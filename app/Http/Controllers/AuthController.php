<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    private $users;

    public function __construct()
    {
        $this->users = [
            'riyan' => 'password',
        ];
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);

        if (!isset($credentials['username'])) {
            return response()->json(['message' => 'Invalid username'], 404);
        }

        if ($this->isValidCredentials($credentials)) {
            $token = "YIo6abISPQq56tJhH6LtD7kIE2ZXacjRvjbLGzbXZHE"; //dibuat sendiri aja
            return response()->json(['message' => 'Login Berhasil', 'token' => 'YIo6abISPQq56tJhH6LtD7kIE2ZXacjRvjbLGzbXZHE']);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    private function isValidCredentials($credentials)
    {
        foreach ($this->users as $username => $password) {
            if ($credentials['username'] === $username && $credentials['password'] === $password) {
                return true;
            }
        }

        return false;
    }
}