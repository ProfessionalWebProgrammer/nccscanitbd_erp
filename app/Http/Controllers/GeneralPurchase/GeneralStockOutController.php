<?php

namespace App\Http\Controllers\GeneralPurchase;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralProduct;
use App\Models\Factory;
use App\Models\GeneralWirehouse;
use App\Models\GeneralStockOut;
use Illuminate\Support\Facades\DB;

class GeneralStockOutController extends Controller
{
    public function index(Request $request)
    {

        // dd($request->all());
        $wirehouses = GeneralWirehouse::orderBy('wirehouse_name','asc')->get();


        $stockoutdata = DB::table('general_stock_outs')
            ->select('general_stock_outs.*', 'general_wirehouses.wirehouse_name', 'general_products.gproduct_name')
            ->leftJoin('general_wirehouses', 'general_wirehouses.wirehouse_id', 'general_stock_outs.wirehouse_id')
            ->leftJoin('general_products', 'general_products.id', 'general_stock_outs.product_id')
      		->orderBy('general_stock_outs.id','desc');

        if ($request->fdate != null && $request->tdate != null) {
            $fdate = $request->fdate;
            $tdate = $request->tdate;

            $stockoutdata =  $stockoutdata->whereBetween('general_stock_outs.date', [$fdate, $tdate]);
        } else {
            $fdate = '';
            $tdate = '';
          	$stockoutdata =  $stockoutdata->take(500);
        }
        if ($request->factory != null) {
            $fid = $request->factory;
            $stockoutdata =  $stockoutdata->where('general_stock_outs.wirehouse_id', $fid);
        } else {
            $fid = '';
        }

        $stockoutdata =  $stockoutdata->get();


        return view('backend.general_purchase.general_stockout_index', compact('stockoutdata', 'wirehouses', 'fdate', 'tdate', 'fid'));
    }
    public function createstockout(Request $request)
    {
       if ($request->session()->has('so_date')) {
            $date = $request->session()->get('so_date');
        } else {
            $date = date('Y-m-d');
        }
      if ($request->session()->has('sowr_id')) {
            $wr_id = $request->session()->get('sowr_id');
        } else {
            $wr_id = '';
        }
      //dd($request->session()->get('sowr_id'));
        $gproducts = GeneralProduct::all();
        $wirehouses = GeneralWirehouse::orderBy('wirehouse_name','asc')->get();
        return view('backend.general_purchase.ganeral_stockout_create', compact('gproducts', 'wirehouses','date','wr_id'));
    }
    public function storestockout(Request $request)
    {
         
      	if ($request->date) {
            $s_date = $request->date;
            $date_put = $request->session()->put('so_date', $s_date);
        } else {
            $s_date = date('Y-m-d');
        }
      
      	if ($request->wirehouses_id) {
            $wrs_id = $request->wirehouses_id;
            $wr_id_put = $request->session()->put('sowr_id', $wrs_id);
        }
      
      //dd($request->all());
        foreach ($request->products_id as $kye => $products) {

            $stockoutdata = new GeneralStockOut();
            $stockoutdata->date = $request->date;
            $stockoutdata->wirehouse_id = $request->wirehouses_id;
            $stockoutdata->product_id = $request->products_id[$kye];
            $stockoutdata->price = $request->price[$kye];
            $stockoutdata->quantity = $request->p_qty[$kye];
            $stockoutdata->dimensions = $request->dimension[$kye];
            $stockoutdata->Referance = $request->referance;
            $stockoutdata->note = $request->note;
            $stockoutdata->save();
        }
        return redirect()->back()->with('success','Stock Out Created Successfull! ');
    }
  	
  	public function stockoutedit($id)
    {
      	$editdata = GeneralStockOut::where('id',$id)->first();
      	$gproducts = GeneralProduct::all();
        $wirehouses = GeneralWirehouse::orderBy('wirehouse_name','asc')->get();
      	//dd($editdata);
    	return view('backend.general_purchase.general_stockout_edit',compact('editdata','gproducts', 'wirehouses'));    	
    }
  	public function stockoutupdate(Request $request)
    {
    	//dd($request->all());
      		$stockoutdata = GeneralStockOut::where('id',$request->id)->first();
            $stockoutdata->date = $request->date;
            $stockoutdata->wirehouse_id = $request->wirehouses_id;
            $stockoutdata->product_id = $request->products_id;
            $stockoutdata->price = $request->price;
            $stockoutdata->quantity = $request->p_qty;
            $stockoutdata->dimensions = $request->dimension;
            $stockoutdata->Referance = $request->referance;
            $stockoutdata->note = $request->note;
            $stockoutdata->save();
      return redirect()->route('general.purchase.stockout.index')->with('success','Stock Out Updated Successfull! ');
    }
  	public function deletestockout(Request $request)
    {
      //dd($request->all());
      GeneralStockOut::where('id',$request->id)->delete();
      return redirect()->back()->with('success','Stock Out Deleted Success!');
    }
  	
  	public function stockoutreportindedx()
    {
      	$wirehouses = GeneralWirehouse::orderBy('wirehouse_name','asc')->get();
    	return view('backend.general_purchase.stockout_report_index',compact('wirehouses'));
    }
  	public function stockoutreportview(Request $request)
    {
       if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
      
    	$wirehouses = DB::table('general_stock_outs')
          			->groupBy('wirehouse_id')
          			->whereBetween('date', [$fdate, $tdate])
                	->whereIn('wirehouse_id', $request->warehouse_id)
          			->get();
      //dd($wirehouses);
      return view('backend.general_purchase.stockout_report_view',compact('wirehouses','fdate','tdate'));
    }
}
