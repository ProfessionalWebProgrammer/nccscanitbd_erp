<?php
namespace App\Traits;
use App\Models\Account\ChartOfAccounts;
use App\Models\Account\IndividualAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Account\SubSubAccount;
use App\Models\Supplier;
use App\Models\AssetClint;
use App\Models\MasterBank;
use App\Models\MasterCash;
use App\Models\AssetCategory;
use App\Models\Dealer;
use App\Models\SalesStockIn;
use Illuminate\Support\Facades\Cache;
use App\Models\Account\AssetDepreciationSetting;
use App\Models\Account\AssetDepreciationInfoDetails;
use App\Traits\ChartOfAccount;


trait AssetOfDepreciation
{ 
   use ChartOfAccount;

   public function createAssetDepreciationInfoDetails($assetId , $categoryId , $productId , $assetValue , $assetDepreciation){
        $assetDepreciationInfoDetails = new AssetDepreciationInfoDetails();
        $assetDepreciationInfoDetails->ac_asset_id = $assetId;
        $assetDepreciationInfoDetails->ac_assets_depreciation_setting_id = $assetDepreciation->id;
        $assetDepreciationInfoDetails->category_id = $categoryId;
        $assetDepreciationInfoDetails->product_id = $productId;
        $assetDepreciationInfoDetails->asset_value = $assetValue;
        $assetDepreciationInfoDetails->remaining_value = $assetValue;
        $assetDepreciationInfoDetails->status = 0;
        $assetDepreciationInfoDetails->save();
   }

    public function createYearlyDepreciation(){
        ini_set('memory_limit', '500M');
        set_time_limit(600);
       
        $assetDepreciationInfoDetails = AssetDepreciationInfoDetails::where('status' , 0)->get();
        foreach($assetDepreciationInfoDetails as $details){   
            if(Carbon::parse($details->created_at)->addMonths($details->depreciation_month)->format('Y-m-d') == Carbon::now()->format('Y-m-d')){
                $assetDepreciationSetting = AssetDepreciationSetting::where('id' , $details->ac_assets_depreciation_setting_id)->first();
                if($assetDepreciationSetting){
                    if($assetDepreciationSetting->id == 1){
                        if(($details->remaining_value > 0) && ($details->depreciation_month <= ($assetDepreciationSetting->depreciation_year * 12))){
                            $expense =  ($details->remaining_value - $assetDepreciationSetting->depreciation_rate) / ($assetDepreciationSetting->depreciation_year * 12);
                            $remainValue = $details->remaining_value -  $expense;
                            $totalMonth = $details->depreciation_month + 1;
                            $accountValue = $details->account_value +  $expense;
                            if($totalMonth == ($assetDepreciationSetting->depreciation_year * 12)){
                                $status = 1;
                            }
                            
                            AssetDepreciationInfoDetails::where('id' , $details->id)->update(['remaining_value' => $remainValue , 'depreciation_month' => $totalMonth , 'account_value' => $accountValue ,'status' => $status ?? 0]);
                            $this->createCreditForDepreciation('Accumulated Depreciation' , $expense);
                            $this->createDebitForDepreciation('Depreciation Expense' , $expense);
                        }
                    }else{
                        if(($details->remaining_value > 0) && ($details->depreciation_month <= ($assetDepreciationSetting->depreciation_year * 12))){
                            $initialPercentage =  (100 * 2) / ($assetDepreciationSetting->depreciation_year * 12);
                            $secondStepValue = ($details->remaining_value * $initialPercentage) / 100;
                            $remainValue = $details->remaining_value -  $secondStepValue;
                            $accountValue = $details->account_value +  $secondStepValue;
                            $totalMonth = $details->depreciation_month + 1;
                            if($totalMonth == ($assetDepreciationSetting->depreciation_year * 12)){
                                $status = 1;
                            }
                            AssetDepreciationInfoDetails::where('id' , $details->id)->update(['remaining_value' => $remainValue , 'depreciation_month' => $totalMonth , 'account_value' => $accountValue, 'status' => $status ?? 0]);
                            $this->createCreditForDepreciation('Accumulated Depreciation' , $secondStepValue);
                            $this->createDebitForDepreciation('Depreciation Expense' , $secondStepValue);
                        }  
                    }
                }
            }
        }
    }
}