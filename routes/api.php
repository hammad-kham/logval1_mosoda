<?php


use App\Http\Controllers\Api\AppApiController as AppApiController;

use App\Http\Controllers\Api\HomeApiController as HomeController;

use App\Http\Controllers\Api\AppPageApiController as AppPageController;

use App\Http\Controllers\Api\AppLabelApiController as AppLabelController;

use App\Http\Controllers\Api\AppSlideApiController as AppSlideController;

use App\Http\Controllers\Api\AppUserApiController as AppUserController;

use App\Http\Controllers\Api\BannerApiController as BannerController;

use App\Http\Controllers\Api\ContactApiController as ContactController;

use App\Http\Controllers\Api\CategoryApiController as CategoryController;

use App\Http\Controllers\Api\SubCategoryApiController as SubCategoryController;

use App\Http\Controllers\Api\ServiceApiController as ServiceController;

use App\Http\Controllers\Api\ProductApiController as ProductController;

use App\Http\Controllers\Api\VendorApiController as VendorController;

use App\Http\Controllers\Api\PaymentMethodApiController as PaymentMethodController;

use App\Http\Controllers\Api\ToDoApiController as ToDoController;

use App\Http\Controllers\Api\NotificationApiController as NotificationController;

use App\Http\Controllers\Api\RewardApiController as RewardController;




use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;





// --------------------------------------------------------------------------//
// ------------------------------- APP APIs ---------------------------------//
// --------------------------------------------------------------------------//




// --------- App ------------- //

Route::post('/app/{action}', [AppApiController::class, 'retMethod']);


// --------- App Label ------------- //

Route::post('/app-labels', [AppLabelController::class, 'retMethod']);


// --------- AppSlide ------------- //

Route::post('/app-slides', [AppSlideController::class, 'retMethod']);


// --------- App Page ------------- //

Route::post('/app-page/{action}', [AppPageController::class, 'retMethod']);


// --------- Banners ------------- //

Route::post('/banners', [BannerController::class, 'retMethod']);


// --------- Contacts ------------- //

Route::post('/contacts', [ContactController::class, 'retMethod']);


// --------- To Dos ------------- //

Route::post('todo/{action}', [ToDoController::class, 'retMethod']);


// --------- Notifications ------------- //

Route::post('notification/{action}', [NotificationController::class, 'retMethod']);





// --------------------------------------------------------------------------//
// ------------------------------- SERVICES ---------------------------------//
// --------------------------------------------------------------------------//





// --------- App User ------------- //

Route::post('user/{action}', [AppUserController::class, 'retMethod']);


// --------- Services Home API ------------- //

Route::post('home/{action}', [HomeController::class, 'retMethod']);



// --------- Services Categories ------------- //

Route::post('/categories/{action}', [CategoryController::class, 'retMethod']);



// --------- Services SubCategories ------------- //

Route::post('/subcategories/{action}', [SubCategoryController::class, 'retMethod']);


// --------- Services of Services ------------- //

Route::post('/services/{action}', [ServiceController::class, 'retMethod']);


// --------- Services Products ------------- //

Route::post('/products/{action}', [ProductController::class, 'retMethod']);


// --------- Vendors ------------- //

Route::post('/vendors/{action}', [VendorController::class, 'retMethod']);


// --------- Payment Methods ------------- //

Route::post('/payment-methods', [PaymentMethodController::class, 'retMethod']);


// --------- Rewards ------------- //

Route::post('/rewards/{action}', [RewardController::class, 'retMethod']);





// --------------------------------------------------------------------------//
// -------------------------------- OTHERS ----------------------------------//
// --------------------------------------------------------------------------//



// --------- Others ------------- //

Route::any('{url?}/{sub_url?}', function(){

	return response()->json([

		'code'    => '404',

		'status'    => false,

		'message'   => 'Invalid Request',

	], 404);

});