<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account\ChartOfAccounts;
use App\Models\Account\AssetDepreciationInfoDetails;
use App\Models\Account\MainAccount;
// use DB;
use Carbon\Carbon;
use App\Models\Account\AssetDepreciationSetting;
use App\Models\Account\SubAccount;
use App\Models\Account\SubSubAccount;
use App\Models\Account\IndividualAccount;
use App\Models\Supplier;
use App\Models\PurchaseLedger;
use App\Models\ExpanseSubgroup;
use App\Models\Dealer;
use App\Models\SalesLedger;
use App\Models\IncomeStatement;
use App\Models\MasterBank;
use App\Models\InterCompany;
use App\Models\PackingConsumptions;
use App\Models\SalesCategory;
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

          $individualWithoutOpeningAccountInfo = $this->getChartOfAccountInfoWithoutOpening($fdate, $tdate);
          if($fdate == "2023-10-01"){
            $startDate = '2023-09-30';
            $preDate = '2023-09-30';
          } else {
            $startDate = '2023-10-01';
            $preDate =  $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
          }

            $individualWithOpeningAccountInfo = $this->getChartOfAccountInfoWithoutOpening($startDate, $preDate);
            $preTime = strtotime($fdate);
            $preStartDate = date("Y-m-01", strtotime("-1 month", $preTime));
            $preEndDate = date("Y-m-t", strtotime("-1 month", $preTime));

            $retainedEarningOB = IncomeStatement::whereBetween('date',[$preStartDate,$preEndDate])->sum('net_amount');
            //$retainedEarningOB = 0;
          //  dd($retainedEarningOB);
             $fdate = '2023-10-01';
            $accountInfo = [];
            $accountAccrudeExpInfo = [];
            $accountInfoExpenseDebit = [];
            $accountInfoExpenseCredit = [];
            $accountInfoAssetDebit = [];
            $accountSupplierInfo = [];
            $accountDealerInfo = [];
            $accountSisterConcernInfo = [];
            $accountEquityInfo = [];
            $individualAccountInfo = $this->getChartOfAccountInfo($fdate, $tdate);
        //$individualAccountDetailsInfo = $this->getChartOfAccountDetailsInfo($fdate, $tdate);

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
        $aseetOB = $this->totalAseetOb($fdate, $tdate);
        $aseetDepreciationOB = $this->totalAseetDepreciationOb($fdate, $tdate);
      //  dd($fdate);
        // dd($dealerOB);
        //$expenseOB = -24492523.36;
        if($fdate == '2023-10-01'){
         $expenseOB -= 115200;
          //$expenseOB -= 4256120;
          //$expenseOB -= 5507552;
          //$expenseOB -= 5610558;
          //$expenseOB -= 1123898.21;
         //$expenseOB -= 1123932;
          //$expenseOB -= 3173932;
          //$expenseOB += 1581068;
        //$expenseOB = 2628467;
      }
       //dd($expenseOB);

        $othersOB = 0;
        $salesRevenueOB = 0 ;
        $salesReturnOB = 0 ;

        $openingReained = 0;
         foreach($individualWithOpeningAccountInfo as $account3){
           if($account3->ac_main_account_id == 5){
             $openingReained -=  $account3->total_debit - $account3->total_credit;
           } elseif($account3->acSubSubAccount?->title == 'Finished Goods Sales'){
           $openingReained += $account3->total_credit - $account3->total_debit;
           } elseif($account3->acSubSubAccount?->title == 'Sales Returns'){
             $openingReained -=  $account3->total_debit - $account3->total_credit;
           } else {

           }
         }

