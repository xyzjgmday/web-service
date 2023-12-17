<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::Class);
        $this->call(CategoriesSeeder::Class);
        $this->call(PostsSeeder::Class);
        $this->call(ProfileSeeder::Class);
        $this->call(RolesSeeder::Class);
        $this->call(UsersEnrolmentsSeeder::Class);
    }
}
