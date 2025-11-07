<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use DataTables;

use App\Models\Dealer;
use App\Models\Factory;
use App\Models\Employee;
use App\Models\DealerArea;
use App\Models\DealerType;
use App\Models\DealerZone;
use App\Models\SalesStockIn;
use App\Models\SalesLedger;
use App\Models\SalesOrderItem;
use App\Models\SalesOrder;
use App\Models\DealerDelete;
use App\Models\ExpanseGroup;
use App\Models\DealerSubzone;
use App\Models\SalesCategory;
use App\Models\TransportCost;
use App\Models\ExpanseSubgroup;
use App\Models\YearlyIncentive;
use App\Models\CommissionIn;
use App\Models\JournalEntry;
use App\Models\Transfer;
use App\Models\SalesProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\RawMaterialStockOut;
use App\Models\PackingStockOut;
use App\Models\PurchaseStockout;
use App\Models\Account\ChartOfAccounts;

use App\Traits\AccountInfoAdd;
use App\Traits\TrailBalance;
use App\Traits\ChartOfAccount;

class SalesReportController extends Controller
{
    use AccountInfoAdd;
  use TrailBalance;
  use ChartOfAccount;
  
    public function dailysalesReportIndex()
    {
        $zones = DealerZone::All();
        $areas = DealerArea::All();
        $dealers = Dealer::All();
        $factory = Factory::all();

        $categorys = SalesCategory::orderBy('id', 'desc')->get();

        return view('backend.sales_report.daily_sales_report_index', compact('zones', 'areas', 'dealers', 'factory', 'categorys'));
    }

    public function dailysalesReport(Request $request)
    {
	//dd($request->all());
        $date = $request->date;

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }


		$vid = $request->vendor_id;
		$aid = $request->dlr_area_id;
		$zid = $request->dlr_zone_id;


