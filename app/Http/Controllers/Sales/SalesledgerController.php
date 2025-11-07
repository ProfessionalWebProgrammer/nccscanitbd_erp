<?php

namespace App\Http\Controllers\Sales;

use App\Models\Dealer;
use App\Models\SalesLedger;
use App\Models\Factory;
use App\Models\DealerArea;
use App\Models\DealerZone;
use App\Models\DealerSubzone;
use App\Models\SalesProduct;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\SalesCategory;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Auth;

use DataTables;

class SalesledgerController extends Controller
{

    public function index()
    {

        $zones = DealerZone::All();
        $areas = DealerArea::All();
        $dealers = Dealer::All();
        $factory = Factory::all();
        $products = SalesProduct::all();

        $categorys = SalesCategory::orderBy('id', 'desc')->get();

        return view('backend.ledger.sales_ledger_index', compact('products','zones', 'areas', 'dealers', 'factory', 'categorys'));

    }


    public function salesledger(Request $request)
    {

      // dd($request->all());
      //report_id
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
        $stardate = "2023-10-01";
       if($fdate <= '2023-10-01'){
        $preday = "2023-10-01";
        } else {
        $preday = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
        }

       // dd($preday);

        $warehouse_id = $request->warehouse_id;
        $product_id =$request->product_id;

/*
       $dealears = DB::table('dealers as t1')
                ->leftjoin('dealer_zones as t2','t1.dlr_zone_id','=','t2.id')
                ->leftjoin('dealer_areas as t3','t1.dlr_area_id','=','t3.id');

      $dealer_id = array();
        if($request->vendor_id){
            $dealears->wherein('t1.id',$request->vendor_id);
            $dealer_id = $request->vendor_id;
        } else {
        $dealears = $dealears;
        }
         $dlr_zone_id = array();
        if(!empty($request->dlr_zone_id)){
            $dealears->whereIn('t1.dlr_zone_id',$request->dlr_zone_id);
            $dlr_zone_id = $request->dlr_zone_id;
        }


        $dlr_area_id = array();
        if(!empty($request->dlr_area_id)){
            $dealears->whereIn('t1.dlr_area_id',$request->dlr_area_id);
            $dlr_area_id = $request->dlr_area_id;
        }

      	$dealears = $dealears->select('t1.id','t1.d_s_name','dlr_base')->orderBy('t1.d_s_name','asc')->get();
        */


        //  dd($dealears);
        if (isset($request->vendor_id)) {
        $count = count($request->vendor_id);
        if($count == 1){
          $type = 2;
        } else {
          $type = $request->report_id;
        }
        } else {
          $type = $request->report_id;
        }


	if($type != 1) {
    $count = 100;
      $dealears = Dealer::select('id','d_s_name','dlr_base');

      $dealer_id = array();
        if($request->vendor_id){
            $dealears->wherein('id',$request->vendor_id);
            $dealer_id = $request->vendor_id;
            $count = count($request->vendor_id);
        } else {
          $count = 100;
        }

         $dlr_zone_id = array();
        if(!empty($request->dlr_zone_id)){
            $dealears->whereIn('dlr_zone_id',$request->dlr_zone_id);
            $dlr_zone_id = $request->dlr_zone_id;
        }


        $dlr_area_id = array();
        if(!empty($request->dlr_area_id)){
            $dealears->whereIn('dlr_area_id',$request->dlr_area_id);
            $dlr_area_id = $request->dlr_area_id;
        }

        $dealears = $dealears->orderBy('d_s_name','asc')->get();
        $type = '';
       return view('backend.ledger.sales_ledger_new', compact('dealears','preday','fdate','tdate','dealer_id', 'warehouse_id','product_id','type','count'));
        } else {

          $count = 100;
          $dealears = SalesLedger::select('t2.id','t2.d_s_name','t2.dlr_base')
                      ->leftjoin('dealers as t2','vendor_id','=','t2.id');
          $dealer_id = array();
            if($request->vendor_id){
                $dealears->wherein('vendor_id',$request->vendor_id);
                $dealer_id = $request->vendor_id;
                $count = count($request->vendor_id);
            } else {
              $count = 100;
            }

            $dlr_area_id = array();
            if(!empty($request->dlr_area_id)){
                $dealears->whereIn('area_id',$request->dlr_area_id);
                $dlr_area_id = $request->dlr_area_id;

            }


            if(!empty($product_id)){
                $dealears->whereIn('product_id',$product_id);
            }

            $dealears = $dealears->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('vendor_id')->get();

          return view('backend.ledger.sales_ledger_update', compact('dealears','preday','fdate','tdate','dealer_id', 'warehouse_id','product_id','count'));
}
      //cold code
     /*$opdata =  DB::table('sales_ledgers as t1')->select(
            	'vendor_id',
            	DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "2023-07-01" AND "'.$preday.'" THEN `debit` ELSE null END) as debit_a'),
           		DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "2023-07-01" AND "'.$preday.'" THEN `credit` ELSE null END) as credit_a')
      		)->groupBy('vendor_id'); */

         /*$opdata  = SalesLedger::select('vendor_id', DB::raw('sum(debit) as debit_a'),DB::raw('sum(credit) as credit_a'))->whereBetween('ledger_date' ,[$stardate,$preday])->groupBy('vendor_id')->get();

        $ledgers = DB::table('sales_ledgers as t1')
                ->leftjoin('dealers as t2','t1.vendor_id','=','t2.id')
                ->leftjoin('dealer_zones as t3','t2.dlr_zone_id','=','t3.id')
                ->leftjoin('dealer_areas as t4','t2.dlr_area_id','=','t4.id');
                // ->whereBetween('ledger_date', array($fdate, $tdate));

        $dealer_id = array();
        if($request->vendor_id){
            $ledgers->wherein('t1.vendor_id',$request->vendor_id);
            $dealer_id = $request->vendor_id;
        }
         $dlr_zone_id = array();
        if(!empty($request->dlr_zone_id)){
            $ledgers->whereIn('t2.dlr_zone_id',$request->dlr_zone_id);
            $dlr_zone_id = $request->dlr_zone_id;
        }
      $usercheck = Employee::where('user_id',Auth::id())->first();

       if($usercheck != null){
            $ledgers->where('t2.dlr_zone_id',$usercheck->emp_zone);
            $dlr_zone_id = $usercheck->emp_zone;
        }

      //dd($usercheck);

        $dlr_area_id = array();
        if(!empty($request->dlr_area_id)){
            $ledgers->whereIn('t2.dlr_area_id',$request->dlr_area_id);
            $dlr_area_id = $request->dlr_area_id;
        }
        $ledgers = $ledgers->select('t2.d_s_name','t2.dlr_base','t2.dlr_address','t2.dlr_mail','t2.dlr_mobile_no','t2.id as dealer_id','t3.zone_title','t4.area_title','t9.debit_a','t9.credit_a')
                  ->whereBetween('ledger_date' ,[$fdate,$tdate])
                  ->whereNotNull('t2.id')
                  ->groupby('t2.id')->orderBy('zone_title','asc')->orderBy('d_s_name','asc')
                    ->leftJoinSub($opdata, 't9', function ($join) {
                          $join->on('vendor_id', '=', 't9.vendor_id');
                      })
                    ->get();
      //dd($ledgers);
     $count = count($ledgers);
      //dd($count);
      //ectra code  start
      foreach($ledgers as $data){

      if($count >59){
      $dealerAll = 1;
      }
      else {
      $dealerAll = 0;
      }
      }

      //extra code end

       $dataall = array();


        foreach($ledgers as $key=>$data){

           	$ledgerdata = DB::table('sales_ledgers')->whereBetween('ledger_date', [$fdate, $tdate])
                                        ->where('vendor_id', $data->dealer_id);
                                    //  dd($request->warehouse_id);
                                    if (isset($warehouse_id)) {
                                        $ledgerdata->where('warehouse_bank_id', $warehouse_id);
                                    }

                                    if (isset($product_id)) {
                                        $ledgerdata->where('product_id', $product_id);
                                    }
                                    $ledgerdata = $ledgerdata->orderBy('ledger_date', 'ASC')
                                       ->orderBy('id', 'ASC')
                          				->orderBy('invoice', 'ASC')
                                     // ->orderBy('created_at', 'ASC')

                                        ->get();

          $ledgers[$key]->data = $ledgerdata;
        }


       //  dd($ledgers);


       $salesunit =  DB::table('sales_ledgers as t1')->select(
           DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "'.$fdate.'"  AND "'.$tdate.'" THEN `qty_kg` ELSE null END) as sales_kg'),
           DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "'.$fdate.'"  AND "'.$tdate.'" THEN `discount_amount` ELSE null END) as discount_amount'),
           DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "'.$fdate.'"  AND "'.$tdate.'" THEN `free` ELSE null END) as free')
           ) ->leftjoin('dealers as t2','t1.vendor_id','=','t2.id')
                ->leftjoin('dealer_zones as t3','t2.dlr_zone_id','=','t3.id')
                ->leftjoin('dealer_areas as t4','t2.dlr_area_id','=','t4.id');

          if($request->vendor_id){
            $salesunit->wherein('t1.vendor_id',$request->vendor_id);
        }
         $dlr_zone_id = array();
        if(!empty($request->dlr_zone_id)){
            $salesunit->whereIn('t2.dlr_zone_id',$request->dlr_zone_id);
         }

       if($usercheck != null){
            $salesunit->where('t2.dlr_zone_id',$usercheck->emp_zone);
        }

        $dlr_area_id = array();
        if(!empty($request->dlr_area_id)){
            $salesunit->whereIn('t2.dlr_area_id',$request->dlr_area_id);
         }

    	$salesunit = $salesunit->first();
         //dd($ledgers);

        return view('backend.ledger.sales_ledger', compact('ledgers','preday','fdate','tdate','dealer_id','dlr_zone_id','count', 'dlr_area_id', 'warehouse_id','product_id','salesunit'));
        }
        */
    }


public function salesLedgerReport($fdate, $tdate){
      $fdate = date('Y-m-d',  strtotime($fdate));
      //$fdate = "2023-10-01";
      $tdate = date('Y-m-d',  strtotime($tdate));

      $stardate = "2023-10-01";
     if($fdate <= '2023-10-01'){
      $preday = "2023-10-01";
      } else {
      $preday = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
      }
      $dealears = Dealer::select('id','d_s_name','dlr_base')->orderBy('d_s_name','asc')->get();
      $type = 'TB';
       return view('backend.ledger.salesLedgerReportView', compact('dealears','preday','fdate','tdate','type'));
       //return view('backend.ledger.sales_ledger_new', compact('dealears','preday','fdate','tdate','dealer_id', 'warehouse_id','product_id'));
    }
    public function salesLedgerFGReport($fdate, $tdate){
      $fdate = date('Y-m-d',  strtotime($fdate));
    //  $fdate = "2023-10-01";
      $tdate = date('Y-m-d',  strtotime($tdate));

      if($fdate <= '2023-10-01'){
       $preday = "2023-09-30";
       } else {
       $preday = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
       }

      $dealears = Dealer::select('id','d_s_name','dlr_base')->orderBy('d_s_name','asc')->get();

       return view('backend.ledger.salesLedgerFGReportView', compact('dealears','fdate','tdate','preday'));
       //return view('backend.ledger.sales_ledger_new', compact('dealears','preday','fdate','tdate','dealer_id', 'warehouse_id','product_id'));
    }
    public function salesLedgerReturnReport($fdate, $tdate){
      $fdate = date('Y-m-d',  strtotime($fdate));
      //$fdate = "2023-10-01";
      $tdate = date('Y-m-d',  strtotime($tdate));
      if($fdate <= '2023-10-01'){
       $preday = "2023-09-30";
       } else {
       $preday = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
       }
      $dealears = Dealer::select('id','d_s_name','dlr_base')->orderBy('d_s_name','asc')->get();
       return view('backend.ledger.salesLedgerReturnReportView', compact('dealears','fdate','tdate','preday'));
    }

