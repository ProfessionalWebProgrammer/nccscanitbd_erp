<?php

namespace App\Http\Controllers\GeneralPurchase;

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
            ->select('general_stock_outs.*', 'factories.factory_name', 'general_products.gproduct_name')
            ->leftJoin('factories', 'factories.id', 'general_stock_outs.wirehouse_id')
            ->leftJoin('general_products', 'general_products.id', 'general_stock_outs.product_id');

        if ($request->fdate != null && $request->tdate != null) {
            $fdate = $request->fdate;
            $tdate = $request->tdate;

            $stockoutdata =  $stockoutdata->whereBetween('general_stock_outs.date', [$fdate, $tdate]);
        } else {
            $fdate = '';
            $tdate = '';
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
    public function createstockout()
    {
        $gproducts = GeneralProduct::all();
        $wirehouses = GeneralWirehouse::orderBy('wirehouse_name','asc')->get();
        return view('backend.general_purchase.ganeral_stockout_create', compact('gproducts', 'wirehouses'));
    }
    public function storestockout(Request $request)
    {
        // dd($request->all());
        foreach ($request->products_id as $kye => $products) {

            $stockoutdata = new GeneralStockOut();
            $stockoutdata->date = $request->date;
            $stockoutdata->wirehouse_id = $request->factory_id[$kye];
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
  	public function deletestockout(Request $request)
    {
      //dd($request->all());
      GeneralStockOut::where('id',$request->id)->delete();
      return redirect()->back()->with('success','Stock Out Deleted Success!');
    }
}
