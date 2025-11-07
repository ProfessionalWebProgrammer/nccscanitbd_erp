<?php
namespace App\Traits;
use App\Models\Account\ChartOfAccounts;
use App\Models\Account\IndividualAccount;
use App\Models\Account\SubSubAccount;
use Illuminate\Support\Facades\DB;
use App\Models\MasterBank;
use App\Models\MasterCash;
use App\Models\Supplier;
use App\Models\Dealer;
use App\Models\PurchaseLedger;
use App\Models\PackingConsumptions;
use App\Models\SalesLedger;
use App\Models\SalesProduct;
use App\Models\SalesStockIn;
use App\Models\SalesStockOut;
use App\Models\ExpanseSubgroup;
use App\Models\InterCompany;
use App\Models\Payment;
use App\Models\RowMaterialsProduct;
use App\Models\RawMaterialStockOut;
use App\Models\PackingStockOut;
use App\Models\PurchaseStockout;
use App\Models\SalesCategory;

trait TrailBalance
{
   public function getChartOfAccountInfo($fdate, $tdate){

        return ChartOfAccounts::with('acSubSubAccount:id,title')
            ->select(
                'ac_main_account_id',
                'ac_sub_account_id',
                'ac_sub_sub_account_id',
                'invoice',
                DB::raw('SUM(debit) as total_debit'),
                DB::raw('SUM(credit) as total_credit'),
                DB::raw('SUM(debit) - SUM(credit) as balance')
                
            )
            ->groupBy('ac_sub_sub_account_id')
            ->where(function ($query) use ($fdate, $tdate) {
                $query->whereBetween('date', [$fdate, $tdate]);
            })->get();
        }

    /*    public function getExtendedChartOfAccountInfo($fdate, $tdate){

             return ChartOfAccounts::with('acSubSubAccount:id,title')
                 ->select(
                     'ac_main_account_id',
                     'ac_sub_account_id',
                     'ac_sub_sub_account_id',
                     DB::raw('SUM(debit) as total_debit'),
                     DB::raw('SUM(credit) as total_credit'),
                     DB::raw('SUM(debit) - SUM(credit) as balance')
                 )
                 ->groupBy('ac_sub_sub_account_id')
                 ->where(function ($query) use ($fdate, $tdate) {
                     $query->whereBetween('date', [$fdate, $tdate]);
                 })->get();
             } */

    public function getChartOfAccountInfoWithoutOpening($fdate, $tdate){

        return ChartOfAccounts::with('acSubSubAccount:id,title')
            ->select(
                'ac_main_account_id',
                'ac_sub_account_id',
                'ac_sub_sub_account_id',
                DB::raw('SUM(debit) as total_debit'),
                DB::raw('SUM(credit) as total_credit')
            )
            ->groupBy('ac_sub_sub_account_id')->whereIN('ac_main_account_id',[4,5])
            ->where(function ($query) use ($fdate, $tdate) {
                $query->whereBetween('date', [$fdate, $tdate]);
            })->get();
        }

  public function getChartOfAccountDetailsInfo($fdate, $tdate){

        return ChartOfAccounts::with('acIndividualAccount:id,title')
            ->select(
                'ac_main_account_id',
                'ac_sub_account_id',
                'ac_sub_sub_account_id',
                'ac_individual_account_id',
                DB::raw('SUM(debit) as total_debit'),
                DB::raw('SUM(credit) as total_credit'),
                DB::raw('SUM(debit) - SUM(credit) as balance')
            )
            ->groupBy('ac_individual_account_id')
            ->where(function ($query) use ($fdate, $tdate) {
                $query->whereBetween('date', [$fdate, $tdate]);
            })->get();
   }


   public function getChartOfExpenseAccountInfo($fdate, $tdate){

        /* return ChartOfAccounts::with('acSubSubAccount:id,title')
            ->select('ac_sub_account_id', DB::raw('SUM(debit) - SUM(credit) as balance'))
            ->where('ac_main_account_id',5)->groupBy('ac_sub_sub_account_id')
            ->where(function ($query) use ($fdate, $tdate) {
                $query->whereBetween('date', [$fdate, $tdate]);
            })->get(); */
            /*return ChartOfAccounts::with('acSubSubAccount:id,title')
                ->select(
                    'ac_main_account_id',
                    'ac_sub_account_id',
                    'ac_sub_sub_account_id',
                    DB::raw('SUM(debit) as total_debit'),
                    DB::raw('SUM(credit) as total_credit'),
                    DB::raw('SUM(debit) - SUM(credit) as balance')
                )
                ->groupBy('ac_sub_sub_account_id')
                ->where(function ($query) use ($fdate, $tdate) {
                    $query->whereBetween('date', [$fdate, $tdate]);
                })->get(); */

                return ChartOfAccounts::with('acSubSubAccount:id,title')
                    ->select(
                        'ac_main_account_id',
                        'ac_sub_account_id',
                        'ac_sub_sub_account_id',
                        DB::raw('SUM(debit) as total_debit'),
                        DB::raw('SUM(credit) as total_credit'),
                        DB::raw('SUM(debit) - SUM(credit) as balance')
                    )
                    ->groupBy('ac_sub_account_id')->where('ac_main_account_id',5)
                    ->where(function ($query) use ($fdate, $tdate) {
                        $query->whereBetween('date', [$fdate, $tdate]);
                    })->get();
   }

