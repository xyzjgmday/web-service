<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Tech', 'World', 'Trending'];
        DB::table('categories')->insert(array_map(function ($category) {
            return ['name' => $category];
        }, $categories));
    }
}
