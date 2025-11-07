<?php

namespace App\Http\Controllers;

use App\Models\Factory;
use App\Models\Transfer;
use App\Models\SalesProduct;
use App\Models\PackingConsumptions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TransferController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
        if ($request->vendor_id) {
            $transfer = DB::select('select transfers.invoice,transfers.created_at,transfers.updated_at,transfers.confirm_status,transfers.date,transfers.vehicle,transfers.transfer_fare,transfers.p_branch_id,transfers.note,transfers.from_wirehouse,transfers.to_wirehouse,SUM(transfers.qty) as qty,SUM(transfers.price) as price from transfers
            WHERE transfers.date BETWEEN "' . $fdate . '" AND "' . $tdate . '" AND (transfers.from_wirehouse = "' . $request->vendor_id . '" OR transfers.to_wirehouse = "' . $request->vendor_id . '" )
            GROUP BY transfers.invoice,transfers.date,transfers.confirm_status,transfers.vehicle,transfers.transfer_fare,transfers.from_wirehouse,transfers.to_wirehouse ORDER BY transfers.invoice desc');
        } else {
            $transfer = DB::select('select transfers.invoice,transfers.created_at,transfers.updated_at,transfers.date,transfers.vehicle,transfers.confirm_status,transfers.transfer_fare,transfers.p_branch_id,transfers.note,transfers.from_wirehouse,transfers.to_wirehouse,SUM(transfers.qty) as qty ,SUM(transfers.price) as price from transfers
            GROUP BY transfers.invoice,transfers.date,transfers.confirm_status,transfers.vehicle,transfers.transfer_fare,transfers.from_wirehouse,transfers.to_wirehouse ORDER BY transfers.invoice desc LIMIT 200');
        }
        //dd($transfer);
        // WHERE transfers.date BETWEEN "' . $fdate . '" AND "' . $tdate . '"
        return view('backend.sales_product.transferlist', compact('transfer'));
    }
    //Create Transfer
    public function createTransfer()
    {
        $factory = Factory::ALL();
        $salesProducts = SalesProduct::all();
        return view('backend.sales_product.transfer', compact('factory', 'salesProducts'));
    }

    //Srore Transfer
    public function storeTransfer(Request $request)
    {
      //dd($request->all());
        $in = Transfer::latest('id')->first();
        if ($in) {
          $temp = 10000 + $in->id;
            $invoice = 'T-'.$temp;
        } else {
            $invoice = 'T-10000';
        }

        foreach ($request->product_id as $key => $product) {

            $openingData = DB::table('sales_products')->where('id', $product)->first();
            $salesProduct = \App\Models\SalesStockIn::where('prouct_id', $request->product_qty[$key])->orderBy('id','DESC')->first();
            if($salesProduct){
              $tempAmount = $salesProduct->total_cost;
              $tempQty = $salesProduct->quantity ;
              if($openingData){
                $tempAmount += ($openingData->opening_balance * $openingData->rate);
                $tempQty += $openingData->opening_balance;
                $rate = round(($tempAmount/$tempQty),2);
              } else {
                $rate = round(($tempAmount/$tempQty),2);
              }
            } else {
              $rate = round($openingData->rate,2);
            }

            //$rate = (float)$salesProduct->production_rate;
            /*  $rate = $tempAmount/$tempQty;
            $p_rate = $product_rate->product_dp_price;
            $p_value = $product_rate->product_dp_price * $request->product_qty[$key]; */

            $storeTransfer = new Transfer();
            $storeTransfer->date = $request->date;
            $storeTransfer->invoice = $invoice;
            $storeTransfer->from_wirehouse = $request->from_wirehouse;
            $storeTransfer->to_wirehouse = $request->to_wirehouse;
            $storeTransfer->vehicle = $request->vehicle;
            $storeTransfer->p_branch_id = $request->batch_number[$key];
            $storeTransfer->transfer_fare = $request->transfer_fare;
            $storeTransfer->product_id = $request->product_id[$key];
            $storeTransfer->category_id = $openingData->category_id;
            $storeTransfer->qty = $request->product_qty[$key];
            $storeTransfer->price = $request->product_qty[$key]*$rate;
            $storeTransfer->save();

        }

        return redirect()->back()->with('success', 'Transfer Create Successfully');
    }

	public function viewTransfer($invoice){
      	$user = DB::table('users')->where('id',Auth::id())->value('name');
   		$data = DB::table('transfers')->where('invoice',$invoice)->first();
    	$transferDetails = DB::table('transfers as t')->select('t.qty','p.product_name')->leftjoin('sales_products as p', 'p.id', '=', 't.product_id')->where('t.invoice',$invoice)->get();
     	return view('backend.sales_product.transferChalanView', compact('user','data', 'transferDetails'));
    }

    public function deleteTransfer(Request $request){
        //dd($request->all());
        $uid = Auth::id();
        Transfer::where('invoice', $request->invoice)->delete();
        return redirect()->back()->with('success', 'Transfer Delete Successfull.');
    }


    public function editTransfer($invoice)
    {
        $factory = Factory::ALL();
        $salesProducts = SalesProduct::all();
       $trdata = Transfer::where('invoice',$invoice)->get();
        return view('backend.sales_product.transfer_edit', compact('factory', 'salesProducts','trdata'));
    }

    //Srore Transfer
    public function updateTransfer(Request $request)
    {
     // dd($request->all());
        foreach ($request->product_id as $key => $product) {

          $openingData = DB::table('sales_products')->where('id', $product)->first();
          $salesProduct = \App\Models\SalesStockIn::where('prouct_id', $product)->orderBy('id','DESC')->first();
          if($salesProduct){
            $tempAmount = $salesProduct->total_cost;
            $tempQty = $salesProduct->quantity ;
            if($openingData){
              $tempAmount += ($openingData->opening_balance * $openingData->rate);
              $tempQty += $openingData->opening_balance;
              $rate = $tempAmount/$tempQty;
            } else {
              $rate = $tempAmount/$tempQty;
            }
          } else {
            $rate = $openingData->rate;
          }
          $packingAmountInfo = PackingConsumptions::where('pro_invoice',$salesProduct->sout_number)->sum('amount');
          $packingRate = $packingAmountInfo / $salesProduct->quantity;

            $total = ($request->product_qty[$key] * $rate) + ($request->product_qty[$key] * $packingRate);
            $storeTransfer = Transfer::where('invoice',$request->invoice_no)->first();
            // dd($storeTransfer);
            $storeTransfer->date = $request->date;
            $storeTransfer->invoice = $request->invoice_no;
            $storeTransfer->from_wirehouse = $request->from_wirehouse;
            $storeTransfer->to_wirehouse = $request->to_wirehouse;
            $storeTransfer->vehicle = $request->vehicle;
            $storeTransfer->note = $request->note;
            $storeTransfer->transfer_fare = $request->transfer_fare;
            $storeTransfer->product_id = $request->product_id[$key];
            $storeTransfer->category_id = $openingData->category_id;
            $storeTransfer->qty = $request->product_qty[$key];
            $storeTransfer->price = $total;
          //  $storeTransfer->created_at =$deletecreatetime;
            //$storeTransfer->confirm_status =$confirm_status;
            $storeTransfer->save();

            // Transfer::insert([
            //     'date' => $request->date,
            //     'invoice_no' => $invoice,
            //     'from_wirehouse' => $request->from_wirehouse,
            //     'to_wirehouse' => $request->to_wirehouse,
            //     'vehicle' => $request->vehicle,
            //     'transfer_fare' => $request->transfer_fare,
            //     'product_id' => $product,
            //     //  'rate'=>$p_rate,
            //     'qty' => $request->product_qty[$key],
            //     'price' => $p_value,
            // ]);
        }

        return redirect()->route('product.transfer.list')->with('success', 'Transfer Edit Successfully');
    }

   public function returnTransfer($invoice)
    {

      $trdata = Transfer::where('invoice',$invoice)->update(['qty' => 0,'confirm_status'=>2]);

        return redirect()->route('product.transfer.list')->with('success', 'Transfer Return Successfully');
    }


   public function TransferStatus(){

      $uid = Auth::id();

      $user = User::find($uid);
      // dd($user);

      if ($user->wairehouse_id) {
          $transfer = DB::select('select transfers.invoice,transfers.confirm_status,transfers.date,transfers.vehicle,transfers.transfer_fare,transfers.from_wirehouse,transfers.to_wirehouse,SUM(transfers.qty) as qty ,SUM(transfers.price) as price from transfers
            WHERE transfers.confirm_status=0 AND transfers.to_wirehouse="'.$user->wairehouse_id.'"
            GROUP BY transfers.invoice,transfers.date,transfers.vehicle,transfers.transfer_fare,transfers.from_wirehouse,transfers.to_wirehouse ORDER BY transfers.invoice desc');
        }else{
           if($uid == 101){
                  $transfer = DB::select('select transfers.invoice,transfers.confirm_status,transfers.date,transfers.vehicle,transfers.transfer_fare,transfers.from_wirehouse,transfers.to_wirehouse,SUM(transfers.qty) as qty ,SUM(transfers.price) as price from transfers
                WHERE transfers.confirm_status=0
                GROUP BY transfers.invoice,transfers.date,transfers.vehicle,transfers.transfer_fare,transfers.from_wirehouse,transfers.to_wirehouse ORDER BY transfers.invoice desc');

            }else{
               $transfer = DB::select('select transfers.invoice,transfers.confirm_status,transfers.date,transfers.vehicle,transfers.transfer_fare,transfers.from_wirehouse,transfers.to_wirehouse,SUM(transfers.qty) as qty ,SUM(transfers.price) as price from transfers
                WHERE transfers.confirm_status=2
                GROUP BY transfers.invoice,transfers.date,transfers.vehicle,transfers.transfer_fare,transfers.from_wirehouse,transfers.to_wirehouse ORDER BY transfers.invoice desc');

            }
      }

   //  dd($transfer);

          return view('backend.sales_product.transfer_status_index',compact('transfer'));
        }


        public function TransferStatusUpdate($id){

          $transfer = Transfer::WHERE('invoice',$id)->get();

          foreach ($transfer as  $date) {
            $transferstatus = Transfer::find($date->id);
            $transferstatus->confirm_status=1;
            $transferstatus->save();
          }

          return back()->with('success','Transer Confirm');


        }

  //ajax routes

  public function getbatchnumbers($id)
  {
  	$numbers = DB::table('sales_stock_ins')
      ->select('batch_id')
      ->where('factory_id',$id)
      ->where('batch_id','!=', '')
      ->groupBy('batch_id')
      ->get();
    return response()->json($numbers);
  }


}
