<?php

namespace App\Http\Controllers\Report;

use App\Models\Factory;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\JournalEntry;
use App\Models\Dealer;
use App\Models\SalesProduct;
use App\Models\SalesStockIn;
use App\Models\RawMaterialStockOut;
use App\Models\PackingStockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RowMaterialsProduct;
use App\Http\Controllers\Controller;

class OtherReportController extends Controller
{
    public function cogsreport()
    {
        // $date = date('Y-m-d', strtotime(' -1 days'));
        // dd($date);
        $factories = Factory::all();
        $rawmeterial = RowMaterialsProduct::all();
        return view('backend.purchase_report.cogs_report', compact('rawmeterial', 'factories'));
    }
    public function cogsreportview(Request $request)
    {
        $product = $request->products;
        $wirehouse = $request->factory_id;
        $date = $request->date;
        $dir_labor =  $request->dir_labor;
        $ind_labor =  $request->ind_labor;


        $pdate =  date('Y-m-d', strtotime('-1 day', strtotime($date)));
        $sdate = Purchase::orderBy('date', 'asc')->first()->date;

        $opening_balanceppp = RowMaterialsProduct::where('id', $product)->value('opening_balance');

        $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            where purchase_set_opening_balance.product_id="' . $product . '" and purchase_set_opening_balance.wirehouse_id ="' . $wirehouse . '"  and  purchase_set_opening_balance.date between "' . $sdate . '" and "' . $date . '" ');


        $stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product . '" and purchases.wirehouse_id ="' . $wirehouse . '"  and  purchases.date = "' . $date . '" ');

        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            where purchases.product_id="' . $product . '" and purchases.wirehouse_id ="' . $wirehouse . '"  and  purchases.date between "' . $sdate . '" and "' . $pdate . '" ');

        $return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product . '" and purchase_returns.wirehouse_id ="' . $wirehouse . '" 
             and purchase_returns.date = "' . $date . '"');
        $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             WHERE purchase_returns.product_id="' . $product . '" and purchase_returns.wirehouse_id ="' . $wirehouse . '" 
             and purchase_returns.date between "' . $sdate . '" and "' . $pdate . '"');

        $transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.to_wirehouse_id ="' . $wirehouse . '" and purchase_transfers.product_id="' . $product . '"  and purchase_transfers.date = "' . $date . '"');
        $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.to_wirehouse_id ="' . $wirehouse . '" and purchase_transfers.product_id="' . $product . '"  and purchase_transfers.date BETWEEN "' . $sdate . '" and "' . $pdate . '"');

        $transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.from_wirehouse_id ="' . $wirehouse . '" and purchase_transfers.product_id="' . $product . '"  and purchase_transfers.date = "' . $date . '"');
        $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.from_wirehouse_id ="' . $wirehouse . '" and purchase_transfers.product_id="' . $product . '"  and purchase_transfers.date BETWEEN "' . $sdate . '" and "' . $pdate . '"');

