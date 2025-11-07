<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\QualityControlController;
use App\Http\Controllers\Purchase\RfqController;
use App\Http\Controllers\Purchase\CsController;
use App\Http\Controllers\Purchase\LcController;
use App\Http\Controllers\Purchase\RentalController;
use App\Http\Controllers\Purchase\WeeklyProductionForcasting;
use App\Http\Controllers\api\v1\GalleryController;
use App\Http\Controllers\
{
 CostController,
 EmployeeController
};
use App\Http\Controllers\Account\IndividualAccountController;
use App\Http\Controllers\Account\SubSubAccountController;
use App\Http\Controllers\Account\ChartOfAccountController;
use App\Http\Controllers\Account\SubAccountController;

use App\Http\Controllers\PayRoll\
{
  TimeAttendanceController,
  LoanAdvanceController,
  EmployeeSelfServiceController,
  PayRollController,
  EmployeePromotionController,
  EmployeeIncrementController,
  EmployeeRewardController,
  AttendanceReportController,
  SalaryReportController,
  EmployeeProductionController,
  EmployeeLeavePolicyController
};
use App\Http\Controllers\Report\RentalReportController;
use App\Http\Controllers\RequisitionController;
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



Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);


Auth::routes();

Route::get('/route-cache', function() {
$exitCode = Artisan::call('route:cache');
            Artisan::call('optimize:clear');
return 'Routes cache cleared';
});

//Clear config cache:
Route::get('/config-cache', function() {
$exitCode = Artisan::call('config:cache');
return 'Config cache cleared';
});

// Clear application cache:
Route::get('/clear-cache', function() {
$exitCode = Artisan::call('cache:clear');
return 'Application cache cleared';
});

// Clear view cache:
Route::get('/view-clear', function() {
$exitCode = Artisan::call('view:clear');
  Artisan::call('route:clear');
return 'View cache cleared';
});


//Sales Section

