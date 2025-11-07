<?php

namespace App\Http\Controllers\Report;

use Auth;
use Session;

use DateInterval;
use DatePeriod;
use DataTables;
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
use App\Models\SalesProduct;
use Illuminate\Http\Request;
use App\Models\Ddl_check_out;
use App\Models\Dealer_demand;
use App\Models\Demand_number;
use App\Models\SupplierGroup;
use App\Models\PurchaseLedger;
use App\Models\DeliveryConfirm;
use App\Models\PurchaseStockout;
use App\Models\FinishGoodsPurchase;
use App\Models\ScaleRowMaterial;
use Illuminate\Support\Facades\DB;
use App\Models\RowMaterialsProduct;
use App\Http\Controllers\Controller;

class PurchaseReportController extends Controller
{
  	public function purchaseReports()
    {
    	return view('backend.purchase_report.purchase_reports_index');
    }
  
  	public function productionReports()
    {	
      $userId = $id = Auth::id();
    	return view('backend.purchase_report.production_reports_index',compact('userId'));
    }
  
    public function purchaseReportIndex()
    {

        $factoryes = Factory::latest('id')->get();
        // dd($factoryes);
        $products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $fgProducts = SalesProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

        return view('backend.purchase_report.purchase_report_index', compact('products','fgProducts', 'factoryes', 'suppliers'));
    }

      public function purchaseReport(Request $request)
        {
        //dd($request->all());
        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        /*
        $sup = $request->supplier_id;
        $wir = $request->wirehouse_id;
        $pro = $request->product_id;

        $supplier = DB::table('purchases')->select('purchases.raw_supplier_id', 'suppliers.supplier_name')
                    ->leftjoin('suppliers', 'suppliers.id', '=', 'purchases.raw_supplier_id')
                    ->whereBetween('purchases.date', [$fdate, $tdate]);

        if ($request->supplier_id) {
            $supplier = $supplier->whereIn('purchases.raw_supplier_id', $request->supplier_id);
        }
        if ($request->wirehouse_id) {
            $supplier = $supplier->whereIn('purchases.wirehouse_id', $request->wirehouse_id);
        }
        if ($request->product_id) {
            $supplier = $supplier->whereIn('purchases.product_id', $request->product_id);
        }

        $supplier =  $supplier->groupBy('raw_supplier_id')
                    ->orderBy('suppliers.supplier_name')->get();

      //  dd($pro);

        $wirehouseslist = Factory::latest('id')->get();
        $products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();
        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

        return view('backend.purchase_report.purchase_report', compact('fdate', 'tdate', 'supplier', 'suppliers', 'products', 'wirehouseslist', 'sup', 'pro', 'wir'));
        */

        $sup = $request->supplier_id;
        $wir = $request->wirehouse_id;

      /*  $supplierRm = DB::table('purchases')->select('purchases.raw_supplier_id', 'suppliers.supplier_name')
                    ->leftjoin('suppliers', 'suppliers.id', '=', 'purchases.raw_supplier_id')
                    ->whereBetween('purchases.date', [$fdate, $tdate]);

        $supplierFg = DB::table('finish_goods_purchases')
                      ->select('finish_goods_purchases.*','factories.factory_name','suppliers.supplier_name')
                      ->leftJoin('suppliers','suppliers.id','finish_goods_purchases.supplier_id')
                      ->leftJoin('factories','factories.id','finish_goods_purchases.warehouse_id')
                      ->whereBetween('finish_goods_purchases.date', [$fdate, $tdate]);


        if ($request->supplier_id) {
            $supplier = $supplier->whereIn('purchases.raw_supplier_id', $request->supplier_id);
        }

        if ($request->wirehouse_id) {
            $supplier = $supplier->whereIn('purchases.wirehouse_id', $request->wirehouse_id);
        }

        $supplier =  $supplier->groupBy('raw_supplier_id')
                    ->orderBy('suppliers.supplier_name')->get(); `raw_supplier_id`
                    */
        if($request->product_id || $request->fg_product_id){
          $sdate =  "2023-10-01";
          if($fdate <= "2023-10-01"){
            $pdate =  "2023-10-01";
          } else {
          	$pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
          }

          if($request->product_id){
            $rawPurchaseDatas = Purchase::whereIn('product_id',$request->product_id)->whereBetween('date', [$fdate, $tdate])->get();
            return view('backend.purchase_report.raw_purchase_report', compact('fdate', 'tdate', 'sdate','pdate', 'rawPurchaseDatas'));
          } else {
            $fgPurchase = FinishGoodsPurchase::select('finish_goods_purchases.*','f_g_purchase_detailes.*','sales_products.product_name','sales_products.opening_balance')
                          ->leftJoin('f_g_purchase_detailes','f_g_purchase_detailes.purchase_id','finish_goods_purchases.id')
                          ->leftjoin('sales_products', 'sales_products.id', '=', 'f_g_purchase_detailes.product_id')
                          ->whereBetween('finish_goods_purchases.date', [$fdate, $tdate])->get();

            return view('backend.purchase_report.fg_purchase_report', compact('fdate', 'tdate', 'sdate','pdate', 'fgPurchase'));
          }
        } else {
          if($sup){
            $suppliers = Supplier::whereIn('id',$sup)->orderBy('supplier_name', 'ASC')->get();
          } else {
            $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
          }

          return view('backend.purchase_report.purchase_report', compact('fdate', 'tdate', 'suppliers', 'sup', 'wir'));
        }

    }


