<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\LangController;
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

// Authenticate 
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::controller(ImageController::class)->group(function(){
    Route::get('image', 'index');
    Route::get('image', 'getImg')->name('image');
    Route::post('image', 'store')->name('image.store');

});
Route::post('delete', [ImageController::class, 'delete'])->middleware('auth')->name('delete');
Route::post('update', [ImageController::class, 'update'])->middleware('auth')->name('update');
Route::get('getImgById/{id}', [ImageController::class, 'getImgById'])->name('getImgById');

// Lang
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');

// Cart
Route::get('cart', [CartController::class, 'cartList'])->name('cartList');