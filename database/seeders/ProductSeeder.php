<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $description = "Ini adalah contoh gambar produk pada Gallery Rihanna. Semua properti yang ada disini
                        adalah milik Rihanna Gallery atas izin Mufthi Group. Untuk menggunakan aplikasi ini,
                        silahkan ubah semua properti yang ada sesuai dengan petunjuk pada dokumentasi. Anda
                        bebas melakukan perubahan pada aplikasi dan gambar. Segala bentuk penyalahgunaan aplikasi
                        adalah tanggung jawab anda sendiri.";

        DB::table('product_models')->insert([
            [
                'product_name' => 'Example 1',
                'product_image' => 'example.png',
                'product_description' => $description,
                'category_id' => 1,
                'product_price' => 250000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'product_name' => 'Example 2',
                'product_image' => 'example.png',
                'product_description' => $description,
                'category_id' => 2,
                'product_price' => 250000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'product_name' => 'Example 3',
                'product_image' => 'example3.png',
                'product_description' => $description,
                'category_id' => 3,
                'product_price' => 250000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'product_name' => 'Example 4',
                'product_image' => 'example4.png',
                'product_description' => $description,
                'category_id' => 4,
                'product_price' => 250000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ]
        ]);
    }
}
