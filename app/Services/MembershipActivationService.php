<?php

namespace App\Services;

use App\Models\Transaction;
use Carbon\Carbon;

class MembershipActivationService
{
    public function approve(Transaction $transaction)
    {
        $member  = $transaction->member;
        $package = $transaction->package;

        $oldStatus = $member->status;
        $member->update(['status' => 'active']);

        $now        = Carbon::now();
        $currentEnd = $member->end_date ? Carbon::parse($member->end_date) : null;
        $baseStart  = ($currentEnd && $currentEnd->gt($now)) ? $currentEnd : $now;
        $newEnd     = $baseStart->copy()->addDays($package->duration_in_days);

        $data = ['end_date' => $newEnd];
        if (!$member->start_date || $oldStatus === 'expired') {
            $data['start_date'] = $baseStart;
        }

        $member->update($data);
    }
}