     public function getChartOfCurrentLaibilityInfo($id,$fdate, $tdate){

        return ChartOfAccounts::select(
                'ac_main_account_id',
                'ac_sub_account_id',
                'ac_chart_of_account.ac_sub_sub_account_id',
                'ac_chart_of_account.ac_individual_account_id',
                'ac.title',
                DB::raw('SUM(debit) as total_debit'),
                DB::raw('SUM(credit) as total_credit'),
                DB::raw('SUM(credit) - SUM(debit) as balance')
            )->leftJoin('ac_individual_account as ac','ac.id', 'ac_chart_of_account.ac_individual_account_id')->where('ac_chart_of_account.ac_sub_sub_account_id',$id)
            ->groupBy('ac_chart_of_account.ac_individual_account_id')
            ->where(function ($query) use ($fdate, $tdate) {
                $query->whereBetween('date', [$fdate, $tdate]);
            })->get();
   }
     public function getChartOfAccountReportDetailsInfo($fdate, $tdate){

        return ChartOfAccounts::with('acIndividualAccount:id,title')->select(
                'ac_main_account_id',
                'ac_sub_account_id',
                'ac_sub_sub_account_id',
                'ac_individual_account_id',
                DB::raw('SUM(debit) as total_debit'),
                DB::raw('SUM(credit) as total_credit'),
                DB::raw('SUM(credit) - SUM(debit) as balance')
            )->where('ac_sub_sub_account_id',6)->groupBy('ac_individual_account_id')
            ->where(function ($query) use ($fdate, $tdate) {
                $query->whereBetween('date', [$fdate, $tdate]);
            })->get();
   }

   public function getChartOfAccountInfoForIncomeStatement($fdate, $tdate){

        return ChartOfAccounts::with('acSubSubAccount:id,title')
            ->select(
                'ac_main_account_id',
                'ac_sub_account_id',
                'ac_sub_sub_account_id',
                DB::raw('SUM(debit) as total_debit'),
                DB::raw('SUM(credit) as total_credit'),
                DB::raw('SUM(debit) - SUM(credit) as balance')
            )
            ->whereIn('ac_main_account_id',[4,5])
            ->groupBy('ac_sub_sub_account_id')
            ->where(function ($query) use ($fdate, $tdate) {
                $query->whereBetween('date', [$fdate, $tdate]);
            })->get();
    }
    public function getNewChartOfAccountInfoForIncomeStatement($fdate, $tdate){

        /*return ChartOfAccounts::with('acSubSubAccount:id,title')
            ->select(
                'ac_main_account_id',
                'ac_sub_account_id',
                'ac_sub_sub_account_id',
                DB::raw('SUM(debit) as total_debit'),
                DB::raw('SUM(credit) as total_credit'),
                DB::raw('SUM(debit) - SUM(credit) as balance')
            )
            ->where('ac_main_account_id',5)->where('ac_sub_account_id',8)->whereBetween('date', [$fdate, $tdate])->get();
            */
        return ChartOfAccounts::with('acSubSubAccount:id,title')
            ->select(
                'ac_main_account_id',
                'ac_sub_account_id',
                'ac_sub_sub_account_id',
                DB::raw('SUM(debit) as total_debit'),
                DB::raw('SUM(credit) as total_credit'),
                DB::raw('SUM(debit) - SUM(credit) as balance')
            )
            ->where('ac_main_account_id',5)
            ->where('ac_sub_account_id',8)
            ->groupBy('ac_sub_sub_account_id')
            ->where(function ($query) use ($fdate, $tdate) {
                $query->whereBetween('date', [$fdate, $tdate]);
            })->get();

    }


 public function getJournalInfoForPurchase($fdate, $tdate){
        // $purchaseID = SubSubAccount::where('title','Purchase')->value('id');
        return ChartOfAccounts::with(['acSubSubAccount:id,title' , 'acIndividualAccount'])
                    ->where(function ($query) use ($fdate, $tdate) {
                        $query->whereBetween('date', [$fdate, $tdate]);
                    })
                    ->get()
                    ->groupBy('date');
    }

    public function getEquityForBank(){
      return DB::table('equities')->where('type','BANK')->sum('amount');
    }

