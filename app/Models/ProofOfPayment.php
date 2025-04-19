<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProofOfPayment extends Model
{
    use HasFactory;

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class, 'proof_of_payment_id');
    }
}
