<?php

namespace App\Http\Controllers\Account;


use App\Models\Payment;
use App\Models\ExpanseType;
use App\Models\ExpanseGroup;
use App\Models\Supplier;
use App\Models\Dealer;
use App\Models\MasterBank;
use App\Models\MasterCash;
use App\Models\OthersType;
use App\Models\SalesLedger;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use App\Models\AssetClint;
use App\Models\Asset;
use App\Models\AssetDetail;
use App\Models\AssetType;
use App\Models\AssetCategory;
use App\Models\AssetProduct;
use App\Models\Vehicle;
use App\Models\GeneralSupplier;
use App\Models\Payment_number;
use App\Models\PurchaseLedger;
use App\Models\GeneralPurchaseSupplierLedger;
use App\Models\ExpanseSubgroup;
use App\Models\InterCompany;
use Illuminate\Support\Facades\DB;
use App\Traits\ChartOfAccount;
use App\Models\Account\ChartOfAccounts;

use App\Http\Controllers\Controller;
use App\Models\Account\IndividualAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
   use ChartOfAccount;

    public function bankpaymentList(Request $request)
    {
        $data = Payment::select('payments.*', 'suppliers.supplier_name','inter_companies.name as company')
                ->leftjoin('suppliers', 'suppliers.id', 'payments.supplier_id')
                ->leftjoin('inter_companies', 'inter_companies.id', 'payments.sister_concern_id')
                ->where('payment_type', 'PAYMENT')->whereIN('type',['BANK','company'])
                ->where('payments.status', '1');
            $invoice = '';
            $date = '';
            if($request->invoice){
                $data =  $data->where('payments.invoice', $request->invoice)->get();
                $invoice = $request->invoice;
            } else {
                if (isset($request->date)) {
                    $date = $request->date;
                    $dates = explode(' - ', $request->date);
                    $fdate = date('Y-m-d', strtotime($dates[0]));
                    $tdate = date('Y-m-d', strtotime($dates[1]));
                    $data = $data->whereBetween('payments.payment_date',[$fdate,$tdate])
                    ->orderBy('payments.payment_date','desc')
                    ->orderBy('payments.invoice','desc')
                    ->get();

                } else {

                    $data = $data->orderBy('payments.payment_date','desc')
                    ->orderBy('payments.invoice','desc')
                    ->take(500)
                    ->get();
                }

            }

       // dd($data);

        return view('backend.payment.bankPaymentlist', compact('data','date','invoice'));
    }


    public function bankpaymentcreate(Request $request)
    {

        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
        $allSuppliers = Supplier::orderBy('supplier_name', 'asc')->get();
		    $checkBooks = DB::table('cheque_books')->select('cheque_books.cheque_book_no')->where('cheque_books.status', 1)->groupBy('cheque_books.cheque_book_no')->get();

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
        $allCompanies = InterCompany::orderBy('name', 'asc')->get();

        return view('backend.payment.bankpayment', compact('allBanks','checkBooks','bk_id', 'bk_info', 'allSuppliers', 'date','allCompanies'));
    }

  public function checkBookSerial($id){
  		$data = DB::table('cheque_books')->select('cheque_books.cheque_book_serial_no')->where('cheque_books.cheque_book_no', $id)->get();
    	return response($data);
  }

    public function storebankpayment(Request $request)
    {
    // dd($request->all());
        $usid = Auth::id();

        foreach ($request->bank_id as $key => $bankid) {
            $paymentInvoNumber = new Payment_number();
            $paymentInvoNumber->amount = $request->amount[$key];
            $paymentInvoNumber->user_id = $usid;
            $paymentInvoNumber->save();

            if($request->bank_id[$key]){
              $bankdetails = MasterBank::where('bank_id', $request->bank_id[$key])->first();
            } else {
              $bankdetails = ' ';
            }

            $supplier = Supplier::where('id', $request->dealer_id[$key])->first();

            if($request->company_id[$key]){
              $sisterConcern = InterCompany::where('id', $request->company_id[$key])->value('name');
              $bank_receieve = new Payment();
              //$bank_receieve->bank_id = $request->bank_id[$key];
              $bank_receieve->bank_name = $sisterConcern;
              $bank_receieve->sister_concern_id = $request->company_id[$key];
              $bank_receieve->supplier_id = $request->dealer_id[$key];
              $bank_receieve->amount = $request->amount[$key];
              $bank_receieve->payment_date = $request->payment_date;
              $bank_receieve->payment_type = 'PAYMENT';
              $bank_receieve->type = 'COMPANY';
              //$bank_receieve->transfer_type = 'COMPANY';
              $bank_receieve->invoice = 'Pay-'.$paymentInvoNumber->id;
              $bank_receieve->created_by =  $usid;
              $bank_receieve->payment_description = $request->payment_description;
              $bank_receieve->save();

              $this->debitForSupplier($supplier ,  $request->amount[$key] , $request->payment_description,$request->payment_date,$bank_receieve->invoice);
              $this->interCompanyCredit('Account Payable (Intercompany)' , $request->amount[$key] ,$request->payment_date, $request->payment_description,$bank_receieve->invoice);

              $ledger = new PurchaseLedger();
              $previous_ledger = PurchaseLedger::where('supplier_id', $request->dealer_id[$key])->orderBy('id', 'desc')->first();
              // dd($previous_ledger);
              $ledger->supplier_id = $request->dealer_id[$key];
              $ledger->date = $request->payment_date;
              // $ledger->warehouse_bank_name = $bank->bank_name;
              $ledger->warehouse_bank_name = $sisterConcern;
              $ledger->warehouse_bank_id = $request->company_id[$key];
              $ledger->payment_id = $bank_receieve->id;
              $ledger->narration = $request->payment_description;
              $ledger->invoice_no = 'Pay-'.$paymentInvoNumber->id;
              $ledger->debit = $request->amount[$key];
              $ledger->save();

              if ($ledger->save()) {
                $bank_receieve->ledger_status = 1;
                $bank_receieve->save();
              }

            } else {
            $bank_receieve = new Payment();
            $bank_receieve->bank_id = $request->bank_id[$key];
            $bank_receieve->bank_name = $bankdetails->bank_name;
            $bank_receieve->supplier_id = $request->dealer_id[$key];
            $bank_receieve->amount = $request->amount[$key];
            $bank_receieve->payment_date = $request->payment_date;
            $bank_receieve->payment_type = 'PAYMENT';
            $bank_receieve->type = 'BANK';
            $bank_receieve->invoice = 'Pay-'.$paymentInvoNumber->id;
            $bank_receieve->created_by =  $usid;
            // $bank_receieve->ledger_status = 1;
            $bank_receieve->payment_description = $request->payment_description;
            $bank_receieve->save();



            $ledger = new PurchaseLedger();
            $previous_ledger = PurchaseLedger::where('supplier_id', $request->dealer_id[$key])->orderBy('id', 'desc')->first();
            // dd($previous_ledger);
            $ledger->supplier_id = $request->dealer_id[$key];
            $ledger->date = $request->payment_date;
            // $ledger->warehouse_bank_name = $bank->bank_name;
            $ledger->warehouse_bank_name = $bankdetails->bank_name;
            $ledger->warehouse_bank_id = $request->bank_id[$key];
            $ledger->narration = $request->payment_description;
            $ledger->payment_id = $bank_receieve->id;

            $ledger->invoice_no = 'Pay-'.$paymentInvoNumber->id;
            $ledger->debit = $request->amount[$key];
            $ledger->save();

            if ($ledger->save()) {
              $bank_receieve->ledger_status = 1;
              $bank_receieve->save();
            }

            $this->debitForSupplier($supplier ,  $request->amount[$key] , $request->payment_description,$request->payment_date,$ledger->invoice_no);
            $this->creditForBank($bankdetails ,  $request->amount[$key] , $request->payment_description,$request->payment_date,$ledger->invoice_no);
          }
          // end
        }

        return redirect()->back()->with('success', 'Payment Created Successfull');
    }

public function bankPaymentView($id)
    {
        $data = Payment::select('payments.*', 'suppliers.supplier_name','inter_companies.name as company')
              ->leftjoin('suppliers', 'suppliers.id', 'payments.supplier_id')
              ->leftjoin('inter_companies', 'inter_companies.id', 'payments.sister_concern_id')
              ->where('payments.id', $id)->first();

	             $userName =  DB::table('users')->where('id', Auth::id())->value('name');
               return view('backend.payment.bankPaymentView', compact('data','userName'));
}

    public function deletebankpayment(Request $request)
    {
       // dd($request->all());
          $uid = Auth::id();
          Payment::where('id',$request->id)->update([
        'status' => 0,
       // 'ledger_status' => 0,
        'deleted_by'=>$uid
        ]);

      	$data = Payment::where('id',$request->id)->first();
      	ChartOfAccounts::where('invoice',$data->invoice)->delete();
     	$ledger = PurchaseLedger::where('invoice_no',$data->invoice)->first();

        if($ledger){
            $delete = PurchaseLedger::where('invoice_no',$data->invoice)->delete();

            if($delete){
                Payment::where('id',$request->id)->update([
              'ledger_status' => 0,
              ]);
             }
        }
        //$gledger = GeneralPurchaseSupplierLedger::where('invoice_no',$request->id)->delete();
        return redirect()->back()->with('success', 'Bank Payment Delete successfully.');
    }




    public function cashpaymentList(Request $request)
    {
        $data = Payment::select('payments.*', 'suppliers.supplier_name')
            ->leftjoin('suppliers', 'suppliers.id', 'payments.supplier_id')
            ->where('payment_type', 'PAYMENT')->where('type', 'CASH')
            ->where('status', '1');

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
        //dd($data);
        return view('backend.payment.cashPaymentlist', compact('data','date','invoice'));
     }


    public function cashpaymentcreate(Request $request)
    {

        $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        $allSuppliers = Supplier::orderBy('supplier_name', 'asc')->get();

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

        return view('backend.payment.cashpayment', compact('allcashs', 'bk_id', 'bk_info', 'allSuppliers', 'date'));
    }

    public function storecashpayment(Request $request)
    {
      //dd($request->all());

        $usid = Auth::id();

        foreach ($request->cash_id as $key => $cashid) {

            $paymentInvoNumber = new Payment_number();
            $paymentInvoNumber->amount = $request->amount[$key];
            $paymentInvoNumber->user_id = $usid;
            $paymentInvoNumber->save();

            $cashdetails = MasterCash::where('wirehouse_id', $request->cash_id[$key])->first();

            $cash_receieve = new Payment();
            $cash_receieve->wirehouse_id = $request->cash_id[$key];
            $cash_receieve->wirehouse_name = $cashdetails->wirehouse_name;
            $cash_receieve->supplier_id = $request->dealer_id[$key];
            $cash_receieve->amount = $request->amount[$key];
            $cash_receieve->payment_date = $request->payment_date;
            $cash_receieve->payment_type = 'PAYMENT';
            $cash_receieve->type = 'CASH';
            $cash_receieve->invoice = 'Pay-'.$paymentInvoNumber->id;
            $cash_receieve->created_by =  $usid;
            // $cash_receieve->ledger_status = 1;
            $cash_receieve->payment_description = $request->narration;
            // dd($request->payment_paymentr);

            if ($cash_receieve->save()) {

                $ledger = new PurchaseLedger();
                $previous_ledger = PurchaseLedger::where('supplier_id', $request->dealer_id[$key])->orderBy('id', 'desc')->first();
                $ledger->supplier_id = $request->dealer_id[$key];
                $ledger->date = $request->payment_date;
                $ledger->type = $request->type;
                $ledger->warehouse_bank_name = $cashdetails->wirehouse_name;
                $ledger->warehouse_bank_id = $request->cash_id[$key];
                $ledger->narration = $request->narration;
                $ledger->payment_id = $cash_receieve->id;
                $ledger->invoice_no = 'Pay-'.$paymentInvoNumber->id;
                $ledger->debit = $request->amount[$key];
                //$ledger->closing_balance = $previous_ledger->closing_balance - $request->amount; //dlr_base means closing Balance previous developer did it
                //$ledger->credit_limit = $previous_ledger->credit_limit + $request->amount; //dlr_base means closing Balance
                // dd($ledger);
                $ledger->save();


                if ($ledger->save()) {
                  $supplier = Supplier::where('id', $request->dealer_id[$key])->first();
                  if( $supplier){
                      $this->debitForSupplier($supplier ,  $request->amount[$key] , $request->narration,$request->payment_date,$ledger->invoice_no);
                  }

                  if( $cashdetails){
                      $this->creditForCash($cashdetails ,  $request->amount[$key] , $request->narration,$request->payment_date,$ledger->invoice_no);
                  }

                    $cash_receieve->ledger_status = 1;
                    $cash_receieve->save();
                }
                // $ledgers = SalesLedger::where('supplier_id', $request->payment_paymentr)->whereDate('ledger_date', '>', $ledger->ledger_date)->get();
                //    foreach ($ledgers as $led) {
                //         $ledger_update = SalesLedger::find($led->id);
                //         $ledger_update->closing_balance = $ledger_update->closing_balance - $request->amount; //dlr_base means closing Balance previous developer did it
                //         $ledger_update->credit_limit = $ledger_update->credit_limit + $request->amount;
                //         $ledger_update->save();
                //}

            }
        }


        return redirect()->back()
            ->with('success', 'Payment Created Successfull');
    }

