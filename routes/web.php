<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PresenceController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Member\CardMemberController;
use App\Http\Controllers\Member\DashboardMemberController;
use App\Http\Controllers\Member\MembershipController;
use App\Http\Controllers\Member\PresenceMemberController;
use App\Http\Controllers\Member\ProfileMemberController;
use App\Http\Controllers\Member\ReportTransactionMemberController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/storage/{path}', function ($path) {
    return response()->file(storage_path('app/public/' . $path));
})->where('path', '.*');

// routes/web.php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // admin
    })->middleware('role:1');

    Route::get('/member-dashboard', [DashboardMemberController::class, 'index'])
        ->middleware('role:2')
        ->name('member.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// USER DASHBOARD

Route::middleware(['auth', 'role:2'])->group(function () {
    Route::prefix('member')->group(function () {
        Route::prefix('membership')->group(function () {
            Route::get('/', [MembershipController::class, 'index'])->name('membership.index');
            Route::get('/create', [MembershipController::class, 'create'])->name('membership.create');
            Route::post('store', [MembershipController::class, 'store'])->name('membership.store');
            Route::get('list', [MembershipController::class, 'list'])->name('membership.list');
            Route::get('show', [MembershipController::class, 'show'])->name('membership.show');
        });

        Route::resource('presence-member', PresenceMemberController::class);
        Route::resource('report-transaction-member', ReportTransactionMemberController::class);
        Route::resource('card-member', CardMemberController::class);

        Route::prefix('member')->group(function () {
            Route::get('/profile', [ProfileMemberController::class, 'index'])->name('profile-member.index');
            Route::patch('/profile/update', [ProfileMemberController::class, 'updateProfile'])->name('profile-member.update');
            Route::patch('/profile/email', [ProfileMemberController::class, 'updateEmail'])->name('profile-member.updateEmail');
            Route::put('/profile/password', [ProfileMemberController::class, 'updatePassword'])->name('profile-member.updatePassword');
            Route::patch('/profile/phone', [ProfileMemberController::class, 'updatePhone'])->name('profile-member.updatePhone');
        });
    });
});

// END USER DASHBOARD

// ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // ROLE
    Route::get('/user/{id}/role', [RoleController::class, 'showUserRole']);

    // MEMBER
    Route::get('/member', [MemberController::class, 'index'])->name('member.index');
    Route::get('/member/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('/member/store', [MemberController::class, 'store'])->name('member.store');
    Route::get('/member/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::delete('/member/{id}', [MemberController::class, 'destroy'])->name('member.destroy');
    Route::get('/member/{member}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('/member/{member}', [MemberController::class, 'update'])->name('member.update');
    Route::get('/member/card', [MemberController::class, 'card'])->name('member.card')->middleware('auth');


    // MEMBER ACTIVTIY
    Route::get('/activity', [MemberController::class, 'activity'])->name('activity.index');
    Route::get('/activity/{id}', [MemberController::class, 'activityDetail'])->name('activity.detail');

    // PAKET
    Route::get('/paket', [PackageController::class, 'index'])->name('paket.index');
    Route::get('/paket/create', [PackageController::class, 'create'])->name('paket.create');
    Route::get('/paket/edit', [PackageController::class, 'edit'])->name('paket.edit');
    Route::resource('packages', PackageController::class);

    //Transaction
    Route::resource('transaction', TransactionController::class);

    //Presence
    Route::get('presence',  [PresenceController::class, 'index'])->name('presence.index');
    Route::post('presence/manual-store',  [PresenceController::class, 'manualStore'])->name('presence.manual.store');
    Route::post('presence/scan-store',  [PresenceController::class, 'scanStore'])->name('presence.scan.store');
    Route::post('close-session/{id}',  [PresenceController::class, 'closeSession'])->name('presence.close');
});


// DASHBOARD REVIEW
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
// Route::post('midtrans/callback', [TransactionController::class, 'handleCallback']);

require __DIR__ . '/auth.php';
