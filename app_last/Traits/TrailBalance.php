<?php
namespace App\Traits;
use App\Models\Account\ChartOfAccounts;
use Illuminate\Support\Facades\DB;
use App\Models\MasterBank;
use App\Models\MasterCash;
use App\Models\Supplier;
use App\Models\Dealer;
use App\Models\PurchaseLedger;
use App\Models\SalesLedger;
use App\Models\SalesProduct;
use App\Models\ExpanseSubgroup;
use App\Models\InterCompany;
use App\Models\Payment;
use App\Models\RowMaterialsProduct;

trait TrailBalance
{
   public function getChartOfAccountInfo($fdate, $tdate){

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
        }
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
                        ->whereDate('created_at', '>=', $fdate)
                        ->whereDate('created_at', '<=', $tdate)
                        ->sum('opening_balance');
    }

    public function totalFgOb($fdate, $tdate){
        return SalesProduct::where('opening_balance','!=', 0)
                        ->whereDate('created_at', '>=', $fdate)
                        ->whereDate('created_at', '<=', $tdate)
                        ->sum(DB::raw('rate * opening_balance'));

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
  $dealer = SalesLedger::select(DB::raw('SUM(debit) as total_debit'),
                              DB::raw('SUM(credit) as total_credit'))
                              ->where('vendor_id',$id)->whereBetween('ledger_date', [$fdate, $tdate])->get();
                             // $amount = round($op + $dealer[0]->total_debit) -  round($dealer[0]->total_credit) ;
                              
       /* $dealer =  ChartOfAccounts::select(DB::raw('SUM(debit) as total_debit'),
                              DB::raw('SUM(credit) as total_credit'))
                              ->where('ac_individual_account_id',$id)->whereBetween('date', [$fdate, $tdate])->get();
                              $amount = round($op + round($dealer[0]->total_debit)) -  round($dealer[0]->total_credit) ; */
                              
                              $amount = (floor($op) + floor($dealer[0]->total_debit)) -  floor($dealer[0]->total_credit) ;
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
}
