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
use Illuminate\Support\Facades\Route;

Route::get('/','PagesController@dashboard');
Route::get('/dashboard','PagesController@dashboard')->name('page.dashboard');
Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::post('/attendance/stroe','AttendanceController@store')->name('attendance.store');
Route::post('/attendance/create','AttendanceController@create')->name('attendance.create');
Route::resource('user','UserController');
Route::get('/getusers','DatatableController@UserDatatable')->name('datatable.get_users');
Route::get('/getattendances','DatatableController@AttendanceDatatable')->name('datatable.get_attendances');
Route::post('/request/store','RequestsController@store')->name('request.store');