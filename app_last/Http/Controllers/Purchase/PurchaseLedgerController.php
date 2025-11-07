<?php

namespace App\Http\Controllers\Purchase;

use DB;

use Auth;
use Session;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Sale;
use App\Models\User;
use App\Models\Batch;
use App\Models\Scale;
use App\Models\Dealer;
use App\Models\Ledger;
use App\Models\Factory;
use App\Models\Product;
use App\Models\Vehicle;
use App\Models\Employee;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\ReturnItem;
use App\Models\Returnstbl;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Ddl_check_out;
use App\Models\Dealer_demand;
use App\Models\Demand_number;
use App\Models\SupplierGroup;
use App\Models\PurchaseLedger;
use App\Models\DeliveryConfirm;
use App\Models\PurchaseDetail;
use App\Models\SalesCategory;
use App\Models\ScaleRowMaterial;
use App\Models\RowMaterialsProduct;
use App\Http\Controllers\Controller;

class PurchaseLedgerController extends Controller
{
    public function index()
    {

        $invoice = DB::select('SELECT purchases.purchase_id FROM `purchases` ORDER BY purchases.purchase_id desc');


        $vehicle = DB::select('SELECT purchases.transport_vehicle FROM `purchases` GROUP BY purchases.transport_vehicle ORDER BY purchases.transport_vehicle asc');
        $factoryes = Factory::latest('id')->get();
        // dd($factoryes);
        $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
        $suppliergroups = SupplierGroup::orderBy('group_name', 'ASC')->get();

        return view('backend.purchase_ledger.index', compact('suppliergroups', 'invoice', 'vehicle', 'rm_products', 'factoryes', 'suppliers'));
    }


