<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $membershipCheck = Member::with('user')->where('user_id', $user->id)->first();

        // Ambil member terkait user
        $member = Member::with('user')->where('user_id', $user->id)->where('status', 'active')->first();

        // Ambil presensi harian berdasarkan member_id
        $todayPresence = Presence::whereHas('member', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereDate('scan_in_at', now()->toDateString())
            ->first();

        // Hitung absensi selama bulan ini
        $hadirCount = Presence::whereHas('member', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereMonth('scan_in_at', now()->month)
            ->count();

        $totalDaysThisMonth = now()->daysInMonth;
        $tidakHadirCount = $totalDaysThisMonth - $hadirCount;

        return view('user-dashboard.dashboard', compact(
            'user', 'member', 'todayPresence', 'hadirCount', 'tidakHadirCount', 'membershipCheck'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
