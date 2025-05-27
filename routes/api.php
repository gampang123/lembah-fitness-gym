<?php

use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\MidtransCallbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/midtrans/signature-test', [TransactionController::class, 'testSignature']);
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handleCallback']);
