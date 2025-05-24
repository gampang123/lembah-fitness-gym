<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Member\PackageMemberController;
use App\Http\Controllers\Member\PresenceMemberController;
use App\Http\Controllers\Member\ProfileMemberController;
use App\Http\Controllers\Member\ReportTransactionMemberController;
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

    Route::get('/member-dashboard', function () {
        return view('user-dashboard.dashboard'); // member
    })->middleware('role:2')->name('member.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// USER DASHBOARD

Route::middleware(['auth', 'role:2'])->group(function () {
    Route::prefix('member')->middleware(['auth'])->group(function () {
        Route::resource('package-member', PackageMemberController::class);
    });
    Route::prefix('member')->middleware(['auth'])->group(function () {
        Route::resource('presence-member', PresenceMemberController::class);
    });
    Route::prefix('member')->middleware(['auth'])->group(function () {
        Route::resource('report-transaction-member', ReportTransactionMemberController::class);
    });
    // test view details transaction
    Route::get('test-detail-transaksi', function () {
        return view('user-dashboard.report-transaction.details-transaction');
    });

    Route::prefix('member')->middleware(['auth'])->group(function () {
        Route::resource('profile-member', ProfileMemberController::class);
    });
    Route::get('/list-package-member', [PackageMemberController::class, 'list'])->name('package-member.list');
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

    // PAKET
    Route::get('/paket', [PackageController::class, 'index'])->name('paket.index');
    Route::get('/paket/create', [PackageController::class, 'create'])->name('paket.create');
    Route::get('/paket/edit', [PackageController::class, 'edit'])->name('paket.edit');
    Route::resource('packages', PackageController::class);

    //Transaction
    Route::resource('transaction', TransactionController::class);
    Route::post('transaction/{id}/approve', [TransactionController::class, 'approve'])->name('transaction.approve');
    Route::post('transaction/{id}/cancel',  [TransactionController::class, 'cancel'])->name('transaction.cancel');
});


// DASHBOARD REVIEW
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/midtrans/callback', [TransactionController::class, 'handleCallback']);

require __DIR__ . '/auth.php';
