<?php

namespace App\Http\Controllers\GeneralPurchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralWirehouse;
use App\Models\Dealer;
use App\Models\GeneralSupplier;
use App\Models\GeneralProduct;
use App\Models\Factory;
use Illuminate\Support\Facades\DB;

class GeneralPurReportController extends Controller
{
    public function reportindex()
    {
        $suppliers = GeneralSupplier::orderBy('supplier_name','asc')->get();
        $wirehouse = GeneralWirehouse::orderBy('wirehouse_name','asc')->get();
        $gproducts = GeneralProduct::all();
        return view('backend.general_purchase.general_pur_report_index', compact('suppliers', 'gproducts', 'wirehouse'));
    }

    public function viewreport(Request $request)
    {
         //dd($request->all());
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        // dd($fdate, $tdate);


        $products = $request->products_id;
        if ($request->suppliers !== null && $products  == null && $request->factories == null) {
            // dd('Only suppliers Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('supplier_id', $request->suppliers)
                ->get();
        } elseif ($request->suppliers == null && $products  == null && $request->factories !== null) {
            // dd('Only Factories  Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('warehouse_id', $request->factories)
                ->get();
        } elseif ($request->suppliers == null && $products  !== null && $request->factories == null) {
            // dd('Only Product Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('product_id', $products)
                ->get();
        } elseif ($request->suppliers !== null && $products  !== null && $request->factories == null) {
            // dd('Dealer and Product Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('supplier_id', $request->suppliers)
                ->whereIn('product_id', $products)
                ->get();
        } elseif ($request->suppliers == null && $products  !== null && $request->factories !== null) {
            // dd('Factory and Product Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('warehouse_id', $request->factories)
                ->whereIn('product_id', $products)
                ->get();
        } elseif ($request->suppliers !== null && $products  == null && $request->factories !== null) {
            // dd('Factory and Dealer Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('supplier_id', $request->suppliers)
                ->whereIn('warehouse_id', $request->factories)
                ->get();
        } elseif ($request->suppliers !== null && $products  !== null && $request->factories !== null) {
            // dd('Factory and Product and Dealer Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('warehouse_id', $request->factories)
                ->whereIn('supplier_id', $request->suppliers)
                ->whereIn('product_id', $products)
                ->get();
        } elseif ($request->suppliers == null && $products  == null && $request->factories == null) {
            // dd('Nothing Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->get();
        }
        // dd($reportdata);
        return view('backend.general_purchase.general_purchase_report_view', compact('reportdata', 'products', 'fdate', 'tdate'));
    }
  
  
  
  public function stockreportindex()
    {
        $wirehouse = GeneralWirehouse::orderBy('wirehouse_name','asc')->get();
        $gproducts = GeneralProduct::all();
        return view('backend.general_purchase.stock_report_index', compact('gproducts', 'wirehouse'));
    }

    public function stockviewreport(Request $request)
    {
       //  dd($request->all());
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        // dd($fdate, $tdate);
      if($request->warehouse_id){
       $wirehousedata = GeneralWirehouse::whereIn('wirehouse_id',$request->warehouse_id)->get();
      }else{
       $wirehousedata = GeneralWirehouse::all();
      
      }
      if($request->product_id){
       $gproducts = GeneralProduct::whereIn('id',$request->product_id)->get();
      }else{
       $gproducts = GeneralProduct::all();
      
      }
     
        // dd($reportdata); 
        return view('backend.general_purchase.stock_report', compact( 'wirehousedata','gproducts', 'fdate', 'tdate'));
    }
  	public function comparisonreportindex()
    {
       	$suppliers = GeneralSupplier::orderBy('supplier_name','asc')->get();
        $wirehouse = GeneralWirehouse::orderBy('wirehouse_name','asc')->get();
        $gproducts = GeneralProduct::all();
        return view('backend.general_purchase.general_comparisonreportindex', compact('suppliers', 'gproducts', 'wirehouse'));
    }
  	
  	public function comparisonreportview(Request $request)
    {
       // dd($request->all());
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        // dd($fdate, $tdate);


        $products = $request->products_id;
        if ($request->suppliers !== null && $products  == null && $request->factories == null) {
            // dd('Only suppliers Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('supplier_id', $request->suppliers)
                ->get();
        } elseif ($request->suppliers == null && $products  == null && $request->factories !== null) {
            // dd('Only Factories  Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('warehouse_id', $request->factories)
                ->get();
        } elseif ($request->suppliers == null && $products  !== null && $request->factories == null) {
            // dd('Only Product Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('product_id', $products)
                ->get();
        } elseif ($request->suppliers !== null && $products  !== null && $request->factories == null) {
            // dd('Dealer and Product Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('supplier_id', $request->suppliers)
                ->whereIn('product_id', $products)
                ->get();
        } elseif ($request->suppliers == null && $products  !== null && $request->factories !== null) {
            // dd('Factory and Product Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('warehouse_id', $request->factories)
                ->whereIn('product_id', $products)
                ->get();
        } elseif ($request->suppliers !== null && $products  == null && $request->factories !== null) {
            // dd('Factory and Dealer Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('supplier_id', $request->suppliers)
                ->whereIn('warehouse_id', $request->factories)
                ->get();
        } elseif ($request->suppliers !== null && $products  !== null && $request->factories !== null) {
            // dd('Factory and Product and Dealer Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->whereIn('warehouse_id', $request->factories)
                ->whereIn('supplier_id', $request->suppliers)
                ->whereIn('product_id', $products)
                ->get();
        } elseif ($request->suppliers == null && $products  == null && $request->factories == null) {
            // dd('Nothing Fouded');
            $reportdata = DB::table('general_purchases')
                ->select('invoice_no')
                ->groupBy('invoice_no')
                ->whereBetween('date', [$fdate, $tdate])
                ->get();
        }
       return view('backend.general_purchase.general_comparisonreport_view', compact('reportdata', 'products', 'fdate', 'tdate'));
    }
  
  	public function totalstockreportinput()
    {      	
      	$gproducts = GeneralProduct::orderBy('gproduct_name','asc')->get();
      
    	return view('backend.general_purchase.general_total_stock_input',compact('gproducts'));
    }
  	public function totalstockreportview(Request $request)
    {    
      	if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
      	if($request->product_id){
         $gproducts = GeneralProduct::whereIn('id',$request->product_id)->get();
        }else{
         $gproducts = GeneralProduct::all();

        }
      
    	return view('backend.general_purchase.general_total_stock_view',compact('gproducts', 'fdate', 'tdate'));
    }
}
