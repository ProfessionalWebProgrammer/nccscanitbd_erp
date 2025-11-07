<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\MasterBank;
use App\Models\MasterCash;
use App\Models\Asset;
use App\Models\AssetDetail;
use App\Models\AssetProduct;
use App\Models\AssetCategory;
use App\Models\AssetGroup;
use App\Models\AssetDepreciation;
use App\Models\AssetType;
use App\Models\AssetClint;
use App\Models\ShortTermLibilitiesClient;
use Auth;
use App\Models\Payment_number;
use App\Models\OthersIncome;
use App\Models\Payment;
use App\Traits\ChartOfAccount;
use App\Traits\AccountInfoAdd;
use App\Traits\AssetOfDepreciation;

use App\Models\longTermLibilitiesClient;
use Illuminate\Support\Facades\DB;
use App\Models\Account\ChartOfAccounts;
use App\Models\Account\AssetDepreciationInfoDetails;
use App\Models\Account\AssetDepreciationSetting;

class AssetController extends Controller
{
    use ChartOfAccount, AssetOfDepreciation, AccountInfoAdd;
    public function assettype()
    {
        $assettype = AssetType::all();
        return view('backend.assets.asset_type', compact('assettype'));
    }

    public function deleteassettype(Request $request)
    {
    //  dd($request->all());
      AssetType::where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Asset Type Deleted Successfull');
    }
    public function storeassettype(Request $request)
    {
        // dd($request->all());
        $assettype = new AssetType();
        $assettype->asset_type_name = $request->asset_type;
        $assettype->save();
        return redirect()->back()->with('success', 'Asset Type Created Successfull');
    }
    public function index()
    {
        $assets = Asset::select('assets.*','asset_types.asset_type_name','asset_clints.name','asset_categories.name as category_name')
          ->leftJoin('asset_categories', 'asset_categories.id', 'assets.asset_category_id')
      			->leftJoin('asset_types', 'asset_types.id', 'assets.asset_type')
              ->leftJoin('asset_clints', 'asset_clints.id', 'assets.client_id')
          		->where('intangible',0)->where('investment',0)
              ->get();
      //dd($assets);
        return view('backend.assets.general_assets_index', compact('assets'));
    }
    
    public function assetInvoiceView($id)
    {
        $asset = Asset::select('assets.*','asset_types.asset_type_name','asset_clints.name','asset_categories.name as category_name')
          ->leftJoin('asset_categories', 'asset_categories.id', 'assets.asset_category_id')
      			->leftJoin('asset_types', 'asset_types.id', 'assets.asset_type')
              ->leftJoin('asset_clints', 'asset_clints.id', 'assets.client_id')
          		->where('assets.id', $id)
              ->first();
              
        return view('backend.assets.general_assets_invoice', compact('asset'));
    }
    
    public function createasset()
    {
        $assettype = AssetType::all();
        $shortclient = ShortTermLibilitiesClient::all();
        $assetclint = AssetClint::all();
        $longclient = longTermLibilitiesClient::all();
        //$assetcat =  AssetCategory::all();
        $assetcat = AssetGroup::all();
      	$assetproduct =  AssetProduct::all();
        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $banks = MasterBank::orderBy('bank_name', 'ASC')->get();
        $cashes = MasterCash::orderBy('wirehouse_name', 'ASC')->get();
        return view('backend.assets.ganeral_asset_create', compact('dealers', 'banks', 'cashes', 'shortclient', 'longclient', 'assettype','assetclint','assetcat','assetproduct'));
    }

