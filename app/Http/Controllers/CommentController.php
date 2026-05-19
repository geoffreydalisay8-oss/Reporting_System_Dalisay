<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $ticketId)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->ticket_id = $ticketId;
        $comment->user_id = Auth::id();
        $comment->message = $validated['message'];
        $comment->save();

        return back()->with('success', 'Comment added.');
    }
}