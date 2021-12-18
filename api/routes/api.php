<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\VCardController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\DefaultCategoryController;
use App\Http\Controllers\api\StatisticController;


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
Route::get('vcards/{vcard}', [VCardController::class, 'show']);
Route::get('vcards', [VCardController::class, 'index']);
Route::post('login', [AuthController::class, 'login']);
Route::post('adminlogin', [AuthController::class, 'adminLogin']);
Route::post('users/create', [UserController::class, 'storeUser']);
Route::post('newvcard', [VCardController::class, 'storeVCard']);

Route::put('vcards/{vcard}', [VCardController::class, 'updateVCard']);



Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('users/me', [UserController::class, 'show_me']);
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::put('users/{user}', [UserController::class, 'updateUser']);
    Route::put('users/{user}', [UserController::class, 'updateAdmin']);
    Route::patch('vcards/debit/{vcard}', [VCardController::class, 'changeDebit']);
    Route::delete('users/admin/no/{user}', [UserController::class, 'removeAdmin']);

    //VCARDS ROUTES

    Route::get('vcards/{vcard}', [VCardController::class, 'show']);
    Route::get('vcards/me', [VCardController::class, 'show_me']);
    Route::get('vcard/balance', [VCardController::class, 'getBalance']);

    Route::delete('vcards/{vcard}', [VCardController::class, 'destroyVCard']);
    Route::post('vcards/{vcard}/password', [VCardController::class, 'update_password']);
    Route::post('vcards/{vcard}/confirmationcode', [VCardController::class, 'update_confirmationCode']);
    Route::patch('vcards/blocked/yes/{vcard}', [VCardController::class, 'blockVCard']);

    Route::patch('vcards/blocked/no/{vcard}', [VCardController::class, 'unblockVCard']);

    //TRANSACTION ROUTES
    Route::post('newtransaction', [TransactionController::class, 'storeTransaction']);
    Route::get('transactions/{transaction}', [TransactionController::class, 'show']);
    Route::put('transactions/{transaction}', [TransactionController::class, 'updateTransaction']);
    Route::delete('transactions/{transaction}', [TransactionController::class, 'destroyTransaction']);
    Route::post('newsaving', [TransactionController::class, 'storeSaving']);
    Route::post('removesaving', [TransactionController::class, 'removeSaving']);
    Route::get('vcards/{vcard}/transactions-send', [TransactionController::class, 'getTransactionsOfVCard']);

    //CATEGORY ROUTES
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/default', [CategoryController::class, 'getDefaultCategory']);
    Route::post('newcategory', [CategoryController::class, 'storeCategory']);
    Route::put('categories/{category}', [CategoryController::class, 'updateCategory']);
    Route::post('categories/default', [CategoryController::class, 'storeDefaultCategory']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroyCategory']);
    Route::get('mycategories/{vcard}', [CategoryController::class, 'showMyCategory']);
    Route::delete('categories/default/{category}', [CategoryController::class, 'deleteDefaultCategory']);


    //DEFAULT CATEGORY ROUTES
    Route::get('defaultcategories', [DefaultCategoryController::class, 'index']);
    Route::get('defaultcategories/{defaultCategory}', [DefaultCategoryController::class, 'show']);
    Route::put('defaultcategories/{defaultCategory}', [DefaultCategoryController::class, 'updateDefaultCategory']);
    Route::delete('defaultcategories/{defaultCategory}', [DefaultCategoryController::class, 'destroyDefaultCategory']);

    //STATISTICS ROUTES
    Route::get('statistics/{vcard}', [StatisticController::class, 'vcardStats']);
    Route::get('statistics', [StatisticController::class, 'adminStats']);
});
