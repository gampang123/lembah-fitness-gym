<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil member terkait user yang sedang login
        $member = Member::with('user')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        // Jika tidak ada member, kembalikan view kosong atau error
        if (!$member) {
            return view('user-dashboard.presence.index', [
                'presences' => collect(),
                'members' => collect()
            ]);
        }

        // Ambil presences berdasarkan member_id dari user login
        $presences = Presence::with(['member.user'])
            ->where('member_id', $member->id)
            ->get();

        return view('user-dashboard.presence.index', [
            'presences' => $presences,
            'members' => collect([$member]) // hanya member yang sedang login
        ]);
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