        return view('backend.sales_report.daily_sales_report', compact('fdate', 'tdate', 'date','vid','aid','zid'));
    }



    public function getdailysalesReportdata(Request $request)
    {

        //dd($request->all());
        if ($request->fdate &&  $request->tdate) {
            $fdate = $request->fdate;
            $tdate = $request->tdate;
        }

        //dd($tdate);

        $saleData = DB::table('sales_ledgers as t1')
            // ->leftjoin('sales as t1','t1.id','t5.sale_id')
            ->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id')
            ->leftjoin('dealer_areas as t6', 't2.dlr_area_id', '=', 't6.id')
            ->leftjoin('dealer_zones as t7', 't2.dlr_zone_id', '=', 't7.id')
            ->leftjoin('factories as t3', 't1.warehouse_bank_id', '=', 't3.id')
            ->whereNotNull('t1.product_id')
            ->whereNotNull('t2.d_s_name')
            ->orderBy('t2.d_s_name', 'asc')
            ->orderBy('t3.factory_name', 'asc')
            ->orderBy('t1.invoice', 'desc')
            ->orderBy('t1.product_name', 'asc');
        if ($fdate &&  $tdate) {
            $saleData =  $saleData->whereBetween('t1.ledger_date', [$fdate, $tdate]);
        }

         if (isset($request->vid)) {
            // $vendorid = explode('_', $request->vendor_id);
             $vendorid = $request->vid;
             $saleData = $saleData->where('t1.vendor_id', $vendorid);
         }
        // if (isset($request->product_id)) {
        //     $product_id = explode('_', $request->product_id);
        //     $saleData = $saleData->whereIn('t1.product_id', $product_id);
        // }
        // if (isset($request->warehouse_id)) {

        //     $saleData = $saleData->where('t1.warehouse_bank_id', $request->warehouse_id);
        // }
        // if (isset($request->dlr_zone_id)) {

        //     $saleData = $saleData->where('t2.dlr_zone_id', $request->dlr_zone_id);
        // }

         if (isset($request->aid)) {
            $dlr_area_id = explode('_', $request->aid);
             $saleData = $saleData->whereIn('t1.area_id', $dlr_area_id);
         }

        $saleData = $saleData->select('t1.ledger_date as date', 't1.invoice as invoice_no', 't1.product_name', 't1.qty_kg', 't1.qty_pcs as qty', 't1.unit_price', 't1.total_price', 't2.d_s_name as dealer_name', 't6.area_title as area', 't7.zone_title as zone', 't6.area_title as area', 't3.factory_name as factory_name')
            ->orderBy('t1.id', 'DESC')

            ->get();


        return Datatables::of($saleData)
            ->addIndexColumn()
            ->addColumn('qty_ton', function ($sales) {
                return ($sales->qty_kg) / 1000;
            })
            ->make(true);
    }

	public function dailySalesOrderReportIndex(){
    	 $zones = DealerZone::All();
         $areas = DealerArea::All();
         $dealers = Dealer::All();
        return view('backend.sales_report.dailySalesOrderReportIndex', compact('zones', 'areas', 'dealers'));
    }
	public function dailySalesOrderReport(Request $request){
      //dd($request->all());
       $date = $request->date;
    if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }


		$vid = $request->vendor_id;
		$aid = $request->dlr_area_id;
		$zid = $request->dlr_zone_id;

        return view('backend.sales_report.dailySalesOrderReportView', compact('date','fdate', 'tdate','vid','aid','zid'));
    }

  	 public function getdailySalesOrderReportdata(Request $request)
    {

       // dd($request->all());
        if ($request->fdate &&  $request->tdate) {
            $fdate = $request->fdate;
            $tdate = $request->tdate;
        }

        //dd($tdate);

        $saleData = DB::table('sales_order_items as t1')
            ->leftjoin('dealers as t2', 't1.dealer_id', '=', 't2.id')
            ->leftjoin('dealer_areas as t6', 't1.area_id', '=', 't6.id')
            ->whereNotNull('t1.product_id')
            ->whereNotNull('t2.d_s_name')
            ->orderBy('t2.d_s_name', 'asc')
            ->orderBy('t1.invoice_no', 'desc')
            ->orderBy('t1.product_name', 'asc');
        if ($fdate &&  $tdate) {
            $saleData =  $saleData->whereBetween('t1.date', [$fdate, $tdate]);
        }

         if (isset($request->vid)) {
            // $vendorid = explode('_', $request->vendor_id);
             $vendorid = $request->vid;
             $saleData = $saleData->where('t1.dealer_id', $vendorid);
         }


         if (isset($request->aid)) {
            //$dlr_area_id = explode('_', $request->aid);
           	$dlr_area_id = $request->aid;
             $saleData = $saleData->whereIn('t1.area_id', $dlr_area_id);
         }

        $saleData = $saleData->select('t1.date as date', 't1.invoice_no', 't1.product_name', 't1.qty', 't1.product_weight', 't1.unit_price', 't1.total_price', 't2.d_s_name as dealer_name', 't6.area_title as area')
            ->orderBy('t1.id', 'DESC')->get();


        return Datatables::of($saleData)
            ->addIndexColumn()
            ->addColumn('qty_ton', function ($sales) {
                return ($sales->qty*$sales->product_weight) / 1000;
            })
            ->make(true);
    }


    public function monthlysSSReportIndex()
    {
        $zones = DealerZone::All();
        $areas = DealerArea::All();
        $dealers = Dealer::All();
        $factory = Factory::all();

        //dd($areas);


        return view('backend.sales_report.monthly_ss_report_index', compact('zones', 'areas', 'dealers', 'factory'));
    }

    public function monthlysSSReport(Request $request)
    {

        // dd($request->all());


        $date = explode('-', $request->month);

        $year = $date[0];
        $month = $date[1];



        if ($month == 1) {
            $pre_pre_month = 11;
            $pre_month = 12;

            $pre_year = $year - 1;
            $pre_pre_year = $year - 1;
            // $pre_month = 12;
        } elseif ($month == 2) {
            $pre_pre_month = 12;
            $pre_month = $month - 1;

            $pre_year = $year;
            $pre_pre_year = $year - 1;
        } else {
            $pre_pre_month = $month - 2;
            $pre_month = $month - 1;

            $pre_year = $year;
            $pre_pre_year = $year;
        }

        $qtr_start_date = date('Y-m-01 H:i:s', strtotime($pre_pre_year . '-' . $pre_pre_month));
        $qtr_end_date = date('Y-m-t H:i:s', strtotime($year . '-' . $month));

        // dd($pre_pre_year);

        $areadata = DB::table('sales_ledgers as t1')
            // ->leftjoin('sales as t1','t1.id','t5.sale_id')
            ->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id')
            ->leftjoin('dealer_areas as t6', 't2.dlr_area_id', '=', 't6.id')
            ->leftjoin('dealer_zones as t7', 't2.dlr_zone_id', '=', 't7.id')
            ->leftjoin('factories as t3', 't1.warehouse_bank_id', '=', 't3.id')
            ->leftjoin('sales_products as t4','t1.product_id','=','t4.id')
            ->orderBy('t6.area_title', 'asc')
            ->orderBy('t2.d_s_name', 'asc');

        if (isset($request->vendor_id)) {
            $vendorid = $request->vendor_id;
            $areadata = $areadata->whereIn('t1.vendor_id', $vendorid);
        }

        if (isset($request->dlr_zone_id)) {

            $areadata = $areadata->where('t7.dlr_zone_id', $request->dlr_zone_id);
        }
        if (isset($request->dlr_area_id)) {
            $dlr_area_id = $request->dlr_area_id;
            $areadata = $areadata->whereIn('t2.dlr_area_id', $dlr_area_id);
        }

        $areadata = $areadata->select(
            't1.vendor_id',
            't2.d_s_name as dealer_name',
            't6.area_title as area',
            't2.dlr_police_station',
            't2.dlr_base',
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `qty_kg`/1000 ELSE null END) as current_sale'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $pre_month . '" AND YEAR(t1.ledger_date) = "' . $pre_year . '" THEN `qty_kg`/1000 ELSE null END) as pre_month_sale'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $pre_pre_month . '" AND YEAR(t1.ledger_date) = "' . $pre_pre_year . '" THEN `qty_kg`/1000 ELSE null END) as pre_pre_month_sale'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `debit` ELSE null END) as current_debit'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `credit` ELSE null END) as current_credit'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $pre_month . '" AND YEAR(t1.ledger_date) = "' . $pre_year . '" THEN `debit` ELSE null END) as pre_month_debit'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $pre_month . '" AND YEAR(t1.ledger_date) = "' . $pre_year . '" THEN `credit` ELSE null END) as pre_month_credit'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" AND t4.category_id = 1 THEN `qty_kg`/1000 ELSE null END) as cat1'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" AND t4.category_id = 3 THEN `qty_kg`/1000 ELSE null END) as cat3'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" AND t4.category_id = 4 THEN `qty_kg`/1000 ELSE null END) as cat4'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" AND t4.category_id = 5 THEN `qty_kg`/1000 ELSE null END) as cat5'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" AND t4.category_id = 6 THEN `qty_kg`/1000 ELSE null END) as cat6')

            )
            ->whereNotNull('t2.d_s_name')->groupBy('t1.vendor_id')->get();



            // foreach ($areadata as $key => $value) {

                // $categorydata =DB::table('sales_ledgers as t1')
                // // ->leftjoin('sales as t1','t1.id','t5.sale_id')
                // ->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id')
                // ->leftjoin('sales_products as t3', 't1.product_id', '=', 't3.id')
                // ->leftjoin('sales_categories as t4', 't3.category_id', '=', 't4.id')
                // ->select(
                //     't3.category_id',
                //     't4.category_name',
                //    DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `qty_kg`/1000 ELSE null END) as category_sale')
                // )
                //     ->where('t1.vendor_id',$value->vendor_id)->whereNotNull('product_id')->groupBy('t3.category_id')->get()->keyBy('category_id');;

            //     //   $areadata[$key]->categorydata =  $categorydata;
            //        $areadata[$key]->categorydata =  json_decode($categorydata, true);
            // }

           //dd($areadata);

          // $areadata = [];
           $categorys = SalesCategory::all();

        return view('backend.sales_report.monthly_ss_report', compact('areadata', 'date','year', 'month','categorys'));
    }





    public function zonewiseSSReportIndex()
    {
        $zones = DealerZone::All();
        $areas = DealerArea::All();
        $dealers = Dealer::All();
        $factory = Factory::all();

        //dd($areas);


        return view('backend.sales_report.zonewise_ss_report_index', compact('zones', 'areas', 'dealers', 'factory'));
    }

    public function zonewiseSSReport(Request $request)
    {

        //  dd($request->all());


        $data = explode('-', $request->month);

        $year = $data[0];
        $month = $data[1];



        if ($month == 1) {
            $pre_pre_month = 11;
            $pre_month = 12;

            $pre_year = $year - 1;
            $pre_pre_year = $year - 1;
            // $pre_month = 12;
        } elseif ($month == 2) {
            $pre_pre_month = 12;
            $pre_month = $month - 1;

            $pre_year = $year;
            $pre_pre_year = $year - 1;
        } else {
            $pre_pre_month = $month - 2;
            $pre_month = $month - 1;

            $pre_year = $year;
            $pre_pre_year = $year;
        }

        $qtr_start_date = date('Y-m-01 H:i:s', strtotime($pre_pre_year . '-' . $pre_pre_month));
        $qtr_end_date = date('Y-m-t H:i:s', strtotime($year . '-' . $month));

        // dd($pre_pre_year);

        $areadata = DB::table('sales_ledgers as t1')
            // ->leftjoin('sales as t1','t1.id','t5.sale_id')
            ->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id')
            ->leftjoin('dealer_areas as t6', 't2.dlr_area_id', '=', 't6.id')
            ->leftjoin('dealer_zones as t7', 't2.dlr_zone_id', '=', 't7.id')
            ->leftjoin('factories as t3', 't1.warehouse_bank_id', '=', 't3.id')
            ->leftjoin('sales_products as t4','t1.product_id','=','t4.id')
            ->orderBy('t6.area_title', 'asc')
            ->orderBy('t7.zone_title', 'asc');


        if (isset($request->dlr_zone_id)) {
            $dlr_zone_id = $request->dlr_zone_id;

            $areadata = $areadata->where('t2.dlr_zone_id', $request->dlr_zone_id);
        }
        if (isset($request->dlr_area_id)) {
            $dlr_area_id = $request->dlr_area_id;
            $areadata = $areadata->whereIn('t2.dlr_area_id', $dlr_area_id);
        }

        $areadata = $areadata->select(
            't7.zone_title as zone',
            't6.area_title as area',
            't2.dlr_area_id',
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `qty_kg`/1000 ELSE null END) as current_sale'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $pre_month . '" AND YEAR(t1.ledger_date) = "' . $pre_year . '" THEN `qty_kg`/1000 ELSE null END) as pre_month_sale'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $pre_pre_month . '" AND YEAR(t1.ledger_date) = "' . $pre_pre_year . '" THEN `qty_kg`/1000 ELSE null END) as pre_pre_month_sale'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `debit` ELSE null END) as current_debit'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `credit` ELSE null END) as current_credit'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $pre_month . '" AND YEAR(t1.ledger_date) = "' . $pre_year . '" THEN `debit` ELSE null END) as pre_month_debit'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $pre_month . '" AND YEAR(t1.ledger_date) = "' . $pre_year . '" THEN `credit` ELSE null END) as pre_month_credit'),
            DB::raw('sum(t2.dlr_police_station) as dlr_police_station'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" AND t4.category_id = 1 THEN `qty_kg`/1000 ELSE null END) as cat1'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" AND t4.category_id = 3 THEN `qty_kg`/1000 ELSE null END) as cat3'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" AND t4.category_id = 4 THEN `qty_kg`/1000 ELSE null END) as cat4'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" AND t4.category_id = 5 THEN `qty_kg`/1000 ELSE null END) as cat5'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" AND t4.category_id = 6 THEN `qty_kg`/1000 ELSE null END) as cat6')
        )
            ->whereNotNull('t6.area_title')->groupBy('t2.dlr_area_id')->get();

            $categorys = SalesCategory::all();

        //  dd($areadata);


        return view('backend.sales_report.zonewise_ss_report', compact('areadata', 'year', 'month','categorys'));
    }


    public function yearlyVendorSSReportIndex()
    {
        $zones = DealerZone::All();
        $areas = DealerArea::All();
        $dealers = Dealer::All();
        $factory = Factory::all();

        //dd($areas);
        return view('backend.sales_report.yearly_vendor_ss_report_index', compact('zones', 'areas', 'dealers', 'factory'));
    }

    public function yearlyVendorSSReport(Request $request)
    {
        // dd($request->all());
        $dealer = Dealer::find($request->vendor_id);
        $dealer_zone = DealerZone::find($dealer->dlr_zone_id);
        $vendor = $request->vendor_id;
        $year = $request->year;
        $data = array(
            '1' => null,
            '2' => null,
            '3' => null,
            '4' => null,
            '5' => null,
            '6' => null,
            '7' => null,
            '8' => null,
            '9' => null,
            '10' => null,
            '11' => null,
            '12' => null,
        );
      $fdate = "01-01-".$year;
        $dealer_opening_balancea = SalesLedger::where('vendor_id', $request->vendor_id)
            ->where('warehouse_bank_name', 'Opening Balance')
            ->first();
        $stardate = "2023-07-01";

       $predate=date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
   // dd($predate);
            $openingpre =  DB::select('SELECT SUM(debit) as debit,SUM(credit) as credit FROM `sales_ledgers`
                                        WHERE vendor_id = "'.$request->vendor_id.'" AND ledger_date <= "'.$predate.'"');

    $dealer_opening_balance = $dealer->dlr_base + $openingpre[0]->debit-$openingpre[0]->credit;


      //dd($dealer_opening_balance);
        $cdata = DB::table('sales_ledgers')->leftjoin('sales_products', 'sales_ledgers.product_id', '=', 'sales_products.id')
            ->select(
                DB::raw('sum(debit) as `debit`,sum(credit) as credit,sum(qty_pcs) as total_qty,sum(qty_kg) as qty_kg'),
                DB::raw('YEAR(ledger_date) year, MONTH(ledger_date) month'),
                DB::raw('sum(CASE WHEN sales_products.product_weight  = 50  THEN `qty_pcs` ELSE null END) as total_qty_50kg')
            )
            ->where('vendor_id', $vendor)
            ->whereYear('ledger_date', $year)
            ->groupby('year', 'month')
            ->orderBy('month', 'asc')
            ->get();
        $dealer_warehouse = DB::table('transport_costs as t1')
            ->leftjoin('factories as t2', 't1.warehouse_id', '=', 't2.id')
            ->where('t1.dealer_id', $request->vendor_id)
            ->select('t1.*', 't2.factory_name')
            ->get();
        // dd($dealer_warehouse);
        foreach ($data as $key => $v) {
            foreach ($dealer_warehouse as $warehouse) {
                $warehouse_data[$key][] = 0;
                $warehouse_bagdata[$key][] = 0;
            }
        }
        $twqty = 0;
        foreach ($cdata as $value) {
            $warehouse_data[$value->month] = array();
            $warehouse_bagdata[$value->month] = array();
            $warehouse_50kgbagdata[$value->month] = array();
            $transport_cost = 0;
            $tqty = 0;
            $bagtransport_cost = 0;
            $bagtqty = 0;
            foreach ($dealer_warehouse as $warehouse) {

                $wdata = DB::table('sales_ledgers')
                    ->select(DB::raw('sum(qty_kg) as tqty'))
                    ->where('vendor_id', $vendor)
                    ->where('warehouse_bank_id', $warehouse->warehouse_id)
                    ->whereYear('ledger_date', $year)
                    ->whereMonth('ledger_date', $value->month)
                    ->groupby('vendor_id')
                    ->first();

                $warehouse_data[$value->month][] = ($wdata) ? $wdata->tqty : 0;
                $wqty =  ($wdata) ? $wdata->tqty : 0;
                $transport_cost += $wqty * ($warehouse->transport_cost / 50);
                $tqty += $wqty;

                //dd($tqty);


                $bagwdata = DB::table('sales_ledgers')->join('sales_products', 'sales_ledgers.product_id', '=', 'sales_products.id')
                    ->select(
                        DB::raw('sum(qty_pcs) as bagtqty'),
                        DB::raw('sum(CASE WHEN sales_products.product_weight  = 50  THEN `qty_pcs` ELSE null END) as total_qty_50kg'),
                        DB::raw('sum(CASE WHEN sales_products.product_weight  = 25  THEN `qty_pcs` ELSE null END) as total_qty_25kg'),
                        DB::raw('sum(CASE WHEN sales_products.product_weight  = 10  THEN `qty_pcs` ELSE null END) as total_qty_10kg')
                    )
                    ->where('vendor_id', $vendor)
                    ->where('warehouse_bank_id', $warehouse->warehouse_id)
                    ->whereYear('ledger_date', $year)
                    ->whereMonth('ledger_date', $value->month)
                    ->groupby('vendor_id')
                    ->first();

                $return = DB::table('return_products')
                    ->select(DB::raw('sum(total_qty) as retbagtqty'))
                    ->where('dealer_id', $vendor)
                    ->where('demand_year', $year)
                    ->where('demand_month', $value->month)
                    ->groupby('dealer_id')
                    ->first();

                $warehouse_bagdata[$value->month][] = ($bagwdata) ? $bagwdata->bagtqty : 0;
                // $warehouse_bagdata[$value->month][1] = ($bagwdata)?$bagwdata->total_qty_50kg:0;
                // $warehouse_bagdata[$value->month][2] = ($bagwdata)?$bagwdata->total_qty_25kg:0;
                // $warehouse_bagdata[$value->month][3] = ($bagwdata)?$bagwdata->total_qty_10kg:0;
                $bagwqty =  ($bagwdata) ? $bagwdata->bagtqty : 0;
                $rtn = ($return) ? $return->retbagtqty : 0;
                $bagtransport_cost += $bagwqty * $warehouse->transport_cost;
                $bagtqty += $bagwqty - $rtn;
            }





            $ins_per = CommissionIn::where('target_amount', '<=', ($tqty / 1000))
                ->where('max_target_amount', '>=', ($tqty / 1000))
                ->first();
            $twqty += $tqty;

            if ($ins_per) {
                $percent = $ins_per->achive_commision;
            } else {
                $percent = 0;
            }



            $value->percent = $percent;
            $value->incentive = ($value->debit - $transport_cost) * ($percent / 100);
            $value->transport_cost = $transport_cost;
            $data[$value->month] = $value;
        }

        //dd($warehouse_bagdata);

        $yearly_incentive = YearlyIncentive::where('min_target_amount', '<=', ($twqty / 1000))
            ->where('max_target_amount', '>=', ($twqty / 1000))
            ->first();


        return view('backend.sales_report.yearly_vendor_ss_report', compact('data', 'dealer', 'dealer_zone', 'year', 'dealer_warehouse', 'warehouse_data', 'warehouse_bagdata', 'dealer_opening_balance', 'yearly_incentive'));
    }


   public function yearlyVendorDaterangeSSReportIndex()
    {
        $zones = DealerZone::All();
        $areas = DealerArea::All();
        $dealers = Dealer::All();
        $factory = Factory::all();

        //dd($areas);


        return view('backend.sales_report.yearly_vendor_daterange_ss_report_index', compact('zones', 'areas', 'dealers', 'factory'));
    }

   public function yearlyVendorDaterangeSSReport(Request $request){

         $dealer = Dealer::find($request->vendor_id);
         $dealer_zone = DealerZone::find($dealer->dlr_zone_id);
     	 $category = SalesCategory::whereIn('id',[20,21,27])->get();
         $vendor = $request->vendor_id;
         $year = $request->year;
         $date = $request->date;

    	 if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
         }

        $dealer_opb = SalesLedger::where('vendor_id',$request->vendor_id)
                ->where('warehouse_bank_name','Opening Balance')
                ->first();
    	  $stardate = "2023-07-01";

         if($fdate <= "2023-07-01"){
              $predate = "2023-07-01";
         } else {
           $predate=date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
         }
          //  $openingpre =  DB::select('SELECT SUM(debit) as debit,SUM(credit) as credit FROM `sales_ledgers`
                                    //    WHERE vendor_id = "'.$request->vendor_id.'" AND ledger_date <="'.$predate.'"');

        $openingpre =  DB::select('SELECT SUM(debit) as debit,SUM(credit) as credit FROM `sales_ledgers`
                                        WHERE vendor_id = "'.$request->vendor_id.'" AND ledger_date BETWEEN "'.$stardate.'" AND "'.$predate.'"');

     	$dealer_opening_balance = $dealer->dlr_base + $openingpre[0]->debit-$openingpre[0]->credit;


    //  dd($dealer_opening_balance);

      //dd($dealer_opening_balance);
        $cdata = DB::table('sales_ledgers')->leftjoin('sales_products','sales_ledgers.product_id','=','sales_products.id')
       				->select(DB::raw('sum(debit) as `debit`,sum(credit) as credit,sum(qty_pcs) as total_qty,sum(qty_kg) as qty_kg'),
                 	DB::raw('YEAR(ledger_date) year, MONTH(ledger_date) month'),
                   	DB::raw('sum(CASE WHEN sales_products.product_weight  = 50  THEN `qty_pcs` ELSE null END) as total_qty_50kg'))
                  	->where('vendor_id',$vendor)
                  	->whereBetween('ledger_date',[$fdate,$tdate])
                	->groupby('year','month')
                	->orderBy('month','asc')->get();

     $data = array();
     foreach ($cdata as $key=>$v){
           $data[$v->month.'_'.$v->year] = 0;
        }


        $dealer_warehouse = DB::table('transport_costs as t1')->select('t1.*','t2.factory_name')
                ->leftjoin('factories as t2','t1.warehouse_id','=','t2.id')
                ->where('t1.dealer_id',$request->vendor_id)->get();

        foreach ($data as $key=>$v){
            foreach ($dealer_warehouse as $warehouse) {
                $warehouse_data[$key][] = 0;
                $warehouse_bagdata[$key][] = 0;
            }
        }
         $twqty = 0;

     $len = count($cdata);

        foreach ($cdata as $key => $value) {

           if($key == 0 && $len == 1){
            	$ffdate = $fdate;
            	$ttdate = $tdate;

            }elseif($key == 0 && $len > 1){
            	 $ffdate = $fdate;
            	 $ttdate = date("Y-m-t", strtotime($ffdate));

            }
            elseif($key == $len-1){
            	$ffdate = $value->year.'-'.$value->month."-01";
            	$ttdate = $tdate;
            	// $ttdate = date("Y-m-t", strtotime($ffdate));

            }else{
            	$ffdate = $value->year.'-'.$value->month."-01";
            	$ttdate = date("Y-m-t", strtotime($ffdate));
            }

            $warehouse_data[$value->month.'_'.$value->year] = array();
            $warehouse_bagdata[$value->month.'_'.$value->year] = array();
            $warehouse_50kgbagdata[$value->month.'_'.$value->year] = array();
            $transport_cost =0;
            $tqty = 0;
            $bagtransport_cost =0;
            $bagtqty = 0;
            foreach ($dealer_warehouse as $warehouse) {

                $wdata = DB::table('sales_ledgers')
                        ->select(DB::raw('sum(qty_kg) as tqty'))
                        ->where('vendor_id', $vendor)
                        ->where('warehouse_bank_id', $warehouse->warehouse_id)
                        ->whereBetween('ledger_date',[$ffdate,$ttdate])->first();

                $warehouse_data[$value->month.'_'.$value->year][] = ($wdata)?$wdata->tqty:0;
              /*
                $wqty =  ($wdata)?$wdata->tqty:0;
                $transport_cost += $wqty * ($warehouse->transport_cost/50);
                $tqty +=$wqty; */
             /* $insentive = 0;
              foreach($category as $val){
              	$insentiveQty = DB::table('sales_ledgers')->where('category_id',$val->id)->where('vendor_id', $vendor)
                        //->where('warehouse_bank_id', $warehouse->warehouse_id)
                        ->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_kg');
                $ton = 0;
                $ton = $insentiveQty/1000;
                //dd($ton);
                //$com = CommissionIn::where('category_id', $val->id)->where('target_amount','<=', $ton )->where('max_target_amount','>=',$ton)->value('achive_commision');
               	$com = YearlyIncentive::where('category_id', $val->id)->where('min_target_amount','<=', $ton )->where('max_target_amount','>=',$ton)->value('incentive');
                  $insentive+= $com*$insentiveQty;
              }
              $value->incentive = $insentive;
              */


                //dd($insentive);
                $transport_cost = 0;

                $bagwdata = DB::table('sales_ledgers')->join('sales_products','sales_ledgers.product_id','=','sales_products.id')
                        		->select(DB::raw('sum(qty_pcs) as bagtqty'),
                                 DB::raw('sum(CASE WHEN sales_products.product_weight  = 50  THEN `qty_pcs` ELSE null END) as total_qty_50kg'),
                                 DB::raw('sum(CASE WHEN sales_products.product_weight  = 25  THEN `qty_pcs` ELSE null END) as total_qty_25kg'),
                                 DB::raw('sum(CASE WHEN sales_products.product_weight  = 10  THEN `qty_pcs` ELSE null END) as total_qty_10kg'))
                              	->where('vendor_id', $vendor)
                              	->where('warehouse_bank_id', $warehouse->warehouse_id)
                              	->whereBetween('ledger_date',[$ffdate,$ttdate])
                              	->groupby('vendor_id')->first();

                $return = DB::table('sales_returns')
                        ->select(DB::raw('sum(total_qty) as retbagtqty'))
                        ->where('dealer_id', $vendor)
                        ->whereBetween('date',[$ffdate,$ttdate])
                        ->groupby('dealer_id')->first();

                $warehouse_bagdata[$value->month.'_'.$value->year][] = ($bagwdata)?$bagwdata->bagtqty:0;
               // $warehouse_bagdata[$value->month][1] = ($bagwdata)?$bagwdata->total_qty_50kg:0;
               // $warehouse_bagdata[$value->month][2] = ($bagwdata)?$bagwdata->total_qty_25kg:0;
               // $warehouse_bagdata[$value->month][3] = ($bagwdata)?$bagwdata->total_qty_10kg:0;
                  $bagwqty =  ($bagwdata)?$bagwdata->bagtqty:0;
                $rtn = ($return)?$return->retbagtqty:0;
                $bagtransport_cost += $bagwqty * $warehouse->transport_cost;
                $bagtqty +=$bagwqty-$rtn;

            }

          /*  $ins_per = CommissionIn::where('target_amount','<=',($tqty/1000))
                    ->where('max_target_amount','>=',($tqty/1000))
                    ->first();
             $twqty +=$tqty;

            if($ins_per){
                $percent = $ins_per->achive_commision;
            }else{
                $percent = 0;
            }*/
			$value->percent = 0;
            //$value->percent = $percent;
           // $value->incentive = ($value->debit - $transport_cost) *($percent/100);
            $value->transport_cost = $transport_cost;
            $data[$value->month.'_'.$value->year] = $value;
        }

    //dd($twqty);

     // dd($dealer_warehouse);

      /* $yearly_incentive = YearlyIncentive::where('min_target_amount','<=',($twqty/1000))
                    ->where('max_target_amount','>=',($twqty/1000))
                    ->first(); */

                // dd($yearly_incentive);

    			 $insentive = 0;
              foreach($category as $val){

              	$insentiveQty = DB::table('sales_ledgers')->where('category_id',$val->id)->where('vendor_id', $vendor)
                        //->where('warehouse_bank_id', $warehouse->warehouse_id)
                        ->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_kg');

                if($insentiveQty >= 1000){
                $ton = 0;
                $ton = intval($insentiveQty/1000);
                //dd($ton);
                //$com = CommissionIn::where('category_id', $val->id)->where('target_amount','<=', $ton )->where('max_target_amount','>=',$ton)->value('achive_commision');
               		$com = YearlyIncentive::where('category_id', $val->id)->where('min_target_amount','<=', $ton )->where('max_target_amount','>=',$ton)->value('incentive');

                  $insentive+= $com*$insentiveQty;
                }
              }
              $insentive = $insentive;

     //Journal Entry Start
               $month = date('m', strtotime($tdate));

              $remainingCom = 0;
              $comission = DB::table('sales_ledgers')->where('vendor_id', $vendor)->whereBetween('ledger_date',[$fdate,$tdate])->sum('discount_amount');
              $subLedgerId = DB::table('expanse_sub_subgroups')->where('subgroup_id',101)->first();
              $remainingCom = $insentive - $comission;
               $checkData = JournalEntry::where('vendor_id',$vendor)->whereMonth('date',$month)->where('debit',$remainingCom)->first();
              if(empty($checkData) && $remainingCom > 0)
              {
             	$JournalEntry = new JournalEntry();
                $JournalEntry->vendor_id = $vendor;
                $JournalEntry->ledger_id = 101;
                $JournalEntry->sub_ledger_id = $subLedgerId->id ?? '';
              	$JournalEntry->user_id = Auth::id();
                $JournalEntry->debit = $remainingCom;
                $JournalEntry->credit = $remainingCom;
                $JournalEntry->subject = 'Journal Sales Insentive';
                $JournalEntry->dc_type = 1;
                $JournalEntry->date = $tdate;
                $JournalEntry->save();
              	$id = $JournalEntry->id+100000;
                $JournalEntry->invoice = 'Jar-'.$id;
                $JournalEntry->save();


                if ($JournalEntry->save()) {

                    $ledger = new SalesLedger();
                     $delaer_area_id = DB::table('dealers')->where('id', $vendor)->value('dlr_area_id');

                    $ledger->vendor_id = $vendor;
                    $ledger->area_id = $delaer_area_id;
                    $ledger->ledger_date = $tdate;
                    $ledger->warehouse_bank_name =  "Journal Sales Insentive";

                    $ledger->invoice =  $JournalEntry->invoice;
                    $ledger->narration = "(Journal Sales Insentive)";
                    $ledger->journal_id = $JournalEntry->id;
                  	$ledger->priority = 100;
                    $ledger->credit = $remainingCom;
                    $ledger->ledger_id = 101;
               		$ledger->sub_ledger_id = $subLedgerId->id ?? '';
                    $ledger->save();
                }
              }
              //Journal Entry End

        return view('backend.sales_report.yearly_vendor_daterange_ss_report', compact('data','insentive','vendor', 'dealer','fdate','tdate', 'dealer_zone','year','dealer_warehouse','warehouse_data','warehouse_bagdata','dealer_opening_balance','category'));

    }



    public function yearlySalesStatementReportIndex()
    {

        $dealer = Dealer::all();
        $zones = DealerZone::orderby('zone_title')->get();
        $areas = DealerArea::orderby('area_title')->get();

        return view('backend.sales_report.yearly_ss_report_index', compact('dealer', 'zones', 'areas'));
    }

    public function yearlySalesStatementReport(Request $request)
    {
        //  dd($request->all());
        $areaID = $request->dlr_area_id;
        $zoneID = $request->vendor_zone;

        $dealrs = DB::table('dealers as t1')
            ->select('t1.dlr_area_id as id', 't2.area_title', 't3.zone_title', 't3.main_zone')
            ->join('dealer_areas as t2', 't1.dlr_area_id', '=', 't2.id')
            ->join('dealer_zones as t3', 't1.dlr_zone_id', '=', 't3.id')
            ->distinct('dlr_area_id')
            ->orderBy(DB::raw('ISNULL(t3.main_zone), t3.main_zone'), 'asc')
            ->orderby('zone_title', 'asc')
            ->orderby('area_title', 'asc');
        if ($areaID) {
            $dealrs->wherein('t1.dlr_area_id', $areaID);
        }
        if ($zoneID) {
            $dealrs->wherein('t1.dlr_zone_id', $zoneID);
        }
        $area = $dealrs->get();
        $all_area = $dealrs->get();


        $get_year = $request->year;
        // dd($area);

        return view('backend.sales_report.yearly_ss_report', compact('get_year', 'area'));
    }



    public function monthlyTargetReportIndex()
    {
        $dealer = Dealer::all();
        $zones = DealerZone::orderby('zone_title')->get();
        $areas = DealerArea::orderby('area_title')->get();

       // $cashdealer = Dealer::where('dlr_type_id', 9)->get();

        return view('backend.sales_report.monthly_employee_target_index', compact('dealer', 'zones', 'areas'));
    }



    public function monthlyTargetReport(Request $request)
    {

        //  $cyear = date('Y');
        //  $cmonth = date('m');
        // dd($request->all());

		if (isset($request->date)) {
             $dates = explode(' - ', $request->date);
             $fdate = date('Y-m-d', strtotime($dates[0]));
             $tdate = date('Y-m-d', strtotime($dates[1]));
             $month_name =  date('F', strtotime($fdate));
            $year = date('Y', strtotime($fdate));
         }
      /*
        if ($request->month_year) {

            $fdate = $request->month_year . "-01";
            //$tdate = $request->month_year."-31";
            $tdate = date("Y-m-t", strtotime($fdate));
            $month_name =  date('F', strtotime($fdate));

            $year = date('Y', strtotime($fdate));
        } */

        if ($request->q_month && $request->month_year == null) {

            if ($request->q_year) {
                $year = $request->q_year;
            } else {
                $year = date('Y');
            }
            //dd($year);

            if ($request->q_month == 1) {
                $fdate = $year . "-01-01";
                $tdate = $year . "-03-31";
                $month_name =  "Jan-Feb-Mar";
            } elseif ($request->q_month == 2) {
                $fdate = $year . "-04-01";
                $tdate = $year . "-06-31";
                $month_name =   "Apr-May-Jun";
            } elseif ($request->q_month == 3) {
                $fdate = $year . "-07-01";
                $tdate = $year . "-09-31";
                $month_name =   "Jul-Aug-Sep";
            } else {
                $fdate = $year . "-10-01";
                $tdate = $year . "-12-31";
                $month_name =   "Oct-Nov-Dec";
            }
        }
        if ($request->q_year && $request->q_month == null && $request->month_year == null) {
            $fdate = $request->q_year . "-01-01";
            $tdate = $request->q_year . "-12-31";
            $month_name =  "January To Decembar";
        }



        // dd($request);
        $areaId = $request->dlr_area_id;

        $zoneID = $request->vendor_zone;


        $areas = DB::table('montly_sales_targets as t1')
            ->select('t1.area_id', 't4.area_title')
            ->join('dealer_areas as t4', 't1.area_id', '=', 't4.id')
            ->whereBetween('date', [$fdate, $tdate])
            ->whereNotNUll('area_id')
            ->distinct('area_id')
            ->get();

        $zones = DB::table('montly_sales_targets as t1')
            ->select('t1.area_id', 't4.zone_title', 't4.main_zone')
            ->join('dealer_zones as t4', 't1.zone_id', '=', 't4.id')
            ->whereBetween('date', [$fdate, $tdate])
            ->whereNotNUll('zone_id')
            ->distinct('zone_id');

        if ($request->vendor_main_zone != '') {
            $zones->where('t4.main_zone', $request->vendor_main_zone);
        }

        if ($request->vendor_zone) {
            $zones->whereIn('t1.zone_id', $request->vendor_zone);
        }
        if ($request->dlr_area_id) {
            $zones->whereIn('t1.area_id', $request->dlr_area_id);
        }
        if ($request->dealer_id) {
            $zones->whereIn('t1.dealer_id', $request->dealer_id);
        }

        $zones = $zones->orderBy(DB::raw('ISNULL(t4.main_zone), t4.main_zone'), 'asc')
            ->orderBy('t4.zone_title', 'asc')
            ->get();

	//dd($zones);

        $data = array();

        foreach ($zones as $key => $zone) {
            $ddd = DB::table('montly_sales_targets as t1')
                ->select('t1.area_id', 't4.area_title')
                ->join('dealer_areas as t4', 't1.area_id', '=', 't4.id')
                ->whereBetween('date', [$fdate, $tdate])
                ->where('area_id', $zone->area_id)
                ->distinct('area_id');
            //     ->get();
            //  dd($request->warehouse_id);
            if ($request->dlr_area_id) {
                $ddd->whereIn('t1.area_id', $request->dlr_area_id);
            }
            if ($request->cash_dlr_id) {
                $ddd->whereIn('t1.dealer_id', $request->cash_dlr_id);
            }

            $data[$zone->area_id]  = $ddd->orderBy('area_title', 'ASC')->get();
        }


        //dd($zones);

        $product_categorys = DB::table('sales_products as t1')
            ->select('t1.category_id', 't2.category_name')
            ->join('sales_categories as t2', 't1.category_id', '=', 't2.id')->whereNotIn('t2.id',[31,32])
            ->orderBy('category_id')
            ->distinct('category_id')
            ->get();
		$allProducts = DB::table('sales_products')->whereNotIn('category_id',[31])->orderby('product_name', 'asc')->get();
       //  dd($product_categorys);
        // return view('salesReport.monthly_target_report_list', compact('zones','product_categorys','areas','fdate','tdate','month_name','areaId','dlr_area_id','zoneID','main_zzz'));
        return view('backend.sales_report.monthly_employee_target_report', compact('allProducts','year', 'product_categorys', 'data', 'zones', 'areas', 'fdate', 'tdate', 'month_name', 'areaId', 'zoneID'));
    }
	public function monthlyDealerSalesTargetReportIndex(){
    	$dealer = Dealer::all();
        $zones = DealerZone::orderby('zone_title')->get();
        $areas = DealerArea::orderby('area_title')->get();
        return view('backend.sales_report.monthlyDealerSalesTargetIndex', compact('dealer', 'zones', 'areas'));
    }

  public function monthlyDealerSalesTargetReport(Request $request){
  if (isset($request->date)) {
             $dates = explode(' - ', $request->date);
             $fdate = date('Y-m-d', strtotime($dates[0]));
             $tdate = date('Y-m-d', strtotime($dates[1]));
             $month_name =  date('F', strtotime($fdate));
            $year = date('Y', strtotime($fdate));
         }
        if ($request->q_month && $request->month_year == null) {

            if ($request->q_year) {
                $year = $request->q_year;
            } else {
                $year = date('Y');
            }
            //dd($year);

            if ($request->q_month == 1) {
                $fdate = $year . "-01-01";
                $tdate = $year . "-03-31";
                $month_name =  "Jan-Feb-Mar";
            } elseif ($request->q_month == 2) {
                $fdate = $year . "-04-01";
                $tdate = $year . "-06-31";
                $month_name =   "Apr-May-Jun";
            } elseif ($request->q_month == 3) {
                $fdate = $year . "-07-01";
                $tdate = $year . "-09-31";
                $month_name =   "Jul-Aug-Sep";
            } else {
                $fdate = $year . "-10-01";
                $tdate = $year . "-12-31";
                $month_name =   "Oct-Nov-Dec";
            }
        }
        if ($request->q_year && $request->q_month == null && $request->month_year == null) {
            $fdate = $request->q_year . "-01-01";
            $tdate = $request->q_year . "-12-31";
            $month_name =  "January To Decembar";
        }


/*
        // dd($request);
        $areaId = $request->dlr_area_id;

        $zoneID = $request->vendor_zone;


        $areas = DB::table('montly_sales_targets as t1')
            ->select('t1.area_id', 't4.area_title')
            ->join('dealer_areas as t4', 't1.area_id', '=', 't4.id')
            ->whereBetween('date', [$fdate, $tdate])
            ->whereNotNUll('area_id')
            ->distinct('area_id')
            ->get();

        $zones = DB::table('montly_sales_targets as t1')
            ->select('t1.area_id', 't4.zone_title', 't4.main_zone')
            ->join('dealer_zones as t4', 't1.zone_id', '=', 't4.id')
            ->whereBetween('date', [$fdate, $tdate])
            ->whereNotNUll('zone_id')
            ->distinct('zone_id');

        if ($request->vendor_main_zone != '') {
            $zones->where('t4.main_zone', $request->vendor_main_zone);
        }

        if ($request->vendor_zone) {
            $zones->whereIn('t1.zone_id', $request->vendor_zone);
        }
        if ($request->dlr_area_id) {
            $zones->whereIn('t1.area_id', $request->dlr_area_id);
        }
        if ($request->cash_dlr_id) {
            $zones->whereIn('t1.dealer_id', $request->cash_dlr_id);
        }

        $zones = $zones->orderBy(DB::raw('ISNULL(t4.main_zone), t4.main_zone'), 'asc')
            ->orderBy('t4.zone_title', 'asc')
            ->get();

	//dd($zones);

        $data = array();

        foreach ($zones as $key => $zone) {
            $ddd = DB::table('montly_sales_targets as t1')
                ->select('t1.area_id', 't4.area_title')
                ->join('dealer_areas as t4', 't1.area_id', '=', 't4.id')
                ->whereBetween('date', [$fdate, $tdate])
                ->where('area_id', $zone->area_id)
                ->distinct('area_id');
            //     ->get();
            //  dd($request->warehouse_id);
            if ($request->dlr_area_id) {
                $ddd->whereIn('t1.area_id', $request->dlr_area_id);
            }
            if ($request->dealer_id) {
                $ddd->whereIn('t1.dealer_id', $request->dealer_id);
            }

            $data[$zone->area_id]  = $ddd->orderBy('area_title', 'ASC')->get();
        }
*/

        $dealers = DB::table('montly_sales_targets as t1')->select('t1.dealer_id','t2.d_s_name as name')
          			->join('dealers as t2', 't1.dealer_id', '=', 't2.id')
          			->whereBetween('date', [$fdate, $tdate]);

    	 if ($request->vendor_zone) {
            $dealers->whereIn('t1.zone_id', $request->vendor_zone);
        }
        if ($request->dlr_area_id) {
            $dealers->whereIn('t1.area_id', $request->dlr_area_id);
        }
        if ($request->dealer_id) {
            $dealers->whereIn('t1.dealer_id', $request->dealer_id);
        }
    	$dealers = $dealers->groupBy('t1.dealer_id')->orderBy('t2.d_s_name', 'asc')->get();


        $product_categorys = DB::table('sales_products as t1')
            ->select('t1.category_id', 't2.category_name')
            ->join('sales_categories as t2', 't1.category_id', '=', 't2.id')->whereNotIn('t2.id',[31,32])
            ->orderBy('category_id')
            ->distinct('category_id')
            ->get();
		$allProducts = DB::table('sales_products')->whereNotIn('category_id',[31])->orderby('product_name', 'asc')->get();

        return view('backend.sales_report.monthlyDealerSalesTargetReportView', compact('allProducts','dealers','month_name','year','product_categorys', 'fdate', 'tdate'));
    }

	public function monthlyTargetItemReport($cat,$id, $fDate,$tDate){
    $products = DB::table('montly_sales_targets as t1')->select('t2.product_name',DB::raw('sum(qty_kg) as qty_kg'))
      ->join('sales_products as t2', 't1.product_id', '=', 't2.id')->where('t1.category_id',$cat)
      ->where('t1.area_id',$id)->whereBetween('t1.date', [$fDate, $tDate])->groupBy('t1.product_id')->get();
     // dd($products);
       $month =  date('F', strtotime($fDate));
       $year = date('Y', strtotime($fDate));
       $zones = DB::table('montly_sales_targets as t1')->select('t4.main_zone','t4.zone_title')
            ->join('dealer_zones as t4', 't1.zone_id', '=', 't4.id')->where('t1.area_id',$id)
            ->whereBetween('date', [$fDate, $tDate])->first();

      $area = DB::table('dealer_areas')->where('id',$id)->value('area_title');
     // dd($area);
     return view('backend.sales_report.monthly_employee_targetReport_products', compact('products','month','year','zones','area'));
    }


    public function shortSummaryReportIndex()
    {

        $dealer = Dealer::orderby('d_s_name')->get();
        $zones = DealerZone::orderby('zone_title')->get();
        $areas = DealerArea::orderby('area_title')->get();

        $factory = Factory::all();

        return view('backend.sales_report.short_summary_index', compact('dealer', 'zones', 'areas', 'factory'));
    }


    public function shortSummaryReport(Request $request)
    {
        //dd($request->all());

        $date = $request->date;
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $datefrom = date('Y-m-d', strtotime($dates[0]));
            $dateto = date('Y-m-d', strtotime($dates[1]));
        } else {
            $datefrom = date('Y-m-d');
            $dateto = date('Y-m-d');
        }

        if (isset($request->wirehouse_id)) {
            $wid = $request->wirehouse_id;
        } else {
            $wid = '';
        }
       if (isset($request->vendor_id)) {
            $vid = $request->vendor_id;
        } else {
            $vid = '';
        }

        //dd($vid);

        $category = DB::table('sales_categories')->whereNotIn('id',[39])->get();
        //dd($category);

        $wirehouses = Factory::all();
        return view('backend.sales_report.short_summary_report', compact('date', 'category', 'datefrom', 'dateto', 'wid','vid', 'wirehouses'));
    }
    
    
    //Brand Wise Sales By Awal (27-Jun-2024)
    public function brandWiseSalesReportIndex()
    {
        return view('backend.sales_report.bwsr.index');
    }
    
    
    public function getPreviousDateRange($startDate, $endDate) 
    {
        // Convert strings to DateTime objects
        $startDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);
        
        // Calculate the interval for 30 days
        $days = $startDate->diff($endDate)->days;
        
        $interval = new \DateInterval('P'.$days.'D');
        
        // Calculate previous date range ending just before the current start date
        $prevEndDate = clone $startDate;
        $prevEndDate->sub(new \DateInterval('P1D')); // Previous end date is one day before current start date
        $prevStartDate = clone $prevEndDate;
        $prevStartDate->sub($interval);
    
        // Calculate the same date range for the previous year
        $prevYearEndDate = clone $prevEndDate;
        $prevYearEndDate->sub(new \DateInterval('P1Y')); // Previous year end date is one year before prev end date
        $prevYearStartDate = clone $prevYearEndDate;
        $prevYearStartDate->sub($interval);
    
        return [
            'previous_start_date' => $prevStartDate->format('Y-m-d'),
            'previous_end_date' => $prevEndDate->format('Y-m-d'),
            'previous_year_start_date' => $prevYearStartDate->format('Y-m-d'),
            'previous_year_end_date' => $prevYearEndDate->format('Y-m-d')
        ];
    }


    public function brandWiseSalesReport(Request $request)
    {
        //dd($request->all());

        $date = $request->date;
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $datefrom = date('Y-m-d', strtotime($dates[0]));
            $dateto = date('Y-m-d', strtotime($dates[1]));
        } else {
            $datefrom = date('Y-m-d');
            $dateto = date('Y-m-d');
        }
    
        $previousDateRange = $this->getPreviousDateRange($datefrom, $dateto);
        
        $report_type = $request->report_type;
        $category = DB::table('sales_categories')->whereNotIn('id',[39])->get();
        
        return view('backend.sales_report.bwsr.reports', compact('date', 'report_type', 'category', 'datefrom', 'dateto', 'previousDateRange'));
    }
    //Brand Wise Sales By Awal (27-Jun-2024) End
    
    public function categoryWiseSummaryReportIndex()
    {
        $categories = DB::table('sales_categories')->get();

        return view('backend.sales_report.cwsr.index', compact('categories'));
    }
    
    public function categoryWiseSummaryReport(Request $request)
    {
        $this->validate($request, [
            'date'=>'required',
            'category_id'=>'required'
        ], [
            'date.required' => 'The field is required',
            'category_id.required' => 'The field is required',
        ]);
        
        $date = $request->date;
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $datefrom = date('Y-m-d', strtotime($dates[0]));
            $dateto = date('Y-m-d', strtotime($dates[1]));
        } else {
            $datefrom = date('Y-m-d');
            $dateto = date('Y-m-d');
        }

        $category = DB::table('sales_categories')->whereIn('id', $request->category_id)->whereNotIn('id',[39])->get();

        return view('backend.sales_report.cwsr.reports', compact('date', 'category', 'datefrom', 'dateto'));
    }
    
    
    public function categoryWiseShortSummaryReportIndex()
    {
        $categories = DB::table('sales_categories')->get();

        return view('backend.sales_report.cwsr.shortReportIndex', compact('categories'));
    }
    
    public function categoryWiseShortSummaryReport(Request $request)
    {
        $this->validate($request, [
            'date'=>'required',
            'category_id'=>'required'
        ], [
            'date.required' => 'The field is required',
            'category_id.required' => 'The field is required',
        ]);
        
        $date = $request->date;
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $datefrom = date('Y-m-d', strtotime($dates[0]));
            $dateto = date('Y-m-d', strtotime($dates[1]));
        } else {
            $datefrom = date('Y-m-d');
            $dateto = date('Y-m-d');
        }

        $category = DB::table('sales_categories')->whereIn('id', $request->category_id)->whereNotIn('id',[39])->get();

        return view('backend.sales_report.cwsr.shortReports', compact('date', 'category', 'datefrom', 'dateto'));
    }
    
    
    public function salesShortSummaryCogsReportIndex()
    {
        $categories = DB::table('sales_categories')->get();

        return view('backend.sales_report.sales_short_summary_reports_cogs_index', compact('categories'));
    }
    
    public function salesShortSummaryCogsReport(Request $request)
    {
        //dd($request->all());
        
        $this->validate($request, [
            'date'=>'required',
            'category_id'=>'required'
        ], [
            'date.required' => 'The field is required',
            'category_id.required' => 'The field is required',
        ]);

        $date = $request->date;
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $datefrom = date('Y-m-d', strtotime($dates[0]));
            $dateto = date('Y-m-d', strtotime($dates[1]));
        } else {
            $datefrom = date('Y-m-d');
            $dateto = date('Y-m-d');
        }

        $category = DB::table('sales_categories')->whereIn('id', $request->category_id)->whereNotIn('id',[39])->get();

        return view('backend.sales_report.sales_short_summary_cogs_reports', compact('date', 'category', 'datefrom', 'dateto'));
    }
    
    // SKU Wise COGS By Awal (27-Jun-2024)
    public function skuWiseCogsReportIndex()
    {
        // $categories = DB::table('sales_categories')->get();

        return view('backend.sales_report.sku_wcr.index');
    }
    
    public function skuWiseCogsReport(Request $request)
    {
        //dd($request->all());
        
        $this->validate($request, [
            'date'=>'required',
            // 'category_id'=>'required'
        ], [
            'date.required' => 'The field is required',
            // 'category_id.required' => 'The field is required',
        ]);

        $date = $request->date;
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate  = date('Y-m-d', strtotime($dates[0]));
            $tdate  = date('Y-m-d', strtotime($dates[1]));
        } else {
            $fdate = date('Y-m-d');
            $tdate = date('Y-m-d');
        }

        // $category = DB::table('sales_categories')->whereIn('id', $request->category_id)->whereNotIn('id',[39])->get();
        $category = DB::table('sales_categories')->whereNotIn('id',[39])->get();
        
        $allRawProducts = RawMaterialStockOut::where('invoice','LIKE','Sal-%')
                        ->where('status',1)
                        ->select('id', 'product_id', 'raw_product_id', DB::raw('SUM(amount) as amount'))
                        ->whereBetween('date',[$fdate, $tdate])
                        ->groupBy('raw_product_id')
                        ->get();
        $totalRawProductsAmount = RawMaterialStockOut::where('invoice','LIKE','Sal-%')->where('status',1)->whereBetween('date',[$fdate, $tdate])->sum('amount');
        
        // echo "<pre>";
        // print_r($allRawProducts);
        // exit;
        
        $allFgProducts = RawMaterialStockOut::where('invoice','LIKE','Sal-%')
                        ->where('status',2)
                        ->select('id', 'product_id', 'raw_product_id', DB::raw('SUM(amount) as amount'))
                        ->whereBetween('date',[$fdate, $tdate])
                        ->groupBy('raw_product_id')
                        ->get();
        $totalFgProductsAmount = RawMaterialStockOut::where('invoice','LIKE','Sal-%')->where('status',2)->whereBetween('date',[$fdate, $tdate])->sum('amount');
                        
        $allPackingProducts = PackingStockOut::where('invoice','LIKE','Sal-%')->where('status',1)->whereBetween('date',[$fdate, $tdate])->get();
        
        // dd($allPackingProducts->sum('amount'));
        
        $rawProducts = PurchaseStockout::where('sout_number','LIKE','Sal-%')
                        ->select('id', 'product_id', 'date', DB::raw('SUM(total_amount) as total_amount'))
                        ->whereBetween('date',[$fdate, $tdate])
                        ->groupBy('product_id')
                        ->get();
                        
        $rawProductsTotalAmount = PurchaseStockout::where('sout_number','LIKE','Sal-%')->whereBetween('date',[$fdate, $tdate])->sum('total_amount');
        $grandTotalRawProductsAmount = $totalRawProductsAmount + $rawProductsTotalAmount;
        
        $expenseData = [];
        $checkDate = $fdate;
        $individualAccountInfo = $this->getChartOfExpenseAccountInfo($fdate, $tdate);
           foreach($individualAccountInfo as $account)
           {
               if($checkDate == '2023-10-01'){
                 $preEndDate = '2023-10-01';
                 $preData = ChartOfAccounts::with('acSubSubAccount:id,title')->select('ac_sub_account_id',
                         DB::raw('SUM(debit) - SUM(credit) as balance')
                         )->where('invoice','LIKE','E-Pay-Inv%')
                         ->where('ac_sub_account_id',$account->acSubAccount?->id)->whereBetween('date', [$fdate, $preEndDate])->first();

                    $amount = $account->balance -  $preData->balance;
               } else {
                   $amount = $account->balance;
               }
                   
               $expenseData[] = $this->getDebitForIncomeStatement($account->ac_sub_account_id, $account->acSubAccount?->title, $amount);

           }
           
            $totalFOverHead = 0;

            foreach ($expenseData as $key => $val)
            {
                if ($val['id'] == 21 || $val['id'] == 9)
                    {
                        $totalFOverHead += $val['debit'];
                    }
            }
       
        $returnData = ChartOfAccounts::select(
           DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = 14 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as fgReturn'),
           DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = 13 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as rawReturn'),
           DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = 163 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as bagReturn')
        )->first();
        
        return view('backend.sales_report.sku_wcr.reports', compact(
            'category',
            'date',
            'fdate',
            'tdate',
            'allRawProducts',
            'totalRawProductsAmount',
            'rawProducts',
            'rawProductsTotalAmount',
            'grandTotalRawProductsAmount',
            'allFgProducts',
            'totalFgProductsAmount',
            'allPackingProducts',
            'totalFOverHead',
            'returnData'
            ));
    }
    // SKU Wise COGS By Awal (27-Jun-2024) End

	 public function catSalesOrderReportIndex()
    {

        $dealer = Dealer::orderby('d_s_name')->get();
        $factory = Factory::all();
        return view('backend.sales_report.catSalesOrderReportIndex', compact('dealer', 'factory'));
    }
	public function catSalesOrderReportView(Request $request){

     // dd($request->all());
     // $date = $request->date;
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $datefrom = date('Y-m-d', strtotime($dates[0]));
            $dateto = date('Y-m-d', strtotime($dates[1]));
        } else {
            $datefrom = date('Y-m-d');
            $dateto = date('Y-m-d');
        }

        if (isset($request->wirehouse_id)) {
            $wid = $request->wirehouse_id;
        } else {
            $wid = '';
        }
       if (isset($request->vendor_id)) {
            $vid = $request->vendor_id;
        } else {
            $vid = '';
        }
        //dd($vid);

        $category = DB::table('sales_categories')->whereNotIn('id',[31,32])->get();
        //dd($category);
        $wirehouses = Factory::all();
        return view('backend.sales_report.catSalesOrderReportView', compact('category', 'datefrom', 'dateto', 'wid','vid', 'wirehouses'));
    }

    public function expasneReportIndex()
    {

        $subgroups = ExpanseSubgroup::all();
        $groups = ExpanseGroup::all();
        $subSubLedgers = DB::table('expanse_sub_subgroups')->get();
      //  dd($groups);
        return view('backend.sales_report.expanse_report_index', compact('subgroups', 'groups','subSubLedgers'));
    }


    public function expasneReport(Request $request)
    {

       $date = $request->date;

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
        $startDate = '2023-10-01';
        if($fdate == '2023-10-01'){
            $predate = "2023-10-01";
            } else {
            $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
            }

        $exp_subgroup = [];
        $exp_sub_subgroup = [];

        $exp_subgroup = $request->subgroup_id;
        $exp_sub_subgroup = $request->subSubLedger_id;

        // $ledger_payments = \App\Models\Payment::whereIn('expanse_subgroup_id', $exp_subgroup)
        //                                 ->leftJoin('expanse_subgroups', 'payments.expanse_subgroup_id', '=', 'expanse_subgroups.id')
        //                                 ->select('payments.*', 'expanse_subgroups.subgroup_name as s_g_name', 'expanse_subgroups.group_name as g_name')
        //                                 ->whereNull('expanse_subSubgroup_id')
        //                                 ->whereBetween('payment_date',[$fdate, $tdate])
        //                                 ->where('status',1)->get()->groupBy('s_g_name')->toArray();
                                        
        // echo "<pre>";
        // print_r($ledger_payments);
        // exit;
          
        
        
        //$expanse_sub_subgroups = DB::table('expanse_sub_subgroups')->whereIn('id', $request->subSubLedger_id)->pluck('group_id')->toArray();
        //$expanse_subgroups = DB::table('expanse_subgroups')->whereIn('id', $request->subgroup_id)->pluck('group_id')->toArray();
        //$group_id = array_unique(array_merge($expanse_sub_subgroups, $expanse_subgroups));
        //$expence_groups = DB::table('expanse_groups')->whereIn('id', $group_id)->get();
        

        //dd($exp_subgroup);
      /*  foreach ($exp_subgroup as $key => $id) {
          $val = ExpanseSubgroup::where('id',$id)->first();
          dd($val);
        }

        if($exp_subgroup){
          $countLedger = count($exp_subgroup);
        } else {
          $countLedger = 0;
        }

        if($exp_sub_subgroup){
          $countSubLedger = count($exp_sub_subgroup);
        } else {
          $countSubLedger = 0;
        }
        */


        return view('backend.sales_report.expanse_report', compact('startDate','predate','fdate', 'tdate', 'exp_subgroup', 'exp_sub_subgroup'));

        /*
         $journalLedger = '';  $journalSubLedger = '';

        $exp_group = $request->group_id;
        $exp_subgroup = $request->subgroup_id;
        $exp_sub_subgroup = $request->subSubLedger_id;

        if(empty($exp_sub_subgroup)) {

        $expanse_group = DB::table('payments as t1')
            ->select('t2.group_id', 't2.group_name')
            ->leftJoin('expanse_subgroups as t2', 't1.expanse_subgroup_id', '=', 't2.id')
            //->whereNotNull('t1.expanse_subSubgroup_id')
            ->whereBetween('t1.payment_date', [$fdate, $tdate]);

        if ($exp_group) {
            $expanse_group = $expanse_group->whereIn('t2.group_id', $exp_group);
        }
        if ($exp_subgroup) {
            $expanse_group = $expanse_group->whereIn('t1.expanse_subgroup_id', $exp_subgroup);


        }

        $expanse_group = $expanse_group->groupBy('t2.group_id')->get();

        if(count($expanse_group) <= 0){

            $expanse_group = JournalEntry::select('e.id as group_id' ,'e.group_name')
                            ->leftjoin('expanse_subgroups as e','journal_entries.ledger_id','=','e.id')
                            ->whereIn('journal_entries.ledger_id',$exp_subgroup)->whereBetween('journal_entries.dc_type',[5,6])
                            ->whereBetween('journal_entries.date', [$fdate, $tdate])->groupby('e.id')->get();
        }

        } else {


             $expanse_group = JournalEntry::select('e.id as group_id' ,'e.group_name')
                            ->leftjoin('expanse_sub_subgroups as e','journal_entries.sub_ledger_id','=','e.id')
                            ->whereBetween('journal_entries.dc_type',[5,6])
                            ->whereBetween('journal_entries.date', [$fdate, $tdate])->groupby('e.id')->get();

             if(count($expanse_group) <= 0){

           $expanse_group = DB::table('payments as t1')
                    ->select('t2.group_id', 't2.group_name')
                    ->leftJoin('expanse_sub_subgroups as t2', 't1.expanse_subSubgroup_id', '=', 't2.id')
                    ->whereBetween('t1.payment_date', [$fdate, $tdate])->wherein('expanse_subSubgroup_id',$exp_sub_subgroup)->groupBy('t2.group_id')->get();
            }
        }
        */

      //dd($expanse_group);

       // dd($exp_sub_subgroup);




        //dd($journalLedger);

        //return view('backend.sales_report.expanse_report', compact('fdate', 'tdate', 'expanse_group', 'exp_group', 'exp_subgroup','exp_sub_subgroup','journalLedger','journalSubLedger'));



      //dd($expanse_group);

       // dd($exp_sub_subgroup);

    }


    public function trailbalanceIndex()
    {

        $areas = DealerArea::All();

        return view('backend.sales_report.trail_balance_index', compact('areas'));
    }


    public function trailbalance(Request $request)
    {
        // dd($request->all());

        $date = $request->date;

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }


        // dd($request);
        // $fdate = $request->from_date;
        // $tdate = $request->to_date;
        $dlr_id = $request->vendor_id;

        $list_type = $request->list_type;

        if ($request->dlr_area_id) {
            $dlr_area = DB::table('dealer_areas')->whereIn('id', $request->dlr_area_id)->orderby('area_title', 'asc')->get();
        } else {
            $dlr_area = DB::table('dealer_areas')->orderby('area_title', 'asc')->get();
        }


        $espanse_group = DB::table('payments as t1')
            ->select('t2.group_id', 't2.group_name')
            ->leftJoin('expanse_subgroups as t2', 't1.expanse_subgroup_id', '=', 't2.id')
            ->whereNotNull('expanse_subgroup_id')
            ->whereBetween('payment_date', [$fdate, $tdate])
            ->groupBy('group_id', 'group_name')
            ->get();
        //dd($espanse_group);



        return view('backend.sales_report.trail_balance', compact('fdate', 'tdate', 'dlr_id', 'dlr_area', 'espanse_group', 'list_type'));
    }



    public function stockReportIndex()
    {

        $wirehouses = Factory::all();
        $products = SalesProduct::orderBy('product_name', 'asc')->get();
        $categories = SalesCategory::whereIN('id',[20,21,27])->orderBy('category_name','asc')->get();
      	$user = Auth::id();
        return view('backend.sales_report.stock_report_index', compact('user','wirehouses', 'products','categories'));
    }


    public function stockReport(Request $request)
    {
        // dd($request->all());
        $date = $request->date;

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        if ($request->warehouse_id) {
            $wirehousedata = DB::table('factories')->whereIn('id', $request->warehouse_id)->orderby('factory_name', 'asc')->get();
        } else {
            $wirehousedata = DB::table('factories')->orderby('factory_name', 'asc')->get();
        }

			if($request->cat_id){
            $products = DB::table('sales_products')->where('category_id', $request->cat_id)->orderby('product_name', 'asc')->get();
              $cat = $request->cat_id;
            }
        elseif ($request->product_id) {
            $products = DB::table('sales_products')->whereIn('id', $request->product_id)->orderby('product_name', 'asc')->get();
            $cat = '';
        } else {
            $products = DB::table('sales_products')->orderby('product_name', 'asc')->get();
            //dd($products);
          $cat = '';
        }
      if ($request->unit) {
		$unit = $request->unit;
      } else {
      $unit = '';
      }
        // dd($wirehousedata);

        return view('backend.sales_report.stock_report', compact('unit','fdate', 'tdate', 'products', 'wirehousedata','cat'));
    }


  public function stockTotalReportIndex()
    {
       $wirehouses = Factory::all();
        $products = SalesProduct::orderBy('product_name', 'asc')->get();
      //  $category = SalesCategory::whereNotIn('category_name',['RM'])->orderBy('category_name', 'asc')->get();
        $category = SalesCategory::orderBy('category_name', 'asc')->get();
        return view('backend.sales_report.stock_total_report_index', compact('wirehouses', 'products','category'));
    }


     public function stockTotalReport(Request $request)
    {
         //dd($request->all());

        $date = $request->date;

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        if ($request->warehouse_id) {
            $wirehousedata = DB::table('factories')->whereIn('id', $request->warehouse_id)->orderby('factory_name', 'asc')->get();
        } else {
            $wirehousedata = DB::table('factories')->orderby('factory_name', 'asc')->get();
        }

          $category =[];
          if($request->cat_id){
            $category = $request->cat_id;
          } else {
            //$cat = SalesCategory::select('id')->whereNotIn('category_name',['RM'])->orderBy('category_name', 'asc')->get();
            $cat = SalesCategory::select('id')->orderBy('category_name', 'asc')->get();
            foreach ($cat as $key => $value) {
             $category[] = $value->id;
            }
          }

          if ($request->product_id) {
            $product = $request->product_id;
          } else {
              $product = '';
          }

      //   dd($category);
       $count = count($category);

        return view('backend.sales_report.stock_total_report', compact('fdate', 'tdate', 'product', 'wirehousedata','category','count'));
    }
    
    public function transferReportIndex()
      {
         $wirehouses = Factory::all();
          $products = SalesProduct::orderBy('product_name', 'asc')->get();
          $category = SalesCategory::orderBy('category_name', 'asc')->get();
          return view('backend.transfer_report.index', compact('wirehouses', 'products','category'));
      }

  public function transferReportView(Request $request){
    //dd($request->all());
    if (isset($request->date)) {
        $dates = explode(' - ', $request->date);
        $fdate = date('Y-m-d', strtotime($dates[0]));
        $tdate = date('Y-m-d', strtotime($dates[1]));
    }

    if($request->wirehouse_id){
        $wirehousedata = Factory::whereIn('id',$request->wirehouse_id)->orderBy('factory_name','DESC')->get();
    } else {
        $wirehousedata = Factory::orderBy('factory_name','DESC')->get();
    }

      $category = [];
      if($request->cat_id){
        $category = $request->cat_id;
      } else {
        //$cat = SalesCategory::select('id')->whereNotIn('category_name',['RM'])->orderBy('category_name', 'asc')->get();
        $cat = SalesCategory::select('id')->orderBy('category_name', 'asc')->get();
        foreach ($cat as $key => $value) {
         $category[] = $value->id;
        }
      }

      if ($request->product_id) {
        $product = $request->product_id;
      } else {
          $product = '';
      }

   $count = count($category);

    return view('backend.transfer_report.report', compact('fdate', 'tdate', 'product', 'wirehousedata','category','count'));


  }
  
  ////////////////////////////////////////////////////////
  public function transferShortSummaryReportIndex()
      {
         $wirehouses = Factory::all();
          $products = SalesProduct::orderBy('product_name', 'asc')->get();
          $category = SalesCategory::orderBy('category_name', 'asc')->get();
          return view('backend.transfer_report.shortSummary.index', compact('wirehouses', 'products','category'));
      }

  public function transferShortSummaryReportView(Request $request){
    //dd($request->all());
    if (isset($request->date)) {
        $dates = explode(' - ', $request->date);
        $fdate = date('Y-m-d', strtotime($dates[0]));
        $tdate = date('Y-m-d', strtotime($dates[1]));
    }

    if($request->wirehouse_id){
        $wirehousedata = Factory::whereIn('id',$request->wirehouse_id)->orderBy('factory_name','DESC')->get();
    } else {
        $wirehousedata = Factory::orderBy('factory_name','DESC')->get();
    }

      $category = [];
      if($request->cat_id){
        $category = $request->cat_id;
      } else {
        //$cat = SalesCategory::select('id')->whereNotIn('category_name',['RM'])->orderBy('category_name', 'asc')->get();
        $cat = SalesCategory::select('id')->orderBy('category_name', 'asc')->get();
        foreach ($cat as $key => $value) {
         $category[] = $value->id;
        }
      }

      if ($request->product_id) {
        $product = $request->product_id;
      } else {
          $product = '';
      }

   $count = count($category);

    return view('backend.transfer_report.shortSummary.report', compact('fdate', 'tdate', 'product', 'wirehousedata','category','count'));


  }
  ////////////////////////////////////////////////////////
    
    public function stockTotalReportView($fdate, $tdate)
    {
            $fdate = date('Y-m-d',  strtotime($fdate));
            $tdate = date('Y-m-d',  strtotime($tdate));
            $wirehousedata = DB::table('factories')->orderby('factory_name', 'asc')->get();
            $cat = SalesCategory::select('id')->orderBy('category_name', 'asc')->get();
            foreach ($cat as $key => $value) {
             $category[] = $value->id;
            }
            $product = '';
            $count = count($category);

        return view('backend.sales_report.stock_total_report_view', compact('fdate', 'tdate', 'product', 'wirehousedata','category','count'));
    }



    public function variousVendorkReportIndex()
    {

        $dealer = Dealer::all();
        $zones = DealerZone::orderby('zone_title')->get();
        $areas = DealerArea::orderby('area_title')->get();

        $dlrtype = DealerType::all();

        return view('backend.sales_report.various_vendor_index', compact('dealer', 'zones', 'areas', 'dlrtype'));
    }


    public function variousVendorReport(Request $request)
    {
        //dd($request->all());

        $date = $request->date;

        if($request->month_year){

            $fdate = $request->month_year."-01";
            //$tdate = $request->month_year."-31";
            $tdate = date("Y-m-t", strtotime($fdate));
            $month_name =  date('F', strtotime($fdate));
        }
       // $zones=DealerZone::all();
    	$dlr_type =DealerType::where('id',$request->dlr_type)->first();

        //dd($dlr_type);
        $zoneID = $request->vendor_zone;
    //  dd($request->vendor_main_zone);
       if($request->vendor_main_zone == ''){

            if($zoneID){

                $zones = DB::table('dealers as t1')
                          ->select('t1.dlr_zone_id','zone_title','main_zone')
                          ->join('dealer_zones as t3','t1.dlr_zone_id','=','t3.id')
                           ->whereIn('t1.dlr_zone_id',$zoneID)
                           ->where('t1.dlr_type_id',$request->dlr_type)
                          ->distinct('dlr_zone_id')
                           ->orderBy(DB::raw('ISNULL(t3.main_zone), t3.main_zone'),'asc')
                      		->orderBy('t3.zone_title','asc')
                          ->get();
            			}else{
                            $zones = DB::table('dealers as t1')
                            ->select('t1.dlr_zone_id','zone_title','main_zone')
                            ->join('dealer_zones as t3','t1.dlr_zone_id','=','t3.id')
                            ->where('t1.dlr_type_id',$request->dlr_type)
                            ->distinct('dlr_zone_id')
                             ->orderBy(DB::raw('ISNULL(t3.main_zone), t3.main_zone'),'asc')
                      		->orderBy('t3.zone_title','asc')
                             ->get();
                  }

         }else{
         	 if($zoneID){

                $zones = DB::table('dealers as t1')
                          ->select('t1.dlr_zone_id','zone_title','main_zone')
                          ->join('dealer_zones as t3','t1.dlr_zone_id','=','t3.id')
                           ->whereIn('t1.dlr_zone_id',$zoneID)
                           ->where('t1.dlr_type_id',$request->dlr_type)
                           ->where('t3.main_zone',$request->vendor_main_zone)
                          ->distinct('dlr_zone_id')
                         	->orderBy('t3.zone_title','asc')
                          ->get();
            }else{
                            $zones = DB::table('dealers as t1')
                            ->select('t1.dlr_zone_id','zone_title','main_zone')
                            ->join('dealer_zones as t3','t1.dlr_zone_id','=','t3.id')
                            ->where('t1.dlr_type_id',$request->dlr_type)
                            ->where('t3.main_zone',$request->vendor_main_zone)
                            ->distinct('dlr_zone_id')
                         	->orderBy('t3.zone_title','asc')
                             ->get();
                  }
         }
            //  dd($zones);

            //dd($dlr_type);
      /*if($request->dlr_type == 9){
        return view('backend.sales_report.vendor_cash_type_sales_report',compact('fdate','tdate','month_name','zones','dlr_type'));
        }
        elseif($request->dlr_type == "3type"){
        $dlr_types = DB::table('dealer_types')->whereIn('id',[11,12,14])->get();



        return view('backend.sales_report.vendor_333type_sales_report',compact('fdate','tdate','month_name','zoneID','dlr_types'));
        }else{
           return view('backend.sales_report.vendor_type_sales_report',compact('fdate','tdate','month_name','zones','dlr_type'));
       }
      */
      return view('backend.sales_report.vendor_type_sales_report',compact('fdate','tdate','month_name','zones','dlr_type'));
    }
       public function yearlyTargetReportIndex()
    {
        $zones = DealerZone::All();
        $areas = DealerArea::All();
        $dealers = Dealer::All();
        $factory = Factory::all();

        //dd($areas);


        return view('backend.sales_report.yearly_sales_target_report_index', compact('zones', 'areas', 'dealers', 'factory'));
    }

    public function yearlyTargetReport(Request $request)
    {
        //dd($request->all());


      if($request->area_id){
      	$areas = DealerArea::whereIn('id',$request->area_id)->get();
      }else{
      	 $areas = DealerArea::All();
      }

      //  $area = $request->area_id;
        $year = $request->year;

      $fdate = "01-01-".$year;
    //    $dealer_opening_balancea = SalesLedger::where('vendor_id', $request->vendor_id)
    //        ->where('warehouse_bank_name', 'Opening Balance')
     //       ->first();
        $stardate = "2023-07-01";

       $predate=date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
   // dd($predate);
      //      $openingpre =  DB::select('SELECT SUM(debit) as debit,SUM(credit) as credit FROM `sales_ledgers`
        //                                WHERE vendor_id = "'.$request->vendor_id.'" AND ledger_date <= "'.$predate.'"');

 //   $dealer_opening_balance = $dealer->dlr_base + $openingpre[0]->debit-$openingpre[0]->credit;


     // dd($areas);






      //dd($qty);

        //       $cdata = DB::table('sales_ledgers as t1')->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id')
      //      ->leftjoin('dealer_areas as t6', 't2.dlr_area_id', '=', 't6.id')
        //    ->leftjoin('dealer_zones as t7', 't2.dlr_zone_id', '=', 't7.id')
        //    ->select(
        //        DB::raw('sum(t1.debit) as `debit`,sum(t1.credit) as credit,sum(t1.qty_pcs) as total_qty,sum(t1.qty_kg) as qty_kg'),
        //        DB::raw('YEAR(ledger_date) year, MONTH(ledger_date) month')
        //     )
        //    ->where('t2.dlr_area_id', $area)
//->whereYear('ledger_date', $year)
        //    ->groupby('year', 'month')
         //   ->orderBy('month', 'asc')
         //   ->get();

       $categorys = SalesCategory::all();

        return view('backend.sales_report.yearly_sales_target_report', compact('areas', 'year','categorys'));
    }

  public function zonewisepiechartIndex()
    {

        $areas = DealerArea::All();

        return view('backend.sales_report.zonewise_pie_chart_index', compact('areas'));
    }


    public function zonewisepiechart(Request $request)
    {

 		 if (isset($request->date)) {
         	$fdate = $request->date . "-01";
            //$tdate = $request->month_year."-31";
            $tdate = date("Y-m-t", strtotime($fdate));
            $month_name =  date('F', strtotime($fdate));
           $month =date('m', strtotime($request->date));
           $year =date('Y', strtotime($request->date));
         }


      $zonedata = DB::table('sales_ledgers as t1')
            // ->leftjoin('sales as t1','t1.id','t5.sale_id')
            ->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id')
            ->leftjoin('dealer_areas as t6', 't2.dlr_area_id', '=', 't6.id')
            ->leftjoin('dealer_zones as t7', 't2.dlr_zone_id', '=', 't7.id')
            ->leftjoin('factories as t3', 't1.warehouse_bank_id', '=', 't3.id')
            ->leftjoin('sales_products as t4','t1.product_id','=','t4.id')
            ->orderBy('t7.zone_title', 'asc');



        if (isset($request->dlr_zone_id)) {
            $dlr_zone_id = $request->dlr_zone_id;

            $zonedata = $zonedata->where('t2.dlr_zone_id', $request->dlr_zone_id);
        }
        if (isset($request->dlr_area_id)) {
            $dlr_area_id = $request->dlr_area_id;
            $zonedata = $zonedata->whereIn('t2.dlr_area_id', $dlr_area_id);
        }

        $zonedata = $zonedata->select(
            't7.zone_title as zone',
            't2.dlr_zone_id',
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `qty_kg`/1000 ELSE null END) as current_sale'),
             DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `debit` ELSE null END) as current_debit'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `credit` ELSE null END) as current_credit')

        )
            ->whereNotNull('t7.zone_title')->whereNotNull('t1.debit')->groupBy('t2.dlr_zone_id')->get();


    //  dd( $zonedata );

      $zonedataall = DB::table('sales_ledgers as t1')
            // ->leftjoin('sales as t1','t1.id','t5.sale_id')
            ->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id')
            ->leftjoin('dealer_areas as t6', 't2.dlr_area_id', '=', 't6.id')
            ->leftjoin('dealer_zones as t7', 't2.dlr_zone_id', '=', 't7.id')
            ->leftjoin('factories as t3', 't1.warehouse_bank_id', '=', 't3.id')
            ->leftjoin('sales_products as t4','t1.product_id','=','t4.id');


        if (isset($request->dlr_zone_id)) {
            $dlr_zone_id = $request->dlr_zone_id;

            $zonedataall = $zonedataall->where('t2.dlr_zone_id', $request->dlr_zone_id);
        }
        if (isset($request->dlr_area_id)) {
            $dlr_area_id = $request->dlr_area_id;
            $zonedataall = $zonedataall->whereIn('t2.dlr_area_id', $dlr_area_id);
        }

        $zonedataall = $zonedataall->select(
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `qty_kg`/1000 ELSE null END) as current_sale'),
             DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `debit` ELSE null END) as current_debit'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `credit` ELSE null END) as current_credit'),


        )
           ->get();




       $categoryzonedata = DB::table('sales_ledgers as t1')
            // ->leftjoin('sales as t1','t1.id','t5.sale_id')
            ->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id')
            ->leftjoin('dealer_areas as t6', 't2.dlr_area_id', '=', 't6.id')
            ->leftjoin('dealer_zones as t7', 't2.dlr_zone_id', '=', 't7.id')
             ->leftjoin('sales_products as t4','t1.product_id','=','t4.id')
            ->leftjoin('sales_categories as t9','t4.category_id','=','t9.id')
            ->orderBy('t7.zone_title', 'asc')
            ->orderBy('t1.product_name', 'asc');


        if (isset($request->dlr_zone_id)) {
            $dlr_zone_id = $request->dlr_zone_id;

            $categoryzonedata = $categoryzonedata->where('t2.dlr_zone_id', $request->dlr_zone_id);
        }
        if (isset($request->dlr_area_id)) {
            $dlr_area_id = $request->dlr_area_id;
            $categoryzonedata = $categoryzonedata->whereIn('t2.dlr_area_id', $dlr_area_id);
        }

        $categoryzonedata = $categoryzonedata->select(
            't1.product_id',
            't1.product_name',
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `qty_kg`/1000 ELSE null END) as current_sale'),
             DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `debit` ELSE null END) as current_debit'),
            DB::raw('sum(CASE WHEN MONTH(t1.ledger_date)  = "' . $month . '" AND YEAR(t1.ledger_date) = "' . $year . '" THEN `credit` ELSE null END) as current_credit'),


        )
            ->whereNotNull('t7.zone_title')->groupBy('t1.product_id')->get();


      $categorys = SalesCategory::all();


      $data = [];
