<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\Dealer;
use App\Models\Payment;
use App\Models\Factory;
use App\Models\SalesCategory;
use App\Models\RowMaterialsProduct;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

class LayoutController extends Controller
{
  
  public function salesdashboard()
    {
    $userId = Auth::id();
     $month12datasales = Sale::select([
                              DB::raw("DATE_FORMAT(date, '%Y') year"),
                              DB::raw("DATE_FORMAT(date, '%m') month"),
                              DB::raw("SUM(total_qty) total_qty"),
                              DB::raw("SUM(grand_total) total_value")
                          ])->where('is_active',1)->groupBy('year')->groupBy('month')->orderby('month','asc')->take(12)->get();   
      $arraycountsales = count($month12datasales);
        $month12datarcv = Payment::select([
                              DB::raw("DATE_FORMAT(payment_date, '%Y') year"),
                              DB::raw("DATE_FORMAT(payment_date, '%m') month"),
                              DB::raw("SUM(amount) amount")
                           
                          ])->where('status',1)->where('payment_type',"RECEIVE")->where('payment_date','>','2021-01-01')->groupBy('year')->groupBy('month')->orderby('month','asc')->take($arraycountsales)->get();   
  
    
     	  	

        return view('backend.dashboard.sales_dashboard', compact('userId','month12datasales','month12datarcv'));
    
    	//return view('backend.dashboard.sales_dashboard');
    
    
    }
  public function purchasedeshboard()
  {
    $products = RowMaterialsProduct::whereIN('unit', ['Kg','LITRE'])->orderBy('product_name', 'ASC')->get();
    $fdate = '2023-07-01';
    $now = new Carbon();
    $tdate = date("Y-m-d", strtotime($now));
    $mydate = Purchase::orderBy('date','asc')->value('date');
        if($mydate){
          $sdate = Purchase::orderBy('date','asc')->first()->date;
        } else {
          $sdate = $fdate;
        } 
    $pdate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
    
  	return view('backend.dashboard.purchase_dashboard',compact('products','fdate','tdate','sdate','pdate'));
  }
  
  public function accountdashboard()
  {
  	return view('backend.dashboard.account_dashboard');
  }
  
    public function settingsdashboard()
  {
  	return view('backend.user.password_change');
  }
  
  public function crmdashboard()
  {
  	return view('backend.dashboard.crm_dashboard');
  }
  
  public function hrPayrollDashBoard()
  {
  	return view('backend.dashboard.hrPayroll_dashboard');
  }
  
  public function tenderBiddingDashBoard()
  {
  	return view('backend.dashboard.tenderBidding_dashboard');
  }
  
  
}