    public function assetstore(Request $request)
    {
        //dd($request->all());
     // $lastid = Asset::orderby('id','desc')->first();

     // if($lastid){
    //  	$invoice = 10000+$lastid->id+1;
     // }else{
      //	$invoice = 10000;
     // }

        $assetdata = new Asset();
        $assetdata->date = $request->date;

       // $assetdata->asset_head = $request->asset_head;
        $assetdata->asset_type = $request->asset_type;
        $assetdata->group_id = $request->group_id;
        $assetdata->client_id = $request->clint_id;
        $assetdata->asset_product_id = $request->product_id;
       // $assetdata->asset_qty = $request->asset_qty;
      //  $assetdata->asset_unit_price = $request->asset_unit_price;
      //  $assetdata->asset_value = $request->asset_value_dr;

      //  $assetdata->client_type = $request->client_type;
       // $assetdata->short_term_client_id = $request->short_client;
      //  $assetdata->long_term_client_id = $request->long_client;

        $assetdata->asset_value = $request->total_amount;
        $assetdata->payment_value = $request->payment_value_cr ?? 0;
        $assetdata->remaining_value = $request->remaining_value_dr ?? 0;
        $assetdata->asset_term = $request->asset_term;

        $assetdata->payment_mode = $request->payment_mode;
        $assetdata->wirehouse_id = $request->wirehouse_id;
        $assetdata->bank_id = $request->bank_id;
        $assetdata->description = $request->description;
        $assetdata->save();
        $invoice = 'Asst-'.$assetdata->id+10000;
        $assetdata->invoice = $invoice;
        $assetdata->save();

        $data = AssetProduct::where('id',$request->product_id)->first();
        $rate = $data->depreciation_rate;
        $count = $data->depreciation_year * 12;
        $product = $data->product_name;

        if(@$request->payment_value_cr > 0){
           if($request->payment_mode == 'Bank'){
              $this->createCreditForAssetWithPayment('Bank' , $request->bank_id , $request->payment_value_cr, $request->date , $request->description, $invoice);
              //$this->createDebitForPurchaseReturnAccount($product, $request->payment_value_cr, $request->date, $invoice);
              $this->assetSubGroupDebit($product, $request->payment_value_cr, $request->date, $request->description ,$invoice);
           }else{
              $this->createCreditForAssetWithPayment('Cash' , $request->wirehouse_id, $request->payment_value_cr, $request->date , $request->description, $invoice);
              //$this->createDebitForPurchaseReturnAccount($product, $request->payment_value_cr, $request->date, $invoice);
              $this->assetSubGroupDebit($product, $request->payment_value_cr, $request->date, $request->description ,$invoice);
           }
        }

        $assetdaetails = new AssetDetail();
        $assetdaetails->invoice = $assetdata->invoice;
        $assetdaetails->asset_id = $assetdata->id;
        $assetdaetails->group_id = $request->group_id;
        $assetdaetails->product_id = $request->product_id;
        $assetdaetails->asset_qty = $request->asset_qty;
        $assetdaetails->asset_unit_price = $request->asset_unit_price;
        $assetdaetails->asset_value = $request->asset_value_dr;
        $assetdaetails->save();


/*SELECT SUM(`remaining_value`) FROM `ac_assets_depreciation_details` WHERE `date` BETWEEN '2023-12-01' AND '2023-12-30';
 [j month e calculation korbo tra ager month er last date er Remaining Amonut ta nibo
then calculation month thekay duration month er data delete koray dibo

tarpor data calculation korbo

]
        //Delete Previous Data
SELECT * FROM `ac_chart_of_account` WHERE `ac_sub_sub_account_id`=22 AND `date` > '2023-12-16';
SELECT * FROM `ac_chart_of_account` WHERE `ac_sub_sub_account_id`=23 AND `date` > '2023-12-16';
SELECT * FROM `ac_assets_depreciation_details` WHERE `product_id`= 24 AND `date` > '2023-12-26';
*/
      $preTime = strtotime($request->date);
      $preStartDate = date("Y-m-01", strtotime("-1 month", $preTime));
      $preEndDate = date("Y-m-t", strtotime("-1 month", $preTime));

      $preRemainAmount = AssetDepreciationInfoDetails::whereBetween('date',[$preStartDate,$preEndDate])->sum('remaining_value');
    //  $assetProductOpening = AssetProduct::where('id',$request->product_id)->sum('balance');
          $startDate = date("Y-m-01", strtotime($request->date));
          $endDate = date("Y-m-t", strtotime($request->date));

          ChartOfAccounts::where('invoice',$data->invoice)->where('credit','!=',$data->dep_amount)->where('ac_sub_sub_account_id', 22)->where('date','>=',$startDate)->delete();
          ChartOfAccounts::where('invoice',$data->invoice)->where('ac_sub_sub_account_id', 23)->where('date','>=',$startDate)->delete();
          AssetDepreciationInfoDetails::where('product_id', $request->product_id)->where('date','>=',$startDate)->delete();

          $assetSales = OthersIncome::where('product_id',$request->product_id)->whereBetween('date',[$startDate,$endDate])->sum('amount');

        $time = strtotime($request->date);

      //  dd($assetProductOpening);

      //  $final = date("Y-m-d", strtotime("+1 month", $time));



        for($i = 0; $i < $count ; $i++){
          $finalDate = date("Y-m-d", strtotime("+".$i." month", $time));
          /*$preTime = strtotime($finalDate);
          $preStartDate = date("Y-m-01", strtotime("-1 month", $preTime));
          $preEndDate = date("Y-m-t", strtotime("-1 month", $preTime));

          $preRemainingValue = AssetDepreciationInfoDetails::where('product_id',$request->product_id)
                            ->whereBetween('date',[$preStartDate,$preEndDate])->sum('remaining_value');
                            */
                /*            if($i == 0){
                              if($assetSales){
                                $calculation = $request->payment_value_cr + $preRemainAmount - $assetSales;
                              } else {
                                $calculation = $request->payment_value_cr + $preRemainAmount ;
                              }
                            } else {
                              $calculation = $calculation;
                            }

          $amount = (( $calculation * $rate) / 100 ) / 12;

          $calculation -= $amount;
*/
$preDepTime =  strtotime($finalDate);
$preDepStartDate = date("Y-m-01", strtotime("-1 month", $preDepTime));
$preDepEndDate = date("Y-m-t", strtotime("-1 month", $preDepTime));

$depData = AssetDepreciationInfoDetails::where('product_id',$request->product_id)->whereBetween('date',[$preDepStartDate, $preDepEndDate])->first();
//dd($depData);

$depAmount = $depData->dep_account ?? 0;
$currentAmount = $depData->account_value ?? 0;
$totalAsset = $depData->total_asset ?? 0;
if($i == 0){
    if($currentAmount == 0){
        $remainValue = $depData->remaining_value - $depAmount + $request->total_amount - $assetSales;
    } else {
        $remainValue = $depData->remaining_value - $currentAmount + $request->total_amount - $assetSales;
    }
    $assetTotal = $totalAsset  + $request->total_amount - $assetSales;
    } else {
    $remainValue = $totalAsset - $depAmount;
    $assetTotal = $totalAsset;
    }
$amount = (($remainValue * $rate) / 100 ) / 12;

$totalAmount = $amount + $depAmount;

/*if($i == 0){
  $remainValue = $depData->remaining_value   + $request->total_amount - $totalAmount - $assetSales;
} else {
  $remainValue = $depData->remaining_value   - $totalAmount;
}*/


          $AssetOfDepreciation = new  AssetDepreciationInfoDetails;
          $AssetOfDepreciation->date = $finalDate;
          $AssetOfDepreciation->invoice = $invoice;
          $AssetOfDepreciation->ac_asset_id = $assetdata->id;
          $AssetOfDepreciation->category_id = $request->category_id;
          $AssetOfDepreciation->product_id = $request->product_id;
          if($i == 0) {
            $AssetOfDepreciation->asset_value = $request->total_amount;
          } else {
            $AssetOfDepreciation->asset_value = 0;
          }
          $AssetOfDepreciation->total_asset = $assetTotal;
          $AssetOfDepreciation->status = 0;
          $AssetOfDepreciation->depreciation_year = date("Y", strtotime($finalDate));
          $AssetOfDepreciation->depreciation_month = date("m", strtotime($finalDate));
          $AssetOfDepreciation->remaining_value = $remainValue;
          $AssetOfDepreciation->account_value = $amount;
          $AssetOfDepreciation->dep_account = $totalAmount;
          $AssetOfDepreciation->save();

          $this->createCreditForDepreciation('Accumulated Depreciation' , $amount,  $finalDate, $request->description, $invoice );
          $this->createDebitForDepreciation('Depreciation Expense' , $amount, $finalDate, $request->description, $invoice );
        }

/*
        $this->createCreditForAssetWithoutPayment($request->clint_id ,$request->total_amount,$request->date , $request->description);
        $this->createDebitForAssetWithoutPayment($request->category_id ,$request->total_amount,$request->date , $request->description);

      $assetDepreciation = AssetDepreciationSetting::where('status',1)->first();

      foreach($request->product_id as $key=> $item ){

        $assetdaetails = new AssetDetail();
        $assetdaetails->invoice = $assetdata->invoice;
        $assetdaetails->asset_id = $assetdata->id;
        $assetdaetails->category_id = $request->category_id;
        $assetdaetails->product_id = $request->product_id[$key];
        $assetdaetails->asset_qty = $request->asset_qty[$key];
        $assetdaetails->asset_unit_price = $request->asset_unit_price[$key];
        $assetdaetails->asset_value = $request->asset_value_dr[$key];
        $assetdaetails->save();

         $this->createAssetDepreciationInfoDetails($assetdata->id,$request->category_id,$request->product_id[$key],$request->asset_value_dr[$key] , $assetDepreciation);

      }
      */

      $usid = Auth::id();
      if(@$request->payment_value_cr > 0){
       if ($request->payment_mode == "Bank") {

                $paymentInvoNumber = new Payment_number();
                $paymentInvoNumber->amount = $request->payment_value_cr;
                $paymentInvoNumber->user_id = $usid;
                $paymentInvoNumber->save();
                $bankdetails = MasterBank::where('bank_id', $request->bank_id)->first();
                $bank_receieve = new Payment();
                $bank_receieve->asset_id = $assetdata->id;
                $bank_receieve->bank_id = $request->bank_id;
                $bank_receieve->bank_name = $bankdetails->bank_name;
                $bank_receieve->amount = $request->payment_value_cr;
                $bank_receieve->payment_date = $request->date;
                $bank_receieve->payment_type = 'PAYMENT';
                $bank_receieve->type = 'BANK';
                $bank_receieve->invoice = $paymentInvoNumber->id;
                $bank_receieve->created_by =  $usid;
                // $bank_receieve->ledger_status = 1;
               $bank_receieve->payment_description = "Asset -".$request->description;
                $bank_receieve->save();
            }


            if ($request->payment_mode == "Cash") {

                $paymentInvoNumber = new Payment_number();
                $paymentInvoNumber->amount = $request->amount;
                $paymentInvoNumber->user_id = $usid;
                $paymentInvoNumber->save();
                $cashdetails = MasterCash::where('wirehouse_id', $request->wirehouse_id)->first();
                $cash_receieve = new Payment();
                $cash_receieve->asset_id = $assetdata->id;
                $cash_receieve->wirehouse_id = $request->wirehouse_id;
                $cash_receieve->wirehouse_name = $cashdetails->wirehouse_name;
                $cash_receieve->amount = $request->payment_value_cr;
                $cash_receieve->payment_date = $request->date;
                $cash_receieve->payment_type = 'PAYMENT';
                $cash_receieve->type = 'CASH';
                $cash_receieve->invoice = $paymentInvoNumber->id;
                $cash_receieve->created_by =  $usid;
                // $cash_receieve->ledger_status = 1;
                $cash_receieve->payment_description = "Asset -".$request->description;
                $cash_receieve->save();

                }
      }
        return redirect()->route('asset.index')->with('success', 'Asset Created Successfull');
    }