//dd($productzonedata);

        return view('backend.sales_report.zonewise_pie_chart', compact('fdate', 'tdate', 'zonedata','month_name','zonedataall','categorys'));
    }




   public function SalesYearlyShortsummaryTargetReport(){



         $areas=DB::table('dealer_areas as t1')
            ->select('t1.*','t2.*')
            ->join('dealers as t2','t1.id','=','t2.dlr_area_id')
            ->get();
            $areas=$areas->unique('dlr_area_id')->all();
        //  dd($areas);
         $dealer = Dealer::all();
         $zones=DealerZone::all();

      //  $main_zones =  DB::table('dealer_zones')->distinct('main_zone')->pluck('main_zone');
         //dd($main_zones);


         $cashdealer = Dealer::where('dlr_type_id',9)->get();


        // dd($sales);
        return view('backend.sales_report.yearly_short_summary_target_report_input',  compact('dealer','zones','areas','cashdealer'));
     }


     public function postSalesYearlyShortsummaryTargetReport(Request $request){
        //  $cyear = date('Y');
        //  $cmonth = date('m');




        $categorys = DB::table('sales_categories')->get();

             if($request->dlr_area_id){
                $areas = DealerArea::whereIn('id',$request->dlr_area_id)->get();
              }else{
                 $areas = DealerArea::All();
              }


              if($request->year){
            	$year = $request->year;
            }else{
              $year = date('Y');
            }

              // dd($salesArea);
     // return view('salesReport.yearly_short_summary_target_report_list', compact('cash_dlr_id','product_categorys','data','zones','areas','fdate','tdate','month_name','areaId','zoneID'));
      return view('backend.sales_report.yearly_short_summary_target_report_list', compact('categorys','areas','year'));

     }


      public function SalesYearlyShortsummaryCompanyReport(){




        return view('backend.sales_report.yearly_short_summary_company_report_input');
     }


     public function postSalesYearlyShortsummaryCompanyReport (Request $request){
        //  $cyear = date('Y');
        //  $cmonth = date('m');




        $categorys = DB::table('sales_categories')->get();

             if($request->dlr_area_id){
                $areas = DealerArea::whereIn('id',$request->dlr_area_id)->get();
              }else{
                 $areas = DealerArea::All();
              }


              if($request->year){
            	$year = $request->year;
            }else{
              $year = date('Y');
            }

              // dd($salesArea);
     // return view('salesReport.yearly_short_summary_target_report_list', compact('cash_dlr_id','product_categorys','data','zones','areas','fdate','tdate','month_name','areaId','zoneID'));
      return view('backend.sales_report.yearly_short_summary_company_report_list', compact('categorys','areas','year'));

     }

  	public function ReportsIndex()
    {
      return view('backend.sales_report.quick_reports_index');
    }
    



  public function toptendealerreportindex()
    {
        $zones = DealerZone::All();
        $areas = DealerArea::All();
        $dealers = Dealer::All();
        $factory = Factory::all();

        $categorys = SalesCategory::orderBy('id', 'desc')->get();

        return view('backend.sales_report.toptenreportindex', compact('zones', 'areas', 'dealers', 'factory', 'categorys'));
    }


      public function toptendealerreportpiechart(Request $request)
    {

 		 if (isset($request->date)) {
         	   $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
         }


      $zonedata = DB::table('sales_ledgers as t1')
            // ->leftjoin('sales as t1','t1.id','t5.sale_id')
            ->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id');


        $zonedata = $zonedata->select(
            't2.d_s_name',
            't1.vendor_id',
            DB::raw('sum(CASE WHEN t1.ledger_date between    "' . $fdate . '" AND  "' . $tdate . '" THEN `qty_kg`/1000 ELSE null END) as current_sale'),
             DB::raw('sum(CASE WHEN t1.ledger_date between    "' . $fdate . '" AND  "' . $tdate . '" THEN `debit` ELSE null END) as current_debit'),
            DB::raw('sum(CASE WHEN t1.ledger_date between    "' . $fdate . '" AND  "' . $tdate . '" THEN `credit` ELSE null END) as current_credit'),


        )
            ->whereNotNull('t2.d_s_name')->groupBy('t1.vendor_id')
            ->orderBy('current_sale', 'desc')->take(10)->get();


    //  dd( $zonedata );



        return view('backend.sales_report.toptenreport', compact('fdate', 'tdate', 'zonedata',));
    }

  	public function vendorsalessummaryreport()
    {
       	$areas = DealerArea::All();
      	$delartype = DealerType::All();
      	return view('backend.sales_report.vendor_sales_summary_report_input',compact('areas','delartype'));
    }

  	public function vendorsalessummaryreportview(Request $request)
    {
       	if (isset($request->date)) {
         	$dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
         }


        $delar = $request->dlr_type;

         if($request->dlr_area_id == ''){
              $areas = DealerArea::all();
        }else{
              $areas = DealerArea::whereIn('id',$request->dlr_area_id)->get();
        }


      	return view('backend.sales_report.vendor_sales_summary_report_input_view',compact('delar','areas','fdate','tdate'));

    }


  public function salesprogressreportindividual()
    {
       	$areas = DealerArea::All();
      	$delartype = DealerType::All();
      	return view('backend.sales_report.sales_progress_report_individual_input',compact('areas','delartype'));
    }

  	public function salesprogressreportindividualview(Request $request)
    {
       	if (isset($request->date)) {
         	$dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
         }


          $predate=date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
                                     $sdate = "2023-07-01";

                                        //$dealerData =  DB::table('dealers')->where('dlr_area_id',$area->id)->get();
                                      //  $dealerData =  DB::select('SELECT * FROM `dealers`
                                   	    //    			WHERE dlr_area_id = "'.$area->id.'" ');

                                        $dealerData =  DB::select('SELECT dealers.id,dealers.d_s_name,dealers.dlr_base,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$sdate.'" AND "'.$predate.'" THEN `debit` ELSE null END) as debit_a,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$sdate.'" AND "'.$predate.'" THEN `credit` ELSE null END) as credit_a,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit,
                                        sum(CASE WHEN sales_ledgers.ledger_date BETWEEN "'.$fdate.'" AND "'.$tdate.'" THEN `qty_kg` ELSE null END) as qty_kg
                                        FROM `sales_ledgers`
                                        LEFT JOIN dealers ON dealers.id = sales_ledgers.vendor_id
                                        GROUP BY dealers.id');

     //   dd($dealerData);

      	return view('backend.sales_report.sales_progress_report_individual_view',compact('dealerData','fdate','tdate'));

    }
   public function stocktrunoverreport()
    {

        $wirehouses = Factory::all();
        $products = SalesProduct::orderBy('product_name', 'asc')->get();


        return view('backend.sales_report.stock_trunover_report_index', compact('wirehouses', 'products'));
    }


    public function stocktrunoverreportview(Request $request)
    {
       //  dd($request->all());

        $date = $request->date;

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }




  $stock_ins = SalesStockIn::select('sales_stock_ins.*','sales_products.product_name','factories.factory_name','production_factories.factory_name as pfname')
            ->leftjoin('sales_products', 'sales_products.id', 'sales_stock_ins.prouct_id')
            ->leftjoin('factories', 'factories.id', 'sales_stock_ins.factory_id')
            ->leftjoin('production_factories', 'production_factories.id', 'sales_stock_ins.production_factory_id')