Route::group(['middleware' => ['auth']], function () {

    Route::get('/invoice', function () {
        return view('backend.sales.invoice');
    });

    Route::get('/create/reminder', [App\Http\Controllers\ReminderController::class, 'remindercreate'])->name('create.reminder');
    Route::post('/submit/reminder', [App\Http\Controllers\ReminderController::class, 'submitreminder'])->name('submit.reminder');
    Route::get('/delete/reminder/{id}', [App\Http\Controllers\ReminderController::class, 'deletereminder']);

    Route::get('reminder/archive/list', [App\Http\Controllers\ReminderController::class, 'reminderarchivelist'])->name('reminder.archive.list');

  	Route::get('settings/invoicebill/list', [App\Http\Controllers\ReminderController::class, 'invoiceBillList'])->name('invoiceBillList');
  	Route::get('settings/invoicebill/create', [App\Http\Controllers\ReminderController::class, 'invoiceBillCreate'])->name('invoiceBillCreate');
  	Route::get('settings/invoicebill/edit/{id}', [App\Http\Controllers\ReminderController::class, 'invoiceBillEdit'])->name('invoiceBillEdit');
	Route::post('settings/invoicebill/store', [App\Http\Controllers\ReminderController::class, 'invoiceBillStore'])->name('invoiceBill.store');
    Route::post('settings/invoicebill/update/{id}', [App\Http\Controllers\ReminderController::class, 'invoiceBillUpdate'])->name('invoiceBill.update');
    Route::get('settings/invoicebill/view/{id}', [App\Http\Controllers\ReminderController::class, 'invoiceBillView'])->name('invoiceBillView');
  	Route::delete('settings/invoicebill/delete', [App\Http\Controllers\ReminderController::class, 'invoiceBillDelete'])->name('invoiceBillDelete');

  	//Purchase Order  purchaseOrder.store settings/get/category
  	Route::get('settings/purchaseOrder/list', [App\Http\Controllers\ReminderController::class, 'purchaseOrderList'])->name('purchaseOrderList');
  	Route::get('settings/purchaseOrder/create', [App\Http\Controllers\ReminderController::class, 'purchaseOrderCreate'])->name('purchaseOrderCreate');
  	Route::post('settings/purchaseOrder/store', [App\Http\Controllers\ReminderController::class, 'purchaseOrderStore'])->name('purchaseOrder.store');
    Route::get('/settings/purchaseOrder/view/{id}', [App\Http\Controllers\ReminderController::class, 'purchaseOrderView'])->name('purchaseOrder.view');
  	Route::get('/settings/get/category/{id}', [App\Http\Controllers\ReminderController::class, 'getRawCategory']);
  	Route::get('get/unit/{id}', [App\Http\Controllers\ReminderController::class, 'getRawPUnit']);
  	Route::delete('settings/purchaseOrder/delete', [App\Http\Controllers\ReminderController::class, 'purchaseOrderDelete'])->name('purchaseOrderDelete');
    Route::get('settings/terms/edit/{id}', [App\Http\Controllers\ReminderController::class, 'purchaseTermCreate'])->name('purchaseTerm.create');
  	Route::post('settings/terms/update/{id}', [App\Http\Controllers\ReminderController::class, 'purchaseTermUpdate'])->name('purchaseTerm.update');
	Route::get('/settings/purchaseOrder/edit/{id}', [App\Http\Controllers\ReminderController::class, 'purchaseOrderEdit'])->name('purchaseOrder.edit');
    Route::post('settings/purchaseOrder/update', [App\Http\Controllers\ReminderController::class, 'purchaseOrderUpdate'])->name('purchaseOrder.update');

    Route::get('/sales/dashboard', [App\Http\Controllers\LayoutController::class, 'salesdashboard'])->name('sales.dashboard');
    Route::get('/purchase/dashboard', [App\Http\Controllers\LayoutController::class, 'purchasedeshboard'])->name('purchase.dashboard');
    Route::get('/account/dashboard', [App\Http\Controllers\LayoutController::class, 'accountdashboard'])->name('account.dashboard');
    Route::get('/settings/dashboard', [App\Http\Controllers\LayoutController::class, 'settingsdashboard'])->name('settings.dashboard');
    Route::get('/crm/dashboard', [App\Http\Controllers\LayoutController::class, 'crmdashboard'])->name('crm.dashboard');
  	Route::get('/hrpayroll/dashboard', [App\Http\Controllers\LayoutController::class, 'hrPayrollDashBoard'])->name('hrpayroll.dashboard');
    Route::get('/tenderBidding/dashboard', [App\Http\Controllers\LayoutController::class, 'tenderBiddingDashBoard'])->name('tenderBidding.dashboard');



    Route::get('/sales/list', [App\Http\Controllers\Sales\SalesController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [App\Http\Controllers\Sales\SalesController::class, 'demandcreate'])->name('sales.create');
    Route::post('/sales/store', [App\Http\Controllers\Sales\SalesController::class, 'demandgenerate'])->name('sales.store');

    Route::get('/sales/checkout/{id}', [App\Http\Controllers\Sales\SalesController::class, 'checkoutindex'])->name('sales.checkout.index');
    Route::post('/sales/checkout/update', [App\Http\Controllers\Sales\SalesController::class, 'updatecheckout'])->name('sales.checkout.update');
    Route::get('/sales/invoice/{id}', [App\Http\Controllers\Sales\SalesController::class, 'invoiceView'])->name('sales.invoice.view');
  	Route::post('/sales/on/invoce/update', [App\Http\Controllers\Sales\SalesController::class, 'vandcdatastore'])->name('sales.on.invoice.update');
    Route::delete('/sales/invoice/delete', [App\Http\Controllers\Sales\SalesController::class, 'invoiceDelete'])->name('sales.invoice.delete');
	Route::get('/sales/chalan/list/{id}', [App\Http\Controllers\Sales\SalesController::class, 'chalanIndex'])->name('sales.chalan.index');
   Route::delete('/sales/chalan/delete', [App\Http\Controllers\Sales\SalesController::class, 'chalanDelete'])->name('sales.chalan.delete');

    Route::get('/sales/product/price/{id}/{vendorid}', [App\Http\Controllers\Sales\SalesController::class, 'getproductprice']);
    Route::get('/sales/product/returnVal/{id}/{vendorid}', [App\Http\Controllers\Sales\SalesController::class, 'getProductReturn']);
    Route::get('/sales/get/vendor/creditlimit/{vendorid}', [App\Http\Controllers\Sales\SalesController::class, 'getvendorcreditlimite']);
    Route::get('/sales/salesNumber', [App\Http\Controllers\Sales\SalesController::class, 'demandeNumber'])->name('sales.InvoiceNumber');
	Route::get('/sales/product/stock/{id}/{wirehouse}', [App\Http\Controllers\Sales\SalesController::class, 'getproductstock']);

    Route::get('vendor/sales/invoice/{id}', [App\Http\Controllers\Sales\SalesController::class, 'vendorsalesinvoice']);


    Route::get('/sales/payment/date/{id}', [App\Http\Controllers\Sales\SalesController::class, 'salespaymentdate']);


  	Route::get('/delivery/status', [App\Http\Controllers\Sales\SalesController::class, 'deliveryStatus'])->name('delivery.status');
	Route::get('delivery/status-update/{id}', [App\Http\Controllers\Sales\SalesController::class, 'deliveryStatusUpdate'])->name('delivery.status.update');
	Route::get('today/sales-delivery/list', [App\Http\Controllers\Sales\SalesController::class, 'SalesDeliveyList'])->name('sales.delivery.list');
	Route::get('confirmed/sales-delivery/list', [App\Http\Controllers\Sales\SalesController::class, 'DeliveyConfirmedList'])->name('sales.delivery.confirmed.list');
  	Route::get('/sales/chalan/status/{id}', [App\Http\Controllers\Sales\SalesController::class, 'chalanStatus'])->name('chalan.status');
    Route::post('/sales/chalan/update/{id}', [App\Http\Controllers\Sales\SalesController::class, 'chalanStatusUpdate'])->name('chalan.status.update');
    Route::get('/sales/chalan/print/{id}', [App\Http\Controllers\Sales\SalesController::class, 'chalanPrint'])->name('chalan.print');
   	Route::get('/sales/chalan/view/{id}', [App\Http\Controllers\Sales\SalesController::class, 'chalanView'])->name('delivery.chalan.view');

    	Route::get('/all/sales/update/view', [App\Http\Controllers\Sales\SalesController::class, 'salesUpdate'])->name('allSales.update.view');

    Route::get('today/sales-delivery-summary/list', [App\Http\Controllers\Sales\SalesController::class, 'salesDeliveySummaryList'])->name('sales.delivery.summary.list');

    Route::get('sales/undelivery/summary/list', [App\Http\Controllers\Sales\SalesController::class, 'salesUnDeliveySummaryList'])->name('salesUnDdeliverySummaryList');


	Route::get('/sales/warehouse/check/{did}/{wid}', [App\Http\Controllers\Sales\SalesController::class, 'warehousecheck']);

   //Company Profile
  	Route::get('/company/profile', [App\Http\Controllers\ComProfleController::class, 'comprofile'])->name('company.profile');
  	Route::post('/company/profile/store', [App\Http\Controllers\ComProfleController::class, 'storedata'])->name('company.profile.store');


    Route::get('/sales/ledger/index', [App\Http\Controllers\Sales\SalesledgerController::class, 'index'])->name('sales.ledger.index');
    Route::post('/sales/ledger', [App\Http\Controllers\Sales\SalesledgerController::class, 'salesledger'])->name('sales.ledger');
    Route::get('/sales/ledger/report/{fdate}/{tdate}', [App\Http\Controllers\Sales\SalesledgerController::class, 'salesLedgerReport']);

    Route::get('/sales/ledger/fg/report/{fdate}/{tdate}', [App\Http\Controllers\Sales\SalesledgerController::class, 'salesLedgerFGReport']);
    Route::get('/sales/ledger/return/report/{fdate}/{tdate}', [App\Http\Controllers\Sales\SalesledgerController::class, 'salesLedgerReturnReport']);

    Route::get('/sales/index', [App\Http\Controllers\Sales\SalesledgerController::class, 'salesIndex'])->name('all.sales.report.index');
    Route::post('/sales/report', [App\Http\Controllers\Sales\SalesledgerController::class, 'salesReport'])->name('all.sales.report');

  	Route::get('/sales/total/ledger/index', [App\Http\Controllers\Sales\SalesledgerController::class, 'indextotal'])->name('sales.total.ledger.index');
    Route::post('/sales/total/ledger', [App\Http\Controllers\Sales\SalesledgerController::class, 'salesledgertotal'])->name('sales.total.ledger');

  	Route::post('get/sales/total/ledger/data', [App\Http\Controllers\Sales\SalesledgerController::class, 'gettotalsalesdata'])->name('get.sales.total.ledger.data');
  	Route::post('get/sales/total/ledger/vendor/data', [App\Http\Controllers\Sales\SalesledgerController::class, 'gettotalsalesvendordata'])->name('get.sales.total.ledger.vendor.data');



    Route::get('/sales/delete/log', [App\Http\Controllers\Sales\SalesController::class, 'deletelog'])->name('delete.log');
  	Route::get('/company/profile', [App\Http\Controllers\ComProfleController::class, 'comprofile'])->name('company.profile');

	//Daily Incentive By Shariar
    Route::get('/sales/daily/incentive', [App\Http\Controllers\Sales\IncentiveController::class, 'daily'])->name('sales.daily.incentive');
  	Route::post('/sales/daily/incentive/store', [App\Http\Controllers\Sales\IncentiveController::class, 'dailyStore'])->name('sales.daily.incentive.store');
	Route::get('/sales/daily/incentive/edit/{id}', [App\Http\Controllers\Sales\IncentiveController::class, 'editDailyIncentive'])->name('sales.daily.incentive.edit');
	Route::post('/sales/daily/incentive/update', [App\Http\Controllers\Sales\IncentiveController::class, 'updateIncentive'])->name('sales.daily.incentive.update');
	Route::delete('/sales/daily/incentive/delete', [App\Http\Controllers\Sales\IncentiveController::class, 'deleteDailyIncentive'])->name('sales.daily.incentive.delete');


  //Monthly Incentive By Reza
	Route::get('/sales/monthly/incentive', [App\Http\Controllers\Sales\IncentiveController::class, 'montly'])->name('sales.monthly.incentive');
  	Route::post('/sales/monthly/incentive/store', [App\Http\Controllers\Sales\IncentiveController::class, 'montlystore'])->name('sales.monthly.incentive.store');

	Route::get('/sales/monthly/incentive/edit/{id}', [App\Http\Controllers\Sales\IncentiveController::class, 'editmonthlyincentive']);
	Route::post('/sales/monthly/incentive/update', [App\Http\Controllers\Sales\IncentiveController::class, 'updatemincentive'])->name('sales.monthly.incentive.update');


	Route::delete('/sales/monthly/incentive/delete', [App\Http\Controllers\Sales\IncentiveController::class, 'deletemonthlyincentive'])->name('sales.monthly.incentive.delete');

  //Yearly Incentive By Reza
  	Route::get('/sales/yearly/incentive', [App\Http\Controllers\Sales\IncentiveController::class, 'yearly'])->name('sales.yearly.incentive');
  	Route::post('/sales/yearly/incentive/store', [App\Http\Controllers\Sales\IncentiveController::class, 'yearlystore'])->name('sales.yearly.incentive.store');
	Route::delete('/sales/yearly/incentive/delete', [App\Http\Controllers\Sales\IncentiveController::class, 'deleteyearlyincentive'])->name('sales.yearly.incentive.delete');

  	Route::get('/sales/yearly/incentive/edit/{id}', [App\Http\Controllers\Sales\IncentiveController::class, 'edityearlyincentive']);
  	Route::post('/sales/yearly/incentive/update', [App\Http\Controllers\Sales\IncentiveController::class, 'yearlyincentiveupdate'])->name('sales.yearly.incentive.update');


    //Sales Return Section
    Route::get('/sales/return/list', [App\Http\Controllers\Sales\ReturnController::class, 'index'])->name('sales.return.index');
    Route::get('/sales/return/create', [App\Http\Controllers\Sales\ReturnController::class, 'returncreate'])->name('sales.return.create');
    Route::post('/sales/return/store', [App\Http\Controllers\Sales\ReturnController::class, 'returngenerate'])->name('sales.return.store');
    Route::delete('/sales/return/delete', [App\Http\Controllers\Sales\ReturnController::class, 'returnDelete'])->name('sales.return.delete');
	Route::get('/sales/return/view/{id}', [App\Http\Controllers\Sales\ReturnController::class, 'detailesview'])->name('sales.return.view');
	Route::get('/sales/return/edit/{id}', [App\Http\Controllers\Sales\ReturnController::class, 'checkoutindex'])->name('sales.return.edit');
	Route::post('/sales/return/update', [App\Http\Controllers\Sales\ReturnController::class, 'updatecheckout'])->name('sales.return.update');
    Route::get('/sales/returnNumber', [App\Http\Controllers\Sales\ReturnController::class, 'demandeNumber'])->name('sales.return.InvoiceNumber');
    Route::get('/sales/partialReturn/update/{id}', [App\Http\Controllers\Sales\ReturnController::class, 'partialReturn'])->name('sales.partial.return');
	Route::post('/sales/partial/Return/update', [App\Http\Controllers\Sales\ReturnController::class, 'updatePartialReturn'])->name('sales.partial.return.update');

    //sales Return Report
    Route::get('/sales/return/report/index', [App\Http\Controllers\Sales\ReturnController::class, 'salesReturnReport'])->name('sales.return.report.index');
    Route::post('/sales/return/report/view', [App\Http\Controllers\Sales\ReturnController::class, 'salesReturnReportView'])->name('sales.return.report.view');
    
    Route::get('/finishGood/return/edit/{id}', [App\Http\Controllers\Sales\ReturnController::class, 'fgReturnEdit'])->name('fg.sales.return.edit');
	Route::post('/finishGood/return/update', [App\Http\Controllers\Sales\ReturnController::class, 'fgReturnUpdate'])->name('fg.sales.return.update');


   //Sales Damage Section
      Route::get('/sales/damage/list', [App\Http\Controllers\Sales\DamageController::class, 'index'])->name('sales.damage.index');
      Route::get('/sales/damage/create', [App\Http\Controllers\Sales\DamageController::class, 'damagecreate'])->name('sales.damage.create');
      Route::post('/sales/damage/store', [App\Http\Controllers\Sales\DamageController::class, 'damagegenerate'])->name('sales.damage.store');
      Route::get('/sales/damage/edit/{id}', [App\Http\Controllers\Sales\DamageController::class, 'damageedit'])->name('sales.damage.edit');
      Route::post('/sales/damage/update', [App\Http\Controllers\Sales\DamageController::class, 'damageupdate'])->name('sales.damage.update');
      Route::delete('/sales/damage/delete', [App\Http\Controllers\Sales\DamageController::class, 'damageDelete'])->name('sales.damage.delete');
      Route::get('/sales/damage/invoice/view/{damage_id}', [App\Http\Controllers\Sales\DamageController::class, 'damageInvoiceView'])->name('sales.damage.invoice.view');



    // Sales Order

    Route::get('/sales/order/list', [App\Http\Controllers\Sales\OrderController::class, 'index'])->name('sales.order.index');
    Route::get('/sales/order/create', [App\Http\Controllers\Sales\OrderController::class, 'demandcreate'])->name('sales.order.create');
    Route::post('/sales/order/store', [App\Http\Controllers\Sales\OrderController::class, 'demandgenerate'])->name('sales.order.store');
    Route::get('/sales/order/view/{id}', [App\Http\Controllers\Sales\OrderController::class, 'invoiceView'])->name('sales.order.view');
    Route::delete('/sales/order/delete', [App\Http\Controllers\Sales\OrderController::class, 'invoiceDelete'])->name('sales.order.delete');

    Route::get('/sales/order/confirm/{invoice}', [App\Http\Controllers\Sales\OrderController::class, 'checkoutindex'])->name('sales.order.confirm.edit');
    Route::post('/sales/order/confirm/update', [App\Http\Controllers\Sales\OrderController::class, 'updatecheckout'])->name('sales.order.confirm.update');

  	Route::get('/sales/order/edit/{invoice}', [App\Http\Controllers\Sales\OrderController::class, 'orderEdit'])->name('sales.order.edit');
    Route::post('/sales/order/update', [App\Http\Controllers\Sales\OrderController::class, 'orderUpdate'])->name('sales.order.update');

  	//no need
    Route::post('/sales/order/confirm', [App\Http\Controllers\Sales\OrderController::class, 'orderconfirm'])->name('sales.order.confirm');


    Route::get('/order/delete/log', [App\Http\Controllers\Sales\OrderController::class, 'deletelog'])->name('order.delete.log');


    //Product

    Route::get('/sales/category/index', [App\Http\Controllers\Sales\SalesCategoryController::class, 'index'])->name('sales.category.index');
    Route::post('/sales/category/store', [App\Http\Controllers\Sales\SalesCategoryController::class, 'store'])->name('sales.category.store');
  	Route::delete('/sales/category/delete', [App\Http\Controllers\Sales\SalesCategoryController::class, 'destroy'])->name('sales.category.delete');
  	Route::get('/sales/category/edit/{id}', [App\Http\Controllers\Sales\SalesCategoryController::class, 'edit'])->name('sales.category.edit');
  	Route::post('/sales/category/update', [App\Http\Controllers\Sales\SalesCategoryController::class, 'update'])->name('sales.category.update');

    //Sub Category
    Route::get('/sales/subCategory/index', [App\Http\Controllers\Sales\SalesCategoryController::class, 'indexSubCat'])->name('sales.sub.category.index');
    Route::post('/sales/subCategory/store', [App\Http\Controllers\Sales\SalesCategoryController::class, 'storeSubCat'])->name('sales.sub.category.store');
  	Route::delete('/sales/subCategory/delete', [App\Http\Controllers\Sales\SalesCategoryController::class, 'destroySubCat'])->name('sales.sub.category.delete');
  	Route::get('/sales/subCategory/edit/{id}', [App\Http\Controllers\Sales\SalesCategoryController::class, 'editSubCat'])->name('sales.sub.category.edit');
  	Route::post('/sales/subCategory/update', [App\Http\Controllers\Sales\SalesCategoryController::class, 'updateSubCat'])->name('sales.sub.category.update');


    Route::get('/sales/item/index', [App\Http\Controllers\Sales\SalesProductController::class, 'index'])->name('sales.item.index');
    Route::get('/sales/item/create', [App\Http\Controllers\Sales\SalesProductController::class, 'create'])->name('sales.item.create');
    Route::post('/sales/item/store', [App\Http\Controllers\Sales\SalesProductController::class, 'store'])->name('sales.item.store');
    Route::get('/sales/item/edit/{id}', [App\Http\Controllers\Sales\SalesProductController::class, 'editproduct']);
    Route::post('/sales/item/update/{id}', [App\Http\Controllers\Sales\SalesProductController::class, 'updateItem']);
  	Route::delete('/sales/item/delete', [App\Http\Controllers\Sales\SalesProductController::class, 'deleteproduct'])->name('sales.item.delete');

    //product unite
    Route::get('/product/unit/create', [App\Http\Controllers\Sales\SalesProductController::class, 'productunitcreate'])->name('product.unit.create');
    Route::post('/product/unit/store', [App\Http\Controllers\Sales\SalesProductController::class, 'productunitstore'])->name('product.unit.store');
    Route::delete('/product/unit/delete', [App\Http\Controllers\Sales\SalesProductController::class, 'deleteunit'])->name('product.unit.delete');
    Route::get('/product/unit/edit/{id}', [App\Http\Controllers\Sales\SalesProductController::class, 'editunit']);
    Route::post('/product/unit/update', [App\Http\Controllers\Sales\SalesProductController::class, 'productunitupdate'])->name('product.unit.update');

    // Product Transfer
    Route::get('/product/transfer/list', [App\Http\Controllers\TransferController::class, 'index'])->name('product.transfer.list');
    Route::get('/product/transfer/create', [App\Http\Controllers\TransferController::class, 'createTransfer'])->name('product.transfer.create');
    Route::post('/product/transfer/store', [App\Http\Controllers\TransferController::class, 'storeTransfer'])->name('product.transfer.store');
    Route::delete('/product/transfer/delete', [App\Http\Controllers\TransferController::class, 'deleteTransfer'])->name('product.transfer.delete');
    Route::get('/product/transfer/edit/{invoice}', [App\Http\Controllers\TransferController::class, 'editTransfer'])->name('product.transfer.edit');
  	Route::get('/product/transfer/chalan/view/{invoice}', [App\Http\Controllers\TransferController::class, 'viewTransfer'])->name('product.transfer.view');
    Route::get('/product/transfer/return/{invoice}', [App\Http\Controllers\TransferController::class, 'returnTransfer'])->name('product.transfer.return');
    Route::post('/product/transfer/update', [App\Http\Controllers\TransferController::class, 'updateTransfer'])->name('product.transfer.update');

    Route::get('/get/batch/numbers/by/{id}', [App\Http\Controllers\TransferController::class, 'getbatchnumbers']);


    Route::get('/transfer/status',[App\Http\Controllers\TransferController::class, 'TransferStatus'])->name('transfer.status');
	Route::get('transfer/status-update/{id}',[App\Http\Controllers\TransferController::class, 'TransferStatusUpdate'])->name('transfer.status.update');


  Route::get('/sales/set_margin/index', [App\Http\Controllers\SatMarginController::class, 'index'])->name('sales.set_margin.index');
    Route::post('/sales/set_margin/store', [App\Http\Controllers\SatMarginController::class, 'store'])->name('sales.set_margin.store');
  	Route::delete('/sales/set_margin/delete', [App\Http\Controllers\SatMarginController::class, 'destroy'])->name('sales.set_margin.delete');
  	Route::get('/sales/set_margin/edit/{id}', [App\Http\Controllers\SatMarginController::class, 'edit'])->name('sales.set_margin.edit');
  	Route::post('/sales/set_margin/update', [App\Http\Controllers\SatMarginController::class, 'update'])->name('sales.set_margin.update');

  Route::get('/purchase/set_margin/index', [App\Http\Controllers\SatMarginController::class, 'purchaseindex'])->name('purchase.set_margin.index');
    Route::post('/purchase/set_margin/store', [App\Http\Controllers\SatMarginController::class, 'purchasestore'])->name('purchase.set_margin.store');
  	Route::delete('/purchase/set_margin/delete', [App\Http\Controllers\SatMarginController::class, 'purchasedestroy'])->name('purchase.set_margin.delete');
  	Route::get('/purchase/set_margin/edit/{id}', [App\Http\Controllers\SatMarginController::class, 'purchaseedit'])->name('purchase.set_margin.edit');
  	Route::post('/purchase/set_margin/update', [App\Http\Controllers\SatMarginController::class, 'purchaseupdate'])->name('purchase.set_margin.update');

  Route::get('/expanse/set_margin/index', [App\Http\Controllers\SatMarginController::class, 'expanseindex'])->name('expanse.set_margin.index');
    Route::post('/expanse/set_margin/store', [App\Http\Controllers\SatMarginController::class, 'expansestore'])->name('expanse.set_margin.store');
  	Route::delete('/expanse/set_margin/delete', [App\Http\Controllers\SatMarginController::class, 'expansedestroy'])->name('expanse.set_margin.delete');
  	Route::get('/expanse/set_margin/edit/{id}', [App\Http\Controllers\SatMarginController::class, 'expanseeedit'])->name('expanse.set_margin.edit');
  	Route::post('/expanse/set_margin/update', [App\Http\Controllers\SatMarginController::class, 'expanseupdate'])->name('expanse.set_margin.update');



    // Vendor Section


    Route::get('/deler/index', [App\Http\Controllers\Dealer\DealerController::class, 'index'])->name('dealer.index');
    Route::get('/deler/create', [App\Http\Controllers\Dealer\DealerController::class, 'getcreate'])->name('dealer.create');
    Route::post('/deler/store', [App\Http\Controllers\Dealer\DealerController::class, 'postCreate'])->name('dealer.store');
    Route::get('edit/deler/{id}', [App\Http\Controllers\Dealer\DealerController::class, 'eidtDealer'])->name('dealer.edit');
    Route::post('/deler/update', [App\Http\Controllers\Dealer\DealerController::class, 'postdealeredit'])->name('dealer.update');
    Route::delete('/deler/delete', [App\Http\Controllers\Dealer\DealerController::class, 'destroy'])->name('dealer.delete');



    Route::get('/deler/delete/log', [App\Http\Controllers\Dealer\DealerController::class, 'vendordeletelog'])->name('dealer.delete.log');
    Route::get('/deler/archive/log', [App\Http\Controllers\Dealer\DealerController::class, 'vendorarchivelog'])->name('dealer.archive.log');
    Route::get('/deler/tc/archive/log', [App\Http\Controllers\Dealer\DealerController::class, 'vendorTCarchivelog'])->name('dealer.tc.archive.log');


    Route::get('/get/warehous/by/vendor/{id}', [App\Http\Controllers\Dealer\DealerController::class, 'getwarehouse']);


    Route::get('/deler/type/create', [App\Http\Controllers\Dealer\DealerTypeController::class, 'getcreate'])->name('dealer.type.create');
    Route::post('/deler/type/store', [App\Http\Controllers\Dealer\DealerTypeController::class, 'postCreate'])->name('dealer.type.store');
    Route::get('/deler/type/edit/{id}', [App\Http\Controllers\Dealer\DealerTypeController::class, 'getedit'])->name('dealer.type.edit');
    Route::post('/deler/type/update', [App\Http\Controllers\Dealer\DealerTypeController::class, 'update'])->name('dealer.type.update');
	Route::delete('/deler/type/delete', [App\Http\Controllers\Dealer\DealerTypeController::class, 'deletedealertype'])->name('dealer.type.delete');

    Route::get('/deler/zone/create', [App\Http\Controllers\Dealer\DealerZoneController::class, 'getcreate'])->name('dealer.zone.create');
    Route::post('/deler/zone/store', [App\Http\Controllers\Dealer\DealerZoneController::class, 'postCreate'])->name('dealer.zone.store');
    Route::get('/deler/zone/edit/{id}', [App\Http\Controllers\Dealer\DealerZoneController::class, 'edit'])->name('dealer.zone.edit');
    Route::post('/deler/zone/update', [App\Http\Controllers\Dealer\DealerZoneController::class, 'update'])->name('dealer.zone.update');
    Route::delete('/deler/zone/delete', [App\Http\Controllers\Dealer\DealerZoneController::class, 'destroy'])->name('dealer.zone.delete');

    Route::get('/deler/subzone/create', [App\Http\Controllers\Dealer\DealerSubzoneController::class, 'getcreate'])->name('dealer.subzone.create');
    Route::post('/deler/subzone/store', [App\Http\Controllers\Dealer\DealerSubzoneController::class, 'postCreate'])->name('dealer.subzone.store');
    Route::get('/deler/subzone/edit/{id}', [App\Http\Controllers\Dealer\DealerSubzoneController::class, 'edit'])->name('dealer.subzone.edit');
    Route::post('/deler/subzone/update', [App\Http\Controllers\Dealer\DealerSubzoneController::class, 'update'])->name('dealer.subzone.update');
  	Route::delete('/deler/subzone/delete', [App\Http\Controllers\Dealer\DealerSubzoneController::class, 'destroy'])->name('dealer.subzone.delete');


    Route::get('/deler/area/create', [App\Http\Controllers\Dealer\DealerAreaController::class, 'getcreate'])->name('dealer.area.create');
    Route::post('/deler/area/store', [App\Http\Controllers\Dealer\DealerAreaController::class, 'postCreate'])->name('dealer.area.store');
    Route::get('/deler/area/edit/{id}', [App\Http\Controllers\Dealer\DealerAreaController::class, 'edit'])->name('dealer.area.edit');
  	Route::post('/deler/area/update', [App\Http\Controllers\Dealer\DealerAreaController::class, 'update'])->name('dealer.area.update');
    Route::delete('/deler/area/delete', [App\Http\Controllers\Dealer\DealerAreaController::class, 'destroy'])->name('dealer.area.delete');


  	Route::get('/special/rate/create', [App\Http\Controllers\OthersController::class, 'specialrateIndex'])->name('special.rate.create');
    Route::post('/special/rate/store', [App\Http\Controllers\OthersController::class, 'specialrateStore'])->name('special.rate.store');
   	Route::delete('/special/rate/delete', [App\Http\Controllers\OthersController::class, 'specialrateDelete'])->name('special.rate.delete');




    // Warehouse


    // Factory

    Route::get('/warehouse/index', [App\Http\Controllers\FactoryController::class, 'index'])->name('warehouse.index');
    Route::get('/warehouse/create', [App\Http\Controllers\FactoryController::class, 'getcreate'])->name('warehouse.create');
    Route::post('/warehouse/create', [App\Http\Controllers\FactoryController::class, 'postcreate'])->name('warehouse.store');
    Route::get('/warehouse/edit/{id}', [App\Http\Controllers\FactoryController::class, 'getedit']);
    Route::post('/warehouse/edit', [App\Http\Controllers\FactoryController::class, 'postedit'])->name('warehouse.update');
	Route::delete('/warehouse/delete', [App\Http\Controllers\FactoryController::class, 'deletewarehouse'])->name('warehouse.delete');


   Route::get('/production/factory/index', [App\Http\Controllers\FactoryController::class, 'productionfactoryindex'])->name('production.factory.index');
    Route::get('/production/factory/create', [App\Http\Controllers\FactoryController::class, 'productionfactorycreate'])->name('production.factory.create');
    Route::post('/production/factory/create', [App\Http\Controllers\FactoryController::class, 'productionfactorystore'])->name('production.factory.store');
    Route::get('/production/factory/edit/{id}', [App\Http\Controllers\FactoryController::class, 'productionfactoryedit']);
    Route::post('/production/factory/edit', [App\Http\Controllers\FactoryController::class, 'productionfactoryupdte'])->name('production.factory.update');
	Route::delete('/production/factory/delete', [App\Http\Controllers\FactoryController::class, 'deleteproductionfactory'])->name('production.factory.delete');




    // Employee Section
    Route::get('/employee/management/list', [EmployeeController::class, 'employeeManagementList'])->name('employee.management.list');
    Route::get('/employee/payRoll/report/list', [EmployeeController::class, 'employeePayRoll'])->name('employee.pay.rollReport');

    Route::get('/employee/list', [EmployeeController::class, 'index'])->name('employee.list');
    Route::get('/employee/create', [EmployeeController::class, 'createEmployee'])->name('employee.create');
    Route::post('/employee/store', [EmployeeController::class, 'storeEmployee'])->name('employee.store');
    Route::get('/edit/employee/{id}', [EmployeeController::class, 'editEmployee']);
    Route::post('update/employee/{id}', [EmployeeController::class, 'updateEmployee']);
	  Route::delete('/employee/delete', [EmployeeController::class, 'deleteEmployee'])->name('employee.delete');

    Route::get('/employee/terget/set/index', [EmployeeController::class, 'targetSetIndex'])->name('employee.target.set.index');
    Route::get('/employee/terget/set/create', [EmployeeController::class, 'targetSetcreate'])->name('employee.target.set.create');
    Route::post('/employee/terget/set/store', [EmployeeController::class, 'targetSetStore'])->name('employee.target.set.store');
    Route::get('/employee/terget/set/add', [EmployeeController::class, 'targetSetAdd'])->name('employee.target.set.add');
    Route::post('/employee/terget/set/view', [EmployeeController::class, 'targetSetView'])->name('employee.target.set.view');

    Route::get('/employee/extended/pim/list', [EmployeeController::class, 'extendedPimIndex'])->name('employee.extended.pim.list');

    //Employee Qualification
    Route::get('/employee/qualification/list', [EmployeeController::class, 'qualificationIndex'])->name('employee.qualification.list');
    Route::get('/employee/qualification/create', [EmployeeController::class, 'qualificationCreate'])->name('employee.qualification.create');


    Route::get('/employee/team/list', [EmployeeController::class, 'indexTeam'])->name('employee.team.list');
    Route::get('/employee/team/create', [EmployeeController::class, 'createEmployeeTeam'])->name('employee.team.create');
    Route::post('/employee/team/store', [EmployeeController::class, 'storeEmployeeTeam'])->name('employee.team.store');
    Route::delete('/employee/team/delete', [EmployeeController::class, 'deleteEmployeeTeam'])->name('employee.team.delete');


    Route::get('/employee/team/reaport/list', [EmployeeController::class, 'etreportList'])->name('employee.team.report.list');
  Route::get('/employee/team/reaport/create', [EmployeeController::class, 'etrcreate'])->name('employee.team.report.create');
    Route::post('/employee/team/reaport/store', [EmployeeController::class, 'etrstore'])->name('employee.team.report.store');
    Route::get('/employee/team/reaport/edit/{id}', [EmployeeController::class, 'etredit'])->name('employee.team.report.edit');
    Route::post('/employee/team/reaport/update', [EmployeeController::class, 'etrupdate'])->name('employee.team.report.update');

    Route::delete('/employee/team/reaport/delete', [EmployeeController::class, 'etrdelete'])->name('employee.team.report.delete');

    Route::get('/employee/team/reaport/index', [EmployeeController::class, 'etreportIndex'])->name('employee.team.report.index');
    Route::post('/employee/team/reaport/view', [EmployeeController::class, 'etreportView'])->name('employee.team.report.view');


  	Route::get('/employee/designation/create', [EmployeeController::class, 'designationIndex'])->name('employee.designation.create');
    Route::post('/employee/designation/store', [EmployeeController::class, 'designationStore'])->name('employee.designation.store');

  	Route::get('/employee/departments/create', [EmployeeController::class, 'departmentsIndex'])->name('employee.departments.create');
    Route::post('/employee/departments/store', [EmployeeController::class, 'departmentsStore'])->name('employee.departments.store');


  	Route::get('/employee/stafcategory/create', [EmployeeController::class, 'stafcategoryIndex'])->name('employee.stafcategory.create');
    Route::post('/employee/stafcategory/store', [EmployeeController::class, 'stafcategoryStore'])->name('employee.stafcategory.store');

	  Route::get('/employee/accounts/index/{id}', [EmployeeController::class, 'accountssetIndex'])->name('employee.accounts.index');
	  Route::get('/employee/accounts/edit/{id}', [EmployeeController::class, 'accountssetedit'])->name('employee.accounts.edit');
    Route::post('/employee/accounts/store', [EmployeeController::class, 'accountssetStore'])->name('employee.accounts.store');

	//Employee Attendness
    Route::get('/employee/timeAttendance/list', [EmployeeController::class, 'employeeTimeAttendance'])->name('employee.time.attendance');
    Route::get('/employee/attendance/form', [EmployeeController::class, 'employeeattendance'])->name('employee.attendance.form');
    Route::post('/employee/attendance/store', [EmployeeController::class, 'employeeattendanceStore'])->name('employee.attendance.store');
	  Route::get('/employee/attendance/list', [EmployeeController::class, 'employeeattendanceList'])->name('employee.attendance.list');
    Route::post('/employee/attendance/view', [EmployeeController::class, 'viewattendance'])->name('employee.attendance.view');

  	//Employee Leave of Absent
	Route::get('/employee/leave/of/absent/form', [EmployeeController::class, 'leaveofabsentform'])->name('employee.leave.of.absent.form');
	Route::post('/employee/leave/of/absent/store', [EmployeeController::class, 'leaveofabsentstore'])->name('employee.leave.of.absent.store');
	Route::get('/employee/leave/of/absent/list', [EmployeeController::class, 'leaveofabsentIndex'])->name('employee.leave.of.absent.list');

  Route::get('/employee/leave/of/absent/policy', [EmployeeController::class, 'leaveofabsentPolicy'])->name('employee.leave.of.absent.policy');
  Route::get('/employee/leave/of/absent/policy/create', [EmployeeController::class, 'leaveofabsentPolicyCreate'])->name('employee.leave.of.absent.policy.create');

  	//Employee Overtime
  	Route::get('/employee/overtime/create', [EmployeeController::class, 'employeeovertime'])->name('employee.overtime.create');
  	Route::post('/employee/overtime/store', [EmployeeController::class, 'employeeovertimestore'])->name('employee.overtime.store');
  	Route::get('/employee/overtime/list', [EmployeeController::class, 'employeeOverTimeList'])->name('employee.overtime.list');
    Route::post('/employee/overtime/view', [EmployeeController::class, 'employeeOverTimeView'])->name('employee.overtime.view');

    //Employee Extra Overtime
  	Route::get('/employee/extra/overtime/create', [EmployeeController::class, 'employeeExtraOvertime'])->name('employee.extra.overtime.create');
  	Route::post('/employee/extra/overtime/store', [EmployeeController::class, 'employeeExtraOvertimestore'])->name('employee.extra.overtime.store');
  	Route::get('/employee/extra/overtime/list', [EmployeeController::class, 'employeeExtraOverTimeList'])->name('employee.extra.overtime.list');
    Route::post('/employee/extra/overtime/view', [EmployeeController::class, 'employeeExtraOverTimeView'])->name('employee.extra.overtime.view');

  	//Employee Salary Pay
  	Route::get('/employee/salary/pay', [EmployeeController::class, 'employeesalarypaymentcreate'])->name('employee.salary.pay');
	   Route::post('/employee/salary/paystore', [EmployeeController::class, 'employeesalarypaymentstore'])->name('employee.salary.pay.store');

     // Employee PayRoll
  	Route::get('/employee/salary/payRoll/list', [EmployeeController::class, 'employeePayRollList'])->name('employee.pay.roll.list');

  	Route::get('/employee/salary/pay/list', [EmployeeController::class, 'employeesalarypaylist'])->name('employee.salary.pay.list');
  	Route::get('/employee/salary/pay/view/paysleep/{invoice}', [EmployeeController::class, 'vewsalarypaysleep']);
  	Route::delete('/employee/salary/pay/delete', [EmployeeController::class, 'deleteemployeepay'])->name('employee.salary.pay.delete');

  	Route::get('/employee/salary/get/{emp_id}/{month}', [EmployeeController::class, 'employeesalarygetamount'])->name('employee.salary.getamount');

  	// Employee Deduction Report
	Route::get('/employee/monthly/deduction/filter', [EmployeeController::class, 'empmonthlydeductionfilter'])->name('employee.monthly.deduction.filter');
	Route::post('/employee/monthly/deduction/view', [EmployeeController::class, 'empmonthlydeductionview'])->name('employee.monthly.deduction.view');

  	//Employee Salary Certificate
	Route::get('/employee/salary/certificate/form', [EmployeeController::class, 'employeesalarycertificateform'])->name('employee.salary.certificate.form');
	Route::post('/employee/salary/certificate/view', [EmployeeController::class, 'employeesalarycertificateview'])->name('employee.salary.certificate.view');
  	//Employee Applointment Latter
	Route::get('/employee/appointment/letter/form', [EmployeeController::class, 'AppointmentLetterForm'])->name('employee.AppointmentLetter.form');
	Route::post('/employee/appointment/letter/view', [EmployeeController::class, 'AppointmentLetterView'])->name('employee.AppointmentLetter.view');



  	//Employee Other amount
  	   Route::get('/employee/other/amount/list', [EmployeeController::class, 'otheramountlist'])->name('employee.other.amount.pay.list');
  	    Route::get('/employee/other/amount/entry', [EmployeeController::class, 'otheramountentry'])->name('employee.other.amount.entry');
	     Route::post('/employee/other/amount/entry/store', [EmployeeController::class, 'otheramountstore'])->name('employee.other.amount.store');

  	 //Monthly Salary and Attendance Report
	   Route::get('monthly/salary/and/attendance/report', [EmployeeController::class, 'monthlysalaryandattendanceReport'])->name('monthly.salary.and.attendance.report');
	    Route::post('monthly/salary/and/attendance/report/view', [EmployeeController::class, 'monthlysalaryandattendanceReportVew'])->name('monthly.salary.and.attendance.report.view');

      //Employee Brach transfer
      Route::get('/employee/brach/transfer/list', [EmployeeController::class, 'employeeBrachTransferList'])->name('employee.brach.transfer.list');
      Route::get('/employee/brach/transfer/create', [EmployeeController::class, 'employeeBrachTransferCreate'])->name('employee.brach.transfer.create');

      //Employee Department transfer
      Route::get('/employee/department/transfer/list', [EmployeeController::class, 'employeeDepartmentTransferList'])->name('employee.department.transfer.list');
      Route::get('/employee/department/transfer/create', [EmployeeController::class, 'employeeDepartmentTransferCreate'])->name('employee.department.transfer.create');

    // Amount Transfer
    Route::get('/amount/transfer/create', [App\Http\Controllers\Account\PaymentController::class, 'amounttransferform'])->name('amount.transfer.create');
    Route::post('/amount/transfer/store', [App\Http\Controllers\Account\PaymentController::class, 'amountTransferEntry'])->name('amount.transfer.store');
    Route::get('/amount/transfer/list', [App\Http\Controllers\Account\PaymentController::class, 'amounttransferlist'])->name('amount.transfer.list');
  Route::get('/amount/transfer/view/{id}', [App\Http\Controllers\Account\PaymentController::class, 'viewAmountTransfer']);
    Route::get('/amount/transfer/edit/{id}', [App\Http\Controllers\Account\PaymentController::class, 'editamounttransfer']);
    Route::post('/amount/transfer/update', [App\Http\Controllers\Account\PaymentController::class, 'ampounttransferupdate'])->name('amount.transfer.update');
    Route::delete('/amount/transfer/delete', [App\Http\Controllers\Account\PaymentController::class, 'deleteamounttransfer'])->name('amount.transfer.delete');

	//General Payment Recived
  	Route::get('/general/payment/received/index', [App\Http\Controllers\Account\PaymentController::class, 'generalpurchaseindex'])->name('general.payment.recived.index');
  	Route::delete('/general/payment/recived/delete', [App\Http\Controllers\Account\PaymentController::class, 'generalpaymentdelete'])->name('general.payment.recived.delete');
	Route::get('/general/payment/received/create', [App\Http\Controllers\Account\PaymentController::class, 'generalpaymentcreate'])->name('general.payment.recived.create');
  	Route::get('/general/payment/received/edit/{id}', [App\Http\Controllers\Account\PaymentController::class, 'generalpaymentedit']);
  	Route::post('/general/payment/recived/store', [App\Http\Controllers\Account\PaymentController::class, 'generalpaymentstore'])->name('general.payment.recived.store');
  	Route::post('/general/payment/recived/restore', [App\Http\Controllers\Account\PaymentController::class, 'generalpaymentrestore'])->name('general.payment.recived.restore');

  	//General Purchase Supplier Payment
  	Route::get('/general/purchase/supplier/payment/', [App\Http\Controllers\Account\PaymentController::class, 'generalsupplierpaymentcreate'])->name('general.purchase.supplier.payment');
  	Route::post('/general/purchase/supplier/payment/store', [App\Http\Controllers\Account\PaymentController::class, 'generalsupplierpaymentstore'])->name('general.payment.supplier.store');

    //COGS details Report
  	Route::get('/accounts/rmCogs/report/view/{fdate}/{tdate}', [App\Http\Controllers\Account\AccountController::class, 'rmCogsReportView']);
  	Route::get('/accounts/fgCogs/report/view/{fdate}/{tdate}', [App\Http\Controllers\Account\AccountController::class, 'fgCogsReportView']);
  	Route::get('/accounts/bagCogs/report/view/{fdate}/{tdate}', [App\Http\Controllers\Account\AccountController::class, 'bagCogsReportView']);

  	//Current Liabilities Report
  	Route::get('/current/liabilities/report', [App\Http\Controllers\Account\AccountController::class, 'currentliabilities'])->name('current.liabilities.report');
    //Purchase Section

  	Route::get('/report/daybook/index', [App\Http\Controllers\Report\dayBookController::class, 'index'])->name('report.daybook.index');
  	Route::post('/report/daybook/reportview', [App\Http\Controllers\Report\dayBookController::class, 'viewreport'])->name('report.daybook.view');

    Route::get('/purchase/index', [App\Http\Controllers\Purchase\PurchaseController::class, 'index'])->name('purchase.index');
    Route::post('/purchase/list', [App\Http\Controllers\Purchase\PurchaseController::class, 'purchaseList'])->name('purchase.list');
    Route::get('/purchase/entry', [App\Http\Controllers\Purchase\PurchaseController::class, 'entry'])->name('purchase.entry');
    Route::post('/purchase/store', [App\Http\Controllers\Purchase\PurchaseController::class, 'store'])->name('purchase.store');
  	Route::get('/purchase/view/{id}', [App\Http\Controllers\Purchase\PurchaseController::class, 'detailsview'])->name('purchase.view');
    Route::get('/purchase/edit/{id}', [App\Http\Controllers\Purchase\PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::post('/purchase/update', [App\Http\Controllers\Purchase\PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase/delete', [App\Http\Controllers\Purchase\PurchaseController::class, 'deletePurchase'])->name('purchase.delete');

    Route::get('/purchase/lc/entry', [App\Http\Controllers\Purchase\LcController::class, 'index'])->name('lc.index');
    Route::get('/purchase/lc/create', [App\Http\Controllers\Purchase\LcController::class, 'create'])->name('lc.data.create');
    Route::post('/purchase/lc/store', [App\Http\Controllers\Purchase\LcController::class, 'store'])->name('lc.data.store');

    Route::get('/purchase/delete/log', [App\Http\Controllers\Purchase\PurchaseController::class, 'deleteLog'])->name('purchase.delete.log');

    //get PO rate
    Route::get('/purchase/order/rate/{id}', [App\Http\Controllers\Purchase\PurchaseController::class, 'getPurchaseOrderRate']);

    Route::get('/purchase/bag/index', [App\Http\Controllers\Purchase\PurchaseController::class, 'bagindex'])->name('purchase.bag.index');
    Route::post('/purchase/bag/list', [App\Http\Controllers\Purchase\PurchaseController::class, 'bagpurchaseList'])->name('purchase.bag.list');
    Route::get('/purchase/bag/detaisl/{id}', [App\Http\Controllers\Purchase\PurchaseController::class, 'bagpurchaseDetails'])->name('purchase.bag.details');
    Route::get('/purchase/bag/entry', [App\Http\Controllers\Purchase\PurchaseController::class, 'bagentry'])->name('purchase.bag.entry');
    Route::post('/purchase/bag/store', [App\Http\Controllers\Purchase\PurchaseController::class, 'bagstore'])->name('purchase.bag.store');
    Route::get('/purchase/bag/edit/{id}', [App\Http\Controllers\Purchase\PurchaseController::class, 'bagedit'])->name('purchase.bag.edit');
    Route::post('/purchase/bag/update', [App\Http\Controllers\Purchase\PurchaseController::class, 'bagupdate'])->name('purchase.bag.update');

  	//finish goods manual Purchase
    Route::get('/finish/goods/manual/purchse/create', [App\Http\Controllers\Purchase\PurchaseController::class, 'finishgoodspurchasecreate'])->name('finish.goods.manual.purchse.create');
  	Route::post('/finish/goods/manual/purchse/store', [App\Http\Controllers\Purchase\PurchaseController::class, 'finishgoodpurstore'])->name('finish.goods.manual.purchse.store');
    Route::get('/finish/goods/manual/purchse/list', [App\Http\Controllers\Purchase\PurchaseController::class, 'finishgoodpurchaselist'])->name('finish.goods.manual.purchse.list');
  	Route::post('/finish/goods/manual/purchse/list/view', [App\Http\Controllers\Purchase\PurchaseController::class, 'finishgoodpurchaselistview'])->name('finish.goods.manual.purchse.list.view');
  	Route::get('/finish/goods/manual/purchse/detailes/{id}', [App\Http\Controllers\Purchase\PurchaseController::class, 'finishgoodpurchasedetailes']);
  	Route::delete('/finish/goods/manual/purchse/delete', [App\Http\Controllers\Purchase\PurchaseController::class, 'finishgoodpurchasedelete'])->name('finish.goods.manual.purchse.delete');
  	Route::get('/finish/goods/manual/purchse/edit/{id}', [App\Http\Controllers\Purchase\PurchaseController::class, 'finishgoodspurchaseedit']);
  	Route::post('/finish/goods/manual/purchse/update', [App\Http\Controllers\Purchase\PurchaseController::class, 'finishgoodpurchaseupdate'])->name('finish.goods.manual.purchse.update');

    Route::get('/get/salesProduct/unit/{id}', [App\Http\Controllers\Purchase\PurchaseController::class, 'finishGoodUnit']);

    Route::get('/scale/data/get/{scale_no}', [App\Http\Controllers\Purchase\PurchaseController::class, 'getScaleData'])->name('get.scale.data');



    Route::get('/purchase/ledger/index', [App\Http\Controllers\Purchase\PurchaseLedgerController::class, 'index'])->name('purchase.ledger.index');
    Route::post('/purchase/ledger/list', [App\Http\Controllers\Purchase\PurchaseLedgerController::class, 'ledgerView'])->name('purchase.ledger.view');
    Route::get('/purchase/ledger/report/list/{fdate}/{tdate}', [App\Http\Controllers\Purchase\PurchaseLedgerController::class, 'ledgerReportView']);

    Route::get('/purchase/stock/ledger/index', [App\Http\Controllers\Purchase\PurchaseLedgerController::class, 'stockLedgerindex'])->name('purchase.stock.ledger.index');
    Route::post('/purchase/stock/ledger/', [App\Http\Controllers\Purchase\PurchaseLedgerController::class, 'stockLedger'])->name('purchase.stock.ledger.report');
    Route::get('/purchase/bag/stock/ledger/index', [App\Http\Controllers\Purchase\PurchaseLedgerController::class, 'bagstockLedgerindex'])->name('purchase.bag.stock.ledger.index');
    Route::post('/purchase/bag/stock/ledger/', [App\Http\Controllers\Purchase\PurchaseLedgerController::class, 'bagstockLedger'])->name('purchase.bag.stock.ledger.report');
    Route::get('/purchase/stock/ledger/report/{fdate}/{tdate}', [App\Http\Controllers\Purchase\PurchaseLedgerController::class, 'stockLedgerView']);
    
    
    // 04-Jun-2024 Added
    Route::get('/purchase/short/summary/index', [App\Http\Controllers\Purchase\PurchaseLedgerController::class, 'rmShortSummary'])->name('purchase.rmShortSummary.index');
    Route::post('/purchase/short/summary/reports', [App\Http\Controllers\Purchase\PurchaseLedgerController::class, 'rmShortSummaryReports'])->name('purchase.rmShortSummary.reports');
    // 04-Jun-2024 End


    Route::get('/purchase/transfer/index', [App\Http\Controllers\Purchase\PurchaseTransferController::class, 'index'])->name('purchase.transfer.index');
    Route::get('/purchase/transfer/create', [App\Http\Controllers\Purchase\PurchaseTransferController::class, 'create'])->name('purchase.transfer.create');
    Route::post('/purchase/transfer/store', [App\Http\Controllers\Purchase\PurchaseTransferController::class, 'store'])->name('purchase.transfer.store');
    Route::get('/purchase/transfer/edit/{id}', [App\Http\Controllers\Purchase\PurchaseTransferController::class, 'edit'])->name('purchase.transfer.edit');
    Route::post('/purchase/transfer/update', [App\Http\Controllers\Purchase\PurchaseTransferController::class, 'update'])->name('purchase.transfer.update');
    Route::delete('/purchase/transfer/delete', [App\Http\Controllers\Purchase\PurchaseTransferController::class, 'delete'])->name('purchase.transfer.delete');
    Route::get('/purchase/transfer/chalan/view/{invoice}', [App\Http\Controllers\Purchase\PurchaseTransferController::class, 'viewTransfer']);

    Route::get('/purchase/return/index', [App\Http\Controllers\Purchase\PurchaseReturnController::class, 'index'])->name('purchase.return.index');
    Route::get('/purchase/return/create', [App\Http\Controllers\Purchase\PurchaseReturnController::class, 'create'])->name('purchase.return.create');
    Route::post('/purchase/return/store', [App\Http\Controllers\Purchase\PurchaseReturnController::class, 'store'])->name('purchase.return.store');
    Route::get('/purchase/return/edit/{id}', [App\Http\Controllers\Purchase\PurchaseReturnController::class, 'edit'])->name('purchase.return.edit');
    Route::post('/purchase/return/update', [App\Http\Controllers\Purchase\PurchaseReturnController::class, 'update'])->name('purchase.return.update');
    Route::delete('/purchase/return/delete', [App\Http\Controllers\Purchase\PurchaseReturnController::class, 'delete'])->name('purchase.return.delete');
    Route::get('/item/purchase/value/{id}/{supplier}', [App\Http\Controllers\Purchase\PurchaseReturnController::class, 'getPurchaseVal']);

   Route::get('/purchase/damage/index', [App\Http\Controllers\Purchase\PurchaseDamageController::class, 'index'])->name('purchase.damage.index');
    Route::get('/purchase/damage/create', [App\Http\Controllers\Purchase\PurchaseDamageController::class, 'create'])->name('purchase.damage.create');
    Route::post('/purchase/damage/store', [App\Http\Controllers\Purchase\PurchaseDamageController::class, 'store'])->name('purchase.damage.store');
    Route::get('/purchase/damage/edit/{id}', [App\Http\Controllers\Purchase\PurchaseDamageController::class, 'edit'])->name('purchase.damage.edit');
    Route::post('/purchase/damage/update', [App\Http\Controllers\Purchase\PurchaseDamageController::class, 'update'])->name('purchase.damage.update');
  	Route::delete('/purchase/damage/delete', [App\Http\Controllers\Purchase\PurchaseDamageController::class, 'deletepardamage'])->name('purchase.damage.delete');




    //Supplier Section
    Route::get('/supplier/index', [App\Http\Controllers\SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/supplier/create', [App\Http\Controllers\SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/supplier/store', [App\Http\Controllers\SupplierController::class, 'store'])->name('supplier.store');

    Route::get('/supplier/edit/{id}', [App\Http\Controllers\SupplierController::class, 'editsupplier'])->name('supplier.edit');
    Route::post('/supplier/update', [App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');

  	Route::delete('/supplier/delete', [App\Http\Controllers\SupplierController::class, 'deletesupplier'])->name('supplier.delete');

    Route::get('/supplier/group/index', [App\Http\Controllers\SupplierController::class, 'groupindex'])->name('supplier.group.index');
    Route::get('/supplier/group/create', [App\Http\Controllers\SupplierController::class, 'groupcreate'])->name('supplier.group.create');
    Route::post('/supplier/group/store', [App\Http\Controllers\SupplierController::class, 'groupstore'])->name('supplier.group.store');

    Route::get('/supplier/agent/index', [App\Http\Controllers\SupplierController::class, 'agentIndex'])->name('supplier.agent.index');
    Route::get('/supplier/agent/create', [App\Http\Controllers\SupplierController::class, 'agentCreate'])->name('supplier.agent.create');


    Route::get('/supplier/group/edit/{id}', [App\Http\Controllers\SupplierController::class, 'suppliergroupedit']);
    Route::post('/supplier/group/update', [App\Http\Controllers\SupplierController::class, 'suppliergroupupdate'])->name('supplier.group.update');

	Route::delete('/supplier/group/delete', [App\Http\Controllers\SupplierController::class, 'deletesuppliergroup'])->name('supplier.group.delete');


    Route::get('/supplier/category/group/create', [App\Http\Controllers\SupplierController::class, 'categorygroupcreate'])->name('supplier.category.group.create');
    Route::post('/supplier/category/group/store', [App\Http\Controllers\SupplierController::class, 'categorygroupstore'])->name('supplier.category.group.store');

  Route::get('/supplier/get/balance/{id}', [App\Http\Controllers\SupplierController::class, 'getsupplierbalance'])->name('get.supplier.balance');



    //Row Materials
    Route::get('/product/row/materials/index', [App\Http\Controllers\RowMaterialsController::class, 'index'])->name('row.materials.index');
    Route::get('/product/row/materials/create', [App\Http\Controllers\RowMaterialsController::class, 'create'])->name('row.materials.create');
    Route::post('/product/row/materials/store', [App\Http\Controllers\RowMaterialsController::class, 'store'])->name('row.materials.store');
  	Route::get('/product/row/materials/edit/{id}', [App\Http\Controllers\RowMaterialsController::class, 'edit'])->name('row.materials.edit');
    Route::post('/product/row/materials/update/{id}', [App\Http\Controllers\RowMaterialsController::class, 'update'])->name('row.materials.update');;
  	Route::delete('/product/row/materials/delete', [App\Http\Controllers\RowMaterialsController::class, 'delete'])->name('row.materials.product.delete');

    Route::get('/category/row/materials/index', [App\Http\Controllers\RowMaterialsController::class, 'categoryindex'])->name('row.materials.category.index');
    Route::post('/category/row/materials/store', [App\Http\Controllers\RowMaterialsController::class, 'categorystore'])->name('row.materials.category.store');

	//RM-Issues by Shariar
  	Route::get('raw/materials/issues/list', [App\Http\Controllers\RowMaterialsController::class, 'rmIssuesList'])->name('row.materials.issues.index');
  	Route::get('raw/materials/issues/create', [App\Http\Controllers\RowMaterialsController::class, 'rmIssuesCreate'])->name('row.materials.issuesCreate');
  	Route::post('raw/materials/issues/store', [App\Http\Controllers\RowMaterialsController::class, 'rmIssuesStore'])->name('row.materials.issues.store');
    Route::get('raw/materials/issues/view/{id}', [App\Http\Controllers\RowMaterialsController::class, 'rmIssuesView'])->name('row.materials.issues.view');
  	//Route::get('/settings/get/category/{id}', [App\Http\Controllers\ReminderController::class, 'getRawCategory']);
  	Route::get('row/materials/edit/{id}', [App\Http\Controllers\RowMaterialsController::class, 'rmIssuesEdit'])->name('row.materials.issuesEdit');
    Route::post('row/materials/update/{id}', [App\Http\Controllers\RowMaterialsController::class, 'rmIssuesUpdate'])->name('row.materials.issuesEditUpdate');
  	Route::delete('raw/materials/issues/delete', [App\Http\Controllers\RowMaterialsController::class, 'rmIssuesDelete'])->name('row.materials.issuesDelete');

    // Account Section

    Route::get('/account/manu/index', [App\Http\Controllers\Account\AccountController::class, 'othersManu'])->name('account.manu.index');
    Route::get('/account/manu/report/index', [App\Http\Controllers\Account\AccountController::class, 'reportManu'])->name('account.manu.report.index');

    Route::get('/account/manu/receive', [App\Http\Controllers\Account\AccountController::class, 'receivemenu'])->name('account.manu.receive');
    Route::get('/account/manu/payment', [App\Http\Controllers\Account\AccountController::class, 'paymentmenu'])->name('account.manu.payment');
    Route::get('/account/manu/asset', [App\Http\Controllers\Account\AccountController::class, 'assetmenu'])->name('account.manu.asset');


    Route::get('/bank/receive/index', [App\Http\Controllers\Account\ReceiveController::class, 'bankReceiveList'])->name('bank.receive.index');
    Route::get('/bank/receive/create', [App\Http\Controllers\Account\ReceiveController::class, 'bankReceivecreate'])->name('bank.receive.create');
    Route::post('/bank/receive/store', [App\Http\Controllers\Account\ReceiveController::class, 'storebankReceive'])->name('bank.receive.store');
  	Route::get('/bank/receive/view/{invoice}', [App\Http\Controllers\Account\ReceiveController::class, 'viewBankReceive']); //Shariar
    Route::get('/bank/receive/edit/{invoice}', [App\Http\Controllers\Account\ReceiveController::class, 'editbankReceive']); //reza
    Route::post('/bank/receive/update', [App\Http\Controllers\Account\ReceiveController::class, 'updatebankReceive'])->name('bank.receive.update');
    Route::delete('/bank/receive/delete', [App\Http\Controllers\Account\ReceiveController::class, 'deletebankReceive'])->name('bank.receive.delete');

    Route::get('/cash/receive/index', [App\Http\Controllers\Account\ReceiveController::class, 'cashReceiveList'])->name('cash.receive.index');
    Route::get('/cash/receive/create', [App\Http\Controllers\Account\ReceiveController::class, 'cashReceivecreate'])->name('cash.receive.create');
    Route::post('/cash/receive/store', [App\Http\Controllers\Account\ReceiveController::class, 'storecashReceive'])->name('cash.receive.store');
    Route::get('/cash/receive/view/{invoice}', [App\Http\Controllers\Account\ReceiveController::class, 'viewCashReceive'])->name('cash.receive.view'); //Shariar
    Route::get('/cash/receive/edit/{invoice}', [App\Http\Controllers\Account\ReceiveController::class, 'editcashReceive']); //reza
    Route::post('/cash/receive/update', [App\Http\Controllers\Account\ReceiveController::class, 'updatecashReceive'])->name('cash.receive.update');
    Route::delete('/cash/receive/delete', [App\Http\Controllers\Account\ReceiveController::class, 'deletecashReceive'])->name('cash.receive.delete');

    //Received Report
    Route::get('/receive/report/index', [App\Http\Controllers\Account\ReceiveController::class, 'receivedreportindex'])->name('receive.report.index');
    Route::post('/receive/report/view', [App\Http\Controllers\Account\ReceiveController::class, 'receivedreportview'])->name('receive.report.view');


   Route::get('/payment/delete/log', [App\Http\Controllers\Account\ReceiveController::class, 'paymentDeleteLog'])->name('payment.delete.log');


    Route::get('/get/payment/invoice', [App\Http\Controllers\Account\ReceiveController::class, 'getinvoicenumber'])->name('get.payment.invoice');

    Route::get('/bank/payment/index', [App\Http\Controllers\Account\PaymentController::class, 'bankpaymentList'])->name('bank.payment.index');
    Route::get('/bank/payment/create', [App\Http\Controllers\Account\PaymentController::class, 'bankpaymentcreate'])->name('bank.payment.create');
    Route::get('/bank/payment/view/{id}', [App\Http\Controllers\Account\PaymentController::class, 'bankPaymentView'])->name('bank.payment.view');
    Route::post('/bank/payment/store', [App\Http\Controllers\Account\PaymentController::class, 'storebankpayment'])->name('bank.payment.store');
    Route::delete('/bank/payment/delete', [App\Http\Controllers\Account\PaymentController::class, 'deletebankpayment'])->name('bank.payment.delete');
	Route::get('/bank/payment/checkBookSerial/{id}', [App\Http\Controllers\Account\PaymentController::class, 'checkBookSerial']);

    Route::get('/cash/payment/index', [App\Http\Controllers\Account\PaymentController::class, 'cashpaymentList'])->name('cash.payment.index');
    Route::get('/cash/payment/create', [App\Http\Controllers\Account\PaymentController::class, 'cashpaymentcreate'])->name('cash.payment.create');
    Route::post('/cash/payment/store', [App\Http\Controllers\Account\PaymentController::class, 'storecashpayment'])->name('cash.payment.store');
  	Route::get('/cash/payment/view/{id}', [App\Http\Controllers\Account\PaymentController::class, 'cashPaymentView'])->name('cash.payment.view');
    Route::delete('/cash/payment/delete', [App\Http\Controllers\Account\PaymentController::class, 'deletecashpayment'])->name('cash.payment.delete');

    Route::get('/payment/edit/{id}', [App\Http\Controllers\Account\PaymentController::class, 'payment_edit'])->name('payment.edit');
    Route::post('/payment/update', [App\Http\Controllers\Account\PaymentController::class, 'payment_update'])->name('payment.update');

    Route::get('/all/payment/index', [App\Http\Controllers\Account\PaymentController::class, 'allPaymentIndex'])->name('all.payment.index');
    Route::post('/all/payment/store', [App\Http\Controllers\Account\PaymentController::class, 'allPaymentStore'])->name('all.payment.store');

  Route::get('/others/payment/index', [App\Http\Controllers\Account\PaymentController::class, 'ohtersPaymentIndex'])->name('others.payment.index');
    Route::post('/others/payment/store', [App\Http\Controllers\Account\PaymentController::class, 'ohtersPaymentStore'])->name('others.payment.store');

   Route::get('/payment/report/index', [App\Http\Controllers\Account\PaymentController::class, 'paymentReportIndex'])->name('payment.report.index');
    Route::post('/payment/report/list', [App\Http\Controllers\Account\PaymentController::class, 'paymentReportList'])->name('payment.report.list');


    Route::get('other/payment/report/index', [App\Http\Controllers\Account\PaymentController::class, 'otherpaymentReportIndex'])->name('other.payment.report.index');
    Route::post('other/payment/report/list', [App\Http\Controllers\Account\PaymentController::class, 'otherpaymentReportList'])->name('other.payment.report.list');



    Route::get('/master/bank/index', [App\Http\Controllers\Account\AccountController::class, 'masterbankIndex'])->name('master.bank.index');
    Route::get('/master/bank/create', [App\Http\Controllers\Account\AccountController::class, 'masterbankCreate'])->name('master.bank.create');
    Route::post('/master/bank/store', [App\Http\Controllers\Account\AccountController::class, 'masterbankStore'])->name('master.bank.store');
	Route::delete('/master/bank/delete', [App\Http\Controllers\Account\AccountController::class, 'masterbankdelete'])->name('master.bank.delete');
   Route::get('/master/bank/edit/{id}', [App\Http\Controllers\Account\AccountController::class, 'masterbankEdit'])->name('master.bank.edit');
    Route::post('/master/bank/update', [App\Http\Controllers\Account\AccountController::class, 'masterbankUpdate'])->name('master.bank.update');

    Route::get('/main/bank/create', [App\Http\Controllers\Account\AccountController::class, 'mainbankCreate'])->name('main.bank.create');
    Route::post('/main/bank/store', [App\Http\Controllers\Account\AccountController::class, 'mainbankStore'])->name('main.bank.store');
 	Route::delete('/main/bank/delete', [App\Http\Controllers\Account\AccountController::class, 'deletemainbank'])->name('main.bank.delete');

   Route::get('/loan/type/create', [App\Http\Controllers\Account\AccountController::class, 'loantypeCreate'])->name('loan.type.create');
    Route::post('/loan/bank/store', [App\Http\Controllers\Account\AccountController::class, 'loantypeStore'])->name('loan.type.store');
 	Route::delete('/loan/bank/delete', [App\Http\Controllers\Account\AccountController::class, 'deleteloantype'])->name('loan.type.delete');


    Route::get('/master/cash/index', [App\Http\Controllers\Account\AccountController::class, 'mastercashIndex'])->name('master.cash.index');
    Route::get('/master/cash/create', [App\Http\Controllers\Account\AccountController::class, 'mastercashCreate'])->name('master.cash.create');
    Route::post('/master/cash/store', [App\Http\Controllers\Account\AccountController::class, 'mastercashStore'])->name('master.cash.store');
  	Route::delete('/master/cash/delete', [App\Http\Controllers\Account\AccountController::class, 'mastercashdelete'])->name('master.cash.delete');
	Route::get('/master/cash/edit/{id}', [App\Http\Controllers\Account\AccountController::class, 'masterCashEdit'])->name('master.cash.edit');
    Route::post('/master/cash/update', [App\Http\Controllers\Account\AccountController::class, 'masterCashUpdate'])->name('master.cash.update');

   Route::get('/company/name/create', [App\Http\Controllers\Account\AccountController::class, 'companyCreate'])->name('company.name.create');
    Route::post('/company/name/store', [App\Http\Controllers\Account\AccountController::class, 'companyStore'])->name('company.name.store');
 	Route::delete('/company/name/delete', [App\Http\Controllers\Account\AccountController::class, 'deletecompany'])->name('company.name.delete');


    Route::get('/expanse/index', [App\Http\Controllers\Account\AccountController::class, 'expanseIndex'])->name('expanse.index');
  	Route::get('/expanse/group/edit/{id}', [App\Http\Controllers\Account\AccountController::class, 'expancegroupedit']);
    Route::post('/expanse/group/update', [App\Http\Controllers\Account\AccountController::class, 'expancegroupupdate'])->name('expanse.group.update');

  Route::get('/expanse/subgroup/edit/{id}', [App\Http\Controllers\Account\AccountController::class, 'expancesubgroupedit']);
    Route::post('/expanse/subgroup/update', [App\Http\Controllers\Account\AccountController::class, 'expancesubgroupupdate'])->name('expanse.subgroup.update');


    Route::post('/expanse/group/store', [App\Http\Controllers\Account\AccountController::class, 'expanseGroupStore'])->name('expanse.group.store');
    Route::post('/expanse/subgroup/store', [App\Http\Controllers\Account\AccountController::class, 'expanseSubGroupStore'])->name('expanse.subgroup.store');
	Route::delete('/expanse/group/delete', [App\Http\Controllers\Account\AccountController::class, 'expancegroupdelete'])->name('expanse.group.delete');
  	Route::delete('/expanse/subgroup/delete', [App\Http\Controllers\Account\AccountController::class, 'expancesubgroupdelete'])->name('expanse.subgroup.delete');


    Route::get('/expanse/SubSubGroup/create', [App\Http\Controllers\Account\AccountController::class, 'expenceSubSubCreate'])->name('expanse.SubSubGroup.create');
    Route::post('/expanse/SubSubGroup/store', [App\Http\Controllers\Account\AccountController::class, 'expenceSubSubStore'])->name('expanse.SubSubGroup.store');
 	Route::delete('/expanse/SubSubGroup/delete', [App\Http\Controllers\Account\AccountController::class, 'expenceSubSubDelete'])->name('expanse.SubSubGroup.delete');

    Route::get('/expanse/type/create', [App\Http\Controllers\Account\AccountController::class, 'expansetypeCreate'])->name('expanse.type.create');
    Route::post('/expanse/type/store', [App\Http\Controllers\Account\AccountController::class, 'expansetypeStore'])->name('expanse.type.store');
 	Route::delete('/expanse/type/delete', [App\Http\Controllers\Account\AccountController::class, 'deleteexpansetype'])->name('expanse.type.delete');

	//Expense Ledger Journal Entry
  	Route::get('/expanse/journal/create', [App\Http\Controllers\Account\PaymentController::class, 'expanseJournalCreate'])->name('expanse.journal.create');
    Route::post('/expanse/journal/store', [App\Http\Controllers\Account\PaymentController::class, 'expanseJournalStore'])->name('expanse.journal.store');


    Route::get('/expanse/payment/index', [App\Http\Controllers\Account\PaymentController::class, 'expansePaymentIndex'])->name('expanse.payment.index');
    Route::get('/expanse/payment/create', [App\Http\Controllers\Account\PaymentController::class, 'expansepaymentcreate'])->name('expanse.payment.create');
    Route::post('/expanse/payment/store', [App\Http\Controllers\Account\PaymentController::class, 'storeexpansepayment'])->name('expanse.payment.store');
  	Route::get('/expanse/payment/view/{id}', [App\Http\Controllers\Account\PaymentController::class, 'expansePaymentView'])->name('expanse.payment.view');
    Route::get('/expanse/payment/eidt/{id}', [App\Http\Controllers\Account\PaymentController::class, 'expansepaymentEdit'])->name('expanse.payment.edit');
    Route::post('/expanse/payment/update', [App\Http\Controllers\Account\PaymentController::class, 'updateexpansepayment'])->name('expanse.payment.update');
   Route::get('/expanse/payment/return/index', [App\Http\Controllers\Account\PaymentController::class, 'expansePaymentReturnIndex'])->name('expanse.payment.return.index');
  	Route::get('/expanse/payment/return/{id}', [App\Http\Controllers\Account\PaymentController::class, 'expansePaymentReturn'])->name('expanse.payment.return');
    Route::post('/expanse/payment/returnUpdate', [App\Http\Controllers\Account\PaymentController::class, 'expansePaymentReturnUpdate'])->name('expanse.payment.returnUpdate');
    Route::delete('/expanse/payment/delete', [App\Http\Controllers\Account\PaymentController::class, 'deleteexpansepayment'])->name('expanse.payment.delete');
  	Route::delete('/expanse/payment/returnDelete', [App\Http\Controllers\Account\PaymentController::class, 'expansePaymentReturnDelete'])->name('expanse.payment.return.delete');

//Chart of Accounts
  Route::get('/expanse/chartOfAccount/view', [App\Http\Controllers\Account\PaymentController::class, 'expanseChatOfAccount'])->name('expanse.payment.chartOfAccounts');

    Route::get('/get/bank/balance/{id}', [App\Http\Controllers\Account\AccountController::class, 'getbankbalance']);
    Route::get('/get/cash/balance/{id}', [App\Http\Controllers\Account\AccountController::class, 'getchasbalance']);



    Route::get('/journal/entry/index', [App\Http\Controllers\Account\PaymentController::class, 'journalentryIndex'])->name('journal.entry.index');
    Route::get('/journal/entry/create', [App\Http\Controllers\Account\PaymentController::class, 'journalentrycreate'])->name('journal.entry.create');
    Route::post('/journal/entry/store', [App\Http\Controllers\Account\PaymentController::class, 'storejournalentry'])->name('journal.entry.store');
  	Route::get('/journal/entry/view/{id}', [App\Http\Controllers\Account\PaymentController::class, 'journalEntryView'])->name('journal.entry.view');
    Route::get('/journal/entry/edit/{id}', [App\Http\Controllers\Account\PaymentController::class, 'journalentryedit'])->name('journal.entry.edit');
    Route::post('/journal/entry/update', [App\Http\Controllers\Account\PaymentController::class, 'updatejournalentry'])->name('journal.entry.update');
    Route::delete('/journal/entry/delete', [App\Http\Controllers\Account\PaymentController::class, 'deletejournalentry'])->name('journal.entry.delete');
    
    Route::get('/normalJournal/entry/create', [App\Http\Controllers\Account\PaymentController::class, 'normalJournalCreate'])->name('normal.journal.entry.create');
    Route::post('/normalJournal/entry/store', [App\Http\Controllers\Account\PaymentController::class, 'normalJournalStore'])->name('normal.journal.entry.store');

  	//Others Journal create payment
  	Route::get('/otherJournal/entry/index', [App\Http\Controllers\Account\PaymentController::class, 'OtherJournalEntryIndex'])->name('otherJournal.entry.index');
  	Route::get('/otherJournal/entry/create', [App\Http\Controllers\Account\PaymentController::class, 'OtherJournalCreate'])->name('otherJournal.entry.create');
	Route::post('/otherJournal/entry/store', [App\Http\Controllers\Account\PaymentController::class, 'storeOtherJournalEntry'])->name('otherJournal.entry.store');
  	Route::delete('/otherJournal/entry/delete', [App\Http\Controllers\Account\PaymentController::class, 'deleteOtherJournalEntry'])->name('otherJournal.entry.delete');


    Route::get('/bank/book/index', [App\Http\Controllers\Account\AccountController::class, 'bankBookIndex'])->name('bank.book.index');
    Route::post('/bank/book/list', [App\Http\Controllers\Account\AccountController::class, 'bankBookReport'])->name('bank.book.report');
    Route::get('/bank/book/report/list/{fdate}/{tdate}', [App\Http\Controllers\Account\AccountController::class, 'bankBookReportGet']);

    Route::get('/master/bank/book/index', [App\Http\Controllers\Account\AccountController::class, 'masterbankBookIndex'])->name('master.bank.book.index');
    Route::post('/master/bank/book/list', [App\Http\Controllers\Account\AccountController::class, 'masterbankBookReport'])->name('master.bank.book.report');

    Route::get('/cash/book/index', [App\Http\Controllers\Account\AccountController::class, 'cashBookIndex'])->name('cash.book.index');
    Route::post('/cash/book/list', [App\Http\Controllers\Account\AccountController::class, 'cashBookReport'])->name('cash.book.report');
    Route::get('/cash/book/report/list/{fdate}/{tdate}', [App\Http\Controllers\Account\AccountController::class, 'cashBookReportGet']);
    Route::get('/sisterConcern/book/index', [App\Http\Controllers\Account\AccountController::class, 'sisterConcernIndex'])->name('sisterConcern.book.index');
    Route::post('/sisterConcern/book/list', [App\Http\Controllers\Account\AccountController::class, 'sisterConcernReport'])->name('sisterConcern.book.report');
    Route::get('/sisterConcern/book/report/list/{fdate}/{tdate}', [App\Http\Controllers\Account\AccountController::class, 'sisterConcernReportView']);

    Route::get('/accounts/trial/balance/index', [App\Http\Controllers\Account\AccountController::class, 'trailbalanceIndex'])->name('accounts.trail.balance.index');
    Route::post('/accounts/trial/balance/', [App\Http\Controllers\Account\AccountController::class, 'trailbalance'])->name('accounts.trail.balance.report');

  Route::get('/accounts/trial/balance/head/change', [App\Http\Controllers\Account\AccountController::class, 'trailbalanceheadchange'])->name('accounts.trail.balance.head.change');
    Route::post('/accounts/trial/balance/head/change/store', [App\Http\Controllers\Account\AccountController::class, 'trailbalanceheadchangestore'])->name('accounts.trail.balance.head.change.store');


   Route::get('/accounts/pie/chart/index', [App\Http\Controllers\Account\AccountController::class, 'piechartIndex'])->name('accounts.pie.chart.index');
    Route::post('/accounts/pie/chart/', [App\Http\Controllers\Account\AccountController::class, 'piechart'])->name('accounts.pie.chart.report');

 Route::get('/expenditure/pie/chart/index', [App\Http\Controllers\Account\AccountController::class, 'expenditurepiechartIndex'])->name('expenditure.pie.chart.index');
    Route::post('/expenditure/pie/chart/', [App\Http\Controllers\Account\AccountController::class, 'expenditurepiechart'])->name('expenditure.pie.chart.report');

  Route::get('/budget/pie/chart/index', [App\Http\Controllers\Account\AccountController::class, 'budgetepiechartIndex'])->name('budget.pie.chart.index');
    Route::post('/budget/pie/chart/', [App\Http\Controllers\Account\AccountController::class, 'budgetpiechart'])->name('budget.pie.chart.report');

   Route::get('all/income/index', [App\Http\Controllers\Account\AccountController::class, 'allIncomeInedex'])->name('all.income.index');
    Route::get('all/income/create', [App\Http\Controllers\Account\AccountController::class, 'allIncomecreate'])->name('all.income.create');
    Route::post('all/income/store', [App\Http\Controllers\Account\AccountController::class, 'allIncomeentry'])->name('all.income.store');
   Route::get('others/income/view/{id}', [App\Http\Controllers\Account\AccountController::class, 'otherIncomeView'])->name('all.income.view');
      Route::delete('all/income/delete', [App\Http\Controllers\Account\AccountController::class, 'deleteallIncome'])->name('all.income.delete');


   Route::get('loan/borrowing/index', [App\Http\Controllers\Account\AccountController::class, 'loanBInedex'])->name('loan.borrowing.index');
    Route::get('loan/borrowing/create', [App\Http\Controllers\Account\AccountController::class, 'loanBcreate'])->name('loan.borrowing.create');
    Route::post('loan/borrowing/store', [App\Http\Controllers\Account\AccountController::class, 'loanBentry'])->name('loan.borrowing.store');
      Route::delete('loan/borrowing/delete', [App\Http\Controllers\Account\AccountController::class, 'deleteloanB'])->name('loan.borrowing.delete');


  Route::get('ltr/index', [App\Http\Controllers\Account\AccountController::class, 'ltrInedex'])->name('ltr.index');
    Route::get('ltr/create', [App\Http\Controllers\Account\AccountController::class, 'ltrcreate'])->name('ltr.create');
    Route::post('ltr/store', [App\Http\Controllers\Account\AccountController::class, 'ltrentry'])->name('ltr.store');
      Route::delete('ltr/delete', [App\Http\Controllers\Account\AccountController::class, 'deleteltr'])->name('ltr.delete');



   Route::get('lease/index', [App\Http\Controllers\Account\AccountController::class, 'leaseInedex'])->name('lease.index');
    Route::get('lease/create', [App\Http\Controllers\Account\AccountController::class, 'leasecreate'])->name('lease.create');
    Route::post('lease/store', [App\Http\Controllers\Account\AccountController::class, 'leaseentry'])->name('lease.store');
      Route::delete('lease/delete', [App\Http\Controllers\Account\AccountController::class, 'deletelease'])->name('lease.delete');


  Route::get('bad/debt/index', [App\Http\Controllers\Account\AccountController::class, 'BadDebtInedex'])->name('bad.debt.index');
    Route::get('bad/debt/create', [App\Http\Controllers\Account\AccountController::class, 'BadDebtcreate'])->name('bad.debt.create');
    Route::post('bad/debt/store', [App\Http\Controllers\Account\AccountController::class, 'BadDebtentry'])->name('bad.debt.store');
      Route::delete('bad/debt/delete', [App\Http\Controllers\Account\AccountController::class, 'deleteBadDebt'])->name('bad.debt.delete');




 	Route::get('all/income/source/create', [App\Http\Controllers\Account\AccountController::class, 'allIncomeSourcecreate'])->name('all.income.source.create');
    Route::post('all/income/source/store', [App\Http\Controllers\Account\AccountController::class, 'allIncomeSourceentry'])->name('all.income.source.store');
      Route::delete('all/income/source/delete', [App\Http\Controllers\Account\AccountController::class, 'deleteSourceIncome'])->name('all.income.source.delete');


  Route::get('budget/index', [App\Http\Controllers\Account\AccountController::class, 'budgetindex'])->name('budget.index');
    Route::get('budget/create', [App\Http\Controllers\Account\AccountController::class, 'budgetcreate'])->name('budget.create');
    Route::post('budget/store', [App\Http\Controllers\Account\AccountController::class, 'budgetentry'])->name('budget.store');
      Route::delete('budget/delete', [App\Http\Controllers\Account\AccountController::class, 'deletebudget'])->name('budget.delete');




   Route::get('budget/distribution/index/{id}', [App\Http\Controllers\Account\AccountController::class, 'budgetdistributionindex'])->name('budget.distribution.index');
    Route::get('budget/distribution/create{id}', [App\Http\Controllers\Account\AccountController::class, 'budgetdistributioncreate'])->name('budget.distribution.create');
    Route::post('budget/distribution/store', [App\Http\Controllers\Account\AccountController::class, 'budgetdistributionentry'])->name('budget.distribution.store');
      Route::delete('budget/distribution/delete', [App\Http\Controllers\Account\AccountController::class, 'deletebudgetdistribution'])->name('budget.distribution.delete');


   Route::get('factory_overhead/index', [App\Http\Controllers\Account\AccountController::class, 'factory_overheadindex'])->name('factory_overhead.index');
    Route::get('factory_overhead/create', [App\Http\Controllers\Account\AccountController::class, 'factory_overheadcreate'])->name('factory_overhead.create');
    Route::post('factory_overhead/store', [App\Http\Controllers\Account\AccountController::class, 'factory_overheadentry'])->name('factory_overhead.store');
      Route::delete('factory_overhead/delete', [App\Http\Controllers\Account\AccountController::class, 'deletefactory_overhead'])->name('factory_overhead.delete');


    Route::get('/tax/create', [App\Http\Controllers\Account\AccountController::class, 'taxCreate'])->name('tax.create');
    Route::post('/tax/store', [App\Http\Controllers\Account\AccountController::class, 'taxStore'])->name('tax.store');
 	Route::delete('/tax/delete', [App\Http\Controllers\Account\AccountController::class, 'taxdelete'])->name('tax.delete');

  //Financial Expense
   Route::get('/financial-expense/create', [App\Http\Controllers\Account\AccountController::class, 'financialExpenseCreate'])->name('financialExpense.create');
    Route::post('/financial-expense/store', [App\Http\Controllers\Account\AccountController::class, 'financialExpenseStore'])->name('financialExpense.store');
 	Route::delete('/financial-expense/delete', [App\Http\Controllers\Account\AccountController::class, 'financialExpenseDelete'])->name('financialExpense.delete');


    Route::get('/accounts/income/statement/index', [App\Http\Controllers\Account\AccountController::class, 'incomestatementIndex'])->name('income.statement.index');
    Route::post('/accounts/income/statement/', [App\Http\Controllers\Account\AccountController::class, 'incomestatement'])->name('income.statement.report');

  //  Compared Incomestatement
    Route::get('/accounts/compared/income/statement/index', [App\Http\Controllers\Account\AccountController::class, 'comparedIncomeStatementIndex'])->name('compared.income.statement.index');
    Route::get('/accounts/compared/income/statement/', [App\Http\Controllers\Account\AccountController::class, 'comparedIncomeStatement'])->name('compared.income.statement.report');

  	//Manual statement
  	Route::get('/manual/accounts/income/statement/index', [App\Http\Controllers\Account\AccountController::class, 'manualIncomeStatementIndex'])->name('manual.income.statement.index');
    Route::post('/manual/accounts/income/statement/', [App\Http\Controllers\Account\AccountController::class, 'manualIncomeStatement'])->name('manual.income.statement.report');

	//New Income statement Report
	Route::get('/newAccounts/income/statement/index', [App\Http\Controllers\Account\AccountController::class, 'incomeStatementIndexNew'])->name('pl.income.statement.index');
    Route::post('/newAccounts/income/statement/', [App\Http\Controllers\Account\AccountController::class, 'incomeStatementNew'])->name('pl.income.statement.report');

  	//PL Analytical Report
  	Route::get('/plAnalytical/report/index', [App\Http\Controllers\Account\AccountController::class, 'plAnalyticalReportIndex'])->name('pl.analytical.report.index');
    Route::get('/plAnalytical/report/view/', [App\Http\Controllers\Account\AccountController::class, 'plAnalyticalReportView'])->name('pl.analytical.report.view');
    Route::get('/plAnalytical/report/threat-detection/view/', [App\Http\Controllers\Account\AccountController::class, 'plAnalyticalReportThreatDetectionView'])->name('pl.analytical.report.threat-detection.view');


  	Route::get('/plAnalytical/report/months/view', [App\Http\Controllers\Account\AccountController::class, 'plAnalyticalMonthlyReportView'])->name('pl.analytical.report.monthWise.view');
  	Route::get('/plAnalytical/report/monthly/threat-detection', [App\Http\Controllers\Account\AccountController::class, 'plAnalyticalMonthlyReportViewThreatDetection'])->name('monthly-threat-detection');


 	//cash receivable report
    Route::get('/cash/receivable/report/index', [App\Http\Controllers\Account\AccountController::class, 'cashreceivablereportIndex'])->name('cash.receivable.report.index');
    Route::post('/cash/receivable/report/view', [App\Http\Controllers\Account\AccountController::class, 'cashreceivablereportView'])->name('cash.receivable.report.view');
    //cash Flow Statement report
    Route::get('/cash/flow/statement/report/index', [App\Http\Controllers\Account\AccountController::class, 'cashFlowStatementIndex'])->name('cashFlowStatement.report.index');
    Route::post('/cash/flow/statement/report/view', [App\Http\Controllers\Account\AccountController::class, 'cashFlowStatementView'])->name('cashFlowStatement.report.view');

    Route::get('/accounts/operating/cash/flow/index', [App\Http\Controllers\Account\AccountController::class, 'operatingcashflowIndex'])->name('operating.cash.flow.index');
    Route::post('/accounts/operating/cash/flow/', [App\Http\Controllers\Account\AccountController::class, 'operatingcashflowReport'])->name('operating.cash.flow.report');

   Route::get('/accounts/total/cash/flow/index', [App\Http\Controllers\Account\AccountController::class, 'totalcashflowIndex'])->name('total.cash.flow.index');
    Route::post('/accounts/total/cash/flow/', [App\Http\Controllers\Account\AccountController::class, 'totalcashflowReport'])->name('total.cash.flow.report');

   Route::get('/accounts/new/total/cash/flow/index', [App\Http\Controllers\Account\AccountController::class, 'newtotalcashflowIndex'])->name('new.total.cash.flow.index');
    Route::post('/accounts/new/total/cash/flow/', [App\Http\Controllers\Account\AccountController::class, 'newtotalcashflowReport'])->name('new.total.cash.flow.report');




   	Route::get('/accounts/balance/sheet/index', [App\Http\Controllers\Account\AccountController::class, 'balancesheetIndex'])->name('balance.sheet.index');
    Route::post('/accounts/balance/sheet/', [App\Http\Controllers\Account\AccountController::class, 'balancesheetreport'])->name('balance.sheet.report');

 	Route::get('financial/report/index', [App\Http\Controllers\Account\AccountController::class, 'financialreportIndex'])->name('financial.report.index');
    Route::post('financial/report/sheet/', [App\Http\Controllers\Account\AccountController::class, 'financialreportreport'])->name('financial.report.report');

  	Route::get('/accounts/new/income/statement/index', [App\Http\Controllers\Account\AccountController::class, 'NEWincomestatementIndex'])->name('new.income.statement.index');
    Route::post('/accounts/new/income/statement/', [App\Http\Controllers\Account\AccountController::class, 'NEWincomestatement'])->name('new.income.statement.report');



   Route::get('/accounts/company/summary/index', [App\Http\Controllers\Account\AccountController::class, 'companysummaryIndex'])->name('company.summary.index');
    Route::post('/accounts/company/summary/report', [App\Http\Controllers\Account\AccountController::class, 'companysummaryreport'])->name('company.summary.report');


    Route::get('/accounts/equity/index', [App\Http\Controllers\Account\AccountController::class, 'equityIndex'])->name('accounts.equity.index');
    Route::get('/accounts/equity/report/view/{fdate}/{tdate}', [App\Http\Controllers\Account\AccountController::class, 'equityReportView']);
    Route::get('/accounts/equity/create', [App\Http\Controllers\Account\AccountController::class, 'equitycreate'])->name('accounts.equity.create');
    Route::post('/accounts/equity/store', [App\Http\Controllers\Account\AccountController::class, 'storeequity'])->name('accounts.equity.store');
    Route::delete('accounts/equity/delete', [App\Http\Controllers\Account\AccountController::class, 'deleteequity'])->name('accounts.equity.delete');


   Route::get('/accounts/equity/category', [App\Http\Controllers\Account\AccountController::class, 'equitycategory'])->name('accounts.equity.category');
   Route::post('/accounts/equity/category/store', [App\Http\Controllers\Account\AccountController::class, 'equitycategoryStore'])->name('accounts.equity.category.store');

    Route::get('/top/ten/collection/index', [App\Http\Controllers\Account\AccountController::class, 'toptencollectionreportindex'])->name('top.ten.collection.report.index');
    Route::post('/top/ten/collection/report/', [App\Http\Controllers\Account\AccountController::class, 'toptencollectionreportpiechart'])->name('top.ten.collection.report');

    Route::get('/top/ten/expanse/index', [App\Http\Controllers\Account\AccountController::class, 'toptenexpansereportindex'])->name('top.ten.expanse.report.index');
    Route::post('/top/ten/expanse/report/', [App\Http\Controllers\Account\AccountController::class, 'toptenexpansereportpiechart'])->name('top.ten.expanse.report');



    Route::get('/others/type/create', [App\Http\Controllers\OthersController::class, 'othersTypeindex'])->name('others.type.create');
    Route::post('/others/type/store', [App\Http\Controllers\OthersController::class, 'othersTypestor'])->name('others.type.store');
	Route::delete('/others/type/delete', [App\Http\Controllers\OthersController::class, 'othersTypedelete'])->name('others.type.delete');

	// General Purchase
    Route::get('general/purchase/page/index', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'generalPurchasePageIndex'])->name('general.purchase.page.index');


    Route::get('general/purchase/general/wirehouse/index', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'generalwirehouseindex'])->name('general.purchase.general.wirehouse.index');
    Route::get('general/purchase/general/wirehouse/create', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'generalpurchasewirehousecreate'])->name('general.purchase.general.wirehouse.create');
    Route::post('general/purchase/general/wirehouse/store', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'generalpurchasewirehousestore'])->name('general.purchase.general.wirehouse.store');
    Route::delete('general/purchase/general/wirehouse/delete', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'deletegeneralwirehouse'])->name('general.purchase.general.wirehouse.delete');

    Route::get('/general/purchase/general/category', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseCategory::class, 'index'])->name('general.purchase.generalcategory');
    Route::post('/general/purchase/general/category/store', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseCategory::class, 'storecategory'])->name('general.purchase.generalcategory.store');
    Route::delete('/general/purchase/general/category/delete', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseCategory::class, 'destroy'])->name('general.category.delete');

    Route::get('/general/purchase/general/sub/category', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseCategory::class, 'subcategory'])->name('general.purchase.generalsubcategory');
    Route::post('/general/purchase/general/sub/category/store', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseCategory::class, 'storesubcategory'])->name('general.purchase.generalsubcategory.store');
    Route::delete('/general/purchase/general/sub/category/delete', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseCategory::class, 'destroysubcat'])->name('general-subcategory-delete');

    Route::get('/general/purchase/general/product/create', [App\Http\Controllers\GeneralPurchase\GeneralProductController::class, 'generalproductcreate'])->name('general.product.create');
    Route::post('/general/purchase/general/product/store', [App\Http\Controllers\GeneralPurchase\GeneralProductController::class, 'generalproductstore'])->name('general.purchase.general.product.store');
    Route::get('/general/purchase/general/product/list', [App\Http\Controllers\GeneralPurchase\GeneralProductController::class, 'generalproductlist'])->name('general.product.list');
    Route::get('/general/purchase/general/product/edit/{id}', [App\Http\Controllers\GeneralPurchase\GeneralProductController::class, 'generalproductedit']);
    Route::post('/general/purchase/general/product/restore', [App\Http\Controllers\GeneralPurchase\GeneralProductController::class, 'generalproductrestore'])->name('general.purchase.general.product.restore');
	Route::delete('/general/purchase/general/product/delete', [App\Http\Controllers\GeneralPurchase\GeneralProductController::class, 'destroy'])->name('general.product.delete');

    Route::get('/general/purchase/index', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'index'])->name('general.purchase.index');
    Route::get('/general/purchase/view/{id}', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'viewganarelpurchase']);
    Route::get('/general/purchase/general/purchase/create', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'creategenerelpurchase'])->name('general.purchase.create');
    Route::post('/general/purchase/general/purchase/store', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'storegenerelpurchase'])->name('general.purchase.store');
    Route::get('/general/purchase/edit/{id}', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'editgpurchase']);
    Route::post('/general/purchase/update', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'updategpurchase'])->name('general.purchase.update');
    Route::get('/general/purchase/product/price/{id}', [App\Http\Controllers\GeneralPurchase\GeneralProductController::class, 'getgproductprice']);
  	Route::delete('/general/purchase/invoice/delete', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'deletegeneralpurchase'])->name('generalpurchase.invoice.delete');