     public function editasset($id)
    {
        $assettype = AssetType::all();
        $shortclient = ShortTermLibilitiesClient::all();
        $assetclint = AssetClint::all();
        $longclient = longTermLibilitiesClient::all();
        $assetcat =  AssetCategory::all();
        $assetproduct =  AssetProduct::all();
        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $banks = MasterBank::orderBy('bank_name', 'ASC')->get();
        $cashes = MasterCash::orderBy('wirehouse_name', 'ASC')->get();

       $assets = Asset::where('id',$id)->first();
       $assetdetils = AssetDetail::where('asset_id',$id)->get();

        return view('backend.assets.ganeral_asset_edit', compact('assets','assetdetils','dealers', 'banks', 'cashes', 'shortclient', 'longclient', 'assettype','assetclint','assetcat','assetproduct'));
    }
    public function assetupdate(Request $request)
    {
       // dd($request->all());


        $assetdata =  Asset::where('id',$request->id)->first();

    //  dd($assetdata);
        $assetdata->date = $request->date;

       // $assetdata->asset_head = $request->asset_head;
        $assetdata->asset_type = $request->asset_type;
        //$assetdata->asset_head = $request->asset_head;
        $assetdata->asset_category_id = $request->category_id;
        $assetdata->client_id = $request->clint_id;
       // $assetdata->asset_product_id = $request->product_id;
       // $assetdata->asset_qty = $request->asset_qty;
      //  $assetdata->asset_unit_price = $request->asset_unit_price;
      //  $assetdata->asset_value = $request->asset_value_dr;

      //  $assetdata->client_type = $request->client_type;
       // $assetdata->short_term_client_id = $request->short_client;
      //  $assetdata->long_term_client_id = $request->long_client;

        $assetdata->asset_value = $request->total_amount;
        $assetdata->payment_value = $request->payment_value_cr;
        $assetdata->remaining_value = $request->remaining_value_dr;
        $assetdata->asset_term = $request->asset_term;

        $assetdata->payment_mode = $request->payment_mode;
        $assetdata->wirehouse_id = $request->wirehouse_id;
        $assetdata->bank_id = $request->bank_id;
        $assetdata->description = $request->description;
        $assetdata->save();
        //$assetdata->invoice = $assetdata->id+10000;
       // $assetdata->save();

      AssetDetail::where('asset_id',$request->id)->delete();

      foreach($request->product_id as $key=> $item ){

        $assetdaetails = new AssetDetail();
        $assetdaetails->invoice = $assetdata->invoice;
        $assetdaetails->asset_id = $assetdata->id;
        $assetdaetails->category_id = $request->category_id;
        $assetdaetails->product_id = $request->product_id[$key];
        $assetdaetails->asset_qty = $request->asset_qty[$key];
        $assetdaetails->asset_unit_price = $request->asset_unit_price[$key];
        $assetdaetails->asset_value = $request->asset_value_dr[$key];

        $assetdaetails->save();

      }
      $usid = Auth::id();
       if ($request->payment_mode == "Bank") {


                $bankdetails = MasterBank::where('bank_id', $request->bank_id)->first();

                $bank_receieve = Payment::where('asset_id',$request->id)->first();
         		if($bank_receieve){

                  $bank_receieve->asset_id = $assetdata->id;
                  $bank_receieve->bank_id = $request->bank_id;
                  $bank_receieve->bank_name = $bankdetails->bank_name;
                  $bank_receieve->amount = $request->payment_value_cr;
                  $bank_receieve->payment_date = $request->date;
                  $bank_receieve->payment_type = 'PAYMENT';
                  $bank_receieve->type = 'BANK';
                  $bank_receieve->updated_by =  $usid;
                  // $bank_receieve->ledger_status = 1;
                 $bank_receieve->payment_description = "Asset -".$request->description;
                  $bank_receieve->save();
                }

            }


            if ($request->payment_mode == "Cash") {



                $cashdetails = MasterCash::where('wirehouse_id', $request->wirehouse_id)->first();

            $cash_receieve =  Payment::where('asset_id',$request->id)->first();

                  if($cash_receieve){
                   $cash_receieve->asset_id = $assetdata->id;
                  $cash_receieve->wirehouse_id = $request->wirehouse_id;
                  $cash_receieve->wirehouse_name = $cashdetails->wirehouse_name;
                  $cash_receieve->amount = $request->payment_value_cr;
                  $cash_receieve->payment_date = $request->date;
                  $cash_receieve->payment_type = 'PAYMENT';
                  $cash_receieve->type = 'CASH';
                 $cash_receieve->updated_by =  $usid;
                  // $cash_receieve->ledger_status = 1;
                  $cash_receieve->payment_description = "Asset -".$request->description;
                  $cash_receieve->save();

                  }
             }



        return redirect()->route('asset.index')->with('success', 'Asset Updated Successfull');
    }

