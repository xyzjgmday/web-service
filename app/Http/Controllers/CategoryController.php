<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = new Category;

        $res['success'] = true;
        $res['result'] = $category->all();

        return response($res);
    }

    public function store(Request $request)
    {
        $cat = Category::create($request->all());
        return response()->json($cat, 200);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            abort(404);
        }
        return response()->json($category, 200);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $category = Category::find($id);

        if (!$category) {
            abort(404);
        }

        $category->fill($input);
        $category->save();

        return response()->json($category, 200);
    }
}
