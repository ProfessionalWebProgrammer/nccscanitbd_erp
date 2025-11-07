<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\Dealer;
use App\Models\Payment;
use App\Models\Factory;
use App\Models\Purchase;
use App\Models\PurchaseLedger;
use App\Models\SalesLedger;
use App\Models\SalesStockIn;
use App\Models\Account\ChartOfAccounts;
use App\Models\FinishGoodsPurchase;
use App\Traits\TrailBalance;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     use TrailBalance;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
      public function index()
    {

      $fromDay="2023-10-01";
      $totalAcPayable = 0;
      $totalRawStock = 0;
      $totalFgStock = 0;
      $totalAcReceivable = 0;
      //$fromDay=date('Y-m-d');
      
      $today=date('Y-m-d');

    /* $today_sales = DB::select('SELECT COUNT(id) as total_invoice, SUM(total_qty) as total_qty,SUM(grand_total) as total_price FROM `sales`
            					WHERE sales.is_active=1 AND sales.date = "'.$today.'"');
      $today_sales_kg = DB::select('SELECT SUM(qty_kg) as qty_kg FROM `sales_ledgers`
            					WHERE ledger_date = "'.$today.'"');

       $today_fg_si = DB::select('SELECT COUNT(id) as total_invoice, SUM(quantity) as total_qty, SUM(total_cost) as totalAmount FROM `sales_stock_ins`
            					WHERE date = "'.$today.'"');

      $total_sales = DB::select('SELECT COUNT(id) as total_invoice, SUM(total_qty) as total_qty,SUM(grand_total) as total_price FROM `sales`
            					WHERE sales.is_active=1 ');
       $total_fg_si = DB::select('SELECT COUNT(id) as total_invoice, SUM(quantity) as total_qty, SUM(total_cost) as totalAmount FROM `sales_stock_ins`  ');

      $today_purchase = DB::select('SELECT COUNT(purchase_id) as total_invoice, SUM(bill_quantity) as total_qty,SUM(total_payable_amount) as total_price FROM `purchases`
                        WHERE date = "'.$today.'"');
      $todayFgPurchase = FinishGoodsPurchase::where('date',$today)->sum('total_purchase_amount');

      $today_rm_so = DB::select('SELECT COUNT(id) as total_invoice, SUM(stock_out_quantity) as total_qty, SUM(total_amount) as totalAmount FROM `purchase_stockouts`
            					WHERE date = "'.$today.'"');
       $total_rm_si = DB::select('SELECT COUNT(purchase_id) as total_invoice, SUM(bill_quantity) as total_qty,SUM(total_payable_amount) as total_price FROM `purchases`');
       $total_rm_so = DB::select('SELECT COUNT(id) as total_invoice, SUM(stock_out_quantity) as total_qty, SUM(total_amount) as totalAmount FROM `purchase_stockouts`');


        $today_bank_rcv = DB::select('SELECT COUNT(id) as total_invoice,SUM(amount) as total_amount FROM `payments`
            					WHERE payments.status=1 AND payments.payment_type="RECEIVE" AND payments.type="BANK" AND payments.payment_date = "'.$today.'"');
         $today_cash_rcv = DB::select('SELECT COUNT(id) as total_invoice,SUM(amount) as total_amount FROM `payments`
            					WHERE payments.status=1 AND payments.payment_type="RECEIVE" AND payments.type="CASH" AND payments.payment_date = "'.$today.'"');

          $today_bank_pmnt = DB::select('SELECT COUNT(id) as total_invoice,SUM(amount) as total_amount FROM `payments`
            					WHERE payments.status=1 AND payments.payment_type="PAYMENT" AND payments.type="BANK" AND payments.payment_date = "'.$today.'"');
         $today_cash_pmnt = DB::select('SELECT COUNT(id) as total_invoice,SUM(amount) as total_amount FROM `payments`
            					WHERE payments.status=1 AND payments.payment_type="PAYMENT" AND payments.type="CASH" AND payments.payment_date = "'.$today.'"');

*/
     // dd($today_purchase);

      /* $month12datasales = Sale::select([
                              DB::raw("DATE_FORMAT(date, '%Y') year"),
                              DB::raw("DATE_FORMAT(date, '%m') month"),
                              DB::raw("SUM(total_qty) total_qty"),
                              DB::raw("SUM(grand_total) total_value")
                          ])->where('is_active',1)->groupBy('year')->groupBy('month')->orderby('month','asc')->take(12)->get();  */
                          $fgOB = $this->totalFgOb($fromDay, $today);
                          $rmOB = $this->totalRmOb($fromDay, $today);
                          $supplierOB = $this->totalSupplierOb($fromDay, $today);
                          $dealerOB = $this->totalDealerOb($fromDay, $today);

     /* $totalRawStock = ChartOfAccounts::select( DB::raw('SUM(debit) - SUM(credit)  as balance'))->where('ac_sub_sub_account_id',10)->get();

      $totalFgStock = ChartOfAccounts::select( DB::raw('SUM(debit) - SUM(credit)  as balance'))->where('ac_sub_sub_account_id',25)->get();
      $totalAcPayable = ChartOfAccounts::select( DB::raw('SUM(credit) - SUM(debit)  as balance'))->where('ac_sub_sub_account_id',6)->get();
      $totalAcReceivable = ChartOfAccounts::select( DB::raw('SUM(debit) - SUM(credit)  as balance'))->where('ac_sub_sub_account_id',15)->get();

      $data['totalRawStock'] = $totalRawStock[0]->balance + $rmOB;

      $data['totalFgStock'] = $totalFgStock[0]->balance + $fgOB;
      $data['totalAcPayable'] = $totalAcPayable[0]->balance + $supplierOB;
      $data['totalAcReceivable'] = $totalAcReceivable[0]->balance + $dealerOB; */
      
        $individualAccountInfo = $this->getChartOfAccountInfo($fromDay, $today);
      foreach($individualAccountInfo as $account){
          if($account->acSubSubAccount?->title == 'Purchase'){
              $totalRawStock =  ($rmOB + $account->total_debit - $account->total_credit);
          }elseif($account->acSubSubAccount?->title == 'Inventory(FG)'){
              $totalFgStock = ($fgOB + ($account->total_debit - $account->total_credit));
          }elseif($account->acSubSubAccount?->title == 'Accounts Receivable (Dealer)'){
              $totalAcReceivable =  ($dealerOB + ($account->total_debit - $account->total_credit));
          } elseif($account->acSubSubAccount?->title == 'Accounts Payable (Suppliers)') {
            $totalAcPayable = ($supplierOB + ($account->total_credit - $account->total_debit));
          }
      }
     

      $data['totalRawStock'] = $totalRawStock;
      $data['totalFgStock'] = $totalFgStock;
      $data['totalAcPayable'] = $totalAcPayable;
      $data['totalAcReceivable'] = $totalAcReceivable;

      $data['todayProduction'] = SalesStockIn::whereDate('created_at',$today)->where('sout_number','LIKE','PRO-%')->sum('total_cost');

      $today_sales = DB::select('SELECT COUNT(id) as total_invoice, SUM(total_qty) as total_qty,SUM(grand_total) as total_price FROM `sales`
                          WHERE sales.is_active=1 AND sales.date = "'.$today.'"');
      $today_bank_rcv = DB::select('SELECT COUNT(id) as total_invoice,SUM(amount) as total_amount FROM `payments`
                            WHERE payments.status=1 AND payments.payment_type="RECEIVE" AND payments.type="BANK" AND payments.payment_date = "'.$today.'"');
      $today_cash_rcv = DB::select('SELECT COUNT(id) as total_invoice,SUM(amount) as total_amount FROM `payments`
                            WHERE payments.status=1 AND payments.payment_type="RECEIVE" AND payments.type="CASH" AND payments.payment_date = "'.$today.'"');
      $today_purchase = DB::select('SELECT COUNT(purchase_id) as total_invoice, SUM(bill_quantity) as total_qty,SUM(total_payable_amount) as total_price FROM `purchases`
                                              WHERE date = "'.$today.'"');
     $todayFgPurchase = FinishGoodsPurchase::where('date',$today)->sum('total_purchase_amount');
     $today_bank_pmnt = DB::select('SELECT COUNT(id) as total_invoice,SUM(amount) as total_amount FROM `payments`
                 WHERE payments.status=1 AND payments.payment_type="PAYMENT" AND payments.type="BANK" AND payments.payment_date = "'.$today.'"');
    $today_cash_pmnt = DB::select('SELECT COUNT(id) as total_invoice,SUM(amount) as total_amount FROM `payments`
                 WHERE payments.status=1 AND payments.payment_type="PAYMENT" AND payments.type="CASH" AND payments.payment_date = "'.$today.'"');

       $month12datasales = SalesLedger::select([
                              DB::raw("DATE_FORMAT(ledger_date, '%Y') year"),
                              DB::raw("DATE_FORMAT(ledger_date, '%m') month"),
                              DB::raw("SUM(qty_kg) total_value"),
                              DB::raw("SUM(total_price) totalAmount")
                          ])->whereNotNull('product_id')->groupBy('year')->groupBy('month')->orderby('month','asc')->take(12)->get();

      //  dd($month12datasales);
      $arraycountsales = count($month12datasales);

        $month12datarcv = Payment::select([
                              DB::raw("DATE_FORMAT(payment_date, '%Y') year"),
                              DB::raw("DATE_FORMAT(payment_date, '%m') month"),
                              DB::raw("SUM(amount) amount")
                          ])->where('status',1)->where('payment_type',"RECEIVE")->where('payment_date','>','2023-09-30')->groupBy('year')->groupBy('month')->orderby('month','asc')->take($arraycountsales)->get();

//dd($month12datarcv);
      /*  $month12datapurchae = Purchase::select([
                              DB::raw("DATE_FORMAT(date, '%Y') year"),
                              DB::raw("DATE_FORMAT(date, '%m') month"),
                              DB::raw("SUM(total_payable_amount) total_value"),
                           ])->groupBy('year')->groupBy('month')->orderby('month','asc')->take(12)->get(); */

        $month12datapurchae = PurchaseLedger::select([
                              DB::raw("DATE_FORMAT(date, '%Y') year"),
                              DB::raw("DATE_FORMAT(date, '%m') month"),
                              DB::raw("SUM(credit) total_value"),
                           ])->whereNotNull('purcahse_id')->groupBy('year')->groupBy('month')->orderby('month','asc')->take(12)->get();
      $arraycountp = count($month12datapurchae);

      $month12datapmt = Payment::select([
                              DB::raw("DATE_FORMAT(payment_date, '%Y') year"),
                              DB::raw("DATE_FORMAT(payment_date, '%m') month"),
                              DB::raw("SUM(amount) amount")

                          ])->where('status',1)->where('payment_type',"PAYMENT")->groupBy('year')->groupBy('month')->orderby('month','asc')->take($arraycountp)->get();

     // dd($month12datarcv);
      //  return view('backend.deshboard',compact('today_sales','today_sales_kg','today_purchase','todayFgPurchase','total_sales','today_fg_si','total_fg_si','today_cash_rcv','today_bank_rcv','today_bank_pmnt','today_cash_pmnt','today_rm_so','total_rm_si','total_rm_so','month12datasales','month12datarcv','month12datapurchae','month12datapmt'));
        return view('backend.deshboard',compact('data','today_sales','today_bank_rcv','today_cash_rcv','today_purchase','todayFgPurchase','today_bank_pmnt','today_cash_pmnt','month12datasales','month12datarcv','month12datapurchae','month12datapmt'));
    }


}