	public function assetdelete(Request $request)
    {
      //dd($request->all());
      $invoice = Asset::where('id',$request->id)->value('invoice');
      ChartOfAccounts::where('invoice',$invoice)->delete();
      AssetDepreciationInfoDetails::where('invoice',$invoice)->delete();
      Asset::where('id',$request->id)->delete();
       $assetdetils = AssetDetail::where('asset_id',$request->id)->delete();
       $uid = Auth::id();
          Payment::where('asset_id',$request->id)->update([
        'status' => 0,
       // 'ledger_status' => 0,
        'deleted_by'=>$uid
        ]);

      return redirect()->back()->with('success', 'Asset Deleted Successfull');
    }

    public function shorttermlibilitiescreate()
    {
        return view('backend.assets.short_term_libilities_clients_create');
    }
    public function storeshorttermlibilitiesclient(Request $request)
    {
        $storedata =  new ShortTermLibilitiesClient();
        $storedata->name = $request->client_name;
        $storedata->opening_balance = $request->op_balance;
        $storedata->phone = $request->phone_no;
        $storedata->address = $request->address;
        $storedata->save();
        return redirect()->route('asset.short.term.libilities.list')->with('success', ' Create Successfull');
    }
    public function shorttermlibilitieslist()
    {
        $stlcdata = ShortTermLibilitiesClient::all();
        return view('backend.assets.short_term_libilities_cl_index', compact('stlcdata'));
    }

