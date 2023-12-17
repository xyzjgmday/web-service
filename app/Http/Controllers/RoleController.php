<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $role = new Role;

        $res['success'] = true;
        $res['result'] = $role->all();

        return response($res);
    }
}
