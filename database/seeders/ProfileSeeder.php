<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profile =  [
            'name' => 'nurhidayat',
            'no_telp' => '0893643558376',
            'alamat' => 'dimana hayo',
            'tempat_lahir' => 'clcp',
            'tgl_lahir' => '0',
            'bio' => 'Apapun yang kita mau ya ada',
            'pp' => NULL,
            'users_id' => 1,
            // password
        ];
        DB::table('profile')->insert($profile);
    }
}
