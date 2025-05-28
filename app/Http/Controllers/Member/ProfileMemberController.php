<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileMemberController extends Controller
{
    public function index(Request $request)
    {
        return view('user-dashboard.profile.index', [
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->save();

        return Redirect::back()->with('status', 'profile-updated');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $user = $request->user();
        if ($user->email !== $request->email) {
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->save();
        }

        return Redirect::back()->with('status', 'email-updated');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return Redirect::back()->with('status', 'password-updated');
    }

    public function updatePhone(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $user = $request->user();
        $user->phone = $request->phone;
        $user->save();

        return Redirect::back()->with('status', 'phone-updated');
    }
}
