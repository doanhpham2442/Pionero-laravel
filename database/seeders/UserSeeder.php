<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();
        $limit = 30;

        for ($i = 0; $i < $limit; $i++){
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique->email,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'phone' => $faker->numerify($string = '09########'),
                'password' => Hash::make('password'),
                'remember_token' => Hash::make('password'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
