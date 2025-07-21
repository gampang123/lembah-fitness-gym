<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Member;
use App\Models\Presence;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS2D;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Menampilkan daftar member.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == 1) {
            $members = Member::with('user')->get();
        } else {
            $members = Member::with('user')->where('user_id', $user->id)->get();
        }

        return view('member.member', compact('members'));
    }


    /**
     * Menampilkan form untuk menambahkan member baru.
     */
    public function create(): View
    {
        $user = Auth::user();

        if ($user->role_id == 1) {
            $users = User::all();
        } else {
            $users = User::where('id', $user->id)->get();
        }

        return view('member.create-member', compact('users'));
    }

    /**
     * Menyimpan member baru ke dalam database.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        if ($user->role_id != 1 && $request->user_id != $user->id) {
            return redirect()->route('member.index')->with('error', 'Anda tidak memiliki izin untuk aktivasi member ini.');
        }

        // Find the member record by user_id and update it
        // Assuming 'user_id' is unique in the 'members' table for active members
        $member = Member::where('user_id', $request->user_id)->first(); 

        if ($member) {
            $member->update([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'active',
            ]);
        } else {
            // If no existing member record, you might want to create one instead
            // This depends on your application's logic.
            Member::create([
                'user_id' => $request->user_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'active',
            ]);
        }

        return redirect()->route('member.index')->with('success', 'Aktivasi Member Berhasil.');
    }


    /**
     * edit member
     */
    public function edit(Member $member)
    {
        $user = Auth::user();

        if ($user->role_id != 1 && $member->user_id != $user->id) {
            return redirect()->route('member.index')->with('error', 'Anda tidak memiliki izin untuk mengedit member ini.');
        }

        if ($user->role_id == 1) {
            $users = User::all();
        } else {
            $users = User::where('id', $user->id)->get();
        }

        return view('member.edit-member', compact('member', 'users'));
    }

    /**
     * Mengupdate  member.
     */
    public function update(Request $request, Member $member)
    {
        $user = Auth::user();

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($user->role_id != 1 && $member->user_id != $user->id) {
            return redirect()->route('member.index')->with('error', 'Anda tidak memiliki izin untuk memperbarui member ini.');
        }

        $member->update([
            'user_id' => $request->user_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active',
        ]);

        return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui.');
    }

    /**
     * Menghapus member.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $member = Member::findOrFail($id);

        if ($user->role_id != 1 && $member->user_id != $user->id) {
            return redirect()->route('member.index')->with('error', 'Anda tidak memiliki izin untuk menghapus member ini.');
        }

        if ($member->barcode_path && Storage::disk('public')->exists($member->barcode_path)) {
            Storage::disk('public')->delete($member->barcode_path);
        }

        $member->delete();

        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus.');
    }

    /**
     * kartu member
     */
    public function card()
    {
        $user = Auth::user();

        if ($user->role_id == 1) {
            $members = Member::with('user')->get();
            return view('member.card-member', compact('members'));
        } else {
            $member = Member::with('user')->where('user_id', $user->id)->first();
            return view('member.card-member', compact('member'));
        }
    }

    /**
     * Menampilkan data aktivitas member.
     */
    public function activity()
    {
        $activites = Presence::with(['member.user'])->where('status', 'completed')->orderByDesc('scan_out_at')->get();
        return view('activity.index', compact('activites'));
    }

    /**
     * Menampilkan detail untuk aktivitas 1 member.
     */
    public function activityDetail($id)
    {
        $member = Member::with('user')->findOrFail($id);
        $activity = $member->presences()->where('status', 'completed')->orderByDesc('scan_out_at')->get();

        return view('activity.detail', compact('member', 'activity'));
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role_id != 1) {
                return redirect()->route('member.index')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
            return $next($request);
        })->only(['edit', 'update', 'destroy']);
    }
}
