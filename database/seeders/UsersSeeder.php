<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //user admin seeder
        DB::table('users')->insert([
            'uuid' => Str::uuid(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'is_admin' => 1,
            'email' => 'admin@buckhill.co.uk',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'is_marketing' => 0,
            'created_at' =>  now(),
            'updated_at' =>  now(),
        ]);
        // user factories for non admin users
        User::factory()->count(10)->create();
    }
}