  	public function deleteshortlc(Request $request)
    {
    	//dd($request->all());
      	ShortTermLibilitiesClient::where('id',$request->id)->delete();
      	return redirect()->back()->with('success', 'Asset Deleted Successfull');
    }
    public function longtermlibilitiescreate()
    {
        return view('backend.assets.long_term_libilities_clients_create');
    }

    public function storelongtermlibilitiesclient(Request $request)
    {
        $storedata =  new LongTermLibilitiesClient();
        $storedata->name = $request->client_name;
        $storedata->opening_balance = $request->op_balance;
        $storedata->phone = $request->phone_no;
        $storedata->address = $request->address;
        $storedata->save();
        return redirect()->route('asset.long.term.libilities.list')->with('success', ' Create Successfull');
    }
    public function longtermlibilitieslist()
    {
        $ltlcdata = LongTermLibilitiesClient::all();
        return view('backend.assets.long_term_libilities_cl_index', compact('ltlcdata'));
    }
  	public function deletelonglc(Request $request)
    {
    	//dd($request->all());
      	LongTermLibilitiesClient::where('id',$request->id)->delete();
      	return redirect()->back()->with('success', 'Asset Deleted Successfull');
    }

    public function assetreportindex()
    {
        $assettype = AssetType::all();
        return view('backend.assets.asset_report', compact('assettype'));
    }
    public function viewreport(Request $request)
    {
       //  dd($request->all());
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
        // dd();
        $assets = DB::table('assets')->select('assets.*','asset_types.asset_type_name','asset_clints.name as clint_name','asset_categories.name as category_name')
          ->leftJoin('asset_categories', 'asset_categories.id', 'assets.asset_category_id')
      			->leftJoin('asset_types', 'asset_types.id', 'assets.asset_type')
              ->leftJoin('asset_clints', 'asset_clints.id', 'assets.client_id')
            ->whereBetween('date', [$fdate, $tdate]);

        if ($request->asset_type != null) {
            $assets = $assets->where('asset_type', $request->asset_type);
        }
      if ($request->all_assets == 1) {
            $assets = $assets->where('investment', 0)->where('intangible', 0);
        }
        if ($request->all_assets == 2) {
            $assets = $assets->where('investment', 1);
        }
       if ($request->all_assets == 3) {
            $assets = $assets->where('intangible', 1);
        }
        $assets = $assets->get();
     // dd($assets);
        return view('backend.assets.assets_report_view', compact('assets', 'fdate', 'tdate'));
    }


    public function assetcategory()
    {
        $assetcat = AssetCategory::all();
        return view('backend.assets.asset_category', compact('assetcat'));
    }


    public function storeassetcategory(Request $request)
    {
        // dd($request->all());
        $assetcat = new AssetCategory();

        $assetcat->name = $request->name;
        $assetcat->description = $request->description;
        $assetcat->save();
        return redirect()->back()->with('success', 'Asset Category Created Successfull');
    }
    public function deleteassetcategory(Request $request)
    {
      //dd($request->all());
      AssetCategory::where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Asset Category Deleted Successfull');
    }

    public function assetGroup()
    {
        $assetgroups = AssetGroup::all();
        $assetcat = AssetCategory::all();
        return view('backend.assets.asset_group', compact('assetgroups','assetcat'));
    }


    public function storeAssetGroup(Request $request)
    {
        // dd($request->all());
        $assetcat = new AssetGroup();

        $assetcat->category_id = $request->category_id;
        $assetcat->name = $request->name;
        $assetcat->description = $request->description;
        $assetcat->save();
        $categoryName = AssetCategory::where('id',$request->category_id)->value('name');

        $this->createLedgerForCoa($categoryName, $request->name);

        return redirect()->back()->with('success', 'Asset Group Created Successfull');
    }
    public function deleteAssetGroup(Request $request)
    {
      //dd($request->all());
      AssetGroup::where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Asset Group Deleted Successfull');
    }



   public function assetproduct()
    {
        $assetproduct = AssetProduct::select('asset_products.*','asset_groups.name')
          ->leftJoin('asset_groups', 'asset_groups.id', 'asset_products.group_id')->get();
        return view('backend.assets.asset_product', compact('assetproduct'));
    }

   public function assetproductview($id)
    {
        $assetproduct = AssetProduct::select('asset_products.*','asset_categories.name as catname')
          ->leftJoin('asset_categories', 'asset_categories.id', 'asset_products.category_id')
          ->where('asset_products.id',$id)
          ->first();
     $assetproductdetails = DB::table('asset_product_details')->where('asset_product_id',$id)->get();

        return view('backend.assets.asset_product_details', compact('assetproduct','assetproductdetails'));
    }

    public function assetproductCreate()
    {
        $assetproduct = AssetProduct::all();
        $assetcat = AssetGroup::all();

        return view('backend.assets.asset_product_create', compact('assetproduct','assetcat'));
    }


