<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;

class ProfilesController extends Controller
{
    public function show($userId)
    {
        $profile = Profile::where('user_id', $userId)->with('user')->first();
        if (!$profile) {
            abort(404);
        }
        return response()->json($profile, 200);
    }

    public function image($imageName)
    {
        $imagePath = storage_path('uploads/image_profile') . '/' . $imageName;
        if (file_exists($imagePath)) {
            $file = file_get_contents($imagePath);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
        }

        return response()->json(array("message" => "Image not Found", "path" => $imagePath), 401);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|min:5',
            'no_telp' => 'required|min:10',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'bio' => 'required',
            'pp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Menambahkan aturan validasi untuk file gambar
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $profileData = [
            'name' => $request->input('name'),
            'no_telp' => $request->input('no_telp'),
            'alamat' => $request->input('alamat'),
            'tempat_lahir' => $request->input('tempat_lahir'),
            'tgl_lahir' => $request->input('tgl_lahir'),
            'bio' => $request->input('bio'),
            'user_id' => Auth::user()->id,
        ];

        if ($request->hasFile('pp')) {
            $image = $request->file('pp');
            $imageName = Auth::user()->id . '_' . uniqid();
            $imagePath = 'uploads/image_profile/';

            // Pindahkan gambar ke direktori public
            $image->move(storage_path($imagePath), $imageName);

            // Hapus gambar lama jika ada
            $profile = Profile::where('user_id', $profileData['user_id'])->first();
            $current_image_path = storage_path($imagePath . $profile->pp);
            if (file_exists($current_image_path)) {
                unlink($current_image_path);
            }

            $profileData['pp'] = $imageName;
        }


        // Pastikan user dengan ID yang diberikan ada
        if (!User::find($profileData['user_id'])) {
            return response()->json(['error' => 'User not found'], 404);
        }

        Profile::updateOrCreate(['user_id' => $profileData['user_id']], $profileData);

        return response()->json(['success' => true, 'message' => 'Profile updated successfully'], 200);
    }
}
