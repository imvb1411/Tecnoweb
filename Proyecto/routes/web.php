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
    return view('layouts.login');
});
Route::resource('species','SpecieController');
Route::resource('races','RaceController');
Route::resource('units','UnitController');

Route::resource('users','UserController');
Route::post('usersLogin','UserController@login')->name('users.login');

Route::resource('staffs','StaffController');
Route::resource('categories','CategoryController');
Route::resource('products','ProductController');
Route::resource('purchases','PurchaseController');

Route::resource('histories','HistoryController');
Route::post('historiesVaccination','HistoryController@addVaccination')->name('historiesVaccination.addVaccination');
Route::post('historiesConsultation','HistoryController@addConsultation')->name('historiesConsultation.addConsultation');
Route::resource('vaccinations','VaccinationController');

Route::resource('vaccination_report','VaccinationReportController');
Route::resource('product_report','ProductReportController');

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