public function cashPaymentView($id)
    {
        $data = Payment::select('payments.*', 'suppliers.supplier_name')
            ->leftjoin('suppliers', 'suppliers.id', 'payments.supplier_id')
            ->where('payments.id', $id)->first();
	    $userName =  DB::table('users')->where('id', Auth::id())->value('name');
        //dd($data);
   return view('backend.payment.cashPaymentView', compact('data','userName'));
}


    public function payment_edit($id)
    {

        $data = Payment::where('payment_type', 'PAYMENT')->where('id', $id)->first();
       //$vat_Tax = Payment::where('payment_type', 'PAYMENT')->where('id', $id)->first();

        //dd($data);
        $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
            $allSuppliers = Supplier::orderBy('supplier_name', 'asc')->get();
            $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();

        return view('backend.payment.payment_edit', compact('data','allcashs', 'allBanks', 'allSuppliers'));
    }


    public function payment_update(Request $request)
    {

        // dd($request->all());

        $usid = Auth::id();

           if ($request->bank_id != null) {

                $bankdetails = MasterBank::where('bank_id', $request->bank_id)->first();
                $bank_receieve =  Payment::find($request->id);
                $bank_receieve->bank_id = $request->bank_id;
                $bank_receieve->bank_name = $bankdetails->bank_name;
                $bank_receieve->supplier_id = $request->supplier_id;
                $bank_receieve->amount = $request->amount;
                $bank_receieve->payment_date = $request->payment_date;
                $bank_receieve->updated_by =  $usid;
                // $bank_receieve->ledger_status = 1;
                $bank_receieve->payment_description = $request->payment_description;
                // dd($request->payment_paymentr);

                if ($bank_receieve->save()) {

                    $ledger = PurchaseLedger::where('payment_id',$request->id)->first();

                    $ledger->supplier_id = $request->supplier_id;
                    $ledger->date = $request->payment_date;
                    // $ledger->warehouse_bank_name = $bank->bank_name;
                    $ledger->warehouse_bank_name = $bankdetails->bank_name;
                    $ledger->warehouse_bank_id = $request->bank_id;

                    $ledger->debit = $request->amount;
                    $ledger->save();



                }

                return redirect()->route('bank.payment.index')
                ->with('success', 'Payment Updated Successfull');
            }


            if ($request->cash_id != null) {



                $cashdetails = MasterCash::where('wirehouse_id', $request->cash_id)->first();

                $cash_receieve = Payment::find($request->id);
                $cash_receieve->wirehouse_id = $request->cash_id;
                $cash_receieve->wirehouse_name = $cashdetails->wirehouse_name;
                $cash_receieve->supplier_id = $request->supplier_id;
                $cash_receieve->amount = $request->amount;
                $cash_receieve->payment_date = $request->payment_date;
               $cash_receieve->updated_by =  $usid;
                // $cash_receieve->ledger_status = 1;
                $cash_receieve->payment_description = $request->payment_description;
                // dd($request->payment_paymentr);

                if ($cash_receieve->save()) {

                    $ledger = PurchaseLedger::where('payment_id',$request->id)->first();



                    $ledger->supplier_id = $request->supplier_id;
                    $ledger->date = $request->payment_date;
                    // $ledger->warehouse_bank_name = $bank->bank_name;
                    $ledger->warehouse_bank_name = $cashdetails->wirehouse_name;
                    $ledger->warehouse_bank_id = $request->cash_id;

                   $ledger->debit = $request->amount;
                    $ledger->save();

                }


                return redirect()->route('cash.payment.index')->with('success', 'Payment Updated Successfull');
            }


    }

    public function deletecashpayment(Request $request)
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

        $ledger = PurchaseLedger::where('payment_id',$request->id)->first();
        if($ledger){
            $delete = PurchaseLedger::where('id',$ledger->id)->delete();

            if($delete){
                Payment::where('id',$request->id)->update([
              'ledger_status' => 0,
              ]);
             }
        }


        return redirect()->back()->with('success', 'Bank or Cash Payment Delete successfully.');


    }


    public function allPaymentIndex(Request $request)
    {
        $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        $allSuppliers = Supplier::orderBy('supplier_name', 'asc')->get();
        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
        $interCompany = InterCompany::orderBy('name', 'asc')->get();
        return view('backend.payment.payment_create', compact('allcashs', 'allBanks', 'allSuppliers','interCompany'));
    }



    public function allPaymentStore(Request $request)
    {

        // dd($request->all());

        $usid = Auth::id();

        foreach ($request->amount as $key => $amount) {
            $amount = 0; $ledgerAmount = 0;

            $bankdetails = MasterBank::where('bank_id', $request->bank_id[$key])->first();
            $amount = ($request->amount[$key] + $request->vat_tax[$key]) - $request->tds[$key];

            if ($request->payment_by == "bank") {
              if($request->type == 3){
                $paymentInvoNumber = new Payment_number();
                $paymentInvoNumber->amount = $amount;
                $paymentInvoNumber->user_id = $usid;
                $paymentInvoNumber->save();

                $bank_receieve = new Payment();
                $bank_receieve->bank_id = $request->bank_id[$key];
                $bank_receieve->bank_name = $bankdetails->bank_name;
                $bank_receieve->sister_concern_id = $request->company_id[$key];
                $bank_receieve->amount = $amount;
                $bank_receieve->payment_date = $request->payment_date;
                $bank_receieve->payment_type = 'PAYMENT';
                $bank_receieve->type = 'BANK';
                $bank_receieve->transfer_type = 'COMPANY';
                $bank_receieve->invoice = 'Pay-'.$paymentInvoNumber->id;
                $bank_receieve->created_by =  $usid;
                // $bank_receieve->ledger_status = 1;
                $bank_receieve->payment_description = $request->payment_description;
                // dd($request->payment_paymentr);

                if ($bank_receieve->save()) {

                        $this->createDeditForCogsOfFinishedGoodsSale('Account Payable (Intercompany)' ,  $amount ,$request->payment_date, $request->payment_description,$bank_receieve->invoice);

                    if( $bankdetails){
                        $this->creditForBank($bankdetails ,  $amount , $request->payment_description,$request->payment_date,$bank_receieve->invoice);
                    }
                  }

              } else {
              $ledgerAmount = ($request->amount[$key] + $request->vat_tax[$key]) - $request->tds[$key];

                $paymentInvoNumber = new Payment_number();
                $paymentInvoNumber->amount = $amount;
                $paymentInvoNumber->user_id = $usid;
                $paymentInvoNumber->save();

                $bank_receieve = new Payment();
                $bank_receieve->bank_id = $request->bank_id[$key];
                $bank_receieve->bank_name = $bankdetails->bank_name;
                $bank_receieve->supplier_id = $request->supplier_id[$key];
                $bank_receieve->amount = $amount;
                $bank_receieve->payment_date = $request->payment_date;
                $bank_receieve->payment_type = 'PAYMENT';
                $bank_receieve->type = 'BANK';
                $bank_receieve->invoice = 'Pay-'.$paymentInvoNumber->id;
                $bank_receieve->created_by =  $usid;
                // $bank_receieve->ledger_status = 1;
                $bank_receieve->payment_description = $request->payment_description;
                // dd($request->payment_paymentr);

                if ($bank_receieve->save()) {
                    $supplier = Supplier::where('id', $request->supplier_id[$key])->first();
                    if( $supplier){
                        $this->debitForSupplier($supplier ,  $amount , $request->payment_description,$request->payment_date,$bank_receieve->invoice);
                    }

                    if( $bankdetails){
                        $this->creditForBank($bankdetails ,  $amount , $request->payment_description,$request->payment_date,$bank_receieve->invoice);
                    }

                  //Bank Vat-Tax Charge
              		if($request->vat_tax[$key] > 0){
                    $bank_charge = new Payment();
    				        $bank_charge->bank_id = $request->bank_id[$key];
                    $bank_charge->bank_name = $bankdetails->bank_name;
                    $bank_charge->supplier_id = $request->supplier_id[$key];
                	  $bank_charge->amount = $request->vat_tax[$key];
                	  $bank_charge->payment_date = $request->payment_date;
                	  $bank_charge->payment_type = 'EXPANSE';
                	  $bank_charge->type = 'BANK';
                	  $bank_charge->invoice = 'Pay-'.$paymentInvoNumber->id;
                  	$bank_charge->payment_description = $request->payment_description;
                    $bank_charge->status = 1;
                    $bank_charge->created_by = $usid;
                    $bank_charge->expanse_head = 'Vat or Tax Charge';
                    $bank_charge->expanse_status = 1;
                    $bank_charge->expanse_type_id = 21;
                    $bank_charge->expanse_subgroup_id = 151;
                    $bank_charge->expanse_qntty = 1;
                    $bank_charge->expanse_rate = $request->vat_tax[$key];
                    $bank_charge->save();
                    }

              		if($request->tds[$key] > 0){
                    $bank_charge = new Payment();
    				        $bank_charge->bank_id = $request->bank_id[$key];
                    $bank_charge->bank_name = $bankdetails->bank_name;
                    $bank_charge->supplier_id = $request->supplier_id[$key];
                	  $bank_charge->amount = $request->tds[$key];
                	  $bank_charge->payment_date = $request->payment_date;
                	  $bank_charge->payment_type = 'EXPANSE';
                	  $bank_charge->type = 'BANK';
                	  $bank_charge->invoice = 'Pay-'.$paymentInvoNumber->id;
                  	$bank_charge->payment_description = $request->payment_description;
                    $bank_charge->status = 1;
                    $bank_charge->created_by = $usid;
                    $bank_charge->expanse_head = 'TDS Payable';
                    $bank_charge->expanse_status = 1;
                    $bank_charge->expanse_type_id = 5;
                    $bank_charge->expanse_subgroup_id = 152;
                    $bank_charge->expanse_qntty = 1;
                    $bank_charge->expanse_rate = $request->tds[$key];
                    $bank_charge->save();
                    }

                    $ledger = new PurchaseLedger();
                    $previous_ledger = PurchaseLedger::where('supplier_id', $request->supplier_id[$key])->orderBy('id', 'desc')->first();
                    // dd($previous_ledger);

                    $ledger->supplier_id = $request->supplier_id[$key];
                    $ledger->date = $request->payment_date;
                    $ledger->type = $request->type;
                    $ledger->warehouse_bank_name = $bankdetails->bank_name;
                    $ledger->warehouse_bank_id = $request->bank_id[$key];
                    $ledger->payment_id = $bank_receieve->id;
                    $ledger->narration = $request->payment_description;

                    $ledger->invoice_no = 'Pay-'.$paymentInvoNumber->id;
                    $ledger->debit = $ledgerAmount;
                    $ledger->save();


                    if ($ledger->save()) {
                        $bank_receieve->ledger_status = 1;
                        $bank_receieve->save();
                    }
                }
            }
            }

            if ($request->payment_by == "cash") {
                $cashdetails = MasterCash::where('wirehouse_id', $request->cash_id[$key])->first();
                $amount = ($request->amount[$key] + $request->vat_tax[$key]) - $request->tds[$key];
                if($request->type == 3){
                  $paymentInvoNumber = new Payment_number();
                  $paymentInvoNumber->amount = $request->amount[$key];
                  $paymentInvoNumber->user_id = $usid;
                  $paymentInvoNumber->save();

                  $cash_receieve = new Payment();
                  $cash_receieve->wirehouse_id = $request->cash_id[$key];
                  $cash_receieve->wirehouse_name = $cashdetails->wirehouse_name;
                  $cash_receieve->sister_concern_id =  $request->company_id[$key];
                  $cash_receieve->amount = $amount;
                  $cash_receieve->payment_date = $request->payment_date;
                  $cash_receieve->payment_type = 'PAYMENT';
                  $cash_receieve->type = 'CASH';
                  $cash_receieve->transfer_type = 'COMPANY';
                  $cash_receieve->invoice = 'Pay-'.$paymentInvoNumber->id;
                  $cash_receieve->created_by =  $usid;
                  // $cash_receieve->ledger_status = 1;
                  $cash_receieve->payment_description = $request->payment_description;
                  // dd($request->payment_paymentr);

                  if ($cash_receieve->save()) {

                          $this->createDeditForCogsOfFinishedGoodsSale('Account Payable (Intercompany)' ,  $amount ,$request->payment_date, $request->payment_description,$cash_receieve->invoice);

                      if( $cashdetails){
                          $this->creditForCash($cashdetails,  $amount, $request->payment_description,$request->payment_date,$cash_receieve->invoice);
                      }
                    }

                } else {
                $paymentInvoNumber = new Payment_number();
                $paymentInvoNumber->amount = $request->amount[$key];
                $paymentInvoNumber->user_id = $usid;
                $paymentInvoNumber->save();


                $ledgerAmount =($request->amount[$key] + $request->vat_tax[$key]) - $request->tds[$key];



                $cash_receieve = new Payment();
                $cash_receieve->wirehouse_id = $request->cash_id[$key];
                $cash_receieve->wirehouse_name = $cashdetails->wirehouse_name;
                $cash_receieve->supplier_id = $request->supplier_id[$key];
                $cash_receieve->amount = $amount;
                $cash_receieve->payment_date = $request->payment_date;
                $cash_receieve->payment_type = 'PAYMENT';
                $cash_receieve->type = 'CASH';
                $cash_receieve->invoice = 'Pay-'.$paymentInvoNumber->id;
                $cash_receieve->created_by =  $usid;
                // $cash_receieve->ledger_status = 1;
                $cash_receieve->payment_description = $request->payment_description;
                // dd($request->payment_paymentr);

                if ($cash_receieve->save()) {
                    $supplier = Supplier::where('id', $request->supplier_id[$key])->first();
                    if( $supplier){
                        $this->debitForSupplier($supplier,  $amount, $request->payment_description,$request->payment_date,$cash_receieve->invoice);
                    }

                    if( $cashdetails){
                        $this->creditForCash($cashdetails,  $amount, $request->payment_description,$request->payment_date,$cash_receieve->invoice);
                    }


					//Cash Vat-Tax charge
                if($request->vat_tax[$key] > 0){
                $bank_charge = new Payment();
				        $bank_charge->wirehouse_id = $request->cash_id[$key];
                $bank_charge->wirehouse_name = $cashdetails->wirehouse_name;
                $bank_charge->supplier_id = $request->supplier_id[$key];
              	$bank_charge->amount = $request->vat_tax[$key];
              	$bank_charge->payment_date = $request->payment_date;
              	$bank_charge->payment_type = 'EXPANSE';
              	$bank_charge->type = 'CASH';
              	$bank_charge->invoice = 'Pay-'.$paymentInvoNumber->id;
              	$bank_charge->payment_description = $request->payment_description;
                $bank_charge->status = 1;
                $bank_charge->created_by = $usid;
                $bank_charge->expanse_head = 'Vat or Tax Charge';
                $bank_charge->expanse_status = 1;
                $bank_charge->expanse_type_id = 16;
                $bank_charge->expanse_subgroup_id = 30;
                $bank_charge->expanse_qntty = 1;
                $bank_charge->expanse_rate = $request->vat_tax[$key];
                $bank_charge->save();
                  }

                  if($request->tds[$key] > 0){
                    $bank_charge = new Payment();
    				        $bank_charge->bank_id = $request->bank_id[$key];
                    $bank_charge->bank_name = $bankdetails->bank_name;
                    $bank_charge->supplier_id = $request->supplier_id[$key];
                	  $bank_charge->amount = $request->tds[$key];
                	  $bank_charge->payment_date = $request->payment_date;
                	  $bank_charge->payment_type = 'EXPANSE';
                	  $bank_charge->type = 'BANK';
                	  $bank_charge->invoice = 'Pay-'.$paymentInvoNumber->id;
                  	$bank_charge->payment_description = $request->payment_description;
                    $bank_charge->status = 1;
                    $bank_charge->created_by = $usid;
                    $bank_charge->expanse_head = 'TDS Payable';
                    $bank_charge->expanse_status = 1;
                    $bank_charge->expanse_type_id = 5;
                    $bank_charge->expanse_subgroup_id = 152;
                    $bank_charge->expanse_qntty = 1;
                    $bank_charge->expanse_rate = $request->tds[$key];
                    $bank_charge->save();
                    }

                    $ledger = new PurchaseLedger();
                    $previous_ledger = PurchaseLedger::where('supplier_id', $request->supplier_id[$key])->orderBy('id', 'desc')->first();

                    $ledger->supplier_id = $request->supplier_id[$key];
                    $ledger->date = $request->payment_date;
                    $ledger->type = $request->type;
                    $ledger->warehouse_bank_name = $cashdetails->wirehouse_name;
                    $ledger->warehouse_bank_id = $request->cash_id[$key];
                    $ledger->payment_id = $cash_receieve->id;
                    $ledger->invoice_no = 'Pay-'.$paymentInvoNumber->id;
                    $ledger->debit = $ledgerAmount;
                    $ledger->narration = $request->payment_description;
                    //$ledger->closing_balance = $previous_ledger->closing_balance - $request->amount; //dlr_base means closing Balance previous developer did it
                    //$ledger->credit_limit = $previous_ledger->credit_limit + $request->amount; //dlr_base means closing Balance
                    // dd($ledger);
                    $ledger->save();


                    if ($ledger->save()) {
                        $cash_receieve->ledger_status = 1;
                        $cash_receieve->save();
                    }
                    // $ledgers = SalesLedger::where('supplier_id', $request->payment_paymentr)->whereDate('ledger_date', '>', $ledger->ledger_date)->get();
                    //    foreach ($ledgers as $led) {
                    //         $ledger_update = SalesLedger::find($led->id);
                    //         $ledger_update->closing_balance = $ledger_update->closing_balance - $request->amount; //dlr_base means closing Balance previous developer did it
                    //         $ledger_update->credit_limit = $ledger_update->credit_limit + $request->amount;
                    //         $ledger_update->save();
                    //}

                }
            }
          }
        }
        return redirect()->back()->with('success', 'Payment Created Successfull');
    }


   public function ohtersPaymentIndex(Request $request)
    {
        $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        $allSuppliers = Supplier::orderBy('supplier_name', 'asc')->get();
        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();

        $assetclint = AssetClint::all();

     $leases =  DB::table('leases')->get();
     $borrows =  DB::table('borrows')->get();



        $loanBanks = MasterBank::whereNotNull('loan_amount')->orderBy('bank_name', 'asc')->get();

        return view('backend.payment.others_payment_create', compact('allcashs', 'allBanks', 'allSuppliers','loanBanks','assetclint','leases','borrows'));
    }



    public function ohtersPaymentStore(Request $request)
    {

         //dd($request->all());

        $usid = Auth::id();
      $loan_id = '';
          if($request->payment_for == "loan"){

             $laonbank = MasterBank::where('bank_id', $request->loan_bank_id)->first();
             $laonbank->loan_amount = $laonbank->loan_amount-$request->total_amount;
             $laonbank->save();

          $loan_id =   DB::table('loan_details')->insertGetId([
            	'date'=>$request->payment_date,
            	'loan_bank_id'=>$request->loan_bank_id,
            	'total_loan'=>$laonbank->loan_amount+$request->total_amount,
            	'running_loan'=>$laonbank->loan_amount+$request->total_amount,
            	'payment_amount'=>$request->total_amount,
            	'loan_balance'=>$laonbank->loan_amount

            ]);

          }
      $borrow_lease_id = '';
      if($request->payment_for == "borrow"){

       $borrow= DB::table('borrows')->where('id', $request->borrow_id)->first();

          $borrow_lease_id =   DB::table('others_payment_details')->insertGetId([
            	'date'=>$request->payment_date,
            	'type'=>$request->type,
            	'borrow_id'=>$request->borrow_id,
            	'total_amount'=>$borrow->amount,
            	'amount'=>$request->total_amount,
            	'type'=>"borrow",
            	'balance'=>$borrow->amount-$request->total_amount,

            ]);

        DB::table('borrows')->where('id', $request->borrow_id)->update([
         	'amount'=>$borrow->amount-$request->total_amount,
         ]);

          }
      if($request->payment_for == "lease"){



         $lease = DB::table('leases')->where('id', $request->lease_id)->first();

          $borrow_lease_id =   DB::table('others_payment_details')->insertGetId([
            	'date'=>$request->payment_date,
            	'type'=>$request->type,
            	'lease_id'=>$request->lease_id,
            	'total_amount'=>$lease->amount,
            	'amount'=>$request->total_amount,
            'type'=>"lease",
            	'balance'=>$lease->amount-$request->total_amount,

            ]);

        DB::table('leases')->where('id', $request->lease_id)->update([
         	'amount'=>$lease->amount-$request->total_amount,
         ]);

          }





        foreach ($request->amount as $key => $amount) {

                $paymentInvoNumber = new Payment_number();
                $paymentInvoNumber->amount = $request->amount[$key];
                $paymentInvoNumber->user_id = $usid;
                $paymentInvoNumber->save();
                $bank_receieve = new Payment();
                $bank_receieve->amount = $request->amount[$key];
                $bank_receieve->payment_date = $request->payment_date;
                $bank_receieve->payment_type = 'PAYMENT';

           if ($request->payment_by == "bank") {
               $bankdetails = MasterBank::where('bank_id', $request->bank_id[$key])->first();

              $bank_receieve->bank_id = $request->bank_id[$key];
                $bank_receieve->bank_name = $bankdetails->bank_name;
                $bank_receieve->type = 'BANK';
           }
           if ($request->payment_by == "cash") {
              $cashdetails = MasterCash::where('wirehouse_id', $request->cash_id[$key])->first();
                $bank_receieve->wirehouse_id = $request->cash_id[$key];
                $bank_receieve->wirehouse_name = $cashdetails->wirehouse_name;
            	$bank_receieve->type = 'CASH';
           }
                $bank_receieve->invoice = 'Pay-'.$paymentInvoNumber->id;
                $bank_receieve->created_by =  $usid;
                // $bank_receieve->ledger_status = 1;
                $bank_receieve->payment_description = $request->inputhead;
                // dd($request->payment_paymentr);

           $bank_receieve->others_payment_type = $request->payment_for;
           $bank_receieve->loan_id = $loan_id;
           $bank_receieve->other_client_id = $request->clint_id;
           $bank_receieve->borrow_lease_id = $borrow_lease_id;
               $bank_receieve->save();

        }


        return redirect()->back()
            ->with('success', 'Others Payment Created Successfull');
    }





    public function expansePaymentIndex(Request $request)
    {
        $data = Payment::where('payment_type', 'EXPANSE')
        ->where('status', '1');

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
                ->groupBy('invoice')
                ->orderBy('payment_date','desc')
                ->orderBy('invoice','desc')
                ->get();
            }else{

                $data = $data->groupBy('invoice')->orderBy('payment_date','desc')
                ->orderBy('invoice','desc')
                ->take(500)
                ->get();
            }

        }

      return view('backend.payment.expansePaymentlist', compact('data','date','invoice'));
       // return view('backend.payment.expansePaymentlist_copy', compact('data','date','invoice'));
    }

  public function expanseChatOfAccount(){
  	$data = ExpanseGroup::orderBy('group_name','ASC')->get();
    //dd($data);
   return view('backend.payment.expanseChartOfAccoutList', compact('data'));
  }

    public function expansepaymentcreate(Request $request)
    {

        $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
        $allSuppliers = Supplier::orderBy('supplier_name', 'asc')->get();
      	$allDealers = Dealer::orderBy('d_s_name', 'asc')->get();
        $company = InterCompany::orderBy('name','ASC')->get();
        $date = date('Y-m-d');
        $subgroups = ExpanseSubgroup::all();
        $subSubGroups = DB::table('expanse_sub_subgroups')->get();
        $expansesubgroups = ExpanseGroup::all();
        return view('backend.payment.expanseform', compact('allcashs', 'allBanks', 'date','allDealers','allSuppliers','subSubGroups','subgroups','expansesubgroups','company'));
    }


    public function expanseJournalCreate(){

       /* $expenseDatas = Payment::select('invoice','e.group_name','e.subgroup_name')->leftjoin('expanse_subgroups as e','e.id','=','payments.expanse_subgroup_id')->where('payment_type','EXPANSE')
                    ->where('expanse_status',1)->orderby('payment_date','desc')->orderby('invoice','desc')->get();*/

                     $expenseDatas = Payment::select('invoice','e.expanse_type_id','e.expanse_subgroup_id','e.expanse_subSubgroup_id')->where('payment_type','EXPANSE')
                    ->where('expanse_status',1)->orderby('payment_date','desc')->orderby('invoice','desc')->get();
        return  $expenseDatas;

    }

    public function storeexpansepayment(Request $request)
    {
       //dd($request->all());
        $usid = Auth::id();

        if ($request->bank_id != null) {
            $bankname = MasterBank::where('bank_id', $request->bank_id)->value('bank_name');
            $cashdetails = '';
            $type = 'BANK';
        } else {
            $cashdetails = MasterCash::where('wirehouse_id', $request->wirehouse_id)->value('wirehouse_name');
            $bankname = '';
            $type = 'CASH';
        }

        $paymentInvoNumber = new Payment_number();
        $paymentInvoNumber->user_id = $usid;
        $paymentInvoNumber->save();

// 		dd($type);
    if(!empty($request->dealer_id)){
        foreach ($request->expanse_subgroup_id as $key => $item) {



			$expanse_id = DB::table('expanse_subgroups')->where('id',$request->expanse_subgroup_id[$key])->value('group_id');

          if($request->expanse_subSubgroup_id[$key]){
          	$expenseData = DB::table('expanse_sub_subgroups')->select('group_id','subgroup_id')->where('id',$request->expanse_subSubgroup_id[$key])->first();
            }
            $cash_receieve = new Payment();
            $cash_receieve->bank_id = $request->bank_id;
            $cash_receieve->wirehouse_id = $request->wirehouse_id;
            $cash_receieve->expanse_status = 1;
            //$cash_receieve->expanse_head = $request->expanse_head[$key];
            $cash_receieve->expanse_rate = $request->expanse_rate[$key];
            //$cash_receieve->expanse_qntty = $request->expanse_qntty[$key];
                if($request->expanse_subgroup_id[$key]){
                  	$cash_receieve->expanse_type_id = $expanse_id;
                    $cash_receieve->expanse_subgroup_id = $request->expanse_subgroup_id[$key];
                  	$cash_receieve->expanse_subSubgroup_id = '';
                } else {
                    //$cash_receieve->expanse_type_id = $expenseData->group_id;
                    //$cash_receieve->expanse_subgroup_id = $expenseData->subgroup_id;
                    $cash_receieve->expanse_subSubgroup_id = $request->expanse_subSubgroup_id[$key];
                }
            $cash_receieve->bank_name = $bankname;
            $cash_receieve->wirehouse_name = $cashdetails;
           // $cash_receieve->supplier_id = $request->supplier_id;
            $cash_receieve->amount = $request->expanse_rate[$key];
            $cash_receieve->payment_date = $request->date;
            $cash_receieve->payment_type = 'EXPANSE';
            $cash_receieve->type = $type;
            $cash_receieve->invoice = 'Pay-'.$paymentInvoNumber->id;

            $cash_receieve->created_by =  $usid;

            $cash_receieve->payment_description = $request->payment_description[$key];

            $cash_receieve->save();

          $budgetminus =  DB::table('budget_ditributions')->where('expanse_subgroup_id',$request->expanse_subgroup_id[$key])->first();
           if($budgetminus){
             DB::table('budget_ditributions')->where('expanse_subgroup_id',$request->expanse_subgroup_id[$key])->update([
               'remaining_amount' => $budgetminus->remaining_amount - $request->expanse_rate[$key],

               ]);

           }

         $ledger = new SalesLedger();
                $ledger->vendor_id = $request->dealer_id;

                $ledger->invoice = 'Pay-'.$paymentInvoNumber->id;

        		if(!empty($bankname)) {
                $ledger->warehouse_bank_name = 'Paymnet (' . $bankname. ')';
                $ledger->warehouse_bank_id = $request->bank_id;
                } else {
                $ledger->warehouse_bank_name = 'Paymnet from (' . $cashdetails. ')';
                $ledger->warehouse_bank_id = $request->wirehouse_id;
                }
                $ledger->ledger_date = $request->date;
                $ledger->narration = $request->payment_description[$key];

                $ledger->priority = 1;
                $ledger->debit = $request->expanse_rate[$key];
                $ledger->save();
         }

    } elseif(!empty($request->company_id)){
            $bankName = InterCompany::where('id',$request->company_id)->value('name');
        foreach ($request->expanse_subgroup_id as $key => $item) {


             $expanse_id = DB::table('expanse_subgroups')->where('id',$request->expanse_subgroup_id[$key])->first();

          if($request->expanse_subSubgroup_id[$key]){

              $expenseData = DB::table('expanse_sub_subgroups')->select('group_id','subgroup_id')->where('id',$request->expanse_subSubgroup_id[$key])->first();
          }
          $invoice = 'Pay-'.$paymentInvoNumber->id;
          $cash_receieve = new Payment();
          $cash_receieve->sister_concern_id = $request->company_id;
        //  $cash_receieve->wirehouse_id = $request->wirehouse_id;
          $cash_receieve->expanse_status = 1;
          //$cash_receieve->expanse_head = $request->expanse_head[$key];
          $cash_receieve->expanse_rate = $request->expanse_rate[$key];
          //$cash_receieve->expanse_qntty = $request->expanse_qntty[$key];

          if($request->expanse_subgroup_id[$key]){

              $cash_receieve->expanse_type_id = $expanse_id->group_id;
              $cash_receieve->expanse_subgroup_id = $request->expanse_subgroup_id[$key];
              $cash_receieve->expanse_subSubgroup_id = $request->expanse_subSubgroup_id[$key] ?? '';
              $cash_receieve->save();

              $expanseSubgroups = DB::table('expanse_subgroups')->where('id',$request->expanse_subgroup_id[$key])->value('subgroup_name');
              if($expanseSubgroups){
                  $this->expenseSubGroupDebit($expanseSubgroups ,$request->expanse_rate[$key], $request->date , $request->payment_description[$key], $invoice);
              }

          } else {

              //$cash_receieve->expanse_type_id = $expenseData->group_id;
              //$cash_receieve->expanse_subgroup_id = $expenseData->subgroup_id;
              $cash_receieve->expanse_subSubgroup_id = $request->expanse_subSubgroup_id[$key];
             /* $expenseDataInfo = DB::table('expanse_sub_subgroups')->where('id',$request->expanse_subSubgroup_id[$key])->first();

              if( $expenseDataInfo){
                  $this->expenseSubSubGroupDebit($expenseDataInfo ,$request->expanse_rate[$key], $request->date , $request->payment_description[$key], $invoice);
              } */
          }

          $cash_receieve->bank_name = $bankName;
        //  $cash_receieve->bank_name = $expanse_id->group_name.'-'.$expanse_id->subgroup_name;
          //$cash_receieve->wirehouse_name = ;
          //$cash_receieve->supplier_id = $request->supplier_id ?? null;

          $cash_receieve->amount = $request->expanse_rate[$key];
          $cash_receieve->payment_date = $request->date;
          $cash_receieve->payment_type = 'EXPANSE';
          $cash_receieve->type = 'COMPANY';
          $cash_receieve->invoice = $invoice;

          $cash_receieve->created_by =  $usid;
          $cash_receieve->payment_description = $request->payment_description[$key] ?? null;
          $cash_receieve->save();

          $this->createCreditForFinishedGoodsSale('Account Payable (Intercompany)',$request->expanse_rate[$key],$request->date,$narration='Inter Company Payment', $invoice);
        }

    }else {
        foreach ($request->expanse_subgroup_id as $key => $item) {



			         $expanse_id = DB::table('expanse_subgroups')->where('id',$request->expanse_subgroup_id[$key])->value('group_id');

            if($request->expanse_subSubgroup_id[$key]){

                $expenseData = DB::table('expanse_sub_subgroups')->select('group_id','subgroup_id')->where('id',$request->expanse_subSubgroup_id[$key])->first();
            }
            $invoice = 'Pay-'.$paymentInvoNumber->id;
            $cash_receieve = new Payment();
            $cash_receieve->bank_id = $request->bank_id;
            $cash_receieve->wirehouse_id = $request->wirehouse_id;
            $cash_receieve->expanse_status = 1;
            //$cash_receieve->expanse_head = $request->expanse_head[$key];
            $cash_receieve->expanse_rate = $request->expanse_rate[$key];
            //$cash_receieve->expanse_qntty = $request->expanse_qntty[$key];

            if($request->expanse_subgroup_id[$key]){

                $cash_receieve->expanse_type_id = $expanse_id;
                $cash_receieve->expanse_subgroup_id = $request->expanse_subgroup_id[$key];
                $cash_receieve->expanse_subSubgroup_id = $request->expanse_subSubgroup_id[$key] ?? '';
                $cash_receieve->save();

                $expanseSubgroups = DB::table('expanse_subgroups')->where('id',$request->expanse_subgroup_id[$key])->value('subgroup_name');
                if($expanseSubgroups){
                    $this->expenseSubGroupDebit($expanseSubgroups ,$request->expanse_rate[$key], $request->date , $request->payment_description[$key], $invoice);
                }


            } else {

            }

            $cash_receieve->bank_name = $bankname;
            $cash_receieve->wirehouse_name = $cashdetails;
            $cash_receieve->supplier_id = $request->supplier_id ?? null;

            $cash_receieve->amount = $request->expanse_rate[$key];
            $cash_receieve->payment_date = $request->date;
            $cash_receieve->payment_type = 'EXPANSE';
            $cash_receieve->type = $type;
            $cash_receieve->invoice = $invoice;

            $cash_receieve->created_by =  $usid;
            $cash_receieve->payment_description = $request->payment_description[$key] ?? null;

            $cash_receieve->save();

            if ($request->bank_id != null) {
                $banknameInfo = MasterBank::where('bank_id', $request->bank_id)->value('bank_name');
                if($banknameInfo){
                    $this->expenseForSubSubBankCredit( $banknameInfo ,$request->expanse_rate[$key], $request->date , $request->payment_description[$key], $invoice);
                }

            } else {
                $cashdetailsInfo = MasterCash::where('wirehouse_id', $request->wirehouse_id)->value('wirehouse_name');
                if($cashdetailsInfo){
                    $this->expenseForSubSubCashCredit( $cashdetailsInfo ,$request->expanse_rate[$key], $request->date , $request->payment_description[$key], $invoice);
                }
            }


          $budgetminus =  DB::table('budget_ditributions')->where('expanse_subgroup_id',$request->expanse_subgroup_id[$key])->first();
           if($budgetminus){
             DB::table('budget_ditributions')->where('expanse_subgroup_id',$request->expanse_subgroup_id[$key])->update([
               'remaining_amount' => $budgetminus->remaining_amount - $request->expanse_rate[$key],

               ]);

           }
        }
    }

        return redirect()->back()->with('success', 'Expense Payment Successfull');
    }

  public function expansePaymentView($id){
    	   $data = Payment::where('payment_type', 'EXPANSE')->where('id', $id)->first();
         //dd($data);
    	   $expenseDetails = Payment::where('invoice', $data->invoice)->get();
		    $userName =  DB::table('users')->where('id', Auth::id())->value('name');
        $invoice = substr($data->invoice, 0, 3);
        if($invoice == 'Rec'){
          return view('backend.payment.expansePaymentView2', compact('data', 'userName'));
        } else {
          return view('backend.payment.expansePaymentView', compact('data', 'userName','expenseDetails'));
        }

  }
    public function expansepaymentedit($id)
    {

        $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
        $allSuppliers = Supplier::orderBy('supplier_name', 'asc')->get();
		$allDealers = Dealer::orderBy('d_s_name', 'asc')->get();
        $edata = Payment::where('id',$id)->first();

        $date = date('Y-m-d');

		$groups = ExpanseGroup::all();
        $subgroups = ExpanseSubgroup::all();
       $subSubGroups = DB::table('expanse_sub_subgroups')->get();
      //  dd($id);

        return view('backend.payment.expanseform_edit', compact('edata','allcashs', 'allBanks', 'date','allDealers','allSuppliers', 'groups','subgroups','subSubGroups'));
    }



    public function updateexpansepayment(Request $request)
    {

       // dd($request->all());

        $usid = Auth::id();

        if ($request->bank_id != null) {
            $bankname = MasterBank::where('bank_id', $request->bank_id)->value('bank_name');
            $cashdetails = '';
            $type = 'BANK';
        } else {
            $cashdetails = MasterCash::where('wirehouse_id', $request->wirehouse_id)->value('wirehouse_name');
            $bankname = '';
            $type = 'CASH';
        }
			$expanse_id = DB::table('expanse_subgroups')->where('id',$request->expanse_subgroup_id)->value('group_id');
      	if($request->expanse_subSubgroup_id){
          	$expenseData = DB::table('expanse_sub_subgroups')->select('group_id','subgroup_id')->where('id',$request->expanse_subSubgroup_id)->first();
            }

            $cash_receieve = Payment::where('id',$request->id)->first();
            $cash_receieve->bank_id = $request->bank_id;
            $cash_receieve->wirehouse_id = $request->wirehouse_id;
            $cash_receieve->expanse_status = 1;
           // $cash_receieve->expanse_head = $request->expanse_head;
      		if($request->expanse_subgroup_id){
            	$cash_receieve->expanse_type_id = $expanse_id;
				$cash_receieve->expanse_subgroup_id = $request->expanse_subgroup_id;
              	$cash_receieve->expanse_subSubgroup_id = $request->expanse_subSubgroup_id ?? '';
            } else {
                $cash_receieve->expanse_type_id = $expenseData->group_id;
				$cash_receieve->expanse_subgroup_id = $expenseData->subgroup_id;
            	$cash_receieve->expanse_subSubgroup_id = $request->expanse_subSubgroup_id;
            }

            $cash_receieve->bank_name = $bankname;
            $cash_receieve->wirehouse_name = $cashdetails;
            $cash_receieve->supplier_id = $request->supplier_id;
            $cash_receieve->amount = $request->expanse_amount;
            $cash_receieve->payment_date = $request->date;
            $cash_receieve->type = $type;
            $cash_receieve->updated_by =  $usid;
            $cash_receieve->payment_description = $request->payment_description;
            $cash_receieve->save();

            ChartOfAccounts::where('invoice',$cash_receieve->invoice)->where('debit', '>',0)->update([
                        'debit' =>  $request->expanse_amount,
                        'credit' => 0
                        ]);

            ChartOfAccounts::where('invoice',$cash_receieve->invoice)->where('credit','>',0)->update([
                        'debit' =>  0,
                        'credit' => $request->expanse_amount
                        ]);

        return redirect()->route('expanse.payment.index')
            ->with('success', 'Expense Payment update Successfull');
    }
    public function expansePaymentReturnIndex(Request $request){

      $data = Payment::where('payment_type', 'RETURN')
        ->where('status', '1');

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

      return view('backend.payment.expanseReturnIndex', compact('data','date','invoice'));
    }
  public function expansePaymentReturn($id)
    {

        $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
        $allSuppliers = Supplier::orderBy('supplier_name', 'asc')->get();

        $edata = Payment::where('id',$id)->first();

        $date = date('Y-m-d');

		$groups = ExpanseGroup::all();
        $subgroups = ExpanseSubgroup::all();
       $subSubGroups = DB::table('expanse_sub_subgroups')->get();
      //  dd($id);

        return view('backend.payment.expanseform_return', compact('edata','allcashs', 'allBanks', 'date', 'allSuppliers', 'groups','subgroups','subSubGroups'));
    }

  public function expansePaymentReturnUpdate(Request $request)
  {
 	//dd($request->all());
     $usid = Auth::id();

        if ($request->bank_id != null) {
            $bankname = MasterBank::where('bank_id', $request->bank_id)->value('bank_name');
            $cashdetails = '';
            $type = 'BANK';
        } else {
            $cashdetails = MasterCash::where('wirehouse_id', $request->wirehouse_id)->value('wirehouse_name');
            $bankname = '';
            $type = 'CASH';
        }

		//dd($type);



            $paymentInvoNumber = new Payment_number();
            $paymentInvoNumber->amount = $request->expanse_amount;
            $paymentInvoNumber->user_id = $usid;
            $paymentInvoNumber->save();

			$expanse_id = DB::table('expanse_subgroups')->where('id',$request->expanse_subgroup_id)->value('group_id');

          if($request->expanse_subSubgroup_id){
          	$expenseData = DB::table('expanse_sub_subgroups')->select('group_id','subgroup_id')->where('id',$request->expanse_subSubgroup_id)->first();
            }

            $cash_receieve = new Payment();
            $cash_receieve->bank_id = $request->bank_id;
            $cash_receieve->wirehouse_id = $request->wirehouse_id;
            $cash_receieve->expanse_status = 11;

          if($request->expanse_subgroup_id){
          	$cash_receieve->expanse_type_id = $expanse_id;
            $cash_receieve->expanse_subgroup_id = $request->expanse_subgroup_id;
          	$cash_receieve->expanse_subSubgroup_id = '';
        } else {
            $cash_receieve->expanse_type_id = $expenseData->group_id;
            $cash_receieve->expanse_subgroup_id = $expenseData->subgroup_id;
            $cash_receieve->expanse_subSubgroup_id = $request->expanse_subSubgroup_id;
            }
            $cash_receieve->bank_name = $bankname;
            $cash_receieve->wirehouse_name = $cashdetails;
            $cash_receieve->supplier_id = $request->supplier_id;
            $cash_receieve->amount = $request->expanse_amount;
            $cash_receieve->payment_date = $request->date;
            $cash_receieve->payment_type = 'RETURN';
            $cash_receieve->type = $type;
            $cash_receieve->invoice = 'Ren-'.$paymentInvoNumber->id;

            $cash_receieve->created_by =  $usid;
    		if(!empty($bankname)){
            $cash_receieve->payment_description = 'Return to '.$bankname;
            } else {
            $cash_receieve->payment_description = 'Return to '.$cashdetails;
            }
            $cash_receieve->save();

          $budgetminus =  DB::table('budget_ditributions')->where('expanse_subgroup_id',$request->expanse_subgroup_id)->first();
           if($budgetminus){
             DB::table('budget_ditributions')->where('expanse_subgroup_id',$request->expanse_subgroup_id)->update([
               'remaining_amount' => $budgetminus->remaining_amount + $request->expanse_amount,

               ]);

           }


 return redirect()->route('expanse.payment.index')->with('success', 'Expense Payment Return Successfull');
  }

   public function deleteexpansepayment(Request $request)
    {

          $uid = Auth::id();
        $pay = Payment::where('id',$request->id)->first();
          Payment::where('id',$request->id)->update([
        'status' => 0,
       // 'ledger_status' => 0,
        'deleted_by'=>$uid
        ]);
        $invoice = Payment::where('id',$request->id)->value('invoice');
        ChartOfAccounts::where('invoice',$invoice)->delete();

		SalesLedger::where('invoice',$pay->invoice)->delete();
        return redirect()->back()
                        ->with('success', 'Expense Payment Delete successfully.');

    }

  public function expansePaymentReturnDelete(Request $request)
  {
   $uid = Auth::id();
          Payment::where('id',$request->id)->update([
        'status' => 0,
       'expanse_status' => 0,
        'deleted_by'=>$uid
        ]);

        return redirect()->back()
                        ->with('success', 'Expense Payment Return Delete successfully.');
  }

    // JOURNAL ENTRY



    public function journalentryIndex(Request $request)
    {
      $data = [];
        $data['data'] = JournalEntry::select('journal_entries.*', 'suppliers.supplier_name', 'dealers.d_s_name', 'e.group_name as leg_name','e.subgroup_name as sub_leg_name')
            ->leftjoin('suppliers', 'suppliers.id', 'journal_entries.supplier_id')
            ->leftjoin('dealers', 'dealers.id', 'journal_entries.vendor_id')
            ->leftjoin('expanse_subgroups as e', 'e.id', 'journal_entries.ledger_id')
            ->orderBy('date','desc')
            ->orderBy('id','desc')
            ->take(500)
            ->get();
        //dd( $data);

      	$data['assets'] = Asset::select('assets.*','asset_types.asset_type_name','asset_categories.name as category_name')
          		->leftJoin('asset_categories', 'asset_categories.id', 'assets.asset_category_id')
      			->leftJoin('asset_types', 'asset_types.id', 'assets.asset_type')
          		->where('intangible',0)->where('investment',0)->where('assets.asset_term', 'journal')
                ->get();
      //dd($data['assets']);

      		$expenses = Payment::select('id','bank_name','wirehouse_name','amount','payment_date','payment_type','type','invoice','expanse_head','expanse_subgroup_id','created_by','created_at')->where('others_type', 'journal')
            ->where('status', '1')
            ->orderBy('payment_date','desc')
            ->orderBy('invoice','desc')
            ->get();
      //dd($data['expenses']);
        return view('backend.payment.journal_entry_list', compact('data','expenses'));
    }


    public function journalentrycreate(Request $request)
    {

        $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
        $allSuppliers = Supplier::orderBy('supplier_name', 'asc')->get();
        $allDealers = Dealer::orderBy('d_s_name', 'asc')->get();
      	$subgroups = ExpanseSubgroup::all();
        $subSubGroups = DB::table('expanse_sub_subgroups')->get();

       /* $expenseLedgers = Payment::select('payments.invoice','e.id','e.subgroup_name','e.group_name')
                        ->leftjoin('expanse_subgroups as e','payments.expanse_subgroup_id','=','e.id')
                        ->where('payments.payment_type','EXPANSE')
                        ->wherenotnull('payments.expanse_subgroup_id')->where('payments.status', 1)->get();

        $expenseSubLedgers = Payment::select('payments.invoice','e.id','e.subSubgroup_name','e.subgroup_name')
                        ->leftjoin('expanse_sub_subgroups as e','payments.expanse_subSubgroup_id','=','e.id')
                        ->where('payments.payment_type','EXPANSE')
                        ->wherenotnull('payments.expanse_subSubgroup_id')->where('payments.status', 1)->get(); */

        //$OthersTypes = OthersType::orderBy('name', 'asc')->get();


        // $otherdata = JournalEntry::where('type',"Other")->get();

        // foreach ($otherdata as $key => $value) {
        //     JournalEntry::where('type',"Vendor")
        //    ->where('subject',$value->subject)
        //    ->where('credit',$value->debit)
        //    ->where('journel_description',$value->journel_description)
        //     ->update([
        //         'debit'=> $value->debit,
        //         'others_id'=> $value->others_id,
        //     ]);
        // }

        // dd($otherdata);

        $date = date('Y-m-d');

        return view('backend.payment.journal_entry_create', compact('subgroups','subSubGroups', 'allDealers', 'allcashs', 'allBanks', 'date', 'allSuppliers'));
    }


    public function storejournalentry(Request $request)
    {
      // dd($request->all());


        $usid = Auth::id();

        foreach ($request->ledger_id as $key => $item) {
            $subLedgerName = DB::table('expanse_subgroups')->where('id',$request->sub_ledger_id[$key])->value('subgroup_name');
            $ledgerName = DB::table('expanse_subgroups')->where('id',$request->ledger_id[$key])->value('subgroup_name');

          if($request->dc_type == 5 || $request->dc_type == 6) {

            	$id= 0;
            	//$ledgerData = Payment::select('expanse_subgroup_id','expanse_subSubgroup_id')->where('invoice',$request->sub_ledger_id)->first();
          		$JournalEntry = new JournalEntry();
                $JournalEntry->ledger_id = $request->ledger_id[$key];
                $JournalEntry->sub_ledger_id = $request->sub_ledger_id[$key];
              	$JournalEntry->user_id = Auth::id();
              	//$JournalEntry->input = $request->sub_ledger_id[$key];
                $JournalEntry->debit = $request->debit[$key];
                $JournalEntry->credit = $request->credit[$key];
                $JournalEntry->subject = $request->reference ?? 'Expense Ledger Journal Entry';
                $JournalEntry->type = 'Expense';
                $JournalEntry->dc_type = $request->dc_type;
                $JournalEntry->date = $request->date;
            	$JournalEntry->journel_description = 'Expense Ledger Journal Entry';
                $JournalEntry->save();
              	$id = $JournalEntry->id+1000;
                $JournalEntry->invoice = 'Jar-'.$id;
                $JournalEntry->save();

                /* if($request->ledgerType == 'ledger_debit'){
                    if($request->journal_type == 'accured'){
                      $this->creditJournalForAccrued($subLedgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                      $this->debitJournalForAccrued($ledgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    } else {
                      $this->creditJournalForOthersStepOne($subLedgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                      $this->debitJournalForOthersStepOne($ledgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    }

                }else{
                  if($request->journal_type == 'accured'){
                    $this->creditJournalForAccrued($ledgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    $this->debitJournalForAccrued( $subLedgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                  } else {
                    $this->creditJournalForOthersStepTwo($ledgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    $this->debitJournalForOthersStepTwo($subLedgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                  }
                } */


                if($request->ledgerType == 'ledger_debit'){
                    if($request->journal_type == 'accured'){
                      if($request->exp_type_one == 'accrued'){
                        $this->creditJournalForAccrued($subLedgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                      } else {
                        $this->creditJournalForOthersStepOne($subLedgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                      }

                      if($request->exp_type_two == 'accrued'){
                        $this->debitJournalForAccrued($ledgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                      } else {
                        $this->debitJournalForOthersStepOne($ledgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                      }

                    } else {
                      if($request->exp_type_one == 'accrued'){
                        $this->creditJournalForAccrued($subLedgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                      } else {
                        $this->creditJournalForOthersStepOne($subLedgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                      }

                      if($request->exp_type_two == 'accrued'){
                        $this->debitJournalForAccrued($ledgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                      } else {
                        $this->debitJournalForOthersStepOne($ledgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                      }

                    }

                }else{
                  if($request->journal_type == 'accured'){
                    if($request->exp_type_one == 'accrued'){
                      $this->creditJournalForAccrued($ledgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    } else {
                      $this->creditJournalForOthersStepTwo($ledgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    }

                    if($request->exp_type_two == 'accrued'){
                    $this->debitJournalForAccrued( $subLedgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                  } else {
                    $this->debitJournalForOthersStepTwo($subLedgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                  }
                  } else {

                    if($request->exp_type_one == 'accrued'){
                      $this->creditJournalForAccrued($ledgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    } else {
                      $this->creditJournalForOthersStepTwo($ledgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    }

                    if($request->exp_type_two == 'accrued'){
                    $this->debitJournalForAccrued( $subLedgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    } else {
                      $this->debitJournalForOthersStepTwo($subLedgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    }
                  }
                }


                /* if($JournalEntry->save()){
                    // $expenseData = DB::table('expanse_sub_subgroups')->select('group_id','subgroup_id')->where('id',$request->sub_ledger_id[$key])->first();
                    // $cash_receieve = new Payment();
                    // $cash_receieve->expanse_type_id = @$expenseData->group_id ?? null;
                    // $cash_receieve->expanse_subgroup_id = @$expenseData->subgroup_id;
                    // $cash_receieve->expanse_subSubgroup_id = $request->sub_ledger_id[$key];
                    // $cash_receieve->amount = $request->debit[$key];
                    // $cash_receieve->payment_date = $request->date;
                    // $cash_receieve->journel_id = $JournalEntry->id;
                    // $cash_receieve->save();
                } */

          } else {

            if ($request->dealer_id[$key] != null) {
				        $id= 0;
                $JournalEntry = new JournalEntry();

                $JournalEntry->vendor_id = $request->dealer_id[$key];
                $JournalEntry->ledger_id = $request->ledger_id[$key];
                $JournalEntry->sub_ledger_id = $request->sub_ledger_id[$key];
              	$JournalEntry->user_id = Auth::id();
                $JournalEntry->debit = $request->debit[$key];
                $JournalEntry->credit = $request->credit[$key];
                $JournalEntry->subject = $request->reference;
                $JournalEntry->dc_type = $request->dc_type ?? '';
                $JournalEntry->date = $request->date;
                $JournalEntry->save();
              	$id = $JournalEntry->id+1000;
                $JournalEntry->invoice = 'Jar-'.$id;
                $JournalEntry->save();


                if ($JournalEntry->save()) {

                    $this->creditJournalForDelaer($request->dealer_id[$key] , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                  //  $this->debitJournalForDelaer($ledgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    $this->debitJournalForDelaer('Retained Earning' , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);

                    $delaer_area_id = DB::table('dealers')->where('id', $request->dealer_id[$key])->value('dlr_area_id');
                    $ledger = new SalesLedger();
                    $ledger->vendor_id = $request->dealer_id[$key];
                    $ledger->area_id = $delaer_area_id;
                    $ledger->ledger_date = $request->date;
                    $ledger->warehouse_bank_name =  "Journal Entry";
                    $ledger->invoice =  $JournalEntry->invoice;
                    $ledger->narration = $ledgerName."- $subLedgerName "."(".$request->reference.")";
                    $ledger->journal_id = $JournalEntry->id;
                    $ledger->credit = $request->credit[$key];
                    $ledger->save();
                   /*
                    $ledger1 = new SalesLedger();
                    $ledger1->vendor_id = $request->dealer_id[$key];
                    $ledger1->area_id = $delaer_area_id;
                    $ledger1->ledger_date = $request->date;
                    $ledger1->product_name = $ledgerName;
                    $ledger1->invoice =  $JournalEntry->invoice;
                    $ledger1->debit = $request->debit[$key];
                    $ledger1->ledger_id = $request->ledger_id[$key];
               		$ledger1->sub_ledger_id = $request->sub_ledger_id[$key];
                    $ledger1->save();
                    */
                }
            } elseif ($request->supplier_id[$key] != null) {
              if($request->dcoption == 1){
                $id = 0;
                      $JournalEntry = new JournalEntry();

                      $JournalEntry->supplier_id = $request->supplier_id[$key];
                      if($request->ledger_type == 'accrued'){
                      $JournalEntry->ledger_id = $request->ledger_id[$key];
                      } else {
                          $JournalEntry->sub_ledger_id = $request->ledger_id[$key];
                      }
                        $JournalEntry->user_id = Auth::id();
                    	$JournalEntry->dc_type = 6;
                      $JournalEntry->debit = $request->debit[$key];
                      $JournalEntry->credit = $request->credit[$key];
                      $JournalEntry->subject = $request->reference;
                      $JournalEntry->date = $request->date;
                      $JournalEntry->save();
                    	$id = $JournalEntry->id+1000;
                      $JournalEntry->invoice = 'Jar-'.$id;
                      $JournalEntry->save();


                      if ($JournalEntry->save()) {

                          $this->debitJournalForSupplier($request->supplier_id[$key] , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);

                          if($request->ledger_type == 'accrued'){
                              //$this->creditJournalForAccrued($ledgerName , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                              $this->creditJournalForAccrued('Retained Earning' , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                          } else {
                            //  $this->creditJournalForSupplier($ledgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                              $this->creditJournalForSupplier('Retained Earning' , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                          }


                          $ledger = new PurchaseLedger();

                          $ledger->supplier_id = $request->supplier_id[$key];
                          $ledger->date = $request->date;
                          $ledger->journal_id = $JournalEntry->id;
                          $ledger->invoice_no = $JournalEntry->invoice;
                          $ledger->warehouse_bank_name = $ledgerName."- $subLedgerName "."(".$request->reference.")";
                          $ledger->debit = $request->debit[$key];
                          $ledger->save();
                      }

              } else {
					$id = 0;
                $JournalEntry = new JournalEntry();
                $JournalEntry->supplier_id = $request->supplier_id[$key];
                //$JournalEntry->ledger_id = ;
                $JournalEntry->sub_ledger_id = $request->ledger_id[$key];
              	$JournalEntry->dc_type = 5;
              	$JournalEntry->user_id = Auth::id();
                $JournalEntry->debit = $request->debit[$key];
                $JournalEntry->credit = $request->credit[$key];
                $JournalEntry->subject = $request->reference;
                $JournalEntry->date = $request->date;
                $JournalEntry->save();
              	$id = $JournalEntry->id+1000;
                $JournalEntry->invoice = 'Jar-'.$id;
               $JournalEntry->save();


                if ($JournalEntry->save()) {

                    $this->creditJournalForSupplierEntry($request->supplier_id[$key] , $request->credit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    if($request->ledger_type == 'accrued'){
                        //$this->debitJournalForAccrued($ledgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                        $this->debitJournalForAccrued('Retained Earning' , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    } else {
                       //$this->debitJournalForSupplierEntry($ledgerName , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                       $this->debitJournalForSupplierEntry('Retained Earning' , $request->debit[$key] , $request->date , $request->reference, $JournalEntry->invoice);
                    }

                    $ledger = new PurchaseLedger();
                    $ledger->supplier_id = $request->supplier_id[$key];
                    $ledger->date = $request->date;
                    $ledger->journal_id = $JournalEntry->id;
                    $ledger->invoice_no = $JournalEntry->invoice;
                    $ledger->warehouse_bank_name = $ledgerName."- $subLedgerName "."(".$request->reference.")";
                    $ledger->credit = $request->credit[$key];
                    $ledger->balance = $request->credit[$key];
                    $ledger->save();


                }
              }
            } else {
            }
        }
        }

        return redirect()->route('journal.entry.index')->with('success', 'Journal Entry Successfull');
    }

	public function journalEntryView($id){
    $data = JournalEntry::select('journal_entries.*', 'suppliers.supplier_name', 'dealers.d_s_name', 'e.subgroup_name as leg_name','e.subSubgroup_name as sub_leg_name')
            ->leftjoin('suppliers', 'suppliers.id', 'journal_entries.supplier_id')
            ->leftjoin('dealers', 'dealers.id', 'journal_entries.vendor_id')
            ->leftjoin('expanse_sub_subgroups as e', 'e.id', 'journal_entries.sub_ledger_id')
            ->where('journal_entries.id',$id)->first();
      $userName =  DB::table('users')->where('id', Auth::id())->value('name');
      //dd($data);
       return view('backend.payment.journal_entry_view', compact('data','userName'));
    }
    public function journalentryedit($id)
    {

        $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
        $allSuppliers = Supplier::orderBy('supplier_name', 'asc')->get();
        $allDealers = Dealer::orderBy('d_s_name', 'asc')->get();
        $subgroups = ExpanseSubgroup::all();
        $subSubGroups = DB::table('expanse_sub_subgroups')->get();
        $date = date('Y-m-d');

        $jedata = JournalEntry::where('id',$id)->first();
        return view('backend.payment.journal_entry_edit', compact('jedata','subgroups','subSubGroups','allDealers', 'allcashs', 'allBanks', 'date', 'allSuppliers'));
    }


    public function updatejournalentry(Request $request)
    {
       //dd($request->all());

        $usid = Auth::id();
			$ledgerName = DB::table('expanse_sub_subgroups')->where('id',$request->sub_ledger_id)->value('subSubgroup_name');
            if ($request->dealer_id != null) {

                $JournalEntry = JournalEntry::where('id',$request->id)->first();
                $invoice = $JournalEntry->invoice;

                ChartOfAccounts::where('invoice',$invoice)->where('credit','>',0)->update([
                        'debit' => 0,
                        'credit' => $request->credit
                        ]);

               ChartOfAccounts::where('invoice',$invoice)->where('debit','>',0)->update([
                        'debit' => $request->debit,
                        'credit' => 0
                        ]);
                $JournalEntry->vendor_id = $request->dealer_id;
                $JournalEntry->ledger_id = $request->ledger_id;
                $JournalEntry->sub_ledger_id = $request->sub_ledger_id;
                $JournalEntry->debit = $request->debit;
                $JournalEntry->credit = $request->credit;
                $JournalEntry->subject = $request->reference;
                $JournalEntry->date = $request->date;

                // $JournalEntry->invoice = $paymentInvoNumber->id;
                $JournalEntry->save();


                if ($JournalEntry->save()) {

                    $ledger = SalesLedger::where('journal_id',$request->id)->first();
                  //  $ledger = new SalesLedger();
                    // $previous_ledger = SalesLedger::where('vendor_id', $request->dealer_id)->where('ledger_date', '<=', $request->date)->orderBy('ledger_date', 'desc')->orderBy('id', 'desc')->first();
                    // // dd($previous_ledger);
                    $delaer_area_id = DB::table('dealers')->where('id', $request->dealer_id)->value('dlr_area_id');

                    $dealerdata = Dealer::where('id', $request->dealer_id)->first();

                    $ledger->vendor_id = $request->dealer_id;
                    $ledger->area_id = $delaer_area_id;
                    $ledger->ledger_date = $request->date;
                    $ledger->narration = $ledgerName."(".$request->reference.")";

                    $ledger->credit = $request->credit;
                    $ledger->ledger_id = $request->ledger_id;
                	$ledger->sub_ledger_id = $request->sub_ledger_id;
                    $ledger->save();
                }
            } elseif ($request->supplier_id != null) {

                $JournalEntry = JournalEntry::where('id',$request->id)->first();
                $invoice = $JournalEntry->invoice;

                ChartOfAccounts::where('invoice',$invoice)->where('credit','>',0)->update([
                        'debit' => 0,
                        'credit' => $request->credit
                        ]);

               ChartOfAccounts::where('invoice',$invoice)->where('debit','>',0)->update([
                        'debit' => $request->debit,
                        'credit' => 0
                        ]);
                $JournalEntry->supplier_id = $request->supplier_id;
                $JournalEntry->ledger_id = $request->ledger_id;
                $JournalEntry->sub_ledger_id = $request->sub_ledger_id;
                $JournalEntry->debit = $request->debit;
                $JournalEntry->credit = $request->credit;
                $JournalEntry->subject = $request->reference;
                $JournalEntry->date = $request->date;

                // $JournalEntry->invoice = $paymentInvoNumber->id;
                $JournalEntry->save();


                if ($JournalEntry->save()) {

                    $ledger = PurchaseLedger::where('journal_id',$request->id)->first();
                    $ledger->supplier_id = $request->supplier_id;
                    $ledger->date = $request->date;
                    $ledger->ledger_id = $request->ledger_id;
                	$ledger->sub_ledger_id = $request->sub_ledger_id;

                    $ledger->debit = $request->debit;
                    $ledger->save();
                }

            } else {
            }



        return redirect()->route('journal.entry.index') ->with('success', 'Journal Entry Update Successfull');
    }

  public function deletejournalentry(Request $request)
    {

         //dd($request->all());

          //$uid = Auth::id();
          $invoice = JournalEntry::where('id',$request->id)->value('invoice');

          ChartOfAccounts::where('invoice',$invoice)->delete();

          JournalEntry::where('id',$request->id)->delete();

         $delete = PurchaseLedger::where('invoice_no',$invoice)->delete();

        SalesLedger::where('invoice',$invoice)->delete();


        return redirect()->back()
                        ->with('success', 'Journal Entry Delete successfully.');


    }

 	//Other Journal entry paymnet Shariar
  	public function OtherJournalEntryIndex(){

    }

    public function OtherJournalCreate(){
		$assettype = AssetType::all();
        $assetclint = AssetClint::all();
        $assetcat =  AssetCategory::all();
      	$assetproduct =  AssetProduct::all();
        $dealers = Dealer::orderBy('d_s_name', 'ASC')->get();
        $banks = MasterBank::orderBy('bank_name', 'ASC')->get();
        $cashes = MasterCash::orderBy('wirehouse_name', 'ASC')->get();

        $allSuppliers = Supplier::orderBy('supplier_name', 'asc')->get();
        $date = date('Y-m-d');
        $subgroups = ExpanseSubgroup::all();
        $expansesubgroups = ExpanseType::all();

      return view('backend.payment.journal.create', compact('date','assettype', 'assetclint', 'assetcat', 'assetproduct', 'dealers', 'banks','cashes','allSuppliers','subgroups','expansesubgroups'));
    }

  public function storeOtherJournalEntry(Request $request){

   if($request->journal_type == 'vendor'){
	//dd($request->all());
     $head = DB::table('asset_types')->where('id', $request->asset_type)->value('asset_type_name');
     $assetdata = new Asset();
     $assetdata->date = $request->date;
     $assetdata->asset_head = $head;
     $assetdata->asset_type = $request->asset_type;
     $assetdata->asset_category_id = $request->category_id;
     $assetdata->asset_value = $request->total_amount;
     $assetdata->payment_value = $request->payment_value_cr;
     $assetdata->remaining_value = $request->remaining_value_dr;
	 $assetdata->asset_term = 'journal';
     $assetdata->payment_mode = $request->payment_mode;
     $assetdata->wirehouse_id = $request->wirehouse_id;
     $assetdata->bank_id = $request->bank_id;
     $assetdata->description = $request->description;
     $assetdata->save();
     $assetdata->invoice = 'Ass'.$assetdata->id+10000;
     $assetdata->save();

     foreach($request->product_id as $key=> $item ){

        $assetdaetails = new AssetDetail();
        $assetdaetails->invoice = $assetdata->invoice;
        $assetdaetails->asset_id = $assetdata->id;
        $assetdaetails->category_id = $request->category_id;
        $assetdaetails->product_id = $request->product_id[$key];
        $assetdaetails->asset_value = $request->debit[$key];
        $assetdaetails->save();
      }
     $usid = Auth::id();
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
                $bank_receieve->invoice = 'Ass-'.$paymentInvoNumber->id;
                $bank_receieve->created_by =  $usid;
                $bank_receieve->payment_description = "Asset -".$request->description;
                $bank_receieve->save();
            }
     if ($request->payment_mode == "Cash") {

                $paymentInvoNumber = new Payment_number();
                $paymentInvoNumber->amount = $request->payment_value_cr;
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
                $cash_receieve->invoice = 'Ass-'.$paymentInvoNumber->id;
                $cash_receieve->created_by =  $usid;
                $cash_receieve->payment_description = "Asset -".$request->description;
                $cash_receieve->save();

                }

   } else {
   	//dd($request->all());
      $usid = Auth::id();

        if ($request->bank_id != null) {
            $bankname = MasterBank::where('bank_id', $request->bank_id)->value('bank_name');
            $cashdetails = '';
            $type = 'BANK';
        } else {
            $cashdetails = MasterCash::where('wirehouse_id', $request->wirehouse_id)->value('wirehouse_name');
            $bankname = '';
            $type = 'CASH';
        }

        foreach ($request->expanse_head as $key => $item) {

            $paymentInvoNumber = new Payment_number();
            $paymentInvoNumber->amount = $request->debit[$key];
            $paymentInvoNumber->user_id = $usid;
            $paymentInvoNumber->save();


            $cash_receieve = new Payment();
            $cash_receieve->bank_id = $request->bank_id;
            $cash_receieve->wirehouse_id = $request->wirehouse_id;
            $cash_receieve->expanse_status = 1;
            $cash_receieve->expanse_head = $request->expanse_head[$key];

            $cash_receieve->expanse_subgroup_id = $request->expanse_subgroup_id;

            $cash_receieve->bank_name = $bankname;
            $cash_receieve->wirehouse_name = $cashdetails;
            $cash_receieve->amount = $request->debit[$key];
            $cash_receieve->payment_date = $request->date;
            $cash_receieve->payment_type = 'EXPANSE';
            $cash_receieve->type = $type;
            $cash_receieve->invoice = 'PayEx-'.$paymentInvoNumber->id;
            $cash_receieve->expanse_type_id = $request->expanse_type_id;
          	$cash_receieve->others_type = 'journal';
            $cash_receieve->created_by =  $usid;
            $cash_receieve->payment_description = $request->description;
          /*
          if(!empty($request->production_head[$key]) && !empty($request->production_qty[$key])){

           $cash_receieve->production_head = $request->production_head[$key];
            $cash_receieve->production_qty = $request->production_qty[$key];
          } */

            $cash_receieve->save();

          $budgetminus =  DB::table('budget_ditributions')->where('expanse_subgroup_id',$request->expanse_subgroup_id)->first();
           if($budgetminus){
             DB::table('budget_ditributions')->where('expanse_subgroup_id',$request->expanse_subgroup_id)->update([
               'remaining_amount' => $budgetminus->remaining_amount-$request->debit[$key],

               ]);

           }
        }

   }

    return redirect()->route('journal.entry.index')->with('success', 'Other Journal Entry Successfull');

  }

  	public function deleteOtherJournalEntry(Request $request){
      //dd($request->id);
       Asset::where('id',$request->id)->delete();
       $assetdetils = AssetDetail::where('asset_id',$request->id)->delete();

       $uid = Auth::id();
       Payment::where('asset_id',$request->id)->update([
        'status' => 0,
        'deleted_by'=>$uid
        ]);

      return redirect()->back()->with('success', 'Other Journal Entry Asset Deleted Successfull');
    }


    // Amount Transfer  Reza
    public function amounttransferform()
    {
        $banks = MasterBank::all();
        $cashes = MasterCash::all();

        $getdata = Payment::select('amount','payment_date','created_at')->where('payment_type',"TRANSFER")
          ->groupby('amount','payment_date','created_at')
        ->where('status', '1')->get();

        // $getdata = Payment::select('amount','payment_date','created_at')
        // ->where('payment_type',"TRANSFER")
        // ->groupby('amount','payment_date','created_at')->take(10)
        // ->get();
         $invoice = 1000001 ;

        /* foreach ($getdata as $key => $value) {
             Payment::where('payment_type',"TRANSFER")
             ->where('payment_date',$value->payment_date)
             ->where('created_at',$value->created_at)
             ->where('amount',$value->amount)
             ->update(['transfer_invoice'=>$invoice ]);
             $invoice = $invoice +1;
         }  */

       //  dd($getdata);

        return view('backend.amountTransfer.amount_transger_create', compact('banks', 'cashes'));
    }

    public function amounttransferlist()
    {
        $listData = DB::table('payments')
            ->select('transfer_invoice', 'payment_date',DB::raw('COUNT(transfer_invoice) as count'))
            ->where('payment_type',"TRANSFER")
            ->where('status', '1')
            ->groupBy('payments.transfer_invoice')
          	->orderBy('payment_date', 'desc')
          	->take(200)
            ->get();
       //dd( $listData);
        return view('backend.amountTransfer.amount_transfer_list', compact('listData'));
    }

    public function amountTransferEntry(Request $request)
    {
       // dd($request->all());
        $bank_name1 = null;
        $bank_id1 = null;
        if ($request->type1 == "BANK") {
            $bank_name1 = MasterBank::where('bank_id', $request->bank_id1)->value('bank_name');
            $bank_id1 = $request->bank_id1;
        }

        $cash_name1 = null;
        $cash_id1 = null;
        if ($request->type1 == "CASH") {
            $cash_name1 = MasterCash::where('wirehouse_id', $request->wirehouse_id1)->value('wirehouse_name');
            $cash_id1 = $request->wirehouse_id1;
        }

        $bank_name2 = null;
        $bank_id2 = null;
        if ($request->type2 == "BANK") {
            $bank_name2 = MasterBank::where('bank_id', $request->bank_id2)->value('bank_name');
            $bank_id2 = $request->bank_id2;
        }

        $cash_name2 = null;
        $cash_id2 = null;
        if ($request->type2 == "CASH") {
            $cash_name2 = MasterCash::where('wirehouse_id', $request->wirehouse_id2)->value('wirehouse_name');
            $cash_id2 = $request->wirehouse_id2;
        }
        // dd($bank_name);

        if ($request->type1 != null) {

           /* if ($request->credit1 != null) {
                $amount1 = $request->credit1;
                $payment_type1 = "RECEIVE";
            } */
            if ($request->debit1 != null) {
                $amount1 = $request->debit1;
                $payment_type1 = "PAYMENT";
            }


            $usid = Auth::id();

            $paymentInvoNumber = new Payment_number();
            $paymentInvoNumber->amount = $amount1;
            $paymentInvoNumber->user_id = $usid;
            $paymentInvoNumber->save();

            $payment = new Payment();
            $payment->bank_id = $bank_id1;
            $payment->bank_name = $bank_name1;
            $payment->wirehouse_id = $cash_id1;
            $payment->wirehouse_name = $cash_name1;
            $payment->amount = $amount1;
            $payment->payment_date = $request->journel_date;
            $payment->payment_type = "TRANSFER";
            $payment->transfer_type = $payment_type1;
            $payment->type = $request->type1;
            $payment->invoice = 'CT-'.$paymentInvoNumber->id;
            $payment->created_by = Auth::User()->id;
            // $payment->journel_id =  $journel->id;
          	$payment->expanse_head = $request->subject;
            $payment->payment_description = $request->description . " (" . $bank_name2 . $cash_name2 . ")";
            $payment->save();

			$inId = 0;
          	$inId = 100000 + $payment->id;
            $tinvoice = $payment->transfer_invoice = 'CT-'.$inId;
            $payment->save();

            if($request->type1 == 'BANK'){
                $this->creditBankCashTranasfer('bank',$bank_name1 , $request->debit1 , $request->journel_date , $request->description, $tinvoice);
            }
            if($request->type1 == 'CASH'){
                $this->creditBankCashTranasfer('cash' , $cash_name1 , $request->debit1 , $request->journel_date , $request->description, $tinvoice);
            }
        }

        if ($request->type2 != null) {

            if ($request->credit2 != null) {
                $amount2 = $request->credit2;
                $payment_type2 = "RECEIVE";
            }

            /*if ($request->debit2 != null) {
                $amount2 = $request->debit2;
                $payment_type2 = "PAYMENT";
            } */


            $usid = Auth::id();

            $paymentInvoNumber = new Payment_number();
            $paymentInvoNumber->amount = $amount2;
            $paymentInvoNumber->user_id = $usid;
            $paymentInvoNumber->save();

            $payment = new Payment();
            $payment->bank_id = $bank_id2;
            $payment->bank_name = $bank_name2;
            $payment->wirehouse_id = $cash_id2;
            $payment->wirehouse_name = $cash_name2;
            $payment->amount = $amount2;
            $payment->payment_date = $request->journel_date;
            $payment->payment_type = "TRANSFER";
            $payment->transfer_type = $payment_type2;
            $payment->transfer_invoice = $payment_type2;
            $payment->created_by = Auth::User()->id;
            $payment->type = $request->type2;
            $payment->invoice = 'Pay-'.$paymentInvoNumber->id;
            // $payment->journel_id =  $journel->id;
           $payment->expanse_head = $request->subject;
            $payment->payment_description = $request->description . " (" . $bank_name1 . $cash_name1 . ")";
            $payment->save();

            $payment->transfer_invoice = $tinvoice;
            $payment->save();

            if($request->type2 == 'BANK'){
                $this->debitBankCashTranasfer('bank',$bank_name2 , $request->credit2 , $request->journel_date , $request->description, $tinvoice);
            }
            if($request->type2 == 'CASH'){
                $this->debitBankCashTranasfer('cash' , $cash_name2 , $request->credit2 , $request->journel_date , $request->description, $tinvoice);
            }
        }



        return back()->with('success', 'Amount Transfer Successfully!');
    }
  public function viewAmountTransfer($id){
  	$data = Payment::where('transfer_invoice', $id)->where('status', '1')->first();
    $id = Auth::id();
    $userName = DB::select('select users.name from users where users.id="' . $id . '"');
    //dd();
    return view('backend.amountTransfer.amount_transfer_view', compact('data','userName'));
  }
    public function editamounttransfer($id)
    {
        $editabledata = Payment::where('transfer_invoice', $id)->get();
        $banks = MasterBank::all();
        $cashes = MasterCash::all();

        $listData = DB::table('payments')
            ->select('transfer_invoice', 'payment_date', 'payment_description')
            ->where('transfer_invoice', $id)
            ->where('status', '1')
            ->whereNotNull('transfer_invoice')
            ->groupBy('payments.transfer_invoice')
            ->first();
       // dd($listData);
        return view('backend.amountTransfer.amount_transger_edit', compact('editabledata', 'listData', 'banks', 'cashes'));
    }
    public function ampounttransferupdate(Request $request)
    {
        // dd($request->all());
        $bank_name1 = null;
        $bank_id1 = null;
        if ($request->type1 == "BANK") {
            $bank_name1 = MasterBank::where('bank_id', $request->bank_id1)->value('bank_name');
            $bank_id1 = $request->bank_id1;
        }

        $cash_name1 = null;
        $cash_id1 = null;
        if ($request->type1 == "CASH") {
            $cash_name1 = MasterCash::where('wirehouse_id', $request->wirehouse_id1)->value('wirehouse_name');
            $cash_id1 = $request->wirehouse_id1;
        }

        $bank_name2 = null;
        $bank_id2 = null;
        if ($request->type2 == "BANK") {
            $bank_name2 = MasterBank::where('bank_id', $request->bank_id2)->value('bank_name');
            $bank_id2 = $request->bank_id2;
        }

        $cash_name2 = null;
        $cash_id2 = null;
        if ($request->type2 == "CASH") {
            $cash_name2 = MasterCash::where('wirehouse_id', $request->wirehouse_id2)->value('wirehouse_name');
            $cash_id2 = $request->wirehouse_id2;
        }
        // dd($bank_name);

        if ($request->type1 != null) {

            if ($request->credit1 != null) {
                $amount1 = $request->credit1;
                $payment_type1 = "RECEIVE";
            }
            if ($request->debit1 != null) {
                $amount1 = $request->debit1;
                $payment_type1 = "PAYMENT";
            }


            $usid = Auth::id();

            $payment =  Payment::where('id', $request->id1)->first();
            $payment->bank_id = $bank_id1;
            $payment->bank_name = $bank_name1;
            $payment->wirehouse_id = $cash_id1;
            $payment->wirehouse_name = $cash_name1;
            $payment->amount = $amount1;
            $payment->payment_date = $request->journel_date;
            $payment->payment_type = "TRANSFER";
            $payment->transfer_type = $payment_type1;
            $payment->type = $request->type1;
            $payment->updated_by = Auth::User()->id;
            $payment->payment_description = $request->description;
          	$payment->expanse_head = $request->subject;
            $payment->save();
        }

        if ($request->type2 != null) {

            if ($request->credit2 != null) {
                $amount2 = $request->credit2;
                $payment_type2 = "RECEIVE";
            }
            if ($request->debit2 != null) {
                $amount2 = $request->debit2;
                $payment_type2 = "PAYMENT";
            }


            $usid = Auth::id();

            $payment = Payment::where('id', $request->id2)->first();
            $payment->bank_id = $bank_id2;
            $payment->bank_name = $bank_name2;
            $payment->wirehouse_id = $cash_id2;
            $payment->wirehouse_name = $cash_name2;
            $payment->amount = $amount2;
            $payment->payment_date = $request->journel_date;
            $payment->payment_type = "TRANSFER";
            $payment->transfer_type = $payment_type2;
            $payment->updated_by = Auth::User()->id;
            $payment->type = $request->type2;
            $payment->payment_description = $request->description;
            $payment->expanse_head = $request->subject;
            $payment->save();
        }
        return redirect()->route('amount.transfer.list')->with('success', 'Amount Transfer Successfully!');
    }
    public function deleteamounttransfer(Request $request)
    {
      //dd($request->all());
      ChartOfAccounts::where('invoice',$request->invoice)->delete();
      Payment::where('transfer_invoice', $request->invoice)->delete();
      return redirect()->route('amount.transfer.list')->with('success', 'Amount delete Successfully!');
     }
    public function paymentReportIndex()
    {
        $banks = MasterBank::all();
        $cashes = MasterCash::all();
        return view('backend.payment.payment_report_index', compact('banks', 'cashes'));
    }


    public function paymentReportList(Request $request)
    {
        $data = Payment::select('payments.*', 'suppliers.supplier_name')
              ->leftjoin('suppliers', 'suppliers.id', 'payments.supplier_id')
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

         $data =  $data->where('payments.payment_type', 'PAYMENT')->orderby('payment_date', 'desc')->orderby('payments.id', 'desc')->get();

  // dd($data);
        return view('backend.payment.payment_report', compact('data'));
    }


   public function otherpaymentReportIndex()
    {
        $banks = MasterBank::all();
        $cashes = MasterCash::all();
        return view('backend.payment.others_payment_report_index', compact('banks', 'cashes'));
    }


    public function otherpaymentReportList(Request $request)
    {

        $data = Payment::select('payments.*', 'suppliers.supplier_name')
        ->leftjoin('suppliers', 'suppliers.id', 'payments.supplier_id')
        ->where('status', '1')
        ->whereNotNull('others_payment_type');

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

     //   if ($request->cash_id && $request->bank_id) {

      //      return redirect()->back()->with('warning', 'Please Select Banks Or Cashes');
      //  }

       if ($request->report_type != null ) {
            $purchases = $data->where('payments.others_payment_type', $request->report_type);
        }

         $data =  $data->where('payments.payment_type', 'PAYMENT')->orderby('payment_date', 'asc')->orderby('payments.id', 'asc')->get();

  // dd($data);
        return view('backend.payment.others_payment_report', compact('data'));
    }

  	public function generalpurchaseindex()
    {
      $listdata = Payment::where('payment_type','COLLECTION')->get();
      //dd($listdata);
      return view('backend.account.generalpaymentreceivedindex',compact('listdata'));
    }

  	public function generalpaymentdelete(Request $request)
    {
    	Payment::where('id',$request->id)->delete();
      	return redirect()->back()->with('success', 'General Payment Recived deleted Successfully!');
    }

	public function generalpaymentcreate()
    {
      	$banks = MasterBank::orderBy('bank_name', 'ASC')->get();
        $cashes = MasterCash::orderBy('wirehouse_name', 'ASC')->get();
      	$othertype = DB::table('others_types')->orderBy('name', 'ASC')->get();
      $vehicles = Vehicle::all();
    	return view('backend.account.generalpaymentrecived',compact('banks', 'cashes','othertype','vehicles'));
    }

  	public function generalpaymentstore(Request $request)
    {
      $usid = Auth::id();
      $cashname = '';
      $bankname = '';
      if($request->collection_mode == 'BANK'){
        	$bankname = MasterBank::where('bank_id',$request->bank_id)->value('bank_name');
      }elseif($request->collection_mode == 'CASH'){
        	$cashname = MasterCash::where('wirehouse_id',$request->wirehouse_id)->value('wirehouse_name');
      }

      //dd($request->all());

       $paymentInvoNumber = new Payment_number();
            $paymentInvoNumber->amount = $request->received_amount;
            $paymentInvoNumber->user_id = $usid;
            $paymentInvoNumber->save();





      $gpaymentstore = new Payment();
      $gpaymentstore->payment_date = $request->date;
      $gpaymentstore->payment_description = $request->general_received_head;
      $gpaymentstore->payment_type = "COLLECTION";
      $gpaymentstore->type = $request->collection_mode;
      $gpaymentstore->bank_id = $request->bank_id;
      $gpaymentstore->bank_name = $bankname;
      $gpaymentstore->wirehouse_id = $request->wirehouse_id;
      $gpaymentstore->wirehouse_name = $cashname;
      $gpaymentstore->amount = $request->received_amount;
      $gpaymentstore->invoice = 'PayGen-'.$paymentInvoNumber->id;
      $gpaymentstore->vehicle_number = $request->vehicle_number;

      $gpaymentstore->save();

      return redirect()->route('general.payment.recived.index')->with('success', 'General Payment Recived Successfully!');
    }
	public function generalpaymentedit($id)
    {
    	$editdata = Payment::where('id',$id)->first();
      	$banks = MasterBank::orderBy('bank_name', 'ASC')->get();
        $cashes = MasterCash::orderBy('wirehouse_name', 'ASC')->get();
       $vehicles = Vehicle::all();
      	return view('backend.account.generalpaymentreceivededit',compact('editdata','banks', 'cashes','vehicles'));
    }

  		public function generalpaymentrestore(Request $request)
    {
      $cashname = '';
      $bankname = '';
      if($request->collection_mode == 'BANK'){
        	$bankname = MasterBank::where('bank_id',$request->bank_id)->value('bank_name');
      }elseif($request->collection_mode == 'CASH'){
        	$cashname = MasterCash::where('wirehouse_id',$request->wirehouse_id)->value('wirehouse_name');
      }

     // dd($request->all());

      $gpaymentstore = Payment::where('id',$request->id)->first();
      $gpaymentstore->payment_date = $request->date;
      $gpaymentstore->payment_description = $request->general_received_head;
      $gpaymentstore->type = $request->collection_mode;
      $gpaymentstore->bank_id = $request->bank_id;
      $gpaymentstore->bank_name = $bankname;
      $gpaymentstore->wirehouse_id = $request->wirehouse_id;
      $gpaymentstore->wirehouse_name = $cashname;
      $gpaymentstore->amount = $request->received_amount;
      $gpaymentstore->vehicle_number = $request->vehicle_number;
      $gpaymentstore->save();
      return redirect()->route('general.payment.recived.index')->with('success', 'General Payment Edited Successfully!');

    }

  	public function generalsupplierpaymentcreate()
    {
    	$suppliers = GeneralSupplier::orderBy('supplier_name', 'ASC')->get();
         $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
        $allSuppliers = Supplier::orderBy('supplier_name', 'asc')->get();
        $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();


        return view('backend.payment.general_psupplier_payment', compact('suppliers','allcashs','allBanks'));
    }



 public function generalsupplierpaymentstore(Request $request)
    {
      $usid = Auth::id();
      $cashname = '';
      $bankname = '';
      if($request->payment_by == 'BANK'){
        	$bankname = MasterBank::where('bank_id',$request->bank_id)->value('bank_name');
      }elseif($request->payment_by == 'CASH'){
        	$cashname = MasterCash::where('wirehouse_id',$request->wirehouse_id)->value('wirehouse_name');
      }

      //dd($request->all());

       $paymentInvoNumber = new Payment_number();
            $paymentInvoNumber->amount = $request->received_amount;
            $paymentInvoNumber->user_id = $usid;
            $paymentInvoNumber->save();





      $gpaymentstore = new Payment();
      $gpaymentstore->payment_date = $request->payment_date;
      $gpaymentstore->general_supplier_id = $request->general_supplier_id;

      $gpaymentstore->payment_description = $request->payment_description;
      $gpaymentstore->payment_type = "PAYMENT";
      $gpaymentstore->type = $request->payment_by;
      $gpaymentstore->bank_id = $request->bank_id;
      $gpaymentstore->bank_name = $bankname;
      $gpaymentstore->wirehouse_id = $request->wirehouse_id;
      $gpaymentstore->wirehouse_name = $cashname;
      $gpaymentstore->amount = $request->amount;
      $gpaymentstore->invoice = 'PayGenSup'.$paymentInvoNumber->id;

      $gpaymentstore->save();


   				$generelledger = new GeneralPurchaseSupplierLedger();
              	$generelledger->supplier_id =  $request->general_supplier_id;
              	$generelledger->date =  $request->payment_date;
              	$generelledger->credit = $request->amount;
              	$generelledger->invoice_no = $paymentInvoNumber->id;
               $generelledger->warehouse_bank_id = $request->wirehouse_id != null ? $request->wirehouse_id : $request->bank_id;
                  $generelledger->warehouse_bank_name = $cashname != '' ? $cashname :$bankname;
                  $generelledger->payment_id = $gpaymentstore->id;
              	$generelledger->save();


       return redirect()->route('general.purchase.supplier.payment')->with('success', 'General Supplier Payment Created Successfully!');

    }

}