    public function storeassetproduct(Request $request)
    {
        //dd($request->all());
        $data = AssetProduct::where('product_name',$request->product_name)->first();
      	if(!empty($data)){
        return redirect()->back()->with('warning', 'The Asset Product Already Exists');
        } else {
        $assetproduct = new AssetProduct();
        $assetproduct->product_name = $request->product_name;
        $assetproduct->group_id = $request->group_id;
        //$assetproduct->category_id = $request->category_id;
        $assetproduct->depreciation_rate = $request->depreciation_rate;
        $assetproduct->depreciation_year = $request->depreciation_year;
        //$assetproduct->balance = $request->balance;
        $assetproduct->date = $request->date;
        $assetproduct->warranty_date = $request->warranty_date;
        $assetproduct->guarantee_date = $request->guarantee_date;
        $assetproduct->description = $request->description;
        $assetproduct->save();

        $invoice = 'AsstP-'.$assetproduct->id;
        $category = AssetGroup::where('id',$request->group_id)->value('name');

         $this->createLedgerForCoa($category, $request->product_name);
        // if($assetProduct){
        //   $this->assetSubGroupDebit($request->product_name,$request->balance, $request->date , $description = 'Fixed Asset Product', $invoice );
        // }

        $assetproduct->invoice = $invoice;
        $assetproduct->save();

        if ($request->hasFile('image')) {
        $mainimage = $request->image;
        $imagename = 'AssetProduct'.$assetproduct->id.'.'.$mainimage->getClientOriginalExtension();
       // Image::make($mainimage)->save(base_path('public/uploads/'.$imagename));
        $mainimage->move(public_path('uploads'), $imagename);

          $assetproduct->invoice = $invoice;
          $assetproduct->image = $imagename;
          $assetproduct->save();
      }

      foreach($request->specification as $key => $item){

          DB::table('asset_product_details')->insert([
           'asset_product_id' => $assetproduct->id,
           'head' => $request->specification[$key],
           'value' => $request->value[$key]

          ]);
      }
        return redirect()->route('asset.product')->with('success', 'Asset Product Created Successfull');
    }
  }

  public function updateAssetProduct(Request $request){
  //  dd($request->all());
  $assetProduct = AssetProduct::where('id',$request->id)->first();

  $invoice = $assetProduct->invoice;
  $name =  $assetProduct->product_name;
  $date = $assetProduct->date ?? '2023-10-01';

  $assetProduct->balance = $request->balance;
  $assetProduct->dep_amount = $request->dep_amount;
  $assetProduct->date = $date;
  $assetProduct->save();

  if($assetProduct){
    ChartOfAccounts::where('invoice',$invoice)->delete();
    $this->assetSubGroupDebit($name,$request->balance, $date , $description = 'Fixed Asset Product Opening', $invoice );
  }

  $preTime = strtotime($date);
  $preDate = date("Y-m-01", strtotime("-1 month", $preTime));

  $AssetOfDepreciation = new  AssetDepreciationInfoDetails;
  $AssetOfDepreciation->date = $preDate;
  $AssetOfDepreciation->invoice = $invoice;
  $AssetOfDepreciation->category_id = $assetProduct->category_id;
  $AssetOfDepreciation->product_id = $assetProduct->id;
  $AssetOfDepreciation->asset_value = 0;
  $AssetOfDepreciation->total_asset = $request->balance;
  $AssetOfDepreciation->status = 0;
  $AssetOfDepreciation->depreciation_year = date("Y", strtotime($preDate));
  $AssetOfDepreciation->depreciation_month = date("m", strtotime($preDate));
  $AssetOfDepreciation->remaining_value = $request->balance;

  $AssetOfDepreciation->dep_account = $request->dep_amount ?? 0;
  $AssetOfDepreciation->save();
    if($request->dep_amount > 0) {
      $this->createCreditForDepreciation('Accumulated Depreciation' , $request->dep_amount,  $date, $description='Accumulated Depreciation Opening', $invoice );
    }
  $time = strtotime($date);
  $rate = $assetProduct->depreciation_rate;
  $count = $assetProduct->depreciation_year * 12;


//  $remainValue = $request->balance - $request->dep_amount;



  for($i = 0; $i < $count ; $i++){
    $finalDate = date("Y-m-d", strtotime("+".$i." month", $time));

    $preDepTime =  strtotime($finalDate);
    $preDepStartDate = date("Y-m-01", strtotime("-1 month", $preDepTime));
    $preDepEndDate = date("Y-m-t", strtotime("-1 month", $preDepTime));

    $depData = AssetDepreciationInfoDetails::where('product_id',$request->id)->whereBetween('date',[$preDepStartDate, $preDepEndDate])->first();

    $depAmount = $depData->dep_account;

    if($i == 0){
    $remainValue = $depData->remaining_value - $depAmount ;
    } else {
    $remainValue = $depData->total_asset - $depAmount ;
    }

  //$remainValue = $depData->remaining_value;

    $amount = (($remainValue * $rate) / 100 ) / 12;

    $totalAmount = $amount + $depAmount;

    //$remainValue = $depData->remaining_value - $totalAmount;

    $AssetOfDepreciation = new  AssetDepreciationInfoDetails;
    $AssetOfDepreciation->date = $finalDate;
    $AssetOfDepreciation->invoice = $invoice;
    //$AssetOfDepreciation->ac_asset_id = $assetdata->id;
    $AssetOfDepreciation->category_id = $assetProduct->category_id;
    $AssetOfDepreciation->product_id = $assetProduct->id;
    /*if($i == 0){
      $AssetOfDepreciation->asset_value = $request->balance;
    } else {
      $AssetOfDepreciation->asset_value = 0;
    } */
    $AssetOfDepreciation->asset_value = 0;
    $AssetOfDepreciation->total_asset = $depData->total_asset;
    $AssetOfDepreciation->status = 0;
    $AssetOfDepreciation->depreciation_year = date("Y", strtotime($finalDate));
    $AssetOfDepreciation->depreciation_month = date("m", strtotime($finalDate));
    $AssetOfDepreciation->remaining_value = $remainValue;
    $AssetOfDepreciation->account_value = $amount;
    $AssetOfDepreciation->dep_account = $totalAmount;
    $AssetOfDepreciation->save();

    $this->createCreditForDepreciation('Accumulated Depreciation' , $amount,  $finalDate, $description='Fixed Asset Product Opening', $invoice );
    $this->createDebitForDepreciation('Depreciation Expense' , $amount, $finalDate, $description='Fixed Asset Product Opening', $invoice );
  }

  return redirect()->route('asset.product')->with('success', 'Asset Product Opening Balance updated Successfull');
  }

