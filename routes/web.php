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

Route::get('electre', 'CriteriaController@electre');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () {
    return view('home');
})->middleware('auth');

Route::post('deleteCatalogGood','CatalogController@deleteGood')->name('deleteCatalogGood');

Route::post('getCompanyData','CompanyController@getCompanyData')->name('getCompanyData');

Route::get('designerApproval/{id}','DesignerController@approve')->name('designerApproval');
Route::get('designerDisapproval/{id}','DesignerController@disapprove')->name('designerDisapproval');
Route::post('getDesignerData','DesignerController@getDesignerData')->name('getDesignerData');
Route::post('deleteDesignerGood','DesignerController@deleteGood')->name('deleteDesignerGood');
Route::post('getProjectDetail','CriteriaController@electre')->name('getProjectDetail');

Route::post('deleteFile','FileController@deleteFile')->name('deleteFile');

Route::get('goodReceipt','GoodController@goodReceiptPage');
Route::get('goodDeliver','GoodController@goodDeliverPage');
Route::post('goodDeliverSearch','GoodController@goodDeliverSearch');
Route::post('goodReceiptSearch','GoodController@goodReceiptSearch');
Route::post('goodDeliverFinish','GoodController@goodDeliverFinish');
Route::post('goodReceiptFinish','GoodController@goodReceiptFinish');

Route::get('makeSaleInvoice/{id}','InvoiceController@makeInvoice')->name('makeSaleInvoice')->middleware('auth');

Route::get('makePurchaseInvoice/{id}','PurchaseController@makeInvoice')->name('makePurchaseInvoice')->middleware('auth');
Route::get('price','PurchaseController@price')->name('price');
Route::get('purchaseRequest','PurchaseController@request')->name('purchaseRequest');
Route::get('requestApprove/{designer}/{id}','DesignerController@requestApprove')->name('requestApprove');
Route::get('requestDispprove/{designer}/{id}','DesignerController@requestDisapprove')->name('requestDispprove');
Route::post('purchaseQuotation/','PurchaseController@quotation')->name('purchaseQuotation');
Route::get('addPurchaseQuotation/{good}/{project}','PurchaseController@addQuotation')->name('addPurchaseQuotation');

Route::get('projectFinish/{id}','ProjectController@finish')->name('projectFinish');

Route::get('reports','ReportController@index')->name('reports');
Route::get('reports/{page}','ReportController@show')->name('reportPage');

Route::get('saleApproval/{id}','SaleController@approve')->name('saleApproval');
Route::get('saleDisapproval/{id}','SaleController@disapprove')->name('saleDisapproval');
Route::get('quotation/','SaleController@quotation')->name('quotation');


Route::get('surveyorApproval/{id}','SurveyorController@approve')->name('surveyorApproval');
Route::get('surveyorDisapproval/{id}','SurveyorController@disapprove')->name('surveyorDisapproval');

// Route::resource('bills','BillOfMaterialController');
Route::resource('addresses', 'AddressController')->middleware('auth');
Route::resource('catalogs','CatalogController')->middleware('auth');
Route::resource('checklists','ChecklistController')->middleware('auth');
Route::resource('companies', 'CompanyController')->middleware('auth');
Route::resource('criterias', 'CriteriaController')->middleware('auth');
Route::resource('delivers', 'DeliverController')->middleware('auth');
Route::resource('designers', 'DesignerController')->middleware('auth');
Route::resource('files', 'FileController')->middleware('auth');
Route::resource('goods','GoodController')->middleware('auth');
Route::resource('invoices','InvoiceController')->middleware('auth');
Route::resource('projects', 'ProjectController')->middleware('auth');
Route::resource('purchases', 'PurchaseController')->middleware('auth');
Route::resource('receipts', 'ReceiptController')->middleware('auth');
Route::resource('roles', 'RoleController')->middleware('auth');
Route::resource('sales', 'SaleController')->middleware('auth');
Route::resource('surveyors', 'SurveyorController')->middleware('auth');
Route::resource('types', 'TypeController')->middleware('auth');
Route::resource('units', 'UnitController')->middleware('auth');
Route::resource('users', 'UserController')->middleware('auth');
Route::resource('warehouses', 'WarehouseController')->middleware('auth');