//  Asset
    Route::get('/asset/type', [App\Http\Controllers\AssetController::class, 'assettype'])->name('asset.type');
    Route::post('/asset/type/store', [App\Http\Controllers\AssetController::class, 'storeassettype'])->name('store.asset.type');
  	Route::delete('/asset/type/delete', [App\Http\Controllers\AssetController::class, 'deleteassettype'])->name('delete.asset.type');

    Route::get('/asset/category', [App\Http\Controllers\AssetController::class, 'assetcategory'])->name('asset.category');
    Route::post('/asset/category/store', [App\Http\Controllers\AssetController::class, 'storeassetcategory'])->name('store.asset.category');
  	Route::delete('/asset/category/delete', [App\Http\Controllers\AssetController::class, 'deleteassetcategory'])->name('delete.asset.category');

    Route::get('/asset/group', [App\Http\Controllers\AssetController::class, 'assetGroup'])->name('asset.group');
    Route::post('/asset/group/store', [App\Http\Controllers\AssetController::class, 'storeAssetGroup'])->name('store.asset.group');
  	Route::delete('/asset/group/delete', [App\Http\Controllers\AssetController::class, 'deleteAssetGroup'])->name('delete.asset.group');

  Route::get('/asset/product', [App\Http\Controllers\AssetController::class, 'assetproduct'])->name('asset.product');
  Route::get('/asset/product/create', [App\Http\Controllers\AssetController::class, 'assetproductCreate'])->name('asset.product.create');
    Route::post('/asset/product/store', [App\Http\Controllers\AssetController::class, 'storeassetproduct'])->name('store.asset.product');
    Route::post('/asset/product/update', [App\Http\Controllers\AssetController::class, 'updateAssetProduct'])->name('update.asset.product');
  	Route::delete('/asset/product/delete', [App\Http\Controllers\AssetController::class, 'deleteassetproduct'])->name('delete.asset.product');

  Route::get('/asset/product/view/{id}', [App\Http\Controllers\AssetController::class, 'assetproductview'])->name('asset.product.view');


  Route::get('/asset/get/product/{cid}', [App\Http\Controllers\AssetController::class, 'assetGetproduct'])->name('asset.get.product');






    Route::get('/asset/index', [App\Http\Controllers\AssetController::class, 'index'])->name('asset.index');
    Route::get('/asset/create', [App\Http\Controllers\AssetController::class, 'createasset'])->name('asset.create');
    Route::post('/asset/store', [App\Http\Controllers\AssetController::class, 'assetstore'])->name('asset.store');
  	Route::delete('/asset/delete', [App\Http\Controllers\AssetController::class, 'assetdelete'])->name('asset.delete');
    Route::get('/asset/edit/{id}', [App\Http\Controllers\AssetController::class, 'editasset'])->name('asset.edit');
    Route::post('/asset/update', [App\Http\Controllers\AssetController::class, 'assetupdate'])->name('asset.update');
    
    Route::get('/asset/invoice/view/{id}', [App\Http\Controllers\AssetController::class, 'assetInvoiceView'])->name('asset.invoice.view');

   // Route::get('/asset/create', [App\Http\Controllers\AssetController::class, 'createasset'])->name('asset.create');
   // Route::post('/asset/store', [App\Http\Controllers\AssetController::class, 'assetstore'])->name('asset.store');

    Route::get('/asset/report/index', [App\Http\Controllers\AssetController::class, 'assetreportindex'])->name('asset.report.index');
    Route::post('/asset/report/view', [App\Http\Controllers\AssetController::class, 'viewreport'])->name('asset.report.view');

   Route::get('/asset/clint/list', [App\Http\Controllers\AssetController::class, 'ClintList'])->name('asset.clint.list');
    Route::get('/asset/clint/create', [App\Http\Controllers\AssetController::class, 'clintCreate'])->name('asset.clint.create');
    Route::post('/asset/clint/store', [App\Http\Controllers\AssetController::class, 'clintStore'])->name('asset.clint.store');
	Route::delete('/asset/clint/delete', [App\Http\Controllers\AssetController::class, 'clintdelete'])->name('asset.clint.delete');



    Route::get('/asset/short/term/libilities/list', [App\Http\Controllers\AssetController::class, 'shorttermlibilitieslist'])->name('asset.short.term.libilities.list');
    Route::get('/asset/short/term/libilities/create', [App\Http\Controllers\AssetController::class, 'shorttermlibilitiescreate'])->name('asset.short.term.libilities.create');
    Route::post('/asset/short/term/libilities/store', [App\Http\Controllers\AssetController::class, 'storeshorttermlibilitiesclient'])->name('asset.short.term.libilities.store');
	Route::delete('/asset/short/term/libilities/delete', [App\Http\Controllers\AssetController::class, 'deleteshortlc'])->name('asset.short.term.libilities.delete');

    Route::get('/asset/long/term/libilities/list', [App\Http\Controllers\AssetController::class, 'longtermlibilitieslist'])->name('asset.long.term.libilities.list');
    Route::get('/asset/long/term/libilities/create', [App\Http\Controllers\AssetController::class, 'longtermlibilitiescreate'])->name('asset.long.term.libilities.create');
    Route::post('/asset/long/term/libilities/store', [App\Http\Controllers\AssetController::class, 'storelongtermlibilitiesclient'])->name('asset.long.term.libilities.store');
  	Route::delete('/asset/long/term/libilities/delete', [App\Http\Controllers\AssetController::class, 'deletelonglc'])->name('asset.long.term.libilities.delete');


   	Route::get('/asset/investment/list', [App\Http\Controllers\AssetController::class, 'investmentList'])->name('asset.investment.list');
    Route::get('/asset/investment/create', [App\Http\Controllers\AssetController::class, 'investmentCreate'])->name('asset.investment.create');
    Route::post('/asset/investment/store', [App\Http\Controllers\AssetController::class, 'investmentStore'])->name('asset.investment.store');
	Route::delete('/asset/investment/delete', [App\Http\Controllers\AssetController::class, 'investmentdelete'])->name('asset.investment.delete');


  	Route::get('/asset/Intangible/list', [App\Http\Controllers\AssetController::class, 'IntangibleList'])->name('asset.Intangible.list');
    Route::get('/asset/Intangible/create', [App\Http\Controllers\AssetController::class, 'IntangibleCreate'])->name('asset.Intangible.create');
    Route::post('/asset/Intangible/store', [App\Http\Controllers\AssetController::class, 'IntangibleStore'])->name('asset.Intangible.store');
	Route::delete('/asset/Intangible/delete', [App\Http\Controllers\AssetController::class, 'Intangibledelete'])->name('asset.Intangible.delete');

  	Route::get('/asset/depreciation/list', [App\Http\Controllers\AssetController::class, 'assetdepreciationlist'])->name('asset.depreciation.list');
  	Route::get('/asset/depreciation/create', [App\Http\Controllers\AssetController::class, 'assetdepreciation'])->name('asset.depreciation.create');
  	Route::post('/asset/depreciation/store', [App\Http\Controllers\AssetController::class, 'assetdepreciationstore'])->name('asset.depreciation.store');
	Route::delete('/asset/depreciation/delete', [App\Http\Controllers\AssetController::class, 'depreciationdelete'])->name('asset.depreciation.delete');

  	Route::get('/asset/depreciation/get/asset/product/{asset_id}', [App\Http\Controllers\AssetController::class, 'assetdepreciationgetassetproduct']);
  	Route::get('/asset/depreciation/get/asset/details/product/{asset_id}', [App\Http\Controllers\AssetController::class, 'assetdepreciationgetassetproductdetails']);




  	Route::get('/asset/Intangible/list', [App\Http\Controllers\AssetController::class, 'IntangibleList'])->name('asset.Intangible.list');
    Route::get('/asset/Intangible/create', [App\Http\Controllers\AssetController::class, 'IntangibleCreate'])->name('asset.Intangible.create');
    Route::post('/asset/Intangible/store', [App\Http\Controllers\AssetController::class, 'IntangibleStore'])->name('asset.Intangible.store');
	Route::delete('/asset/Intangible/delete', [App\Http\Controllers\AssetController::class, 'Intangibledelete'])->name('asset.Intangible.delete');


  	Route::post('/asset/notification/confirm', [App\Http\Controllers\AssetController::class, 'assetnotificationconfirm'])->name('asset.notification.confirm');


   Route::get('/asset/license', [App\Http\Controllers\AssetController::class, 'assetlicense'])->name('asset.license');
    Route::post('/asset/type/license', [App\Http\Controllers\AssetController::class, 'storeassetlicense'])->name('store.asset.license');
  	Route::delete('/asset/type/license/delete', [App\Http\Controllers\AssetController::class, 'deleteassetlicense'])->name('delete.asset.license');


    // General Purchase Ledger
    Route::get('/general/purchase/ledger/index', [App\Http\Controllers\GeneralPurchase\GeneralPurLedgerController::class, 'ledgerindex'])->name('general.purchase.ledger.index');
    Route::post('/general/purchase/ledger/view', [App\Http\Controllers\GeneralPurchase\GeneralPurLedgerController::class, 'viewgeneralledger'])->name('general.purchase.ledger.view');

    // General Purchase  Report
    Route::get('/general/purchase/report/index', [App\Http\Controllers\GeneralPurchase\GeneralPurReportController::class, 'reportindex'])->name('general.purchase.report.index');
    Route::post('/general/purchase/report/view', [App\Http\Controllers\GeneralPurchase\GeneralPurReportController::class, 'viewreport'])->name('general.purchase.report.view');
   //Comparison Report
    Route::get('/general/purchase/comparison/report/index', [App\Http\Controllers\GeneralPurchase\GeneralPurReportController::class, 'comparisonreportindex'])->name('comparison.report.index');
    Route::post('/general/purchase/comparison/report/view', [App\Http\Controllers\GeneralPurchase\GeneralPurReportController::class, 'comparisonreportview'])->name('general.purchase.comparison.report.view');
   // General Purchase stock Report
    Route::get('/general/purchase/stock/report/index', [App\Http\Controllers\GeneralPurchase\GeneralPurReportController::class, 'stockreportindex'])->name('general.purchase.stock.report.index');
    Route::post('/general/purchase/stock/report/view', [App\Http\Controllers\GeneralPurchase\GeneralPurReportController::class, 'stockviewreport'])->name('general.purchase.stock.report.view');

  	//General total stock report
    Route::get('/general/purchase/total/stock/report/input', [App\Http\Controllers\GeneralPurchase\GeneralPurReportController::class, 'totalstockreportinput'])->name('general.purchase.total.stock.report.input');
    Route::post('/general/purchase/total/stock/report/view', [App\Http\Controllers\GeneralPurchase\GeneralPurReportController::class, 'totalstockreportview'])->name('general.purchase.total.stock.report.view');

	// General Transger
    Route::get('/general/purchase/transfer/index', [App\Http\Controllers\GeneralPurchase\GeneralTransferController::class, 'index'])->name('general.purchase.transfer.index');
    Route::get('/general/purchase/transfer/create', [App\Http\Controllers\GeneralPurchase\GeneralTransferController::class, 'createtransfer'])->name('general.purchase.transfer.create');
    Route::post('/general/purchase/transfer/store', [App\Http\Controllers\GeneralPurchase\GeneralTransferController::class, 'storetransfer'])->name('general.purchase.transfer.store');
	  Route::delete('/general/purchase/transfer/delete', [App\Http\Controllers\GeneralPurchase\GeneralTransferController::class, 'destroytransfer'])->name('generalpurchase.transfer.delete');

    // General Stock Out
    Route::get('/general/purchase/stockout/index', [App\Http\Controllers\GeneralPurchase\GeneralStockOutController::class, 'index'])->name('general.purchase.stockout.index');
    Route::get('/general/purchase/stockout/create', [App\Http\Controllers\GeneralPurchase\GeneralStockOutController::class, 'createstockout'])->name('general.purchase.stockout.create');
    Route::post('/general/purchase/stockout/store', [App\Http\Controllers\GeneralPurchase\GeneralStockOutController::class, 'storestockout'])->name('general.purchase.stockout.store');
  	Route::get('/general/purchase/stockout/edit/{id}', [App\Http\Controllers\GeneralPurchase\GeneralStockOutController::class, 'stockoutedit']);
    Route::post('/general/purchase/stockout/update', [App\Http\Controllers\GeneralPurchase\GeneralStockOutController::class, 'stockoutupdate'])->name('general.purchase.stockout.update');

  	Route::delete('/general/purchase/stockout/delete', [App\Http\Controllers\GeneralPurchase\GeneralStockOutController::class, 'deletestockout'])->name('generalpurchase.stockout.delete');

    // General StockOut Report
    Route::get('/general/stockout/report/index', [App\Http\Controllers\GeneralPurchase\GeneralStockOutController::class, 'stockoutreportindedx'])->name('general.stockout.report.index');
    Route::post('/general/stockout/report/view', [App\Http\Controllers\GeneralPurchase\GeneralStockOutController::class, 'stockoutreportview'])->name('general.stockout.report.view');

  	//General Supplier
 	Route::get('/general/purchase/supplier/index', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'generalpurchasesupplierindex'])->name('general.purchase.supplier.index');
  	Route::get('/general/purchase/supplier/create', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'generalpurchasesuppliercreate'])->name('general.purchase.supplier.create');
  	Route::post('/general/purchase/supplier/store', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'storegeneralpurchasedata'])->name('general.purchase.supplier.store');
  	Route::delete('/general/purchase/supplier/delete', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'generalsupplierdelete'])->name('general.purchase.supplier.delete');
  	Route::get('/general/purchase/supplier/edit/{id}', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'generalsupplieredit'])->name('general.purchase.supplier.edit');
  	Route::post('/general/purchase/supplier/update', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'generalpurchasesupplierupdate'])->name('general.purchase.supplier.update');

    // Ajax Route
    Route::get('/get/gsubcat/by/maincat/{id}', [App\Http\Controllers\GeneralPurchase\GeneralProductController::class, 'getsubcatbymaincat']);
    Route::get('/get/last/general/purchase/invoice', [App\Http\Controllers\GeneralPurchase\GeneralPurchaseController::class, 'getlastinvoice']);

	//Packing Consumption code Shahriar
    Route::get('/production/packing/consumption/list', [App\Http\Controllers\Production\PStockOutController::class, 'packinglist'])->name('production.packing.consumption.list');
    Route::get('/production/packing/consumption/create', [App\Http\Controllers\Production\PStockOutController::class, 'packingcreate'])->name('production.packing.consumption.create');
    Route::post('/production/packing/consumption/store', [App\Http\Controllers\Production\PStockOutController::class, 'packingstore'])->name('production.packing.consumption.store');
    Route::get('/production/packing/consumption/edit/{id}', [App\Http\Controllers\Production\PStockOutController::class, 'packingEdit'])->name('production.packing.consumption.edit');
    Route::post('/production/packing/consumption/update/{id}', [App\Http\Controllers\Production\PStockOutController::class, 'packingUpdate'])->name('production.packing.consumption.update');
    Route::delete('/production/packing/consumption/delete', [App\Http\Controllers\Production\PStockOutController::class, 'packingdelete'])->name('production.packing.consumption.delete');

    // Manual Reprocess Shahriar
    Route::get('/production/reprocess/stock/out/list', [App\Http\Controllers\Production\PStockOutController::class, 'reprocessList'])->name('reprocess.production.stock.out.list');
    Route::get('/production/reprocess/stock/out/create', [App\Http\Controllers\Production\PStockOutController::class, 'reprocesscreate'])->name('reprocess.production.stock.out.create');
  	Route::post('/production/reprocess/stock/out/store', [App\Http\Controllers\Production\PStockOutController::class, 'reprocessStore'])->name('reprocess.production.stock.out.store');
  	Route::get('/production/reprocess/stock/out/edit/{id}', [App\Http\Controllers\Production\PStockOutController::class, 'reprocessEdit'])->name('reprocess.production.stock.out.edit');
  	Route::post('/production/reprocess/stock/out/update', [App\Http\Controllers\Production\PStockOutController::class, 'reprocessUpdate'])->name('reprocess.production.stock.out.update');
  	Route::get('/production/reprocess/stock/out/delete/{id}', [App\Http\Controllers\Production\PStockOutController::class, 'reprocessDelete'])->name('reprocess.production.stock.out.delete');
    Route::get('/production/reprocess/stock/out/invoice/{id}', [App\Http\Controllers\Production\PStockOutController::class, 'reprocessInvoiceview'])->name('reprocess.production.stock.out.invoice.view');


    //SABIB

    // Production  Section
    Route::get('/production/stock/out/list', [App\Http\Controllers\Production\PStockOutController::class, 'psolist'])->name('production.stock.out.list');
    Route::get('/production/stock/out/create', [App\Http\Controllers\Production\PStockOutController::class, 'psocreate'])->name('production.stock.out.create');
    Route::post('/production/stock/out/store', [App\Http\Controllers\Production\PStockOutController::class, 'psostore'])->name('production.stock.out.store');
    Route::get('/production/stock/out/edit/{invoice}', [App\Http\Controllers\Production\PStockOutController::class, 'psoEdit'])->name('production.stock.out.edit');
    Route::post('/production/stock/out/update', [App\Http\Controllers\Production\PStockOutController::class, 'psoUpdate'])->name('production.stock.out.update');
    Route::delete('/production/stock/out/delete', [App\Http\Controllers\Production\PStockOutController::class, 'psodelete'])->name('production.stock.out.delete');
	  Route::get('/production/stock/out/newTab', [App\Http\Controllers\Production\PStockOutController::class, 'newTab'])->name('production.stock.out.newTab');

  	Route::get('/production/manual/stock/out/list', [App\Http\Controllers\Production\PStockOutController::class, 'psoListManual'])->name('manual.production.stock.out.list');
  	Route::post('/production/manual/stock/out/store', [App\Http\Controllers\Production\PStockOutController::class, 'psoStoreManual'])->name('manual.production.stock.out.store');
  	Route::get('/production/manual/fgStock/in/edit/{id}', [App\Http\Controllers\Production\PStockOutController::class, 'psoFGEdit'])->name('production.fgStock.in.edit');
  	Route::post('/production/manual/stock/out/update', [App\Http\Controllers\Production\PStockOutController::class, 'psoUpdateManual'])->name('manual.production.stock.out.update');
  	Route::get('/production/manual/fgStock/in/delete/{id}', [App\Http\Controllers\Production\PStockOutController::class, 'psoFGDelete'])->name('production.fgStock.in.delete');
  	Route::get('/production/manual/rmStock/out/delete/{id}', [App\Http\Controllers\Production\PStockOutController::class, 'psoRMDelete'])->name('production.rmStock.out.delete');
    Route::get('/production/manual/stock_in/out/invoice/{id}', [App\Http\Controllers\Production\PStockOutController::class, 'psoSTockInInvoiceview'])->name('production.manual.stock.in.invoice.view');

  	Route::get('/production/stock/out/invoice/delete/{invoice}', [App\Http\Controllers\Production\PStockOutController::class, 'psoInvoiceDelete'])->name('production.stock.out.deleteNew');

   Route::get('/auto/production/stock/out/create', [App\Http\Controllers\Production\PStockOutController::class, 'autopsocreate'])->name('auto.production.stock.out.create');
  // Route::post('/auto/production/stock/out/store', [App\Http\Controllers\Production\PStockOutController::class, 'autopsostore'])->name('auto.production.stock.out.store');


    Route::get('/production/stock/out/invoice/{invoice}', [App\Http\Controllers\Production\PStockOutController::class, 'psoinvoiceview'])->name('production.stock.out.invoice.view');
    Route::get('/production/stock/out/checkout/{invoice}', [App\Http\Controllers\Production\PStockOutController::class, 'psocheckout'])->name('production.stock.out.checkout');
    //Route::post('/production/stock/out/update', [App\Http\Controllers\Production\PStockOutController::class, 'psoupdate'])->name('production.stock.out.update');

    Route::get('stock/product/{id}',[App\Http\Controllers\Production\PStockOutController::class, 'getproductqty'])->name('get.stock.product');
    Route::get('stock/bag/{id}',[App\Http\Controllers\Production\PStockOutController::class, 'getBagStock'])->name('get.stock.bag');
    Route::get('stock/product/wip/{id}',[App\Http\Controllers\Production\PStockOutController::class, 'getProductWipQty'])->name('get.wip.product.qty');

	//production process loss $datas
  	Route::get('/production/process/loss/list', [App\Http\Controllers\Production\PStockOutController::class, 'ppLossIndex'])->name('production.process.loss.list');
	Route::post('/production/process/loss/store', [App\Http\Controllers\Production\PStockOutController::class, 'ppLossStore'])->name('production.process.loss.store');
  	Route::get('/production/process/loss/edit/{id}', [App\Http\Controllers\Production\PStockOutController::class, 'ppLossEdit'])->name('production.process.loss.edit');
  	Route::post('/production/process/loss/update', [App\Http\Controllers\Production\PStockOutController::class, 'ppLossUpdate'])->name('production.process.loss.update');
    Route::delete('/production/process/loss/delete', [App\Http\Controllers\Production\PStockOutController::class, 'ppLossDelete'])->name('production.process.loss.delete');

  	Route::get('/production/fg/set/list', [App\Http\Controllers\Production\PStockOutController::class, 'fgsetindex'])->name('production.fg.set.list');
    Route::get('/production/fg/set/create', [App\Http\Controllers\Production\PStockOutController::class, 'fgsetcreate'])->name('production.fg.set.create');
    Route::post('/production/fg/set/store', [App\Http\Controllers\Production\PStockOutController::class, 'fgsetstore'])->name('production.fg.set.store');
  	Route::get('/production/fg/set/edit/{id}', [App\Http\Controllers\Production\PStockOutController::class, 'fgsetEdit'])->name('production.fg.set.edit');
  	Route::post('/production/fg/set/update', [App\Http\Controllers\Production\PStockOutController::class, 'fgsetUpdate'])->name('production.update.fg.set');
    Route::delete('/production/fg/set/delete', [App\Http\Controllers\Production\PStockOutController::class, 'fgsetdelete'])->name('production.fg.set.delete');

  	Route::get('get/production/fg/set/{id}', [App\Http\Controllers\Production\PStockOutController::class, 'getfgsetdata'])->name('production.fg.get');


    Route::get('/production/stock/in/list', [App\Http\Controllers\Production\PStockInController::class, 'psilist'])->name('production.stock.in.list');
    Route::get('/production/stock/in/create', [App\Http\Controllers\Production\PStockInController::class, 'psicreate'])->name('production.stock.in.create');
    Route::post('/production/stock/in/store', [App\Http\Controllers\Production\PStockInController::class, 'psistore'])->name('production.stock.in.store');
    Route::delete('/production/stock/in/delete', [App\Http\Controllers\Production\PStockInController::class, 'deletestockin'])->name('production.stock.in.delete');

    Route::get('/stockin/notification/list', [App\Http\Controllers\Production\PStockInController::class, 'stockinnotificationlist'])->name('stockin.notification.list');
  	Route::get('/stockin/notification', [App\Http\Controllers\Production\PStockInController::class, 'stockinnotification'])->name('stockin.notification');
  	Route::post('/stockin/notification/store', [App\Http\Controllers\Production\PStockInController::class, 'stockinnotificationstore'])->name('stockin.notification.store');
	Route::delete('/stockin/notification/delete', [App\Http\Controllers\Production\PStockInController::class, 'notificationdelete'])->name('stockin.notification.delete');


  	Route::post('/stockin/notification/confirm', [App\Http\Controllers\Production\PStockInController::class, 'stockinnotificationconfirm'])->name('stockin.notification.confirm');


    //Costing
    Route::get('/direct/labour/cost/list', [App\Http\Controllers\CostController::class, 'labourcostlist'])->name('direct.labour.cost.list');
    Route::get('/direct/labour/cost/create', [App\Http\Controllers\CostController::class, 'labourcostcreate'])->name('direct.labour.cost.create');
    Route::post('/direct/labour/cost/store', [App\Http\Controllers\CostController::class, 'labourcoststore'])->name('direct.labour.cost.store');
    Route::get('/direct/labour/cost/edit/{id}', [App\Http\Controllers\CostController::class, 'labourcostEdit'])->name('direct.labour.cost.edit');
  	Route::post('/direct/labour/cost/update', [App\Http\Controllers\CostController::class, 'labourcostUpdate'])->name('direct.labour.cost.update');
  	Route::delete('/direct/labour/cost/delete', [App\Http\Controllers\CostController::class, 'labourcostdelete'])->name('direct.labour.cost.delete');

    Route::get('/indirect/cost/list', [App\Http\Controllers\CostController::class, 'indirectcostlist'])->name('indirect.cost.list');
    Route::get('/indirect/cost/create', [App\Http\Controllers\CostController::class, 'indiretccostcreate'])->name('indirect.cost.create');
    Route::post('/indirect/cost/store', [App\Http\Controllers\CostController::class, 'indirectcoststore'])->name('indirect.cost.store');
    Route::delete('/indirect/cost/delete', [App\Http\Controllers\CostController::class, 'indirectcostdelete'])->name('indirect.cost.delete');


    Route::get('/manufacturing/cost/list', [App\Http\Controllers\CostController::class, 'manufacturingcostlist'])->name('manufacturing.cost.list');
    Route::get('/manufacturing/cost/create', [App\Http\Controllers\CostController::class, 'manufacturingcostcreate'])->name('manufacturing.cost.create');
    Route::post('/manufacturing/cost/store', [App\Http\Controllers\CostController::class, 'manufacturingcoststore'])->name('manufacturing.cost.store');
  	Route::get('/manufacturing/cost/edit/{id}', [App\Http\Controllers\CostController::class, 'manufacturingcostEdit'])->name('manufacturing.cost.edit');
  	Route::post('/manufacturing/cost/update', [App\Http\Controllers\CostController::class, 'manufacturingcostUpdate'])->name('manufacturing.cost.update');
    Route::delete('/manufacturing/cost/delete', [App\Http\Controllers\CostController::class, 'manufacturingcostdelete'])->name('manufacturing.cost.delete');

	//New Costing by Shariar
	Route::get('/production/cost/menu', [CostController::class, 'productionCost'])->name('production.cost.menu');
	Route::get('/direct/labour/newCost/create', [CostController::class, 'labournewCostcreate'])->name('direct.labour.newCost.create');
    Route::post('/direct/labour/newCost/store', [CostController::class, 'labournewCoststore'])->name('direct.labour.newCost.store');
    Route::get('/direct/labour/newCost/edit/{id}', [CostController::class, 'labournewCostEdit'])->name('direct.labour.newCost.edit');
  	Route::post('/direct/labour/newCost/update', [CostController::class, 'labournewCostUpdate'])->name('direct.labour.newCost.update');
  	Route::delete('/direct/labour/newCost/delete', [CostController::class, 'labournewCostdelete'])->name('direct.labour.newCost.delete');

	Route::get('/manufacturing/newCost/list', [CostController::class, 'manufacturingnewCostlist'])->name('manufacturing.newCost.list');
    Route::get('/manufacturing/newCost/create', [CostController::class, 'manufacturingnewCostcreate'])->name('manufacturing.newCost.create');
    Route::post('/manufacturing/newCost/store', [CostController::class, 'manufacturingnewCoststore'])->name('manufacturing.newCost.store');
  	Route::get('/manufacturing/newCost/edit/{id}', [CostController::class, 'manufacturingnewCostEdit'])->name('manufacturing.newCost.edit');
  	Route::post('/manufacturing/newCost/update', [CostController::class, 'manufacturingnewCostUpdate'])->name('manufacturing.newCost.update');
    Route::delete('/manufacturing/newCost/delete', [CostController::class, 'manufacturingnewCostdelete'])->name('manufacturing.newCost.delete');


    //Row Materials  Scale  Section

    Route::get('row/materials/scale/index', [App\Http\Controllers\ScaleController::class, 'RowMaterialsIndex'])->name('row.materials.scale.index');
    Route::get('row/materials/scale/entry', [App\Http\Controllers\ScaleController::class, 'RowMaterialsCreate'])->name('row.materials.scale.entry');
    Route::post('row/materials/scale/generate', [App\Http\Controllers\ScaleController::class, 'RowMaterialsScalegenerate'])->name('row.materials.scale.generate');
    Route::delete('row/materials/scale/destroy', [App\Http\Controllers\ScaleController::class, 'RowMaterialsDestroy'])->name('row.materials.scale.destroy');
    Route::get('row/materials/scale/view/{id}', [App\Http\Controllers\ScaleController::class, 'RowMaterialsView'])->name('row.materials.scale.view');
    Route::get('row/materials/scale/edit/{id}', [App\Http\Controllers\ScaleController::class, 'RowMaterialsEdit'])->name('row.materials.scale.edit');
    Route::post('row/materials/scale/edit/store', [App\Http\Controllers\ScaleController::class, 'RowMaterialsEditStore'])->name('row.materials.scale.edit.store');
    Route::get('row/materials/scale/delivery/status-update/{id}', [App\Http\Controllers\ScaleController::class, 'RowMaterialsDeliveryconfirm'])->name('row.materials.scale.delivery.confirm');
    Route::get('row/materials/scale/summary', [App\Http\Controllers\ScaleController::class, 'RowMaterialsScaleSummary'])->name('row.materials.scale.summary');

    Route::get('scale/load/unload/summary', [App\Http\Controllers\ScaleController::class, 'ScaleLoadUnloadSummary'])->name('scale.load.unload.summary');







    // Report Section

    Route::get('/reports/index', [App\Http\Controllers\Report\SalesReportController::class, 'ReportsIndex'])->name('reports.index');


    Route::get('/daily/sales/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'dailysalesReportIndex'])->name('daily.sales.report.index');
    Route::post('/daily/sales/report/', [App\Http\Controllers\Report\SalesReportController::class, 'dailysalesReport'])->name('daily.sales.report');
    Route::get('/daily/sales/report/ajaxlist', [App\Http\Controllers\Report\SalesReportController::class, 'getdailysalesReportdata'])->name('daily.sales.report.ajaxlist');

  	Route::get('/daily/sales/order/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'dailySalesOrderReportIndex'])->name('daily.sales.order.report.index');
    Route::post('/daily/sales/order/report/', [App\Http\Controllers\Report\SalesReportController::class, 'dailySalesOrderReport'])->name('daily.sales.order.report');
    Route::get('/daily/sales/order/report/ajaxlist', [App\Http\Controllers\Report\SalesReportController::class, 'getdailySalesOrderReportdata'])->name('daily.sales.order.report.ajaxlist');



    Route::get('/monthly/sales/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'monthlysSSReportIndex'])->name('monthly.sales.statement.report.index');
    Route::post('/monthly/sales/report/', [App\Http\Controllers\Report\SalesReportController::class, 'monthlysSSReport'])->name('monthly.sales.statement.report');

  Route::get('/monthly/sales/report/ajaxlist', [App\Http\Controllers\Report\SalesReportController::class, 'monthlysSSReportajaxlist'])->name('monthly.sales.statement.report.ajaxlist');


    Route::get('/mr/sales/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'mrsalesReportIndex'])->name('mr.sales.statement.report.index');
    Route::post('/mr/sales/report/', [App\Http\Controllers\Report\SalesReportController::class, 'mrsalesReport'])->name('mr.sales.statement.report');


    Route::get('/zone/wise/sales/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'zonewiseSSReportIndex'])->name('zonewise.sales.statement.report.index');
    Route::post('/zone/wise/sales/report/', [App\Http\Controllers\Report\SalesReportController::class, 'zonewiseSSReport'])->name('zonewise.sales.statement.report');

    // vendor sales summary report
    Route::get('/vendor/sales/summary/report/input', [App\Http\Controllers\Report\SalesReportController::class, 'vendorsalessummaryreport'])->name('vendor.sales.summary.report.input');
    Route::post('/vendor/sales/summary/report/input/view', [App\Http\Controllers\Report\SalesReportController::class, 'vendorsalessummaryreportview'])->name('vendor.sales.summary.report.input.view');


   // Sales Progress Report (individual)
    Route::get('/sales/progress/report/individual/input', [App\Http\Controllers\Report\SalesReportController::class, 'salesprogressreportindividual'])->name('sales.progress.report.individual.input');
    Route::post('/sales/progress/report/individual/view', [App\Http\Controllers\Report\SalesReportController::class, 'salesprogressreportindividualview'])->name('sales.progress.report.individual.view');

   // Stock Trunover Report
    Route::get('/stock/trunover/report/input', [App\Http\Controllers\Report\SalesReportController::class, 'stocktrunoverreport'])->name('stock.trunover.report.input');
    Route::post('/stock/trunover/report/view', [App\Http\Controllers\Report\SalesReportController::class, 'stocktrunoverreportview'])->name('stock.trunover.report.view');



    Route::get('/yearly/vendor/sales/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'yearlyVendorSSReportIndex'])->name('yearly.vendor.sales.report.index');
    Route::post('/yearly/vendor/sales/report/', [App\Http\Controllers\Report\SalesReportController::class, 'yearlyVendorSSReport'])->name('yearly.vendor.sales.report');

	  Route::get('/yearly/vendor/daterange/sales/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'yearlyVendorDaterangeSSReportIndex'])->name('yearly.vendor.daterange.sales.report.index');
    Route::post('/yearly/vendor/daterange/sales/report/', [App\Http\Controllers\Report\SalesReportController::class, 'yearlyVendorDaterangeSSReport'])->name('yearly.vendor.daterange.sales.report');


    Route::get('/yearly/sales/statement/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'yearlySalesStatementReportIndex'])->name('yearly.sales.statement.report.index');
    Route::post('/yearly/sales/statement/report/', [App\Http\Controllers\Report\SalesReportController::class, 'yearlySalesStatementReport'])->name('yearly.sales.statement.report');



    Route::get('/monthly/employee/target/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'monthlyTargetReportIndex'])->name('monthly.employee.target.report.index');
    Route::post('/monthly/employee/target/report', [App\Http\Controllers\Report\SalesReportController::class, 'monthlyTargetReport'])->name('monthly.employee.target.report');
  	Route::get('/monthly/employee/target/item/report/{cat}/{id}/{fDate}/{tDate}', [App\Http\Controllers\Report\SalesReportController::class, 'monthlyTargetItemReport'])->name('monthly.employee.target.item.report');

  //Dealer Sales Product Wise Report
  	Route::get('/monthly/dealerSalesProduct/target/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'monthlyDealerSalesTargetReportIndex'])->name('monthly.dealer.sales.target.report.index');
    Route::post('/monthly/dealerSalesProduct/target/report', [App\Http\Controllers\Report\SalesReportController::class, 'monthlyDealerSalesTargetReport'])->name('monthly.dealer.sales.target.report');


  Route::get('/yearly/sales/target/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'yearlyTargetReportIndex'])->name('yearly.sales.target.report.index');
    Route::post('/yearly/sales/target/report', [App\Http\Controllers\Report\SalesReportController::class, 'yearlyTargetReport'])->name('yearly.sales.target.report');

    Route::get('/short/summary/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'shortSummaryReportIndex'])->name('short.summary.report.index');
    Route::post('/short/summary/report/', [App\Http\Controllers\Report\SalesReportController::class, 'shortSummaryReport'])->name('short.summary.report');
    
    
    // Brand Wise Sales By Awal (27-Jun-2024)
    Route::get('/brand/wise/sales/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'brandWiseSalesReportIndex'])->name('brand.wise.sales.report.index');
    Route::post('/brand/wise/sales/report', [App\Http\Controllers\Report\SalesReportController::class, 'brandWiseSalesReport'])->name('brand.wise.sales.report');
    // Brand Wise Sales By Awal (27-Jun-2024) End
    
    
    // Sales Category Wise Cogs R.
    Route::get('/sales/short/summary/cogs/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'salesShortSummaryCogsReportIndex'])->name('sales.short.summary.cogs.report.index');
    Route::post('/sales/short/summary/cogs/report', [App\Http\Controllers\Report\SalesReportController::class, 'salesShortSummaryCogsReport'])->name('sales.short.summary.cogs.report');
    // Sales Category Wise Cogs R.End
    
    
    // SKU Wise COGS By Awal (27-Jun-2024)
    Route::get('/sku/wise/cogs/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'skuWiseCogsReportIndex'])->name('sku.wise.cogs.report.index');
    Route::post('/sku/wise/cogs/report', [App\Http\Controllers\Report\SalesReportController::class, 'skuWiseCogsReport'])->name('sku.wise.cogs.report');
    // SKU Wise COGS By Awal (27-Jun-2024) END
    
    
    // Category Wise short summary report
    Route::get('/category/wise/summary/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'categoryWiseSummaryReportIndex'])->name('category.wise.summary.report.index');
    Route::post('/category/wise/summary/report', [App\Http\Controllers\Report\SalesReportController::class, 'categoryWiseSummaryReport'])->name('category.wise.summary.report');
    Route::get('/category/wise/short/summary/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'categoryWiseShortSummaryReportIndex'])->name('category.wise.short.summary.report.index');
    Route::post('/category/wise/short/summary/report', [App\Http\Controllers\Report\SalesReportController::class, 'categoryWiseShortSummaryReport'])->name('category.wise.short.summary.report');
    // Category Wise short summary report

  Route::get('/category/salesOrder/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'catSalesOrderReportIndex'])->name('catSales.order.report.index');
    Route::post('/category/salesOrder/report/view/', [App\Http\Controllers\Report\SalesReportController::class, 'catSalesOrderReportView'])->name('catSales.order.report.view');

    Route::get('/expasne/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'expasneReportIndex'])->name('expasne.report.index');
    Route::post('/expasne/report/', [App\Http\Controllers\Report\SalesReportController::class, 'expasneReport'])->name('expasne.report');

    Route::get('/journal/report/index', [App\Http\Controllers\Report\OtherReportController::class, 'journalReportindex'])->name('journal.report.index');
    Route::post('/journal/report/', [App\Http\Controllers\Report\OtherReportController::class, 'journalReport'])->name('journal.report');



    Route::get('/sales/trial/balance/index', [App\Http\Controllers\Report\SalesReportController::class, 'trailbalanceIndex'])->name('trail.balance.index');
    Route::post('/sales/trial/balance/', [App\Http\Controllers\Report\SalesReportController::class, 'trailbalance'])->name('trail.balance.report');

    Route::get('/sales/stock/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'stockReportIndex'])->name('sales.stock.report.index');
    Route::post('/sales/stock/report', [App\Http\Controllers\Report\SalesReportController::class, 'stockReport'])->name('sales.stock.report');

	Route::get('/sales/stock/total/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'stockTotalReportIndex'])->name('sales.stock.total.report.index');
    Route::post('/sales/stock/total/report', [App\Http\Controllers\Report\SalesReportController::class, 'stockTotalReport'])->name('sales.stock.total.report');
    Route::get('/sales/stock/total/report/list/{fdate}/{tdate}', [App\Http\Controllers\Report\SalesReportController::class, 'stockTotalReportView']);

    Route::get('/various/vendor/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'variousVendorkReportIndex'])->name('various.vendor.report.index');
    Route::post('/various/vendor/report', [App\Http\Controllers\Report\SalesReportController::class, 'variousVendorReport'])->name('various.vendor.report');


   Route::get('/zonewise/sales/pie/chart/index', [App\Http\Controllers\Report\SalesReportController::class, 'zonewisepiechartIndex'])->name('zonewise.pie.chart.index');
    Route::post('/zonewise/sales/pie/chart/', [App\Http\Controllers\Report\SalesReportController::class, 'zonewisepiechart'])->name('zonewise.pie.chart.report');

	//code by shariar

    Route::get('/emp/salesOrder/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'empSalesOrderReportIndex'])->name('emp.salesOrder.report.index');
    Route::post('/emp/salesOrder/report/view', [App\Http\Controllers\Report\SalesReportController::class, 'empSalesOrderReportView'])->name('emp.salesOrder.report');

    Route::get('/emp/orderDelivery/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'empOrderDeliveryReportIndex'])->name('emp.orderDelivery.report.index');
    Route::post('/emp/orderDelivery/report/view', [App\Http\Controllers\Report\SalesReportController::class, 'empOrderDeliveryReportView'])->name('emp.orderDelivery.report');

  	Route::get('/emp/salesDetails/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'empSalesDetailsReportIndex'])->name('emp.salesDetails.report.index');
    Route::post('/emp/salesDetails/report/view', [App\Http\Controllers\Report\SalesReportController::class, 'empSalesDetailsReportView'])->name('emp.salesDetails.report');


  	Route::get('/sales-report/yearly-short-summary-target-report-input', [App\Http\Controllers\Report\SalesReportController::class, 'SalesYearlyShortsummaryTargetReport'])->name('salesReport.Yaerly_Shortsummary_target_report_input');
      Route::post('/sales-report/yearly-short-summary-target-report-post', [App\Http\Controllers\Report\SalesReportController::class, 'postSalesYearlyShortsummaryTargetReport'])->name('salesReport.Yaerly_Shortsummary_target_report');

	Route::get('/sales-report/yearly-short-summary-company-report-input', [App\Http\Controllers\Report\SalesReportController::class, 'SalesYearlyShortsummaryCompanyReport'])->name('salesReport.Yaerly_Shortsummary_company_report_input');
      Route::post('/sales-report/yearly-short-summary-company-report-post', [App\Http\Controllers\Report\SalesReportController::class, 'postSalesYearlyShortsummaryCompanyReport'])->name('salesReport.Yaerly_Shortsummary_company_report');



   Route::get('/top/ten/dealer/index', [App\Http\Controllers\Report\SalesReportController::class, 'toptendealerreportindex'])->name('top.ten.dealer.report.index');
    Route::post('/top/ten/dealer/report/', [App\Http\Controllers\Report\SalesReportController::class, 'toptendealerreportpiechart'])->name('top.ten.dealer.report');



   Route::get('/top/ten/dealer/d/index', [App\Http\Controllers\Report\SalesReportController::class, 'toptendealerDreportindex'])->name('top.ten.dealer.d.report.index');
    Route::post('/top/ten/dealer/d/report/', [App\Http\Controllers\Report\SalesReportController::class, 'toptendealerDreport'])->name('top.ten.dealer.d.report');


     Route::get('/fiscal/year/index', [App\Http\Controllers\Report\SalesReportController::class, 'fiscalyearreportindex'])->name('fiscal.year.report.index');
    Route::post('/fiscal/year/report/', [App\Http\Controllers\Report\SalesReportController::class, 'fiscalyearreport'])->name('fiscal.year.report');

    Route::get('/fiscal/year/comparison/index', [App\Http\Controllers\Report\SalesReportController::class, 'fiscalyearComparisonreportindex'])->name('fiscal.year.comparison.report.index');
    Route::post('/fiscal/year/comparison/report/', [App\Http\Controllers\Report\SalesReportController::class, 'fiscalyearComparisonreport'])->name('fiscal.year.comparison.report');


  	Route::get('/product/comparison/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'productComparisonIndex'])->name('product.comparison.report.index');
    Route::post('/product/comparison/report', [App\Http\Controllers\Report\SalesReportController::class, 'productComparisonReport'])->name('product.comparison.report');

	//Dealer wise sales Report By  Shariar
  	Route::get('/dealer/sales/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'dealerSalesIndex'])->name('dealer.sales.report.index');
    Route::post('/dealer/sales/report/view', [App\Http\Controllers\Report\SalesReportController::class, 'dealerSalesReport'])->name('dealer.sales.report.view');

    Route::get('/sales/categoryWiseGP/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'categoryWiseGPReport'])->name('sales.categoryWiseGP.report.index');
    Route::post('/sales/categoryWiseGP/report/view', [App\Http\Controllers\Report\SalesReportController::class, 'categoryWiseGPReportView'])->name('sales.categoryWiseGP.report.view');


    //sales Discount Report
    Route::get('/sales/discount/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'salesDiscountReport'])->name('sales.discount.report.index');
    Route::post('/sales/discount/report/view', [App\Http\Controllers\Report\SalesReportController::class, 'salesDiscountReportView'])->name('sales.discount.report.view');
    
    //Transfer Report by Shariar
    Route::get('/fgStock/transfer/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'transferReportIndex'])->name('fgTransfer.report.index');
    Route::post('/fgStock/transfer/report/view', [App\Http\Controllers\Report\SalesReportController::class, 'transferReportView'])->name('fgTransfer.report.view');
    
    
    //Transfer Short Summary Report by Awal (10-Jun-2024)
    Route::get('/fgStock/transfer/short/summary/report/index', [App\Http\Controllers\Report\SalesReportController::class, 'transferShortSummaryReportIndex'])->name('fgTransfer.short.summary.report.index');
    Route::post('/fgStock/transfer/short/summary/report/view', [App\Http\Controllers\Report\SalesReportController::class, 'transferShortSummaryReportView'])->name('fgTransfer.short.summary.report.view');


	//Production Report
  	 Route::get('/production/reports', [App\Http\Controllers\Report\PurchaseReportController::class, 'productionReports'])->name('production.reports');

  	//Dailay Production Summary Report
  	 Route::get('/daily/production/summary/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'dailyProductionSummaryReportIndex'])->name('daily.production.summary.details.report.index');
     Route::post('/daily/production/summary/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'dailyProductionSummaryReportView'])->name('daily.production.summary.details.report.view');

    //Purchase Report
    Route::get('/purchase/reports', [App\Http\Controllers\Report\PurchaseReportController::class, 'purchaseReports'])->name('purchase.reports');


    Route::get('/purchase/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'purchaseReportIndex'])->name('purchase.report.index');
    Route::post('/purchase/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'purchaseReport'])->name('purchase.report');

    Route::get('/bag/purchase/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'bagpurchaseReportIndex'])->name('bag.purchase.report.index');
    Route::post('bag/purchase/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'bagpurchaseReport'])->name('bag.purchase.report');



    Route::get('/monthly/purchase/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'monthlypurchaseReportIndex'])->name('monthly.purchase.report.index');
    Route::post('/monthly/purchase/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'monthlypurchaseReport'])->name('monthly.purchase.report');

    Route::get('/yearly/purchase/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'yearlypurchaseReportIndex'])->name('yearly.purchase.report.index');
    Route::post('/yearly/purchase/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'yearlypurchaseReport'])->name('yearly.purchase.report');

    Route::get('/purchase/stock/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'stockReportIndex'])->name('purchase.stock.report.index');
    Route::post('/purchase/stock/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'stockReport'])->name('purchase.stock.report');

    Route::get('/purchase/inventory/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'inventoryReportIndex'])->name('purchase.inventory.report.index');
    Route::post('/purchase/inventory/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'inventoryReport'])->name('purchase.inventory.report');

  //code by Shariar
    Route::get('/purchase/clpo/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'clpoReportIndex'])->name('clpo.report.index');
    Route::post('/purchase/clpo/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'clpoPurchaseReport'])->name('clpo.report');

	Route::get('/purchase/delivery/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'purchaseDeliveryReportIndex'])->name('purchase.delivery.report.index');
    Route::post('/purchase/delivery/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'purchaseDeliveryReport'])->name('purchase.delivery.report');


    Route::get('/production/stockout/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'stockoutReportIndex'])->name('production.stockout.report.index');
    Route::post('/production/stockout/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'stockoutReport'])->name('production.stockout.report');

    Route::get('/individual/production/stockout/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'individualStockoutReportIndex'])->name('individual.production.stockout.report.index');
    Route::post('/individual/production/stockout/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'individualStockoutReportView'])->name('individual.production.stockout.report');

    Route::get('/production/progress/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'PprogressReportIndex'])->name('production.progress.report.index');
    Route::post('/production/progress/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'PprogressReport'])->name('production.progress.report');


    Route::get('/production/cogm/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'cogmReportIndex'])->name('production.cogm.report.index');
    Route::post('/production/cogm/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'cogmReport'])->name('production.cogm.report');

  //newCOGM Report by Shariar
	Route::get('/production/newCogm/report/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'newCogmReportIndex'])->name('production.newCogm.report.index');
    Route::post('/production/newCogm/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'newCogmReport'])->name('production.newCogm.report');

  	//Product History Stock Ledger
  	Route::get('/product/history/stock/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'producthistorystockindex'])->name('product.history.stock.index');
  	Route::post('/product/history/stock/view', [App\Http\Controllers\Report\PurchaseReportController::class, 'viewproducthistorystockreport'])->name('product.history.stock.reportview');
    // Other Reports
    Route::get('/cogs/report', [App\Http\Controllers\Report\OtherReportController::class, 'cogsreport'])->name('cogs.report');
    Route::post('/cogs/report/view', [App\Http\Controllers\Report\OtherReportController::class, 'cogsreportview'])->name('cogs.report.view');

    Route::get('sales/cogs/report', [App\Http\Controllers\Report\OtherReportController::class, 'salescogsreport'])->name('sales.cogs.report');
    //Route::post('sales/cogs/report/view', [App\Http\Controllers\Report\OtherReportController::class, 'salescogsreportview'])->name('sales.cogs.report.view');
    Route::post('sales/cogs/report/view', [App\Http\Controllers\Report\OtherReportController::class, 'salesAllCogsReportView'])->name('sales.cogs.report.view');


   Route::get('/top/ten/purchase/index', [App\Http\Controllers\Report\PurchaseReportController::class, 'toptenpurchasereportindex'])->name('top.ten.purchase.report.index');
    Route::post('/top/ten/purchase/report/', [App\Http\Controllers\Report\PurchaseReportController::class, 'toptenpurchasereportpiechart'])->name('top.ten.purchase.report');





 Route::get('user/setting/list', [App\Http\Controllers\UserController::class, 'userList'])->name('user.setting.list');
    Route::get('user/setting/create', [App\Http\Controllers\UserController::class, 'userCreate'])->name('user.setting.create');
    Route::post('user/setting/store', [App\Http\Controllers\UserController::class, 'UserStore'])->name('user.setting.store');
    Route::delete('user/setting/delete', [App\Http\Controllers\UserController::class, 'Userdelete'])->name('user.setting.delete');

 Route::get('user/password/change/index', [App\Http\Controllers\UserController::class, 'passwordchangeindex'])->name('user.password.password.index');
 Route::post('user/password/change', [App\Http\Controllers\UserController::class, 'passwordchange'])->name('user.password.change');

    Route::get('get/employee/{id}', [App\Http\Controllers\UserController::class, 'getemp'])->name('get.emp.user');

    Route::get('user/setting/set/permission/{id}', [App\Http\Controllers\UserController::class, 'userSetPermission'])->name('user.setting.set.permission');
    Route::post('user/setting/set/permission/store', [App\Http\Controllers\UserController::class, 'userSetPermissionStore'])->name('user.setting.set.permission.store');

    Route::get('user/notification/', [App\Http\Controllers\UserController::class, 'userNotification'])->name('user.notification');
    Route::post('user/notification/store', [App\Http\Controllers\UserController::class, 'userNotificationStore'])->name('user.notification.store');

    Route::get('user/chat/list', [App\Http\Controllers\UserController::class, 'chatlist'])->name('user.chat.list');
    Route::get('user/chat/create', [App\Http\Controllers\UserController::class, 'chatCreate'])->name('user.chat.create');
    Route::post('user/chat/store', [App\Http\Controllers\UserController::class, 'chatStore'])->name('user.chat.store');
    Route::post('user/chat/seen/', [App\Http\Controllers\UserController::class, 'chatSeen'])->name('user.chat.seen');
  	Route::get('user/chat/edit/{id}/{user}', [App\Http\Controllers\UserController::class, 'chatEdit'])->name('user.chat.edit');
  	Route::post('user/chat/approved/{id}', [App\Http\Controllers\UserController::class, 'approved'])->name('user.chat.approved');
    Route::get('user/chat/view/{id}', [App\Http\Controllers\UserController::class, 'chatView'])->name('user.chat.view');
    Route::get('user/chat/again/edit/{id}', [App\Http\Controllers\UserController::class, 'chatAgainEdit'])->name('user.chat.again.edit');
    Route::post('user/chat/updated', [App\Http\Controllers\UserController::class, 'chatUpdate'])->name('user.chat.update');


    Route::post('user/theme/mood/', [App\Http\Controllers\UserController::class, 'thememood'])->name('user.theme.mood');

    Route::get('/requisition/approve/checkboxItem/index', [App\Http\Controllers\UserController::class, 'checkBoxIndex'])->name('user.approve.checkBox.index');
    Route::post('/requisition/approve/checkboxItem/store', [App\Http\Controllers\UserController::class, 'checkBoxStore'])->name('user.approve.checkBox.store');
    Route::get('/requisition/approve/checkboxItem/edit/{id}', [App\Http\Controllers\UserController::class, 'checkBoxEdit']);
    Route::post('/requisition/approve/checkboxItem/update/{id}', [App\Http\Controllers\UserController::class, 'checkBoxUpdate']);
    Route::delete('/requisition/approve/checkboxItem/delete', [App\Http\Controllers\UserController::class, 'checkBoxDelete'])->name('user.approve.checkBox.delete');


  //Vehicle Section

   Route::get('/vehicle/category', [App\Http\Controllers\VehicleController::class, 'categoryCreate'])->name('vehicle.category');
    Route::post('/vehicle/category/store', [App\Http\Controllers\VehicleController::class, 'categoryStore'])->name('store.category.store');
  	Route::delete('/vehicle/category/delete', [App\Http\Controllers\VehicleController::class, 'deleteCategory'])->name('delete.vehicle.category');

    Route::get('/vehicle/list', [App\Http\Controllers\VehicleController::class, 'index'])->name('vehicle.list');
    Route::get('/vehicle/create', [App\Http\Controllers\VehicleController::class, 'create'])->name('vehicle.create');
    Route::post('/vehicle//store', [App\Http\Controllers\VehicleController::class, 'store'])->name('vehicle.store');
  	Route::delete('/vehicle//delete', [App\Http\Controllers\VehicleController::class, 'delete'])->name('delete.vehicle');


    Route::get('/driver/list', [App\Http\Controllers\VehicleController::class, 'driverindex'])->name('driver.list');
    Route::get('/driver/create', [App\Http\Controllers\VehicleController::class, 'drivercreate'])->name('driver.create');
    Route::post('/driver/store', [App\Http\Controllers\VehicleController::class, 'driverstore'])->name('driver.store');
  	Route::delete('/driver/delete', [App\Http\Controllers\VehicleController::class, 'driverdelete'])->name('delete.driver');

  	//Vehical Commission
    /**Route::get('/commission/list', [App\Http\Controllers\VehicleController::class, 'commissionIndex'])->name('commission.list');
    Route::get('/commission/create', [App\Http\Controllers\VehicleController::class, 'commissionCreate'])->name('commission.create');
    Route::post('/commission/store', [App\Http\Controllers\VehicleController::class, 'commissionStore'])->name('commission.store');
    Route::get('/commission/edit/{id}', [App\Http\Controllers\VehicleController::class, 'commissionEdit'])->name('commission.edit');
    Route::post('/commission/update', [App\Http\Controllers\VehicleController::class, 'commissionUpdate'])->name('commission.update');
  	Route::delete('/commission/delete', [App\Http\Controllers\VehicleController::class, 'commissionDelete'])->name('commission.driver'); */

    Route::get('/trip/list', [App\Http\Controllers\VehicleController::class, 'tripindex'])->name('trip.list');
    Route::get('/trip/create', [App\Http\Controllers\VehicleController::class, 'tripcreate'])->name('trip.create');
    Route::post('/trip/store', [App\Http\Controllers\VehicleController::class, 'tripstore'])->name('trip.store');
  	Route::delete('/trip/delete', [App\Http\Controllers\VehicleController::class, 'tripdelete'])->name('trip.delete');

    Route::get('/add/trip/expanse/{id}', [App\Http\Controllers\VehicleController::class, 'addtripexpanse']);
    Route::post('/trip/expanse/store', [App\Http\Controllers\VehicleController::class, 'storetripexpanse'])->name('trip.expanse.store');
    Route::get('/view/trip/expanse/{id}', [App\Http\Controllers\VehicleController::class, 'viewtripexpanse']);

  	//Vehicle expanse
  	/*Route::get('/add/allvehicles/expense/create', [App\Http\Controllers\VehicleController::class, 'addallvehicleexpense'])->name('add.allvahicles.expense.create');
  	Route::post('/allvehicles/expense/store', [App\Http\Controllers\VehicleController::class, 'storeAllVehicleExpense'])->name('vehicles.expanse.store'); */

   Route::get('/trip/report/index', [App\Http\Controllers\VehicleController::class, 'tripreportindex'])->name('trip.report.index');
   Route::post('/trip/report', [App\Http\Controllers\VehicleController::class, 'tripreport'])->name('trip.report');

   Route::get('/total/trip/report/index', [App\Http\Controllers\VehicleController::class, 'totaltripreportindex'])->name('total.trip.report.index');
   Route::post('/total/trip/report/view', [App\Http\Controllers\VehicleController::class, 'totaltripreportview'])->name('total.trip.report.view');



 // new add

   Route::get('/machine/list', [App\Http\Controllers\MachineController::class, 'index'])->name('machine.list');
    Route::get('/machine/create', [App\Http\Controllers\MachineController::class, 'create'])->name('machine.create');
    Route::post('/machine/store', [App\Http\Controllers\MachineController::class, 'store'])->name('machine.store');
  	 Route::get('/machine/edit/{id}', [App\Http\Controllers\MachineController::class, 'edit'])->name('machine.edit');
    Route::post('/machine/update', [App\Http\Controllers\MachineController::class, 'update'])->name('machine.update');
  	Route::delete('/machine/delete', [App\Http\Controllers\MachineController::class, 'delete'])->name('delete.machine');


   Route::get('/meter/list', [App\Http\Controllers\MeterController::class, 'index'])->name('meter.list');
    Route::get('/meter/create', [App\Http\Controllers\MeterController::class, 'create'])->name('meter.create');
    Route::post('/meter/store', [App\Http\Controllers\MeterController::class, 'store'])->name('meter.store');
  	 Route::get('/meter/edit/{id}', [App\Http\Controllers\MeterController::class, 'edit'])->name('meter.edit');
    Route::post('/meter/update', [App\Http\Controllers\MeterController::class, 'update'])->name('meter.update');
  	Route::delete('/meter/delete', [App\Http\Controllers\MeterController::class, 'delete'])->name('delete.meter');

    Route::get('/meter/reading/list', [App\Http\Controllers\MeterController::class, 'meterreadingindex'])->name('meter.reading.list');
    Route::get('/meter/reading/create', [App\Http\Controllers\MeterController::class, 'meterreadingcreate'])->name('meter.reading.create');
    Route::post('/meter/reading/store', [App\Http\Controllers\MeterController::class, 'meterreadingstore'])->name('meter.reading.store');
  	 Route::get('/meter/reading/edit/{id}', [App\Http\Controllers\MeterController::class, 'meterreadingedit'])->name('meter.reading.edit');
    Route::post('/meter/reading/update', [App\Http\Controllers\MeterController::class, 'meterreadingupdate'])->name('meter.reading.update');
  	Route::delete('/meter/reading/delete', [App\Http\Controllers\MeterController::class, 'meterreadingdelete'])->name('delete.meter.reading');

  //CRM

   //Client

Route::get('/client/index', [App\Http\Controllers\CRM\ClientController::class, 'index'])->name('client.index');
Route::get('/client/create', [App\Http\Controllers\CRM\ClientController::class, 'create'])->name('client.create');
Route::post('/client/store', [App\Http\Controllers\CRM\ClientController::class, 'store'])->name('client.store');
Route::get('/client/edit/{id}', [App\Http\Controllers\CRM\ClientController::class, 'edit']);
Route::post('/client/update', [App\Http\Controllers\CRM\ClientController::class, 'update'])->name('client.update');
Route::delete('/client/delete/', [App\Http\Controllers\CRM\ClientController::class, 'destroy']);


Route::get('/progress/index', [App\Http\Controllers\CRM\CRMController::class, 'index'])->name('progress.index');
Route::get('/progress/create', [App\Http\Controllers\CRM\CRMController::class, 'create'])->name('progress.create');
Route::post('/progress/store', [App\Http\Controllers\CRM\CRMController::class, 'progressStore'])->name('progress.store');
Route::delete('/delete/progress', [App\Http\Controllers\CRM\CRMController::class, 'deleteProgress'])->name('delete.progress');
Route::get('/view/progress/{id}', [App\Http\Controllers\CRM\CRMController::class, 'viewprogress'])->name('view.progress');

Route::get('/progress/report/index', [App\Http\Controllers\CRM\CRMController::class, 'progressReportIndex'])->name('progress.report.index');
Route::post('/progress/report/view', [App\Http\Controllers\CRM\CRMController::class, 'viewprogressReport'])->name('progress.report.view');


  Route::get('/client/requirement/index', [App\Http\Controllers\CRM\CRMController::class, 'CRindex'])->name('client.requirement.index');
Route::get('/client/requirement/create', [App\Http\Controllers\CRM\CRMController::class, 'CRcreate'])->name('client.requirement.create');
Route::post('/client/requirement/store', [App\Http\Controllers\CRM\CRMController::class, 'CRstore'])->name('client.requirement.store');
Route::get('/client/requirement/edit/{id}', [App\Http\Controllers\CRM\CRMController::class, 'CRedit']);
Route::post('/client/requirement/update', [App\Http\Controllers\CRM\CRMController::class, 'CRupdate'])->name('client.requirement.update');
Route::delete('/client/requirement/delete/', [App\Http\Controllers\CRM\CRMController::class, 'CRdestroy']);
Route::post('/client/requirement/assign/', [App\Http\Controllers\CRM\CRMController::class, 'CRassign']);
Route::post('/client/requirement/feedback/', [App\Http\Controllers\CRM\CRMController::class, 'CRfeedback']);


Route::get('/view/requirement/{id}', [App\Http\Controllers\CRM\CRMController::class, 'viewrequirement'])->name('view.requirement');

  Route::get('/requirement/report/index', [App\Http\Controllers\CRM\CRMController::class, 'requirementReportIndex'])->name('requirement.report.index');
Route::post('/requirement/report/view', [App\Http\Controllers\CRM\CRMController::class, 'viewrequirementReport'])->name('requirement.report.view');

//Quality Control
Route::get('purchase/qualitycontrol/list', [QualityControlController::class, 'qualityControlList'])->name('qualityControlList');
Route::get('purchase/qualitycontrol/create', [QualityControlController::class, 'qualityControlCreate'])->name('qualityControl.create');
Route::post('purchase/qualitycontrol/store', [QualityControlController::class, 'qualityControlStore'])->name('qualityControl.store');
Route::get('purchase/qualitycontrol/edit/{id}', [QualityControlController::class, 'qualityControlEdit'])->name('qualityControl.edit');
Route::post('purchase/qualitycontrol/update/{id}', [QualityControlController::class, 'qualityControlUpdate'])->name('qualityControl.update');
Route::delete('purchase/qualitycontrol/delete', [QualityControlController::class, 'qualityControlDelete'])->name('qualityControl.delete');
Route::get('purchase/qualitycontrol/view/{id}', [QualityControlController::class, 'qualityControlView'])->name('qualityControl.view');

Route::get('purchase/qualitycontrol/parameter/create', [QualityControlController::class, 'qcParameterCreate'])->name('qc.parameter.create');
Route::post('purchase/qualitycontrol/parameter/store', [QualityControlController::class, 'qcParameterStore'])->name('qc.parameter.store');
Route::get('purchase/qualitycontrol/parameter/edit/{id}', [QualityControlController::class, 'qcParameterEdit'])->name('qc.parameter.edit');
Route::post('purchase/qualitycontrol/parameter/update/{id}', [QualityControlController::class, 'qcParameterUpdate'])->name('qc.parameter.update');
Route::delete('purchase/qualitycontrol/parameter/delete', [QualityControlController::class, 'qcParameterDelete'])->name('qc.parameter.delete');

  Route::get('purchase/qualitycontrol/getParameter/value/{id}', [QualityControlController::class, 'qcParameterValue'])->name('qc.parameter.value');

//F.G. Quality Control

Route::get('purchase/fgqualitycontrol/list', [QualityControlController::class, 'fgQualityControlList'])->name('fgQualityControlList');
Route::get('purchase/fgqualitycontrol/create', [QualityControlController::class, 'fgQualityControlCreate'])->name('fgQualityControl.create');
Route::post('purchase/fgqualitycontrol/store', [QualityControlController::class, 'fgQualityControlStore'])->name('fgQualityControl.store');
Route::get('purchase/fgQualitycontrol/edit/{id}', [QualityControlController::class, 'fgQualityControlEdit'])->name('fgQualityControl.edit');
Route::post('purchase/fgQualitycontrol/update/{id}', [QualityControlController::class, 'fgQualityControlUpdate'])->name('fgQualityControl.update');
Route::delete('purchase/fgqualitycontrol/delete', [QualityControlController::class, 'fgQualityControlDelete'])->name('fgQualityControl.delete');
Route::get('purchase/fgqualitycontrol/view/{id}', [QualityControlController::class, 'fgQualityControlView'])->name('fgQualityControl.view');

Route::get('purchase/fgqualitycontrol/parameter/create', [QualityControlController::class, 'fgQcParameterCreate'])->name('fg.qc.parameter.create');
Route::post('purchase/fgqualitycontrol/parameter/store', [QualityControlController::class, 'fgQcParameterStore'])->name('fg.qc.parameter.store');
Route::get('purchase/fgqualitycontrol/parameter/edit/{id}', [QualityControlController::class, 'fgQcParameterEdit'])->name('fg.qc.parameter.edit');
Route::post('purchase/fgqualitycontrol/parameter/update/{id}', [QualityControlController::class, 'fgQcParameterUpdate'])->name('fg.qc.parameter.update');
Route::delete('purchase/fgqualitycontrol/parameter/delete', [QualityControlController::class, 'fgQcParameterDelete'])->name('fg.qc.parameter.delete');

  Route::get('purchase/fgQualitycontrol/getParameter/value/{id}', [QualityControlController::class, 'fgQcParameterValue'])->name('fg.qc.parameter.value');

Route::get('purchase/rfq/list', [RfqController::class, 'index'])->name('rfq.list');
Route::get('purchase/rfq/create', [RfqController::class, 'create'])->name('rfq.create');
Route::post('purchase/rfq/store', [RfqController::class, 'store'])->name('rfq.store');
Route::get('purchase/rfq/view/{id}', [RfqController::class, 'show'])->name('rfq.view');
Route::get('purchase/rfq/edit/{id}', [RfqController::class, 'edit'])->name('rfq.edit');
Route::post('purchase/rfq/update/{id}', [RfqController::class, 'update'])->name('rfq.update');
Route::delete('purchase/rfq/delete', [RfqController::class, 'destroy'])->name('rfq.delete');

Route::get('get/supplier/{id}', [RfqController::class, 'getSupplier']);

Route::get('purchase/cs/list', [CsController::class, 'index'])->name('cs.list');
Route::get('purchase/cs/create', [CsController::class, 'create'])->name('cs.create');
Route::post('purchase/cs/store', [CsController::class, 'store'])->name('cs.store');
Route::get('purchase/cs/view/{id}', [CsController::class, 'show'])->name('cs.view');
Route::get('purchase/cs/edit/{id}', [CsController::class, 'edit'])->name('cs.edit');
Route::post('purchase/cs/update/{id}', [CsController::class, 'update'])->name('cs.update');
Route::delete('purchase/cs/delete', [CsController::class, 'destroy'])->name('cs.delete');

//Gallery
  Route::get('gallery/view/all', [GalleryController::class, 'gallery'])->name('gallery');
  Route::delete('gallery/delete/{id}', [GalleryController::class, 'destroy'])->name('gallery.delete');

  Route::get('purchase/WeeklyProductionForcasting/list', [WeeklyProductionForcasting::class, 'index'])->name('wpf.list');
  Route::get('purchase/WeeklyProductionForcasting/create', [WeeklyProductionForcasting::class, 'create'])->name('wpf.create');
  Route::post('purchase/WeeklyProductionForcasting/store', [WeeklyProductionForcasting::class, 'store'])->name('wpf.store');
  Route::get('purchase/WeeklyProductionForcasting/view/{id}', [WeeklyProductionForcasting::class, 'show'])->name('wpf.view');
  Route::get('purchase/WeeklyProductionForcasting/edit/{id}', [WeeklyProductionForcasting::class, 'edit'])->name('wpf.edit');
  Route::post('purchase/WeeklyProductionForcasting/update/{id}', [WeeklyProductionForcasting::class, 'update'])->name('wpf.update');
  Route::delete('purchase/WeeklyProductionForcasting/delete', [WeeklyProductionForcasting::class, 'destroy'])->name('wpf.delete');

//Marketing
//Marketing Team
Route::get('/marketing/item/index', [App\Http\Controllers\CRM\MarketingProductController::class, 'index'])->name('marketing.item.index');
Route::get('/marketing/item/create', [App\Http\Controllers\CRM\MarketingProductController::class, 'create'])->name('marketing.item.create');
Route::post('/marketing/item/store', [App\Http\Controllers\CRM\MarketingProductController::class, 'store'])->name('marketing.item.store');
Route::get('/marketing/item/edit/{id}', [App\Http\Controllers\CRM\MarketingProductController::class, 'edit']);
Route::post('/marketing/item/update/{id}', [App\Http\Controllers\CRM\MarketingProductController::class, 'update']);
Route::delete('/marketing/item/delete', [App\Http\Controllers\CRM\MarketingProductController::class, 'delete'])->name('marketing.item.delete');

//Inter company
Route::get('/inter/company/index', [App\Http\Controllers\CRM\MarketingProductController::class, 'indexInterCompany'])->name('inter.company.index');
Route::get('/inter/company/create', [App\Http\Controllers\CRM\MarketingProductController::class, 'createInterCompany'])->name('inter.company.create');
Route::post('/inter/company/store', [App\Http\Controllers\CRM\MarketingProductController::class, 'storeInterCompany'])->name('inter.company.store');
Route::get('/inter/company/edit/{id}', [App\Http\Controllers\CRM\MarketingProductController::class, 'editInterCompany']);
Route::post('/inter/company/update/{id}', [App\Http\Controllers\CRM\MarketingProductController::class, 'updateInterCompany']);
Route::delete('/inter/company/delete', [App\Http\Controllers\CRM\MarketingProductController::class, 'deleteInterCompany'])->name('inter.company.delete');

Route::get('/marketing/order/item/index', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'index'])->name('marketingOrder.item.index');
Route::get('/marketing/order/item/create', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'create'])->name('marketingOrder.item.create');
Route::post('/marketing/order/item/store', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'store'])->name('marketingOrder.item.store');
Route::get('/marketing/order/item/edit/{id}', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'edit']);
Route::post('/marketing/order/item/update/{id}', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'update']);
Route::delete('/marketing/order/item/delete', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'delete'])->name('marketingOrder.item.delete');

Route::post('/marketing/order/item/ststus/update/{id}', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'updateStatus'])->name('marketingOrder.item.ststus.update');
Route::get('/marketing/order/item/invoice/view/{id}', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'invoiceView'])->name('marketingOrder.item.View');
Route::get('/marketing/order/item/invoice/{id}', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'invoiceNotificationView'])->name('marketingOrder.item.invoiceView');
Route::get('/marketing/order/item/SpecificationData/{id}', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'getSpecificationData'])->name('marketingOrder.item.SpecificationData');

Route::get('/marketing/item/order/traking/list', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'marketingOrderTrackingIndex'])->name('marketingOrder.tracking.index');
Route::get('/marketing/item/order/traking/create', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'marketingOrderTrackingCreate'])->name('marketingOrder.tracking.create');
Route::post('/marketing/item/order/traking/store', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'marketingOrderTrackingStore'])->name('marketingOrder.tracking.store');
Route::get('/marketing/item/order/traking/edit/{invoice}', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'marketingOrderTrackingEdit'])->name('marketingOrder.tracking.edit');
Route::post('/marketing/item/order/traking/update', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'marketingOrderTrackingUpdate'])->name('marketingOrder.tracking.update');
Route::post('/marketing/item/order/traking/invoice', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'getMarketingOrderTrackingInvoice'])->name('get.marketingOrder.tracking.invoice');
Route::get('/marketing/item/order/traking/invoice/{invoice}', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'marketingOrderTrackingInvoice'])->name('marketingOrder.tracking.invoice');
Route::get('/marketing/item/purchaseOrder/getId/{id}', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'getPurchaseOrderTrackingId']);

Route::get('/marketing/order/item/invoiceNumber', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'invoiceNumber']);
Route::get('/get/product/data/{id}', [App\Http\Controllers\CRM\MarketingProductController::class, 'getproductdata']);

Route::get('/marketing/order/qc/list', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'marketingListQc'])->name('marketingQualityControlList');
Route::get('/marketing/order/qc/create', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'createQc'])->name('marketingOrder.qc.create');
Route::post('/marketing/order/qc/store', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'storeQc'])->name('marketingOrder.cq.store');
Route::delete('/marketing/order/qc/delete', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'deleteQc'])->name('marketingOrder.qc.delete');
//Product Specification Head

//Marketing Order Report
Route::get('/marketing/order/report/index', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'marketingReportIndex'])->name('marketingOrder.report.index');
Route::post('/marketing/order/report/reportView', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'marketingReportView'])->name('marketingOrder.report.view');


//Inter company
Route::get('/product/specification/head/index', [App\Http\Controllers\CRM\MarketingProductController::class, 'indexSpecificationHead'])->name('specification.head.index');
//Route::get('/product/specification/head/create', [App\Http\Controllers\CRM\MarketingProductController::class, 'createSpecificationHead'])->name('specification.head.create');
Route::post('/product/specification/head/store', [App\Http\Controllers\CRM\MarketingProductController::class, 'storeSpecificationHead'])->name('specification.head.store');
Route::get('/product/specification/head/edit/{id}', [App\Http\Controllers\CRM\MarketingProductController::class, 'editSpecificationHead']);
Route::post('/product/specification/head/update/{id}', [App\Http\Controllers\CRM\MarketingProductController::class, 'updateSpecificationHead']);
Route::delete('/product/specification/head/delete', [App\Http\Controllers\CRM\MarketingProductController::class, 'deleteSpecificationHead'])->name('specification.head.delete');


//Individual Account
Route::get('account/individual/list', [IndividualAccountController::class, 'index'])->name('individual.account.list');
Route::get('account/individual/create', [IndividualAccountController::class, 'create'])->name('individual.account.create');
Route::post('account/individual/store', [IndividualAccountController::class, 'store'])->name('individual.account.store');
Route::delete('account/individual/delete', [IndividualAccountController::class, 'destroy'])->name('individual.account.delete');

Route::get('account/sub-sub/list', [SubSubAccountController::class, 'index'])->name('sub.sub.account.list');
Route::get('account/sub-sub/create', [SubSubAccountController::class, 'create'])->name('sub.sub.account.create');
Route::post('account/sub-sub/store', [SubSubAccountController::class, 'store'])->name('sub.sub.account.store');
Route::delete('account/sub-sub/delete', [SubSubAccountController::class, 'destroy'])->name('sub.sub.account.delete');

Route::get('account/sub/list', [SubAccountController::class, 'index'])->name('sub.account.list');
Route::get('account/sub/create', [SubAccountController::class, 'create'])->name('sub.account.create');
Route::post('account/sub/store', [SubAccountController::class, 'store'])->name('sub.account.store');
Route::delete('account/sub/delete', [SubAccountController::class, 'destroy'])->name('sub.account.delete');

Route::get('account/chat-of-account/list', [ChartOfAccountController::class, 'index'])->name('chat.of.account.list');
Route::get('account/chat-of-account/trail/balance/input', [ChartOfAccountController::class, 'inputTrailBalanceSheet'])->name('chat.of.account.trail.balance.input');
Route::get('account/chat-of-account/trail-balance', [ChartOfAccountController::class, 'getTrailBalanceSheet'])->name('chat.of.account.trail.balance');
Route::get('account/chat-of-account/balance/sheet/input', [ChartOfAccountController::class, 'inputBalanceSheet'])->name('chat.of.account.balance.sheet.input');
Route::get('account/chat-of-account/balance-sheet', [ChartOfAccountController::class, 'balanceSheet'])->name('chat.of.account.balance.sheet');
Route::get('account/chat-of-account/depreciation', [ChartOfAccountController::class, 'getDepreciation'])->name('get.chat.of.account.depreciation');
Route::get('account/chat-of-account/depreciation/update/{id}', [ChartOfAccountController::class, 'storeDepreciation'])->name('update.chat.of.account.depreciation');


Route::post('account/chat-of-account/trail-balance', [ChartOfAccountController::class, 'getComparedTrailBalanceSheet'])->name('chat.of.account.compared.trail.balance');

//compared Balance sheet
Route::get('account/chat-of-account/compared/balance/sheet/input', [ChartOfAccountController::class, 'inputComparedBalanceSheet'])->name('chat.of.account.compared.balance.sheet.input');
Route::get('account/chat-of-account/compared/balance-sheet', [ChartOfAccountController::class, 'comparedBalanceSheet'])->name('chat.of.account.compared.balance.sheet');

//Lc
Route::get('/lc/import/entry/list', [LcController::class, 'lcEntryIndex'])->name('lcEntryIndex');
Route::get('/lc/import/entry/create', [LcController::class, 'lcEntryCreate'])->name('lcEntry.create');
Route::post('/lc/import/entry/store', [LcController::class, 'lcEntryStore'])->name('lcEntry.store');
Route::delete('/lc/import/entry/delete', [LcController::class, 'lcEntryDelete'])->name('lcEntry.delete');
Route::get('/lc/import/entry/invoice/{id}', [LcController::class, 'lcEntryInvoice'])->name('lcEntry.invoice');

Route::get('/lc/entry/report/index', [LcController::class, 'lcEntryReportIndex'])->name('lcEntry.report.index');
Route::post('/lc/entry/report/view', [LcController::class, 'lcEntryReportView'])->name('lcEntry.report.view');

Route::get('/import/lcGroup/item/list', [LcController::class, 'lcGroupIndex'])->name('lcGroupIndex');
//Route::get('/import/lcGroup/item//create', [App\Http\Controllers\CRM\MarketingOrderItemController::class, 'createQc'])->name('marketingOrder.qc.create');
Route::post('/import/lcGroup/item/store', [LcController::class, 'lcGroupStore'])->name('lcGroup.store');
Route::delete('/import/lcGroup/item/delete', [LcController::class, 'lcGroupDelete'])->name('lcGroup.delete');

Route::get('/import/lcLedger/item/list', [LcController::class, 'lcLedgerIndex'])->name('lcLedgerIndex');
Route::post('/import/lcLedger/item/store', [LcController::class, 'lcLedgerStore'])->name('lcLedger.store');
Route::delete('/import/lcLedger/item/delete', [LcController::class, 'lcLedgerDelete'])->name('lcLedger.delete');

Route::get('/import/agentBank/item/list', [LcController::class, 'agentBankIndex'])->name('agentBankIndex');
Route::post('/import/agentBank/item/store', [LcController::class, 'agentBankStore'])->name('agentBank.store');
Route::delete('/import/agentBank/item/delete', [LcController::class, 'agentBankDelete'])->name('agentBank.delete');

Route::get('/import/exporterLedger/item/list', [LcController::class, 'exporterLedgerIndex'])->name('exporterLedgerIndex');
Route::post('/import/exporterLedger/item/store', [LcController::class, 'exporterLedgerStore'])->name('exporterLedger.store');
Route::delete('/import/exporterLedger/item/delete', [LcController::class, 'exporterLedgerDelete'])->name('exporterLedger.delete');

Route::get('/import/cnfNname/item/list', [LcController::class, 'cnfNnameIndex'])->name('cnfNnameIndex');
Route::post('/import/cnfNname/item/store', [LcController::class, 'cnfNnameStore'])->name('cnfNname.store');
Route::delete('/import/cnfNname/item/delete', [LcController::class, 'cnfNnameDelete'])->name('cnfNname.delete');

Route::get('/import/motherVessel/item/list', [LcController::class, 'motherVesselIndex'])->name('motherVesselIndex');
Route::post('/import/motherVessel/item/store', [LcController::class, 'motherVesselStore'])->name('motherVessel.store');
Route::delete('/import/motherVessel/item/delete', [LcController::class, 'motherVesselDelete'])->name('motherVessel.delete');


Route::get('/import/portOfEntry/item/list', [LcController::class, 'portOfEntryIndex'])->name('portOfEntryIndex');
Route::post('/import/portOfEntry/item/store', [LcController::class, 'portOfEntryStore'])->name('portOfEntry.store');
Route::delete('/import/portOfEntry/item/delete', [LcController::class, 'portOfEntryDelete'])->name('portOfEntry.delete');

Route::get('/import/portOfDischarge/item/list', [LcController::class, 'portOfDischargeIndex'])->name('portOfDischargeIndex');
Route::post('/import/portOfDischarge/item/store', [LcController::class, 'portOfDischargeStore'])->name('portOfDischarge.store');
Route::delete('/import/portOfDischarge/item/delete', [LcController::class, 'portOfDischargeDelete'])->name('portOfDischarge.delete');


//Rental
Route::get('/rental/organization/profile/list', [RentalController::class, 'rentalProfileIndex'])->name('rentalProfileIndex');
Route::get('/rental/organization/profile/create', [RentalController::class, 'rentalProfileCreate'])->name('rental.rentalProfile.create');

Route::get('/rental/rentalGoodsReceived/list', [RentalController::class, 'rentalGoodsReceivedIndex'])->name('rentalGoodsReceivedIndex');
Route::get('/rental/rentalGoodsReceived/create', [RentalController::class, 'rentalGoodsReceivedCreate'])->name('rental.rentalGoodsReceived.create');

Route::get('/rental/rentalGoodsDelivery/list', [RentalController::class, 'rentalGoodsDeliveryIndex'])->name('rentalGoodsDeliveryIndex');
Route::get('/rental/rentalGoodsDelivery/create', [RentalController::class, 'rentalGoodsDeliveryCreate'])->name('rental.rentalGoodsDelivery.create');


Route::get('/rental/rentalGoodsDeliveryCollection/list', [RentalController::class, 'rentalGoodsDeliveryCollectionIndex'])->name('rentalGoodsDeliveryCollectionIndex');
Route::get('/rental/rentalGoodsDeliveryCollection/create', [RentalController::class, 'rentalGoodsDeliveryCollectionCreate'])->name('rental.rentalGoodsDeliveryCollection.create');

// Time and Attendance
Route::get('/hrpayroll/timeAttendance/lateEmployee/list', [TimeAttendanceController::class, 'lateEmployeeListIndex'])->name('hrpayroll.time.attendance.lateEmployee.list');
Route::get('/hrpayroll/timeAttendance/lateEmployee/create', [TimeAttendanceController::class, 'lateEmployeeCreate'])->name('hrpayroll.time.attendance.lateEmployee.create');

Route::get('/hrpayroll/timeAttendance/lateManage/list', [TimeAttendanceController::class, 'lateManageListIndex'])->name('hrpayroll.time.attendance.lateManage.list');
Route::get('/hrpayroll/timeAttendance/lateManage/create', [TimeAttendanceController::class, 'lateManageCreate'])->name('hrpayroll.time.attendance.lateManage.create');

Route::get('/hrpayroll/timeAttendance/lateManage/deducted/prority/list', [TimeAttendanceController::class, 'lateManageDeductedProrityIndex'])->name('hrpayroll.time.attendance.lateManage.prority.list');
Route::get('/hrpayroll/timeAttendance/lateManage/deducted/prority/create', [TimeAttendanceController::class, 'lateManageDeductedProrityCreate'])->name('hrpayroll.time.attendance.lateManage.prority.create');

Route::get('/hrpayroll/timeAttendance/shiftManage/list', [TimeAttendanceController::class, 'shiftManageListIndex'])->name('hrpayroll.time.attendance.shiftManage.list');
Route::get('/hrpayroll/timeAttendance/shiftManage/create', [TimeAttendanceController::class, 'shiftManageCreate'])->name('hrpayroll.time.attendance.shiftManage.create');

Route::get('/hrpayroll/timeAttendance/maternityLeavePolicy/list', [TimeAttendanceController::class, 'maternityLeavePolicyIndex'])->name('hrpayroll.time.attendance.maternityLeavePolicy.list');
Route::get('/hrpayroll/timeAttendance/maternityLeavePolicy/create', [TimeAttendanceController::class, 'maternityLeavePolicyCreate'])->name('hrpayroll.time.attendance.maternityLeavePolicy.create');
Route::post('/hrpayroll/timeAttendance/maternityLeavePolicy/store', [TimeAttendanceController::class, 'maternityLeavePolicyStore'])->name('hrpayroll.time.attendance.maternityLeavePolicy.store');
Route::delete('/hrpayroll/timeAttendance/maternityLeavePolicy/delete', [TimeAttendanceController::class, 'maternityLeavePolicyDelete'])->name('hrpayroll.time.attendance.maternityLeavePolicy.delete');

Route::get('/hrpayroll/timeAttendance/paternityLeavePolicy/list', [TimeAttendanceController::class, 'paternityLeavePolicyIndex'])->name('hrpayroll.time.attendance.paternityLeavePolicy.list');
Route::get('/hrpayroll/timeAttendance/paternityLeavePolicy/create', [TimeAttendanceController::class, 'paternityLeavePolicyCreate'])->name('hrpayroll.time.attendance.paternityLeavePolicy.create');

Route::get('/hrpayroll/timeAttendance/billingProcessing/list', [TimeAttendanceController::class, 'billingProcessingMPIndex'])->name('hrpayroll.time.attendance.billingProcessingMP.list');
Route::get('/hrpayroll/timeAttendance/billingProcessing/create', [TimeAttendanceController::class, 'billingProcessingMPCreate'])->name('hrpayroll.time.attendance.billingProcessingMP.create');

Route::get('/hrpayroll/timeAttendance/employeeWisePolicyAssign/list', [TimeAttendanceController::class, 'employeeWisePolicyAssignIndex'])->name('hrpayroll.time.attendance.employeeWisePolicyAssign.list');
Route::get('/hrpayroll/timeAttendance/employeeWisePolicyAssign/create', [TimeAttendanceController::class, 'employeeWisePolicyAssignCreate'])->name('hrpayroll.time.attendance.employeeWisePolicyAssign.create');

Route::get('/hrpayroll/timeAttendance/employeePartialLeave/list', [TimeAttendanceController::class, 'employeePartialLeaveIndex'])->name('hrpayroll.time.attendance.employeePartialLeave.list');
Route::get('/hrpayroll/timeAttendance/employeePartialLeave/create', [TimeAttendanceController::class, 'employeePartialLeaveCreate'])->name('hrpayroll.time.attendance.employeePartialLeave.create');
Route::post('/hrpayroll/timeAttendance/employeePartialLeave/store', [TimeAttendanceController::class, 'employeePartialLeaveStore'])->name('hrpayroll.time.attendance.employeePartialLeave.store');
Route::delete('/hrpayroll/timeAttendance/employeePartialLeave/delete', [TimeAttendanceController::class, 'employeePartialLeaveDelete'])->name('hrpayroll.time.attendance.employeePartialLeave.delete');

Route::get('/hrpayroll/timeAttendance/employeeFractionalLeave/list', [TimeAttendanceController::class, 'employeeFractionalLeaveIndex'])->name('hrpayroll.time.attendance.employeeFractionalLeave.list');
Route::get('/hrpayroll/timeAttendance/employeeFractionalLeave/create', [TimeAttendanceController::class, 'employeeFractionalLeaveCreate'])->name('hrpayroll.time.attendance.employeeFractionalLeave.create');
Route::post('/hrpayroll/timeAttendance/employeeFractionalLeave/store', [TimeAttendanceController::class, 'employeeFractionalLeaveStore'])->name('hrpayroll.time.attendance.employeeFractionalLeave.store');
Route::delete('/hrpayroll/timeAttendance/employeeFractionalLeave/delete', [TimeAttendanceController::class, 'employeeFractionalLeaveDelete'])->name('hrpayroll.time.attendance.employeeFractionalLeave.delete');

Route::get('/hrpayroll/timeAttendance/employeeHolidayCalender/list', [TimeAttendanceController::class, 'employeeHolidayCalenderIndex'])->name('hrpayroll.time.attendance.employeeHolidayCalender.list');
Route::get('/hrpayroll/timeAttendance/employeeHolidayCalender/create', [TimeAttendanceController::class, 'employeeHolidayCalenderCreate'])->name('hrpayroll.time.attendance.employeeHolidayCalender.create');

//compliance Non Compliance
Route::get('/hrpayroll/employee/timeAttendance/complianceNonCompliance/list', [TimeAttendanceController::class, 'complianceNonComplianceIndex'])->name('hrpayroll.time.attendance.complianceNonCompliance.list');
Route::post('/hrpayroll/employee/timeAttendance/complianceNonCompliance/store', [TimeAttendanceController::class, 'complianceNonComplianceStore'])->name('hrpayroll.time.attendance.complianceNonCompliance.store');
Route::delete('/hrpayroll/employee/timeAttendance/complianceNonCompliance/delete', [TimeAttendanceController::class, 'complianceNonComplianceDelete'])->name('hrpayroll.time.attendance.complianceNonCompliance.delete');


Route::get('/hrpayroll/employee/loan/list', [LoanAdvanceController::class, 'loanIndex'])->name('hrpayroll.employee.loan.list');
Route::get('/hrpayroll/employee/loan/create', [LoanAdvanceController::class, 'loanCreate'])->name('hrpayroll.employee.loan.create');
Route::post('/hrpayroll/employee/loan/store', [LoanAdvanceController::class, 'loanStore'])->name('hrpayroll.employee.loan.store');
Route::delete('/hrpayroll/employee/loan/delete', [LoanAdvanceController::class, 'loanDelete'])->name('hrpayroll.employee.loan.delete');

Route::get('/hrpayroll/employee/salary/loan/configuration/list', [LoanAdvanceController::class, 'loanConfigurationIndex'])->name('hrpayroll.employee.salaryLoanConfiguration.list');
Route::get('/hrpayroll/employee/salary/loan/configuration/create', [LoanAdvanceController::class, 'loanConfigurationCreate'])->name('hrpayroll.employee.salaryLoanConfiguration.create');

Route::get('/hrpayroll/employee/advance/salary/list', [LoanAdvanceController::class, 'salaryAdvanceIndex'])->name('hrpayroll.employee.salaryAdvance.list');
Route::get('/hrpayroll/employee/advance/salary/create', [LoanAdvanceController::class, 'salaryAdvanceCreate'])->name('hrpayroll.employee.salaryAdvance.create');
Route::post('/hrpayroll/employee/advance/salary/store', [LoanAdvanceController::class, 'salaryAdvanceStore'])->name('hrpayroll.employee.salaryAdvance.store');
Route::delete('/hrpayroll/employee/advance/salary/delete', [LoanAdvanceController::class, 'salaryAdvanceDelete'])->name('hrpayroll.employee.salaryAdvance.delete');

Route::get('/hrpayroll/employee/bonus/payment/list', [LoanAdvanceController::class, 'employeeBonusPayIndex'])->name('hrpayroll.employee.bonusPayment.list');
Route::get('/hrpayroll/employee/bonus/payment/create', [LoanAdvanceController::class, 'employeeBonusPayCreate'])->name('hrpayroll.employee.bonusPayment.create');
Route::post('/hrpayroll/employee/bonus/payment/store', [LoanAdvanceController::class, 'employeeBonusPayStore'])->name('hrpayroll.employee.bonusPayment.store');
Route::delete('/hrpayroll/employee/bonus/payment/delete', [LoanAdvanceController::class, 'employeeBonusPayDelete'])->name('hrpayroll.employee.bonusPayment.delete');

Route::get('/hrpayroll/employee/holiday/bonus/list', [LoanAdvanceController::class, 'employeeBonusHolidayIndex'])->name('hrpayroll.employee.holidayBonus.list');
Route::post('/hrpayroll/employee/holiday/bonus/store', [LoanAdvanceController::class, 'employeeBonusHolidayStore'])->name('hrpayroll.employee.holidayBonus.store');
Route::delete('/hrpayroll/employee/holiday/bonus/delete', [LoanAdvanceController::class, 'employeeBonusHolidayDelete'])->name('hrpayroll.employee.holidayBonus.delete');

Route::get('/hrpayroll/employee/subsidiary/list', [LoanAdvanceController::class, 'employeeSubsidiaryIndex'])->name('hrpayroll.employee.subsidiary.list');
Route::post('/hrpayroll/employee/subsidiary/store', [LoanAdvanceController::class, 'employeeSubsidiaryStore'])->name('hrpayroll.employee.subsidiary.store');
Route::delete('/hrpayroll/employee/subsidiary/delete', [LoanAdvanceController::class, 'employeeSubsidiaryDelete'])->name('hrpayroll.employee.subsidiary.delete');



Route::get('/hrpayroll/employee/selfService/dashboard', [EmployeeSelfServiceController::class, 'dashboard'])->name('hrpayroll.employee.selfServiceProfile.dashboard');

Route::get('/hrpayroll/employee/selfService/profile', [EmployeeSelfServiceController::class, 'index'])->name('hrpayroll.employee.selfServiceProfile.index');

Route::get('/hrpayroll/employee/selfService/leaveApplication/index', [EmployeeSelfServiceController::class, 'leaveApplicationIndex'])->name('hrpayroll.employee.leaveApplication.index');
Route::get('/hrpayroll/employee/selfService/leaveApplication', [EmployeeSelfServiceController::class, 'leaveApplicationCreate'])->name('hrpayroll.employee.leaveApplication.create');

Route::get('/hrpayroll/employee/selfService/myAttendance/index', [EmployeeSelfServiceController::class, 'myAttendanceIndex'])->name('hrpayroll.employee.myAttendance.index');

Route::post('/hrpayroll/employee/selfService/myAttendance/report', [EmployeeSelfServiceController::class, 'myAttendanceReport'])->name('hrpayroll.employee.myAttendance.report');

Route::get('/hrpayroll/employee/reimbursement/payment/list', [PayRollController::class, 'reimbursementIndex'])->name('hrpayroll.employee.reimbursementPayment.list');
Route::get('/hrpayroll/employee/reimbursement/payment/create', [PayRollController::class, 'reimbursementCreate'])->name('hrpayroll.employee.reimbursementPayment.create');

Route::get('/hrpayroll/employee/arrear/payment/list', [PayRollController::class, 'arrearPayIndex'])->name('hrpayroll.employee.arrearPayment.list');
Route::get('/hrpayroll/employee/arrear/payment/create', [PayRollController::class, 'arrearPayCreate'])->name('hrpayroll.employee.arrearPayment.create');

Route::get('/hrpayroll/employee/miscellaneous/payment/list', [PayRollController::class, 'miscellaneousPayIndex'])->name('hrpayroll.employee.miscellaneousPayment.list');
Route::get('/hrpayroll/employee/miscellaneous/payment/create', [PayRollController::class, 'miscellaneousPayCreate'])->name('hrpayroll.employee.miscellaneousPayment.create');

Route::get('/hrpayroll/employee/promotion/list', [EmployeePromotionController::class, 'index'])->name('hrpayroll.employee.promotion.list');
Route::get('/hrpayroll/employee/promotion/create', [EmployeePromotionController::class, 'create'])->name('hrpayroll.employee.promotion.create');
Route::post('/hrpayroll/employee/promotion/store', [EmployeePromotionController::class, 'store'])->name('hrpayroll.employee.promotion.store');
Route::delete('/hrpayroll/employee/promotion/delete', [EmployeePromotionController::class, 'delete'])->name('hrpayroll.employee.promotion.delete');
Route::get('/hrpayroll/employee/promotion/report/index', [EmployeePromotionController::class, 'reportIndex'])->name('hrpayroll.employee.promotion.report');
Route::post('/hrpayroll/employee/promotion/report/view', [EmployeePromotionController::class, 'reportView'])->name('hrpayroll.employee.promotion.view');

Route::get('/hrpayroll/employee/increment/list', [EmployeeIncrementController::class, 'index'])->name('hrpayroll.employee.increment.list');
Route::get('/hrpayroll/employee/increment/create', [EmployeeIncrementController::class, 'create'])->name('hrpayroll.employee.increment.create');
Route::post('/hrpayroll/employee/increment/store', [EmployeeIncrementController::class, 'store'])->name('hrpayroll.employee.increment.store');
Route::delete('/hrpayroll/employee/increment/delete', [EmployeeIncrementController::class, 'delete'])->name('hrpayroll.employee.increment.delete');
Route::get('/hrpayroll/employee/increment/report/index', [EmployeeIncrementController::class, 'reportIndex'])->name('hrpayroll.employee.increment.report');
Route::post('/hrpayroll/employee/increment/report/view', [EmployeeIncrementController::class, 'reportView'])->name('hrpayroll.employee.increment.view');


Route::get('/hrpayroll/employee/reward/list', [EmployeeRewardController::class, 'index'])->name('hrpayroll.employee.reward.list');
Route::get('/hrpayroll/employee/reward/create', [EmployeeRewardController::class, 'create'])->name('hrpayroll.employee.reward.create');
Route::post('/hrpayroll/employee/reward/store', [EmployeeRewardController::class, 'store'])->name('hrpayroll.employee.reward.store');
Route::delete('/hrpayroll/employee/reward/delete', [EmployeeRewardController::class, 'delete'])->name('hrpayroll.employee.reward.delete');


Route::get('/hrpayroll/employee/attendance/index', [AttendanceReportController::class, 'index'])->name('hrpayroll.employee.attendance.index');
Route::post('/hrpayroll/employee/attendance/report', [AttendanceReportController::class, 'attendanceReport'])->name('hrpayroll.employee.attendance.report');

Route::get('/hrpayroll/employee/attendance/ledger/index', [AttendanceReportController::class, 'ledgerIndex'])->name('hrpayroll.employee.attendance.ledger.index');
Route::post('/hrpayroll/employee/attendance/ledger/report', [AttendanceReportController::class, 'attendanceLedgerReport'])->name('hrpayroll.employee.attendance.ledger.report');

Route::get('/hrpayroll/employee/lefty/industry/index', [AttendanceReportController::class, 'leftyIndex'])->name('hrpayroll.employee.lefty.industry.index');
Route::post('/hrpayroll/employee/lefty/industry/report', [AttendanceReportController::class, 'leftyReport'])->name('hrpayroll.employee.lefty.industry.report');

Route::get('/hrpayroll/employee/earn/leave/index', [AttendanceReportController::class, 'earnLeaveIndex'])->name('hrpayroll.employee.earnLeave.index');
Route::post('/hrpayroll/employee/earn/leave/report', [AttendanceReportController::class, 'earnLeaveReport'])->name('hrpayroll.employee.earnLeave.report');

//Salary Sheet Report
Route::get('/hrpayroll/employee/salary/sheet/index', [SalaryReportController::class, 'index'])->name('hrpayroll.employee.salarySheet.index');
Route::post('/hrpayroll/employee/salary/sheet/report', [SalaryReportController::class, 'report'])->name('hrpayroll.employee.salarySheet.report');

//Production Salary Sheet Report
Route::get('/hrpayroll/employee/production/salary/sheet/index', [SalaryReportController::class, 'productSalaryIndex'])->name('hrpayroll.employee.productSalarySheet.index');
Route::post('/hrpayroll/employee/production/salary/sheet/report', [SalaryReportController::class, 'productSalaryReport'])->name('hrpayroll.employee.productSalarySheet.report');

//Employee Product
Route::get('/hrpayroll/employee/Product/list', [EmployeeProductionController::class, 'productIndex'])->name('hrpayroll.employee.product.list');
Route::get('/hrpayroll/employee/Product/create', [EmployeeProductionController::class, 'productCreate'])->name('hrpayroll.employee.product.create');
Route::post('/hrpayroll/employee/Product/store', [EmployeeProductionController::class, 'productStore'])->name('hrpayroll.employee.product.store');
Route::delete('/hrpayroll/employee/Product/delete', [EmployeeProductionController::class, 'productDelete'])->name('hrpayroll.employee.product.delete');

Route::get('/hrpayroll/employee/product/rate/{id}', [EmployeeProductionController::class, 'productGet']);


// Employee Production
Route::get('/hrpayroll/employee/production/list', [EmployeeProductionController::class, 'index'])->name('hrpayroll.employee.production.list');
Route::get('/hrpayroll/employee/production/create', [EmployeeProductionController::class, 'create'])->name('hrpayroll.employee.production.create');
Route::post('/hrpayroll/employee/production/store', [EmployeeProductionController::class, 'store'])->name('hrpayroll.employee.production.store');
Route::delete('/hrpayroll/employee/production/delete', [EmployeeProductionController::class, 'delete'])->name('hrpayroll.employee.production.delete');
Route::get('/hrpayroll/employee/production/report/index', [EmployeeProductionController::class, 'reportIndex'])->name('hrpayroll.employee.production.report');
Route::post('/hrpayroll/employee/production/report/view', [EmployeeProductionController::class, 'reportView'])->name('hrpayroll.employee.production.view');

Route::get('/employee/leave/of/absent/policy/list', [EmployeeLeavePolicyController::class, 'index'])->name('employee.leave.of.absent.policy');
Route::get('/employee/leave/of/absent/policy/create', [EmployeeLeavePolicyController::class, 'create'])->name('employee.leave.of.absent.policy.create');
Route::post('/employee/leave/of/absent/policy/store', [EmployeeLeavePolicyController::class, 'store'])->name('employee.leave.of.absent.policy.store');
Route::delete('/employee/leave/of/absent/policy/delete', [EmployeeLeavePolicyController::class, 'delete'])->name('employee.leave.of.absent.policy.delete');

//Employee ID Card
Route::get('/employee/idCard/create', [EmployeeController::class, 'employeeIdCardCreate'])->name('employee.idCard.create');
Route::post('/employee/idCard/store', [EmployeeController::class, 'employeeIdCardStore'])->name('employee.idCard.store');
Route::get('/employee/idCard/list', [EmployeeController::class, 'employeeIdCardList'])->name('employee.idCard.list');
// Route::post('/employee/idCard/view', [EmployeeController::class, 'employeeIdCardView'])->name('employee.idCard.view');
 Route::delete('/employee/idCard/delete', [EmployeeController::class, 'employeeIdCardDelete'])->name('employee.idCard.delete');


Route::get('/servise/rental/goods/all/reports', [RentalReportController::class, 'allReports'])->name('rental.goods.allReports');

Route::get('/servise/rental/goods/received/report', [RentalReportController::class, 'rentalGoodReceiveReport'])->name('rental.goods.report');

Route::get('/servise/rental/goods/delivery/report', [RentalReportController::class, 'rentalGoodDeliveryReport'])->name('rental.goods.delivery.report');

Route::get('/servise/rental/goods/delivery/ledger', [RentalReportController::class, 'rentalGoodDeliveryLedger'])->name('rental.goods.delivery.ledger');

Route::get('/servise/rental/goods/collection/sleep', [RentalReportController::class, 'rentalGoodCollectionSlip'])->name('rental.goods.collection.slip.view');


Route::get('/employee/history/reaport/index', [EmployeeController::class, 'ehreportIndex'])->name('employee.history.report.index');
Route::post('/employee/history/reaport/view', [EmployeeController::class, 'ehreportView'])->name('employee.history.report.view');

Route::get('/employee/payment/reaport/index', [EmployeeController::class, 'esreportIndex'])->name('employee.payment.report.index');
Route::post('/employee/payment/reaport/view', [EmployeeController::class, 'esreportView'])->name('employee.payment.report.view');

Route::get('/newEmployee/recruitment/reaport/index', [EmployeeController::class, 'newRReportIndex'])->name('newEmployee.recruitment.report.index');
Route::post('/newEmployee/recruitment/reaport/view', [EmployeeController::class, 'newRReportView'])->name('newEmployee.recruitment.report.view');

Route::get('/employee/production/reaport/index', [EmployeeProductionController::class, 'pReportIndex'])->name('employee.production.report.index');
Route::post('/employee/production/reaport/view', [EmployeeProductionController::class, 'pReportView'])->name('employee.production.report.view');

Route::get('/hrpayroll/timeAttendance/maternityLeave/reaport/index', [TimeAttendanceController::class, 'maternityLeaveReportIndex'])->name('employee.maternityLeave.report.index');
Route::post('/hrpayroll/timeAttendance/maternityLeave/reaport/view', [TimeAttendanceController::class, 'maternityLeaveReportView'])->name('employee.maternityLeave.report.view');

Route::get('/multi-function-requisitions/list', [RequisitionController::class, 'index'])->name('user.multiFunction.requisition.list');
Route::get('/multi-function-requisitions/create', [RequisitionController::class, 'create'])->name('user.multiFunction.requisition.create');
Route::post('/multi-function-requisitions/store', [RequisitionController::class, 'store'])->name('user.multiFunction.requisition.store');
Route::get('/multi-function-requisitions/edit/{id}/{user}', [RequisitionController::class, 'chatEdit'])->name('user.multiFunction.requisition.edit');
Route::post('/multi-function-requisitions/approved/{id}', [RequisitionController::class, 'approved'])->name('user.multiFunction.requisition.approved');
Route::get('/multi-function-requisitions/view/{id}', [RequisitionController::class, 'chatView'])->name('user.multiFunction.requisition.view');
Route::get('/multi-function-requisitions/again/edit/{id}', [RequisitionController::class, 'edit'])->name('user.multiFunction.requisition.again.edit');
Route::post('/multi-function-requisitions/updated', [RequisitionController::class, 'update'])->name('user.multiFunction.requisition.update');

Route::get('/asset/depreciation/report/index', [App\Http\Controllers\AssetController::class, 'depreciationReportIndex'])->name('asset.depreciation.report.index');
Route::post('/asset/depreciation/report/view', [App\Http\Controllers\AssetController::class, 'depreciationReportView'])->name('asset.depreciation.report.view');

});
