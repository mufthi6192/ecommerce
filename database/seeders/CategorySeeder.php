<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_models')->insert([
           [
               'category_name' => 'Blouse Atasan',
               'category_image' => '1.png',
               'created_at' => Carbon::now(),
               'updated_at' => Carbon::now()
           ],
            [
                'category_name' => 'Setelan',
                'category_image' => '4.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'category_name' => 'Tunik',
                'category_image' => '3.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'category_name' => 'Gamis',
                'category_image' => '2.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
