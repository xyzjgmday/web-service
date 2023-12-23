<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|min:5',
        ]);

        // Buat komentar baru
        $comment = Comment::create($request->all());

        return response()->json($comment, 201);
    }

    public function getByPost($postId)
    {
        // Ambil komentar berdasarkan post
        $comments = Comment::where('post_id', $postId)->with('user')->get();

        return response()->json($comments, 200);
    }
}


?>