<?php

namespace App\Http\Controllers\Account;

use DB;

use DataTables;

use App\Models\Dealer;
use App\Models\Payment;
use App\Models\Supplier;
use App\Models\MasterBank;
use App\Models\MasterCash;
use App\Models\SalesLedger;
use App\Models\InterCompany;
use Illuminate\Http\Request;

use App\Models\Account\ChartOfAccounts;
use App\Models\Payment_number;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ChartOfAccount;

class ReceiveController extends Controller
{
    use ChartOfAccount;
    public function bankReceiveList(Request $request)
    {
      // dd($request->all());
            $data = DB::table('payments')
             ->selectRaw('*,ROW_NUMBER() OVER (ORDER BY id) AS row_num')
            ->select('payments.*', 'dealers.d_s_name')
            ->leftjoin('dealers', 'dealers.id', 'payments.vendor_id')
            ->where('payment_type', 'RECEIVE')->where('type', 'BANK')
            ->where('status', '1');

            $invoice = '';
            $date = '';
            if($request->invoice){
                $data =  $data->where('invoice', $request->invoice)->paginate(10);
                $invoice = $request->invoice;
            }else{
                if (isset($request->date)) {
                    $date = $request->date;
                    $dates = explode(' - ', $request->date);
                    $fdate = date('Y-m-d', strtotime($dates[0]));
                    $tdate = date('Y-m-d', strtotime($dates[1]));

                    $data = $data->whereBetween('payment_date',[$fdate,$tdate])
                    ->orderBy('payment_date','desc')
                    ->orderBy('invoice','desc')
                    ->paginate(10);
                }else{

                    $data = $data->orderBy('payment_date','desc')
                    ->orderBy('invoice','desc')
                    ->paginate(10);
                }
            }

        // dd($data);
        return view('backend.receive.bankReceivedlist', compact('data','date','invoice'));

    }




    public function bankReceivecreate(Request $request)
    {

        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
        $allDealers = Dealer::orderBy('d_s_name', 'asc')->get();
        $allCompanies = InterCompany::orderBy('name', 'asc')->get();
        // if($request->session()->has('my_date')){
        //     $date = $request->session()->get('my_date');
        // }else
        //  {
        $date = date('Y-m-d');
        //  }
        if ($request->session()->has('bk_id')) {
            $bk_id = $request->session()->get('bk_id');

            foreach ($allBanks as $bank) {
                if ($bank->bank_id == $bk_id) {

                    $bk_info = $bank->bank_name;
                    // dd($bk_info);
                }
            }
            // $bk_info = Bank::find($bk_id)->bank_name;
        } else {
            $bk_id = '';
            $bk_info = '';
        }
        //$date = date('Y-m-d');

        return view('backend.receive.bankreceive', compact('allBanks', 'bk_id', 'bk_info', 'allDealers', 'date','allCompanies'));
    }

