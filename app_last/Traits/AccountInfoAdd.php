<?php
namespace App\Traits;
use App\Models\Account\IndividualAccount;
use App\Models\Account\SubSubAccount;
use App\Models\Account\MainAccount;
use App\Models\Account\SubAccount;

trait AccountInfoAdd
{ 

    public function createDealerForCoa($dealerName){
        $subSubAccount = SubSubAccount::where('title','Accounts Receivable (Dealer)')->first();
        if($subSubAccount){
            $IndividualAccount = IndividualAccount::create(['title' => $dealerName, 'ac_sub_sub_account_id' => $subSubAccount->id]);
        }
    }
    
    public function updateDealerForCoa($oldName, $dealerName){  
      $subSubAccount = SubSubAccount::where('title','Accounts Receivable (Dealer)')->first();
      if($subSubAccount){
          $IndividualAccount = IndividualAccount::where('title', $oldName)->update(['title' => $dealerName, 'ac_sub_sub_account_id' => $subSubAccount->id]);
        }
    }
    
    public function createSupplierForCoa($supplierName){
        $subSubAccount = SubSubAccount::where('title','Accounts Payable (Suppliers)')->first();
        if($subSubAccount){
            $IndividualAccount = IndividualAccount::create(['title' => $supplierName, 'ac_sub_sub_account_id' => $subSubAccount->id]);
        }
    }
    
    public function updateSupplierForCoa($oldName, $supplierName){  
            $IndividualAccount = IndividualAccount::where('title', $oldName)->update(['title' => $supplierName]);
    }
    
    public function createBankForCoa($bankName){
        $subSubAccount = SubSubAccount::where('title','Bank')->first();
        if($subSubAccount){
            $IndividualAccount = IndividualAccount::create(['title' => $bankName, 'ac_sub_sub_account_id' => $subSubAccount->id]);
        }
    }

    public function createCashForCoa($cashName){
        $subSubAccount = SubSubAccount::where('title','Cash')->first();
        if($subSubAccount){
            $IndividualAccount = IndividualAccount::create(['title' => $cashName, 'ac_sub_sub_account_id' => $subSubAccount->id]);
        } 
    }
    
      public function createAssetCategoryForCoa($assetCat){
        $obj = MainAccount::where('title','Assets')->first();
        if($obj){
            $mainAccountInfo = MainAccount::where('id',$obj->id)->first('code');
            $subAccountInfo = SubAccount::where('ac_main_account_id',$obj->id)->orderBy('id','desc')->first('code');
            if($subAccountInfo){
                $code =  $subAccountInfo->code + 1;
            }else{
                $code =   @$mainAccountInfo->code + 1;
            }
            $subAccount = SubAccount::create(['title' => $assetCat,'code' => $code,'ac_main_account_id' => $obj->id]);
        }
    }
    
    public function createExpenseGroupForCoa($expenseGroup){
        $obj = MainAccount::where('title','Expenses')->first();
        if($obj){
            $mainAccountInfo = MainAccount::where('id',$obj->id)->first('code');
            $subAccountInfo = SubAccount::where('ac_main_account_id',$obj->id)->orderBy('id','desc')->first('code');
            if($subAccountInfo){
                $code =  $subAccountInfo->code + 1;
            }else{
                $code =   @$mainAccountInfo->code + 1;
            }
            $subAccount = SubAccount::create(['title' => $expenseGroup,'code' => $code,'ac_main_account_id' => $obj->id]);
        } 
    }
    
    public function updateExpenseGroupForCoa($expenseOldGroup, $expenseGroup){
      $subAccount = SubAccount::where('title', $expenseOldGroup)->update(['title' => $expenseGroup]);
    }
    
    public function createLedgerForCoa($expenseGroupName , $ledgerName){
        $subAccountInfo = SubAccount::where('title',$expenseGroupName)->first();
        if($subAccountInfo){
          $subSubAccountInfo = SubSubAccount::where('ac_sub_account_id',$subAccountInfo->id)->orderBy('id','desc')->first('code');

          if($subSubAccountInfo){
              $code =  $subSubAccountInfo->code + 1;
          }else{
              $code =   @$subAccountInfo->code + 1;
          }
       // $code =   @$subAccountInfo->code + 1;
        $subSubAccount = SubSubAccount::create(['title' => $ledgerName,'code' => $code,'ac_sub_account_id' => $subAccountInfo->id]);
      } else {
        $subSubAccountInfo = SubSubAccount::where('title',$expenseGroupName)->first();
        $individual = IndividualAccount::where('ac_sub_sub_account_id',$subSubAccountInfo->id)->orderBy('id','desc')->first('code');
        if($individual){
            $code =  $individual->code + 1;
        }else{
            $code =   @$subSubAccountInfo->code + 1;
        }
        IndividualAccount::create(['title' => $ledgerName,'code' => $code,'ac_sub_sub_account_id' => $subSubAccountInfo->id]);
      }
    }
    
    public function updateLedgerForCoa($oldName,$expenseGroupName, $ledgerName){
        $subAccountInfo = SubAccount::where('title',$expenseGroupName)->first();
        if($subAccountInfo){
          $subSubAccountInfo = SubSubAccount::where('ac_sub_account_id',$subAccountInfo->id)->orderBy('id','desc')->first('code');

        if($subSubAccountInfo){
              $code =  $subSubAccountInfo->code + 1;
          }else{
              $code =   @$subAccountInfo->code + 1;
          }

          $subSubAccount = SubSubAccount::where('title', $oldName)->update(['title' => $ledgerName, 'code' => $code,'ac_sub_account_id' => $subAccountInfo->id]);
        } else {
          $subSubAccountInfo = SubSubAccount::where('title',$expenseGroupName)->first();
          $individual = IndividualAccount::where('ac_sub_sub_account_id',$subSubAccountInfo->id)->orderBy('id','desc')->first('code');
          if($individual){
              $code =  $individual->code + 1;
          }else{
              $code =   @$subSubAccountInfo->code + 1;
          }

          IndividualAccount::where('title', $oldName)->update(['title' => $ledgerName,'code' => $code,'ac_sub_sub_account_id' => $subSubAccountInfo->id]);
        }
      }
      
     public function createSubLedgerForCoa($expGroup , $ledgerName , $subLedgerName){
        // $subAccountInfo = SubAccount::where('title',$expGroup)->first();
        $subSubAccountInfo = SubSubAccount::where('title',$ledgerName)->first();
        $individual = IndividualAccount::where('ac_sub_sub_account_id',$subSubAccountInfo->id)->orderBy('id','desc')->first('code');
        if($individual){
            $code =  $individual->code + 1;
        }else{
            $code =   @$subSubAccountInfo->code + 1;
        }
      
        IndividualAccount::create(['title' => $subLedgerName,'code' => $code,'ac_sub_sub_account_id' => $subSubAccountInfo->id]);  
    }

}