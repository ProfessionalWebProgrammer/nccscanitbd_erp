<?php

namespace App\Http\Controllers\GeneralPurchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralProduct;
use App\Models\Factory;
use App\Models\GeneralWirehouse;
use App\Models\GeneralTransfer;

class GeneralTransferController extends Controller
{
    public function index()
    {
        $gtransfer =  GeneralTransfer::all();
        return view('backend.general_purchase.general_transfer_index', compact('gtransfer'));
    }
    public function createtransfer()
    {
        $gproducts = GeneralProduct::all();
        $wirehouse = GeneralWirehouse::orderBy('wirehouse_name','asc')->get();
        return view('backend.general_purchase.ganeral_transfer_create', compact('gproducts', 'wirehouse'));
    }
    public function storetransfer(Request $request)
    {
        // dd($request->all());
        foreach ($request->products_id as $key => $products) {
            $transferdata = new GeneralTransfer();
            $transferdata->date = $request->date;
            $transferdata->from_wirehouse = $request->factory_out_id;
            $transferdata->to_wirehouse = $request->factory_in_id;
            $transferdata->fwarehouse = Factory::where('id', $request->factory_out_id)->value('factory_name');
            $transferdata->twarehouse = Factory::where('id', $request->factory_in_id)->value('factory_name');
            $transferdata->product_id = $request->products_id[$key];
            $transferdata->quantity = $request->p_qty[$key];
            $transferdata->price = $request->price[$key];
            $transferdata->dimension = $request->dimension[$key];
            $transferdata->save();
        }
        return redirect()->back()->with('success','Transfer Success!');
    }
  
  	public function destroytransfer(Request $request)
    {
      	//dd($request->all());
      	GeneralTransfer::where('id',$request->id)->delete();
      	return redirect()->back()->with('success','Transfer Deleted Success!');
    }
}
