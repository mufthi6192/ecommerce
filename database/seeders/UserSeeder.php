<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = DB::table('users')->insertGetId([
           'username' => 'admin',
           'email' => 'admin@gmail.com',
           'name' => 'Admin Panel',
           'password' => Hash::make('admin'),
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now()
        ]);
        DB::table('user_details')->insert([
            'user_id' => $id,
            'image' => null,
            'level' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
