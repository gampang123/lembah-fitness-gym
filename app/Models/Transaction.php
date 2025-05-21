<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['created_by', 'member_id', 'proof_of_payment_id', 'package_id', 'payment_method', 'status', 'order_id', 'snap_token'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
