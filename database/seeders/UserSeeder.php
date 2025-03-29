<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Member;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(200)->create()->each(function ($user) {
            Member::factory()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
