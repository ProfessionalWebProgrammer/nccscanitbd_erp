<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account\ChartOfAccounts;
use App\Models\Account\MainAccount;
// use DB;
use App\Models\Account\AssetDepreciationSetting;
use App\Models\Account\SubSubAccount;
use App\Models\Supplier;
use App\Models\MasterBank;
use App\Traits\TrailBalance;
use Illuminate\Support\Facades\DB;

class ChartOfAccountController extends Controller
{
    use TrailBalance;

    public function index(){
        // $chartOfAccounts = ChartOfAccounts::with(['acMainAccount','acSubAccount','acSubSubAccount','acIndividualAccount'])->selectRaw('*,ROW_NUMBER() OVER (ORDER BY id) AS row_num')->orderBy('id','desc')->paginate(10);
        $mainAccounts = MainAccount::with('subAccounts')->get();
        return view('backend.account.chart_of_account.index',[
            'mainAccounts' => $mainAccounts
        ]);
    }

    public function inputTrailBalanceSheet(){
        return view('backend.account.chart_of_account.trail-balance-input');
    }

    public function getTrailBalanceSheet(Request $request){

        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        $accountInfo = [];
        $individualAccountInfo = $this->getChartOfAccountInfo($fdate, $tdate);
        
        // return $individualAccountInfo;
       
        $bankEquity = $this->getEquityForBank();
        $cashEquity = $this->getEquityForCash();
        $bankOB =  $this->totalBankOb($fdate, $tdate);
        $cashOB =  $this->totalCashOb($fdate, $tdate); 
        $supplierOB = $this->totalSupplierOb($fdate, $tdate);
        $fgOB = $this->totalFgOb($fdate, $tdate);
        $rmOB = $this->totalRmOb($fdate, $tdate);
        $dealerOB = $this->totalDealerOb($fdate, $tdate);
        $expenseOB = $this->totalExpenseOb($fdate, $tdate);
        $interCompanyOB = $this->totalInterCompanyOb($fdate, $tdate);
        $equityOB = $this->totalEquityOb($fdate, $tdate);

        if($fdate == '2023-10-01'){
          $othersOB = 8520;
          $salesRevenueOB = 27949233;
          $salesReturnOB = 726360;
          $retainedEarningOB = 3318860;
        } else {
          $othersOB = 0;
          $salesRevenueOB = 0 ;
          $salesReturnOB = 0 ;
          $retainedEarningOB = 0 ;
        }
        
        
       // $accountInfo[] = $this->getCreditSection('Equity' , ($bankEquity + $cashEquity + $bankOB + $cashOB + $fgOB + $dealerOB));
      
        // $accountInfo[] = $this->getCreditSection('Equity' , ($bankEquity + $cashEquity));
        $accountInfo[] = $this->getCreditSection('Clearance Accounting' , (($bankOB + $cashOB + $fgOB + $rmOB +  $dealerOB + $expenseOB + $salesReturnOB) - ($supplierOB + $interCompanyOB + $equityOB + $othersOB +$salesRevenueOB + $retainedEarningOB)));
        $accountInfo[] = $this->getCreditSection('Equity',($bankEquity + $cashEquity + $equityOB+ $retainedEarningOB));
          
            $isBank = 0;
            $isCash = 0;
            $isPurchase = 0;
            $isAccountPayable = 0;
            $isInventoryFg = 0;
            $isAccountReceivable = 0;
            $isEquity =0;
            $isOthersIncome = 0;
            $isSalesRevenue = 0;
            $isSalesReturn = 0;
            foreach($individualAccountInfo as $account){
                  if($account->ac_main_account_id == 1 || $account->ac_main_account_id == 3 || $account->ac_main_account_id == 4 || $account->ac_main_account_id == 5 ){
                    if($account->acSubSubAccount?->title == 'Bank'){
                        $accountInfo[] = $this->getDebitSection($account->acSubSubAccount?->title , ($bankEquity + $bankOB + $account->balance));
                        $isBank++;
                    }elseif($account->acSubSubAccount?->title == 'Cash'){
                        $accountInfo[] = $this->getDebitSection($account->acSubSubAccount?->title , ($cashEquity + $cashOB + $account->balance));
                        $isCash++;
                    }elseif($account->acSubSubAccount?->title == 'Purchase'){
                        $accountInfo[] =  $this->getDebitSection('Purchase' , ($rmOB + $account->total_debit - $account->total_credit)); 
                        $isPurchase++;
                    }elseif($account->acSubSubAccount?->title == 'Inventory(FG)'){
                        $accountInfo[] =  $this->getDebitSection('Inventory(FG)' , ($fgOB + ($account->total_debit - $account->total_credit))); 
                        $isInventoryFg++;
                    }elseif($account->acSubSubAccount?->title == 'Accounts Receivable (Dealer)'){
                        $accountInfo[] =  $this->getDebitSection($account->acSubSubAccount?->title , ($dealerOB + ($account->total_debit - $account->total_credit))); 
                        $isAccountReceivable++;
                    }elseif($account->acSubSubAccount?->title == 'Accumulated Depreciation'){
                        $accountInfo[] =  $this->getCreditSection($account->acSubSubAccount?->title , ($account->total_credit - $account->total_debit)); 
                    }elseif($account->acSubSubAccount?->title == 'Finished Goods Sales'){
                      $accountInfo[] =  $this->getCreditSection($account->acSubSubAccount?->title , (($account->total_credit + $salesRevenueOB) - $account->total_debit));
                      $isSalesRevenue++;
                    }elseif($account->acSubSubAccount?->title == 'Others Income'){
                      $accountInfo[] =  $this->getCreditSection($account->acSubSubAccount?->title , ( $othersOB + $account->total_credit - $account->total_debit));
                      $isOthersIncome++;
                    }else{
                        $accountInfo[] =  $this->getDebitSection($account->acSubSubAccount?->title , ($account->total_debit - $account->total_credit));
                    }
             
                }else{
                    if($account->acSubSubAccount?->title == 'Accounts Payable (Suppliers)'){
                        // dd($account->total_credit - $account->total_debit);
                        $accountInfo[] =  $this->getCreditSection($account->acSubSubAccount?->title , ($supplierOB + ($account->total_credit - $account->total_debit))); 
                        $isAccountPayable++;
                    }elseif($account->acSubSubAccount?->title == 'Sales Returns'){
                        $accountInfo[] =  $this->getDebitSection($account->acSubSubAccount?->title , ($salesReturnOB + $account->total_debit - $account->total_credit)); 

                    }else{
                        
                        $accountInfo[] =  $this->getCreditSection($account->acSubSubAccount?->title , ($account->total_credit - $account->total_debit));  
 
                    }
                }
            }

            if($isBank < 1){
                $accountInfo[] = $this->getDebitSection('Bank' , ($bankOB + $bankEquity));
            }
            if($isCash < 1){
                $accountInfo[] = $this->getDebitSection('Cash' , ($cashOB + $cashEquity));
            }
            if($isAccountPayable < 1){
                $accountInfo[] = $this->getCreditSection('Accounts Payable (Suppliers)' , $supplierOB);
            }
            if($isPurchase < 1){
                $accountInfo[] = $this->getDebitSection('Purchase' , $rmOB);
            }
            if($isInventoryFg < 1){
                $accountInfo[] = $this->getDebitSection('Inventory(FG)' , $fgOB);
            }
            // if($isInventoryRm < 1){
            //     $accountInfo[] = $this->getDebitSection('Inventory(RM)' , $rmOB);
            // }
            
            if($isAccountReceivable < 1){
                $accountInfo[] = $this->getDebitSection('Accounts Receivable (Dealer)' , $dealerOB);
            }
            
            if($isOthersIncome < 1){
                $accountInfo[] = $this->getCreditSection('Others Income' , $othersOB);
            }
            if($isSalesRevenue < 1){
                $accountInfo[] = $this->getCreditSection('Finished Goods Sales' , $salesRevenueOB);
            }
            if($isSalesReturn < 1){
                $accountInfo[] = $this->getDebitSection('Sales Returns' , $salesReturnOB);
            }
                
           
            
            usort($accountInfo, function($a, $b) {
                return strcmp($a['title'], $b['title']);
            });
            return view('backend.account.chart_of_account.trail_balance_sheet',[
                'chartOfAccounts' => $accountInfo,
                'fdate' => \Carbon\Carbon::parse($fdate)->format('j F, Y'),
                'tdate' => \Carbon\Carbon::parse($tdate)->format('j F, Y'),
            ]); 
    }

