<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;



class PostsController extends Controller
{
    /**
     * Menampilkan resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::OrderBy("id", "DESC")->paginate(4)-> toArray();
        $response = [
            "total_count" => $posts["total"],
            "limit" => $posts["per_page"],
            "pagination" => [
                "next_page" => $posts["next_page_url"],
                "current_page" => $posts["current_page"],
            ],
            "data" => $posts['data'],
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validationRules = [
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'status' => 'required|in:draft,published',
            // 'user_id' => 'required|exists:users,id'
        ];

        $validator = Validator::make($input, $validationRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post = Post::create($input);
        return response()->json($post, 200);
    }



    public function show(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $post = Post::findOrFail($id);

            if ($acceptHeader === 'application/json') {
                return response()->json($post, 200);
            } elseif ($acceptHeader === 'application/xml') {
                // Format XML untuk respons tunggal
                $postXML = '<post><id>' . $post->id . '</id><title>' . $post->title . '</title></post>';
                return response($postXML, 200)->header('Content-Type', 'application/xml');
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }


    public function update(Request $request, $id)
    {
        $input = $request->all();

        $post = Post::find($id);

        if(!$post) {
            abort(404);
        }

        // validation
        $validationRules = [
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'status' => 'required|in:draft,published',
            // 'user_id' => 'required|exists:users,id'
        ];

        $validator = Validator::make($input, $validationRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // validation end

        $post->fill($input);
        $post->save();

        return response()->json($post, 200);
    }

    

    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $post = Post::findOrFail($id);

            if (!$post) {
                abort(404);
            }

            if ($acceptHeader === 'application/json') {
                $post->delete();
                $message = [
                    "message" => "Deleted Successfully", 'post_id' => $id
                ];

                return response()->json($message, 200);
            } elseif ($acceptHeader === 'application/xml') {
                // Format XML untuk respons penghapusan
                $messageXML = '<message><text>Deleted Successfully</text><post_id>' . $id . '</post_id></message>';
                return response($messageXML, 200)->header('Content-Type', 'application/xml');
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }

}