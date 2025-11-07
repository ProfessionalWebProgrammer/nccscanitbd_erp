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
use App\Models\PurchaseDetail;
use App\Models\PurchaseLedger;
use App\Models\DeliveryConfirm;
use App\Models\PurchaseTransfer;
use App\Models\ScaleRowMaterial;
use App\Models\RowMaterialsProduct;
use App\Http\Controllers\Controller;

class PurchaseTransferController extends Controller
{
    public function index()
    {

      $tlist = '';
      $transfers = PurchaseTransfer::select('purchase_transfers.*','row_materials_products.product_name')
      ->leftjoin('row_materials_products', 'row_materials_products.id', '=', 'purchase_transfers.product_id')
      ->orderby('purchase_transfers.date','desc')->get();
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
        // $lastid = PurchaseTransfer::orderBy('id','desc')->first();

        // if ($lastid) {
        //     $trno = $lastid->id+100001;
        // }else{
        //     $trno = 100001;
        // }
       // dd($request->all());

        foreach ($request->product_id as $key => $product_id) {
                $transfer = new PurchaseTransfer;
              //  $transfer->transfer_no = $trno;
                $transfer->from_wirehouse_id = $request->from_wirehouse_id ;
                $transfer->to_wirehouse_id = $request->to_wirehouse_id ;
                $transfer->date = $request->date ;
                $transfer->product_id = $product_id ;
                $transfer->qty = $request->qty[$key] ;
                //$transfer->receive_qty = $request->receive_quantity[$key] ;
                $transfer->receive_qty = $request->receive_qty[$key] ;
                $transfer->save();

        }

        return redirect()->route('purchase.transfer.index')->with('success', 'Transfer Successfully');
    }

    public function edit($id)
    {

        
        $trdetails = PurchaseTransfer::where('id',$id)->first();

        // dd($trdetails);

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


   



}