->whereNotNull('expire_date')
    ->whereBetween('date',[$fdate,$tdate])
            ->get();

         //dd($stock_ins);

      	$transfers = Transfer::select('transfers.*','sales_products.product_name')
			->leftjoin('sales_products', 'sales_products.id', 'transfers.product_id')
        	->whereBetween('date',[$fdate,$tdate])
        	->get();


		//dd($transfers);
        return view('backend.sales_report.stock_trunover_report', compact('fdate', 'tdate', 'stock_ins','transfers'));
    }


   public function fiscalyearreportindex()
    {

        $wirehouses = Factory::all();
        $products = SalesProduct::orderBy('product_name', 'asc')->get();


        return view('backend.sales_report.fiscal_year_report_index', compact('wirehouses', 'products'));
    }


    public function fiscalyearreport(Request $request)
    {
       //  dd($request->all());

        $date = $request->date;

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }


		$zones = DealerZone::all();
//dd($zones);
  $stock_ins = SalesStockIn::select('sales_stock_ins.*','sales_products.product_name','factories.factory_name','production_factories.factory_name as pfname')
            ->leftjoin('sales_products', 'sales_products.id', 'sales_stock_ins.prouct_id')
            ->leftjoin('factories', 'factories.id', 'sales_stock_ins.factory_id')
            ->leftjoin('production_factories', 'production_factories.id', 'sales_stock_ins.production_factory_id')