  public function deleteassetproduct(Request $request)
    {
      //dd($request->all());
      $product =  AssetProduct::where('id',$request->id)->first();
      $image_path = public_path('uploads/').$product->image;  // Value is not URL but directory file path
     // dd($image_path);
        if (file_exists($image_path)) {

           @unlink($image_path);

       }
        ChartOfAccounts::where('invoice',$product->invoice)->delete();
        AssetDepreciationInfoDetails::where('invoice',$product->invoice)->delete();
        DB::table('ac_sub_sub_account')->where('title',$product->product_name)->delete();
        DB::table('asset_product_details')->where('asset_product_id', $request->id)->delete();
        AssetProduct::where('id',$request->id)->delete();


      return redirect()->back()->with('success', 'Asset Head Deleted Successfull');
    }

   public function ClintList()
    {
        $stlcdata = AssetClint::all();
        return view('backend.assets.clint_index', compact('stlcdata'));
    }

   public function clintCreate()
    {
        return view('backend.assets.clint_create');
    }
    public function clintStore(Request $request)
    {
        $storedata =  new AssetClint();
        $storedata->name = $request->client_name;
        $storedata->opening_balance = $request->op_balance;
        $storedata->phone = $request->phone_no;
        $storedata->address = $request->address;
        $storedata->save();
        return redirect()->route('asset.clint.list')->with('success', ' Create Successfull');
    }


  	public function clintdelete(Request $request)
    {
    	//dd($request->all());
      	AssetClint::where('id',$request->id)->delete();

      	return redirect()->back()->with('success', 'Deleted Successfull');
    }
    

   	public function assetGetproduct($cid)
    {
    	//dd($request->all());
     //$catp =  	AssetProduct::where('category_id',$cid)->get();
     $catp =  	AssetProduct::where('group_id',$cid)->get();

      	return response($catp);
    }





   public function investmentList()
    {
        $stlcdata = Asset::select('assets.*','asset_categories.name')->leftJoin('asset_categories', 'asset_categories.id', 'assets.asset_category_id')->where('investment',1)->get();
        return view('backend.assets.investment_index', compact('stlcdata'));
    }

   public function investmentCreate()
    {
        return view('backend.assets.investment_create');
    }
    public function investmentStore(Request $request)
    {
      //dd($request->all());
        $storedata =  new Asset();
        $storedata->date = $request->date;
        $storedata->company_name = $request->company_name;
        $storedata->asset_qty = $request->share_qty;
        $storedata->asset_unit_price = $request->share_rate;
        $storedata->asset_value = $request->share_value;
        $storedata->investment = 1;
        $storedata->save();
      $storedata->invoice = $storedata->id+10000;
        $storedata->save();
        return redirect()->route('asset.investment.list')->with('success', 'Investment Entry Successfull');
    }


  	public function investmentdelete(Request $request)
    {
    	//dd($request->all());
      	Asset::where('id',$request->id)->delete();

      	return redirect()->back()->with('success', ' Deleted Successfull');
    }


   public function IntangibleList()
    {
        $stlcdata = Asset::select('assets.*','asset_categories.name')->leftJoin('asset_categories', 'asset_categories.id', 'assets.asset_category_id')->where('intangible',1)->get();
        return view('backend.assets.intangible_index', compact('stlcdata'));
    }

   public function IntangibleCreate()
    {
      $assetcat = AssetCategory::all();
        return view('backend.assets.intangible_create', compact('assetcat'));
    }
    public function IntangibleStore(Request $request)
    {
      //dd($request->all());
        $storedata =  new Asset();
        $storedata->date = $request->date;
        $storedata->asset_category_id = $request->category_id;
        $storedata->asset_value = $request->amount;
        $storedata->description = $request->description;
        $storedata->intangible = 1;
        $storedata->save();
      $storedata->invoice = $storedata->id+10000;
        $storedata->save();

        return redirect()->route('asset.Intangible.list')->with('success', 'Investment Entry Successfull');
    }


  	public function Intangibledelete(Request $request)
    {
    	//dd($request->all());
      	Asset::where('id',$request->id)->delete();

      	return redirect()->back()->with('success', ' Deleted Successfull');
    }




   public function assetdepreciationlist()
    {
        $stlcdata =AssetDepreciation::select('asset_depreciations.*','asset_products.product_name','assets.asset_head')
          		->leftJoin('assets', 'assets.id', 'asset_depreciations.asset_id')
          		->leftJoin('asset_products', 'asset_products.id', 'asset_depreciations.asset_product_id')
          		->orderby('id','desc')->get();
   //  dd($stlcdata);
     return view('backend.assets.depreciation_index', compact('stlcdata'));
    }

