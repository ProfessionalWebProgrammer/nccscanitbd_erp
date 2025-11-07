<?php

namespace App\Http\Controllers\Sales;

use Session;
use Carbon\Carbon;
use App\Models\Ctc;
use App\Models\Sale;
use App\Models\Dealer;
use App\Models\Factory;
use App\Models\Employee;
use App\Models\CommissionIn;
// use App\Models\Dealer_demand;
// use App\Models\Ddl_check_out;
// use App\Models\Transaction;
use App\Models\SalesItem;
use App\Models\SalesLedger;
use App\Models\SalesProduct;
use App\Models\SalesOrderItem;
use App\Models\SalesStockIn;
use App\Models\SalesReturnItem;
use App\Models\SalesDamage;
use App\Models\RawMaterialStockOut;
use App\Models\PackingStockOut;
use App\Models\PackingConsumptions;
// use App\Models\DeliveryConfirm;
// use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Demand_number;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
//use App\Models\SalesStockIn;
use App\Models\Transfer;
use App\Models\RowMaterialsProduct;
use App\Traits\ChartOfAccount;
use App\Models\Purchase;
use App\Models\PurchaseStockout;
use App\Models\PurchaseReturn;
use App\Models\PurchaseDamage;
use App\Models\SalesStockOut;
use App\Models\Account\ChartOfAccounts;


