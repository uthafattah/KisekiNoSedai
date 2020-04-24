<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('category/all', 'CategoryController@all');
Route::get('merchandise/all', 'MerchandiseController@all');


Route::resource("cart", "CartController");
Route::resource("category", "CategoryController");
Route::resource("merchandise", "MerchandiseController");
Route::resource("message", "MessageController");
Route::resource("order", "OrderController");
Route::resource("order_merchandise", "OrderMerchandiseController");
Route::resource("payment", "PaymentController");
Route::resource("promo", "PromoController");
Route::resource("review", "ReviewController");
Route::resource("role", "RoleController");
Route::resource("status_order", "StatusOrderController");
Route::resource("status_store", "StatusStoreController");
Route::resource("store", "StoreController");
Route::resource("store_category", "StoreCategoryController");
Route::resource("user", "UserController");
Route::resource("wishlist", "WishlistController");