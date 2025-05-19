<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $activeMember = Member::where('status', 'active')->count();
        $inactiveMember = Member::where('status', 'expired')->count();
        $countMember = Member::count();

        return view('dashboard', compact('activeMember', 'inactiveMember', 'countMember'));
    }
}
