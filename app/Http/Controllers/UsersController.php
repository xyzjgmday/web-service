<?php
namespace App\Http\Controllers;

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

    public function index($id = null)
    {
        return response()->json($this->users);
    }

    public function show($id)
    {
        $user = $this->findUserById($id);

        if ($user) {
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }
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