<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Your API",
 *     version="1.0",
 *     description="Your API description"
 * )
 */
class PostsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/employee",
     *     summary="Summary of the endpoint",
     *     description="Description of the endpoint",
     *     @OA\Response(response="200", description="Successful response")
     * )
     */
    public function index(Request $request)
    {
        $url = 'https://dummy.restapiexample.com/api/v1/employees';
        $headers = ['Accept: application/json'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);
        $data = $response->data;

        return view('employees/index', ['results' => $data]);
    }

    public function show(Request $request, $id)
    {
        $url = 'https://dummy.restapiexample.com/api/v1/employee/' . $id;
        $headers = ['Accept: application/json'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);
        $data = $response->data;

        return view('employees/show', ['result' => $data]);
    }

    public function create()
    {

        return view('employees/create');
    }

    public function change(Request $request, $id)
    {
        $url = 'https://dummy.restapiexample.com/api/v1/employee/' . $id;
        $headers = ['Accept: application/json'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $response = json_decode($result);
        $data = $response->data;

        return view('employees/update', ['result' => $data]);
    }

    public function store(Request $request)
    {
        $url = 'http://localhost:5000/posts';
        $headers = ['Accept: application/json', 'Content-Type: application/json'];
        $data = array(
            "title" => "Ini adalah title",
            "content" => "Ini adalah Content",
            "status" => "draft",
            "categories_id" => 3,
            "user_id" => 1
        );
        $dataJSON = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJSON);

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);

        return view('posts/postRequestJson', ['result' => $response]);
    }
}
