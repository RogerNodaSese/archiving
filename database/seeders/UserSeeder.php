<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                "last_name" => "Ofelia",
                "first_name" => "Galang",
                "email" => "library@neu.edu.ph",
                "email_verified_at" => \Carbon\Carbon::now(),
                "password" => \Illuminate\Support\Facades\Hash::make("secret"),
                "role_id" => 1
            ],
        ]);
    }
}
