<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Obter as transações todas que um VCard mandou dinheiro
Route::get('vcards/{vcard}/transactions-send', [TransactionController::class, 'getTransactionsOfVCardSend']);

Route::get('vcards/{pair_vcard}/transactions-receive', [TransactionController::class, 'getTransactionsOfVCardReceive']);

Route::post('transactions', [TransactionController::class, 'store']);