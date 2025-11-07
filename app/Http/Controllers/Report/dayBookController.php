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
use App\Models\SalesLedger;
use App\Models\CommissionIn;
use App\Models\DealerDelete;
use App\Models\ExpanseGroup;
use App\Models\DealerSubzone;
use App\Models\SalesCategory;
use App\Models\TransportCost;
use App\Models\ExpanseSubgroup;
use App\Models\YearlyIncentive;
use App\Models\SalesProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class dayBookController extends Controller
{
	public function index(){
    	return view('backend.day_book.daybookindex');
    }
  
  	public function viewreport(Request $request)
    {
    	//($request->date);
      $tdate = $request->date;
      $totalsalesamount = DB::table('sales')->where('is_active',1)->where('date',$request->date)->sum('grand_total');
      $totalsalesreturnamount = DB::table('sales_returns')->where('date',$request->date)->sum('grand_total');
      $totalpurchase =  DB::table('purchases')->where('date',$request->date)->where('purchas_unit',null)->sum('total_payable_amount');
      $totalpurchaseinbag =  DB::table('purchases')->where('date',$request->date)->where('purchas_unit','bag')->sum('total_payable_amount');
      $generalpurchase = DB::table('general_purchases')->where('date',$request->date)->sum('total_value');
      $purchasereturn = DB::table('purchase_returns')->where('date',$request->date)->sum('total_amount');
      $bankreceivedamount = DB::table('payments')->where('status',1)->where('payment_date',$request->date)->where('payment_type','RECEIVE')->where('type','BANK')->sum('amount');
      $bankpaymentamount = DB::table('payments')->where('status',1)->where('payment_date',$request->date)->where('payment_type','PAYMENT')->where('type','BANK')->sum('amount');
      $cashreceivedamount = DB::table('payments')->where('status',1)->where('payment_date',$request->date)->where('payment_type','RECEIVE')->where('type','CASH')->sum('amount');
      $cashpaymentamount = DB::table('payments')->where('status',1)->where('payment_date',$request->date)->where('payment_type','PAYMENT')->where('type','CASH')->sum('amount');
      
      $generalbankpaymentreceive = DB::table('payments')->where('status',1)->where('payment_date',$request->date)->where('payment_type','COLLECTION')->where('type','BANK')->sum('amount');
      $generalcashpaymentreceive = DB::table('payments')->where('status',1)->where('payment_date',$request->date)->where('payment_type','COLLECTION')->where('type','CASH')->sum('amount');
      
      $trnasferpyamentamount = DB::table('payments')->where('status',1)->where('payment_date',$request->date)->where('payment_type','TRANSFER')->where('transfer_type','PAYMENT')->sum('amount');
      $trnasferreceiveamount = DB::table('payments')->where('status',1)->where('payment_date',$request->date)->where('payment_type','TRANSFER')->where('transfer_type','RECEIVE')->sum('amount');
      
      
      $totalexpance = DB::table('payments')->where('payment_date',$request->date)->where('payment_type','EXPANSE')->where('status',1)->sum('amount');
      $totasset = DB::table('assets')->where('date',$request->date)->sum('asset_value');
      $totassetpayment = DB::table('assets')->where('date',$request->date)->sum('payment_value');
      $journaldramount = DB::table('journal_entries')->where('date',$request->date)->sum('debit');
      $journalcramount = DB::table('journal_entries')->where('date',$request->date)->sum('credit');
      
      return view('backend.day_book.daybookreportview',compact('journalcramount','trnasferpyamentamount','trnasferreceiveamount',
                                                               'journaldramount','totalsalesamount','totalsalesreturnamount','totalpurchaseinbag',
                                                               'generalpurchase','totalpurchase','purchasereturn','bankpaymentamount',
                                                               'cashreceivedamount','cashpaymentamount','bankreceivedamount','totalexpance',
                                                               'totasset','totassetpayment','tdate','generalbankpaymentreceive',
                                                               'generalcashpaymentreceive'));
      
    }

}
