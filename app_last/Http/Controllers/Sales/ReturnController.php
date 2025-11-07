<?php

namespace App\Http\Controllers\Sales;

use Auth;


use Session;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Dealer;
use App\Models\Factory;
// use App\Models\Dealer_demand;
// use App\Models\Ddl_check_out;
// use App\Models\Transaction;
use App\Models\Employee;
use App\Models\SalesItem;
use App\Models\SalesLedger;
use App\Models\SalesStockIn;
use App\Models\SalesReturn;
use App\Models\SalesProduct;
 use App\Models\MontlySalesTarget;
 use App\Models\SalesStockOut;
 use App\Models\RawMaterialStockOut;
 use App\Models\PackingStockOut;
// use App\Models\DeliveryConfirm;
// use App\Models\Vehicle;
use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Demand_number;
use App\Models\SalesReturnItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Account\ChartOfAccounts;
use App\Traits\ChartOfAccount;

class ReturnController extends Controller
{
    use ChartOfAccount;
    public function index()
    {
        $id = Auth::id();


        // dd($emp_id[0]->id);
        $authid = $id = Auth::id();
        $dealerid = DB::select('SELECT dealers.id as did FROM dealers
        WHERE dealers.user_id ="' . $authid . '" ');
        // dd($dealerid[0]->did);
        // if(Auth::user()->user_role->role_id==1)
        // {
        $returnslist = DB::select('SELECT sales_returns.*,dealers.d_s_name,factories.factory_name,(select name from users where id=updated_by) as updated_by_name FROM `sales_returns`
LEFT JOIN dealers ON dealers.id = sales_returns.dealer_id
LEFT JOIN factories ON factories.id = sales_returns.warehouse_id
LEFT JOIN users ON users.id = sales_returns.emp_id where is_active=1 order by  date desc,invoice_no desc LIMIT 4000');

        // dd($returnslist);

        return view('backend.sales_return.index', compact('returnslist'));
    }









    public function returncreate(Request $request)
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
            $date = date('d M Y');
        }
        if ($request->session()->has('wr_id')) {
            $wr_id = $request->session()->get('wr_id');
            $wr_info = Factory::find($wr_id)->factory_name;
        } else {
            $wr_id = '';
            $wr_info = '';
        }

        return view('backend.sales_return.create', compact('products', 'factoryes', 'wr_id', 'wr_info', 'date', 'dealers', 'dealerlogid', 'employees', 'vehicles'));
    }


    public function returngenerate(Request $request)
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
       if (!$request->products_id && $request->qty) {
            return redirect()->back()
                ->with('error', 'Please Insert Product');
        }


        $factories = Factory::find($request->warehouse_id);
        //dd($factories);


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

        $invoice = 'SR-Inv-'.$demandInvoNumber->id;
        $return = new SalesReturn();
        $return->warehouse_id = $request->warehouse_id;
        $return->dealer_id = $request->dealer_id;
        //$return->user_id = $id;
        //$return->user_name = $userName;
        $return->vendor_area_id = $delaer_area_id;
        $return->vendor_area =  $delaer_area_name;
        $return->date = $date_f;
        //    $return->vehicle = $request->vehicle;
        //    $return->transport_cost = $request->transport_cost;
        $return->invoice_no = $invoice;
        $return->total_qty = $request->grand_total_qty;

        $return->price = $request->grand_total_value;
        $return->discount = $request->grand_total_discount;
        //    $return->price = $total_price;
        //    $return->grand_total = $total_price;
        $return->grand_total = $request->total_payable;

