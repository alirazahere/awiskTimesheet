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

Route::get('/', 'DashboardController@index');
Route::get('/dashboard', 'DashboardController@index')->name('page.dashboard');
Auth::routes();

// Logout Controller
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

//Attendance Controller
Route::post('/attendance/store', 'AttendanceController@store')->name('attendance.store');
Route::post('/attendance/create', 'AttendanceController@create')->name('attendance.create');

//User Controller
Route::resource('user', 'UserController')->except(['show', 'create']);

//DataTable Controller
Route::get('/getusers', 'DatatableController@UserDatatable')->name('datatable.get_users');
Route::get('/getattendances', 'DatatableController@AttendanceDatatable')->name('datatable.get_attendances');
Route::get('/{user}/getattendances', 'DatatableController@UserAttendanceDatatable')->name('datatable.get_userattendances');

//Request Controller
Route::post('/request/store', 'RequestsController@store')->name('request.store');

//Attendance Ajax
Route::post('/attendanceAjax/fetchAttendance', 'EditAttendanceAjax@fetch_Attendance')->name('atdAjax.fetchAtd');
Route::post('/attendanceAjax/updateAttendance', 'EditAttendanceAjax@Update_Attendance')->name('atdAjax.updateAtd');
Route::post('/attendanceAjax/deleteAttendance', 'EditAttendanceAjax@Delete_Attendance')->name('atdAjax.deleteAtd');