->whereNotNull('expire_date')
    ->whereBetween('date',[$fdate,$tdate])
            ->get();

         //dd($stock_ins);

      	$transfers = Transfer::select('transfers.*','sales_products.product_name')
			->leftjoin('sales_products', 'sales_products.id', 'transfers.product_id')
        	->whereBetween('date',[$fdate,$tdate])
        	->get();


		//dd($transfers);
        return view('backend.sales_report.fiscal_year_report', compact('fdate', 'tdate', 'stock_ins','transfers','zones'));
    }


   public function fiscalyearComparisonreportindex()
    {

        $wirehouses = Factory::all();
        $products = SalesProduct::orderBy('product_name', 'asc')->get();


        return view('backend.sales_report.fiscal_year_Comparison_report_index', compact('wirehouses', 'products'));
    }


    public function fiscalyearComparisonreport(Request $request)
    {
       //  dd($request->all());

        $date = $request->date;

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }


		$zones = DealerZone::all();
//dd($zones);
  $stock_ins = SalesStockIn::select('sales_stock_ins.*','sales_products.product_name','factories.factory_name','production_factories.factory_name as pfname')
            ->leftjoin('sales_products', 'sales_products.id', 'sales_stock_ins.prouct_id')
            ->leftjoin('factories', 'factories.id', 'sales_stock_ins.factory_id')
            ->leftjoin('production_factories', 'production_factories.id', 'sales_stock_ins.production_factory_id')
