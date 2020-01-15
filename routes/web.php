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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reports','ReportController@index')->name('reports');
Route::get('/reports/{page}','ReportController@show')->name('reportPage');

Route::post('getCompanyData','CompanyController@getCompanyData')->name('getCompanyData');

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('catalogs','CatalogController');
Route::resource('companies', 'CompanyController');
Route::resource('addresses', 'AddressController');
Route::resource('goods','GoodController');
Route::resource('sales', 'SaleController');
Route::resource('purchases', 'PurchaseController');
Route::resource('warehouses', 'WarehouseController');
