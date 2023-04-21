<?php

use Illuminate\Support\Facades\Auth;
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
/*Route::get('/additem', function(){
    return view('additem');
})->name('additem');
*/



Auth::routes();

Route::get('/add-item', [App\Http\Controllers\ItemController::class, 'addItem'])->name('add_item');
Route::post('/create-item', [App\Http\Controllers\ItemController::class, 'create'])->name('create_item');

Route::get('/',  [App\Http\Controllers\ItemController::class, 'index'])->name('home');
Route::get('/add-to-cart/{id}', [App\Http\Controllers\CartController::class, 'add_to_cart'])->name('add_to_cart');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'cart'])->name('cart');
Route::patch('update-cart', [App\Http\Controllers\CartController::class, 'update'])->name('update_cart');
Route::delete('remove-from-cart', [App\Http\Controllers\CartController::class, 'remove'])->name('remove_from_cart');