    public function salesIndex(){
      $zones = DealerZone::All();
      $regions = DealerSubzone::All();
      $areas = DealerArea::All();
      $dealers = Dealer::All();
      $products = SalesProduct::all();
    //  $factory = Factory::all();


    //  $categorys = SalesCategory::orderBy('id', 'desc')->get();

      return view('backend.ledger.report.index', compact('products','zones','regions','areas', 'dealers'));
    }

    public function salesReport(Request $request){
    //dd($request->all());
  if (isset($request->date)) {
      $dates = explode(' - ', $request->date);
      $fdate = date('Y-m-d', strtotime($dates[0]));
      $tdate = date('Y-m-d', strtotime($dates[1]));
  }
  $sdate = '2023-10-01';
  if($fdate <= '2023-10-01'){
    $sdate = '2023-09-30';
    $pdate = '2023-09-30';
  } else {
    $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
  }
  //dd($pdate);
$region_id = array();
$area_id = array();
$dealer_id = array();
$product_id = array();
  if(!empty($request->dlr_zone_id)){
    $zones = SalesLedger::select('zone_id as id','t3.zone_title as name')
                ->leftjoin('dealer_zones as t3','zone_id','=','t3.id')
                ->whereIn('zone_id',$request->dlr_zone_id)->whereNotNull('sales_ledgers.zone_id')
                ->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('zone_id')->get();
   return view('backend.ledger.report.sales_report_zone', compact('zones','fdate','tdate','sdate','pdate'));
 }elseif($request->dlr_region_id){
   $zones = SalesLedger::select('sales_ledgers.zone_id as id','t2.zone_title')
               ->leftjoin('dealer_zones as t2','sales_ledgers.zone_id','=','t2.id')
               ->leftjoin('dealer_subzones as t3','region_id','=','t3.id')
               ->whereIn('region_id',$request->dlr_region_id)->whereNotNull('sales_ledgers.zone_id')
               ->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('sales_ledgers.zone_id')->get();
               $region_id = $request->dlr_region_id;
  return view('backend.ledger.report.sales_report_region', compact('zones','region_id','fdate','tdate','sdate','pdate'));
}elseif($request->dlr_area_id){
    $zones = SalesLedger::select('sales_ledgers.zone_id as id','t2.zone_title')
                ->leftjoin('dealer_zones as t2','sales_ledgers.zone_id','=','t2.id')
                ->leftjoin('dealer_subzones as t3','region_id','=','t3.id')
                ->whereIn('area_id',$request->dlr_area_id)->whereNotNull('sales_ledgers.zone_id')
                ->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('sales_ledgers.zone_id')->get();
                $area_id = $request->dlr_area_id;
   return view('backend.ledger.report.sales_report_area', compact('zones','area_id','fdate','tdate','sdate','pdate'));
 }elseif($request->vendor_id){
   $zones = SalesLedger::select('sales_ledgers.zone_id as id','t2.zone_title')
               ->leftjoin('dealer_zones as t2','sales_ledgers.zone_id','=','t2.id')
               ->leftjoin('dealer_subzones as t3','region_id','=','t3.id')
               ->whereIn('vendor_id',$request->vendor_id)->whereNotNull('sales_ledgers.zone_id')
               ->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('sales_ledgers.zone_id')->get();
               $dealer_id = $request->vendor_id;

  return view('backend.ledger.report.sales_report_dealer', compact('zones','dealer_id','fdate','tdate'));
}elseif($request->product_id){
  $zones = SalesLedger::select('sales_ledgers.zone_id as id','t2.zone_title')
              ->leftjoin('dealer_zones as t2','sales_ledgers.zone_id','=','t2.id')
              ->leftjoin('dealer_subzones as t3','region_id','=','t3.id')
              ->whereIn('product_id',$request->product_id)->whereNotNull('sales_ledgers.zone_id')
              ->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('sales_ledgers.zone_id')->get();
              $product_id = $request->product_id;
 return view('backend.ledger.report.sales_report_product', compact('zones','product_id','fdate','tdate'));
} else {
  return redirect()->route('all.sales.report.index')->with('warning','Please select Zone!');
}
  }


/*
  public function salesReport(Request $request){
  //  dd($request->all());
  if (isset($request->date)) {
      $dates = explode(' - ', $request->date);
      $fdate = date('Y-m-d', strtotime($dates[0]));
      $tdate = date('Y-m-d', strtotime($dates[1]));
  }
  $stardate = "2023-10-01";
 if($fdate <= '2023-10-01'){
  $preday = "2023-10-01";
  } else {
  $preday = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
  }
 // dd($preday);

  $warehouse_id = 35;
  $product_id =$request->product_id;

  $dealears = SalesLedger::select('t2.id','t2.d_s_name','t2.dlr_base')
              ->leftjoin('dealers as t2','vendor_id','=','t2.id');
  $dealer_id = array();
    if($request->vendor_id){
        $dealears->wherein('vendor_id',$request->vendor_id);
        $dealer_id = $request->vendor_id;
    }



    $dlr_area_id = array();
    if(!empty($request->dlr_area_id)){
        $dealears->whereIn(t2.'dlr_area_id',$request->dlr_area_id);
        $dlr_area_id = $request->dlr_area_id;
    }

    $dlr_zone_id = array();
   if(!empty($request->dlr_zone_id)){
       $dealears->whereIn('t2.dlr_zone_id',$request->dlr_zone_id);
       $dlr_zone_id = $request->dlr_zone_id;
   }

    if(!empty($product_id)){
        $dealears->whereIn('product_id',$product_id);
    }

    $dealears = $dealears->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('vendor_id')->get();

     return view('backend.ledger.report.sales_report', compact('dealears','preday','fdate','tdate','dealer_id', 'warehouse_id','product_id'));

  }

  */