    public function bagpurchaseReportIndex()
    {

        $factoryes = Factory::latest('id')->get();
        // dd($factoryes);
        $products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

        return view('backend.purchase_report.bag_purchase_report_index', compact('products', 'factoryes', 'suppliers'));
    }

    public function bagpurchaseReport(Request $request)
    {
        //dd($request->all());
        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        $sup = $request->supplier_id;
        $wir = $request->wirehouse_id;
        $pro = $request->product_id;


        $supplier = DB::table('purchases')->select('purchases.raw_supplier_id', 'suppliers.supplier_name')
            ->leftjoin('suppliers', 'suppliers.id', '=', 'purchases.raw_supplier_id')
            ->whereBetween('purchases.date', [$fdate, $tdate]);

        if ($request->supplier_id) {
            $supplier = $supplier->whereIn('purchases.raw_supplier_id', $request->supplier_id);
        }
        if ($request->wirehouse_id) {
            $supplier = $supplier->whereIn('purchases.wirehouse_id', $request->wirehouse_id);
        }
       

        $supplier =  $supplier->groupBy('raw_supplier_id')
            ->orderBy('suppliers.supplier_name')
            ->get();

      //  dd($pro);

        $wirehouseslist = Factory::latest('id')->get();
        $products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();
        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

        return view('backend.purchase_report.bag_purchase_report', compact('fdate', 'tdate', 'supplier', 'suppliers', 'products', 'wirehouseslist', 'sup', 'pro', 'wir'));
    }



    public function monthlypurchaseReportIndex()
    {

        $factoryes = Factory::latest('id')->get();
        // dd($factoryes);
        $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

        return view('backend.purchase_report.monthly_purchase_report_index', compact('rm_products', 'factoryes', 'suppliers'));
    }

