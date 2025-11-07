<?php

namespace App\Http\Controllers\Sales;

use Session;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Dealer;
use App\Models\Factory;
use App\Models\Employee;
use App\Models\Ctc;
// use App\Models\Dealer_demand;
// use App\Models\Ddl_check_out;
// use App\Models\Transaction;
use App\Models\SalesItem;
use App\Models\SalesOrder;
use App\Models\SalesLedger;
use App\Models\CommissionIn;
// use App\Models\Returnstbl;
// use App\Models\ReturnItem;
// use App\Models\Batch;
// use App\Models\DeliveryConfirm;
// use App\Models\Vehicle;
use App\Models\SalesProduct;
use App\Models\SalesStockOut;
// use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Demand_number;
use App\Models\SalesOrderItem;
use App\Models\RowMaterialsProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ChartOfAccount;
use App\Models\Purchase;
use App\Models\PurchaseStockout;
use App\Models\RawMaterialStockOut;
use App\Models\PackingStockOut;
use App\Models\Account\ChartOfAccounts;

class OrderController extends Controller
{
  use ChartOfAccount;
    public function index(Request $request)
    {
      	//dd($request->all());
       $dateq = '';

      if ($request->date) {
                $date = $request->date;
                $dates = explode(' - ', $request->date);
                $fdate = date('Y-m-d', strtotime($dates[0]));
                $tdate = date('Y-m-d', strtotime($dates[1]));

                $dateq = 'AND sales_orders.date BETWEEN "'.$fdate.'" AND "'.$tdate.'"';

       /* $orderlist = DB::select('SELECT sales_orders.*,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales_orders`
        LEFT JOIN dealers ON dealers.id = sales_orders.dealer_id
        LEFT JOIN factories ON factories.id = sales_orders.warehouse_id
        LEFT JOIN users ON users.id = sales_orders.emp_id
        WHERE is_active=1 '.$dateq.'
        order by  date desc,invoice_no desc LIMIT 800'); */

        $orderlist = SalesOrder::selectRaw('*,ROW_NUMBER() OVER (ORDER BY id) AS row_num')
                     ->select('sales_orders.*','dealers.d_s_name','factories.factory_name')->leftJoin('dealers','sales_orders.dealer_id','=','dealers.id')
                    ->leftJoin('factories','sales_orders.warehouse_id','=','factories.id')
                    ->leftJoin('users','sales_orders.emp_id','=','users.id')->where('is_active',1)->whereBetween('sales_orders.date',[$fdate,$tdate])->orderby('sales_orders.date','desc')->orderby('sales_orders.invoice_no','desc')->paginate(10);
      } else {
     /* $orderlist = DB::select('SELECT sales_orders.*,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales_orders`
        LEFT JOIN dealers ON dealers.id = sales_orders.dealer_id
        LEFT JOIN factories ON factories.id = sales_orders.warehouse_id
        LEFT JOIN users ON users.id = sales_orders.emp_id
        WHERE is_active=1
        order by  date desc,invoice_no desc LIMIT 800');
        */
        $orderlist = SalesOrder::selectRaw('*,ROW_NUMBER() OVER (ORDER BY id) AS row_num')->select('sales_orders.*','dealers.d_s_name','factories.factory_name')->leftJoin('dealers','sales_orders.dealer_id','=','dealers.id')
                    ->leftJoin('factories','sales_orders.warehouse_id','=','factories.id')
                    ->leftJoin('users','sales_orders.emp_id','=','users.id')->where('is_active',1)->orderby('sales_orders.date','desc')->orderby('sales_orders.invoice_no','desc')->paginate(10);;
      }
	//dd($orderlist);
        // return view('backend.sales_order_order.index', compact('saleslist', 'dealers', 'factoryes', 'warehouse_id', 'dealer_id', 'date', 'invoice'));
        return view('backend.sales_order.index', compact('orderlist'));
    }



    public function invoiceView($invoice)
    {
        $salesdetails = Sale::select('sales.*', 'dealers.d_s_name', 'factories.factory_name')
            ->leftjoin('dealers', 'sales.dealer_id', '=', 'dealers.id')
            ->leftjoin('factories', 'sales.warehouse_id', '=', 'factories.id')
            ->where('invoice_no', $invoice)
            ->first();
        $salesitems = SalesItem::where('invoice_no', $invoice)->get();

        //dd($salesitems);
        return view('backend.sales_order.invoice', compact('salesdetails', 'salesitems', 'invoice'));
    }


    public function demandeNumber()
    {
        $demandnumber = DB::select('SELECT demand_numbers.id as invoice_no FROM `demand_numbers` ORDER BY demand_numbers.id DESC LIMIT 1 ');
        return response($demandnumber);
    }

    public function getproductprice($id, $vendorid)
    {
        $special_rate_data = DB::table('special_rates')->where('dealer_id', $vendorid)->first();

        if ($special_rate_data) {

            $date = DB::table('sales_products')->where('id', $id)->first();
            $pruductprice = $date->product_dp_price + ($date->product_weight * $special_rate_data->rate_kg);
        } elseif ($vendorid == 696) {
            $pruductprice = DB::table('sales_products')->where('id', $id)->value('product_mrp');
        } else {
            $pruductprice = DB::table('sales_products')->where('id', $id)->value('product_dp_price');
        }


        return response($pruductprice);
    }


    public function demandcreate(Request $request)
    {
	//dd($request->all());
        $id = Auth::id();
		$data = [];
        $dealerlogid = Dealer::latest('id')->where('user_id', '=', $id)->get();
        $products = SalesProduct::orderBy('product_name', 'ASC')->get();
        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $employees = Employee::latest('id')->get();
        $factoryes = Factory::latest('id')->get();
      	$rawProducts = RowMaterialsProduct::select('id','product_name')->orderBy('product_name', 'ASC')->get();

      //	$products = array_merge( $data['fgProducts'],$data['rawProducts']);
      	//dd($products);
        // $vehicles = Vehicle::all();
        $vehicles = '';
        //dd( $request->all());
        if ($request->session()->has('my_date')) {
            $date = $request->session()->get('my_date');
        } else {
            $date = date('d M Y');
        }
        if ($request->session()->has('wr_id')) {
            $wr_id = $request->session()->get('wr_id');
            $wr_info = Factory::find($wr_id)->factory_name;
        } else {
            $wr_id = '';
            $wr_info = '';
        }

        return view('backend.sales_order.poscreate', compact('products','rawProducts','factoryes', 'wr_id', 'wr_info', 'date', 'dealers', 'dealerlogid', 'employees', 'vehicles'));
    }