        public function storebankReceive(Request $request)
    {

        // dd($request->all());
        $usid = Auth::id();

        foreach ($request->bank_id as $key => $bankid) {
          $paymentInvoNumber = new Payment_number();
          $paymentInvoNumber->amount = $request->amount[$key];
          $paymentInvoNumber->user_id = $usid;
          $paymentInvoNumber->save();
          $bankdetails = MasterBank::where('bank_id', $request->bank_id[$key])->first();

          if($request->company_id[$key]){
            //$company = InterCompany::where('id',$request->company_id[$key])->first();
            $bank_receieve = new Payment();
            $bank_receieve->bank_id = $request->bank_id[$key];
            $bank_receieve->bank_name = $bankdetails->bank_name;
            $bank_receieve->sister_concern_id = $request->company_id[$key];
            $bank_receieve->amount = $request->amount[$key];
            $bank_receieve->payment_date = $request->payment_date;
            $bank_receieve->payment_type = 'RECEIVE';
            $bank_receieve->type = 'BANK';
            $bank_receieve->transfer_type = 'COMPANY';
            $bank_receieve->invoice = 'Rec-'.$paymentInvoNumber->id;
            $bank_receieve->created_by =  $usid;
            $bank_receieve->payment_description = $request->payment_description;

            if ($bank_receieve->save()) {
              $bankcharge = 0;
              //Bank Charge
             if($request->bank_charge[$key] > 0){
               $bankcharge = $request->bank_charge[$key];
               $bank_charge = new Payment();
               $bank_charge->bank_id = $request->bank_id[$key];
               $bank_charge->bank_name = $bankdetails->bank_name;
               $bank_charge->sister_concern_id = $request->company_id[$key];
               $bank_charge->amount = $request->bank_charge[$key];
               $bank_charge->payment_date = $request->payment_date;
               $bank_charge->payment_type = 'EXPANSE';
               $bank_charge->type = 'BANK';
               $bank_charge->invoice = 'Rec-'.$paymentInvoNumber->id;
               $bank_charge->payment_description = $request->payment_description;
               $bank_charge->status = 1;
               $bank_charge->created_by = $usid;
               $bank_charge->expanse_head = 'Bank Charge';
               $bank_charge->expanse_status = 2;
               $bank_charge->expanse_type_id = 6;
               $bank_charge->expanse_subgroup_id = 20;
               $bank_charge->expanse_qntty = 1;
               $bank_charge->expanse_rate = $bankcharge;
               $bank_charge->others_payment_type = 'OTHERS';
               $bank_charge->save();
             }
             $this->interCompanyCredit('Account Payable (Intercompany)' , $request->amount[$key]+$bankcharge, $request->payment_date, $request->payment_description,$bank_receieve->invoice);
             $this->createDebitForBankReceive($bankdetails->bank_name , $request->amount[$key], $request->payment_date, $request->payment_description,$bank_receieve->invoice);
             $this->createBankChargeDebit('BANK CHARGE' , $bankcharge, $request->payment_date, $request->payment_description,$bank_receieve->invoice);
           }

          } else {

            $bank_receieve = new Payment();
            $bank_receieve->bank_id = $request->bank_id[$key];
            $bank_receieve->bank_name = $bankdetails->bank_name;
            $bank_receieve->vendor_id = $request->dealer_id[$key];
            $bank_receieve->amount = $request->amount[$key];
            $bank_receieve->payment_date = $request->payment_date;
            $bank_receieve->payment_type = 'RECEIVE';
            $bank_receieve->type = 'BANK';
            $bank_receieve->invoice = 'Rec-'.$paymentInvoNumber->id;
            $bank_receieve->created_by =  $usid;
            $bank_receieve->payment_description = $request->payment_description;
            if ($bank_receieve->save()) {
              $bankcharge = 0;
              //Bank Charge
             if($request->bank_charge[$key] > 0){
               $bankcharge = $request->bank_charge[$key];
               $bank_charge = new Payment();
               $bank_charge->bank_id = $request->bank_id[$key];
               $bank_charge->bank_name = $bankdetails->bank_name;
               $bank_charge->vendor_id = $request->dealer_id[$key];
               $bank_charge->amount = $request->bank_charge[$key];
               $bank_charge->payment_date = $request->payment_date;
               $bank_charge->payment_type = 'EXPANSE';
               $bank_charge->type = 'BANK';
               $bank_charge->invoice = 'Rec-'.$paymentInvoNumber->id;
               $bank_charge->payment_description = $request->payment_description;
               $bank_charge->status = 1;
               $bank_charge->created_by = $usid;
               $bank_charge->expanse_head = 'Bank Charge';
               $bank_charge->expanse_status = 2;
               $bank_charge->expanse_type_id = 6;
               $bank_charge->expanse_subgroup_id = 20;
               $bank_charge->expanse_qntty = 1;
               $bank_charge->expanse_rate = $bankcharge;
               $bank_charge->others_payment_type = 'OTHERS';
               $bank_charge->save();
             }

                $dealer = Dealer::where('id' , $request->dealer_id[$key])->first();
                $this->createCreditForBankReceive($dealer->d_s_name , $request->amount[$key]+$bankcharge, $request->payment_date, $request->payment_description,$bank_receieve->invoice);
                $this->createDebitForBankReceive($bankdetails->bank_name , $request->amount[$key], $request->payment_date, $request->payment_description,$bank_receieve->invoice);
                $this->createBankChargeDebit('BANK CHARGE' , $bankcharge, $request->payment_date, $request->payment_description,$bank_receieve->invoice);


            }
        }

        $ledger = new SalesLedger();
        $previous_ledger = SalesLedger::where('vendor_id', $request->dealer_id[$key])->where('ledger_date', '<=', $request->payment_date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();
        // dd($previous_ledger);
        $totalAmount = 0;
        $totalAmount = $request->amount[$key] + $request->bank_charge[$key];

      //  $delaer_area_id = DB::table('dealers')->where('id', $request->dealer_id[$key])->first();

        $dealerdata = Dealer::where('id', $request->dealer_id[$key])->first();

        $ledger->vendor_id = $request->dealer_id[$key];
        $ledger->zone_id = $dealerdata->dlr_zone_id ?? '';
        $ledger->region_id = $dealerdata->dlr_subzone_id ?? '';
        $ledger->area_id = $dealerdata->dlr_area_id ?? '';
        $ledger->ledger_date = $request->payment_date;
        // $ledger->warehouse_bank_name = $bank->bank_name;
        $ledger->warehouse_bank_name = $bankdetails->bank_name;
        $ledger->warehouse_bank_id = $request->bank_id[$key];
        $ledger->payment_id = $bank_receieve->id;
        $ledger->narration = $request->payment_description;

        $ledger->invoice = 'Rec-'.$paymentInvoNumber->id;
        $ledger->is_bank = 1;
        $ledger->credit = $totalAmount;

        if ($previous_ledger) {
            $ledger->closing_balance = $previous_ledger->closing_balance - $totalAmount;
            $ledger->credit_limit = $previous_ledger->credit_limit + $totalAmount;

            $next_ledger = SalesLedger::where('vendor_id', $request->dealer_id[$key])->where('ledger_date', '>', $request->payment_date)->orderBy('ledger_date', 'asc')->orderBy('id', 'asc')->get();
            if (count($next_ledger) != 0) {
                //  dd($next_ledger);
                $amount = 0;

                foreach ($next_ledger as $value) {

                    if ($value->debit != null) {
                        $amount += $value->debit;
                    } elseif ($value->credit != null) {
                        $amount -= $value->credit;
                    } else {
                        $amount += 0;
                    }

                    //dd($amount);

                    $updateledger = SalesLedger::where('id', $value->id)->first();
                    $updateledger->closing_balance = $previous_ledger->closing_balance - $totalAmount + $amount;
                    $updateledger->credit_limit = $previous_ledger->credit_limit + $totalAmount - $amount;
                    $updateledger->save();
                }
            }
        }



        $ledger->save();


        if ($ledger->save()) {
            $bank_receieve->ledger_status = 1;
            $bank_receieve->save();
        }
        // end
      }
        return redirect()->back()->with('success', 'Received Created Successfull');
    }


	public function viewBankReceive($invoice){
     // $data = Payment::where('invoice', $invoice)->first();
    	$data = DB::table('payments')
            ->select('payments.*', 'dealers.d_s_name')
            ->leftjoin('dealers', 'dealers.id', 'payments.vendor_id')
            ->where('invoice', $invoice)->first();
      //DB::select('select users.name from users where users.id="' . $id . '"');
      //$id = Auth::id();
    $userName =  DB::table('users')->where('id', Auth::id())->value('name');

      return view('backend.receive.bankReceivedView', compact('data','invoice','userName'));
    }



    public function editbankReceive($invoice) //reza
    {
        $bankreceivedata = Payment::where('invoice', $invoice)->first();
		//dd($bankreceivedata);
        $bankCharge = Payment::where('invoice', $invoice)->where('payment_type','EXPANSE')->value('amount');
        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
        $allDealers = Dealer::orderBy('d_s_name', 'asc')->get();

        return view('backend.receive.editbankreceive', compact('bankreceivedata', 'allBanks', 'allDealers','bankCharge'));
    }


    public function updatebankReceive(Request $request)
    {
       // dd($request->all());
        $usid = Auth::id();
        $paymentInvoNumber = '';
        $bankdetails = MasterBank::where('bank_id', $request->bank_id)->first();
        $bank_receieve = Payment::where('id', $request->id)->first();
        $bank_receieve->bank_id = $request->bank_id;
        $bank_receieve->bank_name = $bankdetails->bank_name;
        $bank_receieve->vendor_id = $request->dealer_id;
        $bank_receieve->amount = $request->amount;
        $bank_receieve->payment_date = $request->payment_date;
        $bank_receieve->updated_by =  $usid;
        // $bank_receieve->ledger_status = 1;
        $bank_receieve->payment_description = $request->payment_description;
        //dd($bank_receieve);

      			$bank_charge = Payment::where('invoice', $request->invoice)->where('payment_type','EXPANSE')->first();
      			if(!empty($bank_charge))
                {
                $bank_charge->bank_id = $request->bank_id;
                $bank_charge->bank_name = $bankdetails->bank_name;
                $bank_charge->vendor_id = $request->dealer_id;
            	$bank_charge->amount = $request->bank_charge;
            	$bank_charge->payment_date = $request->payment_date;

              	$bank_charge->payment_description = $request->payment_description;
                $bank_charge->status = 2;
                $bank_charge->updated_by = $usid;
                $bank_charge->expanse_rate = $request->bank_charge;
                $bank_charge->save();

                ChartOfAccounts::where('invoice',$request->invoice)->where('ac_sub_sub_account_id',8)->update([
                        'debit' =>  $request->bank_charge,
                        'credit' => 0
                        ]);
                }

                ChartOfAccounts::where('invoice',$request->invoice)->where('ac_sub_sub_account_id',4)->update([
                        'debit' =>  $request->amount,
                        'credit' => 0
                        ]);

                ChartOfAccounts::where('invoice',$request->invoice)->where('ac_sub_sub_account_id',15)->update([
                        'debit' =>  0,
                        'credit' => ($request->amount + $request->bank_charge)
                        ]);


        if ($bank_receieve->save()) {
                $backledger = SalesLedger::where('payment_id', $request->id)->first();
                $ledger = SalesLedger::where('payment_id', $request->id)->delete();

              //  dd($backledger);
                $ledger = new SalesLedger();
                $previous_ledger = SalesLedger::where('vendor_id', $request->dealer_id)
                    ->where('ledger_date', '<=', $request->payment_date)
                //    ->where('ledger_date', '<=', $backledger->ledger_date)
                    ->orderBy('ledger_date', 'desc')
                    ->orderBy('id', 'desc')
                    ->first();
                // dd($previous_ledger);
          		$totalAmount = 0;
              	$totalAmount = $request->amount + $request->bank_charge;

                //$delaer_area_id = DB::table('dealers')->where('id', $request->dealer_id)->value('dlr_area_id');

                $dealerdata = Dealer::where('id', $request->dealer_id)->first();
                $ledger->vendor_id = $request->dealer_id;
                $ledger->zone_id = $dealerdata->dlr_zone_id ?? '';
                $ledger->region_id = $dealerdata->dlr_subzone_id ?? '';
                $ledger->area_id = $dealerdata->dlr_area_id ?? '';
                $ledger->ledger_date = $request->payment_date;
                // $ledger->warehouse_bank_name = $bank->bank_name;
                $ledger->warehouse_bank_name = $bankdetails->bank_name;
                $ledger->warehouse_bank_id = $request->bank_id;
                $ledger->payment_id = $bank_receieve->id;
        		$ledger->narration = $request->payment_description;

                $ledger->invoice =  $request->invoice;
                $ledger->is_bank = 1;
                $ledger->credit = $totalAmount;

                if ($previous_ledger) {
                    $ledger->closing_balance = $previous_ledger->closing_balance - $totalAmount;
                    $ledger->credit_limit = $previous_ledger->credit_limit + $totalAmount;

                    $next_ledger = SalesLedger::where('vendor_id', $request->dealer_id)->where('ledger_date', '>', $request->payment_date)->orderBy('ledger_date', 'asc')->orderBy('id', 'asc')->get();
                    if (count($next_ledger) != 0) {
                        //  dd($next_ledger);
                        $amount = 0;

                        foreach ($next_ledger as $value) {

                            if ($value->debit != null) {
                                $amount += $value->debit;
                            } elseif ($value->credit != null) {
                                $amount -= $value->credit;
                            } else {
                                $amount += 0;
                            }

                            //dd($amount);
                            $updateledger = SalesLedger::where('id', $value->id)->first();
                            $updateledger->closing_balance = $previous_ledger->closing_balance - $totalAmount + $amount;
                            $updateledger->credit_limit = $previous_ledger->credit_limit + $totalAmount - $amount;
                            $updateledger->save();
                        }
                    }
                }



                $ledger->save();



                if ($ledger->save()) {
                    $bank_receieve->ledger_status = 1;
                    $bank_receieve->save();
                }
        }



        return redirect()->route('bank.receive.index')->with('success', 'Bank Received Edited Successfull');
    }


      public function deletebankReceive(Request $request)
    {

         // dd($request->all());
          $uid = Auth::id();
          $invoice = Payment::where('id',$request->id)->value('invoice');
          Payment::where('invoice',$invoice)->update([
        'status' => 0,
       // 'ledger_status' => 0,
        'deleted_by'=>$uid
        ]);


        ChartOfAccounts::where('invoice',$invoice)->delete();

        $ledger = SalesLedger::where('payment_id',$request->id)->first();
        if($ledger){
            $delete = SalesLedger::where('id',$ledger->id)->delete();

            if($delete){
                Payment::where('invoice',$invoice)->update([
              'ledger_status' => 0,
              ]);
             }
        }

        return redirect()->back()->with('success', 'Bank Receive Delete successfully.');
    }



    public function cashReceiveList(Request $request)
    {

       // dd($request->all());

        $data = Payment::select('payments.*', 'dealers.d_s_name')
            ->leftjoin('dealers', 'dealers.id', 'payments.vendor_id')
            ->where('payment_type', 'RECEIVE')
            ->where('type', 'CASH')
            ->where('status', '1');

            if($request->invoice){
                $data =  $data->where('invoice', $request->invoice);
            }
            $invoice = '';
            $date = '';
            if($request->invoice){
                $data =  $data->where('invoice', $request->invoice)->get();
                $invoice = $request->invoice;
            }else{
                if (isset($request->date)) {
                    $date = $request->date;
                    $dates = explode(' - ', $request->date);
                    $fdate = date('Y-m-d', strtotime($dates[0]));
                    $tdate = date('Y-m-d', strtotime($dates[1]));

                    $data = $data->whereBetween('payment_date',[$fdate,$tdate])
                    ->orderBy('payment_date','desc')
                    ->orderBy('invoice','desc')
                    ->get();
                }else{

                    $data = $data->orderBy('payment_date','desc')
                    ->orderBy('invoice','desc')
                    ->take(500)
                    ->get();
                }

            }




        return view('backend.receive.cashReceivedlist', compact('data','date','invoice'));
    }


    public function cashReceivecreate(Request $request)
    {

        $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        $allDealers = Dealer::orderBy('d_s_name', 'asc')->get();

        // if($request->session()->has('my_date')){
        //     $date = $request->session()->get('my_date');
        // }else
        //  {
        $date = date('Y-m-d');
        //  }
        // if($request->session()->has('bk_id')){
        //     $bk_id = $request->session()->get('bk_id');

        //     foreach($allBanks as $bank){
        //       if($bank->bank_id == $bk_id ){

        //        $bk_info = $bank->bank_name;
        //       // dd($bk_info);
        //       }

        //     }
        //    // $bk_info = Bank::find($bk_id)->bank_name;
        // }else
        // {
        $bk_id = '';
        $bk_info = '';
        //}
        //$date = date('Y-m-d');

        return view('backend.receive.cashreceive', compact('allcashs', 'bk_id', 'bk_info', 'allDealers', 'date'));
    }

    public function storecashReceive(Request $request)
    {


        //dd($request->all());

        //   if($request->payment_date)
        //     {
        //         $datec = $request->payment_date;
        //         $date_put = $request->session()->put('my_date',$datec);
        //      }
        //     if($request->bank_id)
        //     {
        //         $bk_id = $request->bank_id;
        //         $bk_id_put = $request->session()->put('bk_id',$bk_id);
        //     }

        $usid = Auth::id();
		      $invoice = 0;
        foreach ($request->cash_id as $key => $cashid) {

            $paymentInvoNumber = new Payment_number();
            $paymentInvoNumber->amount = $request->amount[$key];
            $paymentInvoNumber->user_id = $usid;
            $paymentInvoNumber->save();

            $cashdetails = MasterCash::where('wirehouse_id', $request->cash_id[$key])->first();
            //dd($cashdetails);
            $cash_receieve = new Payment();
            $cash_receieve->wirehouse_id = $request->cash_id[$key];
            $cash_receieve->wirehouse_name = $cashdetails->wirehouse_name;
            $cash_receieve->vendor_id = $request->dealer_id[$key];
            $cash_receieve->amount = $request->amount[$key];
            $cash_receieve->payment_date = $request->payment_date;
            $cash_receieve->payment_type = 'RECEIVE';
            $cash_receieve->type = 'CASH';
            $cash_receieve->invoice = 'Rec-'.$paymentInvoNumber->id;
            $cash_receieve->created_by =  $usid;
            if(@$request->sales_invoice[$key] != null){
          	DB::table('sales')->where('invoice_no',$request->sales_invoice[$key])->update(['payment_status' => 1]);
            $cash_receieve->sales_invoice =  $request->sales_invoice[$key];
          }

            // $cash_receieve->ledger_status = 1;
            $cash_receieve->payment_description = $request->payment_description;
            // dd($cash_receieve);

            if ($cash_receieve->save()) {

                $dealer = Dealer::where('id' , $request->dealer_id[$key])->first();
                $this->createCreditForCashReceive($dealer->d_s_name , $request->amount[$key], $request->payment_date, $request->payment_description,$cash_receieve->invoice);
                $this->createDebitForCashReceive($cashdetails->wirehouse_name , $request->amount[$key], $request->payment_date, $request->payment_description,$cash_receieve->invoice);

				        $invoice = $cash_receieve->invoice;
                $ledger = new SalesLedger();
                $previous_ledger = SalesLedger::where('vendor_id', $request->dealer_id[$key])->where('ledger_date', '<=', $request->payment_date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();
                // dd($previous_ledger);
              //  $delaer_area_id = DB::table('dealers')->where('id', $request->dealer_id[$key])->value('dlr_area_id');

                $dealerdata = Dealer::where('id', $request->dealer_id[$key])->first();

                $ledger->vendor_id = $request->dealer_id[$key];

                $ledger->zone_id = $dealerdata->dlr_zone_id ?? '';
                $ledger->region_id = $dealerdata->dlr_subzone_id ?? '';
                $ledger->area_id = $dealerdata->dlr_area_id ?? '';
                $ledger->ledger_date = $request->payment_date;
                // $ledger->warehouse_bank_name = $bank->bank_name;
                $ledger->warehouse_bank_name = $cashdetails->wirehouse_name;
                $ledger->warehouse_bank_id = $request->cash_id[$key];
                $ledger->payment_id = $cash_receieve->id;
        		    $ledger->narration = $request->payment_description;

                $ledger->invoice = 'Rec-'.$paymentInvoNumber->id;
                $ledger->is_bank = 0;
                $ledger->credit = $request->amount[$key];

                if ($previous_ledger) {
                    $ledger->closing_balance = $previous_ledger->closing_balance - $request->amount[$key]; //dlr_base means closing Balance previous developer did it
                    $ledger->credit_limit = $previous_ledger->credit_limit + $request->amount[$key]; //dlr_base means closing Balance

                    $next_ledger = SalesLedger::where('vendor_id', $request->dealer_id[$key])->where('ledger_date', '>', $request->payment_date)->orderBy('ledger_date', 'asc')->orderBy('id', 'asc')->get();
                    if (count($next_ledger) != 0) {
                        //  dd($next_ledger);
                        $amount = 0;

                        foreach ($next_ledger as $value) {

                            if ($value->debit != null) {
                                $amount += $value->debit;
                            } elseif ($value->credit != null) {
                                $amount -= $value->credit;
                            } else {
                                $amount += 0;
                            }

                            //dd($amount);

                            $updateledger = SalesLedger::where('id', $value->id)->first();
                            $updateledger->closing_balance = $previous_ledger->closing_balance - $request->amount[$key]; + $amount;
                            $updateledger->credit_limit = $previous_ledger->credit_limit + $request->amount[$key]; - $amount;
                            $updateledger->save();
                        }
                    }
                }


                $ledger->save();

                if ($ledger->save()) {
                    $cash_receieve->ledger_status = 1;
                    $cash_receieve->save();
                }
            }
        }

  // return redirect()->route('cash.receive.view',$invoice);
        return redirect()->back()
            ->with('success', 'Received Created Successfull');
    }
    
	 public  function viewCashReceive($invoice) {
    	$data = Payment::select('payments.*', 'dealers.d_s_name')
            ->leftjoin('dealers', 'dealers.id', 'payments.vendor_id')
            ->where('invoice', $invoice)->first();
       $userName =  DB::table('users')->where('id', Auth::id())->value('name');
      return view('backend.receive.cashReceivedView', compact('data','invoice','userName'));
    }


    public function editcashReceive($invoice) // Edit Cash Received By Reza
    {
        $cashreceivedata = Payment::where('invoice', $invoice)->first();

        $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        $allDealers = Dealer::orderBy('d_s_name', 'asc')->get();
        // dd($cashreceivedata->wirehouse_id);
        return view('backend.receive.editcashreceive', compact('cashreceivedata', 'allcashs', 'allDealers'));
    }


    public function updatecashReceive(Request $request)
    {
      //  dd($request->all());
        $usid = Auth::id();

        $cashdetails = MasterCash::where('wirehouse_id', $request->cash_id)->first();
        $cash_receieve = Payment::where('id', $request->id)->first();
        $cash_receieve->wirehouse_id = $request->cash_id;
        $cash_receieve->wirehouse_name = $cashdetails->wirehouse_name;
        $cash_receieve->vendor_id = $request->dealer_id;
        $cash_receieve->amount = $request->amount;
        $cash_receieve->payment_date = $request->payment_date;
        //  $cash_receieve->payment_type = 'RECEIVE';
        // $cash_receieve->type = 'CASH';
        //$cash_receieve->invoice = $paymentInvoNumber->id;
        $cash_receieve->updated_by =  $usid;
        // $cash_receieve->ledger_status = 1;
        $cash_receieve->payment_description = $request->payment_description;
        // dd($request->payment_receiver);

        //dd($cash_receieve);

        if ($cash_receieve->save()) {

            $backledger = SalesLedger::where('payment_id', $request->id)->first();

            $ledger = SalesLedger::where('payment_id', $request->id)->delete();
            $ledger = new SalesLedger();
            $previous_ledger = SalesLedger::where('vendor_id', $request->dealer_id)
                ->where('ledger_date', '<=', $request->payment_date)
                ->orderBy('ledger_date', 'desc')
                ->orderBy('id', 'desc')
                ->first();
                // dd($previous_ledger);
            $delaer_area_id = DB::table('dealers')->where('id', $request->dealer_id)->value('dlr_area_id');

            $dealerdata = Dealer::where('id', $request->dealer_id)->first();

            $ledger->vendor_id = $request->dealer_id;
            $ledger->area_id = $delaer_area_id;
            $ledger->ledger_date = $request->payment_date;
            // $ledger->warehouse_bank_name = $bank->bank_name;
            $ledger->warehouse_bank_name = $cashdetails->wirehouse_name;
            $ledger->warehouse_bank_id = $request->cash_id;
            $ledger->payment_id = $cash_receieve->id;
        	$ledger->narration = $request->payment_description;

            $ledger->invoice = $request->invoice;
            $ledger->is_bank = 1;
            $ledger->credit = $request->amount;

            if ($previous_ledger) {
                $ledger->closing_balance = $previous_ledger->closing_balance - $request->amount; //dlr_base means closing Balance previous developer did it
                $ledger->credit_limit = $previous_ledger->credit_limit + $request->amount; //dlr_base means closing Balance

                $next_ledger = SalesLedger::where('vendor_id', $request->dealer_id)->where('ledger_date', '>', $request->payment_date)->orderBy('ledger_date', 'asc')->orderBy('id', 'asc')->get();
                if (count($next_ledger) != 0) {
                    //  dd($next_ledger);
                    $amount = 0;

                    foreach ($next_ledger as $value) {

                        if ($value->debit != null) {
                            $amount += $value->debit;
                        } elseif ($value->credit != null) {
                            $amount -= $value->credit;
                        } else {
                            $amount += 0;
                        }

                        //dd($amount);

                        $updateledger = SalesLedger::where('id', $value->id)->first();
                        $updateledger->closing_balance = $previous_ledger->closing_balance - $request->amount + $amount;
                        $updateledger->credit_limit = $previous_ledger->credit_limit + $request->amount - $amount;
                        $updateledger->save();
                    }
                }
            }


            $ledger->save();


            if ($ledger->save()) {
                $cash_receieve->ledger_status = 1;
                $cash_receieve->save();
            }
        }


        return redirect()->route('cash.receive.index')
            ->with('success', 'Cash Received Updated Successfull');
    }

    public function getinvoicenumber()
    {

        $demandnumber = Payment_number::orderBy('id', 'desc')->first();
        if ($demandnumber) {
            $invoice = 'Rec-'.$demandnumber->id + 1;
        } else {
            $invoice = 'Rec-10000001';
        }
        return response($invoice);
    }



    public function deletecashReceive(Request $request)
    {

         // dd($request->all());



          $uid = Auth::id();
          Payment::where('id',$request->id)->update([
        'status' => 0,
       // 'ledger_status' => 0,
        'deleted_by'=>$uid
        ]);

        $invoice = Payment::where('id',$request->id)->value('invoice');
        ChartOfAccounts::where('invoice',$invoice)->delete();

        $ledger = SalesLedger::where('payment_id',$request->id)->first();
        if($ledger){
            $delete = SalesLedger::where('id',$ledger->id)->delete();

            if($delete){
                Payment::where('id',$request->id)->update([
              'ledger_status' => 0,
              ]);
             }
        }

        return redirect()->back()
                        ->with('success', 'Cash Receive Delete successfully.');


    }


   public function paymentDeleteLog(Request $request)
    {
        $payment_logs = Payment::select('payments.*', 'suppliers.supplier_name', 'dealers.d_s_name')
            ->leftjoin('dealers', 'dealers.id', 'payments.vendor_id')
            ->leftjoin('suppliers', 'suppliers.id', 'payments.supplier_id')

            ->where('status', '0')
          	->orderBy('payment_date','desc')
                    ->orderBy('invoice','desc')
          			->take(500)
                    ->get();


           //dd($data);
        return view('backend.receive.delete_log', compact('payment_logs'));
    }

  public function receivedreportindex()
  {
      $banks = MasterBank::all();
      $cashes = MasterCash::all();
      return view('backend.receive.received_report_index', compact('banks', 'cashes'));
  }

  public function receivedreportview(Request $request)
  {
    $data = Payment::select('payments.*', 'dealers.d_s_name')
        ->leftjoin('dealers', 'dealers.id', 'payments.vendor_id')
        ->where('status', '1');

        if ($request->date) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));


            $purchases = $data->whereBetween('payments.payment_date', [$fdate, $tdate]);
        }

        // if ($request->supplier_id) {
        //     $purchases = $data->whereIn('payments.supplier_id', $request->supplier_id);
        // }
        if ($request->bank_id && !$request->cash_id) {
            $purchases = $data->whereIn('payments.bank_id', $request->bank_id);
        }
        if ($request->cash_id && !$request->bank_id) {
            $purchases = $data->whereIn('payments.wirehouse_id', $request->cash_id);
        }

        if ($request->cash_id && $request->bank_id) {

            return redirect()->back()->with('warning', 'Please Select Banks Or Cashes');
        }

         $data =  $data->where('payments.payment_type', 'RECEIVE')->orderby('payment_date', 'desc')->orderby('payments.id', 'desc')->get();
     return view('backend.receive.received_report',compact('data'));
  }

}