    public function indextotal()
    {

        $zones = DealerZone::All();
        $areas = DealerArea::All();
        $dealers = Dealer::All();
        $factory = Factory::all();
        $products = SalesProduct::all();

        $categorys = SalesCategory::orderBy('id', 'desc')->get();

        return view('backend.ledger.total_sales_ledger_index', compact('products','zones', 'areas', 'dealers', 'factory', 'categorys'));

    }


    public function salesledgertotal(Request $request)
    {

        //dd($request->all());

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
       $stardate = "2021-01-01";
        $preday = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));


        $wid = $request->warehouse_id;
        $pid=$request->product_id;

            $vid = $request->vendor_id;

            $zid = $request->dlr_zone_id;

             $usercheck = Employee::where('user_id',Auth::id())->first();

           if($usercheck != null){
                $ezid = $usercheck->emp_zone;
            }else{
           $ezid = '';
           }

            $aid = $request->dlr_area_id;




       $salesunit =  DB::table('sales_ledgers as t1')->select(
          DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "'.$fdate.'"  AND "'.$tdate.'" THEN `qty_kg` ELSE null END) as sales_kg'),
           DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "'.$fdate.'"  AND "'.$tdate.'" THEN `qty_pcs` ELSE null END) as qty_pcs'),
           DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "'.$fdate.'"  AND "'.$tdate.'" THEN `discount_amount` ELSE null END) as discount_amount'),
           DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "'.$fdate.'"  AND "'.$tdate.'" THEN `free` ELSE null END) as free'),
           DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "'.$fdate.'"  AND "'.$tdate.'" THEN `total_price` ELSE null END) as total_price'),
           DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "'.$fdate.'"  AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
           DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "'.$fdate.'"  AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
           ) ->leftjoin('dealers as t2','t1.vendor_id','=','t2.id')
                ->leftjoin('dealer_zones as t3','t2.dlr_zone_id','=','t3.id')
                ->leftjoin('dealer_areas as t4','t2.dlr_area_id','=','t4.id')
      			->whereNotNull('t2.id');

          if($request->vendor_id){
            $salesunit->wherein('t1.vendor_id',$request->vendor_id);
        }
         $dlr_zone_id = array();
        if(!empty($request->dlr_zone_id)){
            $salesunit->whereIn('t2.dlr_zone_id',$request->dlr_zone_id);
         }

       if($usercheck != null){
            $salesunit->where('t2.dlr_zone_id',$usercheck->emp_zone);
        }

        $dlr_area_id = array();
        if(!empty($request->dlr_area_id)){
            $salesunit->whereIn('t2.dlr_area_id',$request->dlr_area_id);
         }

    $salesunit = $salesunit->first();
      //dd($salesunit);






        return view('backend.ledger.total_sales_ledger', compact('preday','fdate','tdate','zid', 'aid', 'wid','pid','ezid','vid','salesunit'));

    }


  public function gettotalsalesdata(Request $request)
    {

        //dd($request->all());

            $fdate =$request->fdate;
            $tdate = $request->tdate;
        $stardate = "2021-01-01";
        $preday = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
       // dd($preday);

      $opdata =  DB::table('sales_ledgers as t1')->select(
            'vendor_id',
            DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "2021-01-01" AND "'.$preday.'" THEN `debit` ELSE null END) as debit_a'),
           DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "2021-01-01" AND "'.$preday.'" THEN `credit` ELSE null END) as credit_a')
      )->groupBy('vendor_id');



        $warehouse_id = $request->warehouse_id;
        $product_id =$request->product_id;

        $ledgers = DB::table('sales_ledgers as t1')
                ->leftjoin('dealers as t2','t1.vendor_id','=','t2.id')
                ->leftjoin('dealer_zones as t3','t2.dlr_zone_id','=','t3.id')
                ->leftjoin('dealer_areas as t4','t2.dlr_area_id','=','t4.id');
                // ->whereBetween('ledger_date', array($fdate, $tdate));
        $dealer_id = array();
        if($request->vendor_id){
            $ledgers->wherein('t1.vendor_id',$request->vendor_id);
            $dealer_id = $request->vendor_id;
        }
         $dlr_zone_id = array();
        if(!empty($request->dlr_zone_id)){
            $ledgers->whereIn('t2.dlr_zone_id',$request->dlr_zone_id);
            $dlr_zone_id = $request->dlr_zone_id;
        }
      $usercheck = Employee::where('user_id',Auth::id())->first();

       if($usercheck != null){
            $ledgers->where('t2.dlr_zone_id',$usercheck->emp_zone);
            $dlr_zone_id = $usercheck->emp_zone;
        }

      //dd($usercheck);

        $dlr_area_id = array();
        if(!empty($request->dlr_area_id)){
            $ledgers->whereIn('t2.dlr_area_id',$request->dlr_area_id);
            $dlr_area_id = $request->dlr_area_id;
        }
        $ledgers = $ledgers->select('t2.d_s_name','t2.dlr_base','t2.dlr_address','t2.dlr_mail','t2.dlr_mobile_no','t2.id as dealer_id','t3.zone_title','t4.area_title','t9.debit_a','t9.credit_a')
        ->whereBetween('ledger_date' ,[$fdate,$tdate])
        ->whereNotNull('t2.id')
        ->groupby('t2.id')->orderBy('zone_title','asc')->orderBy('d_s_name','asc')
          ->leftJoinSub($opdata, 't9', function ($join) {
                $join->on('t1.vendor_id', '=', 't9.vendor_id');
            })
          ->get();

      $count = count($ledgers);



     return Datatables::of($ledgers)
            ->addIndexColumn()


            ->make(true);





    }


   public function gettotalsalesvendordata(Request $request)
    {

       // dd($request->all());

            $fdate =$request->fdate;
            $tdate = $request->tdate;
        $stardate = "2021-01-01";
        $preday = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

        $warehouse_id = $request->warehouse_id;
        $product_id =$request->product_id;
     $vendorid = $request->vendor_id;







           					$ledgerdata = DB::table('sales_ledgers')->whereBetween('ledger_date', [$fdate, $tdate])
                                        ->where('vendor_id', $vendorid);
                                    //  dd($request->warehouse_id);
                                    if (isset($warehouse_id)) {
                                        $ledgerdata->where('warehouse_bank_id', $warehouse_id);
                                    }

                                    if (isset($product_id)) {
                                        $ledgerdata->where('product_id', $product_id);
                                    }
                                    $ledgerdata = $ledgerdata->orderBy('ledger_date', 'ASC')


                                       ->orderBy('id', 'ASC')
                          				->orderBy('invoice', 'ASC')
                                     // ->orderBy('created_at', 'ASC')

                                        ->get();


      return Datatables::of($ledgerdata)
            ->addIndexColumn()

            ->make(true);


    }






}