    public function getEquityForCash(){
      return DB::table('equities')->where('type','CASH')->sum('amount');
    }

    public function getDebitSection($title , $amount){
        return [
            'title' => $title,
            'debit' => $amount,
            'credit' => 0
        ];
    }

    public function getCreditSection($title , $amount){
        return [
            'title' => $title,
            'debit' => 0,
            'credit' => $amount
        ];
    }

      public function getDebitSectionExpense($id , $title , $amount){
        return [
            'id' => $id,
            'title' => $title,
            'debit' => $amount,
            'credit' => 0
        ];
    }
    public function getCreditSectionExpense($id , $title , $amount){
        return [
            'id' => $id,
            'title' => $title,
            'debit' => 0,
            'credit' => $amount
        ];
    }

    public function getDebitSectionFBS($subTitle , $title , $amount){
        return [
            'sub_title' => $subTitle,
            'title' => $title,
            'debit' => $amount,
            'credit' => 0
        ];
    }
    public function getDebitForIncomeStatement( $id,$title , $amount){
        return [
            'id' => $id,
            'title' => $title,
            'debit' => $amount,
            'credit' => 0
        ];
    }

    public function getCreditSectionFBS($subTitle ,$title , $amount){
        return [
            'sub_title' => $subTitle,
            'title' => $title,
            'debit' => 0,
            'credit' => $amount
        ];
    }

    public function totalBankOb($fdate, $tdate){
       return MasterBank::where('bank_op','!=', 0)
                        ->whereDate('created_at', '>=', $fdate)
                        ->whereDate('created_at', '<=', $tdate)
                        ->sum('bank_op');
    }


    public function totalCashOb($fdate, $tdate){
        return MasterCash::where('wirehouse_opb','!=', 0)
                            ->whereDate('created_at', '>=', $fdate)
                            ->whereDate('created_at', '<=', $tdate)
                            ->sum('wirehouse_opb');

    }

    public function totalSupplierOb($fdate, $tdate){

        return Supplier::where('opening_balance','!=', 0)
                       /* ->whereDate('created_at', '>=', $fdate)
                        ->whereDate('created_at', '<=', $tdate) */
                        ->sum('opening_balance');
    }

    public function totalFgOb($fdate, $tdate){
        return SalesProduct::where('opening_balance','!=', 0)
                        ->whereDate('created_at', '>=', $fdate)
                        ->whereDate('created_at', '<=', $tdate)
                        ->sum(DB::raw('rate * opening_balance'));
                        //->sum(DB::raw('product_dp_price * opening_balance'));

    }

      public function totalRmOb($fdate, $tdate){
        return RowMaterialsProduct::where('opening_balance','!=', 0)
                        ->whereDate('created_at', '>=', $fdate)
                        ->whereDate('created_at', '<=', $tdate)
                        ->sum(DB::raw('rate * opening_balance'));

    }

    public function totalDealerOb($fdate, $tdate){
        return Dealer::where('dlr_base','!=',0)
                        ->whereDate('created_at', '>=', $fdate)
                        ->whereDate('created_at', '<=', $tdate)
                        ->sum('dlr_base');

    }

      public function totalExpenseOb($fdate, $tdate){
        return ExpanseSubgroup::where('balance','!=', 0)
                        ->whereDate('created_at', '>=', $fdate)
                        ->whereDate('created_at', '<=', $tdate)
                        ->sum('balance');
    }

      public function totalInterCompanyOb($fdate, $tdate){
        return InterCompany::where('balance','!=', 0)
                ->whereDate('created_at', '>=', $fdate)
                ->whereDate('created_at', '<=', $tdate)
                ->sum('balance');

    }

    public function totalEquityOb($fdate, $tdate){
        return DB::table('equities')->where('type','OPEN')
              ->whereDate('created_at', '>=', $fdate)
              ->whereDate('created_at', '<=', $tdate)
              ->sum('amount');

    }

    public function totalAseetOb($fdate, $tdate){
        return DB::table('asset_products')
              ->whereDate('date', '>=', $fdate)
              ->whereDate('date', '<=', $tdate)
              ->sum('balance');
    }

