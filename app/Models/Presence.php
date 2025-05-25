<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'scan_in_at',
        'scan_out_at',
        'status',
    ];

    protected $dates = [
        'scan_in_at',
        'scan_out_at',
    ];

    public $timestamps = false;

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope for active sessions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for sessions of today
     */
    public function scopeToday($query)
    {
        return $query->whereDate('scan_in_at', now()->toDateString());
    }

    /**
     * Automatically close sessions that forgot to scan out at 10 PM WIB
     */
    public static function autoCloseSessions()
    {
        $now = now()->setTime(22, 0); // 10 PM WIB
        self::active()
            ->today()
            ->update([
                'scan_out_at' => $now,
                'status' => 'completed',
            ]);
    }
}