    public function inputBalanceSheet(){
        return view('backend.account.chart_of_account.balance-sheet-input');
    }

    public function balanceSheet(Request $request){
        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
       
        $accountInfo = [];
        $assetData = [];
        $liabilityData = [];
        $totalRevenue = 0;
        $totalExpense = 0;
        $isBank = 0;
        $isCash = 0;
        $isPurchase = 0;
        $isAccountPayable = 0;
        $isInventoryFg = 0;
        $isAccountReceivable = 0;

        $individualAccountInfo = $this->getChartOfAccountInfo($fdate, $tdate);  
        
        $bankOB =  $this->totalBankOb($fdate, $tdate);
        $cashOB =  $this->totalCashOb($fdate, $tdate); 
        $fgOB = $this->totalFgOb($fdate, $tdate);
        $supplierOB = $this->totalSupplierOb($fdate, $tdate);
        $dealerOB = $this->totalDealerOb($fdate, $tdate);
        $bankEquity = $this->getEquityForBank();
        $cashEquity = $this->getEquityForCash();

        $rmOB = $this->totalRmOb($fdate, $tdate);
        $expenseOB = $this->totalExpenseOb($fdate, $tdate);
        $interCompanyOB = $this->totalInterCompanyOb($fdate, $tdate);
        $equityOB = $this->totalEquityOb($fdate, $tdate);

        if($fdate == '2023-10-01'){
          $othersOB = 8520;
          $salesRevenueOB = 27949233;
          $salesReturnOB = 726360;
          $retainedEarningOB = 3318860;
        } else {
          $othersOB = 0;
          $salesRevenueOB = 0 ;
          $salesReturnOB = 0 ;
          $retainedEarningOB = 0 ;
        }


        $liabilityData[] = $this->getCreditSectionFBS('Equity','Owner\'s Capital' , ($bankEquity + $cashEquity + $equityOB));
        
        //$liabilityData[] = $this->getCreditSectionFBS('Equity','Owner\'s Capital' , ($bankEquity + $cashEquity + $bankOB + $cashOB +$fgOB + $dealerOB));
        
        foreach($individualAccountInfo as $account){
            
            if($account->ac_main_account_id == 1){
                if($account->acSubSubAccount?->title == 'Bank'){
                    $assetData[] = $this->getDebitSectionFBS($account->acSubAccount?->title , $account->acSubSubAccount?->title , ($bankEquity + $bankOB + $account->balance));
                    $isBank++;
                }elseif($account->acSubSubAccount?->title == 'Cash'){
                    $assetData[] = $this->getDebitSectionFBS($account->acSubAccount?->title,$account->acSubSubAccount?->title , ($cashEquity + $cashOB + $account->balance));
                    $isCash++;
                }elseif($account->acSubSubAccount?->title == 'Inventory(FG)'){
                    $assetData[] =  $this->getDebitSectionFBS($account->acSubAccount?->title,'Inventory(FG)' , ($fgOB + ($account->total_debit - $account->total_credit))); 
                    $isInventoryFg++;
                }elseif($account->acSubSubAccount?->title == 'Purchase'){
                    $assetData[] =  $this->getDebitSectionFBS($account->acSubAccount?->title,'Purchase' , ($rmOB+($account->total_debit - $account->total_credit))); 
                    $isPurchase++;
                }elseif($account->acSubSubAccount?->title == 'Accounts Receivable (Dealer)'){
                    $assetData[] =  $this->getDebitSectionFBS($account->acSubAccount?->title, $account->acSubSubAccount?->title , ($dealerOB + ($account->total_debit - $account->total_credit))); 
                    $isAccountReceivable++;
                }elseif($account->acSubSubAccount?->title == 'Accumulated Depreciation'){
                    $assetData[] =  $this->getCreditSectionFBS($account->acSubAccount?->title,$account->acSubSubAccount?->title , ($account->total_credit - $account->total_debit)); 
                }else{
                    $assetData[] =  $this->getDebitSectionFBS($account->acSubAccount?->title,$account->acSubSubAccount?->title , ($account->total_debit - $account->total_credit)); 
                    // if($account->acSubSubAccount?->title != 'Purchase Return'){
                    //         $assetData[] = [
                    //             'sub_title' => $account->acSubAccount?->title,
                    //             'title' => $account->acSubSubAccount?->title == 'Purchase' ? 'Inventory' : $account->acSubSubAccount?->title,
                    //             'debit' => ABS($account->balance),
                    //             'credit' => 0
                    //         ]; 
                    
                    // } 
                }
                
            }elseif($account->ac_main_account_id == 2){
                if($account->acSubSubAccount?->title == 'Accounts Payable (Suppliers)'){
                    $liabilityData[] =  $this->getCreditSectionFBS($account->acSubAccount?->title,$account->acSubSubAccount?->title , ($supplierOB + ($account->total_credit - $account->total_debit))); 
                    $isAccountPayable++;
                }elseif($account->acSubSubAccount?->title == 'ACCRUED EXPANSES'){
                      $liabilityData[] =  $this->getCreditSectionFBS($account->acSubAccount?->title, $account->acSubSubAccount?->title , ($account->total_credit - $account->total_debit));
                }else{
                    $liabilityData[] =  $this->getCreditSectionFBS($account->acSubAccount?->title, $account->acSubSubAccount?->title , ($account->total_credit - $account->total_debit));  
                }
                
            }elseif($account->ac_main_account_id == 4){
                $totalRevenue += ($account->total_credit - $account->total_debit);
            }elseif($account->ac_main_account_id == 5){
                $totalExpense += ($account->total_debit - $account->total_credit); 
            }
            
        }   
      

        if($isBank < 1){
            $assetData[] = $this->getDebitSectionFBS('Current Assets','Bank' , ($bankOB + $bankEquity));
        }
        if($isCash < 1){
            $assetData[] = $this->getDebitSectionFBS('Current Assets','Cash' , ($cashOB + $cashEquity));
        }
        if($isInventoryFg < 1){
            $assetData[] = $this->getDebitSectionFBS('Current Assets','Inventory(FG)' , $fgOB);
        }
        if($isAccountPayable < 1){
            $liabilityData[] = $this->getCreditSectionFBS('Current Liabilities','Accounts Payable (Suppliers)' , $supplierOB);
        }
        if($isPurchase < 1){
            $assetData[] = $this->getDebitSectionFBS('Current Assets','Purchase' , $rmOB);
        }
        if($isAccountReceivable < 1){
            $assetData[] = $this->getDebitSectionFBS('Current Assets','Accounts Receivable (Dealer)' , $dealerOB);
        }
        // dump($totalRevenue - $totalExpense);
        //$totalRetainedEarning = $totalRevenue - $totalExpense;
    //    dd($totalRetainedEarning);
    
    if($fdate == '2023-10-01' || $tdate <= '2023-10-31'){
          $totalRetainedEarning = ($retainedEarningOB + $totalRevenue + $othersOB +   $salesRevenueOB) - ($totalExpense + $salesReturnOB);
        } else {
          $totalRetainedEarning = $totalRevenue - $totalExpense;
        }
        $liabilityData[] = [
            'sub_title' => 'Earning',
            'title' => 'Retained Earning',
            'debit' => 0,
            'credit' => $totalRetainedEarning,
        ];
         
        $currentAssets = [];
        $fixedAssets = [];
        $accumulatedAmount = 0;
        foreach ($assetData as $item) {
            $subTitle = $item['sub_title'];
            if ($subTitle === 'Current Assets') {
                $currentAssets[] = $item;
            } elseif ($subTitle === 'Fixed Assets') {
                if($item['title'] == 'Accumulated Depreciation'){
                    $accumulatedAmount += $item['credit'];
                }else{
                    $fixedAssets[] = $item;
                }
            }elseif($subTitle === 'OTHERS  FIXED  ASSETS'){
                $fixedAssets[] = $item;
            }
        }
        
       
         
        $currentLiabilities = [];
        $fixedLiabilities = [];
        $equities = [];
        $currentLiabilities[] = $this->getCreditSection('Clearance Accounting' , (($bankOB + $cashOB + $fgOB + $rmOB +  $dealerOB + $expenseOB + $salesReturnOB) - ($supplierOB + $interCompanyOB + $equityOB + $othersOB +$salesRevenueOB + $retainedEarningOB)));
        
        foreach ($liabilityData as $item) {
            $subTitle = $item['sub_title'];
            if ($subTitle === 'Current Liabilities') {
                $currentLiabilities[] = $item;
            } elseif ($subTitle === 'Fixed Liabilities') {
                $fixedLiabilities[] = $item;
            }elseif ($subTitle === 'Equity' || $subTitle === 'Earning'){
                $equities[] = $item;
            }
        }

        // return $equities;
        return view('backend.account.chart_of_account.balance-sheet',[
            'chartOfAccounts' => $accountInfo,
            'assetData' =>  $assetData,
            'liabilityData' =>$liabilityData,
            'currentAssets' => $currentAssets,
            'fixedAssets' => $fixedAssets,
            'currentLiabilities' => $currentLiabilities,
            'fixedLiabilities' => $fixedLiabilities,
            'accumulatedAmount' => $accumulatedAmount,
            'equities' => $equities,
            'fdate' => \Carbon\Carbon::parse($fdate)->format('j F, Y'),
            'tdate' => \Carbon\Carbon::parse($tdate)->format('j F, Y'),
        ]);       
    }

