<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
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
    public function store(Request $request)
    {

        $request->validate([
            'comment' => 'required|string',
            'report_id' => 'required|exists:reports,id'
        ]);

        $comment = Comment::create([
            'report_id' => $request->report_id,
            'user_id' => auth()->user()->id,
            'comment' => $request->comment,
        ]);

        $comments = Comment::where('report_id', $request->report_id)->with('user')->orderBy('created_at', 'DESC')->get();

        return redirect()->route('report.articles.show', ['id' => $request->report_id])->with('commentSuccess', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
