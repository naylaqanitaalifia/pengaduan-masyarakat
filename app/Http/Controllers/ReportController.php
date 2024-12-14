<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Report;
use App\Models\Comment;
use App\Models\Response;
use Illuminate\Http\Request;
use App\Exports\ReportsExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $url = "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $reports = json_decode($content, true);
        $dataReport = Report::query();

        if ($request->has('search')) {
            $dataReport = Report::where('province', $request->search);
        } 
        $dataReport = $dataReport->get();

        return view('guest.report.index', ['reports' => $reports] ,compact('dataReport'));
    }

    public function indexStaff(Request $request) {
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');

        $reports = Report::query()->with('user')->orderBy($sort, $order)->get();
        return view('staff.report.index', compact('reports'));
    }

    public function indexHeadSTaff() {
        $reports = Report::select('province', DB::raw('COUNT(*) as total_reports'))
        ->where('province', 'JAWA BARAT')
        ->groupBy('province')
        ->get();

        $responses = Response::join('reports', 'responses.report_id', '=', 'reports.id')
            ->select('reports.province', DB::raw('COUNT(responses.id) as total_responses'))
            ->groupBy('reports.province')
            ->get();

        // Siapkan data untuk view
        $data = [
            'labels' => $reports->pluck('province')->toArray(),
            'total_reports' => $reports->pluck('total_reports')->toArray(),
            'total_responses' => $responses->pluck('total_responses')->toArray(),
        ];

        return view('headstaff.report.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guest.report.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'province_name' => 'required|string',
            'regency_name' => 'required|string',
            'subdistrict_name' => 'required|string',
            'village_name' => 'required|string',
            'type' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
            'statement' => 'required|boolean',
        ]);

        $imgPath = null;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgPath = time() . '.' . $img->getClientOriginalExtension();

            $img->move(public_path('images'), $imgPath);
        }

        Report::create([
            'user_id' => auth()->user()->id,
            'province' => $validated['province_name'],
            'regency' => $validated['regency_name'],
            'subdistrict' => $validated['subdistrict_name'],
            'village' => $validated['village_name'],
            'type' => $validated['type'],
            'description' => $validated['description'],
            'image' => $imgPath,
            'statement' => $validated['statement'],
        ]);

        return redirect()->route('report.me')->with('success', 'Berhasil membuat pengaduan!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $report = Report::find($id);
        
        $report->increment('viewers');
        
        $comments = Comment::where('report_id', $id)->get();
        
        return view('guest.report.detail', compact('report', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        if ($report->response()->exists()) {
            return redirect()->back()->with('failed', 'Tidak dapat menghapus pengaduan karena sudah ada tanggapan');
        };

        $report->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus pengaduan!');
    }

    public function me() {
        $reports = Report::where('user_id', auth()->user()->id)->get();
        return view('guest.report.me', compact('reports'));
    }

    public function viewers($id) {
        $report = Report::find($id);

        $report->increment('viewers');

        return redirect()->back();
    }

    public function voting($id)
{
    // Ambil report berdasarkan ID
    $report = Report::findOrFail($id);

    // Ambil ID user yang login
    $userId = auth()->id();

    // Ambil data voting dan decode JSON menjadi array (jika kosong, inisialisasi array kosong)
    $voting = $report->voting ? json_decode($report->voting, true) : [];

    // Pastikan $voting adalah array
    if (!is_array($voting)) {
        $voting = [];
    }

    // Cek apakah user sudah vote
    if (array_key_exists($userId, $voting)) {
        // Jika sudah vote → Unvote (hapus user ID dari array)
        unset($voting[$userId]);
    } else {
        // Jika belum vote → Tambahkan user ID dengan timestamp
        $voting[$userId] = Carbon::now()->toDateTimeString();
    }

    // Simpan kembali data voting dalam format JSON
    $report->voting = json_encode($voting);
    $report->save();

    return redirect()->back();
}


    public function exportAll() {
        return Excel::download(new ReportsExport, 'reports.xlsx');  
    }

    public function exportDate(Request $request) {
        $date = $request->input('selected_date');

        if (!$date) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }

        return Excel::download(new ReportsExport($date), 'reports_' . $date . '.xlsx');
    }
}
