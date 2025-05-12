<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\auth\LogoutController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Brand\BrandController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ShopController;
use App\Http\Controllers\Product\SizeController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\Client\DetailController;
use App\Http\Controllers\Product\ColorController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\DiscountController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Product\ImageProductController;

Route::get('/', function () {
    return view('client.home');
})->name('home');
Route::get('/about', function () {
    return view('client.about');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'auth.client'], function () {
        // Route::get('/client', function () {
        //     return view('client.home');
        // })->name('home');
    });

    Route::group(['middleware' => 'auth.admin'], function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('indexAdmin');

        Route::get('/showCreateUser', [UserController::class, 'showCreateUser']);
        Route::post('/createUser', [UserController::class, 'createUser'])->name('createUser');
        Route::get('/showEditUser/{id}', [UserController::class, 'showEditUser']);
        Route::post('/editUser/{id}', [UserController::class, 'editUser'])->name('updateUser');

        Route::resource('products', ProductController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('categorys', CategoryController::class);
        Route::resource('colors', ColorController::class);
        Route::resource('discounts', DiscountController::class);

        Route::delete('deleteImage/{id}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');

        Route::get('addSize', [SizeController::class, 'index'])->name('product.size');
        Route::post('addSize', [SizeController::class, 'store'])->name('product.addSize');
        Route::put('updateSize/{id}', [SizeController::class, 'update'])->name('product.updateSize');
        Route::delete('deleteSize/{id}', [SizeController::class, 'delete'])->name('product.deleteSize');
    });

    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});


Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('actionLogin');
Route::get('/register', [RegisterController::class, 'registerForm'])->name('registerForm');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('login/google', [SocialController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [SocialController::class, 'handleGoogleCallback']);

Route::get('/shop', [ShopController::class, 'index'])->name('shop');

Route::get('/test', [ImageProductController::class, 'index'])->name('product.images.index');
Route::get('/image/{product}/edit', [ImageProductController::class, 'edit'])->name('productImage.edit');
Route::get('/product-variants/{variant}/images/create', [ImageProductController::class, 'create'])->name('product.images.create');
Route::post('/product-variants/{variantId}/images', [ImageProductController::class, 'store'])->name('product.images.store');

Route::get('/detail/{id}', [DetailController::class, 'showProductDetail'])->name('product.detail');
Route::get('/get-sizes/{colorId}', [DetailController::class, 'getSizesByColor']);

Route::get('/cart/cartItemQuantity', [CartController::class, 'showCartItemQuantity'])->name('cart.cartItemQuantity');
Route::get('cart/detail', [CartController::class, 'showCartDetail'])->name('cart.detail');
Route::post('/cart/add/{product_id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('cart/remove/{id}', [CartController::class, 'removeCartItem'])->name('cart.removeCartItem');
Route::post('/cart/update-quantity/{id}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');