    // public function balanceSheet(Request $request){
    //     if ($request->date) {
    //         $dates = explode(' - ', $request->date);
    //         $fdate = date('Y-m-d', strtotime($dates[0]));
    //         $tdate = date('Y-m-d', strtotime($dates[1]));
    //     }

    //     // $subsubIds = SubSubAccount::whereIn('title' , ['Accumulated Depreciation' , 'Depreciation Expense'])->pluck('id')->toArray();
    //     // $currentMonth = date('m');
    //     // $currentYear = date('Y');
    //     $individualAccountInfo = ChartOfAccounts::with('acSubSubAccount:id,title')
    //             ->select(
    //                 'ac_main_account_id',
    //                 'ac_sub_account_id',
    //                 'ac_sub_sub_account_id',
    //                 DB::raw('SUM(debit) as total_debit'),
    //                 DB::raw('SUM(credit) as total_credit'),
    //                 DB::raw('SUM(debit) - SUM(credit) as balance')
    //             )
    //             ->groupBy('ac_sub_sub_account_id')
    //             // ->where(function ($query) use ($currentMonth ,$currentYear, $subsubIds) {
    //             //     $query->whereIn('ac_sub_sub_account_id', $subsubIds)
    //             //         ->whereMonth('date', $currentMonth)
    //             //         ->whereYear('date', $currentYear);
    //             // })
    //             ->where(function ($query) use ($fdate, $tdate) {
    //                 $query->whereBetween('date', [$fdate, $tdate]);
    //             })->get();
               
