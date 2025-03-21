<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function showUserRole($id) 
    {
        $user = User::with('role')->find($id); // Pastikan eager loading 'role'

        if (!$user || !$user->role) {
            return response()->json(['message' => 'User atau role tidak ditemukan'], 404);
        }

        return response()->json(['role' => $user->role->name]);
    }
}
