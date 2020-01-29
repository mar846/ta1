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
    return view('home');
})->middleware('auth');
Route::get('goodReceipt','GoodController@goodReceiptPage');
Route::get('goodDeliver','GoodController@goodDeliverPage');

Route::get('/reports','ReportController@index')->name('reports');
Route::get('/reports/{page}','ReportController@show')->name('reportPage');

Route::post('goodDeliverSearch','GoodController@goodDeliverSearch');
Route::post('goodReceiptSearch','GoodController@goodReceiptSearch');
Route::post('goodDeliverFinish','GoodController@goodDeliverFinish');
Route::post('goodReceiptFinish','GoodController@goodReceiptFinish');
Route::post('getCompanyData','CompanyController@getCompanyData')->name('getCompanyData');

Route::get('/home', 'HomeController@index')->name('home');
// Route::resource('bills','BillOfMaterialController');
Route::resource('catalogs','CatalogController')->middleware('auth');
Route::resource('checklists','ChecklistController')->middleware('auth');
Route::resource('companies', 'CompanyController')->middleware('auth');
Route::resource('addresses', 'AddressController')->middleware('auth');
Route::resource('goods','GoodController')->middleware('auth');
Route::resource('sales', 'SaleController')->middleware('auth');
Route::resource('purchases', 'PurchaseController')->middleware('auth');
Route::resource('warehouses', 'WarehouseController')->middleware('auth');