    public function ledgerView(Request $request)
    {
      if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

       // $sdate = PurchaseLedger::orderBy('date','asc')->first()->date;
        $sdate = '2023-10-01';
        //$pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

      	if($fdate <= '2023-10-01'){
        $pdate = "2023-09-30";
        } else {
        $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
        }

       $supplier = Supplier::select('suppliers.group_id','supplier_groups.*')
         				->leftJoin('supplier_groups', 'suppliers.group_id', '=', 'supplier_groups.id');

      if($request->supplier_group_id){
    		$supplier = $supplier->whereIn('suppliers.group_id',$request->supplier_group_id);
      }
      if($request->supplier_id){
    		$supplier = $supplier->whereIn('suppliers.id',$request->supplier_id);
      }

      $supplier = $supplier->groupby('suppliers.group_id')->get();
                //  $suppliergroup = SupplierGroup::whereIn('id',$request->supplier_group_id)->get();

      $groupcount = count($supplier);
     // dd($groupcount);
      $dataall = array();

       foreach($supplier as $key=>$data){
                     $supplierGET = Supplier::where('group_id',$data->group_id);
                  if($request->supplier_id){
                        $supplierGET = $supplierGET->whereIn('suppliers.id',$request->supplier_id);
                  }

                  $supplierGET = $supplierGET->get();
                  $size = count($supplierGET);
                  $supplier[$key]->suppliers_count = $size;
                  $supplier[$key]->suppliers = $supplierGET;
                }

     // dd($supplier);
     // $supplier = Supplier::find($request->supplier_id);

     if($request->type == 1){
       /*$ledgerspurchase = DB::table('purchase_ledgers')
              ->select('finish_goods_purchases.*', 'factories.factory_name as wirehouse_name')
              ->leftJoin('finish_goods_purchases', 'purchase_ledgers.purcahse_id', '=', 'finish_goods_purchases.id')
              ->leftJoin('factories', 'finish_goods_purchases.warehouse_id', '=', 'factories.id')->whereNotNull('finish_goods_purchases.warehouse_id')
              //->whereIn('purchase_ledgers.supplier_id', $request->supplier_id)
              //->whereNotNull('purchase_id')
              ->whereBetween('purchase_ledgers.date', [$fdate, $tdate])->where('type',1)
              ->orderBy('finish_goods_purchases.warehouse_id', 'asc')
              ->groupBy('finish_goods_purchases.warehouse_id')
              ->get();*/
            //  dd($ledgerspurchase);

       return view('backend.purchase_ledger.ledger_view_fg', compact('supplier','sdate','pdate', 'fdate', 'tdate','groupcount'));
     } else {
        /* $ledgerspurchase = DB::table('purchase_ledgers')
              ->select('purchases.wirehouse_id', 'factories.factory_name as wirehouse_name')
              ->leftJoin('purchases', 'purchase_ledgers.purcahse_id', '=', 'purchases.purchase_id')
              ->leftJoin('factories', 'purchases.wirehouse_id', '=', 'factories.id')->whereNotNull('purchases.wirehouse_id')
              //->whereIn('purchase_ledgers.supplier_id', $request->supplier_id)
              //->whereNotNull('purchase_id')
              ->whereBetween('purchase_ledgers.date', [$fdate, $tdate])
              ->orderBy('purchases.wirehouse_id', 'asc')
              ->groupBy('purchases.wirehouse_id')
              ->get(); */
              //dd($ledgerspurchase);
            return view('backend.purchase_ledger.ledger_view', compact('supplier','sdate','pdate', 'fdate', 'tdate','groupcount'));
     }


                /*
                $ledgerspurchase = DB::table('purchase_ledgers')
                       ->select('finish_goods_purchases.warehouse_id', 'factories.factory_name as wirehouse_name')
                       ->leftJoin('finish_goods_purchases', 'purchase_ledgers.purcahse_id', '=', 'finish_goods_purchases.id')
                       ->leftJoin('factories', 'finish_goods_purchases.warehouse_id', '=', 'factories.id')->whereNotNull('finish_goods_purchases.warehouse_id')
                       //->whereIn('purchase_ledgers.supplier_id', $request->supplier_id)
                       //->whereNotNull('purchase_id')
                       ->whereBetween('purchase_ledgers.date', [$fdate, $tdate])
                       ->orderBy('finish_goods_purchases.warehouse_id', 'asc')
                       ->groupBy('finish_goods_purchases.warehouse_id')
                       ->get();
                       */

      //  return view('backend.purchase_ledger.ledger_view', compact('supplier','sdate','pdate', 'fdate', 'tdate','ledgerspurchase','groupcount'));

      //
/*
            $sid = $request->supplier_id;
            $ledgerspurchase = DB::table('purchase_ledgers')
                ->select('purchases.wirehouse_id', 'factories.factory_name as wirehouse_name')
                ->leftJoin('purchases', 'purchase_ledgers.purcahse_id', '=', 'purchases.purchase_id')
                ->leftJoin('factories', 'purchases.wirehouse_id', '=', 'factories.id')
                ->whereIn('purchase_ledgers.supplier_id', $request->supplier_id)
                //->whereNotNull('purchase_id')
                ->whereBetween('purchase_ledgers.date', [$fdate, $tdate])
                ->orderBy('purchases.wirehouse_id', 'asc')
                ->groupBy('purchases.wirehouse_id')
                ->get();
            $ledgerspayment = DB::table('purchase_ledgers')
                ->where('purchase_ledgers.supplier_id', $request->supplier_id)
                ->whereNull('purcahse_id')
                ->whereBetween('date', [$fdate, $tdate])
                ->orderBy('date', 'asc')
                ->get();

			*/

         //   dd($supop);
       // return view('backend.purchase_ledger.ledger_view', compact('supop','supplier', 'ledgerspurchase', 'fdate', 'tdate', 'ledgerspayment', 'sid'));
      //

    }


public function ledgerReportView($fdate, $tdate){
     $fdate = date('Y-m-d',  strtotime($fdate));
     $tdate = date('Y-m-d',  strtotime($tdate));
     if($fdate == '2023-10-01'){
         $pdate = "2023-10-01";
         } else {
         $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
         }
         $sdate ="2023-10-01";
         $supplier = Supplier::select('suppliers.group_id','supplier_groups.*')
                   ->leftJoin('supplier_groups', 'suppliers.group_id', '=', 'supplier_groups.id')->groupby('suppliers.group_id')->get();

        $groupcount = count($supplier);

        foreach($supplier as $key=>$data){
                      $supplierGET = Supplier::where('group_id',$data->group_id)->get();
                   $size = count($supplierGET);
                   $supplier[$key]->suppliers_count = $size;
                   $supplier[$key]->suppliers = $supplierGET;
                 }

     return view('backend.purchase_ledger.ledgerReportView', compact('supplier','sdate','pdate', 'fdate', 'tdate','groupcount'));
   }


   public function stockLedgerindex()
    {

        $factoryes = Factory::latest('id')->get();
        $rawProducts = RowMaterialsProduct::where('unit', '!=','PCS')->get();
        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
        $suppliergroups = SupplierGroup::orderBy('group_name', 'ASC')->get();
        $category = SalesCategory::whereNotIn('category_name',['PACKING MATERIALS'])->orderBy('category_name', 'asc')->get();
        return view('backend.purchase_ledger.stock_ledger_index', compact('suppliergroups','rawProducts', 'factoryes', 'suppliers','category'));

    }

