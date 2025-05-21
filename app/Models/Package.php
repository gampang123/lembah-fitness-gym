<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'duration_in_days'];
    protected $casts = [
        'price' => 'integer',
        'duration_in_days' => 'integer',
    ];

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class, 'package_id');
    }
}
