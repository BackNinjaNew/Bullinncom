<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CatalogController;

Route::get('/', function () {
    return view('home');
})->middleware('guest');

//auth
Route::get('/register', [RegisterController::class, 'create'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [SessionsController::class, 'create'])->name('login.index');
Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
Route::get('/logout', [SessionsController::class, 'destroy'])->name('login.destroy');

//admin
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::post('/products/search', [ProductsController::class, 'search'])->name('products.search');
Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
Route::post('/products/store', [ProductsController::class, 'store'])->name('products.store');
Route::get('/products/edit/{id}', [ProductsController::class, 'edit'])->name('products.edit');
Route::put('/products/update/{id}', [ProductsController::class, 'update'])->name('products.update');
Route::get('/products/show/{id}', [ProductsController::class, 'show'])->name('products.show');
Route::delete('/products/destroy/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');

//client
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::post('/catalog/search', [CatalogController::class, 'search'])->name('catalog.search');
Route::post('/catalog/store', [CatalogController::class, 'store'])->name('catalog.store');
Route::get('/catalog/cart', [CatalogController::class, 'cart'])->name('catalog.cart');
Route::delete('/catalog/destroy/{id}', [CatalogController::class, 'destroy'])->name('catalog.destroy');
Route::post('/catalog/amount', [CatalogController::class, 'amount'])->name('catalog.amount');