      public function stockLedgerView($fdate,$tdate)
  {
      $fdate = date('Y-m-d',  strtotime($fdate));
      $tdate = date('Y-m-d',  strtotime($tdate));
       $wirehousedata = Factory::where('id',35)->get();
      $products = RowMaterialsProduct::whereIn('unit',['KG','ML','GM'])->orderBy('product_name', 'ASC')->get();

    $sdate =  "2023-10-01";
    if($fdate <= "2023-10-01"){
      $pdate =  "2023-10-01";
      $fdate = "2023-10-01";
    } else {
      $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
    }
      if($tdate <= "2023-10-01"){
        $tdate = "2023-10-01";
      }

      $bagProducts = RowMaterialsProduct::where('unit','PCS')->orderBy('product_name', 'ASC')->get();

      return view('backend.purchase_ledger.stock_ledger_view', compact('wirehousedata', 'products','bagProducts','fdate', 'sdate','pdate','tdate'));
  }

      public function stockLedger(Request $request)
    {

      //  dd($request->all());

        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        if($request->wirehouse_id){
            $wirehousedata = Factory::whereIn('id',$request->wirehouse_id)->get();
        } else {
         $wirehousedata = Factory::orderBy('factory_name','DESC')->get();
        }

      /* if(!empty($request->raw_product_id)){
      	$products = RowMaterialsProduct::whereIn('id',$request->raw_product_id)->whereIn('unit',['KG','ML','GM'])->orderBy('product_name', 'ASC')->get();
      } else {
      	$products = RowMaterialsProduct::whereIn('unit',['KG','ML','GM'])->orderBy('product_name', 'ASC')->get();
      } */

      if ($request->raw_product_id) {
        $product = $request->raw_product_id;
      } else {
          $product = '';
      }

		  $sdate =  "2023-10-01";
      if($fdate <= "2023-10-01"){
        $pdate =  "2023-10-01";
        $fdate = "2023-10-01";
      } else {
      	$pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
      }

        if($tdate <= "2023-10-01"){
        	$tdate = "2023-10-01";
        }

        $category =[];
        if($request->category_id){
          $category = $request->category_id;
        } else {
          $cat = SalesCategory::whereNotIn('category_name', ['PACKING MATERIALS'])->orderBy('category_name', 'asc')->get();
          foreach ($cat as $key => $value) {
           $category[] = $value->id;
          }
        }

        $count = count($category);

        return view('backend.purchase_ledger.stock_ledger', compact('wirehousedata', 'product','fdate', 'sdate','pdate','tdate','category','count'));
    }


    public function bagstockLedgerindex()
    {

        $factoryes = Factory::latest('id')->get();
        // dd($factoryes);

        /*
        $products = PurchaseDetail::select('row_materials_products.*')
     		->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchase_details.product_id')
         	->groupby('purchase_details.product_id')
          	->orderBy('row_materials_products.product_name', 'ASC')
        	->get(); */
      $products = RowMaterialsProduct::where('unit','PCS')->get();
      //dd($products);


        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
        $suppliergroups = SupplierGroup::orderBy('group_name', 'ASC')->get();

        return view('backend.purchase_ledger.bag_stock_ledger_index', compact('suppliergroups','products', 'factoryes', 'suppliers'));

    }


    public function bagstockLedger(Request $request)
    {

      //  dd($request->all());

        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }


        if($request->wirehouse_id){
            $wirehousedata = Factory::whereIn('id',$request->wirehouse_id)->get();
        } else {
         $wirehousedata = Factory::orderBy('factory_name','DESC')->get();
        }

        if($request->product_id){
            $product = $request->product_id; // RowMaterialsProduct::whereIn('id',$request->product_id)->where('unit','PCS')->orderBy('product_name', 'ASC')->get();
        }else{
          $product = '';
            //$products = RowMaterialsProduct::where('unit','PCS')->orderBy('product_name', 'ASC')->get();

            /*$products = Purchase::select('row_materials_products.*')
                        ->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchases.product_id')
                        ->where('purchases.purchas_unit',"bag")->groupby('purchases.product_id')
                        ->orderBy('row_materials_products.product_name', 'ASC')->get();
                        */

        }

      $sdate = '2023-10-01';
		if($fdate <= '2023-10-01')
        {
        $pdate = '2023-09-30';
        } else {
        $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
        }
        return view('backend.purchase_ledger.bag_stock_ledger', compact('wirehousedata', 'product','fdate', 'sdate','pdate','tdate'));
    }

}
