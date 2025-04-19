<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->upsert([
            [
                'id' => 1,
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'member',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ], ['id'], ['name', 'guard_name', 'updated_at']);

        User::create([
            'id' => 1,
            'name' => 'Admin Gampang',
            'username' => 'admin',
            'phone' => '081234567890',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role_id' => 1,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::factory(200)->create([
            'role_id' => 2 
        ])->each(function ($user) {
            Member::factory()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