    public function totalAseetDepreciationOb($fdate, $tdate){
        return DB::table('asset_products')
              ->whereDate('date', '>=', $fdate)
              ->whereDate('date', '<=', $tdate)
              ->sum('dep_amount');
    }

public function supplierAccountPayableInfo($id,$name,$op,$fdate, $tdate){
$supb =  PurchaseLedger::select(DB::raw('SUM(debit) as total_debit'),
                            DB::raw('SUM(credit) as total_credit'))
                            ->where('supplier_id',$id)->whereBetween('date', [$fdate, $tdate])->first();
    $amount = ($op + $supb->total_credit) - $supb->total_debit ;
      return [
          'title' => $name,
          'debit' => 0,
          'credit' => $amount
      ];
}

public function dealerAccountPayableInfo($id,$name,$op,$fdate, $tdate){

/*  $dealerId = IndividualAccount::where('title', $name)->where('ac_sub_sub_account_id', 15)->value('id');
  $dealerData = ChartOfAccounts::select(DB::raw('SUM(debit) as total_debit'),
                                DB::raw('SUM(credit) as total_credit'))
                                ->where('ac_individual_account_id',$dealerId)
                                ->where(function ($query) use ($fdate, $tdate) {
                                    $query->whereBetween('date', [$fdate, $tdate]);
                                })->first();

  $amount = ($op + $dealerData->total_debit) -  $dealerData->total_credit ; */

$amount = 0;
 $dealer = SalesLedger::select(DB::raw('SUM(debit) as total_debit'),
                              DB::raw('SUM(credit) as total_credit'))
                              ->where('vendor_id',$id)->whereBetween('ledger_date', [$fdate, $tdate])->first();
                              $amount = (floor($op) + floor($dealer->total_debit)) -  floor($dealer->total_credit) ;
                            return [
                                'title' => $name,
                                'debit' => floor($amount),
                                'credit' => 0
                            ];
}
public function sisterConcernAccountPayableInfo($id,$name,$op,$fdate, $tdate){
  $totaldata = Payment::select('sister_concern_id',
        DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as extotalrcv'),
        DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as receive'),
        DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as payment'),
        DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as bankReceive')
      )->where('status', 1)->where('sister_concern_id', $id)->first();

      $amount = ($op + $totaldata->extotalrcv + $totaldata->bankReceive + $totaldata->payment ) - $totaldata->receive;
      return [
          'title' => $name,
          'debit' => 0,
          'credit' => $amount
      ];
}



public function equityAccountPayableInfo($name,$amount){
  return [
      'title' => $name,
      'debit' => 0,
      'credit' => $amount
  ];
}
public function getAssetInfo($id, $subId, $title){
  return [
      'id' => $id,
      'subId' => $subId,
      'title' => $title
  ];
}


//extended code
public function equityAccountPayableInfoExten($name,$amount){
  return [
      'title' => $name,
      'opening' => $amount,
      'debit' => 0,
      'credit' => 0,
      'closing' => $amount
  ];
}
public function sisterConcernAccountPayableInfoExtend($id,$name,$op,$sdate,$pdate, $fdate, $tdate){
  $totaldata = Payment::select('sister_concern_id',
        DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "COMPANY" AND payment_date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `amount` ELSE null END) as extotalrcvPre'),
        DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `amount` ELSE null END) as receivePre'),
        DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "COMPANY" AND payment_date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `amount` ELSE null END) as paymentPre'),
        DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `amount` ELSE null END) as bankReceivePre'),
        DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as extotalrcv'),
        DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as receive'),
        DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as payment'),
        DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as bankReceive')
      )->where('status', 1)->where('sister_concern_id', $id)->first();

      $Opening = ($op + $totaldata->extotalrcvPre + $totaldata->bankReceivePre + $totaldata->paymentPre ) - $totaldata->receivePre;
      $Credit = ($totaldata->extotalrcv + $totaldata->bankReceive + $totaldata->payment );
      $debit = $totaldata->receive;
      $closing = $Opening + $Credit - $debit;
      return [
          'title' => $name,
          'opening' => $Opening,
          'debit' => 0,
          'credit' => $Credit,
          'closing' => $closing
      ];
}

