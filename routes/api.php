<?php

use App\Http\Controllers\Api\User\AdditionalServiceController;
use App\Http\Controllers\Api\User\CategoryExcursionController;
use App\Http\Controllers\Api\User\CategoryRealEstateController;
use App\Http\Controllers\Api\User\CityController;
use App\Http\Controllers\Api\User\DeleteAccountController;
use App\Http\Controllers\Api\User\EventController;
use App\Http\Controllers\Api\User\ExcursionController;
use App\Http\Controllers\Api\User\FavoriteController;
use App\Http\Controllers\Api\User\HotelController;
use App\Http\Controllers\Api\User\LoginController;
use App\Http\Controllers\Api\User\LogoutController;
use App\Http\Controllers\Api\User\NotificationController;
use App\Http\Controllers\Api\User\OfferController;
use App\Http\Controllers\Api\User\OrderAdditionalServiceController;
use App\Http\Controllers\Api\User\OrderController;
use App\Http\Controllers\Api\Supplier\OrderController as SupplierOrderController;
use App\Http\Controllers\Api\TourLeader\OrderController as TourLeaderOrderController;
use App\Http\Controllers\Api\User\PasswordController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\RealEstateController;
use App\Http\Controllers\Api\User\RegisterController;
use App\Http\Controllers\Api\User\SubCategoryExcursionController;
use Illuminate\Support\Facades\Route;

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
        //delete account
        Route::delete('/delete_account', [DeleteAccountController::class, 'deleteAccount']);

        Route::post('/order_additional_services', [OrderAdditionalServiceController::class, 'store']);
        //orders
        Route::post('/orders', [OrderController::class, 'store']);

        // user's orders
        Route::get('/my_order', [OrderController::class, 'myOrder']);

        Route::get('/favorite', [FavoriteController::class, 'index']);
        Route::post('/favorite', [FavoriteController::class, 'store']);
    });

    Route::group(['prefix' => 'supplier', 'middleware' => ['auth:sanctum', 'supplier']], function () {
        Route::get('/order', [SupplierOrderController::class, 'index']);
        Route::post('/order/{id}/status', [SupplierOrderController::class, 'updateOrderStatus']);
    });

    Route::group(['prefix' => 'tour_leader', 'middleware' => ['auth:sanctum', 'tour_leader']], function () {
          Route::post('/orders', [TourLeaderOrderController::class, 'store']);
    });
});
Route::get('payment/opay/return', [OrderController::class, 'handleReturn'])->name('payment.opay.return');

// الرابط الذي يرسل إليه OPay تحديثات الحالة (Webhook)
Route::post('payment/opay/callback', [OrderController::class, 'handleCallback'])->name('payment.opay.callback');

Route::post('/stripe/webhook', [OrderController::class, 'handle']);
