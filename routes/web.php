<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});

Route::get('candidates', [CandidateController::class, 'index']);
Route::post('candidates-contact', [CandidateController::class, 'contact']);
Route::post('candidates-hire', [CandidateController::class, 'hire']);
Route::get('candidates-list', [CandidateController::class, 'getCandidates']);
Route::get('wallet/{id}', [WalletController::class, 'getWallet']);