public function getAccruedExpenseExtend($title, $id, $sdate,$pdate, $fdate, $tdate){
  $accruedExpData = ChartOfAccounts::select(
                    DB::raw('sum(CASE WHEN ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `debit` ELSE null END) as debitPre'),
                    DB::raw('sum(CASE WHEN ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `credit` ELSE null END) as creditPre'),
                    DB::raw('sum(CASE WHEN ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                    DB::raw('sum(CASE WHEN ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
                    )->first();

        $opening = $accruedExpData->creditPre - $accruedExpData->debitPre;
        $debit = $accruedExpData->debit;
        $credit = $accruedExpData->credit;
        $closing = $opening + $credit - $debit;

        return [
            'title' => $title,
            'opening' => $opening,
            'debit' => $debit,
            'credit' => $credit,
            'closing' => $closing
        ];
}

public function supplierExtendedAccountPayableInfo($id,$title,$op,$sdate,$pdate,$fdate, $tdate){
/* $supb =  PurchaseLedger::select(DB::raw('SUM(debit) as total_debit'),
                            DB::raw('SUM(credit) as total_credit'))
                            ->where('supplier_id',$id)->whereBetween('date', [$fdate, $tdate])->first();  */
  $supplierData =  PurchaseLedger::select(
                    DB::raw('sum(CASE WHEN supplier_id = "'.$id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `debit` ELSE null END) as debitPre'),
                    DB::raw('sum(CASE WHEN supplier_id = "'.$id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `credit` ELSE null END) as creditPre'),
                    DB::raw('sum(CASE WHEN supplier_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                    DB::raw('sum(CASE WHEN supplier_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
                    )->first();

    $opening = ($op + $supplierData->creditPre) - $supplierData->debitPre ;
    $debit = $supplierData->debit;
    $credit = $supplierData->credit;
    $closing = $opening + $credit - $debit;
  if($closing > 0){
    return [
        'title' => $title,
        'opening' => $opening,
        'debit' => $debit,
        'credit' => $credit,
        'closing' => $closing
    ];
  } else {
    return [
        'title' => $title,
        'opening' => 0,
        'debit' => 0,
        'credit' => 0,
        'closing' => 0
    ];
  }

}


public function supplierExtendedAdvanceAccountPayableInfo($id,$title,$op,$sdate,$pdate,$fdate, $tdate){
  $supplierData =  PurchaseLedger::select(
                    DB::raw('sum(CASE WHEN supplier_id = "'.$id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `debit` ELSE null END) as debitPre'),
                    DB::raw('sum(CASE WHEN supplier_id = "'.$id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `credit` ELSE null END) as creditPre'),
                    DB::raw('sum(CASE WHEN supplier_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                    DB::raw('sum(CASE WHEN supplier_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
                    )->first();

    $opening = ($op + $supplierData->creditPre) - $supplierData->debitPre ;
    $debit = $supplierData->debit;
    $credit = $supplierData->credit;
    $closing = $opening + $credit - $debit;
  if($closing < 0){
    return [
        'title' => $title,
        'opening' => $opening,
        'debit' => $debit,
        'credit' => $credit,
        'closing' => $closing
    ];
  } else {
    return [
        'title' => $title,
        'opening' => 0,
        'debit' => 0,
        'credit' => 0,
        'closing' => 0
    ];
  }
}

public function currentAssetExtendedInfo($title, $sdate,$pdate,$fdate, $tdate){
  $currentAssetIds = SubSubAccount::select('id')->where('title',$title)->get();
  foreach($currentAssetIds as $val){
    $currentAssets = ChartOfAccounts::select(
                      DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$val->id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `debit` ELSE null END) as debitPre'),
                      DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$val->id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `credit` ELSE null END) as creditPre'),
                      DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$val->id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                      DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$val->id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
                      )->first();
                      if($currentAssets){
                        $opening = $currentAssets->debitPre - $currentAssets->creditPre;
                        $debit = $currentAssets->debit;
                        $credit = $currentAssets->credit;
                        $closing = ($opening + $debit) - $credit;
                        if($closing != 0){
                        return [
                            'title' => $title,
                            'opening' => $opening,
                            'debit' => $debit,
                            'credit' => $credit,
                            'closing' => $closing
                        ];
                      } else {
                        return [
                            'title' => $title,
                            'opening' => 0,
                            'debit' => 0,
                            'credit' => 0,
                            'closing' => 0
                        ];
                      }
                      }
  }
}

public function getBankDataExtendedTb($id, $title,$op,$sdate,$pdate,$fdate, $tdate){
  $bankAssets = ChartOfAccounts::select(
                    DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `debit` ELSE null END) as debitPre'),
                    DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `credit` ELSE null END) as creditPre'),
                    DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                    DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
                    )->first();

                    $opening = ($op + $bankAssets->debitPre) - $bankAssets->creditPre;
                    $debit = $bankAssets->debit;
                    $credit = $bankAssets->credit;
                    $closing = ($opening + $debit) - $credit;

                    return [
                        'title' => $title,
                        'opening' => $opening,
                        'debit' => $debit,
                        'credit' => $credit,
                        'closing' => $closing
                    ];

}
public function getOthersIncomeExtendedTb($id, $title, $fdate, $tdate){
  $othersIncome = ChartOfAccounts::with('acSubSubAccount:id,title')
      ->select(
          DB::raw('SUM(debit) as debit'),
          DB::raw('SUM(credit) as credit')
      )->where('ac_sub_sub_account_id',$id)->whereBetween('date', [$fdate, $tdate])->first();

      return [
          'title' => $title,
          'opening' => 0,
          'debit' => $othersIncome->debit,
          'credit' => $othersIncome->credit,
          'closing' => $othersIncome->credit - $othersIncome->debit
      ];
}
public function getAccumDepnExtendedTb($id, $title, $sdate,$pdate,$fdate, $tdate){
  $accumDepnAsset = ChartOfAccounts::select(
                    DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `debit` ELSE null END) as debitPre'),
                    DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `credit` ELSE null END) as creditPre'),
                    DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                    DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
                    )->first();
      $opening = $accumDepnAsset->creditPre - $accumDepnAsset->debitPre;
      $debit = $accumDepnAsset->debit;
      $credit = $accumDepnAsset->credit;
      $closing = $opening + $credit - $debit;
      return [
          'title' => $title,
          'opening' => $opening,
          'debit' => $debit,
          'credit' => $credit,
          'closing' => $closing
      ];

}
public function getDebitWithoutOpeningExtendedTb($id, $title, $fdate, $tdate){
  $getData = ChartOfAccounts::with('acSubSubAccount:id,title')
      ->select(
          DB::raw('SUM(debit) as debit'),
          DB::raw('SUM(credit) as credit')
      )->where('ac_sub_sub_account_id',$id)->whereBetween('date', [$fdate, $tdate])->first();

      return [
          'title' => $title,
          'opening' => 0,
          'debit' => $getData->debit,
          'credit' => $getData->credit,
          'closing' =>  $getData->debit - $getData->credit
      ];
}

