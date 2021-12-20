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

// Blank Page
Route::get('/', 'App\Http\Controllers\MainController@index')->name('start');
Route::get('/menu', 'App\Http\Controllers\MainController@menu')->name('menu');

// Modules Page
Route::get('/modules/sweet-alert', 'App\Http\Controllers\MainController@sweetalert')->name('sweetalert');

// Pages
Route::get('/pages/blank', 'App\Http\Controllers\MainController@home')->name('home');
Route::get('/pages/dashboard', 'App\Http\Controllers\MainController@dashboard')->name('dashboard');
Route::get('/pages/topup', 'App\Http\Controllers\MainController@topup')->name('topup');
Route::get('/pages/jumlah_order', 'App\Http\Controllers\MainController@jumlah_order')->name('jumlah_order');
Route::get('/pages/orderlist', 'App\Http\Controllers\MainController@orderlist')->name('orderlist');
Route::get('/pages/ordermenu', 'App\Http\Controllers\MainController@ordermenu')->name('ordermenu');
Route::get('/pages/history_topup', 'App\Http\Controllers\MainController@history_topup')->name('history_topup');
Route::get('/pages/faq', 'App\Http\Controllers\MainController@faq')->name('faq');
Route::get('/pages/credits', 'App\Http\Controllers\MainController@credits')->name('credits');

// Auth
Route::get('/auth/login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/auth/login', 'App\Http\Controllers\AuthController@authenticate')->name('login.custom');
Route::get('/auth/register', 'App\Http\Controllers\Auth\RegisterController@register')->name('register');
Route::post('/auth/store', 'App\Http\Controllers\Auth\RegisterController@store')->name('register.store');
Route::post('/auth/update_password', 'App\Http\Controllers\AuthController@update_password')->name('update_password');
Route::post('/auth/edit_profile', 'App\Http\Controllers\AuthController@edit_profile')->name('edit_profile');
