<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;

class UsersController extends Controller
{
    private $users;

    public function __construct()
    {
        $this->users = [
            ['id' => 1, 'name' => 'Sumatrana', 'email' => 'sumatrana@gmail.com', 'address' => 'Padang', 'gender' => 'Laki-laki'],
            ['id' => 2, 'name' => 'Jawarianto', 'email' => 'jawarianto@gmail.com', 'address' => 'Cimahi', 'gender' => 'Laki-laki'],
            ['id' => 3, 'name' => 'Kalimantanio', 'email' => 'kalimantanio@gmail.com', 'address' => 'Samarinda', 'gender' => 'Laki-laki'],
            ['id' => 4, 'name' => 'Sulawesiani', 'email' => 'sulawesiani@gmail.com', 'address' => 'Makasar', 'gender' => 'Perempuan'],
            ['id' => 5, 'name' => 'Papuani', 'email' => 'papuani@gmail.com', 'address' => 'Jayapura', 'gender' => 'Perempuan'],
        ];
    }

    public function index()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No users found'], 404);
        }

        return response()->json(['users' => $users], 200);
    }

    public function show($id)
    {
        $profile = Profile::with('user')->where('user_id', $id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $user = $profile->user;

        $responseData = [
            'user' => $user ? $user->toArray() : null,
            'profile' => $profile->toArray(),
        ];

        return response()->json($responseData, 200);
    }

    private function findUserById($id)
    {
        foreach ($this->users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }

        return null;
    }
}