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

Route::get('/','PagesController@dashboard');
Route::get('/dashboard','PagesController@dashboard')->name('page.dashboard');
Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
//Route::get('/home', 'HomeController@index')->name('home');
Route::resource('attendance','AttendanceController')->except(['show','index','create']);
Route::post('/attendance/create','AttendanceController@create')->name('attendance.create');
Route::resource('user','UserController');
Route::get('/getusers','UserDatatableController@UserDatatable')->name('getusers');
Route::post('/request/store','RequestsController@store')->name('request.store');