        $stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product . '" AND purchase_stockouts.wirehouse_id ="' . $wirehouse . '" and purchase_stockouts.date = "' . $date . '"');
        $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="' . $product . '" AND purchase_stockouts.wirehouse_id ="' . $wirehouse . '" and purchase_stockouts.date BETWEEN "' . $sdate . '" and "' . $pdate . '"');

        $openingbalance =  $opening_balanceppp+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;

        $clsingbalance = $openingbalance + $stocktotal[0]->srcv - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout;

        $todaypurchase = $stocktotal[0]->srcv;


        $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
        WHERE purchases.product_id ="'.$product.'" and purchases.date between "'.$sdate.'" and "'.$date.'"');
      
      $openingbalance = $openingbalance*$avgrate[0]->rate;
      $clsingbalance =$clsingbalance*$avgrate[0]->rate;
      $todaypurchase = $todaypurchase*$avgrate[0]->rate;

        $productname = RowMaterialsProduct::where('id', $product)->value('product_name');
        $factories = Factory::where('id', $wirehouse)->value('factory_name');
        return view('backend.purchase_report.cogs_report_view', compact('openingbalance', 'todaypurchase', 'clsingbalance', 'productname', 'factories', 'date', 'dir_labor', 'ind_labor'));
    }



    public function salescogsreport()
    {
        // $date = date('Y-m-d', strtotime(' -1 days'));
        // dd($date);
        /*  $factories = Factory::all();
        $salesproduct = SalesProduct::all();
        return view('backend.sales_report.cogs_report', compact('salesproduct', 'factories')); */
        return view('backend.sales_report.cogs_report');
    }
    
    public function salesAllCogsReportView(Request $request){

      if (isset($request->date)) {
         $dates = explode(' - ', $request->date);
         $fdate = date('Y-m-d', strtotime($dates[0]));
         $tdate = date('Y-m-d', strtotime($dates[1]));
       }
       $allRawProducts = RawMaterialStockOut::where('status',1)->whereBetween('date',[$fdate,$tdate])->get();
       $allFgProducts = RawMaterialStockOut::where('status',2)->whereBetween('date',[$fdate,$tdate])->get();
       $allPackingProducts = PackingStockOut::where('status',1)->whereBetween('date',[$fdate,$tdate])->get();
       return view('backend.sales_report.cogsReportView', compact('allRawProducts','allFgProducts','allPackingProducts','fdate','tdate'));
    }
    
    public function salescogsreportview(Request $request)
    {
    //    dd($request->all());
        $product = $request->products;
       // $wirehouse = $request->factory_id;
        //$date = $request->date;
        // $dir_labor =  $request->dir_labor;
        // $ind_labor =  $request->ind_labor;


         if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        // $pdate =  date('Y-m-d', strtotime('-1 day', strtotime($date)));
        // $sdate = SalesStockIn::orderBy('date', 'asc')->first()->date;

       


        $startdate = '2021-01-01';
        $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
          
        // Dont't  

    //     $todaystock = \App\Models\SalesStockIn::where('prouct_id',$product)->where('factory_id',$wirehouse)->where('date',$date)->sum('quantity');
    //     $openingstock = \App\Models\SalesStockIn::where('prouct_id',$product)->where('factory_id',$wirehouse)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');
      
    //     $sales = \App\Models\SalesLedger::where('product_id',$product)->where('warehouse_bank_id',$wirehouse)->where('ledger_date',$date)->sum('qty_pcs');
    //     $opsales = \App\Models\SalesLedger::where('product_id',$product)->where('warehouse_bank_id',$wirehouse)->whereBetween('ledger_date',[$startdate,$fdate2])->sum('qty_pcs');
 
 
    //     //   $returnp = \App\Models\ReturnItem::where('product_id',$product)->whereBetween('created_at',$date)->sum('qty');
    //   //  $opreturnp = \App\Models\ReturnItem::where('product_id',$product)->whereBetween('created_at',[$startdate,$fdate2])->sum('qty');
    //   $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('warehouse_id',$wirehouse)->where('product_id',$product)->where('date',$date)->sum('qty');
    //      $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('warehouse_id',$wirehouse)->where('product_id',$product)->whereBetween('date',[$startdate,$fdate2])->sum('qty');
     
       
     
    //     $transfer_from = \App\Models\Transfer::where('product_id',$product)->where('from_wirehouse',$wirehouse)->where('date',$date)->sum('qty');
    //     $optransfer_from = \App\Models\Transfer::where('product_id',$product)->where('from_wirehouse',$wirehouse)->whereBetween('date',[$startdate,$fdate2])->sum('qty');
        
    //     $transfer_to = \App\Models\Transfer::where('product_id',$product)->where('to_wirehouse',$wirehouse)->where('date',$date)->sum('qty');
    //     $optransfer_to = \App\Models\Transfer::where('product_id',$product)->where('to_wirehouse',$wirehouse)->whereBetween('date',[$startdate,$fdate2])->sum('qty');
        
    //      $damage = \App\Models\SalesDamage::where('product_id',$product)->where('warehouse_id',$wirehouse)->where('date',$date)->sum('quantity');
    //     $opdamage = \App\Models\SalesDamage::where('product_id',$product)->where('warehouse_id',$wirehouse)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');
        


        $todaystock = \App\Models\SalesStockIn::where('prouct_id',$product)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
        $openingstock = \App\Models\SalesStockIn::where('prouct_id',$product)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');
      
        $sales = \App\Models\SalesLedger::where('product_id',$product)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');
        $opsales = \App\Models\SalesLedger::where('product_id',$product)->whereBetween('ledger_date',[$startdate,$fdate2])->sum('qty_pcs');
 
 
       $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product)->whereBetween('date',[$fdate,$tdate])->sum('qty');
         $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_return_items.id', '=', 'sales_return_items.return_id')->where('product_id',$product)->whereBetween('date',[$startdate,$fdate2])->sum('qty');
     
       
     
        $transfer_from = \App\Models\Transfer::where('product_id',$product)->whereBetween('date',[$fdate,$tdate])->sum('qty');
        $optransfer_from = \App\Models\Transfer::where('product_id',$product)->whereBetween('date',[$startdate,$fdate2])->sum('qty');
        
        $transfer_to = \App\Models\Transfer::where('product_id',$product)->whereBetween('date',[$fdate,$tdate])->sum('qty');
        $optransfer_to = \App\Models\Transfer::where('product_id',$product)->whereBetween('date',[$startdate,$fdate2])->sum('qty');
        
         $damage = \App\Models\SalesDamage::where('product_id',$product)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
        $opdamage = \App\Models\SalesDamage::where('product_id',$product)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');
        
        $product_name = \App\Models\SalesProduct::where('id',$product)->value('product_name');
        
        $productdetails = SalesProduct::where('id',$product)->first();

        
        $opblnce = ($productdetails->opening_balance+$openingstock+$optransfer_to)-($opsales+$optransfer_from+$opdamage);
        $clb = ($opblnce+$todaystock+$transfer_to)- ($sales+$transfer_from+$damage);
        
        $productrate = \App\Models\SalesStockIn::where('prouct_id',$product)->avg('production_rate');

      $openingbalance = $opblnce*$productrate;
      $clsingbalance =$clb*$productrate;
      $todaystock = $todaystock*$productrate;

   // dd($opsales);

        $productname = SalesProduct::where('id', $product)->value('product_name');
   //  $factories = Factory::where('id', $wirehouse)->value('factory_name');
        $factories = Factory::all();


          $dir_labordata=  DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost FROM `direct_labour_costs`
            WHERE  direct_labour_costs.fg_id ="'.$product.'" AND  direct_labour_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');
                
        $ind_labordate =   DB::select('SELECT SUM(indirect_costs.total_cost) as ilcost FROM `indirect_costs`
        WHERE  indirect_costs.fg_id ="'.$product.'" AND  indirect_costs.date BETWEEN "'.$startdate.'" and "'.$tdate.'"');
            

        $dir_labor =  $dir_labordata[0]->dlcost;
        $ind_labor =  $ind_labordate[0]->ilcost;

        return view('backend.sales_report.cogs_report_view', compact('openingbalance', 'todaystock', 'clsingbalance', 'productname', 'factories', 'fdate','tdate', 'dir_labor', 'ind_labor'));
    }
  
  
  public function journalReportindex()
    {

        $vendors = Dealer::all();
        $supplier = Supplier::all();

      //  dd($groups);
        return view('backend.account.journal_report_index', compact('vendors', 'supplier'));
    }


    public function journalReport(Request $request)
    {
       //   dd($request->all());

        $date = $request->date;

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
      
      
       $data = JournalEntry::select('journal_entries.*', 'suppliers.supplier_name', 'dealers.d_s_name', 'others_types.name as ohters_name')
            ->leftjoin('suppliers', 'suppliers.id', 'journal_entries.supplier_id')
            ->leftjoin('dealers', 'dealers.id', 'journal_entries.vendor_id')
            ->leftjoin('others_types', 'others_types.id', 'journal_entries.others_id')
         	->whereBetween('date',[$fdate,$tdate]);
      
      
$vendors = '';
$supplier = '';
      		if($request->vendor_id){
        $vendors = Dealer::whereIn('id',$request->vendor_id)->get();
               $data =  $data->whereIn('vendor_id',$request->vendor_id);
        }
 		 if($request->supplier_id){
         $supplier = Supplier::whereIn('id',$request->supplier_id)->get();
            $data =  $data->whereIn('supplier_id',$request->supplier_id);
         }

          $data =  $data->orderBy('date','desc')
            ->orderBy('id','desc')
            ->get();
//dd($data);

         return view('backend.account.journal_report', compact('fdate', 'tdate','vendors', 'supplier','data'));
    }



}
