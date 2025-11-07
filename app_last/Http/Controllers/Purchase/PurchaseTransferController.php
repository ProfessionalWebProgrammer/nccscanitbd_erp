<?php

namespace App\Http\Controllers\Purchase;

use DB;

use Auth;
use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Factory;
use Illuminate\Http\Request;

use App\Models\PurchaseTransfer;
use App\Models\RowMaterialsProduct;
use App\Http\Controllers\Controller;

class PurchaseTransferController extends Controller
{
    public function index()
    {

      $transfers = PurchaseTransfer::select('purchase_transfers.*')->orderby('date','desc')->get();
    //  dd($transfers);
        return view('backend.purchase.transfer_index', compact('transfers'));
    }



    public function create()
    {

      $product = RowMaterialsProduct::all();
      $factoryes = Factory::all();

        return view('backend.purchase.transfer_create', compact('product','factoryes'));
    }
    public function store(Request $request)
    {
      $inv= PurchaseTransfer::latest('id')->first();
      if ($inv) {
          $invoice = 10000 + $inv->id + 1;
      } else {
          $invoice = 10000;
      }
        foreach ($request->product_id as $key => $product_id) {
                $transfer = new PurchaseTransfer;
                $transfer->invoice = 'PurT-'.$invoice;
                $transfer->from_wirehouse_id = $request->from_wirehouse_id ;
                $transfer->to_wirehouse_id = $request->to_wirehouse_id ;
                $transfer->date = $request->date ;
                $transfer->product_id = $product_id ;
                $transfer->qty = $request->qty[$key] ;
                //$transfer->receive_qty = $request->receive_quantity[$key] ;
                $transfer->receive_qty = $request->receive_qty[$key] ;
                $transfer->vehicle = $request->vehicle ;
                $transfer->transfer_fare = $request->transfer_fare ;
                $transfer->narration = $request->narration ;
                $transfer->save();

        }

        return redirect()->route('purchase.transfer.index')->with('success', 'Transfer Successfully');
    }

    public function edit($id)
    {
      $trdetails = PurchaseTransfer::where('id',$id)->first();
      $product = RowMaterialsProduct::all();
      $factoryes = Factory::all();

        return view('backend.purchase.transfer_edit', compact('product','factoryes','trdetails'));
    }

    public function update(Request $request)
    {

        //dd($request->all());

          $transfer = PurchaseTransfer::where('id',$request->id)->first();
                $transfer->from_wirehouse_id = $request->from_wirehouse_id ;
                $transfer->to_wirehouse_id = $request->to_wirehouse_id ;
                $transfer->date = $request->date ;
                $transfer->product_id = $request->product_id ;
                $transfer->qty = $request->qty ;
                $transfer->receive_qty = $request->receive_qty ;
                $transfer->vehicle = $request->vehicle;
                $transfer->transfer_fare = $request->transfer_fare;
                $transfer->narration = $request->narration;
                $transfer->save();


        return redirect()->route('purchase.transfer.index')->with('success', 'Transfer Update Successfully');
    }

    public function delete(Request $request)
    {

       $returndelete =  PurchaseTransfer::where('id', $request->id)->delete();

       if ($returndelete) {
           return redirect()->back()->with('success', 'Purchase Transfer Delete Successfully');

       }else{
        return redirect()->back()->with('error', 'Something Wrong');

       }

    }

    public function viewTransfer($invoice){
        	$user = DB::table('users')->where('id',Auth::id())->value('name');
     		$data = PurchaseTransfer::where('invoice',$invoice)->first();
      	$transferDetails = PurchaseTransfer::where('invoice',$invoice)->get();
       	return view('backend.purchase.transferChalanView', compact('user','data', 'transferDetails'));
      }


}
