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
}