    //     // return   $individualAccountInfo;      

    //             $accountInfo = [];
    //             $assetData = [];
    //             $liabilityData = [];
    //             $totalRevenue = 0;
    //             $totalExpense = 0;
        
    //             foreach($individualAccountInfo as $account){
                    
    //                 if($account->ac_main_account_id == 1){
    //                     if($account->acSubSubAccount?->title == 'Bank'){
    //                         $equity = DB::table('equities')->where('type','BANK')->sum('amount');

    //                         $liabilityData[] = [
    //                             'sub_title' => 'Equity',
    //                             'title' => 'Owner\'s Capital (Bank)',
    //                             'debit' => 0,
    //                             'credit' => $equity,
    //                         ];
    
    //                         $assetData[] = [
    //                             'sub_title' => $account->acSubAccount?->title,
    //                             'title' => $account->acSubSubAccount?->title,
    //                             'debit' => ($equity +$account->total_debit) - $account->total_credit,
    //                             'credit' => 0
    //                         ];
    //                     }elseif($account->acSubSubAccount?->title == 'Cash'){
    //                         $equity = 0;
    //                         $equity = DB::table('equities')->where('type','CASH')->sum('amount');
    //                         $liabilityData[] = [
    //                             'sub_title' => 'Equity',
    //                             'title' => 'Owner\'s Capital (Cash)',
    //                             'debit' => 0,
    //                             'credit' => $equity,
    //                         ];
    
