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

Route::get('updateProductStore', 'HomeController@updateProductStore')->name('updateProductStore');
Route::get('dataexports', 'ExportsController@index');
Route::any('sync', 'HomeController@sync')->name('sync');
Route::any('taswia', 'HomeController@taswia')->name('taswia');
Route::get('updateShipment', 'HomeController@updateShipment')->name('updateShipment');

Route::group(['middleware' => ['locale']], function () {
    Auth::routes();
    Route::any('createTurpoShipment/{id}', 'OrdersController@createTurpoShipment')->name('createTurpoShipment');
    Route::get('areasList', 'PersonsController@areasList')->name('areasList');
    Route::get('governmentList', 'PersonsController@governmentList')->name('governmentList');
    Route::get('offers/getPrint/{id}', 'OfferController@getPrint')->name('offers.getPrint');
    Route::get('updateproductpricepersent', 'HomeController@updateProductPricePersent')->name('updateProductPricePersent');
    Route::any('closeshift', 'HomeController@closeShift')->name('closeShift');
    Route::get('setLang/{language}', 'HomeController@setLang')->name('changeLang');
    Route::get('regionsReport', 'ProductsController@regionsReport')->name('regionsReport');
    Route::get('getSalesDebt', 'OrdersController@getSalesDebt')->name('getSalesDebt');
    Route::get('representativesReport', 'EmployeesController@representativesReport')->name('representativesReport');
    Route::get('getRepresentativesDetail/{id}', 'EmployeesController@getRepresentativesDetail')->name('getRepresentativesDetail');
    Route::get('representativesSalesReport', 'EmployeesController@representativesSalesReport')->name('representativesSalesReport');
    Route::get('getRepresentativesSalesReportDetail/{id}', 'EmployeesController@getRepresentativesSalesReportDetail')->name('getRepresentativesSalesReportDetail');
    Route::get('person/getList', 'PersonsController@getPersonList')->name('person.getList');
    Route::get('person/getDetails', 'PersonsController@getDetails')->name('person.getDetails');
    Route::get('getEmployeeList', 'EmployeesController@getEmployeeList')->name('getEmployeeList');
    Route::get('deleteLogo', 'SettingController@deleteLogo')->name('deleteLogo');
    Route::get('products/priceList2', 'ProductsController@priceList2')->name('products.priceList2');
    Route::get('summery', 'HomeController@summery')->name('summery');

    Route::any('shipment/prepare', 'ShipmentsController@prepare')->name('shipments.prepare');
    Route::get('shipment/report', 'ShipmentsController@report')->name('shipments.report');
    Route::get('shipment/invoices/{id}', 'ShipmentsController@getInvoices')->name('shipments.invoices');
    Route::resource('companies', 'CompanyController');
    Route::post('partner/add-profit', 'PartnersController@addProfitToPartner')->name('partners.addProfitToPartner');
    Route::group(['middleware' => ['auth', 'checkPermission']], function () {
        //dd(app()->getLocale());
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('shipmentstruncate', 'ShipmentsController@truncateShipments')->name('shipments.truncateData');

        Route::any('person/addPayment/{person}', 'PersonsController@addPayment')->name('persons.addPayment');
        Route::get('persons/getClientSupplier/{name?}', 'PersonsController@getClientSupplier')->name('persons.getClientSupplier');
        Route::resource('regions', 'RegionsController');
        Route::any('updateShippingt/{id}', 'ShipmentsController@updateShipping')->name('shipments.updateShipping');
        Route::resource('shipments', 'ShipmentsController');
        Route::any('shipments/transfer/{prodid}', 'ShipmentsController@Transfer')->name('shipments.transfer');
        Route::delete('transaction/destroy/{id}', 'PersonsController@deleteTransaction')->name('transaction.destroy');
        Route::any('person/support/{person}', 'PersonsController@support')->name('persons.support');
        Route::resource('persons', 'PersonsController');
        Route::get('clients/create', 'PersonsController@clientCreate')->name('client.create');
        Route::get('clients/{isdebt?}', 'PersonsController@clientIndex')->name('client.index');
        Route::get('suppliers', 'PersonsController@supplierIndex')->name('supplier.index');
        Route::get('suppliers/create', 'PersonsController@supplierCreate')->name('supplier.create');
        Route::resource('units', 'UnitsController');
        Route::resource('stores', 'StoresController');
        Route::resource('category', 'CategoriesController');
        Route::resource('partners', 'PartnersController');
        Route::resource('movements', 'MovementsController');
        Route::resource('expensesType', 'ExpensesTypeController');
        Route::resource('offers', 'OfferController');

        Route::get('products/report', 'ProductsController@getReport')->name('products.report');
        Route::get('products/getproductbarcode/{product}', 'ProductsController@getProductBarcode')->name('products.barcode');
        Route::get('products/generateBarCode', 'ProductsController@generateBarCode')->name('products.generateBarCode');
        Route::get('products/priceList', 'ProductsController@priceList')->name('products.priceList');
        Route::get('products/search/getProductList/{is_raw?}', 'ProductsController@getProductList')->name('products.getProductList');
        Route::get('products/getReturnsList', 'ProductsController@getReturnsList')->name('products.getReturnsList');
        Route::get('products/getCriticalQuantity', 'ProductsController@getCriticalQuantity')->name('products.getCriticalQuantity');
        Route::get('products/list/{is_raw?}', 'ProductsController@index')->name('products.index');
        Route::resource('combinations', 'CombinationController');
        Route::resource('products', 'ProductsController');
        Route::resource('services', 'ServicesController');
        Route::get("orders/getDetails", 'OrdersController@getDetails')->name('orders.details');
        Route::resource('reservations', 'ReservationController');
        Route::resource('orders', 'OrdersController');
        Route::get('order/create', 'OrdersController@createSales')->name('order.create');
        Route::get('purchase/create', 'OrdersController@createPurchase')->name('purchase.create');
        Route::get('orders', 'OrdersController@getSales')->name('orders.index');
        Route::get('purchases', 'OrdersController@getPurchases')->name('purchases.index');
        Route::get('orders/getPrint/{id}', 'OrdersController@getPrint')->name('orders.getPrint');
        Route::get('returns/getPrint/{id}', 'ReturnsController@getPrint')->name('returns.getPrint');
        Route::get('expenses/report', 'ExpensesController@report')->name('expenses.report');
        Route::get('generaltaxreturnreport/report', 'ExpensesController@generaltaxreturnreport')->name('generaltaxreturnreport');

        Route::resource('expenses', 'ExpensesController');
        Route::resource('damageOptions', 'DamageOptionController');

        Route::resource('tresuryTranactions', 'TresuryTranactionsController');
        Route::resource('returns', 'ReturnsController');
        Route::get('orderReturn/create', 'ReturnsController@createSales')->name('orderReturn.create');
        Route::get('purchaseReturn/create', 'ReturnsController@createPurchase')->name('purchaseReturn.create');
        Route::get('ordersReturn', 'ReturnsController@getSales')->name('ordersReturn.index');
        Route::get('purchasesReturn', 'ReturnsController@getPurchases')->name('purchasesReturn.index');
        Route::resource('users', 'UsersController');
        Route::resource('roles', 'RolesController');
        Route::any('employees/punishments_rewards/{employee}', 'EmployeesController@addPunishmentsRewards')->name('employees.addPunishmentsRewards');
        Route::any('salesmanreport', 'EmployeesController@getSalesManReport')->name('employees.getSalesManReport');
        Route::resource('employees', 'EmployeesController');
        Route::any('Bank/addTransaction/{bank}', 'BanksController@addTransaction')->name('banks.addTransaction');
        Route::get('trans/{id}', 'BanksController@banktransaction')->name('banktransaction');
        Route::get('banks/index/{type?}', 'BanksController@index')->name('tresurycurrency');
        Route::get('banks/create/{type?}', 'BanksController@create')->name('banks.create');
        Route::resource('banks', 'BanksController');
        Route::resource('currencies', 'CurrenciesController');
        Route::resource('damages', 'DamagesController');
        Route::get('clearCache', 'HomeController@clearCache')->name('clearCache');
        Route::get('migrate', 'HomeController@migrate')->name('migrate');
        Route::any('restore', 'HomeController@restore')->name('restore');
        Route::get('cleanDB', 'HomeController@cleanDB')->name('cleanDB');
        Route::get('closeYear', 'HomeController@closeYear')->name('closeYear');
        Route::get('developer', 'HomeController@developer')->name('developer');
        Route::get('dailyreport', 'HomeController@dailyreport')->name('dailyreport');
        Route::get('backup', 'HomeController@backup')->name('backup');
        Route::get('profit', 'HomeController@profit')->name('profit');
        Route::get('setting', array('as' => 'setting.index', 'uses' => 'SettingController@index'));
        Route::post('setting/edit', array('as' => 'setting.edit', 'uses' => 'SettingController@update'));
        Route::get('orders/changeStatus/{order}', 'OrdersController@changeStatus')->name('orders.changeStatus');
        Route::any('workorders', 'OrdersController@workorders')->name('orders.workorders');
        Route::get('instalments-list', 'PersonsController@getCalander')->name('client.getCalander');
    });

    Route::get('gprofit', 'HomeController@gprofit')->name('gprofit');
    Route::get('order/report', 'OrdersController@report')->name('orders.report');
    Route::get('reseveation/report', 'ReservationController@report')->name('reservations.report');
    Route::get('purchase/report', 'OrdersController@purchasereport')->name('purchase.report');
    Route::get('persons/list/payments/{type?}', 'PersonsController@payments')->name('persons.payments');
    Route::get('getworkorderslist', 'OrdersController@getWorkOrders')->name('getWorkOrders');
    Route::get('products/getProductsByCategory/{category_id}', 'ProductsController@getProductsByCategory')->name('products.category');
});

