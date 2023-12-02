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
                    // Jika validasi gagal, kirim respon error JSON
                    return response()->json(['error' => $validator->errors()], 422);
                }
                $input = $request->all();
                $post = Post::create($input);

                return response()->json($post, 200);
            } elseif ($contentTypeHeader === 'application/xml') {
                $validator = app('validator')->make($request->all(), [
                    'title' => 'required',
                    
                ]);

                if ($validator->fails()) {
                    // Jika validasi gagal, kirim respon error XML
                    // Format XML untuk kesalahan validasi
                    $errorXML = '<error>' . $validator->errors()->first() . '</error>';
                    return response($errorXML, 422)
                        ->header('Content-Type', 'application/xml');
                }

                // Jika validasi berhasil, lanjutkan dengan membuat post
                $input = $request->all();
                $post = Post::create($input);

                // Misalnya, format XML untuk respons berhasil
                $successXML = '<success><message>Post created successfully</message></success>';
                return response($successXML, 200)
                    ->header('Content-Type', 'application/xml');
            } else {
                return response('Unsupported Media Type', 415);
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }


    public function show(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $post = Post::findOrFail($id);

            if (!$post) {
                abort(404);
            }

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
        $acceptHeader = $request->header('Accept');
        $contentTypeHeader = $request->header('Content-Type');

        if (($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') &&
            ($contentTypeHeader === 'application/json' || $contentTypeHeader === 'application/xml')) {

            $input = $request->all();

            $post = Post::find($id);

            if (!$post) {
                abort(404);
            }

            if ($contentTypeHeader === 'application/json') {
                $post->fill($input);
                $post->save();

                if ($acceptHeader === 'application/json') {
                    return response()->json($post, 200);
                } elseif ($acceptHeader === 'application/xml') {
                    // Format XML untuk respons tunggal
                    $postXML = '<post><id>' . $post->id . '</id><title>' . $post->title . '</title></post>';
                    return response($postXML, 200)->header('Content-Type', 'application/xml');
                }
            } elseif ($contentTypeHeader === 'application/xml') {
                if ($acceptHeader === 'application/json') {
                    return response()->json($post, 200);
                } elseif ($acceptHeader === 'application/xml') {
                    // Format XML untuk respons tunggal
                    $postXML = '<post><id>' . $post->id . '</id><title>' . $post->title . '</title></post>';
                    return response($postXML, 200)->header('Content-Type', 'application/xml');
                }
            }
        } else {
            return response('Not Acceptable or Unsupported Media Type!', 406);
        }
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