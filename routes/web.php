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
    
    return view('frontend.index');
})->name('/');

Route::get('/about', function () {
    return view('frontend.about.index');
})->name('about');


Route::get('/contact', function () {
    
    return view('frontend.contact.index');
})->name('contact.page');


Route::post('/contact', 'Frontend\ContactController@store')->name('contact');
Route::get('/category/{id}', 'Frontend\StoreController@index')->name('store');
Route::get('/products', 'Frontend\ProductController@index')->name('products');
Route::get('/product-detail/{id}', 'Frontend\ProductController@deatil')->name('product.deatil');
Route::post('/subscribe','Frontend\NewsletterController@store')->name('subscribe');



