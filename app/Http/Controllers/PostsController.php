<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    public function index()
    {
        // authorization
        // check if current user is authorized to do this action

        if (Gate::denies('read-post')) {
            return response()->json([
                'succes' => false,
                'status' => 403,
                'message' => 'You are unauthorized',
            ]);
        }

        if (Auth::user()->role ==='admin') {
            // jika admin, akan query semua post record
            $posts = Post::OrderBy("id", "DESC")->paginate(2)->toArray();
        } else {
            $posts = Post::Where(['user_id' => Auth::user()->id])->OrderBy("id", "DESC")->paginate(2)->toArray();
        }
        // Authorization End

        $response = [
            "total_count" => $posts["total"],
            "limit" => $posts["per_page"],
            "pagination" => [
                "next_page" => $posts["next_page_url"],
                "current_page" => $posts["current_page"]
            ],
            "data" => $posts["data"],
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validationRules = [
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'status' => 'required|in:draft, published',
            // 'user_id' => 'required|exists:users,id'
        ];

        $validator = Validator::make($input, $validationRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (Gate::allows('create-post')) {
            // Jika pengguna diizinkan membuat post, lanjutkan
            $input['user_id'] = auth()->id();
            $post = Post::create($input);
            return response()->json($post, 200);
        } else {
            // Jika pengguna tidak diizinkan membuat post
            return response()->json(['message' => 'Permission denied'], 403);
        }

        $post = Post::Where(['user_id' => Auth::user()->id])->create($input);
        return response()->json($post, 200);
    }

    public function show($id)
    {
        $post = Post::Where(['user_id' => Auth::user()->id])->findOrFail($id);

        if (!$post) {
            abort(404);
        }
        return response()->json($post, 200);

        // Mengecek otorisasi menggunakan gate
        if (Gate::allows('read-post-detail', $post)) {
            // Jika pengguna diizinkan membaca detail post, lanjutkan
            return response()->json($post, 200);
        } else {
            // Jika pengguna tidak diizinkan membaca detail post
            return response()->json(['message' => 'Permission denied'], 403);
        }
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $post = Post::Where(['user_id' => Auth::user()->id])->find($id);

        if (!$post) {
            abort(404);
        }

        // authorization
        if (Gate::denies('update-post', $post)) {
            return response()->json([
                'succes' => false,
                'status' => 403,
                'message' => 'You are unauthorized'
            ], 403);
        }

        $validationRules = [
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'status' => 'required|in:draft, published',
            'user_id' => 'required|exists:users,id'
        ];

        $validator = Validator::make($input, $validationRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post->Where(['user_id' => Auth::user()->id])->fill($input);
        $post->save();

        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        $post = Post::Where(['user_id' => Auth::user()->id])->findOrFail($id);
        if (!$post) {
            abort(404);
        }

        $post->delete();
        $message = [
            "message" => "Deleted SUccessfully",
            'post_id' => $id
        ];

        return response()->json($message, 200);

        if (Gate::allows('delete-post', $post)) {
            // Jika pengguna diizinkan menghapus post, lanjutkan
            $post->delete();
            $message = [
                "message" => "Deleted Successfully",
                'post_id' => $id,
            ];
            return response()->json($message, 200);
        } else {
            // Jika pengguna tidak diizinkan menghapus post
            return response()->json(['message' => 'Permission denied'], 403);
        }
    
    }
}