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


trait ChartOfAccount
{
    //Payemnt by cash or bank in account department -> payment -> bank or cash payment
    public function debitForSupplier($supplier , $amount , $description,$payment_date, $invoice){
        $individualAccountForDebit = IndividualAccount::where('title',$supplier->supplier_name)->first();
        if($individualAccountForDebit){
            $data = [
                'date' => $payment_date,
                'ac_main_account_id' => $individualAccountForDebit?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $individualAccountForDebit?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $individualAccountForDebit?->acSubSubAccount?->id,
                'ac_individual_account_id' => $individualAccountForDebit?->id,
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('payment_account_id', $result->id);
        }
    }

    public function creditForBank( $bankdetails ,  $amount , $description,$payment_date,$invoice){
        $individualAccountForCredit = IndividualAccount::where('title',$bankdetails->bank_name)->first();
        if($individualAccountForCredit){
        $data = [
            'date' => $payment_date,
            'ac_main_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
            'ac_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->id,
            'ac_sub_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->id,
            'ac_individual_account_id' => $individualAccountForCredit?->id,
            'invoice' => $invoice,
            'credit' => $amount,
            'comment' => $description,
            'created_by' => Auth::id(),
            'ref_id' => Cache::get('payment_account_id')
        ];

        $result = $this->storeChartOfAccount($data);
        Cache::forget('payment_account_id');
        ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);

        }

    }

    public function creditForCash($cashdetails ,  $amount , $description,$payment_date,$invoice){
        $individualAccountForCredit = IndividualAccount::where('title',$cashdetails->wirehouse_name)->first();
        if($individualAccountForCredit){
            $data = [
                'date' => $payment_date,
                'ac_main_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->id,
                'ac_individual_account_id' => $individualAccountForCredit?->id,
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
                'ref_id' => Cache::get('payment_account_id')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('payment_account_id');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);

        }
    }

    public function assetSubGroupDebit($product , $amount , $payment_date , $description, $invoice){
        $subSubAccount = SubSubAccount::where('title',$product)->first();
        if( $subSubAccount){
            $data = [
                'date' => $payment_date,
                'ac_main_account_id' => $subSubAccount->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $subSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $subSubAccount->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('expense-id', $result->id);
        } else{
          $individualAccountForCredit = IndividualAccount::where('title',$product)->first();
          if($individualAccountForCredit){
              $data = [
                  'date' => $payment_date,
                  'ac_main_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                  'ac_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->id,
                  'ac_sub_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->id,
                  'ac_individual_account_id' => $individualAccountForCredit?->id,
                  'invoice' => $invoice,
                  'debit' => $amount,
                  'comment' => $description,
                  'created_by' => Auth::id(),
                  'ref_id' => Cache::get('payment_account_id')
              ];
              $result = $this->storeChartOfAccount($data);
              Cache::forget('payment_account_id');
              ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);

          }
        }
      }
    public function journalEntryCredit($product , $amount , $payment_date , $description, $invoice){
          $subSubAccount = SubSubAccount::where('title',$product)->first();
          if( $subSubAccount){
              $data = [
                  'date' => $payment_date,
                  'ac_main_account_id' => $subSubAccount->acSubAccount?->acMainAccount?->id,
                  'ac_sub_account_id' => $subSubAccount?->acSubAccount?->id,
                  'ac_sub_sub_account_id' => $subSubAccount->id,
                  'ac_individual_account_id' => '',
                  'invoice' => $invoice,
                  'credit' => $amount,
                  'comment' => $description,
                  'created_by' => Auth::id()
              ];
              $result = $this->storeChartOfAccount($data);
              Cache::put('expense-id', $result->id);
          } else{
            $individualAccountForCredit = IndividualAccount::where('title',$product)->first();
            if($individualAccountForCredit){
                $data = [
                    'date' => $payment_date,
                    'ac_main_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccountForCredit?->id,
                    'invoice' => $invoice,
                    'credit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id(),
                    'ref_id' => Cache::get('payment_account_id')
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::forget('payment_account_id');
                ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);

            }
          }
        }
        
