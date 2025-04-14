<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\Facades\DNS2DFacade;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        // Nilai default jika tidak di-set dari seeder
        $userId = $this->faker->numberBetween(1, 200); // fallback jika seeder tidak inject user_id
        $barcode = "LF" . str_pad($userId, 5, '0', STR_PAD_LEFT);
        $filename = "{$barcode}.png";
        $barcodePath = "barcodes/{$filename}";

        $startDate = now();
        $endDate = now()->addYear();

        $barcodeImage = DNS2DFacade::getBarcodePNG($barcode, "QRCODE");
        if ($barcodeImage) {
            Storage::disk('public')->put($barcodePath, base64_decode($barcodeImage));
        }

        return [
            'user_id' => $userId,
            'barcode' => $barcode,
            'barcode_path' => $barcodePath,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
