<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\WebhooksController;

//home
Route::get('/', function () { return view('home'); })->middleware('guest');

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
Route::delete('/products/destroy/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
Route::post('/products/activate', [ProductsController::class, 'activate'])->name('products.activate');
Route::get('/products/sales', [ProductsController::class, 'sales'])->name('products.sales');
Route::post('/products/sales/search_sell', [ProductsController::class, 'search_sell'])->name('products.search_sell');
Route::get('/products/sales/detail_sell/{invoice}', [ProductsController::class, 'detail_sell'])->name('products.detail_sell');

//client
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::post('/catalog/search', [CatalogController::class, 'search'])->name('catalog.search');
Route::post('/catalog/store', [CatalogController::class, 'store'])->name('catalog.store');
Route::get('/catalog/cart', [CatalogController::class, 'cart'])->name('catalog.cart');
Route::delete('/catalog/destroy/{id}', [CatalogController::class, 'destroy'])->name('catalog.destroy');
Route::post('/catalog/amount', [CatalogController::class, 'amount'])->name('catalog.amount');
Route::get('/catalog/shopping', [CatalogController::class, 'shopping'])->name('catalog.shopping');
Route::post('/catalog/shopping/search_buys', [CatalogController::class, 'search_buys'])->name('catalog.search_buys');
Route::get('/catalog/shopping/detail_buys/{invoice}', [CatalogController::class, 'detail_buys'])->name('catalog.detail_buys');

//payments
Route::get('/payments', [PaymentsController::class, 'index'])->name('payments.index');
Route::get('/payments/paypal', [PaymentsController::class, 'paypal'])->name('payments.paypal');
Route::get('/paypal/paypal_status', [PaymentsController::class, 'paypal_status'])->name('paypal.paypal_status');
Route::get('/payments/mercadopago', [PaymentsController::class, 'mercadopago'])->name('payments.mercadopago');
Route::get('/mercadopago/mp_status', [PaymentsController::class, 'mp_status'])->name('mercadopago.mp_status');