Route::group(['middleware' => ['auth', 'locale']], function () {
    Route::get('logs', 'LogsController@index')->name('logs');
    Route::get('pos', 'OrdersController@pos')->name('pos');
    Route::get('transaction/payment/{type}', 'PersonsController@addTransaction')->name('persons.addTransaction');
    Route::get('person/transactions/list', 'PersonsController@getTransactionList')->name('persons.getTransactionList');


});
Route::get('orders/getPrintBarcode/{id}', 'OrdersController@getPrintBarcode')->name('orders.getPrintBarcode');
Route::delete('deleteInstalment/{id}', 'PersonsController@deleteInstalment')->name('deleteInstalment');
Route::get('allworkorders', 'OrdersController@allworkorders')->name('allworkorders');
Route::get('products/getPriceHistory/{product}', 'ProductsController@getPriceHistory')->name('products.getPriceHistory');
Route::delete('workorders/destroy/{id}', 'OrdersController@deleteworkorder')->name('workorders.destroy');
Route::get('getPersonInvoices', 'PersonsController@getPersonInvoices')->name('getPersonInvoices');
Route::any('importProduct', 'HomeController@importProduct')->name('importProduct');
Route::get('print/transaction/{id}', 'PersonsController@transrecordprint')->name('transrecordprint');

/*Route::get('editdb',function(){
   \DB::statement('DELETE FROM transactions
    where note like "%المبلغ المتبقى%"
    and id NOT IN (
    SELECT * FROM (
      SELECT MAX(id) FROM transactions
      where note like "%المبلغ المتبقى%"
        GROUP BY note,model_id
    )
    x)
  ');
    \DB::statement('DELETE FROM transactions where value = 0');
    dd("done");
});*/

Route::get('changeConnection', function () {
    $currentConeection = 'sqlite';
    if (file_exists('dbConnection.php')) {
        $currentConeection = file_get_contents('dbConnection.php');
    } else {
        file_put_contents('dbConnection.php', 'sqlite');
    }
    if ($currentConeection == 'sqlite') {
        file_put_contents('dbConnection.php', 'sqlite2');
    } else {
        file_put_contents('dbConnection.php', 'sqlite');
    }
    /*Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');*/
    return back();
})->name('changeConnection');
/*Route::get('form', function () {
    return view('form');
});
Route::get('list', function () {
    return view('list');
});
Route::get('modals', function () {
    return view('modals');
});*/