public function dealerAccountExtendedPayableInfo($id, $title,$op,$sdate,$pdate,$fdate, $tdate){
    $dealerData = SalesLedger::select(
                      DB::raw('sum(CASE WHEN 	vendor_id = "'.$id.'" AND ledger_date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `debit` ELSE null END) as debitPre'),
                      DB::raw('sum(CASE WHEN 	vendor_id = "'.$id.'" AND ledger_date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `credit` ELSE null END) as creditPre'),
                      DB::raw('sum(CASE WHEN 	vendor_id = "'.$id.'" AND ledger_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                      DB::raw('sum(CASE WHEN 	vendor_id = "'.$id.'" AND ledger_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
                      )->first();
                      $opening = ($op + $dealerData->debitPre) - $dealerData->creditPre;
                      $debit = $dealerData->debit;
                      $credit = $dealerData->credit;
                      $closing = ($opening + $debit) - $credit;

                      if($closing > 0){
                        return [
                            'title' => $title,
                            'opening' => $opening,
                            'debit' => $debit,
                            'credit' => $credit,
                            'closing' => $closing
                        ];
                      } else {
                        return [
                            'title' => $title,
                            'opening' => 0,
                            'debit' => 0,
                            'credit' => 0,
                            'closing' => 0
                        ];
                      }

}
public function dealerAccountExtendedAdvancePayableInfo($id, $title,$op,$sdate,$pdate,$fdate, $tdate){
    $dealerData = SalesLedger::select(
                      DB::raw('sum(CASE WHEN 	vendor_id = "'.$id.'" AND ledger_date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `debit` ELSE null END) as debitPre'),
                      DB::raw('sum(CASE WHEN 	vendor_id = "'.$id.'" AND ledger_date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `credit` ELSE null END) as creditPre'),
                      DB::raw('sum(CASE WHEN 	vendor_id = "'.$id.'" AND ledger_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                      DB::raw('sum(CASE WHEN 	vendor_id = "'.$id.'" AND ledger_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
                      )->first();
                      $opening = ($op + $dealerData->debitPre) - $dealerData->creditPre;
                      $debit = $dealerData->debit;
                      $credit = $dealerData->credit;
                      $closing = ($opening + $debit) - $credit;
                      if($closing < 0){
                        return [
                            'title' => $title,
                            'opening' => $opening,
                            'debit' => $debit,
                            'credit' => $credit,
                            'closing' => $closing
                        ];
                      } else {
                        return [
                            'title' => $title,
                            'opening' => 0,
                            'debit' => 0,
                            'credit' => 0,
                            'closing' => 0
                        ];
                      }
}

public function getDebitWithoutOpeningExtendedExpenseData($group, $id, $title,$fdate, $tdate){

  $expenseData = ChartOfAccounts::select(
          'ac_sub_sub_account_id',
          DB::raw('SUM(debit) as debit'),
          DB::raw('SUM(credit) as credit')
      )->where('ac_sub_sub_account_id',$id)
      ->whereBetween('date', [$fdate, $tdate])
      ->first();
      $closing = $expenseData->debit - $expenseData->credit;
      if($closing != 0){
        return [
            'group' =>$group,
            'subLedger' => [
              'title' => $title,
              'opening' => 0,
              'debit' => $expenseData->debit,
              'credit' => $expenseData->credit,
              'closing' =>  $closing
            ]

        ];
      } else {
        return [
            'group' =>'NULL',
            'subLedger' => [
              'title' => $title,
              'opening' => 0,
              'debit' => 0,
              'credit' => 0,
              'closing' => 0
            ]

        ];
      }
}
public function getDebitForNonCurrentAssetTb($group,$id, $title, $sdate,$pdate,$fdate, $tdate){
  $nonCurrentAsset = ChartOfAccounts::select(
                    DB::raw('sum(CASE WHEN 	ac_individual_account_id = "'.$id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `debit` ELSE null END) as debitPre'),
                    DB::raw('sum(CASE WHEN 	ac_individual_account_id = "'.$id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `credit` ELSE null END) as creditPre'),
                    DB::raw('sum(CASE WHEN 	ac_individual_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                    DB::raw('sum(CASE WHEN 	ac_individual_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
                    )->first();

                    $opening = $nonCurrentAsset->debitPre - $nonCurrentAsset->creditPre;
                    $debit = $nonCurrentAsset->debit;
                    $credit = $nonCurrentAsset->credit;
                    $closing = ($opening + $debit) - $credit;

                    if($closing != 0){
                      return [
                          'group' =>$group,
                          'subLedger' => [
                            'title' => $title,
                            'opening' => $opening,
                            'debit' => $debit,
                            'credit' => $credit,
                            'closing' =>  $closing
                          ]

                      ];
                    } else {
                      return [
                          'group' =>'NULL',
                          'subLedger' => [
                            'title' => $title,
                            'opening' => 0,
                            'debit' => 0,
                            'credit' => 0,
                            'closing' => 0
                          ]

                      ];
                    }
                  }

                  public function getDebitForNonCurrentAsset($group,$id, $title, $fdate, $tdate){
                    $nonCurrentAsset = ChartOfAccounts::select(
                                      DB::raw('sum(CASE WHEN 	ac_individual_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                                      DB::raw('sum(CASE WHEN 	ac_individual_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
                                      )->first();

                                      $debit = $nonCurrentAsset->debit;
                                      $credit = $nonCurrentAsset->credit;
                                      $closing = $debit - $credit;

                                      if($closing != 0){
                                        return [
                                            'group' =>$group,
                                            'subLedger' => [
                                              'title' => $title,
                                              'debit' =>  $closing
                                            ]

                                        ];
                                      } else {
                                        return [
                                            'group' =>$group,
                                            'subLedger' => [
                                              'title' => $title,
                                              'debit' => 0
                                            ]

                                        ];
                                      }
                                    }
            public function getDebitForNonCurrentAssetInfo($group,$id, $fdate, $tdate){
            $nonCurrentAsset = ChartOfAccounts::select(
                              DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                              DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
                              )->first();
    
                              $debit = $nonCurrentAsset->debit;
                              $credit = $nonCurrentAsset->credit;
                              $closing = $debit - $credit;
    
                              if($closing != 0){
                                return [
                                     'title' =>$group,
                                      'debit' =>  $closing
                                    ];
                              } else {
                                return [
                                      'title' =>'NULL',
                                      'debit' => 0
                                    ];
                              }
                            }
            public function getDebitForCurrentAsset($id, $title, $fdate, $tdate){
                $currentAsset = ChartOfAccounts::select(
                                  DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
                                  DB::raw('sum(CASE WHEN 	ac_sub_sub_account_id = "'.$id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
                                  )->first();
                        $debit = $currentAsset->debit - $currentAsset->credit;
                        $credit = 0;
                        return [
                          'title' => $title,
                          'debit' => $debit,
                          'credit' => 0
                        ];
              }


public function getFinishGoodExtendedTb($id, $category, $sdate,$pdate,$fdate, $tdate){
  $products = SalesProduct::where('category_id',$id)->orderby('product_name', 'asc')->get();
  $opening = 0;
  $debit = 0;
  foreach ($products as $key => $value) {
    $allStockAmount = SalesStockIn::select(
      DB::raw('sum(CASE WHEN 	prouct_id = "'.$value->id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `total_cost` ELSE null END) as totalCostPre'),
      DB::raw('sum(CASE WHEN 	prouct_id = "'.$value->id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `total_cost` ELSE null END) as totalCost')
      )->first();
    $stockOutAmount = SalesStockOut::select(
      DB::raw('sum(CASE WHEN 	product_id = "'.$value->id.'" AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `amount` ELSE null END) as totalAmountPre'),
      DB::raw('sum(CASE WHEN 	product_id = "'.$value->id.'" AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalAmount')
    )->first();

    $opening += ($value->opening_balance*$value->rate)   + $allStockAmount->totalCostPre - $stockOutAmount->totalAmountPre;
    $debit += $allStockAmount->totalCost - $stockOutAmount->totalAmount;
  }
  $closing = $opening + $debit;

  return [
      'title' => $category,
      'opening' => $opening,
      'debit' => $debit,
      'credit' => 0,
      'closing' => $closing
  ];
}
public function getFGInventoryPackingAmount($title,$sdate,$pdate,$fdate, $tdate){
  $totalPackingConsumption = PackingConsumptions::select(
          DB::raw('sum(CASE WHEN 	date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `amount` ELSE null END) as totalAmountPre'),
          DB::raw('sum(CASE WHEN 	date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalAmount')
          )->first();
          $sid = 8;
          $ssid = 163;
  $totalPackingData = ChartOfAccounts::select(
          DB::raw('sum(CASE WHEN ac_sub_account_id ="'.$sid.'" AND	ac_sub_sub_account_id = "'.$ssid.'" AND invoice like "Sal-%"	AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `debit` ELSE null END) as debitPre'),
          DB::raw('sum(CASE WHEN ac_sub_account_id ="'.$sid.'" AND	ac_sub_sub_account_id = "'.$ssid.'" AND invoice like "Sal-%"	AND	date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `debit` ELSE null END) as debit'),
          DB::raw('sum(CASE WHEN ac_sub_account_id ="'.$sid.'" AND	ac_sub_sub_account_id = "'.$ssid.'" AND invoice like "SR-Inv-%"	AND date BETWEEN  "'.$sdate.'" AND "'.$pdate.'" THEN `credit` ELSE null END) as creditPre'),
          DB::raw('sum(CASE WHEN ac_sub_account_id ="'.$sid.'" AND	ac_sub_sub_account_id = "'.$ssid.'" AND invoice like "SR-Inv-%"	AND	date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as credit')
          )->first();

  //$totalPackingReturnCost = ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','SR-Inv-%')->whereBetween('date',[$startdate,$tdate])->sum('credit');

  $opening = ($totalPackingConsumption->totalAmountPre + $totalPackingData->creditPre) - $totalPackingData->debitPre ;
  $debit = $totalPackingData->credit - $totalPackingData->debit;
  $closing = $opening + $debit;
  return [
      'title' => $title,
      'opening' => $opening,
      'debit' => $debit,
      'credit' => 0,
      'closing' => $closing
  ];
}

public function salesBrandCategoryWiseData($id, $product, $catId, $amount, $fDate, $tDate){
  $SalesProduct = SalesProduct::where('product_name',$product)->first();
  $category = SalesCategory::where('id',$catId)->value('category_name');

  if($SalesProduct){
    //$salesOut = RawMaterialStockOut::select('product_id',DB::raw('SUM(amount) as amount'))->where('product_id',$id)->whereIn('date',[$fDate,$tDate])->first();
    $salesOut = RawMaterialStockOut::where('product_id',$id)->whereBetween('date',[$fDate,$tDate])->sum('amount');
    //$packCost = PackingStockOut::select('product_id',DB::raw('SUM(amount) as amount'))->where('product_id',$id)->whereIn('date',[$fDate,$tDate])->first();
    $packCost = PackingStockOut::where('product_id',$id)->whereBetween('date',[$fDate,$tDate])->sum('amount');
    $pCost = $salesOut ?? 0;
    $bCost = $packCost ?? 0;
    $cogs = $pCost + $bCost;
    $gp = $amount - $cogs;
    if($cogs > 0){
      $gpPercent = ($gp * 100) / $cogs;
    } else {
      $gpPercent = $gp;
    }
    return  [
      'category' => $category,
      'brandCode' => $SalesProduct->product_code,
      'brand' => $product,
      'netSales' => $amount,
      'cogs' => $cogs,
      'gp' => $gp,
      'gpPercent' => $gpPercent
    ];
  } else {
    $salesRawOut = PurchaseStockout::select('product_id',DB::raw('SUM(total_amount) as amount'))->where('product_id',$id)->where('sout_number','LIKE','Sal-%')->whereBetween('date',[$fDate,$tDate])->first();
    $bCode = RowMaterialsProduct::where('id',$id)->value('code');
    $cogs = $salesRawOut->amount ?? 0;
    $gp = $amount - $cogs;
    if($cogs > 0){
      $gpPercent = ($gp * 100) / $cogs;
    } else {
      $gpPercent = $gp;
    }

    return  [
      'category' => $category,
      'brandCode' => $bCode,
      'brand' => $product,
      'netSales' => $amount,
      'cogs' => $cogs,
      'gp' => $gp,
      'gpPercent' => $gpPercent
    ];
  }

}

public function getDebitOpeningData($mainId, $title,$fdate, $tdate){

  $openingBankData = ChartOfAccounts::with('acSubSubAccount:id,title')
      ->select(
          'ac_main_account_id',
          'ac_sub_account_id',
          'ac_sub_sub_account_id',
          DB::raw('SUM(debit) as total_debit'),
          DB::raw('SUM(credit) as total_credit'),
          DB::raw('SUM(debit) - SUM(credit) as balance')
      )
      ->where('ac_main_account_id',$mainId)
      ->whereBetween('date', [$fdate, $tdate])
      ->get();

      return [
          'title' => $title,
          'debit' => $openingBankData[0]->total_debit,
          'credit' => $openingBankData[0]->total_credit
      ];

}
}
