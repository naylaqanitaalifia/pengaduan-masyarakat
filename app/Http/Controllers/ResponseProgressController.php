<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Response;
use Illuminate\Http\Request;
use App\Models\ResponseProgress;

class ResponseProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request, $id)
    {
        $request->validate([
            'histories' => 'required|string',
        ]);

        $response = Response::where('report_id', $id)->firstOrFail();

        $progress = ResponseProgress::firstOrCreate(
            ['response_id' => $response->id],
            ['histories' => json_encode([])]
        );

        $histories = json_decode($progress->histories);
        $histories[] = [
            'timestamp' => now()->locale('id')->translatedFormat('d F Y'),
            'note' => $request->input('histories'),
        ];

        $progress->update(['histories' => json_encode($histories)]);

        return redirect()->back();
        
    }


    /**
     * Display the specified resource.
     */
    public function show(ResponseProgress $responseProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResponseProgress $responseProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResponseProgress $responseProgress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($reportId, $progressId)
    // {
    //     $report = Report::findOrFail($reportId);

    //     $progress = $report->progress()->findOrFail($progressId);

    //     $progress->delete();

    //     return redirect()->back()->with('success', 'Progress berhasil dihapus!');
    // }

    public function destroy($id, Request $request)
{
    // Cari report berdasarkan ID yang diberikan
    $report = Report::findOrFail($id);

    // Ambil progressId yang dikirimkan melalui form
    $progressId = $request->input('progressId');

    // Cari progress berdasarkan ID yang diberikan dan pastikan terkait dengan report
    $progress = $report->progress()->findOrFail($progressId);

    // Hapus progress
    $progress->delete();

    // Redirect kembali dengan pesan sukses
    return redirect()->back()->with('success', 'Progress has been deleted successfully.');
}

}