    //                         $assetData[] = [
    //                             'sub_title' => $account->acSubAccount?->title,
    //                             'title' => $account->acSubSubAccount?->title,
    //                             'debit' => ($equity +$account->total_debit) - $account->total_credit,
    //                             'credit' => 0
    //                         ];
    //                     }else{
    //                         if($account->acSubSubAccount?->title != 'Purchase Return'){
    //                             if($account->acSubSubAccount?->title == 'Accumulated Depreciation'){
    //                                 $assetData[] = [
    //                                     'sub_title' => $account->acSubAccount?->title,
    //                                     'title' => $account->acSubSubAccount?->title == 'Purchase' ? 'Inventory' : $account->acSubSubAccount?->title,
    //                                     'debit' => 0,
    //                                     'credit' => ABS($account->balance)
    //                                 ]; 
    //                             }else{
    //                                 $assetData[] = [
    //                                     'sub_title' => $account->acSubAccount?->title,
    //                                     'title' => $account->acSubSubAccount?->title == 'Purchase' ? 'Inventory' : $account->acSubSubAccount?->title,
    //                                     'debit' => ABS($account->balance),
    //                                     'credit' => 0
    //                                 ]; 
    //                             }
    //                         } 
    //                     }
                       
    //                 }elseif($account->ac_main_account_id == 2){
    //                     if($account->acSubSubAccount?->title != 'Accounts Payable (Return)'){
    //                         $liabilityData[] = [
    //                             'sub_title' => $account->acSubAccount?->title,
    //                             'title' => $account->acSubSubAccount?->title,
    //                             'debit' => 0,
    //                             'credit' => ABS($account->balance),
    //                         ];
    //                     }
    //                 }elseif($account->ac_main_account_id == 4){
    //                     $totalRevenue += ABS($account->balance);
    //                 }elseif($account->ac_main_account_id == 5){
                      
