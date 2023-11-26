<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;


class PostsController extends Controller
{
    /**
     * Menampilkan resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::OrderBy("id", "DESC")->paginate(10);

        $outPut = [
            "message" => "posts",
            "result" => $posts
        ];

        return response()->json($posts, 200);
    }

    public function store(Request $request)
    {
        $post = Post::create($request->all());
        return response()->json($post, 200);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        if (!$post) {
            abort(404);
        }
        return response()->json($post, 200);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $post = Post::find($id);

        if (!$post) {
            abort(404);
        }

        $post->fill($input);
        $post->save();

        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if(!$post){
            abort(404);
        }

        $post->delete();
        $message = [
            "message"=> "Deleted Successfully", 'post_id' => $id
        ];

        return response()->json($message, 200);
    }
}