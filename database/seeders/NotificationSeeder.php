<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notification_models')->insert([
           [
               'user_id' => 1,
               'notification_message' => 'Akun anda berhasil didaftarkan',
               'notification_image' => 'account-created.png',
               'created_at' => Carbon::now(),
               'updated_at' => Carbon::now()
           ],
            [
                'user_id' => 1,
                'notification_message' => 'Akun anda berhasil diaktivasi',
                'notification_image' => 'account-activated.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
