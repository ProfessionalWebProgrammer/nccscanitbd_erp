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
                      <h6 class="text-uppercase font-weight-bold" style="font-size:24px;">Sister Concern Book Report</h6>
                        <p class=""> From {{ date('d F Y', strtotime($fdate)) }}
                            To
                            {{ date('d F Y', strtotime($tdate)) }}</p>
                        <hr>
                    </div>

                    <table id="" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead>

                            <tr>
                                <th style=" font-weight: bold;">SI</th>
                                <th style=" font-weight: bold;">Company Name</th>
                                <th style=" font-weight: bold;">Opening Balance</th>
                                <th style=" font-weight: bold;">Total Receive</th>
                                <th style=" font-weight: bold;">Total Payment</th>
                                <th style=" font-weight: bold;">Closing Balance</th>
                            </tr>
                        </thead>


                        <tbody>
                            @php
                                $topb = 0;
                                $tpmt = 0;
                                $tclb = 0;
                                $tReceive =0;
                          $cashdata[] = 0;

                            @endphp

                            @foreach ($allCompany as $cash_list)
                                @php

                                    $wirehouse_name = $cash_list->name;


                          	$totaldata = DB::table('payments')
                          				->select('bank_id',
                          			  DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "COMPANY" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as exoppay'),
                                	DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as extotalrcv'),
                                	DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as preReceive'),
                                	DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as receive'),
                                  DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "COMPANY" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as prePayment'),
                                  DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as payment'),
                                  DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as preBankReceive'),
                                  DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as bankReceive')
                          			)
                          				->where('status', 1)->where('sister_concern_id', $cash_list->id)->first();


                              	$oppay = $totaldata->exoppay + $totaldata->preBankReceive + $totaldata->prePayment;
                          			$totalpay = $totaldata->extotalrcv + $totaldata->bankReceive + $totaldata->payment;
                              	$preReceive = $totaldata->preReceive;
                          			$receive = $totaldata->receive ;

                                $cashdata[$cash_list->id]['ctrcv'] = 0;
                              	$cashdata[$cash_list->id]['ctpay'] = $totalpay;
                          			$opb =  $oppay + $cash_list->balance - $preReceive;
                                $clb = $opb  + $totalpay - $receive;


                                    $topb += $opb;
                                    $tReceive += $receive;
                                    $tpmt += $totalpay;
                                    $tclb += $clb;

                                @endphp
                                @if($clb != 0)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $wirehouse_name }} </td>
                                    <td align="right">{{ number_format($opb, 2) }}</td>
                                    <td align="right">{{ number_format($receive, 2) }}</td>
                                    <td align="right">{{ number_format($totalpay, 2) }}</td>
                                    <td align="right">{{ number_format($clb, 2) }}</td>
                                </tr>
                                @endif
                            @endforeach
                            <tr style="background-color: #1aebe79c; font-weight:600; font-size:14px;">
                                <td></td>
                                <td style="font-weight:bold">Total</td>

                                <td style="font-weight:bold" align="right">{{ number_format($topb, 2) }}</td>
                                <td style="font-weight:bold" align="right">{{ number_format($tReceive, 2) }}</td>
                                <td style="font-weight:bold" align="right">{{ number_format($tpmt, 2) }}</td>
                                <td style="font-weight:bold" align="right">{{ number_format($tclb, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="container-fluid">
                <div class="py-2">
                    <table id="reporttable" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead style="border: 1px solid #515151;">
                            <tr>
                                 <th style=" font-weight: bold;">SI</th>
                                 <th style=" font-weight: bold; width:100px;">Date</th>
                                 <th style=" font-weight: bold; width:100px;">Voucher No</th>
                                 <th style=" font-weight: bold;">Ledger Name</th>
                                 <th style=" font-weight: bold;">Note</th>
                                 <th style=" font-weight: bold;">Receive Amount (Dr)</th>
                                 <th style=" font-weight: bold;">Payment Amount (Cr)</th>
                              	 <th style=" font-weight: bold;">Balance</th>
                            </tr>
                            </thead>
                             <tbody>

                                @php
                                $grantRecv = 0;
                                $grndt_pym = 0;
                                $finalBalance = 0;
                                @endphp
                                 @foreach($allCompany as $cash_list)
                                 @php

                                   $wirehouse_name = $cash_list->name;

                                   $totaldata = DB::table('payments')
                                 				->select('bank_id',
                                 			  DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "COMPANY" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as exoppay'),
                                       	DB::raw('sum(CASE WHEN payment_type = "EXPANSE" AND type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as extotalrcv'),
                                       	DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as preReceive'),
                                       	DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as receive'),
                                        DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "COMPANY" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as prePayment'),
                                        DB::raw('sum(CASE WHEN payment_type = "PAYMENT" AND type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as payment'),
                                        DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$startdate.'" AND "'.$predate.'" THEN `amount` ELSE null END) as preBankReceive'),
                                        DB::raw('sum(CASE WHEN payment_type = "RECEIVE" AND transfer_type = "COMPANY" AND payment_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `amount` ELSE null END) as bankReceive')
                                 			)
                                 				->where('status', 1)->where('sister_concern_id', $cash_list->id)->first();

                          			$oprcv = 0;
                                $oppay = $totaldata->exoppay + $totaldata->preBankReceive + $totaldata->prePayment;
                                $totalpay = $totaldata->extotalrcv + $totaldata->bankReceive + $totaldata->payment;
                                $preReceive = $totaldata->preReceive;
                                $receive = $totaldata->receive ;

                                $cashdata[$cash_list->id]['ctrcv'] = 0;
                                $cashdata[$cash_list->id]['ctpay'] = $totalpay;
                                $opb =  $oppay + $cash_list->balance - $preReceive;

                               $expnase_payments = DB::select('SELECT payments.invoice,payments.bank_name,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id, SUM(payments.amount) as payamount, payments.payment_date FROM `payments`

                                    LEFT JOIN expanse_subgroups ON expanse_subgroups.id = payments.expanse_subgroup_id
                                    WHERE payments.payment_type = "EXPANSE"
                                    AND payments.type = "COMPANY"
                                    AND payments.status = 1
                                    AND payments.sister_concern_id="'.$cash_list->id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.vendor_id,payments.expanse_head,expanse_subgroups.subgroup_name,payments.payment_description,payments.purchase_transection_id ORDER BY payments.payment_date ASC ');

                                $all_receieves = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as payamount, payments.payment_date, master_banks.bank_name as name, master_cashes.wirehouse_name as cash FROM `payments`
                                    LEFT JOIN master_banks ON master_banks.bank_id = payments.bank_id
                                    LEFT JOIN master_cashes ON master_cashes.wirehouse_id = payments.wirehouse_id
                                    WHERE payments.transfer_type = "COMPANY"
                                    AND payments.payment_type ="PAYMENT"
                                    AND payments.status = 1
                                    AND payments.sister_concern_id="'.$cash_list->id.'"
                                    AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                    GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC ');

                                $all_payments = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as payamount, payments.payment_date, master_banks.bank_name as name, master_cashes.wirehouse_name as cash FROM `payments`
                                        LEFT JOIN master_banks ON master_banks.bank_id = payments.bank_id
                                        LEFT JOIN master_cashes ON master_cashes.wirehouse_id = payments.wirehouse_id
                                        WHERE payments.type = "COMPANY"
                                        AND payments.payment_type ="PAYMENT"
                                        AND payments.status = 1
                                        AND payments.sister_concern_id="'.$cash_list->id.'"
                                        AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                        GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC ');

                                    $all_bankReceieves = DB::select('SELECT payments.invoice,payments.payment_description, SUM(payments.amount) as payamount, payments.payment_date, master_banks.bank_name as name, master_cashes.wirehouse_name as cash FROM `payments`
                                        LEFT JOIN master_banks ON master_banks.bank_id = payments.bank_id
                                        LEFT JOIN master_cashes ON master_cashes.wirehouse_id = payments.wirehouse_id
                                        WHERE payments.transfer_type = "COMPANY"
                                        AND payments.payment_type ="RECEIVE"
                                        AND payments.status = 1
                                        AND payments.sister_concern_id="'.$cash_list->id.'"
                                        AND payments.payment_date BETWEEN "'.$fdate.'" AND "'.$tdate.'"
                                        GROUP BY payments.invoice,payments.payment_description ORDER BY payments.payment_date ASC ');
                                    $si = 1;
                               $finalBalance += $opb;
                                @endphp
                                <tr style="font-weight:bold; font-size:16px;  color:rgb(122, 35, 35)">
                                   <td colspan="100%">{{$wirehouse_name}}</td>
                                </tr>
                               <tr style="font-weight: bold;">
                                <td></td>
                                <td colspan="3">Opening Balance: </td>
                                <td></td>
                                <td  style="font-weight:bold" align="right"></td>
                                <td  style="font-weight:bold" align="right">{{number_format($opb, 2)}}/- (Cr)</td>
                                <td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
                                </tr>
                                @php
                                $subtrcv = 0;
                                $subtpmt = 0;
                                @endphp

                               @foreach($expnase_payments as $data)
                                     @php
                                      $subtpmt += $data->payamount ?? 0;
                                      $grndt_pym += $data->payamount ?? 0;
                               			  $finalBalance += $data->payamount ?? 0;
                                      @endphp
                                      <tr >
                                        <td>{{$si++}}</td>
                                        <td>{{$data->payment_date}}</td>
                                       <td>{{$data->invoice}} (Expanse)</td>
                                        @if($data->bank_name)
                                        <td >
                                        {{$data->bank_name}}
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


                        @foreach($all_receieves as $data)
                              @php
                               $subtrcv += $data->payamount ?? 0;
                               $grantRecv += $data->payamount ?? 0;
                               $finalBalance -= $data->payamount ?? 0;
                               @endphp
                               <tr >
                                 <td>{{$si++}}</td>
                                 <td>{{$data->payment_date}}</td>
                                  <td>{{$data->invoice}} (Receive)</td>
                                 <td >{{$data->name ?? $data->cash}} </td>
                                 <td>{{$data->payment_description}}</td>
                                 <td align="right">{{number_format($data->payamount, 2)}}/-</td>
                                 <td></td>

                                 <td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
                                </tr>
                             @endforeach
                             @foreach($all_payments as $data)
                                   @php
                                   $subtpmt += $data->payamount ?? 0;
                                   $grndt_pym += $data->payamount ?? 0;
                                   $finalBalance += $data->payamount ?? 0;
                                    @endphp
                                    <tr >
                                      <td>{{$si++}}</td>
                                      <td>{{$data->payment_date}}</td>
                                       <td>{{$data->invoice}} (Payment)</td>
                                      <td >{{$data->name ?? $data->cash}} </td>
                                      <td>{{$data->payment_description}}</td>
                                      <td></td>
                                      <td align="right">{{number_format($data->payamount, 2)}}/-</td>
                                      <td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
                                     </tr>
                                  @endforeach

                             @foreach($all_bankReceieves as $data)
                                   @php

                                    $subtpmt += $data->payamount ?? 0;
                                    $grndt_pym += $data->payamount ?? 0;
                               		$finalBalance += $data->payamount ?? 0;
                                    @endphp
                                    <tr>
                                      <td>{{$si++}}</td>
                                      <td>{{$data->payment_date}}</td>
                                      <td>{{$data->invoice}} (Receive)</td>
                                      <td >{{$data->name ?? $data->cash}} </td>
                                      <td>{{$data->payment_description}}</td>
                                      <td></td>
                                      <td align="right">{{number_format($data->payamount, 2)}}/-</td>

                                      <td  style="font-weight:bold" align="right">{{number_format($finalBalance,2)}}</td>
                                     </tr>
                                  @endforeach



                         <tr style="background-color:#ecd2af;">
                             <td></td>
                             <td style="font-weight:bold" colspan="3" >SubTotal</td>
                             <td></td>
                             <td  style="font-weight:bold" align="right">{{number_format($subtrcv ?? 0, 2)}}/- (Dr)</td>
                             <td  style="font-weight:bold" align="right">{{number_format($subtpmt ?? 0, 2)}}/- (Cr)</td>
                             <td  style="font-weight:bold" align="right">{{number_format($finalBalance ?? 0,2)}}</td>
                           </tr>
                 @endforeach





                         <tr style="color: black;background-color: #1aebe79c;font-weight:600; font-size:14px;">
                                <td></td>
                                <td colspan="3" >Grand Total</td>
                                <td></td>
                                 <td  style="font-weight:bold" align="right">{{number_format($grantRecv, 2)}}/- (Dr)</td>
                                 <td  style="font-weight:bold" align="right">{{number_format($grndt_pym ?? 0, 2)}}/- (Cr)</td>
                           		<td  style="font-weight:bold" align="right">{{number_format($finalBalance >> 0,2)}}</td>

                           </tr>

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