//dd($openingReained);

        //$accountAmount = ($bankOB + $cashOB + $fgOB + $rmOB +  $dealerOB + $aseetOB + $expenseOB) - ($supplierOB + $interCompanyOB + $equityOB +  $aseetDepreciationOB);
        $accountInfo[] = $this->getCreditSection('Equity',($bankEquity + $cashEquity + $equityOB));
        //dd($dealerOB);
      //  -3854163.18
      

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
            $retainedInfo = 0;
            foreach($individualAccountInfo as $account){
                  if($account->ac_main_account_id == 1 || $account->ac_main_account_id == 3 || $account->ac_main_account_id == 4){
                    if($account->acSubSubAccount?->title == 'Bank'){
                        $accountInfo[] = $this->getDebitSection($account->acSubSubAccount?->title , ($bankEquity + $bankOB + $account->balance));
                        $isBank++;
                    } elseif($account->acSubSubAccount?->title == 'Cash'){
                        $accountInfo[] = $this->getDebitSection($account->acSubSubAccount?->title , ($cashEquity + $cashOB + $account->balance));
                        $isCash++;
                    } elseif($account->acSubSubAccount?->title == 'Purchase'){
                        $accountInfo[] =  $this->getDebitSection('Purchase' , ($rmOB + $account->total_debit - $account->total_credit));
                        $isPurchase++;
                    } elseif($account->acSubSubAccount?->title == 'Inventory(FG)'){
                        $accountInfo[] =  $this->getDebitSection('Inventory(FG)' , ($fgOB + ($account->total_debit - $account->total_credit)));
                        // print_r($fgOB); echo "<br>";
                        // print_r($account->total_debit); echo "<br>";
                        // print_r($account->total_credit); echo "<br>";
                        // exit;
                        $isInventoryFg++;
                    } elseif($account->acSubSubAccount?->title == 'Accounts Receivable (Dealer)'){
                        $accountInfo[] =  $this->getDebitSection($account->acSubSubAccount?->title , ($dealerOB + ($account->total_debit - $account->total_credit)));
                        $isAccountReceivable++;
                    } elseif($account->acSubSubAccount?->title == 'Accumulated Depreciation'){
                        /* $amount = AssetDepreciationInfoDetails::whereBetween('date',[$fdate,$tdate])->sum('account_value');
                        $accountInfo[] =  $this->getCreditSection($account->acSubSubAccount?->title , $amount); */

                        $accountInfo[] =  $this->getCreditSection($account->acSubSubAccount?->title , ($account->total_credit - $account->total_debit));

                    } elseif($account->acSubSubAccount?->title == 'Finished Goods Sales'){
                    /*  $accountInfo[] =  $this->getCreditSection($account->acSubSubAccount?->title , (($account->total_credit + $salesRevenueOB) - $account->total_debit));
                      $isSalesRevenue++; */
                    } elseif($account->acSubSubAccount?->title == 'Others Income'){
                      //$accountInfo[] =  $this->getCreditSection($account->acSubSubAccount?->title , ( $othersOB + $account->total_credit - $account->total_debit));
                    //  $isOthersIncome++;
                    } elseif($account->acSubSubAccount?->title == 'Sales Returns'){

                        /*  $accountInfo2[] =  $this->getDebitSection($account->acSubSubAccount?->title , ($salesReturnOB + $account->total_debit - $account->total_credit));
                          $isSalesReturn2++; */
                      } elseif($account->acSubSubAccount?->title == 'Retained Earning'){
                            $retainedInfo += ($account->total_credit - $account->total_debit);
                        /* $accountInfo[] =  $this->getDebitSection($account->acSubSubAccount?->title , ($salesReturnOB + $account->total_debit - $account->total_credit));
                        $isSalesReturn++; */
                    } elseif($account->ac_main_account_id == 1){
                      $accountInfoAssetDebit[] = $this->getDebitSectionExpense($account->acSubAccount?->id,$account->acSubSubAccount?->title , ($account->total_debit - $account->total_credit));
                      //$accountInfoAssetDebit[] = $this->getAssetInfo($account->acSubAccount?->id,$account->acSubSubAccount?->id,$account->acSubSubAccount?->title);
                    }  elseif($account->acSubSubAccount?->title == 'Others Income'){

                    }else{
                        $accountInfo[] =  $this->getDebitSection($account->acSubSubAccount?->title , ($account->total_debit - $account->total_credit));
                    }

                }elseif($account->ac_main_account_id == 5){

                    //$accountInfoExpenseDebit[] = $this->getDebitSectionExpense($account->acSubAccount?->id,$account->acSubSubAccount?->title , ($account->total_debit - $account->total_credit));

                }else{
                    if($account->acSubSubAccount?->title == 'Accounts Payable (Suppliers)'){
                        // dd($account->total_credit - $account->total_debit);
                     $accountInfo[] =  $this->getCreditSection($account->acSubSubAccount?->title , ($supplierOB + ($account->total_credit - $account->total_debit)));
                            $isAccountPayable++;

                    }else{

                        if($account->acSubSubAccount?->title == 'ACCRUED EXPANSES'){
                        //dd($account->acSubSubAccount?->id);
                        $accruedExpenses = $this->getChartOfCurrentLaibilityInfo($account->acSubSubAccount?->id,$fdate, $tdate);
                        //dd($accruedExpenses);
                        foreach($accruedExpenses as $accruedExp){
                          $accountAccrudeExpInfo[] =  $this->getCreditSection($accruedExp->title , $accruedExp->balance);
                        }
                      } else {
                        $accountInfo[] =  $this->getCreditSection($account->acSubSubAccount?->title , ($account->total_credit - $account->total_debit));
                      }
                    }
                }
            }

          //  dd($retainedInfo);

            //$accountInfo[] = $this->getCreditSection('Retained Earning',$retainedEarningOB + $openingReained + $retainedInfo);
            //dd($accountInfo);
            $retainedEarning = $retainedEarningOB + $openingReained + $retainedInfo;

            //dd($accountInfo);
            //non-current Asset
            $nonCurrentAsset = SubAccount::select('id','title')->where('title','Non Current Assests')->first();
            $getNonCurrentAssets = SubSubAccount::select('id','title')->where('ac_sub_account_id',$nonCurrentAsset->id)->get();

            foreach($getNonCurrentAssets as $asset){
              $getIndividualNonCurrentAssets = IndividualAccount::select('id','title')->where('ac_sub_sub_account_id',$asset->id)->get();
              foreach ($getIndividualNonCurrentAssets as $value) {
                $accountExtendedNonCurrentAssetInfo[] = $this->getDebitForNonCurrentAsset($asset->title, $value->id, $value->title, $fdate, $tdate);

              }
            }
            

            $assetLand = [];
            $assetOffEquip = [];
            $assetPlant = [];
            $assetMotor = [];
            $assetBuilding = [];
            $assetElectrical = [];
            $assetComputer = [];
            $assetFurniture = [];
            $assetOthers = [];
            //dd($accountExtendedNonCurrentAssetInfo);
            foreach($accountExtendedNonCurrentAssetInfo as $assetVal){
              if($assetVal['group'] != 'NULL'){
                if($assetVal['group'] == 'Land & Land Development'){
                  $assetLand[] = $assetVal;
                } elseif($assetVal['group'] == 'Office Equipments'){
                  $assetOffEquip[] = $assetVal;
                }
                elseif($assetVal['group'] == 'Plant & Mechineries'){
                  $assetPlant[] = $assetVal;
                }
                elseif($assetVal['group'] == 'Motor Vehicle'){
                  $assetMotor[] = $assetVal;
                }
                elseif($assetVal['group'] == 'Building & Civil Construction'){
                  $assetBuilding[] = $assetVal;
                }
                elseif($assetVal['group'] == 'Electrical Equipment'){
                  $assetElectrical[] = $assetVal;
                }
                elseif($assetVal['group'] == 'Computer & Software'){
                  $assetComputer[] = $assetVal;
                }
                elseif($assetVal['group'] == 'Furniture & Fixture'){
                  $assetFurniture[] = $assetVal;
                }
                elseif($assetVal['group'] == 'Preliminary Expanse'){
                  $assetOthers[] = $assetVal;
                } else {

                }

              }
            }
            //non-current Asset end

          //  FinishGood Inventory
            $category = SalesCategory::select('id','category_name as name')->orderBy('category_name', 'asc')->get();
            $fgInventoryInfo = [];
              $subAmount = 0;
              $startdate = '2023-10-01';
              $totalPackingConsumption = PackingConsumptions::whereBetween('date',[$startdate,$tdate])->sum('amount');
              $totalPackingCost = ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','Sal-%')->whereBetween('date',[$startdate,$tdate])->sum('debit');
              $totalPackingReturnCost = ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','SR-Inv-%')->whereBetween('date',[$startdate,$tdate])->sum('credit');
              //$totalReturnValue = \App\Models\Account\ChartOfAccounts::where('ac_sub_account_id',1)->where('ac_sub_sub_account_id',25)->where('invoice','like','SR-Inv-%')->whereBetween('date',[$startdate,$tdate])->sum('debit');
              $packingCost = ($totalPackingConsumption + $totalPackingReturnCost) - $totalPackingCost;

            foreach ($category as $key => $cat) {
                  $products = \App\Models\SalesProduct::where('category_id',$cat->id)->orderby('product_name', 'asc')->get();
                  $amount = 0;
                  foreach ($products as $key => $value) {
                    $allStockAmount = \App\Models\SalesStockIn::where('prouct_id',$value->id)->whereBetween('date',[$startdate,$tdate])->sum('total_cost');
                    $stockOutAmount = \App\Models\SalesStockOut::where('product_id',$value->id)->whereBetween('date',[$startdate,$tdate])->sum('amount');
                    $damageAmount = \App\Models\SalesDamage::where('product_id',$value->id)->whereBetween('date',[$startdate,$tdate])->sum('amount');

                    $amount += ($value->opening_balance*$value->rate)   + $allStockAmount - ($stockOutAmount + $damageAmount);
                    //$subAmount += $temp;

                  }
                  $fgInventoryInfo[] = $this->getDebitSection($cat->name, $amount);
            }

            $fgInventoryInfo[] = $this->getDebitSection('Finished Goods Inventory Packing Amount', $packingCost);
            
            //dd($fgInventoryInfo);

          //  $total = $subAmount + $packingCost;

          //without Opening
          foreach($individualWithoutOpeningAccountInfo as $account2){
            if($account2->ac_main_account_id == 5){
              $accountInfoExpenseDebit[] = $this->getDebitSectionExpense($account2->acSubAccount?->id,$account2->acSubSubAccount?->title , ($account2->total_debit - $account2->total_credit));
            } elseif($account2->acSubSubAccount?->title == 'Finished Goods Sales'){
              $accountInfo[] =  $this->getCreditSection($account2->acSubSubAccount?->title , ($account2->total_credit - $account2->total_debit));
            } elseif($account2->acSubSubAccount?->title == 'Sales Returns'){
              $accountInfo[] =  $this->getDebitSection($account2->acSubSubAccount?->title , ($account2->total_debit - $account2->total_credit));
            } elseif($account2->acSubSubAccount?->title == 'Others Income'){
                $accountInfo[] =  $this->getCreditSection($account2->acSubSubAccount?->title , ($account2->total_credit - $account2->total_debit));
            } else {
              $accountInfo[] =  $this->getDebitSection($account2->acSubSubAccount?->title , ($account2->total_debit - $account2->total_credit));
            }
          }

          //dd($accountInfo);

            $suppliers = Supplier::get();
            foreach ($suppliers as $value) {
              $accountSupplierInfo[] = $this->supplierAccountPayableInfo($value->id,$value->supplier_name,$value->opening_balance,$fdate, $tdate);

            }
            //$dealers = Dealer::whereBetween('created_at',[$fdate, $tdate])->get();
            $dealers = Dealer::get();
            foreach ($dealers as $value) {
              $accountDealerInfo[] = $this->dealerAccountPayableInfo($value->id,$value->d_s_name,$value->dlr_base,$fdate, $tdate);
            }

            /*$dealers = IndividualAccount::where('ac_sub_sub_account_id',15)->get();
              foreach ($dealers as $value) {
                //$accountDealerInfo[] = $this->dealerAccountPayableInfo($value->id,$value->d_s_name,$value->dlr_base,$fdate, $tdate);
                $opening = Dealer::where('d_s_name',$value->title)->value('dlr_base');
                $accountDealerInfo[] = $this->dealerAccountPayableInfo($value->id,$value->title,$opening,$fdate, $tdate);
              } */

            $allCompany = InterCompany::where('status',1)->orderBy('name', 'asc')->get();

            foreach ($allCompany as $value) {
              $accountSisterConcernInfo[] = $this->sisterConcernAccountPayableInfo($value->id,$value->name,$value->balance,$fdate, $tdate);
            }

            $equities = DB::table('equities')->orderBy('name', 'asc')->get();
            foreach ($equities as $value) {
              $accountEquityInfo[] = $this->equityAccountPayableInfo($value->name,$value->amount);
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

            if($isAccountReceivable < 1){
                $accountInfo[] = $this->getDebitSection('Accounts Receivable (Dealer)' , $dealerOB);
            }

          /*  if($isOthersIncome < 1){
                $accountInfo[] = $this->getCreditSection('Others Income' , $othersOB);
            } */

            foreach($accountInfoExpenseCredit as $val){
            //  dd($val);
            }

            usort($accountInfo, function($a, $b) {
                return strcmp($a['title'], $b['title']);
            });

            $currentAsset =[];
            $fixedAsset =[];
            $nonCurrentAsset =[];
            $otherFixedAsset =[];
          //  dd($accountInfoAssetDebit);
            foreach($accountInfoAssetDebit as $item){
              $id = $item['id'];
              if($id === 1) {
                  $currentAsset[] = $item;
                }elseif($id == 2){
                  $fixedAsset[] = $item;
                }elseif($id == 48){
                 $nonCurrentAsset[] = $item;
               }elseif($id == 51){
                  //$otherFixedAsset[] = $item;
                }
            }

            $cogsExp =[];
            $directExp =[];
            $financialExp =[];
            $sellingDistributionExpSD =[];
            $factoryOverHeadExp =[];
            $rechearceDevelopExp =[];
            $othersDirectExp =[];
            $sellingDistributionExp =[];
            $tdsPayableExp = [];
            $officeAdminExp = [];
            $othersExp = [];

            foreach($accountInfoExpenseDebit as $item){
              $id = $item['id'];

              if($id === 8) {
                  $cogsExp[] = $item;
                }elseif($id == 9){
                  $directExp[] = $item;
                }elseif($id == 10){
                  $financialExp[] = $item;
              }elseif($id == 52){
                  $sellingDistributionExpSD[] = $item;
              }elseif($id == 21){
                  $factoryOverHeadExp[] = $item;
              }elseif($id == 22){
                  $rechearceDevelopExp[] = $item;
              }elseif($id == 23){
                  $officeAdminExp[] = $item;
              }elseif($id == 27){
                  $othersDirectExp[] = $item;
              }elseif($id == 33){
                  $tdsPayableExp[] = $item;
                } else {
                  $othersExp[] = $item;
                }
            }
            if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
        //dd($accountInfo);
            return view('backend.account.chart_of_account.trail_balance_sheet',[
                'chartOfAccounts' => $accountInfo,
                'currentAsset' => $currentAsset,
                'fixedAsset' => $fixedAsset,
                'nonCurrentAsset' => '',
              //  'otherFixedAsset' => $otherFixedAsset,
                'otherFixedAsset' => '',
                'officeAdminExp' => $officeAdminExp,
                'cogsExp' => $cogsExp,
                'directExp' => $directExp,
                'financialExp' => $financialExp,
                'sellingDistributionExpSD' => $sellingDistributionExpSD,
                'factoryOverHeadExp' => $factoryOverHeadExp,
                'rechearceDevelopExp' => $rechearceDevelopExp,
                'othersDirectExp' => $othersDirectExp,
                //'sellingDistributionExp' => $sellingDistributionExp,
                'tdsPayableExp' => '',
                'othersExp' => $othersExp,
                'accrudeExpenses' => $accountAccrudeExpInfo,
                'fdate' => \Carbon\Carbon::parse($fdate)->format('j F, Y'),
                'tdate' => \Carbon\Carbon::parse($tdate)->format('j F, Y'),
                'accountSupplierInfo' => $accountSupplierInfo,
                'accountDealerInfo' => $accountDealerInfo,
                'accountSisterConcernInfo' => $accountSisterConcernInfo,
                'accountEquityInfo' => $accountEquityInfo,
                'fgInventoryInfo' => $fgInventoryInfo,
                'assetLand' => $assetLand,
                'assetOffEquip' => $assetOffEquip,
                'assetPlant' => $assetPlant,
                'assetMotor' => $assetMotor,
                'assetBuilding' => $assetBuilding,
                'assetElectrical' => $assetElectrical,
                'assetComputer' => $assetComputer,
                'assetFurniture' => $assetFurniture,
                'assetOthers' => $assetOthers,
                'retainedEarning' => $retainedEarning

            ]);

    }



  public function getComparedTrailBalanceSheet(Request $request)
  {
       $information = [];
      if($request->date){
        $dates = explode(' - ', $request->date);
        $fdate = date('Y-m-d', strtotime($dates[0]));
        $endDate = date('Y-m-d', strtotime($dates[1]));

      }

      $tdate = date("Y-m-t", strtotime($fdate));

        while($tdate <= $endDate){
            $monthWord = date('F, y', strtotime($fdate));
            $tdate = date("Y-m-t", strtotime($fdate));

            $individualWithoutOpeningAccountInfo = $this->getChartOfAccountInfoWithoutOpening($fdate, $tdate);

            if($fdate == "2023-10-01"){
              $startDate = '2023-09-30';
              $preDate = '2023-09-30';
            } else {
              $startDate = '2023-10-01';
              $preDate =  $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
            }

            $individualWithOpeningAccountInfo = $this->getChartOfAccountInfoWithoutOpening($startDate, $preDate);

            $preTime = strtotime($fdate);
            $preStartDate = date("Y-m-01", strtotime("-1 month", $preTime));
            $preEndDate = date("Y-m-t", strtotime("-1 month", $preTime));

          $retainedEarningOB = IncomeStatement::whereBetween('date',[$preStartDate,$preEndDate])->sum('net_amount');

          $expenseId = [];
          $accountInfoExpenseDebit2 = [];
          $expenseIds = SubAccount::select('id')->where('ac_main_account_id',5)->groupBy('title')->orderBy('title', 'asc')->get();
          foreach($expenseIds as $val){
            $expenseId[] = $val->id;
          }
          //dd($expenseId);

         $officeAdminExp = SubSubAccount::select('id','title','ac_sub_account_id as expId')->whereIn('ac_sub_account_id',$expenseId)->groupBy('title')->orderBy('title', 'asc')->get();
          foreach($officeAdminExp as $val){
            //dr - cr
            $temp = ChartOfAccounts::select( DB::raw('SUM(debit) as total_debit'),
                    DB::raw('SUM(credit) as total_credit'),
                    DB::raw('SUM(debit) - SUM(credit) as balance')
                )->where('ac_main_account_id',5)->where('ac_sub_account_id',$val->expId)->where('ac_sub_sub_account_id',$val->id)
                ->where(function ($query) use ($fdate, $tdate) {
                    $query->whereBetween('date', [$fdate, $tdate]);
                })->first();

            // if($val->id == 150){
            //     echo "<pre>";
            //     echo $val->id;
            //      echo "<pre>";
            //     echo $val->expId;
            //      echo "<pre>";
            //     print_r($temp);
            // }
          $accountInfoExpenseDebit2[] = $this->getDebitSectionExpense($val->expId, $val->title, $temp->balance);
        }
        //exit;
        


          $fdate = '2023-10-01';
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
          $aseetOB = $this->totalAseetOb($fdate, $tdate);
          $aseetDepreciationOB = $this->totalAseetDepreciationOb($fdate, $tdate);


            $expenseOB -= 4256120;

            $othersOB = 0;
            $salesRevenueOB = 0 ;
            $salesReturnOB = 0 ;

          $accountInfo2 = [];
          $othersIncomeInfo = [];
          $accountAccrudeExpInfo2 = [];
          $accountInfoExpenseCredit2 = [];
          $accountInfoAssetDebit2 = [];
          $accountSupplierInfo = [];
          $accountDealerInfo = [];
          $accountCurrentAssetDebitInfo = [];
          $accountExtendedNonCurrentAssetInfo = [];
          $individualAccountInfo2 = $this->getChartOfAccountInfo($fdate, $tdate);

          $openingReained = 0;
           foreach($individualWithOpeningAccountInfo as $account3){
             if($account3->ac_main_account_id == 5){
               $openingReained -=  $account3->total_debit - $account3->total_credit;
             } elseif($account3->acSubSubAccount?->title == 'Finished Goods Sales'){
               $openingReained += $account3->total_credit - $account3->total_debit;
             } elseif($account3->acSubSubAccount?->title == 'Sales Returns'){
               $openingReained -=  $account3->total_debit - $account3->total_credit;
             } elseif( $account3->acSubSubAccount?->title == 'Others Income') {
               $openingReained += $account3->total_credit - $account3->total_debit;
             } else {

             }
           }


          //$accountAmount = ($bankOB + $cashOB + $fgOB + $rmOB +  $dealerOB + $aseetOB + $expenseOB + $salesReturnOB) - ($supplierOB + $interCompanyOB + $equityOB + $othersOB +$salesRevenueOB + $retainedEarningOB + $aseetDepreciationOB);
          $accountInfo2[] = $this->getCreditSection('Equity',($bankEquity + $cashEquity + $equityOB));

              $isBank2 = 0;
              $isCash2 = 0;
              $isPurchase2 = 0;
              $isAccountPayable2 = 0;
              $isInventoryFg2 = 0;
              $isAccountReceivable2 = 0;
              $isEquity2 =0;
              $isOthersIncome2 = 0;
              $isSalesRevenue2 = 0;
              $isSalesReturn2 = 0;
              $retainedInfo = 0;
              foreach($individualAccountInfo2 as $account){
                    if($account->ac_main_account_id == 1 || $account->ac_main_account_id == 3 || $account->ac_main_account_id == 4){
                      if($account->acSubSubAccount?->title == 'Bank'){
                          $accountInfo2[] = $this->getDebitSection($account->acSubSubAccount?->title , ($bankEquity + $bankOB + $account->balance));
                          $isBank2++;
                      }elseif($account->acSubSubAccount?->title == 'Cash'){
                          $accountInfo2[] = $this->getDebitSection($account->acSubSubAccount?->title , ($cashEquity + $cashOB + $account->balance));
                          $isCash2++;
                      }elseif($account->acSubSubAccount?->title == 'Purchase'){
                          $accountInfo2[] =  $this->getDebitSection('Purchase' , ($rmOB + $account->total_debit - $account->total_credit));
                          $isPurchase2++;
                      }elseif($account->acSubSubAccount?->title == 'Inventory(FG)'){
                        /////////////////////////////////////////////////////////////////
                            //  FinishGood Inventory
                            $category = SalesCategory::select('id','category_name as name')->orderBy('category_name', 'asc')->get();
                            $fgInventoryInfo = [];
                              $subAmount = 0;
                              $startdate = '2023-10-01';
                              $totalPackingConsumption = PackingConsumptions::whereBetween('date',[$startdate,$tdate])->sum('amount');
                              $totalPackingCost = ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','Sal-%')->whereBetween('date',[$startdate,$tdate])->sum('debit');
                              $totalPackingReturnCost = ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','SR-Inv-%')->whereBetween('date',[$startdate,$tdate])->sum('credit');
                              //$totalReturnValue = \App\Models\Account\ChartOfAccounts::where('ac_sub_account_id',1)->where('ac_sub_sub_account_id',25)->where('invoice','like','SR-Inv-%')->whereBetween('date',[$startdate,$tdate])->sum('debit');
                              $packingCost = ($totalPackingConsumption + $totalPackingReturnCost) - $totalPackingCost;
                              
                
                            foreach ($category as $key => $cat) {
                                  $products = \App\Models\SalesProduct::where('category_id',$cat->id)->orderby('product_name', 'asc')->get();
                                  $amount = 0;
                                  foreach ($products as $key => $value) {
                                    $allStockAmount = \App\Models\SalesStockIn::where('prouct_id',$value->id)->whereBetween('date',[$startdate,$tdate])->sum('total_cost');
                                    $stockOutAmount = \App\Models\SalesStockOut::where('product_id',$value->id)->whereBetween('date',[$startdate,$tdate])->sum('amount');
                                    $damageAmount = \App\Models\SalesDamage::where('product_id',$value->id)->whereBetween('date',[$startdate,$tdate])->sum('amount');
                
                                    $amount += ($value->opening_balance*$value->rate)   + $allStockAmount - ($stockOutAmount + $damageAmount);
                                    //$subAmount += $temp;
                
                                  }
                                  $fgInventoryInfo[] = $this->getDebitSection($cat->name, $amount);
                            }
                
                            $fgInventoryInfo[] = $this->getDebitSection('Finished Goods Inventory Packing Amount', $packingCost);
                            $i_f_g_v = array_sum(array_column($fgInventoryInfo, 'debit'));
                            $accountInfo2[] =  $this->getDebitSection('Inventory(FG)' , $i_f_g_v);
                            
                            //echo "<pre>";
                            //dd($account);
                            //   print_r(array_sum(array_column($fgInventoryInfo, 'debit'))); echo "<br>";
                            //   print_r($totalPackingConsumption); echo "<br>";
                            // print_r($totalPackingCost); echo "<br>";
                            // print_r($totalPackingReturnCost); echo "<br>";
                            // exit;
                            //dd(array_sum(array_column($fgInventoryInfo, 'debit')));
                        /////////////////////////////////////////////////////////////////
                          
                        $isInventoryFg2++;
                      }elseif($account->acSubSubAccount?->title == 'Accounts Receivable (Dealer)'){
                          $accountInfo2[] =  $this->getDebitSection($account->acSubSubAccount?->title , ($dealerOB + ($account->total_debit - $account->total_credit)));
                          $isAccountReceivable2++;
                      }elseif($account->acSubSubAccount?->title == 'Accumulated Depreciation'){

                          $accountInfo2[] =  $this->getCreditSection($account->acSubSubAccount?->title , ($account->total_credit - $account->total_debit));

                      }elseif($account->acSubSubAccount?->title == 'Finished Goods Sales'){
                        /* $accountInfo2[] =  $this->getCreditSection($account->acSubSubAccount?->title , (($account->total_credit + $salesRevenueOB) - $account->total_debit));
                        $isSalesRevenue2++; */
                      }elseif($account->acSubSubAccount?->title == 'Others Income'){
                      //  $accountInfo2[] =  $this->getCreditSection($account->acSubSubAccount?->title , ( $othersOB + $account->total_credit - $account->total_debit));
                        //$isOthersIncome2++;
                      }elseif($account->acSubSubAccount?->title == 'Sales Returns'){

                        /*  $accountInfo2[] =  $this->getDebitSection($account->acSubSubAccount?->title , ($salesReturnOB + $account->total_debit - $account->total_credit));
                          $isSalesReturn2++; */
                      }elseif($account->acSubSubAccount?->title == 'Retained Earning'){
                          $retainedInfo += ($account->total_credit - $account->total_debit);

                        /*  $accountInfo2[] =  $this->getDebitSection($account->acSubSubAccount?->title , ($salesReturnOB + $account->total_debit - $account->total_credit));
                          $isSalesReturn2++; */
                      } elseif($account->ac_main_account_id == 1){
                         if($account->acSubAccount?->id == 1 || $account->acSubAccount?->id == 2 || $account->acSubAccount?->id == 48){
                          $accountInfoAssetDebit2[] = $this->getDebitSectionExpense($account->acSubAccount?->id,$account->acSubSubAccount?->title , ($account->total_debit - $account->total_credit));
                        }
                      //  $accountInfoAssetDebit2[] = $this->getDebitSectionExpense($account->acSubAccount?->id,$account->acSubSubAccount?->title , ($account->total_debit - $account->total_credit));
                      }else{
                          $accountInfo2[] =  $this->getDebitSection($account->acSubSubAccount?->title , ($account->total_debit - $account->total_credit));
                      }

                  }elseif($account->ac_main_account_id == 5){

                  //$accountInfoExpenseDebit2[] = $this->getDebitSectionExpense($account->acSubAccount?->id,$account->acSubSubAccount?->title , ($account->total_debit - $account->total_credit));

                  }else{
                      if($account->acSubSubAccount?->title == 'Accounts Payable (Suppliers)'){
                       $accountInfo2[] =  $this->getCreditSection($account->acSubSubAccount?->title , ($supplierOB + ($account->total_credit - $account->total_debit)));
                              $isAccountPayable2++;

                      }else{

                          if($account->acSubSubAccount?->title == 'ACCRUED EXPENSES'){
                          $accruedExpenses = $this->getChartOfCurrentLaibilityInfo($account->acSubSubAccount?->id,$fdate, $tdate);
                          foreach($accruedExpenses as $accruedExp){
                            $accountAccrudeExpInfo2[] =  $this->getCreditSection($accruedExp->title , $accruedExp->balance);
                          }
                        } else {
                          $accountInfo2[] =  $this->getCreditSection($account->acSubSubAccount?->title , ($account->total_credit - $account->total_debit));
                        }

                      }
                  }
              }

              //  $accountInfo2[] = $this->getCreditSection('Retained Earning',$retainedEarningOB+$accountAmount + $openingReained + $retainedInfo);

              //without Opening
              foreach($individualWithoutOpeningAccountInfo as $account2){
                if($account2->ac_main_account_id == 5){
                  $accountInfoExpenseDebit[] = $this->getDebitSectionExpense($account2->acSubAccount?->id,$account2->acSubSubAccount?->title , ($account2->total_debit - $account2->total_credit));
                } elseif($account2->acSubSubAccount?->title == 'Finished Goods Sales'){
                  $accountInfo2[] =  $this->getCreditSection($account2->acSubSubAccount?->title , ($account2->total_credit - $account2->total_debit));
                } elseif($account2->acSubSubAccount?->title == 'Sales Returns'){
                  $accountInfo2[] =  $this->getDebitSection($account2->acSubSubAccount?->title , ($account2->total_debit - $account2->total_credit));
                } elseif($account2->acSubSubAccount?->title == 'Others Income'){
                    $othersIncomeInfo[] =  $this->getCreditSection($account2->acSubSubAccount?->title , ($account2->total_credit - $account2->total_debit));
                } else {
                  $accountInfo2[] =  $this->getDebitSection($account2->acSubSubAccount?->title , ($account2->total_debit - $account2->total_credit));
                }
              }

              

              //dd($accountInfo);
              //Current Asset
              /*  $currentAsset = SubSubAccount::select('id','title')->where('ac_sub_account_id',1)->groupBy('title')->orderBy('title', 'asc')->get();
                foreach($currentAsset as $val){
                  $temp = ChartOfAccounts::select( DB::raw('SUM(debit) as total_debit'),
                          DB::raw('SUM(credit) as total_credit'),
                          DB::raw('SUM(debit) - SUM(credit) as balance')
                      )->where('ac_main_account_id',1)->where('ac_sub_sub_account_id',$val->id)
                      ->where(function ($query) use ($fdate, $tdate) {
                          $query->whereBetween('date', [$fdate, $tdate]);
                      })->first();

                  $accountInfoAssetDebit2[] = $this->getDebitSectionExpense( 1, $val->title, $temp->balance);
                } */

              //Others Fixed Asset
              $othersFixedAsset = SubSubAccount::select('id','title')->where('ac_sub_account_id',51)->groupBy('title')->orderBy('title', 'asc')->get();

              foreach($othersFixedAsset as $val){
                //dr - cr
                $temp = ChartOfAccounts::select( DB::raw('SUM(debit) as total_debit'),
                        DB::raw('SUM(credit) as total_credit'),
                        DB::raw('SUM(debit) - SUM(credit) as balance')
                    )->where('ac_main_account_id',1)->where('ac_sub_sub_account_id',$val->id)
                    ->where(function ($query) use ($fdate, $tdate) {
                        $query->whereBetween('date', [$fdate, $tdate]);
                    })->first();

                $accountInfoAssetDebit2[] = $this->getDebitSectionExpense( 51, $val->title, $temp->balance);
              }

                  $suppliers = Supplier::get();
              foreach ($suppliers as $value) {
                $accountSupplierInfo[] = $this->supplierAccountPayableInfo($value->id,$value->supplier_name,$value->opening_balance,$fdate, $tdate);

              }

              $dealers = Dealer::get();
              foreach ($dealers as $value) {
                $accountDealerInfo[] = $this->dealerAccountPayableInfo($value->id,$value->d_s_name,$value->dlr_base,$fdate, $tdate);
              }

              if($isBank2 < 1){
                  $accountInfo2[] = $this->getDebitSection('Bank' , ($bankOB + $bankEquity));
              }
              if($isCash2 < 1){
                  $accountInfo2[] = $this->getDebitSection('Cash' , ($cashOB + $cashEquity));
              }
              if($isAccountPayable2 < 1){
                  $accountInfo2[] = $this->getCreditSection('Accounts Payable (Suppliers)' , $supplierOB);
              }
              if($isPurchase2 < 1){
                  $accountInfo2[] = $this->getDebitSection('Purchase' , $rmOB);
              }
              if($isInventoryFg2 < 1){
                  $accountInfo2[] = $this->getDebitSection('Inventory(FG)' , $fgOB);
              }

              if($isAccountReceivable2 < 1){
                  $accountInfo2[] = $this->getDebitSection('Accounts Receivable (Dealer)' , $dealerOB);
              }
              
              
              $retainedEarning = $retainedEarningOB + $openingReained + $retainedInfo;
              
            //   echo $retainedEarningOB; echo "<br/>";
            //   echo $openingReained; echo "<br/>";
            //   echo $retainedInfo; echo "<br/>";
            //   echo $retainedEarning; echo "<br/>";
            //   exit;

              //dd($accountInfo);
              //Current Asset
              $getCurrentAssets = SubSubAccount::select('id','title')->where('ac_sub_account_id',1)->whereNotIn('title',['Bank','Cash','Purchase','Accounts Receivable (Dealer)','Purchase Return','Inventory(FG)'])->get();
              foreach($getCurrentAssets as $value){
                $accountCurrentAssetDebitInfo[] = $this->getDebitForCurrentAsset($value->id, $value->title, $fdate, $tdate);
              }
              //dd($accountCurrentAssetDebitInfo);
              //Current Asset End
              //non-current Asset
              $nonCurrentAsset = SubAccount::select('id','title')->where('title','Non Current Assests')->first();
              $getNonCurrentAssets = SubSubAccount::select('id','title')->where('ac_sub_account_id',$nonCurrentAsset->id)->get();

              foreach($getNonCurrentAssets as $asset){
                $getIndividualNonCurrentAssets = IndividualAccount::select('id','title')->where('ac_sub_sub_account_id',$asset->id)->get();
                foreach ($getIndividualNonCurrentAssets as $value) {
                  $accountExtendedNonCurrentAssetInfo[] = $this->getDebitForNonCurrentAsset($asset->title, $value->id, $value->title, $fdate, $tdate);

                }
              }


              $assetLand = [];
              $assetOffEquip = [];
              $assetPlant = [];
              $assetMotor = [];
              $assetBuilding = [];
              $assetElectrical = [];
              $assetComputer = [];
              $assetFurniture = [];
              $assetOthers = [];
              //dd($accountExtendedNonCurrentAssetInfo);
              foreach($accountExtendedNonCurrentAssetInfo as $assetVal){
                if($assetVal['group'] != 'NULL'){
                  if($assetVal['group'] == 'Land & Land Development'){
                    $assetLand[] = $assetVal;
                  } elseif($assetVal['group'] == 'Office Equipments'){
                    $assetOffEquip[] = $assetVal;
                  }
                  elseif($assetVal['group'] == 'Plant & Mechineries'){
                    $assetPlant[] = $assetVal;
                  }
                  elseif($assetVal['group'] == 'Motor Vehicle'){
                    $assetMotor[] = $assetVal;
                  }
                  elseif($assetVal['group'] == 'Building & Civil Construction'){
                    $assetBuilding[] = $assetVal;
                  }
                  elseif($assetVal['group'] == 'Electrical Equipment'){
                    $assetElectrical[] = $assetVal;
                  }
                  elseif($assetVal['group'] == 'Computer & Software'){
                    $assetComputer[] = $assetVal;
                  }
                  elseif($assetVal['group'] == 'Furniture & Fixture'){
                    $assetFurniture[] = $assetVal;
                  }
                  elseif($assetVal['group'] == 'Preliminary Expanse'){
                    $assetOthers[] = $assetVal;
                  } else {

                  }

                }
              }
              //non-current Asset end
              
              //dd($assetComputer);

              /* if($isOthersIncome2 < 1){
                  $accountInfo2[] = $this->getCreditSection('Others Income' , $othersOB);
              } */

              usort($accountInfo2, function($a, $b) {
                  return strcmp($a['title'], $b['title']);
              });

              $currentAsset2 =[];
              $fixedAsset2 =[];
              $nonCurrentAsset2 =[];
              $otherFixedAsset2 =[];

              foreach($accountInfoAssetDebit2 as $item){
                $id = $item['id'];
                if($id == 1) {
                  //  $currentAsset2[] = $item;
                  }elseif($id == 2){
                    $fixedAsset2[] = $item;
                  }elseif($id == 48){
                   $nonCurrentAsset2[] = $item;
                 }elseif($id == 51){
                    //$otherFixedAsset2[] = $item;
                  }
              }

              $cogsExp2 =[];
              $directExp2 =[];
              $financialExp2 =[];
              $sellingDistributionExpSD2 =[];
              $factoryOverHeadExp2 =[];
              $rechearceDevelopExp2 =[];
              $othersDirectExp2 =[];
              $sellingDistributionExp2 =[];
              $tdsPayableExp2 = [];
              $officeAdminExp2 = [];
              $othersExp2 = [];

              foreach($accountInfoExpenseDebit2 as $item){
                $id = $item['id'];

                if($id == 8) {
                    $cogsExp2[] = $item;
                  }elseif($id == 9){
                    $directExp2[] = $item;
                  }elseif($id == 10){
                    $financialExp2[] = $item;
                }elseif($id == 52){
                    $sellingDistributionExpSD2[] = $item;
                }elseif($id == 21){
                    $factoryOverHeadExp2[] = $item;
                    
                }elseif($id == 22){
                    $rechearceDevelopExp2[] = $item;
                }elseif($id == 23){
                    $officeAdminExp2[] = $item;
                }elseif($id == 27){
                    $othersDirectExp2[] = $item;
                }elseif($id == 33){
                    $tdsPayableExp2[] = $item;
                  } else {
                    $othersExp2[] = $item;
                  }
              }
              
              //dd($accountInfoExpenseDebit2);
              
            //  echo array_sum(array_column($accountInfoExpenseDebit2, 'debit')); echo "<br>";
            //  echo array_sum(array_column($accountInfoExpenseDebit2, 'credit')); echo "<br>";
            // exit;
            //dd($accountInfoExpenseDebit2);
            //dd($accountInfo2);

              $data = [
                'month' => $monthWord,
                'chartOfAccounts' => $accountInfo2,
                'othersIncomeInfo' => $othersIncomeInfo,
                'currentAsset' => $accountCurrentAssetDebitInfo,
                'fixedAsset' => $fixedAsset2,
                'nonCurrentAsset' => $nonCurrentAsset2,
                //'otherFixedAsset' => $otherFixedAsset2,
                'officeAdminExp' => $officeAdminExp2,
                'cogsExp' => $cogsExp2,
                'directExp' => $directExp2,
                'financialExp' => $financialExp2,
                'sellingDistributionExpSD' => $sellingDistributionExpSD2,
                'factoryOverHeadExp' => $factoryOverHeadExp2,
                'rechearceDevelopExp' => $rechearceDevelopExp2,
                'othersDirectExp' => $othersDirectExp2,
                'accountSupplierInfo' => $accountSupplierInfo,
                'accountDealerInfo' => $accountDealerInfo,
                'tdsPayableExp' => '',
                'othersExp' => $othersExp2,
                'accrudeExpenses' => $accountAccrudeExpInfo2,
                'assetLand' => $assetLand,
                'assetOffEquip' => $assetOffEquip,
                'assetPlant' => $assetPlant,
                'assetMotor' => $assetMotor,
                'assetBuilding' => $assetBuilding,
                'assetElectrical' => $assetElectrical,
                'assetComputer' => $assetComputer,
                'assetFurniture' => $assetFurniture,
                'assetOthers' => $assetOthers,
                'retainedEarning' => $retainedEarning
              ];

              $information[] = $data;
              $fdate = date("Y-m-d", strtotime( $tdate. " +1 day"));
              $tdate = date("Y-m-t", strtotime($fdate));
        }

    //    dd($information);

        return view('backend.account.chart_of_account.compared_trail_balance_sheet',[
            'information' => $information
        ]);

    }

    public function inputBalanceSheetDetails(){
        return view('backend.account.chart_of_account.balance-sheetDetails-input');
    }


    public function inputBalanceSheet(){
        return view('backend.account.chart_of_account.balance-sheet-input');
    }

     public function balanceSheet(Request $request){
         //dd($request->type);
        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
        if($fdate == "2023-10-01"){
          $startDate = '2023-09-30';
          $preDate = '2023-09-30';
        } else {
          $startDate = '2023-10-01';
          $preDate =  $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
        }
        
        //$totalRetainedEarning = IncomeStatement::whereBetween('date',[$fdate,$tdate])->sum('net_amount');
        $individualWithOpeningAccountInfo = $this->getChartOfAccountInfoWithoutOpening($startDate, $preDate);
        $preTime = strtotime($fdate);
        $preStartDate = date("Y-m-01", strtotime("-1 month", $preTime));
        $preEndDate = date("Y-m-t", strtotime("-1 month", $preTime));

        $retainedEarningOB = IncomeStatement::whereBetween('date',[$preStartDate,$preEndDate])->first();
        $currentRetainedEarning = IncomeStatement::whereBetween('date',[$fdate,$tdate])->first();
        
        $fdate = '2023-10-01';

        $accountInfo = [];
        $assetData = [];
        $liabilityData = [];
        $accountNonCurrentAssetInfo = [];
        $totalRevenue = 0;
        $totalExpense = 0;
        $isBank = 0;
        $isCash = 0;
        $isPurchase = 0;
        $isAccountPayable = 0;
        $isInventoryFg = 0;
        $isAccountReceivable = 0;
        $retainedEarningNote = [];
        
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
        $aseetOB = $this->totalAseetOb($fdate, $tdate);
        $aseetDepreciationOB = $this->totalAseetDepreciationOb($fdate, $tdate);
        //dd($expenseOB);
      //  $expenseOB += 1581068;
        $expenseOB -= 4256120;
        /*if($fdate == '2023-10-01'){
          $othersOB = 8520;
          $salesRevenueOB = 27949233;
          $salesReturnOB = 736216;

        } else {
          $othersOB = 0;
          $salesRevenueOB = 0 ;
          $salesReturnOB = 0 ;

        } */

        $othersOB = 0;
        $salesRevenueOB = 0 ;
        $salesReturnOB = 0 ;
        $retainedInfo = 0;
        $openingReained = 0;
        
         foreach($individualWithOpeningAccountInfo as $account3){
           if($account3->ac_main_account_id == 5){
             $openingReained -=  $account3->total_debit - $account3->total_credit;
           } elseif($account3->acSubSubAccount?->title == 'Finished Goods Sales'){
           $openingReained += $account3->total_credit - $account3->total_debit;
           } elseif($account3->acSubSubAccount?->title == 'Sales Returns'){
             $openingReained -=  $account3->total_debit - $account3->total_credit;
           } else {

           }
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
                    //$assetData[] =  $this->getDebitSectionFBS($account->acSubAccount?->title,'Inventory(FG)' , ($fgOB + ($account->total_debit - $account->total_credit)));
                    //$isInventoryFg++;
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
                      if($account->acSubSubAccount?->title == 'Retained Earning'){
                            $retainedInfo += ($account->total_credit - $account->total_debit);
                        /* $accountInfo[] =  $this->getDebitSection($account->acSubSubAccount?->title , ($salesReturnOB + $account->total_debit - $account->total_credit));
                        $isSalesReturn++; */
                    } else {
                      $totalRevenue += ($account->total_credit - $account->total_debit);
                    }
            } elseif($account->ac_main_account_id == 5) {
                $totalExpense += ($account->total_debit - $account->total_credit);
            }

        }
        
        
        

        //  FinishGood Inventory
          $category = SalesCategory::select('id','category_name as name')->orderBy('category_name', 'asc')->get();
          $fgInventoryInfo = [];
            $subAmount = 0;
            $startdate = '2023-10-01';
            $totalPackingConsumption = PackingConsumptions::whereBetween('date',[$startdate,$tdate])->sum('amount');
            $totalPackingCost = ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','Sal-%')->whereBetween('date',[$startdate,$tdate])->sum('debit');
            $totalPackingReturnCost = ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','SR-Inv-%')->whereBetween('date',[$startdate,$tdate])->sum('credit');
            //$totalReturnValue = \App\Models\Account\ChartOfAccounts::where('ac_sub_account_id',1)->where('ac_sub_sub_account_id',25)->where('invoice','like','SR-Inv-%')->whereBetween('date',[$startdate,$tdate])->sum('debit');
            $packingCost = ($totalPackingConsumption + $totalPackingReturnCost) - $totalPackingCost;

          foreach ($category as $key => $cat) {
                $products = \App\Models\SalesProduct::where('category_id',$cat->id)->orderby('product_name', 'asc')->get();
                $amount = 0;
                foreach ($products as $key => $value) {
                  $allStockAmount = \App\Models\SalesStockIn::where('prouct_id',$value->id)->whereBetween('date',[$startdate,$tdate])->sum('total_cost');
                  $stockOutAmount = \App\Models\SalesStockOut::where('product_id',$value->id)->whereBetween('date',[$startdate,$tdate])->sum('amount');
                  $damageAmount = \App\Models\SalesDamage::where('product_id',$value->id)->whereBetween('date',[$startdate,$tdate])->sum('amount');

                  $amount += ($value->opening_balance*$value->rate)   + $allStockAmount - ($stockOutAmount + $damageAmount);
                  //$subAmount += $temp;

                }
                $fgInventoryInfo[] = $this->getDebitSection($cat->name, $amount);
          }

          $fgInventoryInfo[] = $this->getDebitSection('Packing Amount', $packingCost);

        if($isBank < 1){
            $assetData[] = $this->getDebitSectionFBS('Current Assets','Bank' , ($bankOB + $bankEquity));
        }
        if($isCash < 1){
            $assetData[] = $this->getDebitSectionFBS('Current Assets','Cash' , ($cashOB + $cashEquity));
        }

        /* if($isInventoryFg < 1){
            $assetData[] = $this->getDebitSectionFBS('Current Assets','Inventory(FG)' , $fgOB);
        } */

        if($isAccountPayable < 1){
            $liabilityData[] = $this->getCreditSectionFBS('Current Liabilities','Accounts Payable (Suppliers)' , $supplierOB);
        }
        if($isPurchase < 1){
            $assetData[] = $this->getDebitSectionFBS('Current Assets','Purchase' , $rmOB);
        }
        if($isAccountReceivable < 1){
            $assetData[] = $this->getDebitSectionFBS('Current Assets','Accounts Receivable (Dealer)' , $dealerOB);
        }

      //  $currentLiaAmount = ($bankOB + $cashOB + $fgOB + $rmOB +  $dealerOB + $aseetOB +$expenseOB) - ($supplierOB + $interCompanyOB + $equityOB  + $aseetDepreciationOB);

        $liabilityData[] = [
            'sub_title' => 'Earning',
            'title' => 'Retained Earning',
            'debit' => 0,
            'credit' => $openingReained + $retainedEarningOB->net_amount + $retainedInfo,
        ];
        
        $retainedEarningNote[] = [
            'opening' => round($retainedEarningOB->net_amount,2),
            'openingPl' => round($currentRetainedEarning->opening,2),
            'salesExpRetn' => round($openingReained,2),
            'jarnal' => round($retainedInfo,2)
        ];
        
        $nonCurrentAsset = SubAccount::select('id','title')->where('title','Non Current Assests')->first();
        $getNonCurrentAssets = SubSubAccount::select('id','title')->where('ac_sub_account_id',$nonCurrentAsset->id)->get();
        foreach($getNonCurrentAssets as $asset)
        {
          $accountNonCurrentAssetInfo[] = $this->getDebitForNonCurrentAssetInfo($asset->title, $asset->id, $fdate, $tdate);
        }
        //dd($accountNonCurrentAssetInfo);
        
        
        
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
            }elseif($subTitle === 'OTHERS FIXED ASSETS'){
                $fixedAssets[] = $item;
            }
        }



        $currentLiabilities = [];
        $fixedLiabilities = [];
        $equities = [];

        //$currentLiabilities[] = $this->getCreditSection('Clearance Accounting' , (($bankOB + $cashOB + $fgOB + $rmOB +  $dealerOB + $aseetOB +$expenseOB) - ($supplierOB + $interCompanyOB + $equityOB  + $aseetDepreciationOB)));

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
        if($request->type == 2){
            return view('backend.account.chart_of_account.balance-sheet-details',[
            'chartOfAccounts' => $accountInfo,
            'assetData' =>  $assetData,
            'fgInventoryInfo' => $fgInventoryInfo,
            'liabilityData' =>$liabilityData,
            'currentAssets' => $currentAssets,
          //  'fixedAssets' => $fixedAssets,
            'accountNonCurrentAssetInfo' => $accountNonCurrentAssetInfo,
            'currentLiabilities' => $currentLiabilities,
            'fixedLiabilities' => $fixedLiabilities,
            'accumulatedAmount' => $accumulatedAmount,
            'retainedEarningNote' => $retainedEarningNote,
            'equities' => $equities,
            'fdate' => \Carbon\Carbon::parse($fdate)->format('j F, Y'),
            'tdate' => \Carbon\Carbon::parse($tdate)->format('j F, Y'),
        ]);
        } else {
            return view('backend.account.chart_of_account.balance-sheet',[
            'chartOfAccounts' => $accountInfo,
            'assetData' =>  $assetData,
            'fgInventoryInfo' => $fgInventoryInfo,
            'liabilityData' =>$liabilityData,
            'currentAssets' => $currentAssets,
          //  'fixedAssets' => $fixedAssets,
            'accountNonCurrentAssetInfo' => $accountNonCurrentAssetInfo,
            'currentLiabilities' => $currentLiabilities,
            'fixedLiabilities' => $fixedLiabilities,
            'accumulatedAmount' => $accumulatedAmount,
            'retainedEarningNote' => $retainedEarningNote,
            'equities' => $equities,
            'fdate' => \Carbon\Carbon::parse($fdate)->format('j F, Y'),
            'tdate' => \Carbon\Carbon::parse($tdate)->format('j F, Y'),
        ]);
        }
        
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

    public function inputComparedBalanceSheet(){
      return view('backend.account.chart_of_account.comparedBalance-sheet-input');
    }

   public function comparedBalanceSheet(Request $request){
        $information = [];
          if($request->date){
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $endDate = date('Y-m-d', strtotime($dates[1]));
          }
          $tdate = date("Y-m-t", strtotime($fdate));

          while($tdate <= $endDate){
              $monthWord = date('F, y', strtotime($fdate));
              $tdate = date("Y-m-t", strtotime($fdate));

              $totalRetainedEarning = IncomeStatement::whereBetween('date',[$fdate,$tdate])->sum('net_amount');

              $fdate = '2023-10-01';

              $accountInfo = [];
              $accountNonCurrentAssetInfo = [];
              $accountCurrentAssetDebitInfo = [];
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
              $aseetOB = $this->totalAseetOb($fdate, $tdate);
              $aseetDepreciationOB = $this->totalAseetDepreciationOb($fdate, $tdate);
              $expenseOB += 1581068;

              $othersOB = 0;
              $salesRevenueOB = 0 ;
              $salesReturnOB = 0 ;

              $liabilityData[] = $this->getCreditSectionFBS('Equity','Owner\'s Capital' , ($bankEquity + $cashEquity + $equityOB));

              foreach($individualAccountInfo as $account){

                  if($account->ac_main_account_id == 1){
                      if($account->acSubSubAccount?->title == 'Bank'){
                          $assetData[] = $this->getDebitSectionFBS($account->acSubAccount?->title , $account->acSubSubAccount?->title , ($bankEquity + $bankOB + $account->balance));
                          $isBank++;
                      }elseif($account->acSubSubAccount?->title == 'Cash'){
                          $assetData[] = $this->getDebitSectionFBS($account->acSubAccount?->title,$account->acSubSubAccount?->title , ($cashEquity + $cashOB + $account->balance));
                          $isCash++;
                      }elseif($account->acSubSubAccount?->title == 'Inventory(FG)'){
                          
                          /////////////////////////////////////////////////////////////////
                            //  FinishGood Inventory
                            $category = SalesCategory::select('id','category_name as name')->orderBy('category_name', 'asc')->get();
                            $fgInventoryInfo = [];
                              $subAmount = 0;
                              $startdate = '2023-10-01';
                              $totalPackingConsumption = PackingConsumptions::whereBetween('date',[$startdate,$tdate])->sum('amount');
                              $totalPackingCost = ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','Sal-%')->whereBetween('date',[$startdate,$tdate])->sum('debit');
                              $totalPackingReturnCost = ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','SR-Inv-%')->whereBetween('date',[$startdate,$tdate])->sum('credit');
                              //$totalReturnValue = \App\Models\Account\ChartOfAccounts::where('ac_sub_account_id',1)->where('ac_sub_sub_account_id',25)->where('invoice','like','SR-Inv-%')->whereBetween('date',[$startdate,$tdate])->sum('debit');
                              $packingCost = ($totalPackingConsumption + $totalPackingReturnCost) - $totalPackingCost;
                              
                
                            foreach ($category as $key => $cat) 
                            {
                                  $products = \App\Models\SalesProduct::where('category_id',$cat->id)->orderby('product_name', 'asc')->get();
                                  $amount = 0;
                                  foreach ($products as $key => $value) {
                                    $allStockAmount = \App\Models\SalesStockIn::where('prouct_id',$value->id)->whereBetween('date',[$startdate,$tdate])->sum('total_cost');
                                    $stockOutAmount = \App\Models\SalesStockOut::where('product_id',$value->id)->whereBetween('date',[$startdate,$tdate])->sum('amount');
                                    $damageAmount = \App\Models\SalesDamage::where('product_id',$value->id)->whereBetween('date',[$startdate,$tdate])->sum('amount');
                
                                    $amount += ($value->opening_balance*$value->rate)   + $allStockAmount - ($stockOutAmount + $damageAmount);
                                    //$subAmount += $temp;
                                  }
                                  $fgInventoryInfo[] = $this->getDebitSection($cat->name, $amount);
                            }
                
                            $fgInventoryInfo[] = $this->getDebitSection('Finished Goods Inventory Packing Amount', $packingCost);
                            $i_f_g_v = array_sum(array_column($fgInventoryInfo, 'debit'));
                            $assetData[] =  $this->getDebitSectionFBS($account->acSubAccount?->title,'Inventory(FG)' , $i_f_g_v);
                            
                            //echo "<pre>";
                            //dd($account);
                            //   print_r(array_sum(array_column($fgInventoryInfo, 'debit'))); echo "<br>";
                            //   print_r($totalPackingConsumption); echo "<br>";
                            // print_r($totalPackingCost); echo "<br>";
                            // print_r($totalPackingReturnCost); echo "<br>";
                            // exit;
                            //dd(array_sum(array_column($fgInventoryInfo, 'debit')));
                        /////////////////////////////////////////////////////////////////
                        
                          
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
                         // $assetData[] =  $this->getDebitSectionFBS($account->acSubAccount?->title,$account->acSubSubAccount?->title , ($account->total_debit - $account->total_credit));
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

              $accountAmount = ($bankOB + $cashOB + $fgOB + $rmOB +  $dealerOB + $aseetOB + $expenseOB + $salesReturnOB) - ($supplierOB + $interCompanyOB + $equityOB + $othersOB +$salesRevenueOB  + $aseetDepreciationOB);
              $liabilityData[] = [
                  'sub_title' => 'Earning',
                  'title' => 'Retained Earning',
                  'debit' => 0,
                  'credit' => $totalRetainedEarning + $accountAmount,
              ];

              $nonCurrentAsset = SubAccount::select('id','title')->where('title','Non Current Assests')->first();
              $getNonCurrentAssets = SubSubAccount::select('id','title')->where('ac_sub_account_id',$nonCurrentAsset->id)->get();
              foreach($getNonCurrentAssets as $asset){
                $accountNonCurrentAssetInfo[] = $this->getDebitForNonCurrentAssetInfo($asset->title, $asset->id, $fdate, $tdate);
              }

              $getCurrentAssets = SubSubAccount::select('id','title')->where('ac_sub_account_id',1)->whereNotIn('title',['Bank','Cash','Purchase','Accounts Receivable (Dealer)','Purchase Return','Inventory(FG)'])->get();
              foreach($getCurrentAssets as $value){
                $accountCurrentAssetDebitInfo[] = $this->getDebitForCurrentAsset($value->id, $value->title, $fdate, $tdate);
              }

              //dd($accountCurrentAssetDebitInfo);
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
                          //$fixedAssets[] = $item;
                      }
                  }elseif($subTitle === 'OTHERS FIXED ASSETS'){
                    //  $fixedAssets[] = $item;
                  }
              }

              $currentLiabilities = [];
              $fixedLiabilities = [];
              $equities = [];


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

              $data = [
                'month' => $monthWord,
                'chartOfAccounts' => $accountInfo,
                'assetData' =>  $assetData,
                'liabilityData' =>$liabilityData,
                'currentAssets' => $currentAssets,
                'currentAssets2' => $accountCurrentAssetDebitInfo,
                'fixedAssets' => $accountNonCurrentAssetInfo,
                //'fixedAssets' => $fixedAssets,
                'currentLiabilities' => $currentLiabilities,
                'fixedLiabilities' => $fixedLiabilities,
                'accumulatedAmount' => $accumulatedAmount,
                'equities' => $equities
              ];

              $information[] = $data;

              $fdate = date("Y-m-d", strtotime( $tdate. " +1 day"));
              $tdate = date("Y-m-t", strtotime($fdate));
            }

            return view('backend.account.chart_of_account.compared_balance-sheet',[
                'information' => $information
            ]);

        }

        public function inputExtendedTrailBalanceSheet(){
            return view('backend.account.chart_of_account.extended-trail-balance-input');
        }

        public function getExtendedTrailBalanceSheet(Request $request){
          if ($request->date) {
              $dates = explode(' - ', $request->date);
              $fdate = date('Y-m-d', strtotime($dates[0]));
              $tdate = date('Y-m-d', strtotime($dates[1]));
          }

            $startDate = '2023-10-01';
            $pdate = date("Y-m-d", strtotime( $fdate. " -1 day"));
              if($fdate < "2023-12-31"){
                return view('backend.account.chart_of_account.data-not-found', compact('fdate','tdate'));
              } else {
                  $accountEquityInfo = [];
                  $accountSisterConcernInfo = [];
                  $accountAccrudeExpInfo = [];
                  $accountSupplierInfo = [];
                  $accountAdvanceSupplierInfo = [];
                  $accountCurrentAsset = [];
                  $accountExtendedNonCurrentAssetInfo = [];
                  $accountExtendedAccDepnInfo = [];
                  $accountExtendedBankInfo = [];
                  $accountExtendedCashInfo = [];
                  $accountExtendedPurchaseInfo = [];
                  $fgInventoryInfo = [];
                  $accountDealerInfo = [];
                  $accountDealerAdvanceInfo = [];
                  $accountExtendedFGSalesInfo = [];
                  $accountExtendedSalesReturnInfo = [];
                  $accountExtendedExpenseInfo = [];
                  $accountExtendedOthersIncomeInfo = [];
                  $accountInfo = [];
                  $openingData = [];

                  $individualAccountInfo = $this->getChartOfAccountInfo($fdate, $tdate);
                  $individualWithOpeningAccountInfo = $this->getChartOfAccountInfoWithoutOpening($startDate, $tdate);
                  $preTime = strtotime($fdate);
                  $preStartDate = date("Y-m-01", strtotime("-1 month", $preTime));
                  $preEndDate = date("Y-m-t", strtotime("-1 month", $preTime));

                  $bankEquity = $this->getEquityForBank();
                  $cashEquity = $this->getEquityForCash();
                  $bankOB =  $this->totalBankOb($startDate, $tdate);
                  $cashOB =  $this->totalCashOb($startDate, $tdate);
                  $fgOB = $this->totalFgOb($startDate, $tdate);
                  $rmOB = $this->totalRmOb($startDate, $tdate);
                  $supplierOB = $this->totalSupplierOb($startDate, $tdate);
                  $dealerOB = $this->totalDealerOb($startDate, $tdate);
                  $interCompanyOB = $this->totalInterCompanyOb($startDate, $tdate);
                  $expenseOB = $this->totalExpenseOb($startDate, $tdate);
                  $equityOB = $this->totalEquityOb($startDate, $tdate);
                  $aseetOB = $this->totalAseetOb($startDate, $tdate);
                  $aseetDepreciationOB = $this->totalAseetDepreciationOb($startDate, $tdate);

                  //$retainedEarningOB = IncomeStatement::whereBetween('date',[$preStartDate,$preEndDate])->sum('net_amount');
                  $retainedEarningOB = 0;
                  $expenseOB = -1123932;
                  $accountAmount = ($bankOB + $cashOB + $fgOB + $rmOB +  $dealerOB + $aseetOB + $expenseOB ) - ($supplierOB + $interCompanyOB + $equityOB + $retainedEarningOB + $aseetDepreciationOB);
                //dd($accountAmount);
                  $openingReainedCr = 0;
                  foreach($individualWithOpeningAccountInfo as $account3){
                    if($account3->ac_main_account_id == 5){
                      $openingReainedCr -=  $account3->total_debit - $account3->total_credit;
                    } elseif($account3->acSubSubAccount?->title == 'Finished Goods Sales'){
                    $openingReainedCr += $account3->total_credit - $account3->total_debit;
                    } elseif($account3->acSubSubAccount?->title == 'Sales Returns'){
                      $openingReainedCr -=  $account3->total_debit - $account3->total_credit;
                    } else {

                    }
                  }

                  //dd($accountAmount);

                  $accountInfo = [];
                  $retainedId = SubSubAccount::select('id','title')->where('title','Retained Earning')->first();
                  $retainedInfo = ChartOfAccounts::select(DB::raw('SUM(credit) - SUM(debit) as balance'))->where('ac_sub_sub_account_id',$retainedId->id)->whereBetween('date',[$startDate, $tdate])->first();
                  $accountInfo[] = $this->getCreditSection('Retained Earning',$retainedEarningOB+ $accountAmount + $openingReainedCr + $retainedInfo->balance);
                  //dd($accountInfo);

                    $equityOB = 0;
                    $equities = DB::table('equities')->orderBy('name', 'asc')->get();
                    foreach ($equities as $value) {
                      $equityOB += $value->amount;
                      $accountEquityInfo[] = $this->equityAccountPayableInfoExten($value->name,$value->amount);
                    }

                  foreach($individualAccountInfo as $account){
                    if($account->ac_main_account_id == 2){
                        //  $accountLiabilitiesInfo[] = $this->getCreditSection($account->acSubSubAccount?->title , ($account->total_credit));
                        if($account->acSubSubAccount?->title == 'ACCRUED EXPENSES'){
                          $accountAccrudeExpInfo[] =  $this->getAccruedExpenseExtend($account->acSubSubAccount?->title, $account->acSubSubAccount?->id,$startDate, $pdate,$fdate, $tdate);
                      }
                          //dd($account->ac_main_account_id);
                    } elseif($account->ac_main_account_id == 1){
                      if($account->acSubSubAccount?->title == 'Bank'){
                        $accountInfo[] = $this->getCreditSection($account->acSubSubAccount?->title , ($account->total_credit));
                      //  $accountInfo[] = $this->getDebitSection($account->acSubSubAccount?->title , ($account->total_debit));
                      $openingData[] = $this->getDebitOpeningData($account->ac_main_account_id ,$account->acSubSubAccount?->title, $fdate, $tdate);

                      }

                    } //end Equity if
                  } //End forloop

                  //Inter_company
                  $allCompany = InterCompany::where('status',1)->orderBy('name', 'asc')->get();

                  foreach ($allCompany as $value) {
                    $accountSisterConcernInfo[] = $this->sisterConcernAccountPayableInfoExtend($value->id,$value->name,$value->balance,$startDate, $pdate,$fdate, $tdate);
                  }
                  //Supplier
                  $suppliers = Supplier::get();
                  foreach ($suppliers as $value) {
                    $accountSupplierInfo[] = $this->supplierExtendedAccountPayableInfo($value->id,$value->supplier_name,$value->opening_balance,$startDate, $pdate,$fdate, $tdate);
                    $accountAdvanceSupplierInfo[] = $this->supplierExtendedAdvanceAccountPayableInfo($value->id,$value->supplier_name,$value->opening_balance,$startDate, $pdate,$fdate, $tdate);
                  }

                  $currentAssets = ExpanseSubgroup::select('subgroup_name as title')->where('group_id',1)->get();
                  foreach($currentAssets as $value){
                    $accountCurrentAsset[] = $this->currentAssetExtendedInfo($value->title,$startDate, $pdate,$fdate, $tdate);
                  }

                  $accDepn = SubSubAccount::select('id','title')->where('title','Accumulated Depreciation')->first();
                  $accountExtendedAccDepnInfo[] = $this->getAccumDepnExtendedTb($accDepn->id, $accDepn->title,$startDate,$pdate, $fdate, $tdate);
                  $bankId = SubSubAccount::select('id','title')->where('title','Bank')->first();
                  $cashId = SubSubAccount::select('id','title')->where('title','Cash')->first();

                  $op = $bankOB+$bankEquity;
                  $accountExtendedBankInfo[] = $this->getBankDataExtendedTb($bankId->id, $bankId->title,$op,$startDate,$pdate,$fdate, $tdate);
                  $op = $cashOB+$cashEquity;
                  $accountExtendedCashInfo[] = $this->getBankDataExtendedTb($cashId->id, $cashId->title,$op,$startDate,$pdate,$fdate, $tdate);

                  $purchase = SubSubAccount::select('id','title')->where('title','Purchase')->first();
                  $accountExtendedPurchaseInfo[] = $this->getBankDataExtendedTb($purchase->id, $purchase->title,$rmOB,$startDate,$pdate,$fdate, $tdate);

                  $finishGood = SubSubAccount::select('id','title')->where('title','Inventory(FG)')->first();
                  $accountExtendedFinishGoodInfo[] = $this->getBankDataExtendedTb($finishGood->id, $finishGood->title,$fgOB,$startDate,$pdate,$fdate, $tdate);
                //  dd($accountExtendedFinishGoodInfo);
                  //  FinishGood Inventory
                    $category = SalesCategory::select('id','category_name as name')->orderBy('category_name', 'asc')->get();
                    foreach ($category as $key => $cat) {
                    $fgInventoryInfo[] = $this->getFinishGoodExtendedTb($cat->id,$cat->name,$startDate,$pdate,$fdate, $tdate);
                    }
                    $fgInventoryInfo[] = $this->getFGInventoryPackingAmount('Finished Goods Inventory Packing Amount',$startDate,$pdate,$fdate, $tdate);
                    //dd($fgInventoryInfo);
                    //Fg Inventory End

                  $dealers = Dealer::get();
                  foreach ($dealers as $value) {
                    $accountDealerInfo[] = $this->dealerAccountExtendedPayableInfo($value->id,$value->d_s_name,$value->dlr_base,$startDate,$pdate,$fdate, $tdate);
                    $accountDealerAdvanceInfo[] = $this->dealerAccountExtendedAdvancePayableInfo($value->id,$value->d_s_name,$value->dlr_base,$startDate,$pdate,$fdate, $tdate);
                  }


                  $fgSales = SubSubAccount::select('id','title')->where('title','Finished Goods Sales')->first();
                  $accountExtendedFGSalesInfo[] = $this->getOthersIncomeExtendedTb($fgSales->id, $fgSales->title, $fdate, $tdate);

                  $salesReturn = SubSubAccount::select('id','title')->where('title','Sales Returns')->first();
                  $accountExtendedSalesReturnInfo[] = $this->getDebitWithoutOpeningExtendedTb($salesReturn->id, $salesReturn->title, $fdate, $tdate);

                  $expenses = SubAccount::select('id','title')->where('ac_main_account_id',5)->whereNotIn('title',['Others Income','Inventory','Current Assets','Non Current Assets','Others Fixed Assets','Journal Expense'])->get();

                  foreach ($expenses as $expense) {
                    $expenseLedgers = SubSubAccount::select('id','title')->where('ac_sub_account_id',$expense->id)->get();
                    //dd($expenseLedgers);
                    foreach ($expenseLedgers as  $expenseLedger) {
                      $accountExtendedExpenseInfo[] = $this->getDebitWithoutOpeningExtendedExpenseData($expense->title, $expenseLedger->id, $expenseLedger->title, $fdate, $tdate);
                    }

                  }

                  $expensesCOGSData = [];
                  $expensesOfficeAdmin = [];
                  $expensesDirectExp = [];
                  $expensesFinancialExp = [];
                  $expensesSellingDistributionExp = [];
                  $expensesDepreciationExp = [];
                  $expensesPrinceExp = [];
                  $expensesFactoryOverheadExp = [];
                  $expensesReseachExp = [];
                  $expensesFuelExp = [];
                  $expensesRepairExp = [];
                  $expensesRegCarExp = [];
                  $expensesMetingExp = [];
                  $expensesDirectLabourExp = [];
                  $othersExpense = [];
                  foreach ($accountExtendedExpenseInfo as $expValue) {
                    if($expValue['group'] != 'NULL'){
                      if($expValue['group'] == 'Cost of Goods Sold (COGS)'){
                        $expensesCOGSData[] = $expValue;
                      } elseif($expValue['group'] == 'OFFICE & ADMINISTRATIVE EXPENSES') {
                        $expensesOfficeAdmin[] = $expValue;
                      } elseif($expValue['group'] == 'DIRECT EXPENSES'){
                        $expensesDirectExp[] = $expValue;
                      } elseif($expValue['group'] == 'FINANCIAL EXPENSES'){
                        $expensesFinancialExp[] = $expValue;
                      } elseif($expValue['group'] == 'SELLING & DISTRIBUTION EXPENSE-SD'){
                        $expensesSellingDistributionExp[] = $expValue;
                      } elseif($expValue['group'] == 'Depreciation Expense'){
                        $expensesDepreciationExp[] = $expValue;
                      } elseif($expValue['group'] == 'PRINCE EXPENSES'){
                        $expensesPrinceExp[] = $expValue;
                      } elseif($expValue['group'] == 'FACTORY OVERHEAD'){
                        $expensesFactoryOverheadExp[] = $expValue;
                      } elseif($expValue['group'] == 'RESEARCH AND DEVELOPMENT-F'){
                        $expensesReseachExp[] = $expValue;
                      } elseif($expValue['group'] == 'FUEL & LUBRICANT- HO'){
                        $expensesFuelExp[] = $expValue;
                      } elseif($expValue['group'] == 'REPAIR & MAINTENANCE - VEHICLE'){
                        $expensesRepairExp[] = $expValue;
                      } elseif($expValue['group'] == 'REGISTRATION EXP-CAR'){
                        $expensesRegCarExp[] = $expValue;
                      } elseif($expValue['group'] == 'MEETING EXPENSES'){
                        $expensesMetingExp[] = $expValue;
                      } elseif($expValue['group'] == 'Direct Labour Cost'){
                        $expensesDirectLabourExp[] = $expValue;
                      } else {
                        $othersExpense[] = $expValue;
                      }


                  }
                }


                  $nonCurrentAsset = SubAccount::select('id','title')->where('title','Non Current Assests')->first();
                  $getNonCurrentAssets = SubSubAccount::select('id','title')->where('ac_sub_account_id',$nonCurrentAsset->id)->get();

                  foreach($getNonCurrentAssets as $asset){
                    $getIndividualNonCurrentAssets = IndividualAccount::select('id','title')->where('ac_sub_sub_account_id',$asset->id)->get();
                    foreach ($getIndividualNonCurrentAssets as $value) {
                      $accountExtendedNonCurrentAssetInfo[] = $this->getDebitForNonCurrentAssetTb($asset->title, $value->id, $value->title, $startDate,$pdate,$fdate, $tdate);

                    }
                  }

                  $assetLand = [];
                  $assetOffEquip = [];
                  $assetPlant = [];
                  $assetMotor = [];
                  $assetBuilding = [];
                  $assetElectrical = [];
                  $assetComputer = [];
                  $assetFurniture = [];
                  $assetOthers = [];

                  foreach($accountExtendedNonCurrentAssetInfo as $assetVal){
                    if($assetVal['group'] != 'NULL'){
                      if($assetVal['group'] == 'Land & Land Development'){
                        $assetLand[] = $assetVal;
                      } elseif($assetVal['group'] == 'Office Equipments'){
                        $assetOffEquip[] = $assetVal;
                      }
                      elseif($assetVal['group'] == 'Plant & Mechineries'){
                        $assetPlant[] = $assetVal;
                      }
                      elseif($assetVal['group'] == 'Motor Vehicle'){
                        $assetMotor[] = $assetVal;
                      }
                      elseif($assetVal['group'] == 'Building & Civil Construction'){
                        $assetBuilding[] = $assetVal;
                      }
                      elseif($assetVal['group'] == 'Electrical Equipment'){
                        $assetElectrical[] = $assetVal;
                      }
                      elseif($assetVal['group'] == 'Computer & Software'){
                        $assetComputer[] = $assetVal;
                      }
                      elseif($assetVal['group'] == 'Furniture & Fixture'){
                        $assetFurniture[] = $assetVal;
                      }
                      elseif($assetVal['group'] == 'Others Fixed Assets'){
                        $assetOthers[] = $assetVal;
                      } else {

                      }

                    }
                  }

                  $othersIncome = SubSubAccount::select('id','title')->where('title','Others Income')->first();
                  $accountExtendedOthersIncomeInfo[] = $this->getOthersIncomeExtendedTb($othersIncome->id, $othersIncome->title,$fdate, $tdate);

                //  dd($assetBuilding);
                  //dd($accountCurrentAsset);

                  return view('backend.account.chart_of_account.extended_trail_balance_sheet',[
                      'accountEquityInfo' => $accountEquityInfo,
                      'accountSisterConcernInfo' => $accountSisterConcernInfo,
                      'accountAccrudeExpInfo' => $accountAccrudeExpInfo,
                      'accountSupplierInfo' => $accountSupplierInfo,
                      'accountAdvanceSupplierInfo' => $accountAdvanceSupplierInfo,
                      'accountCurrentAsset' => $accountCurrentAsset,
                      'fgInventoryInfo' => $fgInventoryInfo,
                      'accountExtendedAccDepnInfo' => $accountExtendedAccDepnInfo,
                      'accountExtendedBankInfo' => $accountExtendedBankInfo,
                      'accountExtendedCashInfo' => $accountExtendedCashInfo,
                      'accountExtendedPurchaseInfo' => $accountExtendedPurchaseInfo,
                      'accountExtendedFinishGoodInfo' => $accountExtendedFinishGoodInfo,
                      'accountDealerInfo' => $accountDealerInfo,
                      'accountDealerAdvanceInfo' => $accountDealerAdvanceInfo,
                      'accountExtendedFGSalesInfo' => $accountExtendedFGSalesInfo,
                      'accountExtendedSalesReturnInfo' => $accountExtendedSalesReturnInfo,
                      'accountExtendedOthersIncomeInfo' => $accountExtendedOthersIncomeInfo,
                      'expensesCOGSData' => $expensesCOGSData,
                      'expensesOfficeAdmin' => $expensesOfficeAdmin,
                      'expensesDirectExp' => $expensesDirectExp,
                      'expensesFinancialExp' => $expensesFinancialExp,
                      'expensesSellingDistributionExp' => $expensesSellingDistributionExp,
                      'expensesDepreciationExp' => $expensesDepreciationExp,
                      'expensesPrinceExp' => $expensesPrinceExp,
                      'expensesFactoryOverheadExp' => $expensesFactoryOverheadExp,
                      'expensesReseachExp' => $expensesReseachExp,
                      'expensesFuelExp' => $expensesFuelExp,
                      'expensesRepairExp' => $expensesRepairExp,
                      'expensesRegCarExp' => $expensesRegCarExp,
                      'expensesMetingExp' => $expensesMetingExp,
                      'expensesDirectLabourExp' => $expensesDirectLabourExp,
                      'othersExpense' => $othersExpense,
                      'assetLand' => $assetLand,
                      'assetOffEquip' => $assetOffEquip,
                      'assetPlant' => $assetPlant,
                      'assetMotor' => $assetMotor,
                      'assetBuilding' => $assetBuilding,
                      'assetElectrical' => $assetElectrical,
                      'assetComputer' => $assetComputer,
                      'assetFurniture' => $assetFurniture,
                      'assetOthers' => $assetOthers,
                      'fdate' => $fdate,
                      'tdate' => $tdate
                  ]);

              }
            }
}