    public function demandgenerate(Request $request)
    {
      // dump($request->products_id);

      //  return $totalCost;
      //  return $request->all();

      // dd($request->all());
       $dealer = $request->dealer_id;
       $products = $request->products_id;
      //dd($products);
        /* $cyear = date('Y');
        $cmonth = date('m'); */
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
      	 $cyear = date('Y',strtotime($date_f));
         $cmonth = date('m',strtotime($date_f));

        if ($request->warehouse_id) {
            $wr_id = $request->warehouse_id;
            $wr_id_put = $request->session()->put('wr_id', $wr_id);
        }

        /* if (empty($request->products_id) or empty($request->qty)) {
          	Session::put('error', 'Please Insert Product.');
            return redirect()->back();
          //->with('error', 'Please Insert Product')
        } */

        //dd($factories);
        $demandInvoNumber = new Demand_number();
        $demandInvoNumber->total_qty = $request->grand_total_qty;
        $demandInvoNumber->user_id = $id;
        $demandInvoNumber->save();

        $factories = Factory::find($request->warehouse_id);

        $delaer_area_id = DB::table('dealers')->where('id', $request->dealer_id)->value('dlr_area_id');
        $delaer_area_name = DB::table('dealer_areas')->where('id', $delaer_area_id)->value('area_title');

        $dealerdata = Dealer::where('id', $request->dealer_id)->first();
        //dd($dealerdata);
  if(!empty($products[0])) {

        $sale = new SalesOrder();
        $sale->item_type = 'fg';
        $sale->warehouse_id = $request->warehouse_id;
        $sale->dealer_id = $request->dealer_id;
        $sale->emp_id = $id;
        $sale->user_id = Auth::user()->id;
        //$sale->user_name = $userName;
        $sale->vendor_area_id = $delaer_area_id;
        $sale->vendor_area =  $delaer_area_name;
        $sale->date = $date_f;
        //    $sale->vehicle = $request->vehicle;
        //    $sale->transport_cost = $request->transport_cost;
        $sale->invoice_no = 'Sal-'.$demandInvoNumber->id;
        $sale->total_qty = $request->grand_total_qty;
        $sale->price = $request->grand_total_value;
        //$sale->discount = $request->grand_total_discount;
        //    $sale->price = $total_price;
        //    $sale->grand_total = $total_price;
        $sale->grand_total = $request->total_payable;
        //$sale->grand_total = $request->total_payable;
        $sale->narration = $request->naration;
        $sale->demand_month = $cmonth;
        $sale->demand_year = $cyear;
        // $sale->save();
        //dd($sale);
        if ($sale->save()) {




            foreach ($request->products_id as $key => $item) {
                //$product = SalesProduct::find($request->products_id[$key]);
              $product = SalesProduct::where('id',$item)->first();
              	                //FOr montly Sales
              if(!empty($product->product_weight)){
              	$qtykg = $product->product_weight * $request->p_qty[$key];
              } else {
               $qtykg = 0;
              }


			 // $com = DB::table('product_commissions')->where('product_id', $item)->first();
			//dd($product->category_id);
                $sale_item = new SalesOrderItem();
                //$sale_item->sale_id = $sale->id;
                $sale_item->date = $date_f;
                $sale_item->dealer_id = $request->dealer_id;
                $sale_item->area_id = $delaer_area_id;
                $sale_item->invoice_no = 'Sal-'.$demandInvoNumber->id;
              	$sale_item->item_type = 'fg';
                $sale_item->product_id = $item;
                $sale_item->category_id = $product->category_id;
                $sale_item->product_name = $product->product_name;
                $sale_item->product_code = $product->product_code;
                $sale_item->product_weight = $product->product_weight;
                $sale_item->qty = $request->p_qty[$key];

              //  $sale_item->discount = $com;
              //	$sale_item->discount_amount = $discount;

                $sale_item->unit_price = $request->p_price[$key];
                $sale_item->total_price = $request->total_price_without_discount[$key];
              //  $sale_item->total_price = $request->total_price_without_discount[$key] - $discount;

                //    $sale_item->unit_price = $product_unit_price;
                // $sale_item->total_price = $product_total_price;

                //dd($sale_item);
                $sale_item->save();

                //FOr product Sales commission
              if($product->category_id == 33){
              	   Session::put('success', 'Order Created Successfull. Please Check Order List.');
              } elseif($dealerdata->dlr_type_id == 25) {
             		   Session::put('success', 'Order Created Successfull. Please Check Order List.');
                  } elseif($dealerdata->dlr_type_id == 24) {
					         Session::put('success', 'Order Created Successfull. Please Check Order List.');
                  } elseif($dealerdata->dlr_type_id == 22) {
                	 Session::put('success', 'Order Created Successfull. Please Check Order List.');
                } elseif($dealerdata->dlr_type_id == 26){
              		$otherComission = DB::table('fixed_dealer_comissions')->where('dealer_id',$request->dealer_id)->where('category_id',$product->category_id)->first();
              		if(!empty($otherComission)){
                    } else {
                    		      $data = Ctc::where('invoice_no',$demandInvoNumber->id)->where('category_id',$product->category_id)->first();
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
                } else {
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

              Session::put('success', 'Order Created Successfull. Please Check Order List.');
            }

        }


/*
            $totalDisscount = 0;
            $totalPayable = 0;

            foreach($request->products_id as $index => $val) {
            $ton = 0; $maxTon = 0;
            $product = DB::table('sales_products')->where('id', $request->products_id[$index])->first();
            $comData = DB::table('ctcs')->select('ton', 'category_id','sale_id')->where('invoice_no', $demandInvoNumber->id)->where('category_id', $product->category_id)->first();
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
                   //dd($com);
                  //sales item commission set
                   $salesItem = SalesOrderItem::where('invoice_no', $demandInvoNumber->id)->where('product_id',$request->products_id[$index])->first();
                   //dd($salesItem);
                   $salesItem->discount = $com;
                   $salesItem->discount_amount = $discount;
                   $salesItem->total_price = $request->total_price[$index] - $discount;
                   $salesItem->save();
                   //dd($com);
                   DB::table('ctcs')->where('invoice_no',$demandInvoNumber->id)->where('category_id',$product->category_id)->update(['discount'=> $com, 'discount_amount' => $com*$ton*1000]);
          }
          $totalPayable = $request->total_payable - $totalDisscount;
          DB::table('sales_orders')->where('invoice_no',$demandInvoNumber->id)->update(['grand_total' => $totalPayable,'discount'=> $totalDisscount]);

        } */

        //DB::table('ctcs')->where('invoice_no',$demandInvoNumber->id)->delete();
    } else {
       // dd('PP Bag');
        $sale = new SalesOrder();
        $sale->item_type = 'raw';
        $sale->warehouse_id = $request->warehouse_id;
        $sale->dealer_id = $request->dealer_id;
        $sale->emp_id = $id;
        $sale->user_id = Auth::user()->id;
        $sale->vendor_area_id = $delaer_area_id;
        $sale->vendor_area =  $delaer_area_name;
        $sale->date = $date_f;
        $sale->invoice_no = 'Sal-'.$demandInvoNumber->id;
        $sale->total_qty = $request->grand_total_qty;
        $sale->price = $request->grand_total_value;
        $sale->grand_total = $request->total_payable;
        $sale->narration = $request->narration;
        $sale->demand_month = $cmonth;
        $sale->demand_year = $cyear;
        // $sale->save();
         if ($sale->save()) {




            foreach ($request->raw_products_id as $key => $item) {
            	$product = RowMaterialsProduct::where('id',$item)->first();
               	$sale_item = new SalesOrderItem();
                $sale_item->date = $date_f;
                $sale_item->dealer_id = $request->dealer_id;
                $sale_item->area_id = $delaer_area_id;
                $sale_item->invoice_no = 'Sal-'.$demandInvoNumber->id;
              	$sale_item->item_type = 'raw';
                $sale_item->product_id = $item;
                $sale_item->category_id = $product->category_id;
                $sale_item->product_name = $product->product_name;
                $sale_item->product_code = $product->code ?? '';

                $sale_item->qty = $request->p_qty[$key];
                $sale_item->unit_price = $request->p_price[$key];
                $sale_item->total_price = $request->total_price_without_discount[$key];
                $sale_item->save();
            }
         }
        }
        Session::put('success', 'Order Created Successfull. Please Check Order List.');


        return redirect()->back();
        // ->with('success','Product Sales Successfull');

    }

    public function orderconfirm(Request $request)
    {
      //  dd($request->all());
        $cyear = date('Y');
        $cmonth = date('m');

        // dd($request);
        $id = Auth::id();
        // dd($id);
        $userName = DB::select('select users.name from users where users.id="' . $id . '"');
        //dd($userName[0]->name);
        $demandInvoNumber = Demand_number::where('id',$request->invoice)->first();
        $requestOrder = SalesOrder::where('invoice_no',$request->invoice)->first();
        $factories = Factory::find($requestOrder->warehouse_id);
        //dd($factories);

        $dealerdata = Dealer::where('id', $requestOrder->dealer_id)->first();

        $sale = new Sale();
        $sale->date = $requestOrder->date;
        $sale->item_type = $request->item_type;
        $sale->warehouse_id = $requestOrder->warehouse_id;
        $sale->dealer_id = $requestOrder->dealer_id;
        $sale->vendor_area_id = $requestOrder->vendor_area_id;
        $sale->vendor_area =  $requestOrder->vendor_area;
        $sale->invoice_no = 'Sal-'.$demandInvoNumber->id;
        $sale->total_qty = $requestOrder->total_qty;
        $sale->price = $requestOrder->price;
        $sale->discount = $requestOrder->discount;
         $sale->grand_total = $requestOrder->grand_total;

        $sale->user_id = Auth::user()->id;
        $sale->narration = $requestOrder->narration;
        $sale->demand_month = $cmonth;
        $sale->demand_year = $cyear;
        $sale->order_number = $requestOrder->id;
        // $sale->save();
        //dd($sale);
        if ($sale->save()) {


            $orderitemdata = SalesOrderItem::where('invoice_no',$demandInvoNumber->id)->get();

            foreach ($orderitemdata as $key => $requestitem) {

                $product = SalesProduct::find($requestitem->product_id);


                $sale_item = new SalesItem();
                $sale_item->sale_id = $sale->id;
              	$sale_item->warehouse_id = $requestOrder->warehouse_id;
        		$sale_item->dealer_id = $requestOrder->dealer_id;
                $sale_item->invoice_no = 'Sal-'.$demandInvoNumber->id;
                $sale_item->product_id =  $requestitem->product_id;

                $sale_item->product_name = $requestitem->product_name;
                $sale_item->product_code = $requestitem->product_code;
                $sale_item->product_weight =  $requestitem->product_weight;
                $sale_item->qty =  $requestitem->qty;

                $sale_item->unit_price =  $requestitem->unit_price;


                $sale_item->discount =  $requestitem->discount;
                $sale_item->discount_amount =  $requestitem->discount_amount;

                $sale_item->total_price =  $requestitem->total_price;
                $sale_item->save();


                //FOr montly Sales


                $categorydata = DB::table('sales_products')->where('id', $requestitem->product_id)->first();

                DB::table('montly_sales_targets')->insert([
                    'dealer_id' => $dealerdata->id,
                    'area_id' => $dealerdata->dlr_area_id,
                    'subzone_id' => $dealerdata->dlr_subzone_id,
                    'zone_id' => $dealerdata->dlr_zone_id,
                    'category_id' => $categorydata->category_id,
                    'product_id' => $requestitem->product_id,
                    'sale_id' => $sale_item->id,
                    'sales_invoice' => 'Sal-'.$demandInvoNumber->id,
                    'date' => $sale->date,
                    'qty_kg' => $product->product_weight * $requestitem->qty
                ]);


                $ledger = new SalesLedger();

                $ledger->vendor_id = $requestOrder->dealer_id;
                $ledger->area_id =$requestOrder->vendor_area_id;
                $ledger->ledger_date = $sale->date;
                $ledger->invoice = 'Sal-'.$demandInvoNumber->id;

                $ledger->sale_id = $sale_item->id;

                $ledger->warehouse_bank_name = 'Sales (' .  $factories->factory_name . ')';
                $ledger->warehouse_bank_id = $requestOrder->warehouse_id;

                $ledger->product_name = $product->product_name;
                $ledger->product_id = $requestitem->product_id;

                $ledger->qty_kg = $product->product_weight * $requestitem->qty;

                $ledger->qty_pcs = $requestitem->qty;



                $ledger->unit_price = $requestitem->unit_price;

                $ledger->discount = $requestitem->discount;
                $ledger->discount_amount = $requestitem->discount_amount;
                $ledger->total_price =  $requestitem->total_price;
                $ledger->save();
            }
        }
        // dd($request);
        $type = "debit";
        $t_head = "Product Sales";


        //dd($request->dealer_id);
        $check_invoice = SalesLedger::where('invoice', $demandInvoNumber->id)->where('priority', 1)->first();
        if (!$check_invoice) {

            $ledger = new SalesLedger();
            $ledger->vendor_id = $requestOrder->dealer_id;
            $ledger->area_id = $requestOrder->vendor_area_id;
            $ledger->invoice = 'Sal'.$demandInvoNumber->id;
            $ledger->warehouse_bank_name = 'Sales (' .  $factories->factory_name . ')';
            $ledger->warehouse_bank_id = $requestOrder->warehouse_id;
            $ledger->ledger_date = date('Y-m-d', strtotime($sale->date));
            $ledger->priority = 1;

            $ledger->debit = $requestOrder->grand_total;
            // $ledger->debit = $total_price;

            // $ledger->closing_balance = $ledger_update->closing_balance;
            // $ledger->credit_limit = $ledger_update->credit_limit;



            $ledger->save();

            if ($ledger->save()) {
                $sale->ledger_status = 1;
                $sale->save();

                $requestOrder->order_status = 1;
                $requestOrder->save();

            }
        }


        Session::put('success', 'Order Placed Successfull. Please Check Invoice List.');

        return redirect()->back();
        // ->with('success','Product Sales Successfull');

    }


    public function checkoutindex($invoice)
    {
        $id = Auth::id();

        $orderdetails = SalesOrder::where('invoice_no',$invoice)->first();
        $orderitems = SalesOrderItem::where('invoice_no', $invoice)->get();
		    //dd($orderitems);
        //dd($orderdetails);

        $dealerlogid = Dealer::latest('id')->where('user_id', '=', $id)->get();
      if($orderdetails->item_type == 'fg'){
        $products = SalesProduct::orderBy('product_name', 'ASC')->get();
      } else {
      	$products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();
      }

        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $employees = Employee::latest('id')->get();
        $factoryes = Factory::latest('id')->get();

        //dd( $request->all());



        return view('backend.sales_order.checkout', compact('products', 'factoryes', 'dealers', 'orderdetails', 'orderitems'));
    }

	//update active method
   public function updatecheckout(Request $request)
    {
        // dd($request->all());
      	 $date_f = $request->testdate;
         $cyear = date('Y',strtotime($date_f));
         $cmonth = date('m',strtotime($date_f));

        $invoice = $request->invoice;
		$invoice_no = substr($request->invoice, 4, strlen($invoice));
         $id = Auth::id();
         //dd($invoice);

		$userName = DB::select('select users.name from users where users.id="' . $id . '"');

        if (!$request->products_id && $request->qty) {
            return redirect()->back()
                ->with('error', 'Please Insert Product');
        }

        $factories = Factory::find($request->warehouse_id);
        //dd($factories);

        $delaer_area_id = DB::table('dealers')->where('id', $request->dealer_id)->value('dlr_area_id');
        $delaer_area_name = DB::table('dealer_areas')->where('id', $delaer_area_id)->value('area_title');


        $dealerdata = Dealer::where('id', $request->dealer_id)->first();
		//$sale = SalesOrder::where('invoice_no',$invoice)->first();

       // dd($sale);

        if ($request->update == 1) {

          //old code
            $sale = SalesOrder::where('invoice_no',$invoice)->first();
          	$sale->item_type = $request->item_type;
            $sale->warehouse_id = $request->warehouse_id;
            $sale->dealer_id = $request->dealer_id;
            //$sale->user_id = $id;
            //$sale->user_name = $userName;
            $sale->vendor_area_id = $delaer_area_id;
            $sale->vendor_area =  $delaer_area_name;
            $sale->date = $date_f;
            //  $sale->vehicle = $request->vehicle;
            //  $sale->transport_cost = $request->transport_cost;
            $sale->total_qty = $request->grand_total_qty;
            $sale->price = $request->grand_total_value;
            //$sale->discount = $request->grand_total_discount;
            //   $sale->price = $total_price;
            //   $sale->grand_total = $total_price;
          	//  $sale->grand_total = $request->total_payable;

            $sale->user_id = Auth::user()->id;
            $sale->narration = $request->narration;

            // $sale->save();
            //dd($sale);
            if ($sale->save()) {
                 SalesOrderItem::where('invoice_no', $invoice)->delete();
                 Ctc::where('invoice_no', $invoice_no)->delete();
              if($request->item_type == 'raw'){
                 foreach ($request->products_id as $key => $item) {
              	$product = RowMaterialsProduct::where('id',$item)->first();
               	$sale_item = new SalesOrderItem();
                $sale_item->date = $date_f;
                $sale_item->dealer_id = $request->dealer_id;
                $sale_item->area_id = $delaer_area_id;
                $sale_item->invoice_no = $invoice;
              	$sale_item->item_type = 'raw';
                $sale_item->product_id = $item;
                $sale_item->category_id = $product->category_id;
                $sale_item->product_name = $product->product_name;
                $sale_item->product_code = $product->code ?? 'PP-BAG';

                $sale_item->qty = $request->p_qty[$key];
                $sale_item->unit_price = $request->p_price[$key];
                $sale_item->total_price = $request->total_price_without_discount[$key];
                $sale_item->save();
                 }
              } else {
                foreach ($request->products_id as $key => $item) {
                    $product = SalesProduct::find($item);

              if(!empty($product->product_weight)){
              	$qtykg = $product->product_weight * $request->p_qty[$key];
              } else {
               $qtykg = 0;
              }

                    $sale_item = new SalesOrderItem();
                    //$sale_item->sale_id = $sale->id;
                  	$sale_item->date = $date_f;
                	$sale_item->dealer_id = $request->dealer_id;
                	$sale_item->area_id = $delaer_area_id;
                    $sale_item->invoice_no = $invoice;
                    $sale_item->item_type = 'fg';
                  //  $sale_item->sale_id = $sale->id;
                    $sale_item->product_id = $item;
                    $sale_item->category_id = $product->category_id;
                    $sale_item->product_name = $product->product_name;
                    $sale_item->product_code = $product->product_code;
                    $sale_item->product_weight = $product->product_weight;
                    $sale_item->qty = $request->p_qty[$key];

                    $sale_item->unit_price = $request->p_price[$key];
                    //dd($sale_item);
                    $sale_item->save();

                    //FOr Sales commission
                  if($product->category_id == 33){
                    Session::put('success', 'Order Created Successfull. Please Check Order List.');
                  } elseif($dealerdata->dlr_type_id == 24){
             		 Session::put('success', 'Order Created Successfull. Please Check Order List.');
                  } elseif($dealerdata->dlr_type_id == 25){
					 Session::put('success', 'Order Created Successfull. Please Check Order List.');
                  } elseif($dealerdata->dlr_type_id == 22){
                    Session::put('success', 'Order Created Successfull. Please Check Order List.');
               	  } elseif($dealerdata->dlr_type_id == 26){
              		$otherComission = DB::table('fixed_dealer_comissions')->where('dealer_id',$request->dealer_id)->where('category_id',$product->category_id)->first();
              		if(!empty($otherComission)){

                    } else {

                    		$data = Ctc::where('invoice_no',$invoice_no)->where('category_id',$product->category_id)->first();
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
                              $ctc->invoice_no = $invoice_no;
                              $ctc->category_id = $product->category_id;
                              $ctc->qty = $request->p_qty[$key];
                              $ctc->product_weight = $product->product_weight;
                              $ctc->ton = ($request->p_qty[$key] * $product->product_weight)/1000;
                              $ctc->save();
                              }
                        }
                } else {
                    $data = Ctc::where('invoice_no',$invoice_no)->where('category_id',$product->category_id)->first();
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
                  $ctc->invoice_no = $invoice_no;
                  $ctc->category_id = $product->category_id;
                  $ctc->qty = $request->p_qty[$key];
                  $ctc->product_weight = $product->product_weight;
                  $ctc->ton = ($request->p_qty[$key] * $product->product_weight)/1000;
                  $ctc->save();
                }
                  }
              }
              }
              /*
                $totalDisscount = 0;
                $totalPayable = 0;
                foreach($request->products_id as $index => $val) {
                $ton = 0; $maxTon = 0;
                $product = SalesProduct::where('id', $request->products_id[$index])->first();
                $comData = DB::table('ctcs')->select('ton', 'category_id','sale_id')->where('invoice_no', $invoice)->where('category_id', $product->category_id)->first();
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
                       //dd($com);
                      //sales item commission set
                       $salesItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();
                       //dd($salesItem);
                       $salesItem->discount = $com;
                       $salesItem->discount_amount = $discount;
                       $salesItem->total_price = $request->total_price[$index] - $discount;
                       $salesItem->save();
                       //dd($com);

                      DB::table('ctcs')->where('invoice_no',$invoice)->where('category_id',$product->category_id)->delete();
              }
              $totalPayable = $request->total_payable - $totalDisscount;
              DB::table('sales_orders')->where('invoice_no',$invoice)->update(['grand_total' => $totalPayable,'discount'=> $totalDisscount]);
              */
            }

            Session::put('success', 'Order Updated Successfull. Please Check Order List.');

            return redirect()->route('sales.order.index');

        }

        if ($request->confirm == 1) {

			  //old code
            $saleOrder = SalesOrder::where('invoice_no',$invoice)->first();
            $saleOrder->warehouse_id = $request->warehouse_id;
            $saleOrder->dealer_id = $request->dealer_id;
            $saleOrder->vendor_area_id = $delaer_area_id;
            $saleOrder->vendor_area =  $delaer_area_name;
            $saleOrder->date = $date_f;
            $saleOrder->total_qty = $request->grand_total_qty;
            $saleOrder->price = $request->grand_total_value;

            $saleOrder->user_id = Auth::user()->id;
            $saleOrder->narration = $request->narration;


            if ($saleOrder->save()) {

/*
            if( $request->item_type == 'fg' ){

                $totalCostOfFg = 0;

                $totalCostOfBag = 0;

                for($i = 0; $i < count($request->products_id); $i++){
                  $bagCostInfo = \App\Models\PackingConsumptions::where('product_id',$request->products_id)->orderBy('id','desc')->first();
                  if( $bagCostInfo ){
                    $totalCostOfBag += $bagCostInfo->rate;
                  }
                  $salesProduct = \App\Models\SalesStockIn::where('prouct_id',$request->products_id[$i])->orderBy('id','DESC')->first();
                  // dd($salesProduct);
                  if($salesProduct){
                      $individualCost = ((float)$salesProduct->total_cost / (float)$salesProduct->quantity) * (int) $request->p_qty[$i];
                      $totalCostOfFg += $individualCost;
                  }
                }

                 $totalSaleCost = $totalCostOfFg + $totalCostOfBag;

                 $this->createCreditForFinishedGoodsSale('Finished Goods Sales' , $request->grand_total_value ,$request->testdate,$request->narration,$invoice);
                 $this->createDebitForFinishedGoodsSale($request->dealer_id , $request->grand_total_value ,$request->testdate,$request->narration,$invoice);


                 $this->createCreditForCogsOfFinishedGoodsSale('Finished Goods',$totalSaleCost,$request->testdate,$request->narration,$invoice);
                 $this->createDeditForCogsOfFinishedGoodsSale('Cost of Good Sold of Finished Goods (FGCOGS)' , $totalSaleCost ,$request->testdate,$request->narration,$invoice);

            }else{
                    $this->createCreditForRawMaterialsSale('Raw Material Sales' , $request->grand_total_value,$request->testdate,$request->narration);
                    $this->createDebitForRawMateriasSale($request->dealer_id , $request->grand_total_value,$request->testdate,$request->narration);

                    $totalCostOfRam = 0;
                    for($i = 0; $i < count($request->raw_products_id); $i++){
                      $purchaseProduct = Purchase::where('product_id',$request->raw_products_id[$i])->orderBy('purchase_id','DESC')->first();

                      if($purchaseProduct){
                          $individualCost = ((float)$purchaseProduct->purchase_value / (int)$purchaseProduct->bill_quantity) * (int) $request->p_qty[$i];
                          $totalCostOfRam += $individualCost;
                      }
                    }

                    $this->createCreditForCogsOfRawMaterialSale('Raw Materials', $totalCostOfRam,$request->testdate,$request->narration);
                    $this->createDeditForCogsOfRawMaterialSale('Cost of Goods Sold of Raw Material (RMCOGS)' ,  $totalCostOfRam ,$request->testdate,$request->narration);
            }

*/

                 SalesOrderItem::where('invoice_no', $invoice)->delete();
                 Ctc::where('invoice_no', $invoice_no)->delete();
              	 Sale::where('invoice_no', $invoice)->delete();
              	 SalesItem::where('invoice_no', $invoice)->delete();

                foreach ($request->products_id as $key => $item) {
                  if($request->item_type == 'fg'){
                    $product = SalesProduct::find($item);
                    if(!empty($product->product_weight)){
                      $qtykg = $product->product_weight * $request->p_qty[$key];
                    } else {
                     $qtykg = 0;
                    }


                    $sale_order_item = new SalesOrderItem();
                    //$sale_item->sale_id = $sale->id;
                  	$sale_order_item->date = $date_f;
                	$sale_order_item->dealer_id = $request->dealer_id;
                	$sale_order_item->area_id = $delaer_area_id;
                    $sale_order_item->invoice_no = $invoice;
                  	$sale_order_item->item_type = $request->item_type;
                    $sale_order_item->product_id = $item;
                    $sale_order_item->category_id = $product->category_id;
                    $sale_order_item->product_name = $product->product_name;
                    $sale_order_item->product_code = $product->product_code?? '';
                    $sale_order_item->product_weight = $product->product_weight;
                    $sale_order_item->qty = $request->p_qty[$key];

                    $sale_order_item->unit_price = $request->p_price[$key];
                    //dd($sale_item);
                    $sale_order_item->save();

                    //FOr Sales commission
                  if($product->category_id == 33){

                  } elseif($dealerdata->dlr_type_id == 24){
             		 //Session::put('success', 'Order Created Successfull. Please Check Order List.');
                  } elseif($dealerdata->dlr_type_id == 25){
					 //Session::put('success', 'Order Created Successfull. Please Check Order List.');
                  } elseif($dealerdata->dlr_type_id == 22){
                   // Session::put('success', 'Order Created Successfull. Please Check Order List.');
               }  elseif($dealerdata->dlr_type_id == 26){
              		$otherComission = DB::table('fixed_dealer_comissions')->where('dealer_id',$request->dealer_id)->where('category_id',$product->category_id)->first();
              		if(!empty($otherComission)){
                    } else {
                    		$data = Ctc::where('invoice_no',$invoice_no)->where('category_id',$product->category_id)->first();
                            if(!empty($data)){
                            $data->qty = $request->p_qty[$key] + $data->qty;
                            $data->product_weight = $product->product_weight;
                            $data->ton = (($request->p_qty[$key] * $product->product_weight)/1000)+$data->ton;
                            $data->save();

                          } else {

                            $ctc = new Ctc();
                            $ctc->date = $date_f;
                            $ctc->dealer_id = $request->dealer_id;
                            $ctc->sale_id = $sale_order_item->id;
                            $ctc->invoice_no = $invoice_no;
                            $ctc->category_id = $product->category_id;
                            $ctc->qty = $request->p_qty[$key];
                            $ctc->product_weight = $product->product_weight;
                            $ctc->ton = ($request->p_qty[$key] * $product->product_weight)/1000;
                            $ctc->save();
                          }
                        }
                } else {
                    $data = Ctc::where('invoice_no',$invoice_no)->where('category_id',$product->category_id)->first();
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
                  $ctc->sale_id = $sale_order_item->id;
                  $ctc->invoice_no = $invoice_no;
                  $ctc->category_id = $product->category_id;
                  $ctc->qty = $request->p_qty[$key];
                  $ctc->product_weight = $product->product_weight;
                  $ctc->ton = ($request->p_qty[$key] * $product->product_weight)/1000;
                  $ctc->save();
                }

              }
              }else {
            	$product = RowMaterialsProduct::where('id',$item)->first();
                $sale_order_item = new SalesOrderItem();
                    //$sale_item->sale_id = $sale->id;
                  	$sale_order_item->date = $date_f;
                	$sale_order_item->dealer_id = $request->dealer_id;
                	$sale_order_item->area_id = $delaer_area_id;
                    $sale_order_item->invoice_no = $invoice;
                  	$sale_order_item->item_type = $request->item_type;
                    $sale_order_item->product_id = $item;
                    $sale_order_item->category_id = $product->category_id;
                    $sale_order_item->product_name = $product->product_name;
                    $sale_order_item->product_code = $product->code?? 'PP-BAG';
                    $sale_order_item->qty = $request->p_qty[$key];

                    $sale_order_item->unit_price = $request->p_price[$key];
                    //dd($sale_item);
                    $sale_order_item->save();
              		}
              	}
            }


            $sale = new Sale();
            $sale->date = $date_f;
          	$sale->item_type = $request->item_type;
            $sale->warehouse_id = $request->warehouse_id;
            $sale->dealer_id = $request->dealer_id;
            $sale->vendor_area_id = $delaer_area_id;
            $sale->vendor_area =  $delaer_area_name;
            $sale->invoice_no = $invoice;
            $sale->total_qty = $request->grand_total_qty;
            $sale->price = $request->grand_total_value;
            $sale->user_id = Auth::user()->id;
            $sale->narration = $request->narration;
            $sale->demand_month = $cmonth;
            $sale->demand_year = $cyear;

            if ($sale->save()) {
                $totalDiscount = 0;
                $totalPayableAmount = 0;
                foreach ($request->products_id as $key => $item) {
                   if($request->item_type == 'fg'){
                    $product = SalesProduct::find($item);
                  } else {
                   $product = RowMaterialsProduct::where('id',$item)->first();
                   }
                    $discountAmount = ($request->total_price[$key] * $request->discount[$key])/100;
                   $totalAmount = $request->total_price[$key] - $discountAmount;
                   $totalDiscount += $discountAmount;
                   $totalPayableAmount += $totalAmount;
                   
                    $sale_item = new SalesItem();
                    $sale_item->sale_id = $sale->id;
                  	$sale_item->item_type = $request->item_type;
                  	$sale_item->warehouse_id = $request->warehouse_id;
            		    $sale_item->dealer_id = $request->dealer_id;
                    $sale_item->date = $date_f;
                  	$sale_item->invoice_no = $invoice;
                    $sale_item->product_id = $item;
                    $sale_item->category_id = $product->category_id;
                    $sale_item->product_name = $product->product_name;
                  if($request->item_type == 'fg')
                    {
                    $sale_item->product_code = $product->product_code;
                    $sale_item->product_weight = $product->product_weight;
                  	} else {
                  	$sale_item->product_code = $product->code ?? 'PP-BAG';
                  	}
                    $sale_item->qty = $request->p_qty[$key];
                  	$sale_item->remain_qty = $request->p_qty[$key];
                    $sale_item->unit_price = $request->p_price[$key];
                  	$sale_item->discount = $request->discount[$key];
                    $sale_item->discount_amount = $discountAmount;
                    //$sale_item->bonus = 1;
                  	$sale_item->total_price = $totalAmount;
                    $sale_item->save();
                }
                DB::table('sales')->where('invoice_no',$invoice)->update(['grand_total' => $totalPayableAmount,'discount'=> $totalDiscount]);
                DB::table('sales_orders')->where('invoice_no',$invoice)->update(['grand_total' => $totalPayableAmount,'discount'=> $totalDiscount]);

              /* if($request->item_type == 'fg') {
               $date = '';
              	$temp = substr($date_f,0,8);
              	$date = $temp.'01';

                $totalDisscount = 0;
                $totalPayable = 0;

                  if($dealerdata->dlr_type_id == 22){
                    foreach($request->products_id as $index => $val) {
                  	$product = SalesProduct::find($val);
                      if($product->category_id != 33) {
                        $qtykg = 0;
                            if($product->product_weight_unit == "KG"){
                            $qtykg = $product->product_weight * $request->p_qty[$index];
                          } else {
                           $qtykg = 0;
                          }

                      $discount = 0;
                      $salesOItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();

                      $discount = $qtykg * 3.7;
                      $totalDisscount += $discount;

                      $salesOItem->discount = 3.7;
                      $salesOItem->discount_amount = $discount;
                      $salesOItem->total_price = $request->total_price[$index] - $discount;
                      $salesOItem->save();

                      $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                       //dd($salesItem);
                       $salesItem->discount = 3.7;
                       $salesItem->discount_amount = $discount;
                       $salesItem->total_price = $request->total_price[$index] - $discount;
                       $salesItem->save();
                    }
                    }

                  } elseif($dealerdata->dlr_type_id == 24){
                  	    foreach($request->products_id as $index => $val) {
                  		$product = SalesProduct::find($val);
                          if($product->category_id != 33) {
                            $qtykg = 0;
                                if($product->product_weight_unit == "KG"){
                                $qtykg = $product->product_weight * $request->p_qty[$index];
                              } else {
                               $qtykg = 0;
                              }
                      $category = SalesProduct::where('id',$request->products_id[$index])->value('category_id');

                    	if($category == 20){

                          $discount = 0;
                          $com = 3;
                          $discount = $qtykg*3;
                          $totalDisscount += $discount;

                          //dd($discount);
                          $salesOItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();
                          $salesOItem->discount = $com;
                          $salesOItem->discount_amount = $discount;
                          $salesOItem->total_price = $request->total_price[$index] - $discount;
                          $salesOItem->save();

                          $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                           //dd($salesItem);
                           $salesItem->discount = $com;
                           $salesItem->discount_amount = $discount;
                           $salesItem->total_price = $request->total_price[$index] - $discount;
                           $salesItem->save();
                          } elseif($category == 27) {

                          $discount = 0;
                          $com = 3;
                          $discount = $qtykg*3;
                          $totalDisscount += $discount;
                          //dd($discount);
                          $salesItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();
                          $salesItem->discount = $com;
                          $salesItem->discount_amount = $discount;
                          $salesItem->total_price = $request->total_price[$index] - $discount;
                          $salesItem->save();

                          $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                           //dd($salesItem);
                           $salesItem->discount = $com;
                           $salesItem->discount_amount = $discount;
                           $salesItem->total_price = $request->total_price[$index] - $discount;
                           $salesItem->save();

                          } elseif($category == 21) {

                          $discount = 0;
                          $com = 3.5;
                          $discount = $qtykg*3.5;
                          $totalDisscount += $discount;
                          //dd($discount);
                          $salesOItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();
                          $salesOItem->discount = $com;
                          $salesOItem->discount_amount = $discount;
                          $salesOItem->total_price = $request->total_price[$index] - $discount;
                          $salesOItem->save();

                          $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                           //dd($salesItem);
                           $salesItem->discount = $com;
                           $salesItem->discount_amount = $discount;
                           $salesItem->total_price = $request->total_price[$index] - $discount;
                           $salesItem->save();
                        }
                  		}
                        }

                  } elseif($dealerdata->dlr_type_id == 26){
                    foreach($request->products_id as $index => $val) {
                      $product = SalesProduct::find($val);
                      if($product->category_id != 33) {
                      $otherComission = DB::table('fixed_dealer_comissions')->where('dealer_id',$request->dealer_id)->where('category_id',$product->category_id)->first();

                      $qtykg = 0;
                            if($product->product_weight_unit == "KG"){
                            $qtykg = $product->product_weight * $request->p_qty[$index];
                          } else {
                           $qtykg = 0;
                          }

                      if(!empty($otherComission)){


                          $discount = 0;
                          $salesOItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();

                          $discount = $qtykg * $otherComission->commission;
                          $totalDisscount += $discount;

                          $salesOItem->discount = $otherComission->commission;
                          $salesOItem->discount_amount = $discount;
                          $salesOItem->total_price = $request->total_price[$index] - $discount;
                          $salesOItem->save();

                          $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                           //dd($salesItem);
                           $salesItem->discount = $otherComission->commission;
                           $salesItem->discount_amount = $discount;
                           $salesItem->total_price = $request->total_price[$index] - $discount;
                           $salesItem->save();


                    } else {
                      	  $ton = 0; $maxTon = 0; $discount = 0;
                          $comData = DB::table('ctcs')->select([DB::raw("SUM(ton) ton"),'category_id','sale_id'])->where('dealer_id', $request->dealer_id)->where('category_id', $product->category_id)->whereBetween('date',[$date, $date_f])->first();
                          $ton = $comData->ton;
                          //$maxTon = $ton + 10;
                              if($ton > 0){
                                $ton = intval($ton);
                                  $com = CommissionIn::where('category_id', $product->category_id)->where('target_amount','<=', $ton )->where('max_target_amount','>=',$ton)->value('achive_commision');
                                  $discount = $com*$qtykg;
                                  $totalDisscount += $discount;
                                } else {
                                  $discount = 0;
                                  $com= 0;
                                }
                                // dd($com);
                                $salesOItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();
                                //dd($salesItem);
                                $salesOItem->discount = $com;
                                $salesOItem->discount_amount = $discount;
                                $salesOItem->total_price = $request->total_price[$index] - $discount;
                                $salesOItem->save();

                                //sales item commission set
                                 $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                                 //dd($salesItem);
                                 $salesItem->discount = $com;
                                 $salesItem->discount_amount = $discount;
                                 $salesItem->total_price = $request->total_price[$index] - $discount;
                                 $salesItem->save();

                                DB::table('ctcs')->where('invoice_no',$invoice_no)->where('category_id',$product->category_id)->update(['discount'=> $com, 'discount_amount' => $com*$ton*1000]);
                                  }
                    	}
                    }
                  } else {

                    foreach($request->products_id as $index => $val) {
                      if($request->item_type == 'fg') {
                  	$product = SalesProduct::find($val);
                      if($product->category_id != 33) {
                    $qtykg = 0;
                        if($product->product_weight_unit == "KG"){
                        $qtykg = $product->product_weight * $request->p_qty[$index];
                      } else {
                       $qtykg = 0;
                      }

                $ton = 0; $maxTon = 0; $discount = 0;
                $product = DB::table('sales_products')->where('id', $request->products_id[$index])->first();
                $comData = DB::table('ctcs')->select([DB::raw("SUM(ton) ton"),'category_id','sale_id'])->where('dealer_id', $request->dealer_id)->where('category_id', $product->category_id)->whereBetween('date',[$date, $date_f])->first();

                $ton = $comData->ton;
                //$maxTon = $ton + 10;
                    if($ton > 0){
                      $ton = intval($ton);
                        $com = CommissionIn::where('category_id', $product->category_id)->where('target_amount','<=', $ton )->where('max_target_amount','>=',$ton)->value('achive_commision');
                        $discount = $com*$qtykg;
                        $totalDisscount += $discount;
                      } else {
                        $discount = 0;
                        $com= 0;
                      }
                      // dd($com);
                      $salesOItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();
                      //dd($salesItem);
                      $salesOItem->discount = $com;
                      $salesOItem->discount_amount = $discount;
                      $salesOItem->total_price = $request->total_price[$index] - $discount;
                      $salesOItem->save();

                      //sales item commission set
                       $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                       //dd($salesItem);
                       $salesItem->discount = $com;
                       $salesItem->discount_amount = $discount;
                       $salesItem->total_price = $request->total_price[$index] - $discount;
                       $salesItem->save();

                      DB::table('ctcs')->where('invoice_no',$invoice_no)->where('category_id',$product->category_id)->update(['discount'=> $com, 'discount_amount' => $com*$ton*1000]);
              		}
                    }

                    }
                }

            $totalPayable = $request->grand_total_value - $totalDisscount;
            DB::table('sales')->where('invoice_no',$invoice)->update(['grand_total' => $totalPayable,'discount'=> $totalDisscount]);
            DB::table('sales_orders')->where('invoice_no',$invoice)->update(['grand_total' => $totalPayable,'discount'=> $totalDisscount]);
            }
                */
            }
            $sale->order_number = $saleOrder->id;
            $sale->save();
            $saleOrder->order_status = 1;
            $saleOrder->save();



            Session::put('success', 'Order Updated & Confirm Successfull. Please Check Sales List.');
            return redirect()->route('sales.order.index');

        }

    }


    public function invoiceDelete(Request $request)
    {
        //dd($request->all());

        $uid = Auth::id();


       SalesOrder::where('invoice_no', $request->invoice)->update([
            'is_active' => 0,
             'deleted_by'=>$uid
            ]);


    //    SalesOrder::where('invoice_no', $request->invoice)->delete();
		$invoice = $request->invoice;
		$invoice_no = substr($request->invoice, 4, strlen($invoice));

        SalesOrderItem::where('invoice_no', $invoice)->delete();

		$ctcs = DB::table('ctcs')->where('invoice_no',$invoice_no)->get();
      	if(!empty($ctcs)){
        	DB::table('ctcs')->where('invoice_no',$invoice_no)->delete();
        }
        
        ChartOfAccounts::where('invoice',$invoice)->delete();
        Sale::where('invoice_no', $request->invoice)->delete();
        SalesItem::where('invoice_no', $request->invoice)->delete();
        SalesLedger::where('invoice', $request->invoice)->delete();
        SalesStockOut::where('invoice',$request->invoice)->delete();
        PurchaseStockout::where('sout_number',$invoice)->delete();
        RawMaterialStockOut::where('invoice',$invoice)->delete();
        PackingStockOut::where('invoice',$invoice)->delete();
        DB::table('sales_returns')->where('invoice_no', $request->invoice)->delete();
        DB::table('chalans')->where('invoice_no',$request->invoice)->delete();
        DB::table('montly_sales_targets')->where('sales_invoice', $request->invoice)->delete();
        DB::table('sales_return_items')->where('invoice_no', $request->invoice)->delete();
        return redirect()->back()->with('success', 'Order  Delete Successfull.');
    }


  public function deletelog(Request $request)
    {

        $orderlist  = DB::select('SELECT sales_orders.*,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales_orders`
                    LEFT JOIN dealers ON dealers.id = sales_orders.dealer_id
                    LEFT JOIN factories ON factories.id = sales_orders.warehouse_id
                    LEFT JOIN users ON users.id = sales_orders.emp_id
                    WHERE is_active=0
                    order by  date desc,invoice_no desc LIMIT 500');


        return view('backend.sales_order.delete_log', compact('orderlist'));
    }

public function orderEdit($invoice){
		$id = Auth::id();

        $orderdetails = SalesOrder::where('invoice_no',$invoice)->first();
        $orderitems = SalesOrderItem::where('invoice_no', $invoice)->get();
		//dd($orderitems);
        $dealerlogid = Dealer::latest('id')->where('user_id', '=', $id)->get();
  		if($orderdetails->item_type == 'fg') {
          	$products = SalesProduct::orderBy('product_name', 'ASC')->get();

        } else {
          $products = RowMaterialsProduct::orderBy('product_name', 'ASC')->get();

        }
        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $employees = Employee::latest('id')->get();
        $factoryes = Factory::latest('id')->get();

        return view('backend.sales_order.edit', compact('products', 'factoryes', 'dealers', 'orderdetails', 'orderitems'));
}


  public function orderUpdate(Request $request){
	//dd($request->all());

    $date_f = $request->testdate;
         $cyear = date('Y',strtotime($date_f));
         $cmonth = date('m',strtotime($date_f));
		$invoice = $request->invoice;
		$invoice_no = substr($request->invoice, 4, strlen($invoice));
         $id = Auth::id();

		$userName = DB::select('select users.name from users where users.id="' . $id . '"');

        if (!$request->products_id && $request->qty) {
            return redirect()->back()
                ->with('error', 'Please Insert Product');
        }

        $factories = Factory::find($request->warehouse_id);

        $delaer_area_id = DB::table('dealers')->where('id', $request->dealer_id)->value('dlr_area_id');
        $delaer_area_name = DB::table('dealer_areas')->where('id', $delaer_area_id)->value('area_title');
        $dealerdata = Dealer::where('id', $request->dealer_id)->first();


          //old code
            $saleOrder = SalesOrder::where('invoice_no',$invoice)->first();
            $saleOrder->warehouse_id = $request->warehouse_id;
            $saleOrder->dealer_id = $request->dealer_id;
            $saleOrder->vendor_area_id = $delaer_area_id;
            $saleOrder->vendor_area =  $delaer_area_name;
            $saleOrder->date = $date_f;
            $saleOrder->total_qty = $request->grand_total_qty;
            $saleOrder->price = $request->grand_total_value;

            $saleOrder->user_id = Auth::user()->id;
            $saleOrder->narration = $request->narration;

            //dd($sale);
            if ($saleOrder->save()) {
                 SalesOrderItem::where('invoice_no', $invoice)->delete();
              	 Sale::where('invoice_no', $invoice)->delete();
              	 SalesItem::where('invoice_no', $invoice)->delete();


              Ctc::where('invoice_no', $invoice_no)->delete();

                foreach ($request->products_id as $key => $item) {
                  if($request->item_type == 'fg') {
                  $product = SalesProduct::find($item);

              if(!empty($product->product_weight)){
              	$qtykg = $product->product_weight * $request->p_qty[$key];
              } else {
               $qtykg = 0;
              }

                    $sale_order_item = new SalesOrderItem();
                    //$sale_item->sale_id = $sale->id;
                  	$sale_order_item->date = $date_f;
                	$sale_order_item->dealer_id = $request->dealer_id;
                	$sale_order_item->area_id = $delaer_area_id;
                    $sale_order_item->invoice_no = $invoice;
                    $sale_order_item->item_type = $request->item_type;
                  //  $sale_item->sale_id = $sale->id;
                    $sale_order_item->product_id = $item;
                    $sale_order_item->category_id = $product->category_id;
                    $sale_order_item->product_name = $product->product_name;
                    $sale_order_item->product_code = $product->product_code;
                    $sale_order_item->product_weight = $product->product_weight;
                    $sale_order_item->qty = $request->p_qty[$key];

                    $sale_order_item->unit_price = $request->p_price[$key];
                    //dd($sale_item);
                    $sale_order_item->save();

                    //FOr Sales commission
                  if($product->category_id == 33) {

                  } elseif($dealerdata->dlr_type_id == 24){
             		 //Session::put('success', 'Order Created Successfull. Please Check Order List.');
                  } elseif($dealerdata->dlr_type_id == 25){
					// Session::put('success', 'Order Created Successfull. Please Check Order List.');
                  } elseif($dealerdata->dlr_type_id == 22){
                    //Session::put('success', 'Order Created Successfull. Please Check Order List.');
               }  elseif($dealerdata->dlr_type_id == 26){

              		$otherComission = DB::table('fixed_dealer_comissions')->where('dealer_id',$request->dealer_id)->where('category_id',$product->category_id)->first();
              		if(!empty($otherComission)){

                    } else {
                    		$data = Ctc::where('invoice_no',$invoice_no)->where('category_id',$product->category_id)->first();
                            if(!empty($data)){
                                $data->qty = $request->p_qty[$key] + $data->qty;
                                $data->product_weight = $product->product_weight;
                                $data->ton = (($request->p_qty[$key] * $product->product_weight)/1000)+$data->ton;
                                $data->save();

                              } else {

                                $ctc = new Ctc();
                                $ctc->date = $date_f;
                                $ctc->dealer_id = $request->dealer_id;
                                $ctc->sale_id = $sale_order_item->id;
                                $ctc->invoice_no = $invoice_no;
                                $ctc->category_id = $product->category_id;
                                $ctc->qty = $request->p_qty[$key];
                                $ctc->product_weight = $product->product_weight;
                                $ctc->ton = ($request->p_qty[$key] * $product->product_weight)/1000;
                                $ctc->save();
                              }
                        }

                } else {

                    $data = Ctc::where('invoice_no',$invoice_no)->where('category_id',$product->category_id)->first();

                if(!empty($data)){
                  $data->qty = $request->p_qty[$key] + $data->qty;
                  $data->product_weight = $product->product_weight;
                  $data->ton = (($request->p_qty[$key] * $product->product_weight)/1000)+$data->ton;
                  $data->save();

                } else {

                  $ctc = new Ctc();
                  $ctc->date = $date_f;
                  $ctc->dealer_id = $request->dealer_id;
                  $ctc->sale_id = $sale_order_item->id;
                  $ctc->invoice_no = $invoice_no;
                  $ctc->category_id = $product->category_id;
                  $ctc->qty = $request->p_qty[$key];
                  $ctc->product_weight = $product->product_weight;
                  $ctc->ton = ($request->p_qty[$key] * $product->product_weight)/1000;
                  $ctc->save();
                }
                  }
                  } else {
                  	$product = RowMaterialsProduct::find($item);
                  	$sale_order_item = new SalesOrderItem();
                  	$sale_order_item->date = $date_f;
                	$sale_order_item->dealer_id = $request->dealer_id;
                	$sale_order_item->area_id = $delaer_area_id;
                    $sale_order_item->invoice_no = $invoice;
                    $sale_order_item->item_type = $request->item_type;
                    $sale_order_item->product_id = $item;
                    $sale_order_item->category_id = $product->category_id;
                    $sale_order_item->product_name = $product->product_name;
                    $sale_order_item->product_code = $product->code??'PP-BAG';
                    $sale_order_item->qty = $request->p_qty[$key];
                    $sale_order_item->unit_price = $request->p_price[$key];
                    //dd($sale_item);
                    $sale_order_item->save();
                  }
              }
            }

            $sale = new Sale();
            $sale->date = $date_f;
            $sale->item_type = $request->item_type;
            $sale->warehouse_id = $request->warehouse_id;
            $sale->dealer_id = $request->dealer_id;
            $sale->vendor_area_id = $delaer_area_id;
            $sale->vendor_area =  $delaer_area_name;
            $sale->invoice_no = $invoice;
            $sale->total_qty = $request->grand_total_qty;
            $sale->price = $request->grand_total_value;
            $sale->user_id = Auth::user()->id;
            $sale->narration = $request->narration;
            $sale->demand_month = $cmonth;
            $sale->demand_year = $cyear;

            if ($sale->save()) {
                $totalDiscount = 0;
                $totalPayableAmount = 0;
                foreach ($request->products_id as $key => $item) {
                   if($request->item_type == 'fg'){
                    $product = SalesProduct::find($item);
                  } else {
                   $product = RowMaterialsProduct::where('id',$item)->first();
                   }
                   
                    $discountAmount = ($request->total_price[$key] * $request->discount[$key])/100;
                    //$discountAmount = $request->discount[$key];
                    $totalAmount = $request->total_price[$key] - $discountAmount;
                    $totalDiscount += $discountAmount;
                    $totalPayableAmount += $totalAmount;
                    
                    $sale_item = new SalesItem();
                    $sale_item->sale_id = $sale->id;
                  	$sale_item->item_type = $request->item_type;
                  	$sale_item->warehouse_id = $request->warehouse_id;
            		$sale_item->dealer_id = $request->dealer_id;
                    $sale_item->date = $date_f;
                  	$sale_item->invoice_no = $invoice;
                    $sale_item->product_id = $item;
                    $sale_item->category_id = $product->category_id;
                    $sale_item->product_name = $product->product_name;
                  if($request->item_type == 'fg')
                    {
                    $sale_item->product_code = $product->product_code;
                    $sale_item->product_weight = $product->product_weight;
                  	} else {
                  	$sale_item->product_code = $product->code ?? 'PP-BAG';
                  	}
                    $sale_item->qty = $request->p_qty[$key];
                  	$sale_item->remain_qty = $request->p_qty[$key];
                    $sale_item->unit_price = $request->p_price[$key];
                  	$sale_item->discount = $request->discount[$key];
                    $sale_item->discount_amount = $discountAmount;
                    //$sale_item->bonus = 1;
                  	$sale_item->total_price = $totalAmount;
                    $sale_item->save();
                }
                DB::table('sales')->where('invoice_no',$invoice)->update(['grand_total' => $totalPayableAmount,'discount'=> $totalDiscount]);
                DB::table('sales_orders')->where('invoice_no',$invoice)->update(['grand_total' => $totalPayableAmount,'discount'=> $totalDiscount]);
            /*
              if($request->item_type == 'fg'){
               $date = '';
              	$temp = substr($date_f,0,8);
              	$date = $temp.'01';

                $totalDisscount = 0;
                $totalPayable = 0;

                  if($dealerdata->dlr_type_id == 22){
                    foreach($request->products_id as $index => $val) {
                  	$product = SalesProduct::find($val);
                    if($product->category_id == 33) {
                    } else {
                    $qtykg = 0;
                        if($product->product_weight_unit == "KG"){
                        $qtykg = $product->product_weight * $request->p_qty[$index];
                      } else {
                       $qtykg = 0;
                      }

                      $discount = 0;
                      $salesOItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();

                      $discount = $qtykg * 3.7;
                      $totalDisscount += $discount;

                      $salesOItem->discount = 3.7;
                      $salesOItem->discount_amount = $discount;
                      $salesOItem->total_price = $request->total_price[$index] - $discount;
                      $salesOItem->save();

                      $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                       //dd($salesItem);
                       $salesItem->discount = 3.7;
                       $salesItem->discount_amount = $discount;
                       $salesItem->total_price = $request->total_price[$index] - $discount;
                       $salesItem->save();
                    }
                    }
                  } elseif($dealerdata->dlr_type_id == 24){
                  	    foreach($request->products_id as $index => $val) {
                  		$product = SalesProduct::find($val);
                        if($product->category_id == 33) {
                    	} else {
                            $qtykg = 0;
                                if($product->product_weight_unit == "KG"){
                                $qtykg = $product->product_weight * $request->p_qty[$index];
                              } else {
                               $qtykg = 0;
                              }
                      $category = SalesProduct::where('id',$request->products_id[$index])->value('category_id');

                    	if($category == 20){

                          $discount = 0;
                          $com = 3;
                          $discount = $qtykg*3;
                          $totalDisscount += $discount;

                          //dd($discount);
                          $salesOItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();
                          $salesOItem->discount = $com;
                          $salesOItem->discount_amount = $discount;
                          $salesOItem->total_price = $request->total_price[$index] - $discount;
                          $salesOItem->save();

                          $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                           //dd($salesItem);
                           $salesItem->discount = $com;
                           $salesItem->discount_amount = $discount;
                           $salesItem->total_price = $request->total_price[$index] - $discount;
                           $salesItem->save();
                          } elseif($category == 27) {

                          $discount = 0;
                          $com = 3;
                          $discount = $qtykg*3;
                          $totalDisscount += $discount;
                          //dd($discount);
                          $salesItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();
                          $salesItem->discount = $com;
                          $salesItem->discount_amount = $discount;
                          $salesItem->total_price = $request->total_price[$index] - $discount;
                          $salesItem->save();

                          $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                           //dd($salesItem);
                           $salesItem->discount = $com;
                           $salesItem->discount_amount = $discount;
                           $salesItem->total_price = $request->total_price[$index] - $discount;
                           $salesItem->save();

                          } elseif($category == 21) {

                          $discount = 0;
                          $com = 3.5;
                          $discount = $qtykg*3.5;
                          $totalDisscount += $discount;
                          //dd($discount);
                          $salesOItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();
                          $salesOItem->discount = $com;
                          $salesOItem->discount_amount = $discount;
                          $salesOItem->total_price = $request->total_price[$index] - $discount;
                          $salesOItem->save();

                          $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                           //dd($salesItem);
                           $salesItem->discount = $com;
                           $salesItem->discount_amount = $discount;
                           $salesItem->total_price = $request->total_price[$index] - $discount;
                           $salesItem->save();
                        }
                  		}
                        }
                  } elseif($dealerdata->dlr_type_id == 26){

                    foreach($request->products_id as $index => $val) {
                        $product = SalesProduct::find($val);
                      	if($product->category_id == 33) {
                        } else {
                    	$otherComission = DB::table('fixed_dealer_comissions')->where('dealer_id',$request->dealer_id)->where('category_id',$product->category_id)->first();
                   		  $qtykg = 0;
                            if($product->product_weight_unit == "KG"){
                            $qtykg = $product->product_weight * $request->p_qty[$index];
                          } else {
                           $qtykg = 0;
                          }
                      if(!empty($otherComission)){


                          $discount = 0;
                          $salesOItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();

                          $discount = $qtykg * $otherComission->commission;
                          $totalDisscount += $discount;

                          $salesOItem->discount = $otherComission->commission;
                          $salesOItem->discount_amount = $discount;
                          $salesOItem->total_price = $request->total_price[$index] - $discount;
                          $salesOItem->save();

                          $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                           //dd($salesItem);
                           $salesItem->discount = $otherComission->commission;
                           $salesItem->discount_amount = $discount;
                           $salesItem->total_price = $request->total_price[$index] - $discount;
                           $salesItem->save();

                    } else {

                          $ton = 0; $maxTon = 0; $discount = 0;

                          $comData = DB::table('ctcs')->select([DB::raw("SUM(ton) ton"),'category_id','sale_id'])->where('dealer_id', $request->dealer_id)->where('category_id', $product->category_id)->whereBetween('date',[$date, $date_f])->first();

                          $ton = $comData->ton;
                          //$maxTon = $ton + 10;
                              if($ton > 0){
                                $ton = intval($ton);
                                  $com = CommissionIn::where('category_id', $product->category_id)->where('target_amount','<=', $ton )->where('max_target_amount','>=',$ton)->value('achive_commision');
                                  $discount = $com*$qtykg;
                                  $totalDisscount += $discount;
                                } else {
                                  $discount = 0;
                                  $com= 0;
                                }
                                // dd($com);
                                $salesOItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();
                                //dd($salesItem);
                                $salesOItem->discount = $com;
                                $salesOItem->discount_amount = $discount;
                                $salesOItem->total_price = $request->total_price[$index] - $discount;
                                $salesOItem->save();

                                //sales item commission set
                                 $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                                 //dd($salesItem);
                                 $salesItem->discount = $com;
                                 $salesItem->discount_amount = $discount;
                                 $salesItem->total_price = $request->total_price[$index] - $discount;
                                 $salesItem->save();

                                DB::table('ctcs')->where('invoice_no',$invoice)->where('category_id',$product->category_id)->update(['discount'=> $com, 'discount_amount' => $com*$ton*1000]);
                              }
                    	}
                    }
                  } else {

                    foreach($request->products_id as $index => $val) {
                  	$product = SalesProduct::find($val);
                    if($product->category_id == 33) {
                    } else {
                    $qtykg = 0;
                        if($product->product_weight_unit == "KG"){
                        $qtykg = $product->product_weight * $request->p_qty[$index];
                      } else {
                       $qtykg = 0;
                      }

                $ton = 0; $maxTon = 0; $discount = 0;
                $product = DB::table('sales_products')->where('id', $request->products_id[$index])->first();
                $comData = DB::table('ctcs')->select([DB::raw("SUM(ton) ton"),'category_id','sale_id'])->where('dealer_id', $request->dealer_id)->where('category_id', $product->category_id)->whereBetween('date',[$date, $date_f])->first();

                $ton = $comData->ton;

                //$maxTon = $ton + 10;
                    if($ton > 0){
                      $ton = intval($ton);
                        $com = CommissionIn::where('category_id', $product->category_id)->where('target_amount','<=', $ton )->where('max_target_amount','>=',$ton)->value('achive_commision');
                        $discount = $com*$qtykg;
                        $totalDisscount += $discount;
                      } else {
                        $discount = 0;
                        $com= 0;
                      }
                      // dd($com);
                      $salesOItem = SalesOrderItem::where('invoice_no', $invoice)->where('product_id',$request->products_id[$index])->first();
                      //dd($salesItem);
                      $salesOItem->discount = $com;
                      $salesOItem->discount_amount = $discount;
                      $salesOItem->total_price = $request->total_price[$index] - $discount;
                      $salesOItem->save();

                      //sales item commission set
                       $salesItem = SalesItem::where('invoice_no',$invoice)->where('product_id',$request->products_id[$index])->first();
                       //dd($salesItem);
                       $salesItem->discount = $com;
                       $salesItem->discount_amount = $discount;
                       $salesItem->total_price = $request->total_price[$index] - $discount;
                       $salesItem->save();

                      DB::table('ctcs')->where('invoice_no',$invoice)->where('category_id',$product->category_id)->update(['discount'=> $com, 'discount_amount' => $com*$ton*1000]);
              		}
                    }
                    
                }

            $totalPayable = $request->grand_total_value - $totalDisscount;
            DB::table('sales')->where('invoice_no',$invoice)->update(['grand_total' => $totalPayable,'discount'=> $totalDisscount]);
            DB::table('sales_orders')->where('invoice_no',$invoice)->update(['grand_total' => $totalPayable,'discount'=> $totalDisscount]);
            }
            
            */
  }
            $sale->order_number = $saleOrder->id;
            $sale->save();
            $saleOrder->order_status = 1;
            $saleOrder->save();

            Session::put('success', 'Order Updated & Confirm Successfull. Please Check Sales List.');
            return redirect()->route('sales.order.index');

}


}
