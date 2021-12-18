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

Route::post('login', [AuthController::class, 'login']);
Route::post('adminlogin',[AuthController::class,'adminLogin']);

Route::post('newvcard', [VCardController::class, 'storeVCard']);


Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('users/me', [UserController::class, 'show_me']);
    Route::get('users', [UserController::class, 'index']);
    Route::post('users/create', [UserController::class, 'store']);

    //VCARDS ROUTES
    Route::get('vcards', [VCardController::class, 'index']);
    Route::get('vcards/{vcard}', [VCardController::class, 'show']);
    Route::get('vcards/me', [VCardController::class, 'show_me']);
    Route::get('vcard/balance', [VCardController::class, 'getBalance']);
    Route::put('vcards/{vcard}', [VCardController::class, 'updateVCard']);
    Route::delete('vcards/{vcard}', [VCardController::class, 'destroyVCard']);
    Route::patch('vcards/{vcard}/password', [vCardController::class, 'update_password']);
    Route::patch('vcards/{vcard}/confirmationcode', [vCardController::class, 'update_confirmationCode'])
        ->middleware('can:updateConfirmationCode,vcard');

    //TRANSACTION ROUTES
    Route::post('newtransaction', [TransactionController::class, 'storeTransaction']);
    Route::get('transactions/{transaction}', [TransactionController::class, 'show']);
    Route::put('transactions/{transaction}', [TransactionController::class, 'updateTransaction']);
    Route::delete('transactions/{transaction}', [TransactionController::class, 'destroyTransaction']);
    Route::post('transactions', [TransactionController::class, 'store']);
    Route::post('newsaving', [TransactionController::class, 'storeSaving']);
    Route::post('removesaving', [TransactionController::class, 'removeSaving']);
    Route::get('vcards/{vcard}/transactions-send', [TransactionController::class, 'getTransactionsOfVCard']);

    //CATEGORY ROUTES
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('newcategory', [CategoryController::class, 'storeCategory']);
    Route::put('categories/{category}', [CategoryController::class, 'updateCategory']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroyCategory']);
    Route::get('mycategories/{vcard}', [CategoryController::class, 'showMyCategories']);

    //DEFAULT CATEGORY ROUTES
    Route::get('defaultcategories', [DefaultCategoryController::class, 'index']);
    Route::get('defaultcategories/{defaultCategory}', [DefaultCategoryController::class, 'show']);
    Route::put('defaultcategories/{defaultCategory}', [DefaultCategoryController::class, 'updateDefaultCategory']);
    Route::delete('defaultcategories/{defaultCategory}', [DefaultCategoryController::class, 'destroyDefaultCategory']);

    //STATISTICS ROUTES
});

Route::get('statistics/{vcard}', [StatisticController::class, 'vcardStats']);
Route::get('statistics', [StatisticController::class, 'adminStats']);