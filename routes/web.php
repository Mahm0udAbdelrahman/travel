<?php

use App\Http\Controllers\Dashboard\AdditionalServiceController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CategoryEventController;
use App\Http\Controllers\Dashboard\CategoryExcursionController;
use App\Http\Controllers\Dashboard\CategoryRealEstateController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\EventController;
use App\Http\Controllers\Dashboard\ExcursionController;
use App\Http\Controllers\Dashboard\FileController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\HotelController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\OfferController;
use App\Http\Controllers\Dashboard\OrderAdditionalServiceController;
use App\Http\Controllers\Dashboard\RealEstateController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SendNotificationController;
use App\Http\Controllers\Dashboard\SubCategoryExcursionController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix'     => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ], function () {

        Route::get('/admin/login', [AuthController::class, 'login'])->name('login');
        Route::post('/admin/login', [AuthController::class, 'loginAction'])->name('loginAction');

        Route::group(['middleware' => ['auth', 'notification', 'is_role'], 'prefix' => 'admin', 'as' => 'Admin.'], function () {
            // home
            Route::get('/home', [HomeController::class, 'index'])->name('home');
            Route::get('/delete/{model}/{id}', [HomeController::class, 'confirmDelete'])->name('confirmDelete');

            // roles
            Route::resource('roles', RoleController::class);

            // admins
            Route::resource('admins', AdminController::class);
            Route::post('/admins/bulk-delete', [AdminController::class, 'bulkDelete'])
                ->name('admins.bulkDelete');

            // users
            Route::resource('users', UserController::class);
            Route::post('/users/bulk-delete', [UserController::class, 'bulkDelete'])
                ->name('users.bulkDelete');

            Route::get('/profile', [UserController::class, 'profile'])->name('profile');
            Route::put('/profile', [UserController::class, 'updateProfile'])->name('updateProfile');

            // notifications
            Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications');
            Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
            Route::get('/notifications/read-all', [NotificationController::class, 'ReadAll'])->name('notifications.markAllRead');
            Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

            // send_notifications
            Route::get('send_notifications', [SendNotificationController::class, 'index'])->name('send_notifications.index');
            Route::get('send_notifications/create', [SendNotificationController::class, 'create'])->name('send_notifications.create');
            Route::post('send_notifications', [SendNotificationController::class, 'store'])->name('send_notifications.store');
            Route::delete('send_notifications/{id}', [SendNotificationController::class, 'destroy'])->name('send_notifications.destroy');
            // logout
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');

            //cities
            Route::resource('cities', CityController::class);
            Route::post('/cities/bulk-delete', [CityController::class, 'bulkDelete'])
                ->name('cities.bulkDelete');

            //category_excursions
            Route::resource('category_excursions', CategoryExcursionController::class);
            Route::post('/category_excursions/bulk-delete', [CategoryExcursionController::class, 'bulkDelete'])
                ->name('category_excursions.bulkDelete');

            //sub_category_excursions
            Route::resource('sub_category_excursions', SubCategoryExcursionController::class);
            Route::post('/sub_category_excursions/bulk-delete', [SubCategoryExcursionController::class, 'bulkDelete'])
                ->name('sub_category_excursions.bulkDelete');

            //excursions
            Route::resource('excursions', ExcursionController::class);
            Route::post('/excursions/bulk-delete', [ExcursionController::class, 'bulkDelete'])
                ->name('excursions.bulkDelete');

            Route::get('/get-sub-categories/{category}', [ExcursionController::class, 'getSubCategories'])->name('get.sub.categories');;

            //additional_services
            Route::resource('additional_services', AdditionalServiceController::class);
            Route::post('/additional_services/bulk-delete', [AdditionalServiceController::class, 'bulkDelete'])
                ->name('additional_services.bulkDelete');

            //order_additional_services
            Route::resource('order_additional_services', OrderAdditionalServiceController::class);
            Route::post('/order_additional_services/bulk-delete', [OrderAdditionalServiceController::class, 'bulkDelete'])
                ->name('order_additional_services.bulkDelete');

            Route::resource('category_events', CategoryEventController::class);
            Route::post('/category_events/bulk-delete', [CategoryEventController::class, 'bulkDelete'])
                ->name('category_events.bulkDelete');

            Route::resource('events', EventController::class);
            Route::post('/events/bulk-delete', [EventController::class, 'bulkDelete'])
                ->name('events.bulkDelete');

            Route::resource('category_real_estates', CategoryRealEstateController::class);
            Route::post('/category_real_estates/bulk-delete', [CategoryRealEstateController::class, 'bulkDelete'])
                ->name('category_real_estates.bulkDelete');

            Route::resource('real_estates', RealEstateController::class);
            Route::post('/real_estates/bulk-delete', [RealEstateController::class, 'bulkDelete'])
                ->name('real_estates.bulkDelete');

            Route::resource('offers', OfferController::class);
            Route::post('/offers/bulk-delete', [OfferController::class, 'bulkDelete'])
                ->name('offers.bulkDelete');

            Route::resource('files', FileController::class);
            Route::post('/files/bulk-delete', [FileController::class, 'bulkDelete'])
                ->name('files.bulkDelete');

            Route::resource('hotels', HotelController::class);
            Route::post('/hotels/bulk-delete', [HotelController::class, 'bulkDelete'])
                ->name('hotels.bulkDelete');

        });
    });
// Route::get('/notifications/count', function () {
//     return response()->json([
//         'unread_count' => auth()->user()->unreadNotifications()->count(),
//     ]);
// })->name('notifications.count');
    Route::get('/payment/success', function () {
        $sessionId = request('session_id');
        return view('payment.success', compact('sessionId'));
    })->name('payment.success');

    Route::get('/payment/cancel', function () {
        return view('payment.cancel');
    })->name('payment.cancel');
