@extends('layouts.account_dashboard')
@section('print_menu')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="contentbody">

        <!-- Main content -->
        <div class="content px-4 ">

            <div class="container"  >

              	<div class="row pt-2">
                  	<div class="col-md-12 text-right">
                         <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                           Export
                        </button>
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                           Print
                        </button>
                    </div>
                </div>

                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>

                </div>
                <div class="pt-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Bank Book From {{ date('d F Y', strtotime($fdate)) }} To
                            {{ date('d F Y', strtotime($tdate)) }}</h5>
                        <hr>
                    </div>

                    <table  class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th style=" font-weight: bold;">SI</th>
                                <th style=" font-weight: bold;">Bank Name</th>
                                <th style=" font-weight: bold;">Opening Balance</th>
                                <th style=" font-weight: bold;">Total Receive</th>
                                <th style=" font-weight: bold;">Total Payment</th>
                                <th style=" font-weight: bold;">Closing Balance</th>
                            </tr>
                        </thead>


                        <tbody>
                            @php
                                $topb = 0;
                                $trcv = 0;
                                $tpmt = 0;
                                $tclb = 0;

                          $bankdata[] = 0;
                            @endphp

                            @foreach ($allBanks as $key => $bank_list)
                                @php

                                    $bank_name = $bank_list->bank_name;

                          			$startdate = "2023-10-01";

                             /*       $oprcv = \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'RECEIVE')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');
                                    $oppay = \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'PAYMENT')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');

                                    $oppay += \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'TRANSFER')
                                        ->where('transfer_type', 'RECEIVE')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');
                                    $oprcv += \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'TRANSFER')
                                        ->where('transfer_type', 'PAYMENT')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');

                                    $oprcv += \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'OTHERS')
                                        ->where('others_type', 'RECEIVE')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');
                                    $oppay += \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'OTHERS')
                                        ->where('others_type', 'PAYMENT')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');

                            		$oppay += \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'EXPANSE')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');

                            		$oprcv += \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'COLLECTION')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');

                                    $opb = $oprcv - $oppay + $bank_list->bank_op;

                                    $totalrcv = \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'RECEIVE')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');
                                    $totalpay = \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'PAYMENT')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');

                                    $totaltrpay = \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'TRANSFER')
                                        ->where('transfer_type', 'RECEIVE')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');
                          			$totalpay +=$totaltrpay;

                                    $totaltrrcv = \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'TRANSFER')
                                        ->where('transfer_type', 'PAYMENT')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');
                                    $totalrcv += $totaltrrcv;

                                    $totalrcv += \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'OTHERS')
                                        ->where('others_type', 'RECEIVE')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');
                                    $totalpay += \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'OTHERS')
                                        ->where('others_type', 'PAYMENT')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');

                          			$totalpay += \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'EXPANSE')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');

                            		$totalrcv += \App\Models\Payment::where('bank_id', $bank_list->bank_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'COLLECTION')
                                        ->where('type', 'BANK')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');

                          */
                         // dd($startdate);
                          			$totaldata = DB::table('payments')
                          				->select('bank_id',
                             		DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND type = "BANK" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as oprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "BANK" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as oppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND type = "BANK" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "BANK" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as troprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as troppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as trtotalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as trtotalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as otoprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as otoppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "BANK" AND  expanse_status = 1 AND  payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as exoppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "BANK" AND  expanse_status = 1 AND  payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as extotalrcv'),

                         			DB::raw('sum(CASE WHEN payment_type = "COLLECTION" AND type = "BANK" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as cloppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "COLLECTION" AND type = "BANK" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as cltotalrcv'),
                          			DB::raw('sum(CASE WHEN payment_type = "RETURN" AND type = "BANK" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as returnPreVal'),
                          			DB::raw('sum(CASE WHEN payment_type = "RETURN" AND type = "BANK" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as returnVal'),
                          			)->where('status', 1)->where('bank_id', $bank_list->bank_id)->first();


                          			$loandcheck = DB::table('master_banks')->whereBetween('loan_fdate',[$fdate,$tdate])->where('bank_id', $bank_list->bank_id)->value('loan_amount');
                          			$preloandcheck = DB::table('master_banks')->whereBetween('loan_fdate',[$startdate,$predate])->where('bank_id', $bank_list->bank_id)->value('loan_amount');
									//$bankChargeAmount = DB::table('payments')->select([DB::raw("SUM(amount) expamount")])->where('payment_type','EXPANSE')->where('type','BANK')->whereBetween('payment_date',[$fdate,$tdate])->where('bank_id', $bank_list->bank_id)->first();

                          			$oprcv = $totaldata->oprcv+$totaldata->troprcv+$totaldata->otoprcv+$totaldata->cltotalrcv+$preloandcheck+$totaldata->returnPreVal;
                          			$oppay = $totaldata->oppay+$totaldata->troppay+$totaldata->otoppay+$totaldata->exoppay;

                          			$totalrcv = $totaldata->totalrcv+$totaldata->trtotalrcv+$totaldata->ottotalrcv+$totaldata->cltotalrcv+$loandcheck+$totaldata->returnVal;
                          			$totalpay = $totaldata->totalpay+$totaldata->trtotalpay+$totaldata->ottotalpay+$totaldata->extotalrcv;

                        //dd($totaldata);
                          			$opb = $bank_list->bank_op +($oprcv - $oppay);

                                    $clb = $opb + $totalrcv - $totalpay;


                          $bankdata[$bank_list->bank_id]['btrcv'] = $totalrcv;
                          $bankdata[$bank_list->bank_id]['btpay'] = $totalpay;


                                    $topb += $opb;
                                    $trcv += $totalrcv;
                                    $tpmt += $totalpay;
                                    $tclb += $clb;

                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bank_name }} @if($totaldata->trtotalrcv || $totaldata->trtotalpay) <span style="color:red"> (Transfer) </span> @endif </td>
                                    <td align="right">{{ number_format($opb, 2) }}</td>
                                    <td align="right">{{ number_format($totalrcv, 2) }}</td>
                                    <td align="right">{{ number_format($totalpay, 2) }}</td>
                                    <td align="right">{{ number_format($clb, 2) }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td></td>
                                <td style="font-weight:bold">Total</td>

                                <td style="font-weight:bold" align="right">{{ number_format($topb, 2) }}</td>
                                <td style="font-weight:bold" align="right">{{ number_format($trcv, 2) }}</td>
                                <td style="font-weight:bold" align="right">{{ number_format($tpmt, 2) }}</td>
                                <td style="font-weight:bold" align="right">{{ number_format($tclb, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

          <div class="container">
               {{--  <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>

                </div> --}}
                <div class="">
                    {{-- <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Bank Book From {{ date('d F Y', strtotime($fdate)) }} To
                            {{ date('d F Y', strtotime($tdate)) }}</h5>
                        <hr>
                    </div> --}}

                    <table id="reporttable" class="table table-bordered table-striped" style="font-size: 12px;">

                        <thead style="border: 1px solid #515151;">

                            <tr >
                             <th style=" font-weight: bold;">SI</th>
                              <th style=" font-weight: bold; width:100px;">Date</th>
                              <th style=" font-weight: bold;width:100px;">Voucher No</th>
                                 <th  style=" font-weight: bold;">Name</th>
                                 <th style=" font-weight: bold;" width="220px">Note</th>
                                 <th style=" font-weight: bold;">Receive Amount (Dr)</th>
                                 <th style=" font-weight: bold;">Payment Amount (Cr)</th>
                                 <th style=" font-weight: bold;">Balance</th>
                            </tr>
                            </thead>
                             <tbody>



                                @php
                                $grndt_rcv = 0;
                                $grndt_pym = 0;
                               	$finalBalance = 0;

                                @endphp

                                 @foreach($allBanks as $bank_list)
                                 @php

                                   $bank_name = $bank_list->bank_name;

                               		$totaldata = DB::table('payments')
                          				->select('bank_id',
                             		DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND type = "BANK" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as oprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "BANK" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as oppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND type = "BANK" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "BANK" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as troprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as troppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as trtotalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "BANK" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as trtotalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as otoprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as otoppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "BANK" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "BANK" AND expanse_status = 1 AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as exoppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "BANK" AND expanse_status = 1 AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as extotalrcv'),

                         			DB::raw('sum(CASE WHEN payment_type = "COLLECTION" AND type = "BANK" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as cloppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "COLLECTION" AND type = "BANK" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as cltotalrcv'),
									DB::raw('sum(CASE WHEN payment_type = "RETURN" AND type = "BANK" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as returnPreVal'),
                          			)->where('status', 1)->where('bank_id', $bank_list->bank_id)->first();

                          			$preloandcheck = DB::table('master_banks')->whereBetween('loan_fdate',[$startdate,$predate])->where('bank_id', $bank_list->bank_id)->value('loan_amount');

                          			$oprcv = $totaldata->oprcv+$totaldata->troprcv+$totaldata->otoprcv+$totaldata->cltotalrcv+$preloandcheck+$totaldata->returnPreVal;
                          			$oppay = $totaldata->oppay+$totaldata->troppay+$totaldata->otoppay+$totaldata->exoppay;

                          			$opb = $bank_list->bank_op + $oprcv - $oppay;

                                   $btotalrcv = $bankdata[$bank_list->bank_id]['btrcv'];
                               		$btotalpay =$bankdata[$bank_list->bank_id]['btpay'];

                                    $vendor_prcv = DB::select('SELECT payments.vendor_id,payments.invoice,dealers.d_s_name,payments.payment_description, SUM(payments.amount) as rcvamount, payments.payment_date FROM `payments`
                                    LEFT JOIN dealers ON dealers.id = payments.vendor_id
                                    WHERE payments.payment_type = "RECEIVE"
                                    AND payments.type ="BANK"
                                    AND payments.status = 1
                                    AND payments.bank_id="'.$bank_list->bank_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.vendor_id,payments.invoice,dealers.d_s_name,payments.payment_description ORDER BY payments.payment_date ASC ');

                                    $vendor_pay = DB::select('SELECT payments.invoice,payments.vendor_id,suppliers.supplier_name,inter_companies.name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`
                                     LEFT JOIN suppliers ON suppliers.id = payments.supplier_id
                                     LEFT JOIN inter_companies ON inter_companies.id = payments.sister_concern_id
                                    LEFT JOIN expanse_subgroups ON expanse_subgroups.id = payments.expanse_subgroup_id
                                    WHERE payments.payment_type = "PAYMENT"
                                    AND payments.type ="BANK"
                                    AND payments.status = 1
                                    AND payments.bank_id="'.$bank_list->bank_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.vendor_id,suppliers.supplier_name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id ORDER BY payments.payment_date ASC ');


                                    $trnsfer_rcv = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as rcvamount, payments.payment_date FROM `payments`
                                    WHERE payments.transfer_type = "RECEIVE"
                                    AND payments.payment_type ="TRANSFER"
                                    AND payments.type ="BANK"
                                    AND payments.status = 1
                                    AND payments.bank_id="'.$bank_list->bank_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC');

                                     $trnsfer_pay = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`
                                    WHERE payments.transfer_type = "PAYMENT"
                                    AND payments.payment_type ="TRANSFER"
                                    AND payments.type ="BANK"
                                    AND payments.status = 1
                                    AND payments.bank_id="'.$bank_list->bank_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC ');



                                     $others_collection_rcv = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as rcvamount, payments.payment_date FROM `payments`
                                    WHERE payments.others_type = "RECEIVE"
                                    AND payments.payment_type ="OTHERS"
                                    AND payments.type ="BANK"
                                    AND payments.status = 1
                                    AND payments.bank_id="'.$bank_list->bank_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC ');



                                     $others_collection_pmt = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`
                                    WHERE payments.others_type = "PAYMENT"
                                    AND payments.payment_type ="OTHERS"
                                    AND payments.type ="BANK"
                                    AND payments.status = 1
                                    AND payments.bank_id="'.$bank_list->bank_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC ');

                                $expnase_pmt = DB::select('SELECT payments.invoice,payments.vendor_id,suppliers.supplier_name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`
                                     LEFT JOIN suppliers ON suppliers.id = payments.supplier_id
                                    LEFT JOIN expanse_subgroups ON expanse_subgroups.id = payments.expanse_subgroup_id
                                    WHERE payments.payment_type = "EXPANSE"
                                    AND payments.type ="BANK"
                                    AND payments.status = 1
                                    AND payments.expanse_status = 1
                                    AND payments.bank_id="'.$bank_list->bank_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.vendor_id,suppliers.supplier_name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id ORDER BY payments.payment_date ASC ');


                                 $general_prcv = DB::select('SELECT payments.vendor_id,payments.invoice,dealers.d_s_name,payments.payment_description, SUM(payments.amount) as rcvamount, payments.payment_date FROM `payments`
                                    LEFT JOIN dealers ON dealers.id = payments.vendor_id
                                    WHERE payments.payment_type = "COLLECTION"
                                    AND payments.type ="BANK"
                                    AND payments.status = 1
                                    AND payments.bank_id="'.$bank_list->bank_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.vendor_id,payments.invoice,dealers.d_s_name,payments.payment_description ORDER BY payments.payment_date ASC ');

                               $returnRec = DB::select('SELECT payments.invoice,payments.supplier_id,suppliers.supplier_name,expanse_subgroups.subgroup_name,payments.payment_description, SUM(payments.amount) as recAmount, payments.payment_date FROM `payments`
                                     LEFT JOIN suppliers ON suppliers.id = payments.supplier_id
                                    LEFT JOIN expanse_subgroups ON expanse_subgroups.id = payments.expanse_subgroup_id
                                    WHERE payments.payment_type = "RETURN"
                                    AND payments.type ="BANK"
                                    AND payments.status = 1
                                    AND payments.bank_id="'.$bank_list->bank_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.supplier_id,suppliers.supplier_name,expanse_subgroups.subgroup_name,payments.payment_description ORDER BY payments.payment_date ASC ');

                               $loandcheck = DB::table('master_banks')->whereBetween('loan_fdate',[$fdate,$tdate])->where('bank_id', $bank_list->bank_id)->first();



                                    $si = 1;
									$finalBalance+= $opb;
                                @endphp


                             @if($btotalrcv != 0 || $btotalpay != 0)
                                <tr style="font-weight:bold; font-size:24px; color:rgb(161, 31, 31)">
                                   <td colspan="100%">{{$bank_name}}</td>
                                  <!--  <td></td>
                                    <td></td>
                                    <td align="right">Opening Balance</td>
                                   <td align="right"></td> -->

                                </tr>
                               <tr>
                                    <td style="font-weight:bold; left:50px;" colspan="5" >Opening Balance: </td>
                                    <td  style="font-weight:bold" align="right">{{number_format($opb, 2)}}/- (Dr)</td>
                                    <td  style="font-weight:bold" align="right"></td>
                                    <td  style="font-weight:bold" align="right">{{number_format($finalBalance, 2)}}</td>
                                  </tr>

                                @php
                                $subtrcv = 0;
                                $subtpmt = 0;
                                @endphp

                                   @foreach($vendor_prcv as $data)
                                   @php
                                      $subtrcv += $data->rcvamount;
                                      $grndt_rcv += $data->rcvamount;
									  $finalBalance += $data->rcvamount;
                                     @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
											<td style="color: rgb(21, 134, 21)">{{$data->payment_date}}</td>
                                            <td style="color: rgb(21, 134, 21)">{{$data->invoice}}</td>
                                        <td >
                                           <form  id="my_form_{{$data->invoice}}" method="get" name="" action="{{Route('bank.receive.index')}}">

                                               <input type="hidden" name="invoice" value="{{$data->invoice}}" >

                                                <a href="javascript:{}" onclick="document.getElementById('my_form_{{$data->invoice}}').submit();" style="color:#000000"> @if($data->d_s_name) {{$data->d_s_name}} (Dealer) @else {{$data->payment_description}} (Equity Receive) @endif</a>
                                          </form>

                                            </td>

												<td>{{$data->payment_description}}</td>
                                        <td align="right">{{number_format($data->rcvamount, 2)}}/-</td>
                                        <td></td>
                                        <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>
                                    @endforeach

                                    @foreach($vendor_pay as $data)
                                     @php

                                      $subtpmt += $data->payamount;
                                      $grndt_pym += $data->payamount;
                               		  $finalBalance -= $data->payamount;
                                      @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
                                        <td>{{$data->payment_date}}</td>
                                        <td>{{$data->invoice}}</td>
                                        @if($data->supplier_name)
                                        <td >
                                        {{$data->supplier_name}} (Supplier)
                                         </td>
                                         @elseif($data->name)
                                         <td>{{$data->name}}</td>
                                           @elseif($data->purchase_transection_id != null || $data->payment_description != null)
                                          <td >
                                          {{$data->payment_description}}
                                           </td>
                                       @else
                                        <td >{{$data->expanse_head}} - {{$data->subgroup_name}} </td>

                                        @endif
                                        <td>{{$data->payment_description}}</td>
                                        <td></td>
                                        <td align="right">{{number_format($data->payamount, 2)}}/-</td>
                                        <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>
                                    @endforeach


                                    @foreach($trnsfer_rcv as $data)
                                   @php
                                      $subtrcv += $data->rcvamount;
                                      $grndt_rcv += $data->rcvamount;
									  $finalBalance += $data->rcvamount;
                                     @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
									    <td style="color: green">{{$data->payment_date}}</td>
                                       	<td style="color: green">{{$data->invoice}}</td>
                                        <td >Transfer In {{$data->payment_description}}</td>

                                        <td>{{$data->payment_description}}</td>
                                         <td align="right">{{number_format($data->rcvamount, 2)}}/-</td>
                                         <td></td>
                                        <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>
                                    @endforeach



                                    @foreach($trnsfer_pay as $data)
                                     @php

                                      $subtpmt += $data->payamount;
                                      $grndt_pym += $data->payamount;
                                	  $finalBalance -= $data->payamount;
                                      @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
                                         <td>{{$data->payment_date}}</td>
                                       <td>{{$data->invoice}}</td>
                                        <td >Transfer Out {{$data->payment_description}} </td>

                                       <td>{{$data->payment_description}}</td>
                                        <td></td>
                                        <td align="right">{{number_format($data->payamount, 2)}}/-</td>
										<td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>
                                    @endforeach


                                      @foreach($others_collection_rcv as $data)
                                   @php
                                      $subtrcv += $data->rcvamount;
                                      $grndt_rcv += $data->rcvamount;
									 $finalBalance += $data->rcvamount;
                                     @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
											<td style="color: green">{{$data->payment_date}}</td>
                                       	<td style="color: green">{{$data->invoice}}</td>
                                        <td > {{$data->payment_description}}</td>


											 <td>{{$data->payment_description}}</td>
                                         <td align="right">{{number_format($data->rcvamount, 2)}}/-</td>
                                         <td></td>
                                        <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>
                                    @endforeach



                                    @foreach($others_collection_pmt as $data)
                                     @php

                                      $subtpmt += $data->payamount;
                                      $grndt_pym += $data->payamount;
                               		  $finalBalance -= $data->payamount;
                                      @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
                                        <td>{{$data->payment_date}}</td>
                                       <td>{{$data->invoice}}</td>
                                        <td >{{$data->payment_description}}dfad </td>

                                       <td>{{$data->payment_description}}</td>
                                        <td></td>
                                        <td align="right">{{number_format($data->payamount, 2)}}/-</td>
										<td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>
                                    @endforeach

                                @foreach($expnase_pmt as $data)
                               @if($data->payamount > 0)
                                     @php

                                      $subtpmt += $data->payamount;
                                      $grndt_pym += $data->payamount;
                               		  $finalBalance -= $data->payamount;
                                      @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
                                          <td>{{$data->payment_date}}</td>
                                        <td>{{$data->invoice}} (Expanse)</td>
                                        @if($data->supplier_name)
                                        <td >
                                        {{$data->supplier_name}} (Supplier)
                                         </td>
                                           @elseif($data->purchase_transection_id != null)
                                          <td >
                                          {{$data->payment_description}}
                                           </td>
                                       @else
                                        <td >{{$data->expanse_head}} - {{$data->subgroup_name}} </td>

                                        @endif

                                        <td>{{$data->payment_description}}</td>
                                         <td></td>
                                        <td align="right">{{number_format($data->payamount, 2)}}/-</td>
                                        <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>
                               @else


                               @endif
                                    @endforeach

                                @foreach($returnRec as $data)
                               @if($data->recAmount > 0)
                                     @php

                                      $subtrcv += $data->recAmount;
                                      $grndt_rcv += $data->recAmount;
									  $finalBalance += $data->recAmount;
                                      @endphp
                                      <tr style="color:red;">
                                        <td>{{$si++}}</td>
                                          <td>{{$data->payment_date}}</td>
                                        <td>{{$data->invoice}} (Return)</td>
                                        @if($data->supplier_name)
                                        <td >
                                        {{$data->supplier_name}} (Supplier)
                                         </td>

                                       @else
                                        <td > {{$data->subgroup_name}} </td>

                                        @endif

                                        <td>{{$data->payment_description}}</td>

                                        <td align="right">{{number_format($data->recAmount, 2)}}/-</td>
                                        <td></td>
                                        <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>
                               @else


                               @endif
                                    @endforeach

                               @foreach($general_prcv as $data)
                                   @php
                                      $subtrcv += $data->rcvamount;
                                      $grndt_rcv += $data->rcvamount;
									  $finalBalance += $data->rcvamount;
                                     @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
                                         <td style="color: rgb(21, 134, 21)">{{$data->payment_date}}</td>

                                        <td style="color: rgb(21, 134, 21)">{{$data->invoice}}</td>

                                        <td> {{$data->payment_description}}  (General Receive)
                                            </td>

										<td>{{$data->payment_description}}</td>
                                        <td align="right">{{number_format($data->rcvamount, 2)}}/-</td>
                                        <td></td>
                                         <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>
                                    @endforeach


                               @if($loandcheck)
                                @php
                                      $subtrcv += $loandcheck->loan_amount;
                                      $grndt_rcv +=  $loandcheck->loan_amount;
									$finalBalance += $loandcheck->loan_amount;
                                     @endphp
                                      <tr >
                                        <td>{{$si++}}</td>

                                        <td colspan="2">Loan Amount
                                            </td>
                                            <td style="color: rgb(21, 134, 21)"></td>
										<td>{{$data->payment_description}}</td>
                                        <td align="right">{{number_format($loandcheck->loan_amount, 2)}}/-</td>
                                        <td></td>
                                        <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                       </tr>
                               @endif

                                <tr>

                                    <td style="font-weight:bold; left:50px;" colspan="5" >SubTotal</td>

                                    <td  style="font-weight:bold" align="right">{{number_format($subtrcv, 2)}}/- (Dr)</td>
                                    <td  style="font-weight:bold" align="right">{{number_format($subtpmt, 2)}}/- (Cr)</td>

                                  	<td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                  </tr>
                                 @endif

                                @endforeach


                         <tr style="color: black;background-color: #827d789c;font-weight: bold;">

                                <td colspan="5" style="left:50px;" >Grand Total</td>

                                 <td  style="font-weight:bold" align="right">{{number_format($grndt_rcv+$topb, 2)}}/- (Dr)</td>
                                  <td  style="font-weight:bold" align="right">{{number_format($grndt_pym, 2)}}/- (Cr)</td>
                           		  <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                           </tr>
                               {{-- <tr>
                                    <td style="font-weight:bold; left:50px;" colspan="7" >Closing Balance: </td>
                                 	<td  style="font-weight:bold" align="right"></td>
                                    <td  style="font-weight:bold" align="right">{{number_format($tclb, 2)}}/-</td>
                                    <td  style="font-weight:bold" align="right">{{number_format(($finalBalance), 2)}}</td>
                                  </tr> --}}

                           </tbody>


                    </table>
                </div>
            </div>



        </div>
    </div>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

<script type="text/javascript">
  $(document).ready(function(){
  $('body').mouseenter(function(){
    $('#btnExport').css("display","inline-block");
      			$('#printbtn').css("display","inline-block");
  });
});

    function printDiv(divName) {
      			$('#btnExport').css("display","none");
      			$('#printbtn').css("display","none");
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
        }
</script>

<script type="text/javascript">
    $(function () {
        $("#btnExport").click(function () {
            $("#reporttable").table2excel({
                filename: "Bankbook.xls"
            });
        });
    });
</script>
@endsection
