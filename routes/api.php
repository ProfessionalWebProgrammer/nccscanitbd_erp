<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\
{
  Dealer\DealerController as Dealer,
  Sales\SalesProductController,
  FactoryController,
};
use App\Http\Controllers\api\v1\{
  PurchaseOrderController,
  SalesOrderController,
  DealerController,
  ProductController,
  EmployeeController,
  GalleryController,
  AuthController,
};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
  Route::get('/get/dealer/info/{id}', [Dealer::class, 'getdealerinfo']);
  Route::get('/sales/product/', [SalesProductController::class, 'getProductApilist']);
  Route::get('/warehouse/data/get', [FactoryController::class, 'getWarehousedata']);
  */

  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/login', [AuthController::class, 'login']);

  Route::group(['middleware'=>['auth:sanctum']], function(){
  Route::post('/logout', [AuthController::class, 'logout']);
  
  });

  Route::get('/get/data/allPurchaseOrder', [PurchaseOrderController::class, 'allPurchaseOrder']);
  Route::get('/get/data/allSalesOrder', [SalesOrderController::class, 'allSalesOrder']);
  Route::get('/get/data/salesInvoiceView/{id}', [SalesOrderController::class, 'salesInvoiceView']);
  Route::get('/get/data/salesInvoiceDetailsView/{id}', [SalesOrderController::class, 'salesInvoiceDetailsView']);
  Route::get('/get/data/employee/allSalesOrder/{id}', [SalesOrderController::class, 'empAllSalesOrder']); 


  Route::get('/get/data/products/', [SalesOrderController::class, 'getSalesProducts']);
  Route::post('/post/data/salesOrder/', [SalesOrderController::class, 'storeSalesOrder']);
  Route::post('/post/data/salesView/', [SalesOrderController::class, 'searchInvoice']);

  Route::get('/get/data/dealer', [DealerController::class, 'getDealer']);
  Route::get('/get/data/warehouse', [DealerController::class, 'getWarehouse']);
  Route::get('/get/data/dealerArea', [DealerController::class, 'dealerArea']);
  Route::get('/get/data/dealerZone', [DealerController::class, 'dealerZone']);
  Route::post('/post/data/dealerCreate/', [DealerController::class, 'dealerCreate']);

  Route::get('/get/data/productCategory', [ProductController::class, 'productCategory']);
  Route::get('/get/data/productUnit', [ProductController::class, 'productUnit']);
  Route::post('/post/data/productCreate/', [ProductController::class, 'productCreate']);

  Route::get('/get/data/allEmployees', [EmployeeController::class, 'allEmployees']);
  Route::post('/post/data/employeeAttendance/', [EmployeeController::class, 'employeeAttendance']);

  //Gallery controller
  Route::post('/post/data/galleryStore/', [GalleryController::class, 'store']);
  Route::get('/get/data/gallery', [GalleryController::class, 'index']);