      public function interCompanyCredit($product , $amount , $payment_date , $description, $invoice){
        $subSubAccount = SubSubAccount::where('title',$product)->first();
        if( $subSubAccount){
            $data = [
                'date' => $payment_date,
                'ac_main_account_id' => $subSubAccount->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $subSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $subSubAccount->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];
            $result = $this->storeChartOfAccount($data);
            //Cache::put('expense-id', $result->id);
        }
      }

      public function createBankChargeDebit($product , $amount , $payment_date , $description, $invoice){
        $subSubAccount = SubSubAccount::where('title',$product)->first();
        if( $subSubAccount){
            $data = [
                'date' => $payment_date,
                'ac_main_account_id' => $subSubAccount->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $subSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $subSubAccount->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];
            $result = $this->storeChartOfAccount($data);
            //Cache::put('expense-id', $result->id);
        }
      }

    // Payment by cash or bank in account department -> Expense -> Create Expense payment
    
    // 28-05-2024 Expense type functionality added END CODE
    public function expenseOnReceivedCredit( $expanseSubgroups ,$amount , $payment_date , $description,$invoice){
        $accountInfo = SubSubAccount::where('title',$expanseSubgroups)->first();
        if($accountInfo){
            $data = [
                'date' => $payment_date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('sale-finished-goods', $result->id);
        }
    }
    

    public function expenseSubGroupDebit($expanseSubgroups , $amount , $payment_date , $description, $invoice){
        $subSubAccount = SubSubAccount::where('title',$expanseSubgroups)->first();
        if( $subSubAccount){
            $data = [
                'date' => $payment_date,
                'ac_main_account_id' => $subSubAccount->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $subSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $subSubAccount->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('expense-id', $result->id);
        } else {

          $individualAccount = IndividualAccount::where('title',$expanseSubgroups)->first();
          if($individualAccount){
              $data = [
                  'date' => $payment_date,
                  'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                  'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                  'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                  'ac_individual_account_id' => $individualAccount?->id,
                  'invoice' => $invoice,
                  'debit' => $amount,
                  'comment' => $description,
                  'created_by' => Auth::id()
              ];
              $result = $this->storeChartOfAccount($data);
              Cache::put('expense-id', $result->id);
          }
        }

    }

    public function expenseSubSubGroupDebit($expanseSubSubgroups , $amount , $payment_date , $description,$invoice){
        $individualAccount = IndividualAccount::where('title',$expanseSubSubgroups->subSubgroup_name)->first();
        if(  $individualAccount){
            $data = [
                'date' => $payment_date,
                'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                'ac_individual_account_id' => $individualAccount?->id,
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('expense-id', $result->id);
        }

    }


    public function expenseForSubSubBankCredit( $bankName ,$amount , $payment_date , $description,$invoice){
        $individualAccount = IndividualAccount::where('title',$bankName)->first();
        if(  $individualAccount){
            $data = [
                'date' => $payment_date,
                'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                'ac_individual_account_id' => $individualAccount?->id,
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
                'ref_id' => Cache::get('expense-id')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('expense-id');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }

    public function expenseForSubSubCashCredit( $cashName ,$amount , $payment_date , $description,$invoice){
        $individualAccount = IndividualAccount::where('title',$cashName)->first();
        if(  $individualAccount){
            $data = [
                'date' => $payment_date,
                'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                'ac_individual_account_id' => $individualAccount?->id,
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
                'ref_id' => Cache::get('expense-id')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('expense-id');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }

    //Purchase in purchase department -> GRR Entry
    public function createCreditForPurchase($supplierId , $amount , $date , $description = null, $invoice){
        $supplier = Supplier::where('id', $supplierId)->first();
        if( $supplier ){
            $individualAccount = IndividualAccount::where('title',$supplier->supplier_name)->first();
            if(  $individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'credit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id()
                ];
               $result = $this->storeChartOfAccount($data);
               Cache::put('raw-material-purchase', $result->id);
            }
        }
    }

    public function createDebitForPurchase($supplierId , $amount , $date , $description = null, $invoice){

            $individualAccount = IndividualAccount::where('title','Raw Materials')->first();
            if(  $individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'debit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id(),
                    'ref_id' => Cache::get('raw-material-purchase')
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::forget('raw-material-purchase');
                ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
            }
    }

     //Purchase in purchase department -> MRR Entry (Finish Goods)
    public function createCreditForFGPurchase($supplierId , $amount , $date , $description = null, $invoice){
        $supplier = Supplier::where('id', $supplierId)->first();
        if( $supplier ){
            $individualAccount = IndividualAccount::where('title',$supplier->supplier_name)->first();
            if(  $individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'credit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id()
                ];
               $result = $this->storeChartOfAccount($data);
               Cache::put('raw-material-purchase', $result->id);
            }
        }
    }

    public function createDebitForFGPurchase($supplierId , $amount , $date , $description = null, $invoice){

            $individualAccount = IndividualAccount::where('title','FG')->first();
            if(  $individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'debit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id(),
                    'ref_id' => Cache::get('raw-material-purchase')
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::forget('raw-material-purchase');
                ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
            }
    }
    //Purchase in purchase department -> MRR Entry (Bag)
    public function createCreditForBagPurchase($supplierId , $amount , $date , $description = null, $invoice){
        $supplier = Supplier::where('id', $supplierId)->first();

        if( $supplier ){
            $individualAccount = IndividualAccount::where('title',$supplier->supplier_name)->first();
            if(  $individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'credit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id()
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::put('bag-purchase', $result->id);
            }
        }
    }

    public function createDebitForBagPurchase($account , $amount , $date , $description = null,$invoice){

            $individualAccount = IndividualAccount::where('title',$account)->first();
            if(  $individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'debit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id(),
                    'ref_id' => Cache::get('bag-purchase')
                ];

                $result = $this->storeChartOfAccount($data);
                Cache::forget('bag-purchase');
                ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
            }
    }

   //Purchase in purchase department -> Return
    public function createCreditForPurchaseReturn($account ,$amount , $date, $invoice){
        $acSubSubAccount = SubSubAccount::where('title',$account)->first();
        if(  $acSubSubAccount){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $acSubSubAccount?->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => '',
                'created_by' => Auth::id(),

            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('return-purchase', $result->id);
        }
    }

    public function createDebitForPurchaseReturn($supplierId , $amount, $date, $invoice){
        $supplier = Supplier::where('id', $supplierId)->first();
        if( $supplier ){
            $individualAccount = IndividualAccount::where('title',$supplier->supplier_name)->first();
            if(  $individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'debit' => $amount,
                    'comment' => '',
                    'created_by' => Auth::id(),
                    'ref_id' => Cache::get('return-purchase')
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::forget('return-purchase');
                ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);

            }
        }


    }

    public function createCreditForPurchaseReturnAccount($account ,$amount , $date, $invoice){
        $acSubSubAccount = SubSubAccount::where('title',$account)->first();
        if(  $acSubSubAccount){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $acSubSubAccount?->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => '',
                'created_by' => Auth::id(),

            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('return-purchase-inventory', $result->id);
        }
    }

      public function createDebitForPurchaseReturnAccount($account ,$amount , $date, $invoice){
        $acSubSubAccount = SubSubAccount::where('title',$account)->first();
        if(  $acSubSubAccount){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $acSubSubAccount?->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => '',
                'created_by' => Auth::id(),
                'ref_id' => Cache::get('return-purchase-inventory')

            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('return-purchase-inventory');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }

    //Asset in Purchase Account Department -> Asset -> Asset Entry

    public function createCreditForAssetWithPayment($accountType ,$accountId, $amount, $date , $description = null, $invoice){
       if($accountType == 'Bank'){
           $accountInfo = MasterBank::where('bank_id',$accountId)->first();
           if($accountInfo){
            $accountName = $accountInfo->bank_name;
           }
       }else{
        $accountInfo = MasterCash::where('wirehouse_id',$accountId)->first();
        if($accountInfo){
            $accountName = $accountInfo->wirehouse_name;
           }
       }

        if( @$accountName ){
            $individualAccount = IndividualAccount::where('title',$accountName)->first();
            if(  $individualAccount  ){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'credit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id()
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::put('asset-purchase', $result->id);
            }
        }
    }

    public function createDebitForAssetWithPayment($accountId , $amount, $date , $description = null){
        //$assetClint = AssetClint::where('id',$accountId)->first();
        $assetClint = AssetProduct::where('id',$accountId)->first();
        if( $assetClint ){
            $individualAccount = SubSubAccount::where('title',$assetClint->product_name)->first();
           // $individualAccount = IndividualAccount::where('title',$assetClint->product_name)->first();
            if($individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'debit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id(),
                    'ref_id' => Cache::get('asset-purchase')
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::forget('asset-purchase');
                ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
            }
        }
    }

    public function createCreditForAssetWithoutPayment($accountId , $amount, $date , $description = null){
        $assetClint = AssetClint::where('id',$accountId)->first();
        if( $assetClint ){
            $individualAccount = IndividualAccount::where('title',$assetClint->name)->first();
            if($individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'credit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id()
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::put('asset-without-purchase', $result->id);
            }
        }
    }

    public function createDebitForAssetWithoutPayment($accountId , $amount, $date , $description = null){
        $accountInfo = AssetCategory::where('id',$accountId)->first();
        if( $accountInfo ){
            $individualAccount = IndividualAccount::where('title',$accountInfo->name)->first();
            if($individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'debit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id(),
                    'ref_id' => Cache::get('asset-without-purchase')
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::forget('asset-without-purchase');
                ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
            }
        }
    }

    //sale in Sales Department -> order and list
    public function createCreditForFinishedGoodsSale($accountName , $amount, $date, $description = null,$invoice){
        $accountInfo = SubSubAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('sale-finished-goods', $result->id);
        }
    }

    public function createDebitForFinishedGoodsSale($accountId , $amount, $date, $description = null, $invoice){
        $dealer = Dealer::where('id' , $accountId)->first();
        if($dealer){
            $individualAccount = IndividualAccount::where('title', $dealer->d_s_name)->first();
            if($individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'debit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id(),
                    'ref_id' => Cache::get('sale-finished-goods')
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::forget('sale-finished-goods');
                ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
            }
        }
    }

    public function createCreditForCogsOfFinishedGoodsSale($accountName , $amount, $date, $description = null,$invoice){

        $accountInfo = IndividualAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->acSubSubAccount?->id,
                'ac_individual_account_id' => $accountInfo->id,
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('sale-finished-goods-cogs', $result->id);
        }
    }

    public function createDeditForCogsOfFinishedGoodsSale($accountName , $amount, $date, $description = null,$invoice){

        $accountInfo = SubSubAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
                'ref_id' => Cache::get('sale-finished-goods-cogs')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('sale-finished-goods-cogs');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }

    public function createCreditForRawMaterialsSale($accountName , $amount, $date, $description = null,$invoice){
        $accountInfo = SubSubAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('sale-raw-naterial', $result->id);
        }
    }

    public function createDebitForRawMateriasSale($accountId , $amount, $date, $description = null,$invoice){
        $dealer = Dealer::where('id' , $accountId)->first();
        if($dealer){
            $individualAccount = IndividualAccount::where('title', $dealer->d_s_name)->first();
            if($individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'debit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id(),
                    'ref_id' => Cache::get('sale-raw-naterial')
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::forget('sale-raw-naterial');
                ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
            }
        }
    }

    public function createCreditForCogsOfRawMaterialSale($accountName , $amount, $date, $description = null,$invoice){

        $accountInfo = IndividualAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->acSubSubAccount?->id,
                'ac_individual_account_id' => $accountInfo->id,
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('sale-raw-naterial-cogs', $result->id);
        }
    }

