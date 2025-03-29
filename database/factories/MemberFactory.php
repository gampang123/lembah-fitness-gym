<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first(); // Ambil user yang sudah ada

        if (!$user) {
            throw new \Exception("Tidak ada user yang tersedia! Pastikan tabel users sudah terisi sebelum seeding.");
        }

        $barcode = "LF" . str_pad($user->id, 5, '0', STR_PAD_LEFT); // Format barcode sesuai user_id

        return [
            'user_id' => $user->id,
            'barcode' => $barcode,
            'barcode_path' => "barcodes/{$barcode}.png", // Gunakan barcode sebagai nama file
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
