<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate ($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $input = $request->all();

        // validation
        $validationRules = [
            'name' => 'required|string',
            'email' => 'required|email\unique:users',
            'password' => 'required|confimed',
        ];

        $validator = Validator::make($input, $validationRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // validation end

        // create user
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $plainPassword = $request->input('password');
        $user->password = app('hash')->make($plainPassword);
        $user->save();

        return response()->json($user, 200);

    }
}