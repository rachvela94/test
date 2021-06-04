<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/stripe', 'StripeController@handleGet');
    Route::get('/transaction', 'TransactionController@index');
    Route::get('/stripe', function(){
        return view("stripe");
    });

    Route::post('/stripe', 'StripeController@handlePost')->name('stripe.payment');
});
