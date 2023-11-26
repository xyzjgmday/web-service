<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class PostsController extends Controller
{
    /**
     * Menampilkan resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $posts = Post::OrderBy("id", "DESC")->paginate(10);

            if ($acceptHeader === 'application/json') {
                return response()->json($posts->items('data'), 200);
            } else {
                $xml = new \SimpleXMLElement('<posts/>');
                foreach ($posts->items('data') as $item) {
                    $xmlItem = $xml->addChild('post');

                    $xmlItem->addChild('id', $item->id);
                    $xmlItem->addChild('title', $item->title);
                    $xmlItem->addChild('status', $item->status);
                    $xmlItem->addChild('content', $item->content);
                    $xmlItem->addChild('user_id', $item->user_id);
                    $xmlItem->addChild('created_at', $item->created_at);
                    $xmlItem->addChild('updated_at', $item->updated_at);
                }
                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function store(Request $request)
{
    $acceptHeader = $request->header('Accept');

    if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

        $contentTypeHeader = $request->header('Content-Type');

        if ($contentTypeHeader === 'application/json') {
            // Manual validation
            $validator = app('validator')->make($request->all(), [
                'title' => 'required',
                // tambahkan validasi untuk kolom-kolom lainnya
            ]);

            if ($validator->fails()) {
                // Jika validasi gagal, kirim respon error
                return response()->json(['error' => $validator->errors()], 422);
            }

            // Jika validasi berhasil, lanjutkan dengan membuat post
            $input = $request->all();
            $post = Post::create($input);

            return response()->json($post, 200);
        } else {
            return response('Unsupported Media Type', 415);
        }
    } else {
        return response('Not Acceptable!', 406);
    }
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