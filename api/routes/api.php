<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\VCardController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\StatisticController;
use App\Http\Controllers\api\AuthController;


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

//LOGIN ROUTES
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    Route::post('login', [AuthController::class,'login']);


    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class,'logout']);
    });
});

//VCARDS ROUTES
Route::get('vcards', [VCardController::class, 'index']);
Route::get('vcards/{vcard}', [VCardController::class, 'show']);
Route::post('newvcard', [VCardController::class, 'storeVcard']);
Route::put('vcards/{vcard}', [VCardController::class, 'updateVCard']);
Route::delete('vcards/{vcard}', [VCardController::class, 'destroyVCard']);

//TRANSACTION ROUTES
Route::get('vcards/{vcard}/transactions-send', [TransactionController::class, 'getTransactionsOfVCardSend']);
Route::get('vcards/{pair_vcard}/transactions-receive', [TransactionController::class, 'getTransactionsOfVCardReceive']);
Route::post('newtransaction', [TransactionController::class, 'storeTransaction']);
Route::put('transactions/{transaction}', [TransactionController::class, 'updateTransaction']);
Route::delete('transactions/{transaction}', [TransactionController::class, 'destroyTransaction']);

//CATEGORY ROUTES
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::post('newcategory', [CategoryController::class, 'storeCategory']);
Route::put('categories/{category}', [CategoryController::class, 'updateCategory']);
Route::delete('categories/{category}', [CategoryController::class, 'destroyCategory']);

//STATISTICS ROUTES
Route::get('statistics/{vcard}', [StatisticController::class, 'vcardStats']);
Route::get('transactionsperdate', [StatisticController::class, 'transactionsPerDate']);

Route::get('adminstats', [StatisticController::class, 'adminStats']);
Route::get('adminstatsperdate', [StatisticController::class, 'adminStatsPerDate']);