<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 1,
            'email_confirm' => 1,
            'status' => 1,
        ]);

        // DB::table('site_settings')->insert([
        //     'site_title' => 'Resource',
        //     'site_favicon' => '5JNnoz3tpw.png',
        //     'site_header_logo' => 'dMLnf3rH0p.png',
        //     'site_notification_email' => 'sunny.tzinfotech@gmail.com',
        //     'facebook_link' => 'https://www.facebook.com',
        //     'lnstagram_link' => 'https://www.instagram.com',
        //     'twitter_link' => 'https://www.twitter.com',
        //     'created_at' => date('Y-m-d H:i:s'),
        // ]);
    }
}
