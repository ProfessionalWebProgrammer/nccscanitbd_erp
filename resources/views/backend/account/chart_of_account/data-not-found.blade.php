@extends('layouts.account_dashboard')
@section('print_menu')

			<li class="nav-item mt-2">
				<a href="{{ URL('/accounts/trial/balance/head/change') }}" class=" btn btn-success btn-xs mr-2">Head Change</a>
            </li>
			<div class="text-right">
                      {{-- <button class="btn btn-xs  btn-success mr-1 mt-2" id="btnExport"  >
                       Export
                    </button> --}}
                    <button class="btn btn-xs  btn-warning mt-2"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>

@endsection
@push('addcss')
    <style>
        .text_sale {
            color: #f7ee79;
        }

        .text_credit {
            color: lime;
        }

    </style>
@endpush


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 pt-4">

            <div class="container-fluid" id="contentbody">
               <div class="row pt-5">
                  	<div class="col-md-3 text-left">


                    </div>
                  	<div class="col-md-6 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    	  <p>Head office, Rajshahi, Bangladesh</p>
                        <p><strong>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</strong></p>
                    </div>
                </div>
								<h5 class="text-center"><a href="{{route('chat.of.account.trail.balance.input')}}" >Click Here and Check Trail Balance Report</a></h5>

            </div>
        </div>
    </div>

		<!-- /.modal -->
		    <div class="modal fade" id="tbBank">
		        <div class="modal-dialog">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <h4 class="modal-title">Bank Details </h4>  <p class="mt-2 ml-1"> ({{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}) </p>
		                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                        <span aria-hidden="true">&times;</span>
		                    </button>
		                </div>
		                @php
										$allBanks = \App\Models\MasterBank::orderBy('bank_name', 'asc')->get();
										if($fdate == '2023-10-01'){
								        $predate = "2023-09-30";
								        } else {
								        $predate = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
								        }


		                @endphp
		                    <div class="modal-body">
													<table  class="table table-bordered table-striped" style="font-size: 12px;">
			                        <thead>
			                            <tr>
			                                <th style=" font-weight: bold;">SI</th>
			                                <th style=" font-weight: bold;">Bank Name {{$fdate}} - {{$tdate}}</th>
			                                <th style=" font-weight: bold;">Opening Balance </th>
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

																		//	$bankReceiveAmount = DB::table('payments')->where('payment_type','RECEIVE')->where('bank_id', $bank_list->bank_id)->sum('amount');
																		//	$balance = \App\Models\Account\ChartOfAccounts::select(DB::raw('SUM(debit) - SUM(credit) as balance'))->where('ac_sub_sub_account_id',4)->get();
												             //dd($bankReceiveAmount);
												//$bankReceiveAmount = DB::table('payments')->select([DB::raw("SUM(amount) expamount")])->where('payment_type','EXPANSE')->where('type','BANK')->whereBetween('payment_date',[$fdate,$tdate])->where('bank_id', $bank_list->bank_id)->first();

			                          			$oprcv = $totaldata->oprcv+$totaldata->troprcv+$totaldata->otoprcv+$totaldata->cltotalrcv+$preloandcheck+$totaldata->returnPreVal;
			                          			$oppay = $totaldata->oppay+$totaldata->troppay+$totaldata->otoppay+$totaldata->exoppay;

			                          			$totalrcv = $totaldata->totalrcv+$totaldata->trtotalrcv+$totaldata->ottotalrcv+$totaldata->cltotalrcv+$loandcheck+$totaldata->returnVal;
			                          			$totalpay = $totaldata->totalpay+$totaldata->trtotalpay+$totaldata->ottotalpay+$totaldata->extotalrcv;

			                       // dd($totaldata);
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
			                                   {{--  <td align="right">{{ number_format($totalrcv, 2) }}</td> --}}
			                                    <td align="right"></td>
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
		            <!-- /.modal-content -->
		        </div>
		        <!-- /.modal-dialog -->
		    </div>
		    <!-- /.modal -->
<script type="text/javascript">
    function printDiv(divName) {
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
                filename: "Trail_balance.xls"
            });
        });
    });
		$('#tbBank').on('show.bs.modal', function(event) {
				//console.log('hello test');
				var button = $(event.relatedTarget);
				var modal = $(this);
				//modal.find('.modal-body #minvoice').val(id);
		});
</script>

@endsection
