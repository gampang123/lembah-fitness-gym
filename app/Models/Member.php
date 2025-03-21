<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Milon\Barcode\DNS1D;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'barcode', 'barcode_path', 'start_date', 'end_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method untuk mendapatkan barcode berdasarkan ID Member
    public function getBarcodeAttribute()
    {
        $barcode = new DNS1D();
        return base64_encode($barcode->getBarcodePNG($this->id, 'C39+', 2, 50));
    }
}