class SalesController extends Controller
{
use ChartOfAccount;
    public function index(Request $request)
    {
      /*$fdate = '2023-03-01';
      $tdate = '2023-03-31';
      $data = DB::table('sales_ledgers')->select('dealers.d_s_name')->join('dealers', 'sales_ledgers.vendor_id', '=', 'dealers.id')
        ->whereBetween('sales_ledgers.ledger_date',[$fdate,$tdate])->groupBy('sales_ledgers.vendor_id')->get();
      //dd($data);
      return view('backend.sales.index-demo', compact('data')); */
        $id = Auth::id();
        $invoiceq = '';
        $invoice = '';
        $dateq = '';
        $date = '';
        $warehouse_id = '';
        $warehouse_q = '';
        $dealer_id = '';
        $dealer_q = '';

        if ($request->invoice) {
            $invoice = $request->invoice;
            $invoiceq = 'AND sales.invoice_no = "'.$invoice.'"';
        }else{

            if ($request->date) {
                $date = $request->date;
                $dates = explode(' - ', $request->date);
                $fdate = date('Y-m-d', strtotime($dates[0]));
                $tdate = date('Y-m-d', strtotime($dates[1]));

                $dateq = 'AND sales.date BETWEEN "'.$fdate.'" AND "'.$tdate.'"';
            }
            if ($request->warehouse_id) {
                $warehouse_id = $request->warehouse_id;


                $warehouse_q = 'AND sales.warehouse_id = "'.$warehouse_id.'"';
            }
            if ($request->dealer_id) {
                $dealer_id = $request->dealer_id;


                $dealer_q = 'AND sales.dealer_id = "'.$dealer_id.'"';
            }

        }

       // dd($dateq);


        $emp_id = DB::select('SELECT employees.id FROM `employees` WHERE employees.user_id="' . $id . '"');
        // dd($emp_id[0]->id);
        $authid = $id = Auth::id();
        $dealerid = DB::select('SELECT dealers.id as did FROM dealers
        WHERE dealers.user_id ="' . $authid . '" ');
        // dd($dealerid[0]->did);
        // if(Auth::user()->user_role->role_id==1)
        // {

        // Sale
        $saleslist = DB::table('sales')
                        ->selectRaw('*,ROW_NUMBER() OVER (ORDER BY id) AS row_num')
                        ->select('sales.*', 'dealers.d_s_name', 'factories.factory_name', DB::raw('(select name from users where id=updated_by) as updated_by_name'))
                        ->leftJoin('dealers', 'dealers.id', '=', 'sales.dealer_id')
                        ->leftJoin('factories', 'factories.id', '=', 'sales.warehouse_id')
                        ->leftJoin('users', 'users.id', '=', 'sales.emp_id')
                        ->where('is_active', 1)
                        ->when($dateq, function ($query, $dateq) {
                            return $query->whereRaw($dateq);
                        })
                        ->when($invoiceq, function ($query, $invoiceq) {
                            return $query->whereRaw($invoiceq);
                        })
                        ->when($warehouse_q, function ($query, $warehouse_q) {
                            return $query->whereRaw($warehouse_q);
                        })
                        ->when($dealer_q, function ($query, $dealer_q) {
                            return $query->whereRaw($dealer_q);
                        })
                        ->orderBy('date', 'desc')
                        ->orderBy('invoice_no', 'desc')
                        ->paginate(10);
        //  dd($saleslist);

        // $saleslist = DB::select('SELECT sales.*,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales`
        //             LEFT JOIN dealers ON dealers.id = sales.dealer_id
        //             LEFT JOIN factories ON factories.id = sales.warehouse_id
        //             LEFT JOIN users ON users.id = sales.emp_id
        //             WHERE is_active=1 '.$dateq.$invoiceq.$warehouse_q.$dealer_q.'
        //              order by  date desc,invoice_no desc ');
                    // order by  date desc,invoice_no desc LIMIT 2000');

        //// dd($saleslist);

        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $factoryes = Factory::latest('id')->get();


        return view('backend.sales.index', compact('saleslist','dealers','factoryes','warehouse_id','dealer_id','date','invoice'));
    }



      public function invoiceView($invoice)
    {
        $salesdetails = Sale::select('sales.*','dealers.d_s_name','dealers.dlr_base','dealers.dlr_address','factories.factory_name')
                        ->leftjoin('dealers', 'sales.dealer_id', '=', 'dealers.id')
                        ->leftjoin('factories', 'sales.warehouse_id', '=', 'factories.id')
                        ->where('invoice_no', $invoice)
                        ->first();

        $salesitems = SalesItem::where('invoice_no', $invoice)->get();

       $dateTime = SalesLedger::where('invoice', $salesdetails->invoice_no)->orderBy('id', 'DESC')->first();

       if($dateTime){
          $lastPaymentDate = SalesLedger::where('vendor_id', $dateTime->vendor_id)->where('invoice', 'LIKE', 'Rec-%')->orderBy('ledger_date', 'DESC')->first();
          $openingBalance = SalesLedger::select(DB::raw('SUM(debit) - SUM(credit) as balance'))->where('vendor_id', $dateTime->vendor_id)
                                   ->where('ledger_date', '<', $dateTime->ledger_date)->get();
        } else {
          $lastPaymentDate = '';
          $openingBalance = '';
        }

      //	$closingbalance = SalesLedger::where('invoice',$salesdetails->invoice_no)->orderBy('id', 'ASC')->first();

     //	dd($salesitems);
     $user = User::where('id',Auth::id())->value('name');
          return view('backend.sales.invoice', compact('user','salesdetails', 'salesitems','invoice','openingBalance','lastPaymentDate'));
    }

	public function chalanIndex($invoice){

    /* $saleslist = DB::select('SELECT sales.*,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales`
                  LEFT JOIN dealers ON dealers.id = sales.dealer_id
                  LEFT JOIN factories ON factories.id = sales.warehouse_id
                  LEFT JOIN users ON users.id = sales.emp_id
                  WHERE is_active=1 AND sales.chalan_status is not null
                  order by  date desc,invoice_no desc LIMIT 500'); */
  //dd($saleslist);

      	$data = DB::table('chalans')->where('invoice_no', $invoice)->groupBy('chalan_no')->get();
       return view('backend.sales_delivery.chalanList', compact('data'));

  }

    public function chalanView($chalan_no){
    if(!empty($chalan_no)){
    $invoice = DB::table('chalans')->where('chalan_no', $chalan_no)->first();
    }

    $salesdetails = Sale::select('sales.*','dealers.d_s_name','dealers.dlr_address','factories.factory_name')
                ->leftjoin('dealers', 'sales.dealer_id', '=', 'dealers.id')
                ->leftjoin('factories', 'sales.warehouse_id', '=', 'factories.id')
                ->where('invoice_no', $invoice->invoice_no)
                ->first();
    if($invoice->item_type == 'fg') {
  	$salesitems = DB::table('sales_ledgers')->select('sales_ledgers.*','sales_products.product_name','sales_products.product_weight','sales_products.product_weight_unit','sales_products.product_unit')
        	         ->leftjoin('sales_products', 'sales_ledgers.product_id', '=', 'sales_products.id')
        	         ->where('chalan_no', $chalan_no)->get();
    } else {
    	$salesitems =  DB::table('sales_ledgers')->select('sales_ledgers.*','sales_ledgers.unit_price','sales_ledgers.discount_amount','row_materials_products.product_name')
        	         ->leftjoin('sales_products', 'sales_ledgers.product_id', '=', 'sales_products.id')
        	        ->where('chalan_no', $chalan_no)->get();
    }
    //dd($salesitems);
	$user = User::where('id',Auth::id())->value('name');
    return view('backend.sales_delivery.chalanview', compact('user','salesdetails','salesitems','invoice'));

  }



    public function demandeNumber()
    {
        $demandnumber = DB::select('SELECT demand_numbers.id as invoice_no FROM `demand_numbers` ORDER BY demand_numbers.id DESC LIMIT 1 ');
        return response($demandnumber);
    }

    public function getProductReturn($id,$vendorid){
      $produtctdata = DB::table('sales_products')->where('id',$id)->first();
      $special_rate_data = DB::table('special_rates')->where('dealer_id',$vendorid)->first();
      $data = array();
        $salesData = SalesLedger::where('vendor_id',$vendorid)->where('product_id',$id)->sum('qty_pcs');
        if($special_rate_data){
          $pruductprice = $produtctdata->product_dp_price+($produtctdata->product_weight*$special_rate_data->rate_kg);
        }else{
           $pruductprice = DB::table('sales_products')->where('id',$id)->value('product_dp_price');
        }

        $data['return'] = $salesData ?? 0;
        $data['price'] =$pruductprice;
      return response($data);
    }

    public function getproductprice($id,$vendorid)
    {

      $produtctdata = SalesProduct::where('id',$id)->first();
      //$special_rate_data = DB::table('special_rates')->where('dealer_id',$vendorid)->first();
      $data = array();

      $salesOrderQty = SalesOrderItem::where('product_id',$id)->sum('qty');
      $stockIn = SalesStockIn::where('prouct_id',$id)->sum('quantity');
      $salesReturn = SalesReturnItem::where('product_id',$id)->sum('qty');
      $salesDamage = SalesDamage::where('product_id',$id)->sum('quantity');

     // $openingStock = SalesProduct::where('id',$id)->value('opening_balance');

      $data['stock'] = ($produtctdata->opening_balance + $stockIn  + $salesReturn) - ($salesOrderQty + $salesDamage);


     /* if($special_rate_data){
        $pruductprice = $produtctdata->product_dp_price+($produtctdata->product_weight*$special_rate_data->rate_kg);
      }else{
         $pruductprice = DB::table('sales_products')->where('id',$id)->value('product_dp_price');
      } */

      $data['price'] =$produtctdata->product_dp_price;
      $data['unit'] =$produtctdata->product_weight_unit;

      //dd($data);

        return response($data);
    }

  	public function getproductstock($id,$wirehouse)
    {

       $wirehouseid = Factory::where('id',$wirehouse)->value('stock_limit_status');
    	// dd($wirehouseid);
      							  $startdate = '2021-01-01';
                                  $fdate = date('Y-m-d');
                                  $tdate = date('Y-m-d');
                                  $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

                          			$todaystock = \App\Models\SalesStockIn::where('prouct_id',$id)->where('factory_id',$wirehouse)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $openingstock = \App\Models\SalesStockIn::where('prouct_id',$id)->where('factory_id',$wirehouse)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                                    $sales = \App\Models\SalesLedger::where('product_id',$id)->where('warehouse_bank_id',$wirehouse)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');
                                    $opsales = \App\Models\SalesLedger::where('product_id',$id)->where('warehouse_bank_id',$wirehouse)->whereBetween('ledger_date',[$startdate,$fdate2])->sum('qty_pcs');


                                    $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('sales_returns.warehouse_id',$wirehouse)->where('product_id',$id)->whereBetween('sales_returns.date',[$fdate,$tdate])->sum('qty');
                                     $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('sales_returns.warehouse_id',$wirehouse)->where('product_id',$id)->whereBetween('sales_returns.date',[$startdate,$fdate2])->sum('qty');



                                   $transfer_from = \App\Models\Transfer::where('product_id',$id)->where('from_wirehouse',$wirehouse)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                    $optransfer_from = \App\Models\Transfer::where('product_id',$id)->where('from_wirehouse',$wirehouse)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                                    $transfer_to = \App\Models\Transfer::where('product_id',$id)->where('to_wirehouse',$wirehouse)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                    $optransfer_to = \App\Models\Transfer::where('product_id',$id)->where('to_wirehouse',$wirehouse)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                                     $damage = \App\Models\SalesDamage::where('product_id',$id)->where('warehouse_id',$wirehouse)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $opdamage = \App\Models\SalesDamage::where('product_id',$id)->where('warehouse_id',$wirehouse)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');


                                        $opblnce = ($openingstock+$optransfer_to)-($opsales+$optransfer_from+$opdamage);
                                        $clb = ($opblnce+$todaystock+$transfer_to)- ($sales+$transfer_from+$damage);
                $stockdata = [
                 	'stock'=>$clb,
                 	'wirehouse_limite'=>$wirehouseid,
                 ];

                return response($stockdata);

    }

    public function getvendorcreditlimite($vendorid)
    {
    // $date = date('Y-m-d');
      $dlrdata = Dealer::find($vendorid);
        $opdata =  DB::table('dealers as t2')
          		->leftjoin('sales_ledgers as t1', 't1.vendor_id', '=', 't2.id')
          		->select('t2.id as vendor_id','t2.dlr_police_station','t2.dlr_base',
            DB::raw('sum(debit) as debit_a'),
            DB::raw('sum(credit) as credit_a')
           )->where('vendor_id',$dlrdata->id)->first();

      $thisdate = date('Y-m-d');

      $limitother = DB::select('SELECT dealers.extra_credit_limit as credit_limit FROM `dealers` WHERE dealers.id = "'.$vendorid.'"
				 AND dealers.cl_fdate <= "'.$thisdate.'" AND dealers.cl_tdate >= "'.$thisdate.'"');
 if($limitother != null){
 $opdata->ex_credit_limit = $limitother[0]->credit_limit ;
 }else{
 	$opdata->ex_credit_limit =0;
 }

        //$openigBalance = $dlrdata->dlr_police_station-$opdata->debit_a+$opdata->credit_a;


        return $opdata;
    }


   public function warehousecheck($did,$wid)
    {


      $idcheck = DB::table('transport_costs')->where('dealer_id',$did)->where('warehouse_id',$wid)->first();

     if($idcheck){
       $id = 1;
     }else{
     	$id = 0;
     }

        return $id;
    }


    public function demandcreate(Request $request)
    {
        $id = Auth::id();
        $dealerlogid = Dealer::latest('id')->where('user_id', '=', $id)->get();
        $products = SalesProduct::orderBy('product_name', 'ASC')->get();
        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $employees = Employee::latest('id')->get();
        $factoryes = Factory::latest('id')->get();
        // $vehicles = Vehicle::all();
        $vehicles = '';
        //dd( $request->all());
        if ($request->session()->has('my_date')) {
            $date = $request->session()->get('my_date');
        } else {
            $date = date('Y-m-d');
        }
        if ($request->session()->has('wr_id')) {
            $wr_id = $request->session()->get('wr_id');
            $wr_info = Factory::find($wr_id)->factory_name;
        } else {
            $wr_id = '';
            $wr_info = '';
        }
     // dd($wr_id);

        return view('backend.sales.poscreate', compact('products', 'factoryes', 'wr_id', 'wr_info', 'date', 'dealers', 'dealerlogid', 'employees', 'vehicles'));
    }


    public function demandgenerate(Request $request)
    {

//dd($request->all());
        $cyear = date('Y');
        $cmonth = date('m');
        // dd($request);
        $id = Auth::id();
        // dd($id);
        $userName = DB::select('select users.name from users where users.id="' . $id . '"');
        //dd($userName[0]->name);
        if ($request->testdate) {
            $date_f = $request->testdate;
            $date_put = $request->session()->put('my_date', $date_f);
            // $date_f = Carbon::createFromFormat('d M Y', $datec)->format('Y-m-d');
        } else {
            $date_f = date('Y-m-d');
        }
        if ($request->warehouse_id) {
            $wr_id = $request->warehouse_id;
            $wr_id_put = $request->session()->put('wr_id', $wr_id);
        }
        //dd($wr_id);

        //     $invoice_number = DB::select('SELECT sales.invoice_no FROM `sales` ORDER BY sales.invoice_no  DESC LIMIT 1')
        //    if($request->invoice_no == $invoice_number[0]->invoice_no)
        //    {
        //        $newinvono = $request->invoice_no+1;
        //    }
        //    elseif($request->invoice_no != $invoice_number[0]->invoice_no){
        //        $newinvono = $request->invoice_no;
        //    }
        if (!$request->products_id && $request->qty) {
            return redirect()->back()
                ->with('error', 'Please Insert Product');
        }


        $factories = Factory::find($request->warehouse_id);
        //dd($factories);

//dd($request->session()->get('my_date'));

        $demandInvoNumber = new Demand_number();
        $demandInvoNumber->total_qty = $request->grand_total_qty;
        $demandInvoNumber->user_id = $id;
        $demandInvoNumber->save();

        //Add New For special rate

        // $special_rate_data = DB::table('special_rates')->where('dealer_id',$request->dealer_id)->first();
        //dd($special_rate_data);
        $special_rate = 0;
        $total_price = 0;

        $delaer_area_id = DB::table('dealers')->where('id', $request->dealer_id)->value('dlr_area_id');
        $delaer_area_name = DB::table('dealer_areas')->where('id', $delaer_area_id)->value('area_title');

        $dealerdata = Dealer::where('id', $request->dealer_id)->first();
        //dd($dealerdata);

        $sale = new Sale();
        $sale->warehouse_id = $request->warehouse_id;
        $sale->dealer_id = $request->dealer_id;
        //$sale->user_id = $id;
        //$sale->user_name = $userName;
        $sale->vendor_area_id = $delaer_area_id;
        $sale->vendor_area =  $delaer_area_name;
        $sale->date = $date_f;
        //    $sale->vehicle = $request->vehicle;
        //    $sale->transport_cost = $request->transport_cost;
        $sale->invoice_no = $demandInvoNumber->id;
        $sale->total_qty = $request->grand_total_qty;

        $sale->price = $request->grand_total_value;
        //$sale->discount = $request->grand_total_discount;
        //    $sale->price = $total_price;
        //    $sale->grand_total = $total_price;
        //$sale->grand_total = $request->total_payable;

        $sale->user_id = Auth::user()->id;
        $sale->narration = $request->narration;

       	$sale->payment_date = $request->payment_date;
          if($request->payment_date != null){
           $sale->payment_status = 1;
          }

        $sale->demand_month = $cmonth;
        $sale->demand_year = $cyear;
        $sale->save();
        //dd($sale);
        if ($sale->save()) {
            $initial_ledger = SalesLedger::where('vendor_id',  $request->dealer_id)->where('ledger_date', '<=', $sale->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();
            //dd($initial_ledger);

            foreach ($request->products_id as $key => $item) {
              //$product = SalesProduct::find($item);
              $product = DB::table('sales_products')->where('id', $item)->first();

                //FOr montly Sales
              if($product->product_weight_unit == "KG"){
              	$qtykg = $product->product_weight * $request->p_qty[$key];
              } else {
               $qtykg = 0;
              }

                $sale_item = new SalesItem();
                $sale_item->sale_id = $sale->id;
                $sale_item->invoice_no = $demandInvoNumber->id;
                $sale_item->batch_no =  $request->batch_number[$key];
                $sale_item->product_id = $item;
                $sale_item->category_id = $product->category_id;
                $sale_item->product_name = $product->product_name;
                $sale_item->product_code = $product->product_code;
                $sale_item->product_weight = $product->product_weight;
                $sale_item->qty = $request->p_qty[$key];
				$sale_item->remain_qty = $request->p_qty[$key];
                $sale_item->unit_price = $request->p_price[$key];

                 // $sale_item->discount = $request->discount[$key];
                 // $sale_item->discount_amount = $request->discount_amount[$key];

                //  $sale_item->discount = $com;
                //  $sale_item->discount_amount = $discount;

                  $sale_item->bonus = $request->bonus[$key];

               // $sale_item->total_price = $request->total_price_without_discount[$key];
				          // $sale_item->total_price = $request->total_price_without_discount[$key] - $discount;

                // $sale_item->unit_price = $product_unit_price;
                // $sale_item->total_price = $product_total_price;
                //dd($sale_item);
                $sale_item->save();
              //FOr product Sales commission
				if($sale->dealer_id != 284 || $sale->dealer_id != 285){
                $data = Ctc::where('invoice_no',$demandInvoNumber->id)->where('category_id',$product->category_id)->first();
              //  dd($data);
                if(!empty($data)){
                  $data->qty = $request->p_qty[$key] + $data->qty;
                  $data->product_weight = $product->product_weight;
                  $data->ton = (($request->p_qty[$key] * $product->product_weight)/1000)+$data->ton;
                  $data->save();

                } else {
                  $ctc = new Ctc();
                  $ctc->date = $date_f;
                  $ctc->dealer_id = $request->dealer_id;
                  $ctc->sale_id = $sale_item->id;
                  $ctc->invoice_no = $demandInvoNumber->id;
                  $ctc->category_id = $product->category_id;
                  $ctc->qty = $request->p_qty[$key];
                  $ctc->product_weight = $product->product_weight;
                  $ctc->ton = ($request->p_qty[$key] * $product->product_weight)/1000;
                  $ctc->save();
                }
               }

                DB::table('montly_sales_targets')->insert([
                    'dealer_id' => $dealerdata->id,
                    'area_id' => $dealerdata->dlr_area_id,
                    'subzone_id' => $dealerdata->dlr_subzone_id,
                    'zone_id' => $dealerdata->dlr_zone_id,
                    'category_id' => $product->category_id,
                    'product_id' => $item,
                    'sale_id' => $sale_item->id,
                    'sales_invoice' => $demandInvoNumber->id,
                    'date' => $sale->date,
                    'qty_kg' => $qtykg
                ]);


                $ledger = new SalesLedger();
                $previous_ledger = SalesLedger::where('vendor_id', $request->dealer_id)->where('ledger_date', '<=', $sale->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();

                $ledger->vendor_id = $request->dealer_id;
                $ledger->area_id = $delaer_area_id;
                $ledger->ledger_date = $sale->date." ".Carbon::now()->toTimeString();
                $ledger->invoice = $demandInvoNumber->id;

                $ledger->sale_id = $sale_item->id;

                $ledger->warehouse_bank_name = 'Sales (' .  $factories->factory_name . ')';
                $ledger->warehouse_bank_id = $request->warehouse_id;
                $ledger->is_bank = 0;

                $ledger->product_name = $product->product_name;
                $ledger->product_unit = $product->product_weight_unit;
                $ledger->product_id = $item;
                $ledger->category_id = $product->category_id;
        			  $ledger->narration = $request->narration;

                $ledger->qty_kg = $qtykg;
                $ledger->qty_pcs = $request->p_qty[$key];
                $ledger->unit_price = $request->p_price[$key];
                $ledger->free = $request->bonus[$key];
              /*
                $ledger->discount = $request->discount[$key];
                $ledger->discount_amount = $request->discount_amount[$key];

                $ledger->total_price = $request->total_price_without_discount[$key];
                */
				         //$ledger->discount = $com;
                 //$ledger->discount_amount = $discount;
              	 //$ledger->total_price = $request->total_price_without_discount[$key] - $discount;

                // $ledger->total_price = round(($request->price[$key]) * ($request->p_qty[$key]));
                // $ledger->unit_price = round($product_unit_price,2);
                // $ledger->total_price = round($product_total_price,2);

                //dd($ledger->total_price);

                //$ledger->debit = round(($request->price[$key]) * ($request->p_qty[$key]));
                // $ledger->debit = 0;

                if ($previous_ledger) {
                    $ledger->closing_balance = $previous_ledger->closing_balance;
                    $ledger->credit_limit = $previous_ledger->credit_limit;
                }

                $ledger->save();
            }
            // end foreach
            $date = '';
            $date = date('Y-m-').'01';
            $totalDisscount = 0;
            $totalPayable = 0;
            foreach($request->products_id as $index => $val) {
            $ton = 0; $maxTon = 0;
            $product = DB::table('sales_products')->where('id', $request->products_id[$index])->first();
            //$comData = DB::table('ctcs')->select('ton', 'category_id','sale_id')->where('invoice_no', $demandInvoNumber->id)->where('category_id', $product->category_id)->first();
            $comData = DB::table('ctcs')->select([DB::raw("SUM(ton) ton"),'category_id','sale_id'])->where('category_id', $product->category_id)->whereBetween('date',[$date, $date_f])->first();

            //dd($comData->ton);

            if($product->product_weight_unit == "KG"){
              $qtykg = $product->product_weight * $request->p_qty[$index];
            } else {
             $qtykg = 0;
            }
            //dd($comData);
            $ton = $comData->ton;
            $maxTon = $ton + 10;
                if($ton >=1){
                    $com = CommissionIn::where('category_id', $product->category_id)->where('target_amount','<=', $ton )->where('max_target_amount','<',$maxTon)->value('achive_commision');
                    $discount = $com*$qtykg;
                    $totalDisscount += $discount;
                  } else {
                    $discount = 0;
                    $com= 0;
                  }
                  // dd($com);
                  //sales item commission set
                   $salesItem = SalesItem::where('invoice_no', $demandInvoNumber->id)->where('product_id',$request->products_id[$index])->first();
                   //dd($salesItem);
                   $salesItem->discount = $com;
                   $salesItem->discount_amount = $discount;
                   $salesItem->total_price = $request->total_price[$index] - $discount;
                   $salesItem->save();
                   //dd($com);
                  //sales ledger commission set
                  $salesLedger = SalesLedger::where('invoice', $demandInvoNumber->id)->where('product_id',$request->products_id[$index])->first();
                  $salesLedger->discount = $com;
                  $salesLedger->discount_amount = $discount;
                  $salesLedger->total_price = $request->total_price[$index] - $discount;
                  $salesLedger->save();

                  DB::table('ctcs')->where('invoice_no',$demandInvoNumber->id)->where('category_id',$product->category_id)->update(['discount'=> $com, 'discount_amount' => $com*$ton*1000]);
          }

        $totalPayable = $request->total_payable - $totalDisscount;
        DB::table('sales')->where('invoice_no',$demandInvoNumber->id)->update(['grand_total' => $totalPayable,'discount'=> $totalDisscount]);
}

        //dd($commissions);
        // dd($request);
        $type = "debit";
        $t_head = "Product Sales";


        //dd($request->dealer_id);
        $check_invoice = SalesLedger::where('invoice', $demandInvoNumber->id)->where('priority', 1)->first();
        if (!$check_invoice) {

            $previous_ledger = SalesLedger::where('vendor_id', $request->dealer_id)->where('ledger_date', '<=', $sale->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();

            $ledger = new SalesLedger();
            $ledger->vendor_id = $request->dealer_id;
            $ledger->area_id = $delaer_area_id;
            $ledger->invoice = $demandInvoNumber->id;
            $ledger->warehouse_bank_name = 'Sales (' .  $factories->factory_name . ')';
            $ledger->warehouse_bank_id = $request->warehouse_id;
        	$ledger->narration = $request->narration;
            $ledger->ledger_date = date('Y-m-d', strtotime($sale->date))." ".Carbon::now()->toTimeString();
            $ledger->priority = 1;

            //$ledger->debit = $request->total_payable - $discount;
            $ledger->debit = $totalPayable;
            // $ledger->debit = $total_price;

            // $ledger->closing_balance = $ledger_update->closing_balance;
            // $ledger->credit_limit = $ledger_update->credit_limit;

            if ($previous_ledger) {
                $ledger->closing_balance = $previous_ledger->closing_balance + $totalPayable; //dlr_base means closing Balance previous developer did it
                $ledger->credit_limit = $previous_ledger->credit_limit - $totalPayable; //dlr_base means closing Balance

                $next_ledger = SalesLedger::where('vendor_id', $request->dealer_id)->where('ledger_date', '>', $sale->date)->orderBy('ledger_date', 'asc')->orderBy('id', 'asc')->get();

                if (count($next_ledger) != 0) {
                    //dd($next_ledger);
                    $amount = 0;
                    foreach ($next_ledger as $value) {
                        //$amount = $value->debit - $value->credit;
                        if ($value->debit != null) {
                            $amount += $value->debit;
                        } elseif ($value->credit != null) {
                            $amount -= $value->credit;
                        } else {
                            $amount += 0;
                        }

                        //dd($amount);
                        $updateledger = SalesLedger::where('id', $value->id)->first();
                        $updateledger->closing_balance =  $amount + ($previous_ledger->closing_balance + $totalPayable);
                        $updateledger->credit_limit = ($previous_ledger->credit_limit - $totalPayable) -$amount ;
                        $updateledger->save();
                    }
                }
            }


            $ledger->save();

            if ($ledger->save()) {
                $sale->ledger_status = 1;
                $sale->save();
            }
        }

        Session::put('success', 'Invoice Created Successfull. Please Check Invoice List.');

        return redirect()->back();
        //->with('success','Invoice Created Successfull. Please Check Invoice List.');

    }




    public function checkoutindex($invoice)
    {
        $id = Auth::id();
        $salesdetails = Sale::where('invoice_no', $invoice)->first();
        $salesitems = SalesItem::where('invoice_no', $invoice)->get();
        // dd($salesdetails);

        $dealerlogid = Dealer::latest('id')->where('user_id', '=', $id)->get();
        $products = SalesProduct::orderBy('product_name', 'ASC')->get();
        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $employees = Employee::latest('id')->get();
        $factoryes = Factory::latest('id')->get();

        //dd( $request->all());

        return view('backend.sales.checkout', compact('products', 'factoryes', 'dealers', 'salesdetails', 'salesitems'));
    }




    public function updatecheckout(Request $request)
    {
      // dd($request->all());
        $id = Auth::id();
        // dd($id);

        if (!$request->products_id && $request->qty) {
            return redirect()->back()
                ->with('error', 'Please Insert Product');
        }
        $date_f = $request->testdate;

        $factories = Factory::find($request->warehouse_id);
        //dd($factories);

        $delaer_area_id = DB::table('dealers')->where('id', $request->dealer_id)->value('dlr_area_id');
        $delaer_area_name = DB::table('dealer_areas')->where('id', $delaer_area_id)->value('area_title');

        $dealerdata = Dealer::where('id', $request->dealer_id)->first();
        //dd($dealerdata);


        $sale = Sale::where('invoice_no', $request->invoice)->first();
        $sale->warehouse_id = $request->warehouse_id;
        $sale->dealer_id = $request->dealer_id;
        $sale->narration = $request->narration;
        //$sale->user_name = $userName;
        $sale->vendor_area_id = $delaer_area_id;
        $sale->vendor_area =  $delaer_area_name;
        $sale->date = $date_f;
        //    $sale->vehicle = $request->vehicle;
        //    $sale->transport_cost = $request->transport_cost;
        // $sale->invoice_no = $demandInvoNumber->id;
        $sale->total_qty = $request->grand_total_qty;

        $sale->price = $request->grand_total_value;
        $sale->discount = $request->grand_total_discount;
        //    $sale->price = $total_price;
        //    $sale->grand_total = $total_price;
        $sale->grand_total = $request->total_payable;

        $sale->updated_by = Auth::user()->id;
        $sale->narration = $request->narration;
        // $sale->save();
        //dd($sale);
        if ($sale->save()) {
            $initial_ledger = SalesLedger::where('vendor_id',  $request->dealer_id)->where('ledger_date', '<=', $sale->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();
            //dd($initial_ledger);

            SalesItem::where('invoice_no', $request->invoice)->delete();
            //SalesLedger::where('invoice', $request->invoice)->delete();
            //DB::table('montly_sales_targets')->where('sales_invoice', $request->invoice)->delete();

            foreach ($request->products_id as $key => $item) {
                $product = SalesProduct::find($item);

                //for Special Rate
                // $product_unit_price = $request->price[$key]+($product->product_weight*$special_rate);
                // $product_total_price = $request->p_cost[$key]+($product->product_weight*$special_rate*$request->qty[$key]);

                //    $product_unit_price = $product->product_dp_price+($product->product_weight*$special_rate);
                // $product_total_price = ($product->product_dp_price*$request->qty[$key])+($product->product_weight*$special_rate*$request->qty[$key]);
              $ton = 0;
              $maxTon = 0;
				if($product->product_weight_unit == "KG"){
              		$qtykg = $product->product_weight * $request->p_qty[$key];
                  }else{
                    $qtykg = null;
                  }
              	 $ton = $qtykg/1000; $maxTon = $ton+10;

                  $discount = 0;
                  $com = 0;
                	if($ton >=1){
                      $com = DB::table('product_commissions')->where('product_id', $item)->where('min_target','>=', $ton )->where('max_target','<=',$maxTon)->value('achive_commision');
                   		$discount = $com*$qtykg;
                    } else {
                      $discount = 0;
                      $com = 0;
                    }

                $sale_item = new SalesItem();
                $sale_item->sale_id = $sale->id;
                $sale_item->invoice_no = $request->invoice;
                $sale_item->product_id = $item;

                $sale_item->product_name = $product->product_name;
                $sale_item->product_code = $product->product_code;
                $sale_item->product_weight = $product->product_weight;
                $sale_item->qty = $request->p_qty[$key];

                $sale_item->unit_price = $request->p_price[$key];

 				$sale_item->bonus = $request->bonus[$key];
                $sale_item->discount = $com;
                $sale_item->discount_amount = $discount;

                $sale_item->total_price = $request->total_price_without_discount[$key];

                //    $sale_item->unit_price = $product_unit_price;
                // $sale_item->total_price = $product_total_price;




                //dd($sale_item);
                $sale_item->save();


                //FOr montly Sales

                $categorydata = DB::table('sales_products')->where('id', $item)->first();

                DB::table('montly_sales_targets')->insert([
                    'dealer_id' => $dealerdata->id,
                    'area_id' => $dealerdata->dlr_area_id,
                    'subzone_id' => $dealerdata->dlr_subzone_id,
                    'zone_id' => $dealerdata->dlr_zone_id,
                    'category_id' => $categorydata->category_id,
                    'product_id' => $item,
                    'sale_id' => $sale_item->id,
                    'sales_invoice' => $request->invoice,
                    'date' => $sale->date,
                    'qty_kg' => $qtykg
                ]);


                $ledger = new SalesLedger();
                $previous_ledger = SalesLedger::where('vendor_id', $request->dealer_id)->where('ledger_date', '<=', $sale->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();

                $ledger->vendor_id = $request->dealer_id;
                $ledger->area_id = $delaer_area_id;
                $ledger->ledger_date = $sale->date;
                $ledger->invoice = $request->invoice;

                $ledger->sale_id = $sale_item->id;

                $ledger->warehouse_bank_name = 'Sales (' .  $factories->factory_name . ')';
                $ledger->warehouse_bank_id = $request->warehouse_id;
                $ledger->is_bank = 0;
        	    $ledger->narration = $request->narration;

                $ledger->product_name = $product->product_name;
                $ledger->product_unit = $product->product_weight_unit;
                $ledger->product_id = $item;

                $ledger->qty_kg = $qtykg;

                $ledger->qty_pcs = $request->p_qty[$key];



                $ledger->unit_price = $request->p_price[$key];

                $ledger->discount = $com;
                $ledger->discount_amount = $discount;

               $ledger->free = $request->bonus[$key];

                $ledger->total_price = $request->total_price_without_discount[$key];



                if ($previous_ledger) {
                    $ledger->closing_balance = $previous_ledger->closing_balance;
                    $ledger->credit_limit = $previous_ledger->credit_limit;
                }


                $ledger->save();
            }
        }
        // dd($request);
        $type = "debit";
        $t_head = "Product Sales";


        //dd($request->dealer_id);
        $check_invoice = SalesLedger::where('invoice', $request->invoice)->where('priority', 1)->first();
        if (!$check_invoice) {


            $previous_ledger = SalesLedger::where('vendor_id', $request->dealer_id)->where('ledger_date', '<=', $sale->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();

            $ledger = new SalesLedger();
            $ledger->vendor_id = $request->dealer_id;
            $ledger->area_id = $delaer_area_id;
            $ledger->invoice = $request->invoice;
            $ledger->warehouse_bank_name = 'Sales (' .  $factories->factory_name . ')';
            $ledger->warehouse_bank_id = $request->warehouse_id;
            $ledger->ledger_date = date('Y-m-d', strtotime($sale->date));
        	$ledger->narration = $request->narration;
            $ledger->priority = 1;

            $ledger->debit = $request->total_payable;
            // $ledger->debit = $total_price;

            // $ledger->closing_balance = $ledger_update->closing_balance;
            // $ledger->credit_limit = $ledger_update->credit_limit;

            if ($previous_ledger) {
                $ledger->closing_balance = $previous_ledger->closing_balance + $request->total_payable; //dlr_base means closing Balance previous developer did it
                $ledger->credit_limit = $previous_ledger->credit_limit - $request->total_payable; //dlr_base means closing Balance


                $next_ledger = SalesLedger::where('vendor_id', $request->dealer_id)->where('ledger_date', '>', $sale->date)->orderBy('ledger_date', 'asc')->orderBy('id', 'asc')->get();


                if (count($next_ledger) != 0) {
                    //dd($next_ledger);
                    $amount = 0;
                    foreach ($next_ledger as $value) {


                        //$amount = $value->debit - $value->credit;
                        if ($value->debit != null) {
                            $amount += $value->debit;
                        } elseif ($value->credit != null) {
                            $amount -= $value->credit;
                        } else {
                            $amount += 0;
                        }

                        //dd($amount);



                        $updateledger = SalesLedger::where('id', $value->id)->first();
                        $updateledger->closing_balance =  $amount + ($previous_ledger->closing_balance + $request->total_payable);
                        $updateledger->credit_limit = ($previous_ledger->credit_limit - $request->total_payable) -$amount ;
                        $updateledger->save();
                    }
                }
            }


            $ledger->save();

            if ($ledger->save()) {
                $sale->ledger_status = 1;
                $sale->save();
            }
        }


        Session::put('success', 'Invoice Edit Successfull. Please Check Invoice List.');

        return redirect()->route('sales.index');
        // ->with('success','Product Sales Successfull');

    }

    public function invoiceDelete(Request $request){
       // dd($request->all());

        $uid = Auth::id();

        Sale::where('invoice_no', $request->invoice)->update([
            'is_active' => 0,
             'deleted_by'=>$uid
            ]);
		$chalan = DB::table('chalans')->where('invoice_no',$request->invoice)->get();
      	if(!empty($chalan)){
        	DB::table('chalans')->where('invoice_no',$request->invoice)->delete();
        }
      	$invoice = $request->invoice;

      	ChartOfAccounts::where('invoice',$invoice)->delete();
        SalesStockOut::where('invoice',$invoice)->delete();
        PurchaseStockout::where('sout_number',$invoice)->delete();
        RawMaterialStockOut::where('invoice',$invoice)->delete();
        PackingStockOut::where('invoice',$invoice)->delete();
		     $invoice_no = substr($request->invoice, 4, strlen($invoice));

      	$ctcs = DB::table('ctcs')->where('invoice_no',$invoice_no)->get();
      	if(!empty($ctcs)){
        	DB::table('ctcs')->where('invoice_no',$invoice_no)->delete();
        }

      //	$waireHouse = Sale::where('invoice_no', $request->invoice)->value('warehouse_id');

		// $allData = SalesItem::select('product_id','qty')->where('invoice_no', $request->invoice)->get();
         /* foreach($allData as $key => $val){

          $qty= 0;
           $salesStock = SalesStockIn::where('prouct_id',$val->product_id)->where('factory_id',$waireHouse)->first();

            if(!empty($salesStock->quantity)){
             $qty = (int)$salesStock->quantity + $val->qty;
           } else {
           	 $qty = $val->qty;
           }

           $salesStock->quantity = $qty;
           $salesStock->save();

          } */



        SalesItem::where('invoice_no', $request->invoice)->delete();
        SalesLedger::where('invoice', $request->invoice)->delete();

        DB::table('montly_sales_targets')->where('sales_invoice', $request->invoice)->delete();


       $salesReturn = DB::table('sales_returns')->where('invoice_no', $request->invoice)->first();
      if(!empty($salesReturn)){
      	DB::table('sales_returns')->where('invoice_no', $request->invoice)->delete();
      }

      $salesReturnItem = DB::table('sales_return_items')->where('invoice_no', $request->invoice)->first();
      if(!empty($salesReturnItem)){
      	DB::table('sales_return_items')->where('invoice_no', $request->invoice)->delete();
      }

        return redirect()->back()->with('success', 'Invoice Delete Successfull.');

    }

  public function deletelog(Request $request)
    {

        $saleslist = DB::select('SELECT sales.*,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales`
LEFT JOIN dealers ON dealers.id = sales.dealer_id
LEFT JOIN factories ON factories.id = sales.warehouse_id
LEFT JOIN users ON users.id = sales.emp_id
WHERE is_active=0
order by  date desc,invoice_no desc LIMIT 500');


        return view('backend.sales.delete_log', compact('saleslist'));
    }

    public function vandcdatastore(Request $request)
    {
    	//dd($request->all());
      	$updata = Sale::where('invoice_no',$request->invoice)->first();
      	$updata->vehicle = $request->vehicle;
      	$updata->transport_cost = $request->tcost;
      	$updata->save();
      return redirect()->back();
      	//dd($updata);
    }


   public function deliveryStatus(Request $request)
    {
        $id = Auth::id();
    // dd($id);
        $invoiceq = '';
        $invoice = '';
        $dateq = '';
        $date = '';
        $warehouse_id = '';
        $warehouse_q = '';
        $dealer_id = '';
        $dealer_q = '';

        if ($request->invoice) {
            $invoice = $request->invoice;
            $invoiceq = 'AND sales.invoice_no = "'.$invoice.'"';
        } else {


            if ($request->date) {
                $date = $request->date;
                $dates = explode(' - ', $request->date);
                $fdate = date('Y-m-d', strtotime($dates[0]));
                $tdate = date('Y-m-d', strtotime($dates[1]));
                $dateq = 'AND sales.date BETWEEN "'.$fdate.'" AND "'.$tdate.'"';
            }
            if ($request->warehouse_id) {
                $warehouse_id = $request->warehouse_id;
                $warehouse_q = 'AND sales.warehouse_id = "'.$warehouse_id.'"';
            }
            if ($request->dealer_id) {
                $dealer_id = $request->dealer_id;
                $dealer_q = 'AND sales.dealer_id = "'.$dealer_id.'"';
            }

        }

       // dd($dateq);


        $emp_id = DB::select('SELECT employees.id FROM `employees` WHERE employees.user_id="' . $id . '"');
        // dd($emp_id[0]->id);
        $authid = Auth::id();
        $dealerid = DB::select('SELECT dealers.id as did FROM dealers
        WHERE dealers.user_id ="' . $authid . '" ');
        // dd($dealerid[0]->did);
        // if(Auth::user()->user_role->role_id==1)
        // { AND sales.delivery=0
		if($authid == 169){
          $saleslist = DB::select('SELECT sales.*,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales`
                    LEFT JOIN dealers ON dealers.id = sales.dealer_id
                    LEFT JOIN factories ON factories.id = 36
                    LEFT JOIN users ON users.id = sales.emp_id
                    WHERE is_active=1 AND sales.warehouse_id = 36 '.$dateq.$invoiceq.$dealer_q.'
                    order by  date desc,invoice_no desc LIMIT 500');
        } else {
        $saleslist = DB::select('SELECT sales.*,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales`
                    LEFT JOIN dealers ON dealers.id = sales.dealer_id
                    LEFT JOIN factories ON factories.id = sales.warehouse_id
                    LEFT JOIN users ON users.id = sales.emp_id
                    WHERE is_active=1 '.$dateq.$invoiceq.$warehouse_q.$dealer_q.'
                    order by  date desc,invoice_no desc LIMIT 500');
        }
        // dd($saleslist);

        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $factoryes = Factory::latest('id')->get();


        return view('backend.sales_delivery.sales_delivery_status', compact('authid','saleslist','dealers','factoryes','warehouse_id','dealer_id','date','invoice'));
    }

  	public function salesDeliveySummaryList(Request $request){
       $today=date('Y-m-d');
       $wirehouses = Factory::all();
       $products = SalesProduct::all();
     	if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));

             $datequry = 'AND sales_ledgers.ledger_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"';
          	 $datequrySal = 'AND sales.date BETWEEN "'.$fdate.'" AND "'.$tdate.'"';
             $date = $request->date;
        }
        else{
       	$datequry = 'AND sales_ledgers.ledger_date = "'.$today.'"';
          $datequrySal = 'AND sales.date = "'.$today.'"';
        $date = "";
           $fdate = date('Y-m-d');
           $tdate = date('Y-m-d');
       }
		$category = DB::table('sales_categories')->whereNotIn('id',[31,32])->get();
      //dd($category);
       if($request->product_id){

         $product = $request->product_id;
         $delivery_count = DB::table('sales_ledgers as t1')
            ->whereIn('t1.product_id',$request->product_id)->whereBetween('t1.ledger_date', [$fdate, $tdate])
            ->sum('qty_pcs');
         $warehouse_id = '';
         //dd( $saleslist);
         return view('backend.sales_delivery.sales_delivery_summary_list_new',compact('category','product','products','wirehouses','warehouse_id','delivery_count','fdate','tdate','today','date'));

       } else {

       if($request->warehouse_id){
       	$warehouse_id = $request->warehouse_id;
         $wirehousequery = 'AND sales_ledgers.warehouse_bank_id = "'.$request->warehouse_id.'"';
         $wirehousequerySal = 'AND sales.warehouse_id = "'.$request->warehouse_id.'"';
       }else{
       	$warehouse_id = '';
       	$wirehousequery = '';
        $wirehousequerySal = '';

       }


    $authid = Auth::id();



         /*   $saleslist = DB::select('SELECT sales.*,dealers.d_s_name,(select name from users where id=updated_by) as updated_by_name,factories.factory_name FROM `sales`
                        LEFT JOIN dealers ON dealers.id = sales.dealer_id
                        LEFT JOIN factories ON factories.id = sales.warehouse_id
                        LEFT JOIN users ON users.id = sales.emp_id
                        WHERE sales.is_active=1
                        '.$wirehousequery.$datequry.'
                        order by  date desc,invoice_no desc LIMIT 2000');

                        //LEFT JOIN factories ON factories.id = sales_ledgers.warehouse_bank_id

      */

		/*$saleslist = DB::select('SELECT sales_ledgers.*,dealers.d_s_name FROM `sales_ledgers`
                        LEFT JOIN dealers ON dealers.id = sales_ledgers.vendor_id
                        WHERE sales_ledgers.product_id IS NOT NULL
                        '.$wirehousequery.$datequry.'
                        order by  sales_ledgers.ledger_date desc, sales_ledgers.invoice desc LIMIT 2000'); */

       if($authid == 169) {
         $saleslist = DB::select('SELECT sales_ledgers.vendor_id ,dealers.d_s_name FROM `sales_ledgers`
                        LEFT JOIN dealers ON dealers.id = sales_ledgers.vendor_id
                        WHERE sales_ledgers.product_id IS NOT NULL AND sales_ledgers.warehouse_bank_id = 36
                        '.$datequry.'
                        group by sales_ledgers.vendor_id order by  sales_ledgers.ledger_date desc, sales_ledgers.invoice desc');
         $invoice_count = DB::select('SELECT SUM(total_qty) as total_qty FROM `sales`
            					WHERE sales.is_active=1 AND sales.warehouse_id = 36
                                '.$datequrySal.'');

        $delivery_count = DB::select('SELECT SUM(qty_pcs) as total_qty FROM `sales_ledgers`
        				WHERE sales_ledgers.product_id IS NOT NULL AND sales_ledgers.warehouse_bank_id = 36
                                '.$datequry.' ');

       } else {
       	$saleslist = DB::select('SELECT sales_ledgers.vendor_id ,dealers.d_s_name FROM `sales_ledgers`
                        LEFT JOIN dealers ON dealers.id = sales_ledgers.vendor_id
                        WHERE sales_ledgers.product_id IS NOT NULL
                        '.$wirehousequery.$datequry.'
                        group by sales_ledgers.vendor_id order by  sales_ledgers.ledger_date desc, sales_ledgers.invoice desc');
         $invoice_count = DB::select('SELECT SUM(total_qty) as total_qty FROM `sales`
            					WHERE sales.is_active=1
                                '.$wirehousequerySal.$datequrySal.'');

        $delivery_count = DB::select('SELECT SUM(qty_pcs) as total_qty FROM `sales_ledgers`  WHERE sales_ledgers.product_id IS NOT NULL
                                '.$wirehousequery.$datequry.' ');
       }



      return view('backend.sales_delivery.sales_delivery_summary_list',compact('authid','products','saleslist','wirehousequery','datequry','invoice_count','delivery_count','fdate','tdate','today','wirehouses','warehouse_id','date'));
       }


      /*
       if($request->product_id){
      	 $saleslist = DB::table('sales_ledgers as t1')
            ->select( DB::raw('sum(total_price) as total_amount,sum(qty_pcs) as total_qty,sum(qty_kg) as qty_kg'), 't2.product_name')
          	->join('sales_products as t2', 't1.product_id', '=', 't2.id')
            ->whereIn('t1.product_id',$request->product_id)->whereBetween('t1.ledger_date', [$fdate, $tdate])
            ->orderBy('t1.ledger_date','desc')->groupBy('t1.product_id')->take(200)
            ->get();
       } else {
       	 $saleslist = DB::table('sales_ledgers as t1')
            ->select( DB::raw('sum(total_price) as total_amount,sum(qty_pcs) as total_qty,sum(qty_kg) as qty_kg'), 't2.product_name')
           	->join('sales_products as t2', 't1.product_id', '=', 't2.id')
            ->whereNotNull('t1.product_id')->whereBetween('t1.ledger_date', [$fdate, $tdate])
            ->orderBy('t1.ledger_date','desc')->groupBy('t1.product_id')->take(200)
            ->get();
       }
      */

   //  return view('backend.sales_delivery.sales_delivery_summary_list',compact('products','saleslist','wirehouses'));

    }

  public function salesUnDeliveySummaryList(Request $request){
    //dd($request->all());
       $today=date('Y-m-d');
       $wirehouses = Factory::all();
       //$products = SalesProduct::all();
     	if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
             $date = $request->date;
        }
        else{
       	  $datequry = 'AND sales_items.date = "'.$today.'"';
          $datequrySal = 'AND sales.date = "'.$today.'"';
        $date = "";
           $fdate = date('Y-m-d');
           $tdate = date('Y-m-d');
       }


    $authid = Auth::id();
       if($authid == 169) {
         /*$saleslist = DB::select('SELECT sales_ledgers.vendor_id ,dealers.d_s_name FROM `sales_ledgers`
                        LEFT JOIN dealers ON dealers.id = sales_ledgers.vendor_id
                        WHERE sales_ledgers.product_id IS NOT NULL AND sales_ledgers.warehouse_bank_id = 36
                        '.$datequry.' group by sales_ledgers.vendor_id order by  sales_ledgers.ledger_date desc, sales_ledgers.invoice desc'); */
         $warehouse_id = 36;
          $salesOrderLists = DB::table('sales_items as s')->select('s.dealer_id','d.d_s_name')
          					->leftjoin('dealers as d', 'd.id', '=', 's.dealer_id')->where('s.warehouse_id', $warehouse_id)
           					->where('s.remain_qty','>', 0)
            				->whereBetween('s.date', [$fdate, $tdate])
           					->groupby('s.dealer_id')->orderby('s.date','desc')->get();

       } else {
        if($request->warehouse_id){
       	/*$salesOrderLists = DB::select('SELECT dealers.id ,dealers.d_s_name,sales_items.sale_id FROM `sales_items`
         				LEFT JOIN sales ON sales.id = sales_items.sale_id
                        LEFT JOIN dealers ON dealers.id = sales.dealer_id
                        WHERE sales_items.product_id IS NOT NULL and WHERE sales_items.product_id IN  '.$request->product_id.'
                        '.$wirehousequerySal.$datequrySal.'
                        group by sales_items.sale_id order by  sales_items.date desc, sales_items.invoice_no desc'); */

          $warehouse_id = $request->warehouse_id;
          $salesOrderLists = DB::table('sales_items as s')->select('s.dealer_id','d.d_s_name')
          					->leftjoin('dealers as d', 'd.id', '=', 's.dealer_id')->where('s.warehouse_id', $warehouse_id)
           					->where('s.remain_qty','>', 0)
            				->whereBetween('s.date', [$fdate, $tdate])
           					->groupby('s.dealer_id')->orderby('s.date','desc')->get();
         // $rqProducts = $request->product_id;

        } else {
       /* $salesOrderLists = DB::select('SELECT DISTINCT dealers.id ,dealers.d_s_name,sales_items.sale_id FROM `sales_items`
         				LEFT JOIN sales ON sales.id = sales_items.sale_id
                        LEFT JOIN dealers ON dealers.id = sales.dealer_id
                        WHERE sales_items.remain_qty > 0
                        '.$wirehousequerySal.$datequrySal.'
                        group by sales_items.sale_id, sales.dealer_id  order by  sales_items.date desc, sales_items.invoice_no desc'); */
          $warehouse_id = '';
          $salesOrderLists = DB::table('sales_items as s')->select('s.dealer_id','d.d_s_name')
          					//->leftjoin('sales as ss', 'ss.id', '=', 's.sale_id')
           					->leftjoin('dealers as d', 'd.id', '=', 's.dealer_id')
           					->where('s.remain_qty','>', 0)->whereBetween('s.date', [$fdate, $tdate])
           					->groupby('s.dealer_id')->orderby('s.date','desc')->get();
        }

        // dd($salesOrderLists);

         /*$invoice_count = DB::select('SELECT SUM(total_qty) as total_qty FROM `sales`
            					WHERE sales.is_active=1
                                '.$wirehousequerySal.$datequrySal.''); */

       /* $delivery_count = DB::select('SELECT SUM(qty_pcs) as total_qty FROM `sales_ledgers`  WHERE sales_ledgers.product_id IS NOT NULL
                                '.$wirehousequery.$datequry.' '); */
       }



      return view('backend.sales_delivery.salesUnDeliverySummaryList',compact('authid','salesOrderLists','fdate','tdate','today','wirehouses','warehouse_id','date'));

  }

    public function deliveryStatusUpdate($id){

    $uid = Auth::id();

    	$i = 1;
        $sale = Sale::find($id);
        $sale->delivery =1;
        $sale->counter += $i;
        $sale->dc_by =$uid;
        $sale->dc_at = Carbon::now();
        $sale->save();



            return redirect()->back()->with('success','Delivery Confirm');

    }

  public function SalesDeliveyList(Request $request)
    {
    $today=date('Y-m-d');

       $wirehouses = Factory::all();
       if($request->warehouse_id){
       	$warehouse_id = $request->warehouse_id;
         $wirehousequery = 'AND sales.warehouse_id = "'.$request->warehouse_id.'"';
       }else{
       	$warehouse_id = '';
       	$wirehousequery = '';

       }

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));

             $datequry = 'AND sales.date BETWEEN "'.$fdate.'" AND "'.$tdate.'"';
             $date = $request->date;
        }
        else{
       	$datequry = 'AND sales.date = "'.$today.'"';
        $date = "";
       }

      $id = Auth::id();

        $emp_id = DB::select('SELECT employees.id FROM `employees` WHERE employees.user_id="'.$id.'"');
        // dd($emp_id[0]->id);
        $dealerid = DB::select('SELECT dealers.id as did FROM dealers
        WHERE dealers.user_id ="'.$id.'" ');

        // dd($dealerid[0]->did);
        // if(Auth::user()->user_role->role_id==1)
        // { sales_ledgers
    		if($id == 169){
            $saleslist = DB::select('SELECT sales.*,dealers.d_s_name,(select name from users where id=updated_by) as updated_by_name,factories.factory_name FROM `sales`
                        LEFT JOIN dealers ON dealers.id = sales.dealer_id
                        LEFT JOIN factories ON factories.id = sales.warehouse_id
                        LEFT JOIN users ON users.id = sales.emp_id
                        WHERE sales.is_active=1 AND sales.warehouse_id = 36
                        '.$datequry.'
                        order by  date desc,invoice_no desc LIMIT 2000');

            $invoice_count = DB::select('SELECT COUNT(id) as tota_invoice, SUM(total_qty) as total_qty FROM `sales`
            					WHERE sales.is_active=1 AND sales.warehouse_id = 36
                                '.$datequry.'');

            $delivery_count = DB::select('SELECT COUNT(id) as tota_delivery, SUM(total_qty) as total_qty FROM `sales`
            					WHERE sales.is_active=1 AND sales.delivery=1 AND sales.warehouse_id = 36
                                '.$datequry.' ');
            } else {
            $saleslist = DB::select('SELECT sales.*,dealers.d_s_name,(select name from users where id=updated_by) as updated_by_name,factories.factory_name FROM `sales`
                        LEFT JOIN dealers ON dealers.id = sales.dealer_id
                        LEFT JOIN factories ON factories.id = sales.warehouse_id
                        LEFT JOIN users ON users.id = sales.emp_id
                        WHERE sales.is_active=1
                        '.$wirehousequery.$datequry.'
                        order by  date desc,invoice_no desc LIMIT 2000');

            $invoice_count = DB::select('SELECT COUNT(id) as tota_invoice, SUM(total_qty) as total_qty FROM `sales`
            					WHERE sales.is_active=1
                                '.$wirehousequery.$datequry.'');

            $delivery_count = DB::select('SELECT COUNT(id) as tota_delivery, SUM(total_qty) as total_qty FROM `sales`
            					WHERE sales.is_active=1 AND sales.delivery=1
                                '.$wirehousequery.$datequry.' ');

            }

            /*$ishawrdi = DB::select('SELECT COUNT(id) as tota_invoice, SUM(total_qty) as total_qty FROM `sales`
            					WHERE sales.is_active=1 AND sales.warehouse_id = 8 '.$datequry.'');
             $rrpu3 = DB::select('SELECT COUNT(id) as tota_invoice, SUM(total_qty) as total_qty FROM `sales`
            					WHERE sales.is_active=1 AND sales.warehouse_id = 17 '.$datequry.''); */
             //dd($delivery_count);

            return view('backend.sales_delivery.sales_delivery_list',compact('id','saleslist','invoice_count','delivery_count','today','wirehouses','warehouse_id','date'));


}


  public function DeliveyConfirmedList(Request $request)
    {
        $id = Auth::id();


        $invoiceq = '';
        $invoice = '';
        $dateq = '';
        $date = '';
        $warehouse_id = '';
        $warehouse_q = '';
        $dealer_id = '';
        $dealer_q = '';

        if ($request->invoice) {
            $invoice = $request->invoice;

            $invoiceq = 'AND sales.invoice_no = "'.$invoice.'"';
        }else{



            if ($request->date) {
                $date = $request->date;
                $dates = explode(' - ', $request->date);
                $fdate = date('Y-m-d', strtotime($dates[0]));
                $tdate = date('Y-m-d', strtotime($dates[1]));

                $dateq = 'AND sales.date BETWEEN "'.$fdate.'" AND "'.$tdate.'"';
            }
            if ($request->warehouse_id) {
                $warehouse_id = $request->warehouse_id;


                $warehouse_q = 'AND sales.warehouse_id = "'.$warehouse_id.'"';
            }
            if ($request->dealer_id) {
                $dealer_id = $request->dealer_id;


                $dealer_q = 'AND sales.dealer_id = "'.$dealer_id.'"';
            }

        }

       // dd($dateq);


        $emp_id = DB::select('SELECT employees.id FROM `employees` WHERE employees.user_id="' . $id . '"');
        // dd($emp_id[0]->id);
        $authid = $id = Auth::id();
        $dealerid = DB::select('SELECT dealers.id as did FROM dealers
        WHERE dealers.user_id ="' . $authid . '" ');
        // dd($dealerid[0]->did);
        // if(Auth::user()->user_role->role_id==1)
        // {
        $saleslist = DB::select('SELECT sales.*,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales`
LEFT JOIN dealers ON dealers.id = sales.dealer_id
LEFT JOIN factories ON factories.id = sales.warehouse_id
LEFT JOIN users ON users.id = sales.emp_id
WHERE is_active=1 AND sales.delivery=1  '.$dateq.$invoiceq.$warehouse_q.$dealer_q.'
order by  date desc,invoice_no desc LIMIT 500');

         //dd($saleslist);

        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $factoryes = Factory::latest('id')->get();


        return view('backend.sales_delivery.sales_delivery_confirmed_list', compact('saleslist','dealers','factoryes','warehouse_id','dealer_id','date','invoice'));
    }


     public function salespaymentdate($id){

    $uid = Auth::id();


        Sale::where('invoice_no',$id)->update(['payment_status'=>0]);

            return redirect()->back();

    }

   public function vendorsalesinvoice($id){

     $saleslist = Sale::where('dealer_id',$id)
                    ->whereNotNull('payment_date')
                    ->where('payment_status',0)
                    ->groupby('invoice_no')
                   ->orderby('date','asc')
                    ->get();

     return response($saleslist);

  }


  public function chalanStatus($invoice){

    $id = Auth::id();

        $salesdetails = DB::table('sales as s')->select('s.id','s.invoice_no', 's.date','s.vehicle','s.narration','s.transport_cost', 's.chalan_status','d.d_s_name','d.dlr_address','f.factory_name')
          				->leftJoin('dealers as d', 's.dealer_id', '=', 'd.id')
          				->leftJoin('factories as f', 's.warehouse_id', '=', 'f.id')
          				->where('s.invoice_no', $invoice)->first();

        $salesitems = SalesItem::where('invoice_no', $invoice)->get();
        //dd($salesitems);
        $products = SalesProduct::orderBy('product_name', 'ASC')->get();
		$driver = DB::table('drivers')->orderBy('name','asc')->get();

    return view('backend.sales_delivery.chalanStatus', compact('products', 'salesdetails', 'salesitems','driver'));
  }

  public function salesUpdate(){
   $sales = Sale::select('invoice_no','dealer_id','warehouse_id','date','item_type','vendor_area_id','t2.dlr_zone_id','t2.dlr_subzone_id','t2.dlr_area_id')
                ->leftjoin('dealers as t2','dealer_id','=','t2.id')->where('date','LIKE', '2024-01-%')->groupBy('invoice_no')->get();
    /* $sales = Sale::select('invoice_no','dealer_id','warehouse_id','date','item_type','vendor_area_id','t2.dlr_zone_id','t2.dlr_subzone_id','t2.dlr_area_id')
                ->leftjoin('dealers as t2','dealer_id','=','t2.id')->where('invoice_no', 'Sal-119')->get(); */

    foreach($sales as $key => $data){
      $dealerdata = Dealer::where('id', $data->dealer_id)->first();
      $factories = Factory::find($data->warehouse_id);

      $qty = 0;
        $in = DB::table('chalans')->latest('id')->first();
        $temp = 0;
            if ($in) {
                $temp = 10000 + $in->id;
                $chalan = 'Cha-'.$temp;
            } else {
                $chalan = 'Cha-10000';
            }
  		$gTotal = 0;

         $date = $data->date;
         $invoice = $data->invoice_no;
         $salesitems = SalesItem::select('sale_id','product_id','item_type','qty','delivery_qty','remain_qty','discount','discount_amount','unit_price','total_price')->where('invoice_no',$data->invoice_no)->whereNotNull('chalan_no')->get();
         $totalCostOfFg = 0;$totalRawCostOfFg =0;  $totalCostOfRam = 0;

         foreach($salesitems as $key => $val){

           if($val->item_type == 'fg'){
            $product = SalesProduct::find($val->product_id);

            $total = 0;
            $disTemp = 0;
            $discount = 0;
           if($val->delivery_qty > 0 ) {
             $discount = ($val->discount_amount / $val->qty) * $val->delivery_qty;
             $total = $val->unit_price*$val->delivery_qty;
             $gTotal += $total - $discount;

           DB::table('chalans')->insert([
             			'date' => $date,
             			'item_type' => $data->item_type,
                  'sales_id' => $val->sale_id,
             			'dlr_address' => $dealerdata->dlr_address,
             			'vehicle' => '',
     					    'chalan_no' => $chalan,
                  'invoice_no' => $invoice,
                  'product_id' => $val->product_id,
             			'qty' => $val->qty,
             			'delivery_qty' => $val->delivery_qty,
             			'remain_qty' => $val->remain_qty,
             			'driver' => '',
             			'phone' => '',
                     ]);
     				//Employee Monthly sales targets
     				DB::table('montly_sales_targets')->insert([
                             'dealer_id' => $dealerdata->id,
                             'area_id' => $dealerdata->dlr_area_id,
                             'subzone_id' => $dealerdata->dlr_subzone_id,
                             'zone_id' => $dealerdata->dlr_zone_id,
                             'category_id' => $product->category_id,
                             'product_id' => $val->product_id,
                             'sale_id' => $val->sale_id,
                       		  'chalan_no' => $chalan,
                             'sales_invoice' => $invoice,
                             'date' => $date,
                             'qty_kg' => $product->product_weight * $val->delivery_qty
                         ]);

     				            $ledger = new SalesLedger();
                      $previous_ledger = SalesLedger::where('vendor_id', $data->dealer_id)->where('ledger_date', '<=', $data->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();
     					          $ledger->vendor_id = $data->dealer_id;
                         $ledger->zone_id = $data->dlr_zone_id;
                         $ledger->region_id = $data->dlr_subzone_id;
                         $ledger->area_id = $data->dlr_area_id;
                         $ledger->ledger_date = $date;
                         $ledger->invoice = $invoice;
                         $ledger->sale_id = $val->sale_id;
                         $ledger->chalan_no = $chalan;
                         $ledger->warehouse_bank_name = 'Sales (' .  $factories->factory_name . ')';
                         $ledger->warehouse_bank_id = $data->warehouse_id;
                         $ledger->is_bank = 0;
                         $ledger->product_name = $product->product_name;
                         $ledger->product_id = $val->product_id;
                         $ledger->category_id = $product->category_id;
                         $ledger->qty_kg = $product->product_weight * $val->delivery_qty;
                         $ledger->qty_pcs = $val->delivery_qty;
                         $ledger->unit_price = $val->unit_price;
                         $ledger->discount = $val->discount;

                         $ledger->discount_amount = $discount;

                         $ledger->total_price = $total - $discount;

                         if ($previous_ledger) {
                             $ledger->closing_balance = $previous_ledger->closing_balance;
                             $ledger->credit_limit = $previous_ledger->credit_limit;
                         }

                         $ledger->save();


                             $salesProduct = SalesStockIn::where('prouct_id',$val->product_id)->orderBy('id','DESC')->first();

                             if($salesProduct) {
                              $productCostBag = PackingConsumptions::where('pro_invoice',$salesProduct->sout_number)->whereNotNull('pro_invoice')->sum('amount');

                                 $individualCost = (($productCostBag) / (float)$salesProduct->quantity) * (int) $val->delivery_qty;

                                 $rate = (float)$salesProduct->production_rate;
                                 $individualRawCost = $rate * (int) $val->delivery_qty;
                                 $totalCostOfFg += $individualCost;
                                 $totalRawCostOfFg += $individualRawCost;
                             } else {
                                 $rate = SalesProduct::where('id', $val->product_id)->value('rate');
                                 $individualRawCost = (int) $val->delivery_qty * $rate;
                                 $totalCostOfFg += 0 ;
                                 $totalRawCostOfFg += $individualRawCost;
                             }


                               $stockOut = new SalesStockOut();
                               $stockOut->date = $date;
                               $stockOut->invoice = $invoice;
                               $stockOut->product_id = $val->product_id;
                               $stockOut->wirehouse_id = $data->warehouse_id;
                               $stockOut->qty = $val->delivery_qty;
                               $stockOut->rate = $rate;
                               $stockOut->amount = $individualRawCost;
                               $stockOut->note = $data->narration;
                               $stockOut->status = 1;
                               $stockOut->save();

                           }
             } else {
           	$product = RowMaterialsProduct::find($val->product_id);

             $total = $val->unit_price*$val->delivery_qty;
             $gTotal += $total;
             DB::table('chalans')->insert([
             			        'date' => $date,
               			      'item_type' => $data->item_type,
                          'sales_id' => $val->sale_id,
             			        'dlr_address' => $dealerdata->dlr_address,
             			        'vehicle' => '',
     					            'chalan_no' => $chalan,
                          'invoice_no' => $invoice,
                          'product_id' => $val->product_id,
             			        'qty' => $val->qty,
             			        'delivery_qty' => $val->delivery_qty,
             			        'remain_qty' => $val->remain_qty,
             			        'driver' => '',
             			        'phone' => '',
                     ]);

             $ledger = new SalesLedger();
                      $previous_ledger = SalesLedger::where('vendor_id', $data->dealer_id)->where('ledger_date', '<=', $data->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();
     					          $ledger->vendor_id = $data->dealer_id;
                         $ledger->zone_id = $data->dlr_zone_id;
                         $ledger->region_id = $data->dlr_subzone_id;
                         $ledger->area_id = $data->dlr_area_id;
                         $ledger->ledger_date = $date;
                         $ledger->invoice = $invoice;
                         $ledger->sale_id = $val->sale_id;
                         $ledger->chalan_no = $chalan;
                         $ledger->warehouse_bank_name = 'Sales (' .  $factories->factory_name . ')';
                         $ledger->warehouse_bank_id = $data->warehouse_id;
                         $ledger->is_bank = 0;
                         $ledger->product_name = $product->product_name;
                         $ledger->product_id = $val->product_id;
                         $ledger->category_id = $product->category_id;

                         $ledger->qty_pcs = $val->delivery_qty;
                         $ledger->unit_price = $val->unit_price;


                         $ledger->total_price = $total;

                         if ($previous_ledger) {
                             $ledger->closing_balance = $previous_ledger->closing_balance;
                             $ledger->credit_limit = $previous_ledger->credit_limit;
                         }

                         $ledger->save();

                             $purchaseProduct = Purchase::where('product_id',$val->product_id)->orderBy('purchase_id','DESC')->first();
                             $rawData = RowMaterialsProduct::where('id',$val->product_id)->first();
                             if($purchaseProduct){
                               if($rawData){
                                 $tempAmount = (float)$purchaseProduct->purchase_value + ($rawData->opening_balance * $rawData->rate);
                                 $tempQty = (int)$purchaseProduct->bill_quantity + $rawData->opening_balance;
                                 $rate = $tempAmount / $tempQty;
                                 $individualCost = $rate * (int) $val->delivery_qty;
                                 $totalCostOfRam += $individualCost;
                               } else {
                                 $rate = (float)$purchaseProduct->purchase_value / (int)$purchaseProduct->bill_quantity;

                                 $individualCost = $rate * (int) $val->delivery_qty;
                                 $totalCostOfRam += $individualCost;
                               }

                             } else {
                               $rate = $rawData->rate;
                               $individualCost = $rate * (int) $val->delivery_qty;
                               $totalCostOfRam += $individualCost;
                             }

                           $purchaseSOut =  new PurchaseStockout();
                           $purchaseSOut->product_id = $val->product_id;
                           $purchaseSOut->wirehouse_id = $data->warehouse_id;
                           $purchaseSOut->date = $date;
                           $purchaseSOut->sout_number = $invoice;
                           $purchaseSOut->stock_out_quantity = $val->delivery_qty;
                           $purchaseSOut->stock_out_rate = $rate;
                           $purchaseSOut->total_amount = $individualCost;
                           $purchaseSOut->save();

           }
         } //Sales-Item loop END

         $ledger = new SalesLedger();
         $ledger->vendor_id = $data->dealer_id;
         $ledger->zone_id = $data->dlr_zone_id;
         $ledger->region_id = $data->dlr_subzone_id;
         $ledger->area_id = $data->dlr_area_id;
         $ledger->invoice = $invoice;
         $ledger->chalan_no = $chalan;
         $ledger->warehouse_bank_name = 'Sales (' .  $factories->factory_name . ')';
         $ledger->warehouse_bank_id = $data->warehouse_id;
         $ledger->ledger_date = $date;
         $ledger->priority = 1;
         $ledger->debit = $gTotal;
         $ledger->save();

         if($data->item_type == 'fg' ){
           $this->createCreditForFinishedGoodsSale('Finished Goods Sales' , $gTotal,$date,$data->narration, $invoice);
           $this->createDebitForFinishedGoodsSale($data->dealer_id , $gTotal,$date,$data->narration, $invoice);

           $this->createCreditForCogsOfFinishedGoodsSale('Finished Goods',$totalCostOfFg + $totalRawCostOfFg  ,$date, $data->narration, $invoice);
           $this->createDeditForCogsOfFinishedGoodsSale('Cost of Good Sold of Finished Goods (FGCOGS)' , $totalRawCostOfFg ,$date, $data->narration, $invoice);
           $this->createDeditForCogsOfRawMaterialSale('Cost of Good Sold of Finished Goods (Packing)' ,  $totalCostOfFg ,$date, $data->narration, $invoice);
         }

         if($data->item_type == 'raw' ){
           $this->createCreditForFinishedGoodsSale('Finished Goods Sales' , $gTotal,$date,$data->narration, $invoice);
           $this->createDebitForRawMateriasSale($data->dealer_id , $gTotal,$date,$data->narration,$invoice);
           $this->createCreditForCogsOfRawMaterialSale('Raw Materials', $totalCostOfRam,$date,$data->narration,$invoice);
           $this->createDeditForCogsOfRawMaterialSale('Cost of Goods Sold of Raw Material (RMCOGS)' ,  $totalCostOfRam ,$date,$data->narration,$invoice);

          }
    }
    return redirect()->route('sales.chalan.index',$invoice)->with('success','Delivery Chalan Update Successfull!');
  }

    public function chalanStatusUpdate(Request $request, $invoice){


    foreach($request->id as $key => $data){
        
        
        
      $id = $request->product_id[$key];
      if($request->item_type[$key] == 'fg')
      {
        $product = SalesProduct::find($id);
        $name = $product->product_name;
        
        // echo "<pre>";
        // echo "SalesProduct";
        // print_r($product);
        // exit;
        
        $salesOrderQty = SalesLedger::where('product_id',$id)->where('category_id',$product->category_id)->where('invoice','LIKE','Sal-%')->sum('qty_pcs');
        
        $stockIn = SalesStockIn::where('prouct_id',$id)->sum('quantity');
        $salesReturn = DB::table('sales_return_items')->where('product_id',$id)->sum('qty');
        $salesDamage = SalesDamage::where('product_id',$id)->sum('quantity');
        
        $stock = ($product->opening_balance + $stockIn  + $salesReturn) - ($salesOrderQty + $salesDamage);
        if($stock < $request->delivery_qty[$key])
        {
            return redirect()->back()->with('warning','This '.$name.' is Out of Stock!');
        }
      } 
      else 
      {
        $product = RowMaterialsProduct::find($id);
        
        
        $name = $product->product_name;
        $salesOrderQty = SalesLedger::where('product_id',$id)->where('category_id',$product->category_id)->where('invoice','LIKE','Sal-%')->sum('qty_pcs');
        $stockIn = Purchase::where('product_id',$id)->sum('bill_quantity');
        $salesReturn = DB::table('sales_return_items')->where('product_id',$id)->sum('qty');
        $purchaseReturn = PurchaseReturn::where('product_id',$id)->sum('return_quantity');
        $salesDamage = SalesDamage::where('product_id',$id)->sum('quantity');
        $purchaseDamage = PurchaseDamage::where('product_id',$id)->sum('quantity');

        $stock = ($product->opening_balance + $stockIn  + abs($salesReturn) + $purchaseReturn) - ($salesOrderQty + $salesDamage + $purchaseDamage);
        
        // echo "<pre>";
        // echo "RowMaterialsProduct <br>";
        // print_r($product);
        // exit;
 
        if($stock < $request->delivery_qty[$key])
        {
          return redirect()->back()->with('warning','This '.$name.' is Out of Stock!');
        }

      }
    }

 DB::table('sales')->where('invoice_no', $invoice)->update([
      				      'vehicle' => $request->vehicle,
      				      'transport_cost' => $request->transport_cost,
      				      'ledger_status' =>1,
                    'chalan_status' => 1,
                    ]);
	$sales = Sale::select('dealer_id','warehouse_id','date','item_type','vendor_area_id','t2.dlr_zone_id','t2.dlr_subzone_id','t2.dlr_area_id')->where('invoice_no', $invoice)
              ->leftjoin('dealers as t2','dealer_id','=','t2.id')->first();
    $dealerdata = Dealer::where('id', $sales->dealer_id)->first();
    //dd($dealerdata);
    $factories = Factory::find($sales->warehouse_id);

    //$initial_ledger = SalesLedger::where('vendor_id',  $sales->dealer_id)->where('ledger_date', '<=', $sales->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();

    $qty = 0;
      $in = DB::table('chalans')->latest('id')->first();
      $temp = 0;
          if ($in) {
              $temp = 10000 + $in->id;
              $chalan = 'Cha-'.$temp;
          } else {
              $chalan = 'Cha-10000';
          }
		$gTotal = 0;
		$gDTotal = 0;
    $totalDiscount = 0;
      // $date = $request->date;
       $date = $sales->date;

    foreach($request->id as $key => $data){

      if($request->item_type[$key] == 'fg'){
       $product = SalesProduct::find($request->product_id[$key]);
       $total = 0;
       $disTemp = 0;
       $discount = 0;
      if($request->delivery_qty[$key] > 0 ) {
       //$discount = ($request->discount_amount[$key]/$request->qty[$key])*$request->delivery_qty[$key];
        //  $discount = ($product->product_weight * $request->delivery_qty[$key])*$request->discount[$key];
        $discount = ($request->discount_amount[$key] / $request->qty[$key]) * $request->delivery_qty[$key];
        $total = $request->unit_price[$key]*$request->delivery_qty[$key];
        //$gTotal += $total - $discount;
        $gTotal += $total;
        $gDTotal += $total - $discount;
        $totalDiscount += $discount;
      DB::table('chalans')->insert([
        			//'date' => $request->date,
        			'date' => $date,
        			'item_type' => $sales->item_type,
              'sales_id' => $request->id[$key],
        			'dlr_address' => $request->dlr_address,
        			'vehicle' => $request->vehicle,
					    'chalan_no' => $chalan,
              'invoice_no' => $invoice,
              'product_id' => $request->product_id[$key],
        			'qty' => $request->qty[$key],
        			'delivery_qty' => $request->delivery_qty[$key],
        			'remain_qty' => $request->remain_qty[$key],
        			'driver' => $request->driver,
        			'phone' => $request->phone,
                ]);
				//Employee Monthly sales targets
				DB::table('montly_sales_targets')->insert([
                        'dealer_id' => $dealerdata->id,
                        'area_id' => $dealerdata->dlr_area_id,
                        'subzone_id' => $dealerdata->dlr_subzone_id,
                        'zone_id' => $dealerdata->dlr_zone_id,
                        'category_id' => $product->category_id,
                        'product_id' => $request->product_id[$key],
                        'sale_id' => $request->id[$key],
                  		  'chalan_no' => $chalan,
                        'sales_invoice' => $invoice,
                        'date' => $date,
                        'qty_kg' => $product->product_weight * $request->delivery_qty[$key]
                    ]);

				            $ledger = new SalesLedger();
                    $previous_ledger = SalesLedger::select('vendor_id',DB::raw('SUM(debit) - SUM(credit) as balance'))->where('vendor_id', $sales->dealer_id)->where('ledger_date', '<=', $sales->date)->get();
					          $ledger->vendor_id = $sales->dealer_id;
                    $ledger->zone_id = $sales->dlr_zone_id;
                    $ledger->region_id = $sales->dlr_subzone_id;
                    $ledger->area_id = $sales->dlr_area_id;
                    $ledger->ledger_date = $date;
      				      //$ledger->ledger_date = $request->date;
                    $ledger->invoice = $invoice;
                    $ledger->sale_id = $request->id[$key];
                    $ledger->chalan_no = $chalan;
                    $ledger->warehouse_bank_name = 'Sales (' .  $factories->factory_name . ')';
                    $ledger->warehouse_bank_id = $sales->warehouse_id;
                    $ledger->is_bank = 0;
                    $ledger->narration = $request->narration ?? $sales->narration;
                    $ledger->product_name = $product->product_name;
                    $ledger->product_id = $request->product_id[$key];
                    $ledger->category_id = $product->category_id;
                    $ledger->qty_kg = $product->product_weight * $request->delivery_qty[$key];
                    $ledger->qty_pcs = $request->delivery_qty[$key];
                    $ledger->unit_price = $request->unit_price[$key];
                    $ledger->discount = $request->discount[$key];

                    $ledger->discount_amount = $discount;

                    $ledger->total_price = $total - $discount;

                    if ($previous_ledger) {
                        $ledger->closing_balance = $previous_ledger[0]->balance;
                       // $ledger->credit_limit = $previous_ledger->credit_limit;
                    }

                    $ledger->save();

      				      $deliQty = 0;
                    $remQty = 0;
                      $salesItem = DB::table('sales_items')->select('delivery_qty','remain_qty')->where('id', $request->id[$key])->first();
                   if(!empty($salesItem)){
        			      $deliQty = $salesItem->delivery_qty + $request->delivery_qty[$key];
                     } else {
                     $deliQty = $request->delivery_qty[$key];
                     }
                     $remQty = $request->remain_qty[$key];

                      DB::table('sales_items')->where('id', $request->id[$key])->update([
                        				'chalan_no' => $chalan,
                                        'delivery_qty' => $deliQty,
                                        'remain_qty' => $remQty,
                        ]);
                      }
                    } else {
      	            $product = RowMaterialsProduct::find($request->product_id[$key]);
                    $discount = ($request->discount_amount[$key] / $request->qty[$key]) * $request->delivery_qty[$key];
                    $total = $request->unit_price[$key]*$request->delivery_qty[$key];
                        $gTotal += $total;
                        $gDTotal += $total - $discount;
                        DB::table('chalans')->insert([
        			          'date' => $date,
          			        'item_type' => $sales->item_type,
                        'sales_id' => $request->id[$key],
        			          'dlr_address' => $request->dlr_address,
        			          'vehicle' => $request->vehicle,
					              'chalan_no' => $chalan,
                        'invoice_no' => $invoice,
                        'product_id' => $request->product_id[$key],
        			          'qty' => $request->qty[$key],
        			          'delivery_qty' => $request->delivery_qty[$key],
        			          'remain_qty' => $request->remain_qty[$key],
        			          'driver' => $request->driver,
        			          'phone' => $request->phone,
                ]);

                    $ledger = new SalesLedger();
                    $previous_ledger = SalesLedger::select('vendor_id',DB::raw('SUM(debit) - SUM(credit) as balance'))->where('vendor_id', $sales->dealer_id)->where('ledger_date', '<=', $sales->date)->get();
					$ledger->vendor_id = $sales->dealer_id;
                    $ledger->zone_id = $sales->dlr_zone_id;
                    $ledger->region_id = $sales->dlr_subzone_id;
                    $ledger->area_id = $sales->dlr_area_id;
                    $ledger->ledger_date = $date;
      				//$ledger->ledger_date = $request->date;
                    $ledger->invoice = $invoice;
                    $ledger->sale_id = $request->id[$key];
                    $ledger->chalan_no = $chalan;
                    $ledger->warehouse_bank_name = 'Sales (' .  $factories->factory_name . ')';
                    $ledger->warehouse_bank_id = $sales->warehouse_id;
                    $ledger->is_bank = 0;
                    $ledger->narration = $request->narration ?? $sales->narration;
                    $ledger->product_name = $product->product_name;
                    $ledger->product_id = $request->product_id[$key];
                    $ledger->category_id = $product->category_id;

                    $ledger->qty_pcs = $request->delivery_qty[$key];
                    $ledger->unit_price = $request->unit_price[$key];
                    $ledger->discount = $request->discount[$key];

                    $ledger->discount_amount = $discount;

                    $ledger->total_price = $total - $discount;

                    if ($previous_ledger) {
                        $ledger->closing_balance = $previous_ledger[0]->balance;
                        //$ledger->credit_limit = $previous_ledger->credit_limit;
                    }

                    $ledger->save();
        			         $deliQty = 0;
                    $remQty = 0;
                      $salesItem = DB::table('sales_items')->select('delivery_qty','remain_qty')->where('id', $request->id[$key])->first();
                   if(!empty($salesItem)){
        			          $deliQty = $salesItem->delivery_qty + $request->delivery_qty[$key];
                     } else {
                     $deliQty = $request->delivery_qty[$key];
                     }
                    $remQty = $request->remain_qty[$key];

                      DB::table('sales_items')->where('id', $request->id[$key])->update([
                        				'chalan_no' => $chalan,
                                        'delivery_qty' => $deliQty,
                                        'remain_qty' => $remQty,
                        ]);

      }
  }

    /*$check_invoice = SalesLedger::where('invoice', $invoice)->where('priority', 1)->first();
    if (!$check_invoice) { */
               //$previous_ledger = SalesLedger::where('vendor_id', $sales->dealer_idd)->where('ledger_date', '<=', $sales->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();

                $ledger = new SalesLedger();
                $ledger->vendor_id = $sales->dealer_id;
                $ledger->zone_id = $sales->dlr_zone_id;
                $ledger->region_id = $sales->dlr_subzone_id;
                $ledger->area_id = $sales->dlr_area_id;
                $ledger->invoice = $invoice;
          		  $ledger->chalan_no = $chalan;
                $ledger->warehouse_bank_name = 'Sales (' .  $factories->factory_name . ')';
                $ledger->warehouse_bank_id = $sales->warehouse_id;
                $ledger->ledger_date = $date;
                $ledger->narration = $request->narration ?? $sales->narration;
     			      //$ledger->ledger_date = $request->date;
                $ledger->priority = 1;
                $ledger->debit = $gDTotal;
                $ledger->save();

              //  dd($sales);

                if($request->item_type[0] == 'fg' ){
                  $this->createCreditForFinishedGoodsSale('Finished Goods Sales' , $gTotal,$date,$sales->narration, $invoice);
                  $this->createDebitForFinishedGoodsSale($sales->dealer_id , $gDTotal,$date,$sales->narration, $invoice);
                  $this->expenseSubGroupDebit('Discount ledger- dealer' , $totalDiscount,$date,$sales->narration, $invoice);

                  $totalCostOfFg = 0;$totalRawCostOfFg = 0;
                  for($i = 0; $i < count($request->product_id); $i++){
                    $salesProduct = SalesStockIn::where('prouct_id',$request->product_id[$i])->orderBy('id','DESC')->first();
                    $openingData = SalesProduct::where('id', $request->product_id[$i])->first();
                    if($salesProduct) {
                  // dd($salesProduct->sout_number);
                    $checkStr = substr($salesProduct->sout_number, 0,3);
                    if($checkStr == 'PRO'){
                      $rawInfos = PurchaseStockout::where('finish_goods_id',$request->product_id[$i])->where('sout_number',$salesProduct->sout_number)->get();
                      $packingInfos = PackingConsumptions::where('pro_invoice',$salesProduct->sout_number)->get();

                      foreach($rawInfos as $rawInfo){
                        $amount = (($rawInfo->total_amount) / (float)$salesProduct->quantity) * (int) $request->delivery_qty[$i];
                        $qty = (($rawInfo->stock_out_quantity) / (float)$salesProduct->quantity) * (int) $request->delivery_qty[$i];

                        $rawStockOut = new RawMaterialStockOut();
                        $rawStockOut->date = $date;
                        $rawStockOut->invoice = $invoice;
                        $rawStockOut->raw_product_id = $rawInfo->product_id;
                        $rawStockOut->product_id = $request->product_id[$i];
                        $rawStockOut->wirehouse_id = $sales->warehouse_id;
                        $rawStockOut->qty = $qty;
                        $rawStockOut->rate = $rawInfo->stock_out_rate;
                        $rawStockOut->amount = $amount;
                        $rawStockOut->note = $salesProduct->sout_number.' '.$sales->narration;
                        $rawStockOut->status = 1;
                        $rawStockOut->save();

                      }

                      if($packingInfos){
                        foreach($packingInfos as $packingInfo){
                          $amount = (($packingInfo->amount) / (float)$salesProduct->quantity) * (int) $request->delivery_qty[$i];
                          $qty = (($packingInfo->qty) / (float)$salesProduct->quantity) * (int) $request->delivery_qty[$i];

                          $packingStockOut = new PackingStockOut();
                          $packingStockOut->date = $date;
                          $packingStockOut->invoice = $invoice;
                          $packingStockOut->packing_id = $packingInfo->bag_id;
                          $packingStockOut->product_id = $request->product_id[$i];
                          $packingStockOut->wirehouse_id = $sales->warehouse_id;
                          $packingStockOut->qty = $qty;
                          $packingStockOut->rate = $packingInfo->rate;
                          $packingStockOut->amount = $amount;
                          $packingStockOut->note = $sales->narration;
                          $packingStockOut->status = 1;
                          $packingStockOut->save();
                        }
                      }
                    } else {
                      $rate = $openingData->rate;
                      $individualRawCost = (int) $request->delivery_qty[$i] * $rate;

                      $rawStockOut = new RawMaterialStockOut();
                      $rawStockOut->date = $date;
                      $rawStockOut->invoice = $invoice;
                    //  $rawStockOut->raw_product_id = $rawInfo->product_id;
                      $rawStockOut->product_id = $request->product_id[$i];
                      $rawStockOut->wirehouse_id = $sales->warehouse_id;
                      $rawStockOut->qty = $request->delivery_qty[$i];
                      $rawStockOut->rate = $rate;
                      $rawStockOut->amount = $individualRawCost;
                      $rawStockOut->note = $request->narration ?? $sales->narration;
                      $rawStockOut->status = 2;
                      $rawStockOut->save();
                    }

                        $productCostBag = PackingConsumptions::where('pro_invoice',$salesProduct->sout_number)->whereNotNull('pro_invoice')->sum('amount');
                        $individualCost = (($productCostBag) / (float)$salesProduct->quantity) * (int) $request->delivery_qty[$i];

                        //$individualRawCost = (((float)$salesProduct->total_cost ) / (float)$salesProduct->quantity) * (int) $request->delivery_qty[$i];
                        $tempAmount = $salesProduct->total_cost + ($openingData->opening_balance * $openingData->rate);
                        $tempQty = $salesProduct->quantity + $openingData->opening_balance;

                        //$rate = (float)$salesProduct->production_rate;
                        $rate = $tempAmount/$tempQty;

                        $individualRawCost = $rate * (int) $request->delivery_qty[$i];
                        $totalCostOfFg += $individualCost;
                        $totalRawCostOfFg += $individualRawCost;

                    } else {
                        $rate = $openingData->rate;
                        $individualRawCost = (int) $request->delivery_qty[$i] * $rate;
                        $totalCostOfFg += 0 ;
                        $totalRawCostOfFg += $individualRawCost;

                        $rawStockOut = new RawMaterialStockOut();
                        $rawStockOut->date = $date;
                        $rawStockOut->invoice = $invoice;
                      //  $rawStockOut->raw_product_id = $rawInfo->product_id;
                        $rawStockOut->product_id = $request->product_id[$i];
                        $rawStockOut->wirehouse_id = $sales->warehouse_id;
                        $rawStockOut->qty = $request->delivery_qty[$i];
                        $rawStockOut->rate = $rate;
                        $rawStockOut->amount = $individualRawCost;
                        $rawStockOut->note = $request->narration ?? $sales->narration;
                        $rawStockOut->status = 2;
                        $rawStockOut->save();

                    }

                    $stockOut = new SalesStockOut();
                    $stockOut->date = $date;
                    $stockOut->invoice = $invoice;
                    $stockOut->product_id = $request->product_id[$i];
                    $stockOut->wirehouse_id = $sales->warehouse_id;
                    $stockOut->qty = $request->delivery_qty[$i];
                    $stockOut->rate = $rate;
                    $stockOut->amount = $individualRawCost;
                    $stockOut->note = $request->narration ?? $sales->narration;
                    $stockOut->status = 1;
                    $stockOut->save();
                  }

                  $this->createCreditForCogsOfFinishedGoodsSale('Finished Goods',$totalCostOfFg + $totalRawCostOfFg  ,$date,$sales->narration, $invoice);
                  $this->createDeditForCogsOfFinishedGoodsSale('Cost of Good Sold of Finished Goods (FGCOGS)' , $totalRawCostOfFg ,$date,$sales->narration, $invoice);
                  $this->createDeditForCogsOfRawMaterialSale('Cost of Good Sold of Finished Goods (Packing)' ,  $totalCostOfFg ,$date,$sales->narration, $invoice);


                }

                if($request->item_type[0] == 'raw' ){
                 // $this->createCreditForRawMaterialsSale('Finished Goods Sales' , $gTotal,$date,$sales->narration,$invoice);
                  $this->createCreditForFinishedGoodsSale('Finished Goods Sales' , $gTotal,$date,$sales->narration, $invoice);
                  $this->createDebitForRawMateriasSale($sales->dealer_id , $gDTotal,$date,$sales->narration,$invoice);
                  $this->expenseSubGroupDebit('Discount ledger- dealer' , $totalDiscount,$date,$sales->narration, $invoice);
                  $totalCostOfRam = 0;
                 /* for($i = 0; $i < count($request->product_id); $i++){
                    $purchaseProduct = Purchase::where('product_id',$request->product_id[$i])->orderBy('purchase_id','DESC')->first();

                    if($purchaseProduct){
                        $individualCost = ((float)$purchaseProduct->purchase_value / (int)$purchaseProduct->bill_quantity) * (int) $request->delivery_qty[$i];
                        $totalCostOfRam += $individualCost;
                    }
                  } */

                  for($i = 0; $i < count($request->product_id); $i++){
                    $purchaseProduct = Purchase::where('product_id',$request->product_id[$i])->orderBy('purchase_id','DESC')->first();
                    $rawData = RowMaterialsProduct::where('id',$request->product_id[$i])->first();
                    if($purchaseProduct){
                      if($rawData){
                        $tempAmount = (float)$purchaseProduct->purchase_value + ($rawData->opening_balance * $rawData->rate);
                        $tempQty = (int)$purchaseProduct->bill_quantity + $rawData->opening_balance;
                        $rate = $tempAmount / $tempQty;
                        $individualCost = $rate * (int) $request->delivery_qty[$i];
                        $totalCostOfRam += $individualCost;
                      } else {
                        $rate = (float)$purchaseProduct->purchase_value / (int)$purchaseProduct->bill_quantity;

                        $individualCost = $rate * (int) $request->delivery_qty[$i];
                        $totalCostOfRam += $individualCost;
                      }

                    } else {
                      $rate = $rawData->rate;
                      $individualCost = $rate * (int) $request->delivery_qty[$i];
                      $totalCostOfRam += $individualCost;
                    }

                  $purchaseSOut =  new PurchaseStockout();
                  $purchaseSOut->product_id = $request->product_id[$i];
                  $purchaseSOut->wirehouse_id = $sales->warehouse_id;
                  $purchaseSOut->date = $date;
                  $purchaseSOut->sout_number = $invoice;
                  $purchaseSOut->stock_out_quantity = $request->delivery_qty[$i];
                  $purchaseSOut->stock_out_rate = $rate;
                  $purchaseSOut->total_amount = $individualCost;
                  $purchaseSOut->note = $request->narration ?? $sales->narration;
                  $purchaseSOut->save();

                  }

                  $this->createCreditForCogsOfRawMaterialSale('Raw Materials', $totalCostOfRam,$date,$sales->narration,$invoice);
                  $this->createDeditForCogsOfRawMaterialSale('Cost of Goods Sold of Raw Material (RMCOGS)' ,  $totalCostOfRam ,$date,$sales->narration,$invoice);

                 }

		return redirect()->route('sales.chalan.index',$invoice)->with('success','Delivery Chalan Update Successfull!');
     //return redirect()->route('chalan.print',$invoice,$chalan)->with('success','Delivery Chalan Update Successfull!');
     //return redirect()->route(url("/sales/chalan/print/{$invoice}/{$chalan}"))->with('success','Delivery Chalan Update Successfull!');
  }



  public function chalanDelete(Request $request){
  $invoice = DB::table('chalans')->where('chalan_no',$request->id)->value('invoice_no');
   /* DB::table('sales')->where('invoice_no', $invoice)->update([
                    'ledger_status' =>0,
                    'chalan_status' => 0,
                    ]); */
    $datas = DB::table('chalans')->select('invoice_no','product_id','delivery_qty')->where('chalan_no',$request->id)->get();
    foreach($datas as $val){
      $deliQty = 0;
      $remQty = 0;
      	$salesItem = DB::table('sales_items')->select('delivery_qty','remain_qty')->where('invoice_no', $val->invoice_no)->where('product_id', $val->product_id)->first();
      $deliQty = $salesItem->delivery_qty - $val->delivery_qty;
      $remQty = $salesItem->remain_qty + $val->delivery_qty;
    	DB::table('sales_items')->where('invoice_no', $val->invoice_no)
          ->where('product_id', $val->product_id)->update([
                          'delivery_qty' => $deliQty,
                          'remain_qty' => $remQty,
                        ]);
    }
    DB::table('montly_sales_targets')->where('chalan_no',$request->id)->delete();
    DB::table('sales_ledgers')->where('chalan_no',$request->id)->delete();
    DB::table('chalans')->where('chalan_no',$request->id)->delete();
    return redirect()->back()->with('success','Chalan Delete Successfull');
  }

  public function chalanPrint($invoice,$chalan){
  //dd($invoice);
    $salesdetails = Sale::select('sales.*','dealers.d_s_name','factories.factory_name')
        ->leftjoin('dealers', 'sales.dealer_id', '=', 'dealers.id')
        ->leftjoin('factories', 'sales.warehouse_id', '=', 'factories.id')
        ->where('invoice_no', $invoice)
        ->first();
    $salesitems = SalesItem::select('sales_items.*','sales_products.product_name')
        ->leftjoin('sales_products', 'sales_items.product_id', '=', 'sales_products.id')
        ->where('invoice_no', $invoice)
        ->get();
    $chalanDate = DB::table('chalans')->where('chalan_no', $chalan)->value('date');
	$user = User::where('id',Auth::id())->value('name');
    return view('backend.sales_delivery.chalanPrint', compact('user','chalanDate','invoice','salesdetails','salesitems'));
  }
}
