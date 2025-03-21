<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        \App\Models\User::factory(200)->create()->each(function ($user) {
            Member::factory()->create([
                'user_id' => $user->id,
                'barcode' => Str::random(10),
                'barcode_path' => 'barcodes/' . Str::random(10) . '.png',
                'start_date' => now(),
                'end_date' => now()->addYear(),
            ]);
        });
    }
}