   public function assetdepreciation()
    {
      $assetcat = AssetCategory::all();
      $assets = Asset::where('intangible',0)->where('investment',0)->get();
        return view('backend.assets.depreciation_create', compact('assetcat','assets'));
    }

   public function assetdepreciationgetassetproduct($asset_id)
    {
      $assetcat = AssetCategory::all();
      $assets = AssetDetail::select('asset_details.*','asset_products.product_name')->leftJoin('asset_products', 'asset_products.id', 'asset_details.product_id')
        ->where('asset_id',$asset_id)->get();
        return response($assets);
    }

    public function assetdepreciationgetassetproductdetails($asset_id)
    {
      $assetcat = AssetCategory::all();
      $assets = AssetDetail::where('id',$asset_id)->first();
        return response($assets);
    }


    public function assetdepreciationstore(Request $request)
    {
     // dd($request->all());
        $storedata =  new AssetDepreciation();
        $storedata->date = $request->date;
        $storedata->asset_id = $request->asset_id;
        $storedata->asset_details_id = $request->asset_details_id;
        $storedata->asset_product_id = $request->asset_product_id;
        $storedata->asset_product_value = $request->asset_product_value;
        $storedata->salvage_value = $request->salvage_value;
        $storedata->remaining_value = $request->rm_value;
        $storedata->year_line = $request->year_line;
        $storedata->yearly_amount = $request->yearly_amount;

        $storedata->save();

        return redirect()->route('asset.depreciation.list')->with('success', 'Depreciation Entry Successfull');
    }


  	public function depreciationdelete(Request $request)
    {
    	//dd($request->all());
      	AssetDepreciation::where('id',$request->id)->delete();

      	return redirect()->back()->with('success', ' Deleted Successfull');
    }



    public function assetnotificationlist()
    {

      $notifications = DB::table('asset_notifications')
        ->select('asset_notifications.*','asset_categories.name as catname','asset_products.product_name','asset_products.warranty_date')
        ->leftJoin('asset_categories', 'asset_categories.id', 'asset_notifications.category_id')
        ->leftJoin('asset_products', 'asset_products.id', 'asset_notifications.product_id')
        ->get();

        return view('backend.assets.notification_list', compact('notifications'));
    }
   public function assetnotification()
    {

      $assetcat = AssetCategory::all();
      $product =  AssetProduct::all();
        return view('backend.assets.notification', compact('assetcat','product'));
    }
    public function assetnotificationstore(Request $request)
    {
    //  dd($request->all());

          DB::table('asset_notifications')->insert([
           'category_id' => $request->category_id,
           'product_id' => $request->product_id,
           'type' => $request->type,
           'before_day' => $request->before_day,

          ]);

        return redirect()->route('asset.notification')->with('success', 'Notification Created Successfull');
    }


   public function assetnotificationconfirm(Request $request)
    {
      //dd($request->all());

          DB::table('asset_notifications')->where('id',$request->notificationid)->update([

           'status' => 1,

          ]);

        return redirect()->route('asset.product.view',$request->product_id)->with('success', 'Notification Seen');
    }

  	public function notificationdelete(Request $request)
    {
    	//dd($request->all());
      	DB::table('asset_notifications')->where('id',$request->id)->delete();

      	return redirect()->back()->with('success', ' Deleted Successfull');
    }



  public function assetlicense()
    {
        $assetlicense = DB::table('asset_licenses')->get();
        return view('backend.assets.asset_license', compact('assetlicense'));
    }

    public function deleteassetlicense(Request $request)
    {
      //dd($request->all());
     DB::table('asset_licenses')->where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Asset License Deleted Successfull');
    }
    public function storeassetlicense(Request $request)
    {
       // dd($request->all());
        DB::table('asset_licenses')->insert([
          'license_no' => $request->license_no,
          'expire_date' => $request->expire_date,
          'head' => $request->head,

        ]);

        return redirect()->back()->with('success', 'Asset license Created Successfull');
    }

      public function depreciationReportIndex(){
      return view('backend.assets.asset_depreciation_report_index');
    }

    public function depreciationReportView(Request $request){
      //dd($request->all());
    $startDate =   $request->month.'-01';
    $finalDate =  date("Y-m-t",strtotime($startDate));


    $preTime = strtotime($startDate);
    $preStartDate = date("Y-m-01", strtotime("-1 month", $preTime));
    $preEndDate = date("Y-m-t", strtotime("-1 month", $preTime));

      //$assetProducts =  AssetProduct::all();
    $assetCategory = AssetProduct::select('a.id','a.name')->join('asset_groups as a', 'a.id', '=', 'asset_products.group_id')->whereNotIn('group_id',[6])->whereNotNull('depreciation_rate')->groupBy('asset_products.group_id')->get();

  /*  $openingAmount = AssetDepreciationInfoDetails::whereBetween('date',[$preStartDate,$preEndDate])->sum('remaining_value');
    $currentAmount = AssetDepreciationInfoDetails::select(
                      DB::raw('SUM(asset_value) as adition'),
                      DB::raw('SUM(remaining_value) as remaining'),
                      DB::raw('SUM(account_value) as amount'))
                    ->whereBetween('date',[$startDate,$finalDate])->groupBy('product_id')->get();

    $assetSales = OthersIncome::where('product_id',$request->product_id)->whereBetween('date',[$startDate,$finalDate])->sum('amount');
    */

      return view('backend.assets.asset_depreciation_report', compact('startDate', 'finalDate', 'preStartDate', 'preEndDate' ,'assetCategory'));
    }

}
