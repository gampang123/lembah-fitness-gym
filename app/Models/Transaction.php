<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'proof_of_payment_id', 'package_id'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function proofOfPayment()
    {
        return $this->belongsTo(ProofOfPayment::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
