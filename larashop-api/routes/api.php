<?php

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('category/all', 'CategoryController@all');
Route::get('merchandise/all', 'MerchandiseController@all');
Route::get('merchandise/top/{count}', 'MerchandiseController@top');
Route::get('merchandise/find/{id}', 'MerchandiseController@find');
//-------------------------------------------------------------------------------------------------
Route::get('merchandise_category/find/{id}', 'MerchandiseCategoryController@find');
Route::get('merchandise/user_merchandise/{id}', 'MerchandiseController@userMerchandise');
//-------------------------------------------------------------------------------------------------
Route::get('merchandise/search/{id}', 'MerchandiseController@search');
//-------------------------------------------------------------------------------------------------
Route::get('store/search/{id}', 'StoreController@search');


Route::group(['middleware'=> ['auth:api']], function() {
	Route::get('cart/user_cart/{id}', 'CartController@userCart');
	Route::get('cart/add_quantity/{id}', 'CartController@addQuantity');
	Route::get('cart/subtract_quantity/{id}', 'CartController@subtractQuantity');
	Route::resource("cart", "CartController");
	//---------------------------------------------------------------------------------------------
	Route::post('category/verify', 'CategoryController@verifyCategory');
	Route::resource("category", "CategoryController");
	//---------------------------------------------------------------------------------------------
	Route::resource("merchandise", "MerchandiseController");
	Route::get('merchandise/store_merchandise/{id}', 'MerchandiseController@storeMerchandise');
	//---------------------------------------------------------------------------------------------
	Route::resource("message", "MessageController");
	Route::get('message/user_to_store/{id}', 'MessageController@userToStore');
	Route::get('message/store_to_user/{id}', 'MessageController@storeToUser');
	Route::get('message/messages/{store_id}/{user_id}', 'MessageController@message');
	//---------------------------------------------------------------------------------------------
	Route::resource("order", "OrderController");
	Route::get('order/store_order/{id}', 'OrderController@storeOrder');
	//---------------------------------------------------------------------------------------------
	Route::resource("order_merchandise", "OrderMerchandiseController");
	//---------------------------------------------------------------------------------------------
	Route::post('payment/verify', 'PaymentController@verifyPayment');
	Route::resource("payment", "PaymentController");
	//---------------------------------------------------------------------------------------------
	Route::post('promo/verify', 'PromoController@verifyPromo');
	Route::resource("promo", "PromoController");
	//---------------------------------------------------------------------------------------------
	Route::resource("review", "ReviewController");
	//---------------------------------------------------------------------------------------------
	Route::post('role/verify', 'RoleController@verifyRole');
	Route::post('roles/delete', 'RoleController@deleteAll');
	Route::resource("role", "RoleController");
	//---------------------------------------------------------------------------------------------
	Route::post('status_order/verify', 'StatusOrderController@verifyStatus');
	Route::resource("status_order", "StatusOrderController");
	//---------------------------------------------------------------------------------------------
	Route::post('status_store/verify', 'StatusStoreController@verifyStatus');
	Route::resource("status_store", "StatusStoreController");
	//---------------------------------------------------------------------------------------------
    Route::post('store/status_store', 'StoreController@changeStatus');
    Route::put('store/status/{id}', 'StoreController@status');
	Route::resource("store", "StoreController");
	//---------------------------------------------------------------------------------------------
	Route::resource("store_category", "StoreCategoryController");
	//---------------------------------------------------------------------------------------------
    Route::post('user/role', 'UserController@changeRole');
    Route::post('user/photo', 'UserController@changePhoto');
	Route::post('users/delete', 'UserController@deleteAll');
	Route::get('user/search/{id}', 'UserController@search');
	Route::get('logged_user', 'UserController@loggedUser')->name('loggedUser');
	Route::resource("user", "UserController");
	//---------------------------------------------------------------------------------------------
	Route::resource("wishlist", "WishlistController");
	Route::get('wishlist/user_wishlist/{id}', 'WishlistController@userWishlist');
});

Route::post('login', 'UserController@login')->name('login');
Route::post('register', 'UserController@register')->name('register');
Route::get('/verify', 'UserController@verify');
Route::post('email/verify', 'UserController@verifyEmail');