    //                     $totalExpense += $account->balance;
    //                 }
                    
                
                
    //             }   
    //     // dump($totalRevenue - $totalExpense);
    //     $totalRetainedEarning = $totalRevenue - $totalExpense;
    // //    dd($totalRetainedEarning);
    //     $liabilityData[] = [
    //         'sub_title' => 'Earning',
    //         'title' => 'Retained Earning',
    //         'debit' => 0,
    //         'credit' => $totalRetainedEarning,
    //     ];
         
    //     $currentAssets = [];
    //     $fixedAssets = [];
    //     $accumulatedAmount = 0;
    //     foreach ($assetData as $item) {
    //         $subTitle = $item['sub_title'];
    //         if ($subTitle === 'Current Assets') {
    //             $currentAssets[] = $item;
    //         } elseif ($subTitle === 'Fixed Assets') {
    //             if($item['title'] == 'Accumulated Depreciation'){
    //                 $accumulatedAmount += $item['credit'];
    //             }else{
    //                 $fixedAssets[] = $item;
    //             }
    //         }
    //     }
       
    //     $currentLiabilities = [];
    //     $fixedLiabilities = [];
    //     $equities = [];
        
    //     foreach ($liabilityData as $item) {
    //         $subTitle = $item['sub_title'];
    //         if ($subTitle === 'Current Liabilities') {
    //             $currentLiabilities[] = $item;
    //         } elseif ($subTitle === 'Fixed Liabilities') {
    //             $fixedLiabilities[] = $item;
    //         }elseif ($subTitle === 'Equity' || $subTitle === 'Earning'){
    //             $equities[] = $item;
    //         }
    //     }