    public function createDeditForCogsOfRawMaterialSale($accountName , $amount, $date, $description = null,$invoice){

        $accountInfo = SubSubAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
                'ref_id' => Cache::get('sale-raw-naterial-cogs')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('sale-raw-naterial-cogs');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }

    //Sales Return
    public function createCreditForFinishedGoodsSaleReturn($accountId , $amount, $date, $description = null, $invoice){
        $dealer = Dealer::where('id' , $accountId)->first();
        if($dealer){
            $individualAccount = IndividualAccount::where('title', $dealer->d_s_name)->first();
            if($individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'credit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id(),
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::put('sale-finished-goods-return', $result->id);
            }
        }
    }

    public function createDebitForFinishedGoodsSaleReturn($accountName , $amount, $date, $description = null, $invoice){
        $accountInfo = SubSubAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
                'ref_id' => Cache::get('sale-finished-goods-return')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('sale-finished-goods-return');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }

    public function createCreditForCogsOfFinishedGoodsSaleReturn($accountName , $amount, $date, $description = null,$invoice){

        $accountInfo = SubSubAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('sale-finished-goods-cogs-return', $result->id);
        }
    }

    public function createDeditForCogsOfFinishedGoodsSaleReturn($accountName , $amount, $date, $description = null,$invoice){
        $accountInfo = IndividualAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->acSubSubAccount?->id,
                'ac_individual_account_id' => $accountInfo->id,
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
                'ref_id' => Cache::get('sale-finished-goods-cogs-return')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('sale-finished-goods-cogs-return');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }

    //Purchase Production
    public function createCreditForRawMaterials($accountName , $amount, $date, $description = null, $invoice){
        $accountInfo = IndividualAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->acSubSubAccount?->id,
                'ac_individual_account_id' => $accountInfo->id,
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id()
            ];

            $result = $this->storeChartOfAccount($data);
            Cache::put('convert-raw-to-finshed', $result->id);
        }
    }

    public function createDebitForFinishedGoods($accountName , $amount, $date, $description = null, $invoice){
        $accountInfo = IndividualAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->acSubSubAccount?->id,
                'ac_individual_account_id' => $accountInfo->id,
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
                'ref_id' => Cache::get('convert-raw-to-finshed')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('convert-raw-to-finshed');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }

    //Bank and Cash Receive
    public function createCreditForBankReceive( $accountName ,  $amount ,$payment_date , $description = null,$invoice){
        $individualAccountForCredit = IndividualAccount::where('title',$accountName)->first();
        if($individualAccountForCredit){
        $data = [
            'date' => $payment_date,
            'ac_main_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
            'ac_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->id,
            'ac_sub_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->id,
            'ac_individual_account_id' => $individualAccountForCredit?->id,
            'invoice' => $invoice,
            'credit' => $amount,
            'comment' => $description,
            'created_by' => Auth::id()
        ];
        $result = $this->storeChartOfAccount($data);
        Cache::put('receive-from-bank', $result->id);
        }

    }

    public function createDebitForBankReceive( $accountName ,  $amount ,$payment_date , $description = null,$invoice){
        $individualAccountForCredit = IndividualAccount::where('title',$accountName)->first();
        if($individualAccountForCredit){
        $data = [
            'date' => $payment_date,
            'ac_main_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
            'ac_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->id,
            'ac_sub_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->id,
            'ac_individual_account_id' => $individualAccountForCredit?->id,
            'invoice' => $invoice,
            'debit' => $amount,
            'comment' => $description,
            'created_by' => Auth::id(),
            'ref_id' => Cache::get('receive-from-bank')
        ];
        $result = $this->storeChartOfAccount($data);
        Cache::forget('receive-from-bank');
        ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }

    }

    public function createCreditForCashReceive( $accountName ,  $amount ,$payment_date , $description = null,$invoice){
        $individualAccountForCredit = IndividualAccount::where('title',$accountName)->first();
        if($individualAccountForCredit){
        $data = [
            'date' => $payment_date,
            'ac_main_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
            'ac_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->id,
            'ac_sub_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->id,
            'ac_individual_account_id' => $individualAccountForCredit?->id,
            'invoice' => $invoice,
            'credit' => $amount,
            'comment' => $description,
            'created_by' => Auth::id()
        ];
        $result = $this->storeChartOfAccount($data);
        Cache::put('receive-from-cash', $result->id);
        }

    }

    public function createDebitForCashReceive( $accountName ,  $amount ,$payment_date , $description = null,$invoice){
        $individualAccountForCredit = IndividualAccount::where('title',$accountName)->first();
        if($individualAccountForCredit){
        $data = [
            'date' => $payment_date,
            'ac_main_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
            'ac_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->id,
            'ac_sub_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->id,
            'ac_individual_account_id' => $individualAccountForCredit?->id,
            'invoice' => $invoice,
            'debit' => $amount,
            'comment' => $description,
            'created_by' => Auth::id(),
            'ref_id' => Cache::get('receive-from-cash')
        ];
        $result = $this->storeChartOfAccount($data);
        Cache::forget('receive-from-cash');
        ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }

    }

      //asset depreciation
    public function createCreditForDepreciation($accountName , $amount, $date, $description, $invoice){
        $accountInfo = SubSubAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                //'date' => Carbon::now(),
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => null
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('asset-deprecation', $result->id);
        }
    }

    public function createDebitForDepreciation($accountName , $amount, $date, $description, $invoice){
        $accountInfo = SubSubAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => null,
                'ref_id' => Cache::get('asset-deprecation')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('asset-deprecation');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }


    //Journal
    public function creditJournalForDelaer($accountId , $amount , $date , $description = null, $invoice){
        $dealer = Dealer::where('id' , $accountId)->first();
        if($dealer){
            $individualAccount = IndividualAccount::where('title', $dealer->d_s_name)->first();
            if($individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'credit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id(),
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::put('journal-dealer', $result->id);

            }
        }
    }

    public function debitJournalForDelaer($accountName , $amount , $date , $description = null, $invoice){
        $accountInfo = SubSubAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => null,
                'ref_id' => Cache::get('journal-dealer')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('journal-dealer');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }

    public function debitJournalForSupplier($accountId , $amount , $date , $description = null, $invoice){
        $supplier = Supplier::where('id', $accountId)->first();
        if( $supplier){
            $individualAccount = IndividualAccount::where('title',  $supplier->supplier_name)->first();
            if($individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'debit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id(),
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::put('journal-supplier', $result->id);

            }
        }
    }

    public function creditJournalForSupplier($accountName , $amount , $date , $description = null, $invoice){
        $accountInfo = SubSubAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => null,
                'ref_id' => Cache::get('journal-supplier')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('journal-supplier');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }
    public function creditJournalForSupplierEntry($accountId , $amount , $date , $description = null, $invoice){
        $supplier = Supplier::where('id', $accountId)->first();
        if( $supplier){
            $individualAccount = IndividualAccount::where('title',  $supplier->supplier_name)->first();
            if($individualAccount){
                $data = [
                    'date' => $date,
                    'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                    'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                    'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                    'ac_individual_account_id' => $individualAccount?->id,
                    'invoice' => $invoice,
                    'credit' => $amount,
                    'comment' => $description,
                    'created_by' => Auth::id(),
                ];
                $result = $this->storeChartOfAccount($data);
                Cache::put('journal-supplier', $result->id);

            }
        }
    }

    public function debitJournalForSupplierEntry($accountName , $amount , $date , $description = null, $invoice){
        $accountInfo = SubSubAccount::where('title' , $accountName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => null,
                'ref_id' => Cache::get('journal-supplier')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('journal-supplier');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }

    public function creditJournalForOthersStepOne($subLedgerName , $amount , $date , $description, $invoice){
        //$individualAccount = IndividualAccount::where('title',  $subLedgerName)->first();
        $accountInfo = SubSubAccount::where('title' , $subLedgerName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                /*'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                'ac_individual_account_id' => $individualAccount?->id,*/
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('journal-other-one', $result->id);

        }
    }

    public function creditJournalForAccrued($subLedgerName , $amount , $date , $description, $invoice){
        $individualAccount = IndividualAccount::where('title',  $subLedgerName)->first();

        if($individualAccount){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                'ac_individual_account_id' => $individualAccount->id,
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('journal-other-one', $result->id);

        } else {
          $accountInfo = SubSubAccount::where('title' , $subLedgerName)->first();
          if($accountInfo){
              $data = [
                  'date' => $date,
                  'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                  'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                  'ac_sub_sub_account_id' => $accountInfo->id,
                  'ac_individual_account_id' => '',
                  'invoice' => $invoice,
                  'credit' => $amount,
                  'comment' => $description,
                  'created_by' => Auth::id(),
                  'ref_id' => Cache::get('journal-supplier')
              ];
              $result = $this->storeChartOfAccount($data);
              Cache::forget('journal-supplier');
              ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
          }
        }
    }

    public function debitJournalForAccrued($ledgerName , $amount , $date , $description, $invoice){
        $individualAccount = IndividualAccount::where('title',  $ledgerName)->first();

        if($individualAccount){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                'ac_individual_account_id' => $individualAccount->id,
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('journal-other-one', $result->id);

        } else {

          $accountInfo = SubSubAccount::where('title' , $ledgerName)->first();
          if($accountInfo){
              $data = [
                  'date' => $date,
                  'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                  'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                  'ac_sub_sub_account_id' => $accountInfo->id,
                  'ac_individual_account_id' => '',
                  'invoice' => $invoice,
                  'debit' => $amount,
                  'comment' => $description,
                  'created_by' => Auth::id(),
                  'ref_id' => Cache::get('journal-supplier')
              ];
              $result = $this->storeChartOfAccount($data);
              Cache::forget('journal-supplier');
              ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
          }

        }
    }

    public function debitJournalForOthersStepOne($ledgerName , $amount , $date , $description, $invoice){
        $accountInfo = SubSubAccount::where('title' , $ledgerName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => null,
                'ref_id' => Cache::get('journal-other-one')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('journal-other-one');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);
        }
    }

    public function creditJournalForOthersStepTwo($ledgerName , $amount , $date , $description, $invoice){
        $accountInfo = SubSubAccount::where('title' , $ledgerName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'credit' => $amount,
                'comment' => $description,
                'created_by' => null,
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::put('journal-other-tow', $result->id);
        }
    }
    public function debitJournalForOthersStepTwo($subLedgerName , $amount , $date , $description, $invoice){
        //$individualAccount = IndividualAccount::where('title',  $subLedgerName)->first();
        $accountInfo = SubSubAccount::where('title' , $subLedgerName)->first();
        if($accountInfo){
            $data = [
                'date' => $date,
                /*'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                'ac_individual_account_id' => $individualAccount?->id, */
                'ac_main_account_id' => $accountInfo->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $accountInfo?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $accountInfo->id,
                'ac_individual_account_id' => '',
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
                'ref_id' => Cache::get('journal-other-two')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('journal-other-two');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);

        }
    }

     //Contra tranasfer
    public function creditBankCashTranasfer($type , $AccName , $amount , $date , $description, $invoice){
        $individualAccountForCredit = IndividualAccount::where('title',$AccName)->first();
        if($individualAccountForCredit){
        $data = [
            'date' => $date,
            'ac_main_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
            'ac_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->acSubAccount?->id,
            'ac_sub_sub_account_id' => $individualAccountForCredit?->acSubSubAccount?->id,
            'ac_individual_account_id' => $individualAccountForCredit?->id,
            'invoice' => $invoice,
            'credit' => $amount,
            'comment' => $description,
            'created_by' => Auth::id()
        ];
        $result = $this->storeChartOfAccount($data);
        Cache::put('tranasfer-from-bank-cash', $result->id);
        }
    }
    public function debitBankCashTranasfer($type , $AccName , $amount , $date , $description, $invoice){
        $individualAccount = IndividualAccount::where('title',  $AccName)->first();
        if($individualAccount){
            $data = [
                'date' => $date,
                'ac_main_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->acMainAccount?->id,
                'ac_sub_account_id' => $individualAccount?->acSubSubAccount?->acSubAccount?->id,
                'ac_sub_sub_account_id' => $individualAccount?->acSubSubAccount?->id,
                'ac_individual_account_id' => $individualAccount?->id,
                'invoice' => $invoice,
                'debit' => $amount,
                'comment' => $description,
                'created_by' => Auth::id(),
                'ref_id' => Cache::get('tranasfer-from-bank-cash')
            ];
            $result = $this->storeChartOfAccount($data);
            Cache::forget('tranasfer-from-bank-cash');
            ChartOfAccounts::where('id' , $result->ref_id)->update(['ref_id' => $result->id]);

        }
    }

    public function storeChartOfAccount($data)
    {
       $result =  ChartOfAccounts::create($data);
       return  $result;
    }
    
    public function journalEntryLedger($id,$title){
      return [
        'id' => $id,
        'title' => $title
      ];
    }
}
