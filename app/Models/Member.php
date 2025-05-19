<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Milon\Barcode\DNS1D;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'barcode', 'barcode_path', 'start_date', 'end_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class, 'member_id');
    }

    // Method untuk mendapatkan barcode berdasarkan ID Member
    public function getBarcodeAttribute()
    {
        $barcode = new DNS1D();
        return base64_encode($barcode->getBarcodePNG($this->id, 'C39+', 2, 50));
    }

    public function scopeActive($query)
    {
        return $query->where('end_date', '>', now());
    }

    public function scopeInactive($query)
    {
        return $query->where('end_date', '<=', now());
    }

}