->whereNotNull('expire_date')
    ->whereBetween('date',[$fdate,$tdate])
            ->get();

         //dd($stock_ins);

      	$transfers = Transfer::select('transfers.*','sales_products.product_name')
			->leftjoin('sales_products', 'sales_products.id', 'transfers.product_id')
        	->whereBetween('date',[$fdate,$tdate])
        	->get();


		//dd($transfers);
        return view('backend.sales_report.fiscal_Comparison_year_report', compact('fdate', 'tdate', 'stock_ins','transfers','zones'));
    }






  public function toptendealerDreportindex()
    {
        $zones = DealerZone::All();
        $areas = DealerArea::All();
        $dealers = Dealer::All();
        $factory = Factory::all();

        $categorys = SalesCategory::orderBy('id', 'desc')->get();

        return view('backend.sales_report.othertoptenreportindex', compact('zones', 'areas', 'dealers', 'factory', 'categorys'));
    }


      public function toptendealerDreport(Request $request)
    {

 		 if (isset($request->date)) {
         	   $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
         }


      $zonedata = DB::table('sales_ledgers as t1')
            // ->leftjoin('sales as t1','t1.id','t5.sale_id')
            ->leftjoin('dealers as t2', 't1.vendor_id', '=', 't2.id');


        $zonedata = $zonedata->select(
            't2.d_s_name',
            't1.vendor_id',
            DB::raw('sum(CASE WHEN t1.ledger_date between    "' . $fdate . '" AND  "' . $tdate . '" THEN `qty_kg`/1000 ELSE null END) as current_sale'),
             DB::raw('sum(CASE WHEN t1.ledger_date between    "' . $fdate . '" AND  "' . $tdate . '" THEN `debit` ELSE null END) as current_debit'),
            DB::raw('sum(CASE WHEN t1.ledger_date between    "' . $fdate . '" AND  "' . $tdate . '" THEN `credit` ELSE null END) as current_credit'),


        )
            ->whereNotNull('t2.d_s_name')->groupBy('t1.vendor_id')
            ->orderBy('current_sale', 'desc')->take(10)->get();


    //  dd( $zonedata );



        return view('backend.sales_report.othertoptenreport', compact('fdate', 'tdate', 'zonedata',));
    }


   public function productComparisonIndex()
    {

        $wirehouses = Factory::all();
        $products = SalesProduct::orderBy('product_name', 'asc')->get();


        return view('backend.sales_report.product_comparison_report_index', compact('wirehouses', 'products'));
    }


    public function productComparisonReport(Request $request)
    {
        // dd($request->all());

        $date = $request->date;

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }



        if ($request->warehouse_id) {
            $wirehousedata = DB::table('factories')->whereIn('id', $request->warehouse_id)->orderby('factory_name', 'asc')->get();
        } else {
            $wirehousedata = DB::table('factories')->orderby('factory_name', 'asc')->get();
        }


        if ($request->product_id) {
            $products = DB::table('sales_products')->whereIn('id', $request->product_id)->orderby('product_name', 'asc')->get();
        } else {
            $products = DB::table('sales_products')->orderby('product_name', 'asc')->get();
        }

        // dd($wirehousedata);
        return view('backend.sales_report.product_comparison_report', compact('fdate', 'tdate', 'products', 'wirehousedata'));
    }



    public function mrsalesReportIndex()
    {

        $dealer = Dealer::all();
        $zones = DealerZone::orderby('zone_title')->get();
        $areas = DealerArea::orderby('area_title')->get();

        $cashdealer = Dealer::where('dlr_type_id', 9)->get();

        return view('backend.sales_report.monthly_employee_target_index', compact('dealer', 'zones', 'areas', 'cashdealer'));
    }



    public function mrsalesReport(Request $request)
    {
        //  $cyear = date('Y');
        //  $cmonth = date('m');
        // dd($request->all());

 		if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }



        // dd($request);
        $areaId = $request->dlr_area_id;

        $zoneID = $request->vendor_zone;


        $areas = DB::table('montly_sales_targets as t1')
            ->select('t1.area_id', 't4.area_title')
            ->join('dealer_areas as t4', 't1.area_id', '=', 't4.id')
            ->whereBetween('date', [$fdate, $tdate])
            ->whereNotNUll('area_id')
            ->distinct('area_id')
            ->get();

        $zones = DB::table('montly_sales_targets as t1')
            ->select('t1.zone_id', 't4.zone_title', 't4.main_zone')
            ->join('dealer_zones as t4', 't1.zone_id', '=', 't4.id')
            ->whereBetween('date', [$fdate, $tdate])
            ->whereNotNUll('zone_id')
            ->distinct('zone_id');
        if ($request->vendor_main_zone != '') {
            $zones->where('t4.main_zone', $request->vendor_main_zone);
        }

        if ($request->vendor_zone) {
            $zones->whereIn('t1.zone_id', $request->vendor_zone);
        }
        if ($request->dlr_area_id) {
            $zones->whereIn('t1.area_id', $request->dlr_area_id);
        }
        if ($request->cash_dlr_id) {
            $zones->whereIn('t1.dealer_id', $request->cash_dlr_id);
        }

        $zones = $zones->orderBy(DB::raw('ISNULL(t4.main_zone), t4.main_zone'), 'asc')
            ->orderBy('t4.zone_title', 'asc')
            ->get();



        $data = array();

        foreach ($zones as $key => $zone) {
            $ddd = DB::table('montly_sales_targets as t1')
                ->select('t1.area_id', 't4.area_title')
                ->join('dealer_areas as t4', 't1.area_id', '=', 't4.id')
                ->whereBetween('date', [$fdate, $tdate])
                ->where('zone_id', $zone->zone_id)
                ->distinct('area_id');
            //     ->get();
            //  dd($request->warehouse_id);
            if ($request->dlr_area_id) {
                $ddd->whereIn('t1.area_id', $request->dlr_area_id);
            }
            if ($request->cash_dlr_id) {
                $ddd->whereIn('t1.dealer_id', $request->cash_dlr_id);
            }

            $data[$zone->zone_id]  = $ddd->orderBy('area_title', 'ASC')->get();
        }


        //dd($zones);

        $product_categorys = DB::table('sales_products as t1')
            ->select('t1.category_id', 't2.category_name')
            ->join('sales_categories as t2', 't1.category_id', '=', 't2.id')
            ->orderBy('category_id')
            ->distinct('category_id')

            ->get();

       //  dd($product_categorys);
        // return view('salesReport.monthly_target_report_list', compact('zones','product_categorys','areas','fdate','tdate','month_name','areaId','dlr_area_id','zoneID','main_zzz'));
        return view('backend.sales_report.monthly_employee_target_report', compact('year', 'product_categorys', 'data', 'zones', 'areas', 'fdate', 'tdate', 'month_name', 'areaId', 'zoneID'));
    }

  public function empSalesOrderReportIndex(){
   $dealerArea = DealerArea::all();
    return view('backend.sales_report.emp_sales_order_report_index', compact('dealerArea'));
  }
   public function empSalesOrderReportView(Request $request){
     //dd($request->all());
     if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

     if ($request->area_id) {
       $areas = SalesOrder::select('vendor_area_id as id')->whereIn('vendor_area_id',$request->area_id)->whereBetween('date', [$fdate, $tdate])->groupBy('vendor_area_id')->get();
       return view('backend.sales_report.emp_sales_order_report_view', compact('areas','fdate', 'tdate'));
     } else {
        $areas = SalesOrder::select('vendor_area_id as id')->whereNotNull('vendor_area_id')->whereBetween('date', [$fdate, $tdate])->groupBy('vendor_area_id')->get();
       return view('backend.sales_report.emp_sales_order_report_view', compact('areas', 'fdate', 'tdate'));
     }

   }

  public function empOrderDeliveryReportIndex(){
   $dealerArea = DealerArea::all();
    return view('backend.sales_report.emp_sales_order_delivery_report_index', compact('dealerArea'));
  }

   public function empOrderDeliveryReportView(Request $request){
     //dd($request->all());
     if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

     if ($request->area_id) {
       $areas = SalesOrder::join('dealer_areas','vendor_area_id','=','dealer_areas.id' )->select('vendor_area_id as id','dealer_areas.area_title as name')->whereIn('vendor_area_id',$request->area_id)->whereBetween('date', [$fdate, $tdate])->groupBy('vendor_area_id')->orderBy('dealer_areas.area_title', 'ASC')->get();
      // dd($areas);
       return view('backend.sales_report.emp_sales_order_delivery_report_view', compact('areas','fdate', 'tdate'));
     } else {
        $areas = SalesOrder::join('dealer_areas','vendor_area_id','=','dealer_areas.id' )->select('vendor_area_id as id','dealer_areas.area_title as name')->whereNotNull('vendor_area_id')->whereBetween('date', [$fdate, $tdate])->groupBy('vendor_area_id')->orderBy('dealer_areas.area_title', 'ASC')->get();
       return view('backend.sales_report.emp_sales_order_delivery_report_view', compact('areas', 'fdate', 'tdate'));
     }

   }


  public function empSalesDetailsReportIndex(){
   $dealerArea = DealerArea::all();
    return view('backend.sales_report.emp_sales_details_report_index', compact('dealerArea'));
  }


	public function empSalesDetailsReportView(Request $request){
     //dd($request->all());
     if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

     if ($request->area_id) {
      $areas = SalesOrder::join('dealer_areas','vendor_area_id','=','dealer_areas.id' )->select('vendor_area_id as id','dealer_areas.area_title as name')->whereIn('vendor_area_id',$request->area_id)->whereBetween('date', [$fdate, $tdate])->groupBy('vendor_area_id')->orderBy('dealer_areas.area_title', 'ASC')->get();
      // dd($areas);
       return view('backend.sales_report.emp_sales_details_report_view', compact('areas','fdate', 'tdate'));
     } else {
      $areas = SalesOrder::join('dealer_areas','vendor_area_id','=','dealer_areas.id' )->select('vendor_area_id as id','dealer_areas.area_title as name')->whereNotNull('vendor_area_id')->whereBetween('date', [$fdate, $tdate])->groupBy('vendor_area_id')->orderBy('dealer_areas.area_title', 'ASC')->get();
       return view('backend.sales_report.emp_sales_details_report_view', compact('areas', 'fdate', 'tdate'));
     }

   }
  public function dealerSalesIndex(){
  	 	$dealers = Dealer::All();
        /*$factory = Factory::all();
        $products = SalesProduct::all();
        $categorys = SalesCategory::orderBy('id', 'desc')->get(); */
        return view('backend.sales_report.dealer_sales_report_index', compact('dealers'));
  }
  public function dealerSalesReport(Request $request){
  //dd($request->all());
     if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

     if ($request->dealer_id) {
       $dealers = SalesLedger::join('dealers', 'sales_ledgers.vendor_id', '=', 'dealers.id')->select('sales_ledgers.vendor_id','dealers.d_s_name as name')->whereIn('vendor_id',$request->dealer_id)->whereBetween('ledger_date', [$fdate, $tdate])->groupBy('vendor_id')->orderBy('dealers.d_s_name', 'ASC')->get();
      // dd($dealers);
       return view('backend.sales_report.dealer_sales_report_view', compact('dealers','fdate', 'tdate'));
     } else {
       $dealers = SalesLedger::join('dealers', 'sales_ledgers.vendor_id', '=', 'dealers.id')->select('sales_ledgers.vendor_id','d_s_name as name')->whereNotNull('vendor_id')->whereBetween('ledger_date', [$fdate, $tdate])->groupBy('vendor_id')->orderBy('dealers.d_s_name', 'ASC')->get();
       return view('backend.sales_report.dealer_sales_report_view', compact('dealers', 'fdate', 'tdate'));
     }

  }
  public function salesDiscountReport(){
    return view('backend.sales_report.salesDiscountIndex');
  }

  public function salesDiscountReportView(Request $request){
  //  dd($request->all());

    if (isset($request->date)) {
        $dates = explode(' - ', $request->date);
        $fdate = date('Y-m-d', strtotime($dates[0]));
        $tdate = date('Y-m-d', strtotime($dates[1]));
    }

    $dealers = SalesLedger::select('warehouse_bank_id','vendor_id')->where('discount_amount', '>', 0)->whereBetween('ledger_date',[$fdate, $tdate])->groupBy('vendor_id')->get();
    return view('backend.sales_report.salesDiscountReportView', compact('fdate', 'tdate', 'dealers'));
  }
}
