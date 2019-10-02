<?php

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

Route::get('/dashboard', function () {
    return view('dashboard.home');
});

Route::get('/charts', function () {
    return view('dashboard.charts');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
  Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('home', 'DashboardController@index')->name('home');
  });
  Route::get('login', 'Auth\LoginController@showAdminLoginForm')->name('login.form');
  Route::get('register', 'Auth\RegisterController@showAdminRegisterForm')->name('register.form');
  Route::post('login', 'Auth\LoginController@loginAdmin')->name('login.post');
  Route::post('register', 'Auth\RegisterController@createAdmin')->name('register.post');
});
