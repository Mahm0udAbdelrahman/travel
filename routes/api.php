<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ExcursionController;
use App\Http\Controllers\Api\RealEstateController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\DeleteAccountController;
use App\Http\Controllers\Api\AdditionalServiceController;
use App\Http\Controllers\Api\CategoryExcursionController;
use App\Http\Controllers\Api\CategoryRealEstateController;
use App\Http\Controllers\Api\SubCategoryExcursionController;
use App\Http\Controllers\Api\OrderAdditionalServiceController;

Route::group(['middleware' => ['lang']], function () {
    // register
    Route::post("/register", [RegisterController::class, 'register']);

    // verify
    Route::post('/verify', [RegisterController::class, 'verify']);
    Route::post('/otp', [RegisterController::class, 'otp']);
    //login
    Route::post("/login", [LoginController::class, 'login']);
    //forget-password
    Route::post('/forget-password', [PasswordController::class, 'forgetPassword']);
    //confirmationOtp
    Route::post('/confirmation-otp', [PasswordController::class, 'confirmationOtp']);
    //reset-password
    Route::post('/reset-password', [PasswordController::class, 'resetPassword']);

    //cities
    Route::get('/cities', [CityController::class, 'index']);

    //category_excursions
    Route::get('/category_excursions', [CategoryExcursionController::class, 'index']);
    //sub_category_excursions
    Route::get('/sub_category_excursions', [SubCategoryExcursionController::class, 'index']);
    //excursions
    Route::get('/excursions', [ExcursionController::class, 'index']);
    //additional_services
    Route::get('/additional_services', [AdditionalServiceController::class, 'index']);

    //events
    Route::get('/events', [EventController::class, 'index']);

    //category_real_estates
    Route::get('/category_real_estates', [CategoryRealEstateController::class, 'index']);
    //real_estates
    Route::get('/real_estates', [RealEstateController::class, 'index']);

    //offers
    Route::get('/offers', [OfferController::class, 'index']);
    //hotels
    Route::get('/hotels', [HotelController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [ProfileController::class, 'profile']);
        Route::post('/profile', [ProfileController::class, 'updateProfile']);
        Route::post('/change-password', [PasswordController::class, 'changePassword']);
        Route::post('/logout', [LogoutController::class, 'logout']);
        Route::get('/notifications', [NotificationController::class, 'index']);

        Route::delete('/delete_account', [DeleteAccountController::class, 'deleteAccount']);

        Route::post('/order_additional_services', [OrderAdditionalServiceController::class, 'store']);
        Route::post('/orders', [OrderController::class, 'store']);
    });

});
Route::get('payment/opay/return', [OrderController::class, 'handleReturn'])->name('payment.opay.return');

// الرابط الذي يرسل إليه OPay تحديثات الحالة (Webhook)
Route::post('payment/opay/callback', [OrderController::class, 'handleCallback'])->name('payment.opay.callback');


Route::post('/stripe/webhook', [OrderController::class, 'handle']);
