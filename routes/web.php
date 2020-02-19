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
Route::get('/invoice',function(){
  return view('prints.invoice');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () {
    return view('home');
})->middleware('auth');
Route::get('goodReceipt','GoodController@goodReceiptPage');
Route::get('goodDeliver','GoodController@goodDeliverPage');

Route::get('purchaseRequest','PurchaseController@request')->name('purchaseRequest');
Route::get('requestApprove/{id}/{good}','PurchaseController@requestApprove')->name('requestApprove');
Route::get('requestDispprove/{id}/{good}','PurchaseController@requestDispprove')->name('requestDispprove');

Route::get('reports','ReportController@index')->name('reports');
Route::get('reports/{page}','ReportController@show')->name('reportPage');

Route::get('designerApproval/{id}','DesignerController@approve')->name('designerApproval');
Route::get('designerDisapproval/{id}','DesignerController@disapprove')->name('designerDisapproval');
Route::post('getDesignerData','DesignerController@getDesignerData')->name('getDesignerData');
Route::post('deleteGood','DesignerController@deleteGood')->name('deleteGood');

Route::get('surveyorApproval/{id}','SurveyorController@approve')->name('surveyorApproval');
Route::get('surveyorDisapproval/{id}','SurveyorController@disapprove')->name('surveyorDisapproval');

Route::get('saleApproval/{id}','SaleController@approve')->name('saleApproval');
Route::get('saleDisapproval/{id}','SaleController@disapprove')->name('saleDisapproval');

Route::get('makeInvoice/{id}','PurchaseController@makeInvoice')->name('makeInvoice')->middleware('auth');
Route::get('price','PurchaseController@price')->name('price');


Route::post('goodDeliverSearch','GoodController@goodDeliverSearch');
Route::post('goodReceiptSearch','GoodController@goodReceiptSearch');
Route::post('goodDeliverFinish','GoodController@goodDeliverFinish');
Route::post('goodReceiptFinish','GoodController@goodReceiptFinish');

Route::post('getCompanyData','CompanyController@getCompanyData')->name('getCompanyData');

// Route::resource('bills','BillOfMaterialController');
Route::resource('addresses', 'AddressController')->middleware('auth');
Route::resource('catalogs','CatalogController')->middleware('auth');
Route::resource('checklists','ChecklistController')->middleware('auth');
Route::resource('companies', 'CompanyController')->middleware('auth');
Route::resource('designers', 'DesignerController')->middleware('auth');
Route::resource('goods','GoodController')->middleware('auth');
Route::resource('projects', 'ProjectController')->middleware('auth');
Route::resource('purchases', 'PurchaseController')->middleware('auth');
Route::resource('roles', 'RoleController')->middleware('auth');
Route::resource('sales', 'SaleController')->middleware('auth');
Route::resource('surveyors', 'SurveyorController')->middleware('auth');
Route::resource('units', 'UnitController')->middleware('auth');
Route::resource('users', 'UserController')->middleware('auth');
Route::resource('warehouses', 'WarehouseController')->middleware('auth');