    //     // return $currentAssets;
    //     return view('backend.account.chart_of_account.balance-sheet',[
    //         'chartOfAccounts' => $accountInfo,
    //         'assetData' =>  $assetData,
    //         'liabilityData' =>$liabilityData,
    //         'currentAssets' => $currentAssets,
    //         'fixedAssets' => $fixedAssets,
    //         'currentLiabilities' => $currentLiabilities,
    //         'fixedLiabilities' => $fixedLiabilities,
    //         'accumulatedAmount' => $accumulatedAmount,
    //         'equities' => $equities,
    //         'fdate' => \Carbon\Carbon::parse($fdate)->format('j F, Y'),
    //         'tdate' => \Carbon\Carbon::parse($tdate)->format('j F, Y'),
    //     ]);       
    // }

    public function getDepreciation(){
       
        return view('backend.account.chart_of_account.assets-depreciation.index',[
            'assetDepreciations' => AssetDepreciationSetting::get()
        ]);
    }

    public function storeDepreciation(Request $request,$id){
        $assetDepreciation = AssetDepreciationSetting::findOrFail($id);
        $assetDepreciation->fill($request->all());
        $assetDepreciation->save();
        return redirect()->route('get.chat.of.account.depreciation')->with('success','Data updated');
    }

    public function inputIncomeStatement(){
        return view('backend.account.chart_of_account.income-statement-input');
    }

    public function getIncomeStatement(Request $request){
        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        $totalSale = 0;
        $totalCogs = 0;
        $totalExpenses = 0;
        $totalDepreciationExpense = 0;
        $assetData = [];
        $expenseInfo = [];
        $individualAccountInfo = $this->getChartOfAccountInfoForIncomeStatement($fdate, $tdate);  
        foreach($individualAccountInfo as $account){
            if($account->ac_main_account_id == 4){
                if($account->acSubSubAccount?->title == 'Finished Goods Sales'){
                    $totalSale += $account->total_credit - $account->total_debit;
                }
                if($account->acSubSubAccount?->title == 'Raw Material Sales'){
                    $totalSale += $account->total_credit - $account->total_debit;
                }

            }elseif($account->ac_main_account_id == 5){
                
                if($account->acSubSubAccount?->title == 'Cost of Goods Sold of Raw Material (RMCOGS)'){
                    $totalCogs = $account->total_debit - $account->total_credit;
                }elseif($account->acSubSubAccount?->title == 'Cost of Good Sold of Finished Goods (FGCOGS)'){
                    $totalCogs = $account->total_debit - $account->total_credit;
                }elseif($account->acSubSubAccount?->title == 'Depreciation Expense'){
                    $totalDepreciationExpense = $account->total_debit - $account->total_credit;
                }else{
                    
                    $title = $account->acSubSubAccount ? $account->acSubSubAccount->title : null;
                    $difference = $account->total_debit - $account->total_credit;
                    $totalExpenses += $difference;
                    if (!is_null($title)) {
                        $expenseInfo[$title] = $difference;
                    }
                }
            }
        }
     
        $assetData = [
            'sales' => $totalSale,
            'cogs'  => $totalCogs,
            'expenseInfo' => $expenseInfo,
            'totalExpenses' => $totalExpenses,
            'totalDepreciationExpense' => $totalDepreciationExpense
        ];

        return view('backend.account.chart_of_account.income-statement',[
                'fdate' =>  $fdate,
                'tdate' => $tdate,
                'assetData' => $assetData
        ]);

    }

    public function inputJournal(){
        return view('backend.account.chart_of_account.journal-input');
    }

    public function getJournal(Request $request){
        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        $coaInfo = $this->getJournalInfoForPurchase($fdate , $tdate);
        $dataSet = [];
        // foreach($coaInfo as $key => $coa){
        //     foreach($coa as $coaList){
        //         $dataSet[] = ;
        //     }
        // }
        // dd($dataSet);

        return view('backend.account.chart_of_account.journal',[
            'fdate' =>  $fdate,
            'tdate' => $tdate,
            'coaInfo' =>  $coaInfo
        ]);
    }
}
