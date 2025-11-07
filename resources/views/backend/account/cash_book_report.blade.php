@extends('layouts.account_dashboard')

@section('print_menu')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="contentbody">

        <!-- Main content -->
        <div class="content px-4 ">

            <div class="container-fluid"  >

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
                <div class="py-4">
                    <div class="text-center">
                      <h6 class="text-uppercase font-weight-bold" style="font-size:24px;">Cash Book Report</h6>
                        <p class=""> From {{ date('d F Y', strtotime($fdate)) }}
                            To
                            {{ date('d F Y', strtotime($tdate)) }}</p>
                        <hr>
                    </div>

                    <table id="" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead>

                            <tr>
                                <th style=" font-weight: bold;">SI</th>
                                <th style=" font-weight: bold;">Cash Name</th>
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

                          $cashdata[] = 0;

                            @endphp

                            @foreach ($allFactory as $cash_list)
                                @php

                                    $wirehouse_name = $cash_list->wirehouse_name;

                                  /*  $oprcv = \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'RECEIVE')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');
                                    $oppay = \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'PAYMENT')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');

                                    $oppay += \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'TRANSFER')
                                        ->where('transfer_type', 'RECEIVE')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');
                                    $oprcv += \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'TRANSFER')
                                        ->where('transfer_type', 'PAYMENT')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');

                                    $oprcv += \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'OTHERS')
                                        ->where('others_type', 'RECEIVE')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');
                                    $oppay += \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'OTHERS')
                                        ->where('others_type', 'PAYMENT')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$startdate, $predate])
                                        ->sum('amount');

                                    $opb = $oprcv - $oppay + $cash_list->wirehouse_opb;

                                    $totalrcv = \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'RECEIVE')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');
                                    $totalpay = \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'PAYMENT')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');

                                    $totaltrpay = \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'TRANSFER')
                                        ->where('transfer_type', 'RECEIVE')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');
                          			$totalpay +=$totaltrpay;

                                    $totaltrrcv = \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'TRANSFER')
                                        ->where('transfer_type', 'PAYMENT')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');
                                    $totalrcv +=$totaltrrcv;

                                    $totalrcv += \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'OTHERS')
                                        ->where('others_type', 'RECEIVE')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');
                                    $totalpay += \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'OTHERS')
                                        ->where('others_type', 'PAYMENT')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');

                                    $totalpay += \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'EXPANSE')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');

                            		$totalrcv += \App\Models\Payment::where('wirehouse_id', $cash_list->wirehouse_id)
                                        ->where('status', 1)
                                        ->where('payment_type', 'COLLECTION')
                                        ->where('type', 'CASH')
                                        ->whereBetween('payment_date', [$fdate, $tdate])
                                        ->sum('amount');

                          */

                          	$totaldata = DB::table('payments')
                          				->select('bank_id',
                             		DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND type = "CASH" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as oprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "CASH" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as oppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "CASH" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as troprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "CASH" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as troppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "CASH" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as trtotalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "CASH" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as trtotalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "CASH" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as otoprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "CASH" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as otoppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "CASH" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "CASH" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "CASH" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as exoppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as extotalrcv'),

                         			DB::raw('sum(CASE WHEN payment_type = "COLLECTION" AND type = "CASH" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as cloppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "COLLECTION" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as cltotalrcv'),
                          			DB::raw('sum(CASE WHEN payment_type = "RETURN" AND type = "CASH" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as returnPreVal'),
                          			DB::raw('sum(CASE WHEN payment_type = "RETURN" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as returnVal'),

                          			)
                          				->where('status', 1)->where('wirehouse_id', $cash_list->wirehouse_id)->first();

                          			$oprcv = $totaldata->oprcv+$totaldata->troprcv+$totaldata->otoprcv+$totaldata->cltotalrcv+$totaldata->returnPreVal;
                          			$oppay = $totaldata->oppay+$totaldata->troppay+$totaldata->otoppay+$totaldata->exoppay;

                          			$totalrcv = $totaldata->totalrcv+$totaldata->trtotalrcv+$totaldata->ottotalrcv+$totaldata->cltotalrcv+$totaldata->returnVal;

                          			//$totalpay = $totaldata->totalpay+$totaldata->trtotalpay+$totaldata->ottotalpay+$totaldata->extotalrcv;
                          			$totalpay = $totaldata->totalpay+$totaldata->trtotalpay+$totaldata->ottotalpay+$totaldata->extotalrcv;

                              // dd($totaldata);

                          			$opb = $oprcv - $oppay + $cash_list->wirehouse_opb;
                                    $clb = $opb + $totalrcv - $totalpay;

                            $cashdata[$cash_list->wirehouse_id]['ctrcv'] = $totalrcv;
                          	$cashdata[$cash_list->wirehouse_id]['ctpay'] = $totalpay;

                                // dd($totalrcv);
                                    $topb += $opb;
                                    $trcv += $totalrcv;
                                    $tpmt += $totalpay;
                                    $tclb += $clb;

                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $wirehouse_name }} @if($totaldata->trtotalpay || $totaldata->trtotalrcv) <span style="color:red"> (Transfer) </span> @endif</td>
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


            <div class="container-fluid">
                {{--<div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div> --}}
                <div class="py-2">
                   {{-- <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Cash Book From {{ date('d F Y', strtotime($fdate)) }}
                            To
                            {{ date('d F Y', strtotime($tdate)) }}</h5>
                        <hr>
                    </div> --}}

                    <table id="reporttable" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead style="border: 1px solid #515151;">

                            <tr >
                                 <th style=" font-weight: bold;">SI</th>
                                 <th style=" font-weight: bold; width:100px;">Date</th>
                                 <th style=" font-weight: bold; width:100px;">Voucher No</th>
                                 <th style=" font-weight: bold;">Name</th>
                                 <th style=" font-weight: bold;">Note</th>
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

                                 @foreach($allFactory as $cash_list)
                                 @php

                                   $wirehouse_name = $cash_list->wirehouse_name;

									$totaldata = DB::table('payments')
                          				->select('bank_id',
                             		DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND type = "CASH" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as oprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "CASH" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as oppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as totalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "CASH" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as troprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "CASH" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as troppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "CASH" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as trtotalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "TRANSFER" AND type = "CASH" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as trtotalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "CASH" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as otoprcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "CASH" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as otoppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "CASH" AND transfer_type = "RECEIVE" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalrcv'),
                             		DB::raw('sum(CASE WHEN payment_type = "OTHERS" AND type = "CASH" AND transfer_type = "PAYMENT" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as ottotalpay'),

                          			DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "CASH" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as exoppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as extotalrcv'),

                         			DB::raw('sum(CASE WHEN payment_type = "COLLECTION" AND type = "CASH" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as cloppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "COLLECTION" AND type = "CASH" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as cltotalrcv'),
									DB::raw('sum(CASE WHEN payment_type = "RETURN" AND type = "CASH" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as returnPreVal'),
                          			)
                          				->where('status', 1)->where('wirehouse_id', $cash_list->wirehouse_id)->first();

                          			$oprcv = $totaldata->oprcv+$totaldata->troprcv+$totaldata->otoprcv+$totaldata->cltotalrcv+$totaldata->returnPreVal;
                          			$oppay = $totaldata->oppay+$totaldata->troppay+$totaldata->otoppay+$totaldata->exoppay;

                          			

                          			$opb = $oprcv - $oppay + $cash_list->wirehouse_opb;
                               	
                                   $btotalrcv =$cashdata[$cash_list->wirehouse_id]['ctrcv'];

                               $btotalpay =  $cashdata[$cash_list->wirehouse_id]['ctpay'];

                                    $vendor_prcv = DB::select('SELECT payments.vendor_id,payments.invoice,dealers.d_s_name,payments.payment_description, SUM(payments.amount) as rcvamount, payments.payment_date FROM `payments`
                                    LEFT JOIN dealers ON dealers.id = payments.vendor_id
                                    WHERE payments.payment_type = "RECEIVE"
                                    AND payments.type ="CASH"
                                    AND payments.status = 1
                                    AND payments.wirehouse_id="'.$cash_list->wirehouse_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                   GROUP BY payments.vendor_id,payments.invoice,dealers.d_s_name,payments.payment_description ORDER BY payments.payment_date ASC');

                                     $vendor_pay = DB::select('SELECT payments.invoice,payments.vendor_id,suppliers.supplier_name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`
                                     LEFT JOIN suppliers ON suppliers.id = payments.supplier_id
                                    LEFT JOIN expanse_subgroups ON expanse_subgroups.id = payments.expanse_subgroup_id
                                    WHERE payments.payment_type ="PAYMENT"
                                    AND payments.type ="CASH"
                                    AND payments.status = 1
                                    AND payments.wirehouse_id="'.$cash_list->wirehouse_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.vendor_id,suppliers.supplier_name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id ORDER BY payments.payment_date ASC');

                                  /*  $trnsfer_rcv = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as rcvamount, payments.payment_date FROM `payments`
                                    WHERE payments.transfer_type ="RECEIVE"
                                    AND payments.payment_type ="TRANSFER"
                                    AND payments.type ="CASH"
                                    AND payments.status = 1
                                    AND payments.wirehouse_id="'.$cash_list->wirehouse_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC '); */
									
                               		$trnsfer_rcv = DB::table('payments')->select([DB::raw("SUM(amount) rcvamount"),'invoice','payment_description','payment_date' ])
                               						->where('transfer_type','RECEIVE')->where('payment_type','TRANSFER')->where('type','CASH')->where('status',1)
                               						->where('wirehouse_id', $cash_list->wirehouse_id)->whereBetween('payment_date', [$fdate, $tdate])
                               						->groupby('invoice')->orderBy('payment_date','ASC')->get();
                               
                                    $trnsfer_pay = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`
                                    WHERE payments.transfer_type = "PAYMENT"
                                    AND payments.payment_type ="TRANSFER"
                                    AND payments.type ="CASH"
                                    AND payments.status = 1
                                    AND payments.wirehouse_id="'.$cash_list->wirehouse_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                   GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC');

                                      $others_collection_rcv = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as rcvamount, payments.payment_date FROM `payments`
                                    WHERE payments.others_type = "RECEIVE"
                                    AND payments.payment_type ="OTHERS"
                                    AND payments.type ="CASH"
                                    AND payments.status = 1
                                    AND payments.wirehouse_id="'.$cash_list->wirehouse_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC ');



                                     $others_collection_pmt = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`
                                    WHERE payments.others_type = "PAYMENT"
                                    AND payments.payment_type ="OTHERS"
                                    AND payments.type ="CASH"
                                    AND payments.status = 1
                                    AND payments.wirehouse_id="'.$cash_list->wirehouse_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.payment_description  ORDER BY payments.payment_date ASC');


                               $expnase_payments = DB::select('SELECT payments.invoice,payments.vendor_id,suppliers.supplier_name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`
                                    LEFT JOIN suppliers ON suppliers.id = payments.supplier_id
                                    LEFT JOIN expanse_subgroups ON expanse_subgroups.id = payments.expanse_subgroup_id
                                    WHERE payments.payment_type = "EXPANSE"
                                    AND payments.type = "CASH"
                                    AND payments.status = 1
                                    AND payments.wirehouse_id="'.$cash_list->wirehouse_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.vendor_id,suppliers.supplier_name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id ORDER BY payments.payment_date ASC ');

                                  $general_prcv = DB::select('SELECT payments.vendor_id,payments.invoice,dealers.d_s_name,payments.payment_description, SUM(payments.amount) as rcvamount, payments.payment_date FROM `payments`
                                    LEFT JOIN dealers ON dealers.id = payments.vendor_id
                                    WHERE payments.payment_type = "COLLECTION"
                                    AND payments.type ="CASH"
                                    AND payments.status = 1
                                   AND payments.wirehouse_id="'.$cash_list->wirehouse_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.vendor_id,payments.invoice,dealers.d_s_name,payments.payment_description ORDER BY payments.payment_date ASC');
                               
									$returnRec = DB::select('SELECT payments.invoice,payments.supplier_id,suppliers.supplier_name,expanse_subgroups.subgroup_name,payments.payment_description, SUM(payments.amount) as recAmount, payments.payment_date FROM `payments`
                                     LEFT JOIN suppliers ON suppliers.id = payments.supplier_id
                                    LEFT JOIN expanse_subgroups ON expanse_subgroups.id = payments.expanse_subgroup_id
                                    WHERE payments.payment_type = "RETURN"
                                    AND payments.type ="CASH"
                                    AND payments.status = 1 
                                    AND payments.wirehouse_id="'.$cash_list->wirehouse_id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.supplier_id,suppliers.supplier_name,expanse_subgroups.subgroup_name,payments.payment_description ORDER BY payments.payment_date ASC ');
                                    $si = 1;
                               $finalBalance+= $opb;
								//dd($expnase_payments);
                                @endphp


                             @if($btotalrcv != 0 || $btotalpay != 0)

								
                                <tr style="font-weight:bold; font-size:24px;  color:rgb(122, 35, 35)">
                                   <td colspan="100%">{{$wirehouse_name}}</td>
                                  <!--  <td></td>
                                    <td></td>
                                    <td align="right">Opening Balance</td>
                                   <td align="right"></td> -->

                                </tr>
                               <tr style="font-weight: bold;">
                                <td></td>
                                <td colspan="3">Opening Balance: </td>
                                <td></td>
                                 <td  style="font-weight:bold" align="right">{{number_format($opb, 2)}}/- (Dr)</td>
                                  <td  style="font-weight:bold" align="right"></td>
                                  <td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
                           </tr>
                                @php
                                $subtrcv = 0;
                                $subtpmt = 0;
                                @endphp
                                   @foreach($vendor_prcv as $data)
                                   @php
                                      $subtrcv += $data->rcvamount?? 0;
                                      $grndt_rcv += $data->rcvamount ?? 0;
									  $finalBalance += $data->rcvamount ?? 0;
                                     @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
                                        <td style="color: rgb(19, 100, 19)">{{$data->payment_date}}</td>
                                        <td style="color: rgb(19, 100, 19)">{{$data->invoice}}</td>
                                        <td >
                                         <form  id="my_form_{{$data->vendor_id}}" method="get" name="" action="{{Route('cash.receive.index')}}">
                                        	@csrf
                                                <input type="hidden" name="invoice" value="{{$data->invoice}}" >

                                                <a href="javascript:{}" onclick="document.getElementById('my_form_{{$data->vendor_id}}').submit();" style="color:#000000">@if($data->d_s_name) {{$data->d_s_name}} (Vendor) @else {{$data->payment_description}} (Equity Receive) @endif </a>
                                          </form>
                                        {{--  @if($data->d_s_name == null)
                                          {{$data->payment_description}}
                                          @endif --}}
                                        </td>
                                        
                                        <td>{{$data->payment_description}}</td>
                                        <td align="right">{{number_format($data->rcvamount, 2)}}/-</td>
                                        <td></td>
                                        <td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
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
                                        <td >{{$data->supplier_name}} (Supplier) </td>
                                         @elseif($data->supplier_name == null && $data->expanse_head == null)
                                        <td >
                                        {{$data->payment_description}}
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
                                        <td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
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
										 <td style="color: rgb(26, 148, 26)">{{$data->payment_date}}</td>
                                        <td style="color: rgb(26, 148, 26)">{{$data->invoice}}</td>
                                        <td >Transfer In {{$data->payment_description}} Receive</td>
                                       
                                        <td>{{$data->payment_description}}</td>
                                        <td align="right">{{number_format($data->rcvamount, 2)}}/-</td>
										<td></td>
                                        <td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
                                       </tr>
                                    @endforeach



                                 @foreach($trnsfer_pay as $data)
                                     @php

                                      $subtpmt += $data->payamount ?? 0;
                                      $grndt_pym += $data->payamount ?? 0;
                               		  $finalBalance -= $data->payamount ?? 0;
                                      @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
                                        <td>{{$data->payment_date}}</td>
                                       <td>{{$data->invoice}}</td>
                                        <td >Transfer Out {{$data->payment_description}} Payment</td>

                                        
                                        <td>{{$data->payment_description}}</td>
                                        <td></td>
                                        <td align="right">{{number_format($data->payamount, 2)}}/-</td>
                                        <td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
                                       </tr>
                                    @endforeach
                               @foreach($expnase_payments as $data)
                                     @php
                                      $subtpmt += $data->payamount ?? 0;
                                      $grndt_pym += $data->payamount ?? 0;
                               			$finalBalance -= $data->payamount ?? 0;
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
                                        <td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
                                       </tr>
                                    @endforeach
                                @foreach($others_collection_rcv as $data)
                                   @php
                                      $subtrcv += $data->rcvamount ?? 0;
                                      $grndt_rcv += $data->rcvamount ?? 0;
										$finalBalance += $data->rcvamount ?? 0;
                                     @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
										<td style="color: rgb(22, 70, 13)">{{$data->payment_date}}</td>
                                        <td style="color: rgb(22, 70, 13)">{{$data->invoice}}</td>
                                        <td > {{$data->payment_description}}</td>
                                        
                                        <td>{{$data->payment_description}}</td>
                                         <td align="right">{{number_format($data->rcvamount, 2)}}/-</td>
                                         <td></td>
                                        <td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
                                       </tr>
                                    @endforeach



                                    @foreach($others_collection_pmt as $data)
                                     @php

                                      $subtpmt += $data->payamount ?? 0;
                                      $grndt_pym += $data->payamount?? 0;
                               		  $finalBalance -= $data->payamount?? 0;
                                      @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
                                        <td>{{$data->payment_date}}</td>
                                       <td>{{$data->invoice}}</td>
                                        <td >{{$data->payment_description}} </td>
                                        
                                        <td>{{$data->payment_description}}</td>
                                       <td></td>
                                        <td align="right">{{number_format($data->payamount, 2)}}/-</td>
										<td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
                                       </tr>
                                    @endforeach


								 @foreach($returnRec as $data)
                               @if($data->recAmount > 0)
                                     @php

                                      $subtrcv += $data->recAmount?? 0;
                                      $grndt_rcv += $data->recAmount?? 0;
									  $finalBalance += $data->recAmount?? 0;
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
                                      $subtrcv += $data->rcvamount?? 0;
                                      $grndt_rcv += $data->rcvamount?? 0;
									  $finalBalance += $data->rcvamount?? 0;
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
                                        <td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
                                       </tr>
                                    @endforeach
                               @endif
                               @endforeach
                                <tr>
                                    <td></td>
                                    <td style="font-weight:bold" colspan="3" >SubTotal</td>
                                    <td></td>
                                    <td  style="font-weight:bold" align="right">{{number_format($subtrcv ?? 0, 2)}}/- (Dr)</td>
                                    <td  style="font-weight:bold" align="right">{{number_format($subtpmt ?? 0, 2)}}/- (Cr)</td>
                                  	<td  style="font-weight:bold" align="right">{{number_format($finalBalance ?? 0,2)}}</td>
                                  </tr>


                                 

								 
                               
                         <tr style="color: black;background-color: #827d789c;font-weight: bold;">
                                <td></td>
                                <td colspan="3" >Grand Total</td>
                                <td></td>
                                 <td  style="font-weight:bold" align="right">{{number_format($grndt_rcv+$topb, 2)}}/- (Dr)</td>
                                 <td  style="font-weight:bold" align="right">{{number_format($grndt_pym ?? 0, 2)}}/- (Cr)</td>
                           		<td  style="font-weight:bold" align="right">{{number_format($finalBalance >> 0,2)}}</td>

                           </tr>
                               {{-- <tr style="font-weight: bold;">
                                <td></td>
                                <td colspan="3" >Closing Balance: </td>
                                <td></td>
                                 <td  style="font-weight:bold" align="right"></td>
                                    <td  style="font-weight:bold" align="right">{{number_format($tclb, 2)}}/- (Dr)</td>
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
                filename: "CashBook.xls"
            });
        });
    });
</script>
@endsection
