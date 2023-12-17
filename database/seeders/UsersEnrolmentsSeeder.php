<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersEnrolmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enrol = array(
            [
                'users_id' => '1',
                'roles_id' => '1',
            ],
        );
        DB::table('users_enrolments')->insert($enrol);
    }
}
