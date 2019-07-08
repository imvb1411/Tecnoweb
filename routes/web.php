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
    return view('layouts.master');
});
Route::resource('species','SpecieController');
Route::resource('races','RaceController');
Route::resource('units','UnitController');

Route::resource('users','UserController');
Route::resource('staffs','StaffController');
Route::resource('categories','CategoryController');
Route::resource('products','ProductController');

Route::resource('histories','HistoryController');
Route::resource('vaccinations','VaccinationController');

Route::resource('vaccination_report','VaccinationReportController');
Route::resource('product_report','ProductReportController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