        $return->user_id = Auth::user()->id;
        $return->narration = $request->narration;
        $return->demand_month = $cmonth;
        $return->demand_year = $cyear;
        // $return->save();
        //dd($return);
        if ($return->save()) {

            // if( $request->type_id == 'fg' ){

                $this->createCreditForFinishedGoodsSaleReturn($request->dealer_id , $request->grand_total_value,$request->testdate,$request->narration,$invoice);
                $this->createDebitForFinishedGoodsSaleReturn('Sales Returns' , $request->grand_total_value,$request->testdate,$request->narration,$invoice);

              /*  $totalCostOfFg = 0;
                for($i = 0; $i < count($request->products_id); $i++){
                  $salesProduct = \App\Models\SalesStockIn::where('prouct_id',$request->products_id[$i])->orderBy('id','DESC')->first();

                  if($salesProduct){
                      $individualCost = ((float)$salesProduct->total_cost / (float)$salesProduct->quantity) * (int) $request->p_qty[$i];
                      $totalCostOfFg += $individualCost;
                  }
                }

                $this->createCreditForCogsOfFinishedGoodsSaleReturn('Cost of Good Sold of Finished Goods (FGCOGS)' , $totalCostOfFg ,$request->testdate,$request->narration);
                $this->createDeditForCogsOfFinishedGoodsSaleReturn('Finished Goods',$totalCostOfFg,$request->testdate,$request->narration);
            */
              $totalCostOfFg = 0; $totalRawCostOfFg =0;

            $initial_ledger = SalesLedger::where('vendor_id',  $request->dealer_id)->where('ledger_date', '<=', $return->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();
            //dd($initial_ledger);

            foreach ($request->products_id as $key => $item) {

                $product = SalesProduct::find($item);

                $return_item = new SalesReturnItem();
                $return_item->date = $date_f;
                $return_item->return_id = $return->id;
                $return_item->invoice_no = $invoice;
                $return_item->product_id = $item;
                $return_item->product_name = $product->product_name;
                $return_item->product_code = $product->product_code;
                $return_item->product_weight = $product->product_weight;
                $return_item->qty = $request->p_qty[$key];

                $return_item->unit_price = $request->p_price[$key];


                  $return_item->total_price = $request->total_price_without_discount[$key];
                //dd($return_item);
                $return_item->save();




                //FOr montly Sales


                $categorydata = DB::table('sales_products')->where('id', $item)->first();

                DB::table('montly_sales_targets')->insert([
                    'dealer_id' => $dealerdata->id,
                    'area_id' => $dealerdata->dlr_area_id,
                    'subzone_id' => $dealerdata->dlr_subzone_id,
                    'zone_id' => $dealerdata->dlr_zone_id,
                    'category_id' => $categorydata->category_id,
                    'product_id' => $item,
                    'return_id' => $return_item->id,
                    'return_invoice' => $invoice,
                    'date' => $return->date,
                    'qty_kg' => -($product->product_weight * $request->p_qty[$key])
                ]);


                $ledger = new SalesLedger();
                $previous_ledger = SalesLedger::where('vendor_id', $request->dealer_id)->where('ledger_date', '<=', $return->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();

                $ledger->vendor_id = $request->dealer_id;
                $ledger->area_id = $delaer_area_id;
                $ledger->ledger_date = $return->date;
                $ledger->invoice = $invoice;

                $ledger->return_id = $return_item->id;

                $ledger->warehouse_bank_name = 'Return (' .  $factories->factory_name . ')';
                $ledger->warehouse_bank_id = $request->warehouse_id;
                $ledger->is_bank = 0;
                $ledger->narration = $request->narration;
                $ledger->product_name = $product->product_name;
                $ledger->product_id = $item;

                $ledger->qty_kg = -($product->product_weight * $request->p_qty[$key]);

                $ledger->qty_pcs = -($request->p_qty[$key]);
                $ledger->unit_price = $request->p_price[$key];
                $ledger->total_price = -($request->total_price_without_discount[$key]);
                $ledger->save();

                $salesProduct = \App\Models\SalesStockIn::where('prouct_id',$item)->orderBy('id','DESC')->first();

                $date = $return->date;
                if($salesProduct) {
                  $checkStr = substr($salesProduct->sout_number, 0,3);
                  if($checkStr == 'PRO'){
                    $rawInfos = \App\Models\PurchaseStockout::where('finish_goods_id',$item)->where('sout_number',$salesProduct->sout_number)->get();
                    $packingInfos = \App\Models\PackingConsumptions::where('pro_invoice',$salesProduct->sout_number)->get();

                    foreach($rawInfos as $rawInfo){
                      $amount = (($rawInfo->total_amount) / (float)$salesProduct->quantity) * (int) $request->p_qty[$key];
                      $qty = (($rawInfo->stock_out_quantity) / (float)$salesProduct->quantity) * (int) $request->p_qty[$key];

                      $rawStockOut = new RawMaterialStockOut();
                      $rawStockOut->date = $date;
                      $rawStockOut->invoice = $invoice;
                      $rawStockOut->raw_product_id = $rawInfo->product_id;
                      $rawStockOut->product_id = $item;
                      $rawStockOut->wirehouse_id = $request->warehouse_id;
                      $rawStockOut->qty = -$qty;
                      $rawStockOut->rate = $rawInfo->stock_out_rate;
                      $rawStockOut->amount = -$amount;
                      $rawStockOut->note = $salesProduct->sout_number;
                      $rawStockOut->status = 1;
                      $rawStockOut->save();

                    }

                    if($packingInfos){
                      foreach($packingInfos as $packingInfo){
                        $amount = (($packingInfo->amount) / (float)$salesProduct->quantity) * (int) $request->p_qty[$key];
                        $qty = (($packingInfo->qty) / (float)$salesProduct->quantity) * (int) $request->p_qty[$key];

                        $packingStockOut = new PackingStockOut();
                        $packingStockOut->date = $date;
                        $packingStockOut->invoice = $invoice;
                        $packingStockOut->packing_id = $packingInfo->bag_id;
                        $packingStockOut->product_id = $item;
                        $packingStockOut->wirehouse_id = $request->warehouse_id;
                        $packingStockOut->qty = -$qty;
                        $packingStockOut->rate = $packingInfo->rate;
                        $packingStockOut->amount = -$amount;
                        $packingStockOut->note = '';
                        $packingStockOut->status = 1;
                        $packingStockOut->save();
                      }
                    }
                  } else {
                    $rate = SalesProduct::where('id', $item)->value('rate');
                    $individualCost = (int) $request->p_qty[$key] * $rate;

                    $rawStockOut = new RawMaterialStockOut();
                    $rawStockOut->date = $date;
                    $rawStockOut->invoice = $invoice;
                  //  $rawStockOut->raw_product_id = $rawInfo->product_id;
                    $rawStockOut->product_id = $item;
                    $rawStockOut->wirehouse_id = $request->warehouse_id;
                    $rawStockOut->qty = -$request->p_qty[$key];
                    $rawStockOut->rate = $rate;
                    $rawStockOut->amount = -$individualCost;
                    $rawStockOut->note = $request->narration ?? '';
                    $rawStockOut->status = 2;
                    $rawStockOut->save();
                  }

                 $productCostBag = \App\Models\PackingConsumptions::where('pro_invoice',$salesProduct->sout_number)->whereNotNull('pro_invoice')->sum('amount');
                    $individualRawCost = (($productCostBag) / (float)$salesProduct->quantity) * (int) $request->p_qty[$key];
                    $individualCost = (((float)$salesProduct->total_cost ) / (float)$salesProduct->quantity) * (int) $request->p_qty[$key];
                    $totalCostOfFg += $individualRawCost;
                    $totalRawCostOfFg += $individualCost;
                } else {
                    $rate = SalesProduct::where('id', $item)->value('rate');
                    $individualCost = (int) $request->p_qty[$key] * $rate;
                    $totalCostOfFg += 0 ;
                    $totalRawCostOfFg += $individualCost;

                    $rawStockOut = new RawMaterialStockOut();
                    $rawStockOut->date = $date;
                    $rawStockOut->invoice = $invoice;
                    $rawStockOut->product_id = $item;
                    $rawStockOut->wirehouse_id = $request->warehouse_id;
                    $rawStockOut->qty = -$request->p_qty[$key];
                    $rawStockOut->rate = $rate;
                    $rawStockOut->amount = -$individualCost;
                    $rawStockOut->note = $request->narration ?? '';
                    $rawStockOut->status = 2;
                    $rawStockOut->save();
                }

                    $stockOut = new SalesStockOut();
                      $stockOut->date = $request->testdate;
                      $stockOut->invoice = $invoice;
                      $stockOut->product_id = $item;
                      $stockOut->wirehouse_id = $request->warehouse_id;
                      $stockOut->qty = -($request->p_qty[$key]);
                      $stockOut->rate = $request->p_price[$key];
                      $stockOut->amount = -($individualCost);
                      $stockOut->note = $request->narration;
                      $stockOut->status = 1;
                      $stockOut->save();
            }

            $this->createCreditForCogsOfFinishedGoodsSaleReturn('Cost of Good Sold of Finished Goods (FGCOGS)' , $totalRawCostOfFg ,$request->testdate,$request->narration,$invoice);
            $this->createDeditForCogsOfFinishedGoodsSaleReturn('Finished Goods',$totalCostOfFg + $totalRawCostOfFg,$request->testdate,$request->narration,$invoice);
            $this->createCreditForCogsOfFinishedGoodsSaleReturn('Cost of Good Sold of Finished Goods (Packing)' , $totalCostOfFg ,$request->testdate,$request->narration,$invoice);


        }
        // dd($request);
        $type = "credit";
        $t_head = "Product Return";


        //dd($request->dealer_id);
        $check_invoice = SalesLedger::where('invoice', $invoice)->where('priority', 1)->first();
        if (!$check_invoice) {
            $ledger = new SalesLedger();
            $ledger->vendor_id = $request->dealer_id;
            $ledger->area_id = $delaer_area_id;
            $ledger->invoice = $invoice;
            $ledger->narration = $request->narration;
            $ledger->warehouse_bank_name = 'Return (' .  $factories->factory_name . ')';
            $ledger->warehouse_bank_id = $request->warehouse_id;
            $ledger->ledger_date = date('Y-m-d', strtotime($return->date));
            $ledger->priority = 4;

            $ledger->credit = $request->total_payable;
            // $ledger->debit = $total_price;

            // $ledger->closing_balance = $ledger_update->closing_balance;
            // $ledger->credit_limit = $ledger_update->credit_limit;

            $ledger->save();

            if ($ledger->save()) {
                $return->ledger_status = 1;
                $return->save();
            }
        }

        Session::put('success', 'Return Created Successfull. Please Check Return  List.');

        return redirect()->back();
    }


    public function checkoutindex($invoice)
    {

        $id = Auth::id();
        $returnsdetails = SalesReturn::where('invoice_no', $invoice)->first();
        $returnsitems = SalesReturnItem::where('invoice_no', $invoice)->get();

        // dd($returnsdetails);

        $dealerlogid = Dealer::latest('id')->where('user_id', '=', $id)->get();
        $products = SalesProduct::orderBy('product_name', 'ASC')->get();
        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $employees = Employee::latest('id')->get();
        $factoryes = Factory::latest('id')->get();

        //dd( $request->all());

        return view('backend.sales_return.edit', compact('products', 'factoryes', 'dealers', 'returnsdetails', 'returnsitems'));
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


        $return =  SalesReturn::where('invoice_no',$request->invoice)->first();
        $return->warehouse_id = $request->warehouse_id;
        $return->dealer_id = $request->dealer_id;
        //$return->user_id = $id;
        //$return->user_name = $userName;
        $return->vendor_area_id = $delaer_area_id;
        $return->vendor_area =  $delaer_area_name;
        $return->date = $date_f;
        //    $return->vehicle = $request->vehicle;
        //    $return->transport_cost = $request->transport_cost;
        $return->invoice_no = $request->invoice;
        $return->total_qty = $request->grand_total_qty;

        $return->price = $request->grand_total_value;
        $return->discount = $request->grand_total_discount;
        //    $return->price = $total_price;
        //    $return->grand_total = $total_price;
        $return->grand_total = $request->total_payable;

        $return->user_id = Auth::user()->id;
        $return->narration = $request->narration;

        // $return->save();
        //dd($return);
        if ($return->save()) {
            $initial_ledger = SalesLedger::where('vendor_id',  $request->dealer_id)->where('ledger_date', '<=', $return->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();
            //dd($initial_ledger);

          	$deletefisrt = SalesReturnItem::where('invoice_no',$request->invoice)->delete();
          	$deletefisrt1 = SalesLedger::where('invoice',$request->invoice)->delete();
          	$deletefisrt2 = DB::table('montly_sales_targets')->where('return_invoice',$request->invoice)->delete();
            foreach ($request->products_id as $key => $item) {
                $product = SalesProduct::find($item);
                $return_item = new SalesReturnItem();
                $return_item->return_id = $return->id;
                $return_item->invoice_no = $request->invoice;
                $return_item->product_id = $item;
                $return_item->product_name = $product->product_name;
                $return_item->product_code = $product->product_code;
                $return_item->product_weight = $product->product_weight;
                $return_item->qty = $request->p_qty[$key];
                $return_item->unit_price = $request->p_price[$key];
                $return_item->total_price = $request->total_price_without_discount[$key];

                //dd($return_item);
                $return_item->save();


                //FOr montly Sales


                $categorydata = DB::table('sales_products')->where('id', $item)->first();

                DB::table('montly_sales_targets')->insert([
                    'dealer_id' => $dealerdata->id,
                    'area_id' => $dealerdata->dlr_area_id,
                    'subzone_id' => $dealerdata->dlr_subzone_id,
                    'zone_id' => $dealerdata->dlr_zone_id,
                    'category_id' => $categorydata->category_id,
                    'product_id' => $item,
                    'return_id' => $return_item->id,
                    'return_invoice' =>$request->invoice,
                    'date' => $return->date,
                    'qty_kg' => -($product->product_weight * $request->p_qty[$key])
                ]);


                $ledger = new SalesLedger();

                $ledger->vendor_id = $request->dealer_id;
                $ledger->area_id = $delaer_area_id;
                $ledger->ledger_date = $return->date;
                $ledger->invoice = $request->invoice;
                $ledger->return_id = $return_item->id;
                $ledger->warehouse_bank_name = 'Return (' .  $factories->factory_name . ')';
                $ledger->warehouse_bank_id = $request->warehouse_id;
                $ledger->is_bank = 0;

                $ledger->product_name = $product->product_name;
                $ledger->product_id = $item;

                $ledger->qty_kg = -($product->product_weight * $request->p_qty[$key]);

                $ledger->qty_pcs = -($request->p_qty[$key]);
                $ledger->unit_price = $request->p_price[$key];

                $ledger->total_price = -($request->total_price_without_discount[$key]);
                $ledger->save();
            }
        }
        // dd($request);
        $type = "credit";
        $t_head = "Product Return";


        //dd($request->dealer_id);
        $check_invoice = SalesLedger::where('invoice', $request->invoice)->where('priority', 1)->first();
        if (!$check_invoice) {

            $ledger = new SalesLedger();
            $ledger->vendor_id = $request->dealer_id;
            $ledger->area_id = $delaer_area_id;
            $ledger->invoice = $request->invoice;
            $ledger->warehouse_bank_name = 'Return (' .  $factories->factory_name . ')';
            $ledger->warehouse_bank_id = $request->warehouse_id;
            $ledger->ledger_date = date('Y-m-d', strtotime($return->date));
            $ledger->priority = 4;

            $ledger->credit = $request->total_payable;
            // $ledger->debit = $total_price;

            // $ledger->closing_balance = $ledger_update->closing_balance;
            // $ledger->credit_limit = $ledger_update->credit_limit;


            $ledger->save();

            if ($ledger->save()) {
                $return->ledger_status = 1;
                $return->save();
            }
        }


        Session::put('success', 'Invoice Edit Successfull. Please Check Invoice List.');

        return redirect()->route('sales.return.index');
        // ->with('success','Product Sales Successfull');

    }

  	public function detailesview($id)
    {
      	$returninvoicedata = SalesReturn::where('invoice_no',$id)->first();
      	$returnitems = SalesReturnItem::where('invoice_no',$id)->get();
    	//dd($returninvoicedata);
      	return view('backend.sales_return.returnitemview', compact('returninvoicedata', 'returnitems'));
    }

    public function returnDelete(Request $request){
        //dd($request->all());

        $uid = Auth::id();

        SalesReturn::where('invoice_no', $request->invoice)->delete();


        SalesReturnItem::where('invoice_no', $request->invoice)->delete();

        SalesLedger::where('invoice', $request->invoice)->delete();
      	ChartOfAccounts::where('invoice', $request->invoice)->delete();
      	SalesStockOut::where('invoice', $request->invoice)->delete();
      	RawMaterialStockOut::where('invoice', $request->invoice)->delete();
        PackingStockOut::where('invoice', $request->invoice)->delete();
        DB::table('montly_sales_targets')->where('return_invoice', $request->invoice)->delete();

        return redirect()->back()->with('success', 'Invoice Delete Successfull.');
    }
	public function partialReturn($invoice){
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

        return view('backend.sales.return', compact('products', 'factoryes', 'dealers', 'salesdetails', 'salesitems'));
	}

	public function updatePartialReturn(Request $request){
      //dd($request->all());
      /*
     //dd($request->all());
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
          $totalReturn = 0;
      	  $totalReturnPrice = 0;
          foreach($request->return_qty as $key => $val)
          {
          $totalReturn += $request->return_qty[$key];
          $totalReturnPrice += $request->return_qty[$key] * $request->p_price[$key];
          }
      //dd($totalReturn);
      	//$return =  SalesReturn::where('invoice_no',$request->invoice)->first();

        $return =  new SalesReturn;
        $return->warehouse_id = $request->warehouse_id;
        $return->dealer_id = $request->dealer_id;
        $return->vendor_area_id = $delaer_area_id;
        $return->vendor_area =  $delaer_area_name;
        $return->date = $date_f;
        $return->invoice_no = $request->invoice;
        $return->total_qty = $request->grand_total_qty;
		$return->total_return_qty = $totalReturn;
        $return->price = $request->grand_total_value;
        $return->discount = $request->grand_total_discount;
        $return->grand_total = $request->total_payable;
        $return->user_id = Auth::user()->id;
        $return->narration = $request->narration;
		$return->save();

        //dd($return);
        $totalDiscount = 0;

         foreach($request->products_id as $key => $val){
           $returnItem = new SalesReturnItem;
           $returnItem->return_id = $return->id;
           $returnItem->invoice_no = $request->invoice;
           $returnItem->product_id = $request->products_id[$key];
           $returnItem->product_code = $request->product_code[$key];
           $returnItem->product_weight = $request->product_weight[$key];
           $returnItem->qty = $request->p_qty[$key];
           $returnItem->return_qty = $request->return_qty[$key];
           $returnItem->unit_price = $request->p_price[$key];
           $returnItem->total_price = $request->total_price[$key];
           $returnItem->save();

           $q= 0;
           $updatePrice = 0;
           $salesStock = SalesStockIn::where('prouct_id',$request->products_id[$key])->where('factory_id',$request->warehouse_id)->first();
           if(!empty($salesStock->quantity)){
             $q = (int)$salesStock->quantity + $request->return_qty[$key];
           } else {
           	 $q = $request->return_qty[$key];
           }
           //dd($q);
           $salesStock->quantity = $q;
           $salesStock->save();

           $qty = 0;
           $ton = 0;
           $discount = 0;
         	$qty = $request->p_qty[$key] - $request->return_qty[$key];

            $qtykg = $request->product_weight[$key] * $qty;

            $com = DB::table('product_commissions')->where('product_id', $request->products_id[$key])->first();

             $ton = $qtykg/1000;
              	if( $ton >= $com->min_target && $ton <= $com->max_target){
                   $discount = $com->achive_commision*$qtykg;
                } else {
                  $discount = 0;
                }

           $totalDiscount += $discount;

           $salesItem = SalesItem::where('invoice_no', $request->invoice)->where('product_id',$request->products_id[$key])->first();
           $updatePrice = $qty * $request->p_price[$key];

           $salesItem->qty = $salesItem->qty - $request->return_qty[$key];
           $salesItem->total_price = $returnPrice;
           $salesItem->discount = $com->achive_commision ?? '';
           $salesItem->discount_amount = $discount;
           $salesItem->save();

           $salesledger = SalesLedger::where('invoice', $request->invoice)->where('product_id',$request->products_id[$key])->first();
           $salesledger->qty_pcs = $salesledger->qty_pcs -  $request->return_qty[$key];
           $salesledger->qty_kg = $qtykg;
           $salesledger->discount = $com->achive_commision ?? '';
           $salesledger->discount_amount = $discount;
           $salesledger->total_price = $updatePrice;
           $salesledger->save();

           $salesTarget = MontlySalesTarget::where('sales_invoice', $request->invoice)->where('product_id',$request->products_id[$key])->first();
           $salesTarget->qty_kg = $qtykg;
           $salesTarget->save();
         }


      	$sale = Sale::where('invoice_no', $request->invoice)->first();
      	$sale->total_qty = 	$sale->total_qty - $totalReturn;
        $sale->price =   $sale->price - $totalReturnPrice;
      	$sale->discount = $sale->discount - $totalDiscount;
        $sale->grand_total = $sale->grand_total - $totalReturnPrice;
      	$sale->save();


        if ($return->save() && $returnItem->save()) {
            $initial_ledger = SalesLedger::where('vendor_id',  $request->dealer_id)->where('ledger_date', '<=', $return->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();
            //dd($initial_ledger);
        }
      */

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
       if (!$request->products_id && $request->qty) {
            return redirect()->back()
                ->with('error', 'Please Insert Product');
        }


        $factories = Factory::find($request->warehouse_id);
        //dd($factories);


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


        $return = new SalesReturn();
        $return->warehouse_id = $request->warehouse_id;
        $return->dealer_id = $request->dealer_id;
        //$return->user_id = $id;
        //$return->user_name = $userName;
        $return->vendor_area_id = $delaer_area_id;
        $return->vendor_area =  $delaer_area_name;
        $return->date = $date_f;
        //    $return->vehicle = $request->vehicle;
        //    $return->transport_cost = $request->transport_cost;
        $return->invoice_no = $request->invoice;
        $return->total_qty = $request->grand_total_qty;

        $return->price = $request->grand_total_value;
        $return->discount = $request->grand_total_discount;
        //    $return->price = $total_price;
        //    $return->grand_total = $total_price;
        $return->grand_total = $request->total_payable;

        $return->user_id = Auth::user()->id;
        $return->narration = $request->narration;
        $return->demand_month = $cmonth;
        $return->demand_year = $cyear;
        // $return->save();
        //dd($return);
        if ($return->save()) {
            $initial_ledger = SalesLedger::where('vendor_id',  $request->dealer_id)->where('ledger_date', '<=', $return->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();
            //dd($initial_ledger);

            foreach ($request->products_id as $key => $item) {

            $qty= 0;
              $temp = 0;
           $salesStock = SalesStockIn::where('prouct_id',$request->products_id[$key])->where('factory_id',$request->warehouse_id)->first();

           if(!empty($salesStock->quantity)){
             $qty = (int)$salesStock->quantity + $request->p_qty[$key];
           } else {
           	 $qty = $request->p_qty[$key];
           }

           $salesStock->quantity = $qty;
           $salesStock->save();


                $product = SalesProduct::find($item);

                $return_item = new SalesReturnItem();
                $return_item->return_id = $return->id;
                $return_item->invoice_no = $request->invoice;
                $return_item->product_id = $item;

                $return_item->product_name = $product->product_name;
                $return_item->product_code = $product->product_code;
                $return_item->product_weight = $product->product_weight;
                $return_item->qty = $request->p_qty[$key];

                $return_item->unit_price = $request->p_price[$key];


                  $return_item->total_price = $request->total_price_without_discount[$key];

                //dd($return_item);
                $return_item->save();


                //FOr montly Sales


                $categorydata = DB::table('sales_products')->where('id', $item)->first();

                DB::table('montly_sales_targets')->insert([
                    'dealer_id' => $dealerdata->id,
                    'area_id' => $dealerdata->dlr_area_id,
                    'subzone_id' => $dealerdata->dlr_subzone_id,
                    'zone_id' => $dealerdata->dlr_zone_id,
                    'category_id' => $categorydata->category_id,
                    'product_id' => $item,
                    'return_id' => $return_item->id,
                    'return_invoice' => $request->invoice,
                    'date' => $return->date,
                    'qty_kg' => -($product->product_weight * $request->p_qty[$key])
                ]);


                $ledger = new SalesLedger();
                $previous_ledger = SalesLedger::where('vendor_id', $request->dealer_id)->where('ledger_date', '<=', $return->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();

                $ledger->vendor_id = $request->dealer_id;
                $ledger->area_id = $delaer_area_id;
                $ledger->ledger_date = $return->date;
                $ledger->invoice = $request->invoice;

                $ledger->return_id = $return_item->id;

                $ledger->warehouse_bank_name = 'Return (' .  $factories->factory_name . ')';
                $ledger->warehouse_bank_id = $request->warehouse_id;
                $ledger->is_bank = 0;

                $ledger->product_name = $product->product_name;
                $ledger->product_id = $item;

                $ledger->qty_kg = -($product->product_weight * $request->p_qty[$key]);

                $ledger->qty_pcs = -($request->p_qty[$key]);

                $ledger->unit_price = $request->p_price[$key];

                $ledger->total_price = -($request->total_price_without_discount[$key]);

                $ledger->save();
            }
        }
        // dd($request);
        $type = "credit";
        $t_head = "Product Return";

        $check_invoice = SalesLedger::where('invoice', $request->invoice)->where('priority', 1)->first();
      //dd($check_invoice);
        if (!empty($check_invoice)) {

            $ledger = new SalesLedger();
            $ledger->vendor_id = $request->dealer_id;
            $ledger->area_id = $delaer_area_id;
            $ledger->invoice = $request->invoice;
            $ledger->return_id = $return_item->id;
            $ledger->warehouse_bank_name = 'Return (' .  $factories->factory_name . ')';
            $ledger->warehouse_bank_id = $request->warehouse_id;
            $ledger->ledger_date = date('Y-m-d', strtotime($return->date));
            $ledger->priority = 4;

            $ledger->credit = $request->total_payable;
            // $ledger->debit = $total_price;

            // $ledger->closing_balance = $ledger_update->closing_balance;
            // $ledger->credit_limit = $ledger_update->credit_limit;

            $ledger->save();

            if ($ledger->save()) {
                $return->ledger_status = 1;
                $return->save();
            }
        }


        //Session::put('success', 'Return Created Successfull. Please Check Return  List.');

       // return redirect()->back();
      return redirect()->route('sales.index')->with('success', 'Invoice Return Success!');
    }
      public function salesReturnReport(){
      return view('backend.sales_return.salesReturnIndex');
    }

    public function salesReturnReportView(Request $request){
      //dd($request->all());

      if (isset($request->date)) {
          $dates = explode(' - ', $request->date);
          $fdate = date('Y-m-d', strtotime($dates[0]));
          $tdate = date('Y-m-d', strtotime($dates[1]));
      }

      $dealers = SalesReturn::select('warehouse_id','dealer_id','invoice_no')->whereBetween('date',[$fdate, $tdate])->get();

      return view('backend.sales_return.salesReturnReportView', compact('fdate', 'tdate', 'dealers'));
    }
}