    public function monthlypurchaseReport(Request $request)
    {

        //dd($request->all());
        
        $wirehouseslist = DB::select('SELECT factories.id,factories.factory_name FROM `factories`
    ORDER BY factory_name ASC');

    //dd($wirehouseslist);

        $cyear = $request->year;
        $month = $request->month;


       

        $rmonth = date("F", mktime(0, 0, 0, $month, 10));
       // $rmonth= date('F', strtotime($month.'-'.$cyear));

       // dd($rmonth);

        if ($month == 1) {
            $pre_month = 12;

            $pre_year = $cyear - 1;
            // $pre_month = 12;
          } else {
            $pre_month = $month - 1;

            $pre_year = $cyear;
        }
     $iswarehouse =  $request->warehouse;


        $products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
       
            // dd($cmonth);
            $wirehouses = DB::select('SELECT row_materials_products.product_name,purchases.raw_supplier_id,purchases.product_id,suppliers.supplier_name,
                suppliers.opening_balance,SUM(purchases.bill_quantity) as cqty,
                ((sum(purchases.purchase_rate))/(COUNT(purchases.purchase_id))) as avg_rate,
                SUM(purchases.total_payable_amount) as payable_amount  FROM `purchases`
                LEFT JOIN row_materials_products ON row_materials_products.id = purchases.product_id
                LEFT JOIN suppliers ON suppliers.id = purchases.raw_supplier_id
                
                WHERE purchases.month = "' . $rmonth . '" AND purchases.year = "' . $cyear . '" and  purchases.purchas_unit is null
                GROUP BY row_materials_products.product_name,suppliers.supplier_name,suppliers.opening_balance,purchases.product_id
                ORDER BY suppliers.supplier_name ASC');
           // dd($wirehouses);
     
        return view('backend.purchase_report.monthly_purchase_report', compact('iswarehouse','wirehouses', 'wirehouseslist', 'rmonth', 'cyear', 'suppliers', 'products', 'wirehouseslist','pre_month','pre_year'));
    }


    public function yearlypurchaseReportIndex()
    {

        $factoryes = Factory::latest('id')->get();
        // dd($factoryes);
        $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

        return view('backend.purchase_report.yearly_purchase_report_index', compact('rm_products', 'factoryes', 'suppliers'));
    }

    public function yearlypurchaseReport(Request $request)
    {

       //dd($request->all());
        
        $wirehouseslist = DB::select('SELECT factories.id,factories.factory_name FROM `factories`
    ORDER BY factory_name ASC');

    //dd($wirehouseslist);

        $cyear = $request->year;
        $month = $request->month;


       

        $rmonth = date("F", mktime(0, 0, 0, $month, 10));
       // $rmonth= date('F', strtotime($month.'-'.$cyear));

       // dd($rmonth);

        if ($month == 1) {
            $pre_month = 12;

            $pre_year = $cyear - 1;
            // $pre_month = 12;
          } else {
            $pre_month = $month - 1;

            $pre_year = $cyear;
        }

$iswarehouse =  $request->warehouse;
      
        $products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
       
            // dd($cmonth);
            $wirehouses = DB::select('SELECT row_materials_products.product_name,purchases.raw_supplier_id,purchases.product_id,suppliers.supplier_name,
                suppliers.opening_balance,SUM(purchases.bill_quantity) as cqty,
                ((sum(purchases.purchase_rate))/(COUNT(purchases.purchase_id))) as avg_rate,
                SUM(purchases.total_payable_amount) as payable_amount  FROM `purchases`
                LEFT JOIN row_materials_products ON row_materials_products.id = purchases.product_id
                LEFT JOIN suppliers ON suppliers.id = purchases.raw_supplier_id
                
                WHERE purchases.year = "' . $cyear . '" and purchases.purchas_unit is null
                GROUP BY row_materials_products.product_name,suppliers.supplier_name,suppliers.opening_balance,purchases.product_id
                ORDER BY suppliers.supplier_name ASC');
            // dd($wirehouses);
     
        return view('backend.purchase_report.yearly_purchase_report', compact('iswarehouse','wirehouses', 'wirehouseslist', 'rmonth', 'cyear', 'suppliers', 'products', 'wirehouseslist','pre_month','pre_year'));
    }

    public function stockReportIndex()
    {

        $factoryes = Factory::latest('id')->get();
        // dd($factoryes);
        $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();

        return view('backend.purchase_report.stock_report_index', compact('rm_products', 'factoryes', 'suppliers'));
    }

    public function stockReport(Request $request)
    {
       // dd($request->all());

        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
        $mydate = Purchase::orderBy('date','asc')->value('date');
        if($mydate){
          $sdate = Purchase::orderBy('date','asc')->first()->date;
        } else {
          $sdate = $fdate;
        } 
     // dd($sdate);
      	//$sdate = '2023-01-01';
        $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
        $products = RowMaterialsProduct::where('unit','Kg')->orderBy('product_name', 'ASC')->get();
      	//dd($products);
        return view('backend.purchase_report.stock_report', compact('products','fdate','tdate','sdate','pdate'));
    }
  
    public function inventoryReportIndex()
    {

        $factoryes = Factory::latest('id')->get();
        // dd($factoryes);
        $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
        $invoice = DB::select('SELECT purchases.purchase_id FROM `purchases` WHERE purchases.purchas_unit IS NULL ORDER BY purchases.purchase_id desc');


        $vehicle = DB::select('SELECT purchases.transport_vehicle FROM `purchases` WHERE purchases.purchas_unit IS NULL GROUP BY purchases.transport_vehicle ORDER BY purchases.transport_vehicle asc');
     

        return view('backend.purchase_report.inventory_report_index', compact('rm_products', 'factoryes', 'suppliers','vehicle','invoice'));
    }

    public function inventoryReport(Request $request)
    {

      // dd($request->all());


        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
        
        $purchases = Purchase::select('purchases.*', 'suppliers.supplier_name', 'row_materials_products.product_name', 'factories.factory_name')
            ->leftjoin('suppliers', 'suppliers.id', '=', 'purchases.raw_supplier_id')
            ->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchases.product_id')
            ->leftjoin('factories', 'factories.id', '=', 'purchases.wirehouse_id')
            ->whereNotNull('purchases.product_id');



        if ($request->invoice) {
            $purchases = $purchases->whereIn('purchases.purchase_id', $request->invoice);

            $fdate = '';
            $tdate = '';
        } else {

            if ($request->date) {
                $dates = explode(' - ', $request->date);
                $fdate = date('Y-m-d', strtotime($dates[0]));
                $tdate = date('Y-m-d', strtotime($dates[1]));


                $purchases = $purchases->whereBetween('purchases.date', [$fdate, $tdate]);
            }

            if ($request->supplier_id) {
                $purchases = $purchases->whereIn('purchases.raw_supplier_id', $request->supplier_id);
            }
            if ($request->wirehouse_id) {
                $purchases = $purchases->whereIn('purchases.wirehouse_id', $request->wirehouse_id);
            }
            if ($request->product_id) {
                $purchases = $purchases->whereIn('purchases.product_id', $request->product_id);
            }
            if ($request->transport_vehicle) {
                $purchases = $purchases->whereIn('purchases.transport_vehicle', $request->transport_vehicle);
            }
        }




        $purchases = $purchases->orderBy('purchases.date', 'desc')->orderBy('purchases.purchase_id', 'desc')->get();

        
     //dd($purchases);
        return view('backend.purchase_report.inventory_report', compact('purchases','fdate','tdate'));
    }


    public function stockoutReportIndex()
    {

        $factoryes = Factory::latest('id')->get();
        // dd($factoryes);
        $rm_products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();
             $finishedgoods = SalesProduct::all();


       

        return view('backend.purchase_report.production_stockout_report_index', compact('rm_products', 'factoryes','finishedgoods'));
    }

    public function stockoutReport(Request $request)
    {

      // dd($request->all());

        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
        
        $wirehouses = DB::table('purchase_stockouts')->select('purchase_stockouts.wirehouse_id', 'factories.factory_name as wirehouse_name')
            ->leftjoin('factories', 'factories.id', '=', 'purchase_stockouts.wirehouse_id');
            
            if ($request->date) {
                $dates = explode(' - ', $request->date);
                $fdate = date('Y-m-d', strtotime($dates[0]));
                $tdate = date('Y-m-d', strtotime($dates[1]));


                $wirehouses = $wirehouses->whereBetween('purchase_stockouts.date', [$fdate, $tdate]);
            }

            $wid = '';
            if ($request->wirehouse_id) {
                $wid = $request->wirehouse_id;
                $wirehouses = $wirehouses->whereIn('purchase_stockouts.wirehouse_id', $request->wirehouse_id);
            }
            $pid = '';
            if ($request->product_id) {
                $pid = $request->product_id;
                // $wirehouses = $wirehouses->whereIn('purchase_stockouts.product_id', $request->product_id);
            }
      
        $wirehouses = $wirehouses->groupBy('purchase_stockouts.wirehouse_id')->orderBy('purchase_stockouts.date', 'desc')->orderBy('purchase_stockouts.id', 'desc')->get();       
     //dd($wirehouses);
        return view('backend.purchase_report.production_stockout_report', compact('wirehouses','fdate','tdate','wid','pid'));
    }


    public function cogmReportIndex()
    {

        $factoryes = Factory::latest('id')->get();
        // dd($factoryes);
        $products  = SalesProduct::orderBy('product_name', 'ASC')->get();

       

        return view('backend.purchase_report.cogm_report_index', compact('products', 'factoryes'));
    }
 

    public function cogmReport(Request $request)
    {

      // dd($request->all());


      if($request->month){
        
        $fdate = $request->month."-01";
        //$tdate = $request->month."-31";
        $tdate = date("Y-m-t", strtotime($fdate));
        $month_name =  date('F', strtotime($fdate));
        $year =  date('Y', strtotime($fdate));
    }

    $sdatee = PurchaseLedger::orderBy('date','asc')->first();
    $sdate = $sdatee->date;
    $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

    $fgproducts = PurchaseStockout::select('sales_products.product_name','purchase_stockouts.finish_goods_id','purchase_stockouts.fg_qty')
      				->leftjoin('sales_products', 'purchase_stockouts.finish_goods_id', '=', 'sales_products.id')
                    ->whereIn('finish_goods_id',$request->product_id)
                    ->whereBetween('date',[$fdate,$tdate])
                    ->groupBy('finish_goods_id')->get();
      
   //dd($fgproducts);
       
  // $products  = RowMaterialsProduct::where('id',$request->product_id)->orderBy('product_name', 'ASC')->get();    
     //dd($wirehouses);
        return view('backend.purchase_report.cogm_report', compact('fgproducts','fdate','tdate','month_name','year','sdate','pdate'));
    }
  
  	public function producthistorystockindex()
    {
          $wirehouses = Factory::all();
          $products = RowMaterialsProduct::orderBy('product_name', 'asc')->get();
      return view('backend.purchase_report.product_history_stock_index',compact('wirehouses', 'products'));
    }
  	
  public function viewproducthistorystockreport(Request $request)
  {
  	 //dd($request->all());
    // dd($request);
    	
    	  if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
        $pid = $request->product_id;
        $wid = $request->warehouse_id;
        
        
        $sdate = Purchase::orderBy('date','asc')->first()->date;
        $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
        
        if((($fdate !=null)&&($tdate !=null))&&($wid== null)&&($pid==null))
        {
            $wirehousedata = Factory::all();
          	$products = RowMaterialsProduct::all();
            
          }
        
           if((($fdate !=null)&&($tdate !=null))&&($wid== null)&&($pid!=null))
        {
            $wirehousedata = Factory::all();
            $products = RowMaterialsProduct::where('id',$pid)->get();
        
            
    	}
        
         if((($fdate !=null)&&($tdate !=null))&&($wid != null)&&($pid!=null))
        {
            $wirehousedata = Factory::where('id',$wid)->get();
            $products = RowMaterialsProduct::where('id',$pid)->get();
          
        
            
     	}
        //dd($products,$wirehousedata,$fdate,$tdate);
   
            return view('backend.purchase_report.product_history_stock_view',compact('wirehousedata','fdate','tdate','sdate','pdate','pid','products'));      
  }
  
     public function toptenpurchasereportindex()
    {
  
        return view('backend.purchase_report.toptenreportindex');
    }
  
  
      public function toptenpurchasereportpiechart(Request $request)
    {
     
 		 if (isset($request->date)) {
         	   $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
         }
      
      
      $data = DB::table('purchases as t1')
            // ->leftjoin('sales as t1','t1.id','t5.sale_id')
            ->leftjoin('suppliers as t2', 't1.raw_supplier_id', '=', 't2.id');


        $data = $data->select(
            't2.supplier_name',
            't1.raw_supplier_id',
            DB::raw('sum(CASE WHEN t1.date between    "' . $fdate . '" AND  "' . $tdate . '" THEN `total_payable_amount` ELSE null END) as amount'),
             
          
        )
            ->whereNotNull('t2.supplier_name')->groupBy('t1.raw_supplier_id')
            ->orderBy('amount', 'desc')->take(10)->get();
      
      
     // dd( $data );
      
   

        return view('backend.purchase_report.toptenreport', compact('fdate', 'tdate', 'data',));
    }
  	
  	public function PprogressReportIndex()
    {
    	return view('backend.purchase_report.production_progress_index');
    }
  	
  	public function PprogressReport(Request $request)
    {
    	//dd($request->all());
      
      	if (isset($request->date)) {
         	$dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
         }
      	  $period = \Carbon\CarbonPeriod::create($fdate, '1 month', $tdate);
      		$fgProducts = DB::table('purchase_stockouts')->select('sales_products.id','sales_products.product_name')
            			->leftJoin('sales_products','sales_products.id','purchase_stockouts.finish_goods_id')
                        ->whereBetween('date', [$fdate, $tdate])
                        ->groupby('purchase_stockouts.finish_goods_id')
            			->orderBy('purchase_stockouts.id','desc')
            			->get();
                        
              //dd($fgProducts);          
          
    		//dd($period);
      return view('backend.purchase_report.production_progress_report_view',compact('fdate','tdate','period','fgProducts'));
    }
  
	public function newCogmReportIndex(){

        return view('backend.purchase_report.newCogm_report_index');
    }
   public function newCogmReport(Request $request){
		//dd($request->all());
      if($request->month){ 
        $fdate = $request->month."-01";
        //$tdate = $request->month."-31";
        $tdate = date("Y-m-t", strtotime($fdate));
        $month_name =  date('F', strtotime($fdate));
        $year =  date('Y', strtotime($fdate));
    }

    $sdatee = PurchaseLedger::orderBy('date','asc')->first();
    $sdate = $sdatee->date;
    $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
	if($tdate <= '2023-01-31'){
      $fgproducts = PurchaseStockout::select('purchase_stockouts.finish_goods_id','sales_products.product_name','purchase_stockouts.fg_qty','sales_products.product_weight' )
      				->leftjoin('sales_products', 'purchase_stockouts.finish_goods_id', '=', 'sales_products.id')
                    ->whereBetween('purchase_stockouts.date',[$fdate,$tdate])
                    ->groupBy('purchase_stockouts.finish_goods_id')->get();
    } else {
    	$fgproducts = PurchaseStockout::select('purchase_stockouts.finish_goods_id','sales_products.product_name','purchase_stockouts.fg_qty as fg_qty1','purchase_stockouts.fg_out_qty as fg_qty','sales_products.product_weight' )
      				->leftjoin('sales_products', 'purchase_stockouts.finish_goods_id', '=', 'sales_products.id')
                    ->whereBetween('purchase_stockouts.date',[$fdate,$tdate])
                    ->groupBy('purchase_stockouts.finish_goods_id')->get();
    }
    
     // dd($fgproducts);
        return view('backend.purchase_report.newCogm_report', compact('fgproducts','fdate','tdate','month_name','year','sdate','pdate'));
   }
  
  public function clpoReportIndex(){
  	$factoryes = Factory::latest('id')->get();
	$rm_products = RowMaterialsProduct::whereIN('unit', ['Kg','LITRE'])->orderBy('product_name', 'ASC')->get();
   
	return view('backend.purchase_report.purchase_clpo_report_index', compact('rm_products', 'factoryes'));
  }
  
  public function clpoPurchaseReport(Request $request){
  //dd($request->all());
    if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
        
        /*$wirehouses = DB::table('purchase_stockouts')->select('purchase_stockouts.wirehouse_id','purchase_stockouts.product_id','purchase_stockouts.stock_out_quantity','factories.factory_name as wirehouse_name')
            ->leftjoin('factories', 'factories.id', '=', 'purchase_stockouts.wirehouse_id');
            
            
            
            $pid = '';
            if ($request->product_id) {
                $pid = $request->product_id;
                // $wirehouses = $wirehouses->whereIn('purchase_stockouts.product_id', $request->product_id);
            }
        
        $wirehouses = $wirehouses->groupBy('purchase_stockouts.wirehouse_id')->orderBy('purchase_stockouts.date', 'desc')->orderBy('purchase_stockouts.id', 'desc')->get();      */
        
    $day = 1;        
   	$pdate =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
   	$sdate = '2023-01-01';
    $datediff = strtotime($tdate) - strtotime($fdate);
    $day += round($datediff / (60 * 60 * 24));
    //dd($day);
    $products = [];
                if (!empty($request->product_id)) {
                    //$products = $request->product_id;
                  	$products = RowMaterialsProduct::select('id')->whereIN('id', $request->product_id)->orderBy('product_name', 'ASC')->get();
                  return view('backend.purchase_report.clpo_all_report', compact('products','pdate','sdate','fdate','tdate','day'));
                  // return view('backend.purchase_report.clpo_report', compact('products','pdate','sdate','fdate','tdate','day'));
                } elseif(!empty($request->cat_id)){
                  $products = RowMaterialsProduct::select('id')->whereIN('category_id', $request->cat_id)->whereIN('unit', ['Kg','LITRE'])->orderBy('product_name', 'ASC')->get();
                  return view('backend.purchase_report.clpo_all_report', compact('products','pdate','sdate','fdate','tdate','day'));
  				}else {
                	$products = RowMaterialsProduct::select('id')->whereIN('unit', ['Kg','LITRE'])->orderBy('product_name', 'ASC')->get();
                   return view('backend.purchase_report.clpo_all_report', compact('products','pdate','sdate','fdate','tdate','day'));
                }
        //return view('backend.purchase_report.clpo_report', compact('products','pdate','sdate','fdate','tdate','day'));
  }
  
  public function purchaseDeliveryReportIndex(){
   $suppliers = DB::table('suppliers')->get();
    $rm_products = RowMaterialsProduct::whereIN('unit', ['Kg','LITRE'])->orderBy('product_name', 'ASC')->get();
  return view('backend.purchase_report.purchase_delivery_report_index', compact('suppliers','rm_products'));
  }
  
  public function purchaseDeliveryReport(Request $request){
  //dd($request->all());
    
    if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
    $suppliers = [];
    //$products = [];
         /*if (!empty($request->supplier_id) && !empty($request->product_id)) {
                  	$suppliers = $request->supplier_id;
                    $products = RowMaterialsProduct::select('id')->whereIN('id', $request->product_id)->orderBy('product_name', 'ASC')->get();
           
           } elseif(!empty($request->supplier_id)){
         	$suppliers = $request->supplier_id;
            $products = RowMaterialsProduct::whereIN('unit', ['Kg','LITRE'])->orderBy('product_name', 'ASC')->get();
          
         } elseif(!empty($request->product_id)) {
         		$suppliers = DB::table('suppliers')->value('id');
            	$products = $request->product_id;
           
         } else {
         	$suppliers = DB::table('suppliers')->value('id');
           $products = RowMaterialsProduct::whereIN('unit', ['Kg','LITRE'])->orderBy('product_name', 'ASC')->value('id');
          
         } */
    if (!empty($request->supplier_id)) {
                  	$suppliers = Supplier::whereIN('id',$request->supplier_id)->orderBy('supplier_name', 'ASC')->get();                
           } else {
         	$suppliers =  Supplier::orderBy('supplier_name', 'ASC')->get();          
         }
    
   // use App\Models\Purchase;
//use App\Models\Supplier;
   
    return view('backend.purchase_report.purchase_delivery_report', compact('suppliers','fdate','tdate'));
  }
  
  
  public function individualStockoutReportIndex(){
        $products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();
        return view('backend.purchase_report.individual_productionStock_index', compact('products'));
  }
  
  public function individualStockoutReportView(Request $request){
  //dd($request->all());
    if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
    $rawProducts = [];
     if (!empty($request->product_id)) {
                  	$rawProducts = PurchaseStockout::select('product_id','date','sout_number','stock_out_quantity')->whereIN('product_id',$request->product_id)->whereBetween('date',[$fdate,$tdate])->orderBy('product_id', 'ASC')->get();                
           } else {
         	$rawProducts =  PurchaseStockout::select('product_id','date','sout_number','stock_out_quantity')->whereBetween('date',[$fdate,$tdate])->orderBy('product_id', 'ASC')->get();          
         }
     return view('backend.purchase_report.individual_productionStock_report', compact('rawProducts','fdate','tdate'));
  }
  
  public function dailyProductionSummaryReportIndex(){
  	return view('backend.purchase_report.dailyProductionSummaryReportIndex');
  }
  
  public function dailyProductionSummaryReportView(Request $request){
  if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
     $allFinishGoods =   DB::select('SELECT DISTINCT sales_stock_ins.sout_number,sales_stock_ins.id, sales_stock_ins.date,s.product_name,sales_stock_ins.quantity  FROM `sales_stock_ins`
                         LEFT JOIN sales_products as s ON s.id = sales_stock_ins.prouct_id 
                         WHERE sales_stock_ins.date BETWEEN "'.$fdate.'" AND "'.$tdate.'" order by date desc, sout_number desc');
    
    $finishGoodsDetails =   DB::select('SELECT DISTINCT s.product_name,SUM(sales_stock_ins.quantity) as qty  FROM `sales_stock_ins`
                         LEFT JOIN sales_products as s ON s.id = sales_stock_ins.prouct_id 
                         WHERE sales_stock_ins.date BETWEEN "'.$fdate.'" AND "'.$tdate.'" 
                         GROUP BY sales_stock_ins.prouct_id  order by sales_stock_ins.date,s.product_name  asc');
    return view('backend.purchase_report.dailyProductionSummaryReportView',compact('allFinishGoods','finishGoodsDetails','fdate','tdate'));
  }
}
