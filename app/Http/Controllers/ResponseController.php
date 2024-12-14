<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Response;
use Illuminate\Http\Request;
use App\Models\ResponseProgress;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::all();
        return view('staff.report.response.index', compact('reports'));
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
            'response_status' => 'required',
            'report_id' => 'required|exists:reports,id',
        ]);

        $report = Report::findOrFail($id);

        Response::create([
            'report_id' => $report->id,
            'response_status' => $request->response_status,
            'staff_id' => auth()->user()->id,
        ]);

        return redirect()->route('response.report.show', ['id' => $id])->with('success', 'Tanggapan berhasil dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $report = Report::with('user', 'progress')->findOrFail($id);
        $response = Response::where('report_id', $id)->first();
        $progress = $report->progress;

        return view('staff.report.response.index', compact('report', 'response', 'progress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Response $response)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Response $response)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $report = Report::findOrFail($id);

        // if ($report->response()->exists()) {
        //     return redirect()->back()->with('failed', 'Tidak dapat menghapus pengaduan karena sudah ada tanggapan');
        // };

        // $report->delete();

        // return redirect()->back()->with('success', 'Berhasil menghapus pengaduan!');
    }

    public function completeReport($id) {
        $response = Response::where('report_id', $id)->first();

        $response->response_status = 'DONE';
        $response->save();

        return redirect()->back()->with('success', 'Keluhan telah diselesaikan!');
    }
}
