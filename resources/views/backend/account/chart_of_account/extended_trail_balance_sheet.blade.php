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
        
        .extendTrailBalanceReports .table tr, .extendTrailBalanceReports .table tr td, .extendTrailBalanceReports .table tr th{
            color: #000 !important;
        }

    </style>
@endpush


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 pt-4">

            <div class="container-fluid extendTrailBalanceReports" id="contentbody">
               <div class="row pt-5">
                  	<div class="col-md-3 text-left">
                      <h5 class="text-uppercase font-weight-bold">Extended Trail Balance</h5>
                      {{-- <p class="text-uppercase font-weight-bold">From {{date('d m, Y',strtotime($date))}} to {{date('d m, Y',strtotime($tdate))}}</p> --}}

                    </div>
                  	<div class="col-md-6 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    	  <p>Head office, Rajshahi, Bangladesh</p>
                        <p><strong>{{ $fdate }} - {{ $tdate }}</strong></p>
                    </div>
                </div>

                <div class="py-4">
                    <div class="py-4 col-md-8 m-auto table-responsive">
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="font-size: 6;table-layout: inherit;">
                            <thead>
                                <tr style="background: #dee2e6 !important;" rowspan="2">
                                    <th>Particulars </th>
                                    <th style="text-align:right;">Opening Balance</th>
                                    <th colspan="2" class="text-center">Transection</th>
                                    <th style="text-align:right;">Closing Balance</th>
                                </tr>
																<tr style="background: #fff !important;">
																	<th></th>
																	<th></th>
																	<th style="text-align:right;">Debit</th>
																	<th style="text-align:right;">Credit</th>
																	<th></th>
																</tr>
                            </thead>
                            <tbody>
															@php
															$totalCr = 0;
															$totalDr = 0;
															@endphp
															<tr>
															<td colspan="100%">Share Capital</td>
															</tr>
															@php
															$subTotalOpening = 0;
															$subTotalClosing = 0;
															@endphp
                              	@foreach($accountEquityInfo as $val)
																@php
																$subTotalOpening += $val['opening'];
																$subTotalClosing += $val['closing'];
																@endphp
																<tr style="color: #c68d06;">
	 															 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																 <td align="right">{{  number_format($val['opening'],2)  }}</td>
	 																 <td align="right"></td>

	 																 <td align="right"></td>
	 																 <td align="right">{{  number_format($val['closing'],2)  }}</td>
	 															</tr>
																@endforeach
																<tr style="color: #c68d06;">
																	<td>Sub Total</td>
																	<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																	<td align="right"></td>
																	<td align="right"></td>
																	<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																</tr>


																<tr>
																<td colspan="100%">Inter Company Loan</td>
																</tr>
																@php
																$subTotalOpening = 0;
																$subTotalDr = 0;
																$subTotalCr = 0;
																$subTotalClosing = 0;
																@endphp
																	@foreach($accountSisterConcernInfo as $val)
																	@php
																	$subTotalOpening += $val['opening'];
																	$subTotalDr += $val['debit'];
																	$subTotalCr += $val['credit'];
																	$subTotalClosing += $val['closing'];
																	$totalCr += $val['credit'];
																	$totalDr += $val['debit'];
																	@endphp
																	@if($val['closing'] != 0)
																	<tr style="color: #453678;">
																	 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																	 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																	 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																	 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																		 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																	</tr>
																	@endif
																	@endforeach
																	<tr style="color: #453678;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>


																	<tr>
																	<td colspan="100%">Accrued Expenses</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																		@foreach($accountAccrudeExpInfo as $val)
																		@php
																		$subTotalOpening += $val['opening'];
																		$subTotalDr += $val['debit'];
																		$subTotalCr += $val['credit'];
																		$subTotalClosing += $val['closing'];
																		$totalCr += $val['credit'];
																		$totalDr += $val['debit'];
																		@endphp
																		@if($val['closing'] != 0)
																		<tr style="color: red;">
																		 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																		 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																		 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																		 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																			 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																		</tr>
																		@endif
																		@endforeach
																		<tr style="color: red;">
																			<td>Sub Total</td>
																			<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																			<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																			<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																			<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																		</tr>

																			<tr>
																			<td colspan="100%">Accounts Payable (Suppliers)</td>
																			</tr>
																			@php
																			$subTotalOpening = 0;
																			$subTotalDr = 0;
																			$subTotalCr = 0;
																			$subTotalClosing = 0;
																			@endphp
																				@foreach($accountSupplierInfo as $val)
																				@php
																				$subTotalOpening += $val['opening'];
																				$subTotalDr += $val['debit'];
																				$subTotalCr += $val['credit'];
																				$subTotalClosing += $val['closing'];
																				$totalCr += $val['credit'];
																				$totalDr += $val['debit'];
																				@endphp
																				@if($val['closing'] != 0)
																				<tr style="color:#719617;">
																				 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																				 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																				 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																				 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																					 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																				</tr>
																				@endif
																				@endforeach
																				<tr style="color:#719617;">
																					<td>Sub Total</td>
																					<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																					<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																					<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																					<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																				</tr>
																		@if($accountAdvanceSupplierInfo)
																		<tr>
																		<td colspan="100%">Advance Deposit Prepayment(Suppliers)</td>
																		</tr>
																		@php
																		$subTotalOpening = 0;
																		$subTotalDr = 0;
																		$subTotalCr = 0;
																		$subTotalClosing = 0;
																		@endphp
																			@foreach($accountAdvanceSupplierInfo as $val)
																			@php
																			$subTotalOpening += $val['opening'];
																			$subTotalDr += $val['debit'];
																			$subTotalCr += $val['credit'];
																			$subTotalClosing += $val['closing'];
																			$totalCr += $val['credit'];
																			$totalDr += $val['debit'];
																			@endphp
																			@if($val['closing'] != 0)
																			<tr style="color:green;">
																			 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																			 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																			 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																			 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																			 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																			</tr>
																			@endif
																			@endforeach
																			<tr style="color:green;">
																				<td>Sub Total</td>
																				<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																				<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																			</tr>

																		@endif


																		@if($accountCurrentAsset)
																		<tr>
																		<td colspan="100%">Current Asset</td>
																		</tr>
																		@php
																		$subTotalOpening = 0;
																		$subTotalDr = 0;
																		$subTotalCr = 0;
																		$subTotalClosing = 0;
																		@endphp
																			@foreach($accountCurrentAsset as $val)

																			@php
																			$subTotalOpening += $val['opening'];
																			$subTotalDr += $val['debit'];
																			$subTotalCr += $val['credit'];
																			$subTotalClosing += $val['closing'];
																			$totalCr += $val['credit'];
																			$totalDr += $val['debit'];
																			@endphp
																			@if($val['closing'] != 0)
																			<tr style="color:#267BF1;">
																			 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																			 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																			 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																			 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																			 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																			</tr>
																			@endif
																			@endforeach
																			<tr style="color:#267BF1;">
																				<td>Sub Total</td>
																				<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																				<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																			</tr>

																		@endif
																		@if($accountExtendedAccDepnInfo)


																			@foreach($accountExtendedAccDepnInfo as $value)
																			@php
																			$totalCr += $value['credit'];
																			$totalDr += $value['debit'];
																			@endphp
																					<tr style="color: #258e3c;">
																						<td>{{$value['title']}}</td>
																						<td align="right">{{number_format($value['opening'],2)}}</td>
																						<td align="right">{{number_format($value['debit'],2)}}</td>
																						<td align="right">{{number_format($value['credit'],2)}}</td>
																						<td align="right">{{number_format($value['closing'],2)}}</td>
																					</tr>
																			@endforeach
																		@endif
																		@if($fgInventoryInfo)
																		<tr>
																			<td colspan="100%">Inventory(FG)</td>
																		</tr>
																		@php
																		$subTotalOpening = 0;
																		$subTotalDr = 0;
																		$subTotalCr = 0;
																		$subTotalClosing = 0;
																		@endphp
																			@foreach($fgInventoryInfo as $val)
																			@php
																			$subTotalOpening += $val['opening'];
																			$subTotalDr += $val['debit'];
																			$subTotalCr += $val['credit'];
																			$subTotalClosing += $val['closing'];
																			$totalCr += $val['credit'];
																			$totalDr += $val['debit'];
																			@endphp
																			@if($val['closing'] != 0)
																			<tr style="color:green;">
																			 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																			 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																			 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																			 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																			 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																			</tr>
																			@endif
																			@endforeach
																			<tr style="color:green;">
																				<td>Sub Total</td>
																				<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																				<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																			</tr>
																		@endif
																		<tr>
																			<td colspan="100%">Non Current Asset</td>
																		</tr>
																		@if($assetBuilding)
																		<tr>
																		<td colspan="100%">Building & Civil Construction</td>
																		</tr>
																		@php
																		$subTotalOpening = 0;
																		$subTotalDr = 0;
																		$subTotalCr = 0;
																		$subTotalClosing = 0;
																		@endphp
																			@foreach($assetBuilding as $value)
																			@php
																			$subTotalOpening += $value['subLedger']['opening'];
																			$subTotalDr += $value['subLedger']['debit'];
																			$subTotalCr += $value['subLedger']['credit'];
																			$subTotalClosing += $value['subLedger']['closing'];
																			$totalCr += $value['subLedger']['credit'];
																			$totalDr += $value['subLedger']['debit'];
																			@endphp
																					<tr style="color: #267BF1;">
																						<td>{{$value['subLedger']['title']}}</td>
																						<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																					</tr>
																			@endforeach
																			<tr style="color:#267BF1;">
																				<td>Sub Total</td>
																				<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																				<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																			</tr>
																		@endif
																		@if($assetOffEquip)
																		<tr>
																		<td colspan="100%">Office Equipments</td>
																		</tr>
																		@php
																		$subTotalOpening = 0;
																		$subTotalDr = 0;
																		$subTotalCr = 0;
																		$subTotalClosing = 0;
																		@endphp
																			@foreach($assetOffEquip as $value)
																			@php
																			$subTotalOpening += $value['subLedger']['opening'];
																			$subTotalDr += $value['subLedger']['debit'];
																			$subTotalCr += $value['subLedger']['credit'];
																			$subTotalClosing += $value['subLedger']['closing'];
																			$totalCr += $value['subLedger']['credit'];
																			$totalDr += $value['subLedger']['debit'];
																			@endphp
																					<tr style="color: #267BF1;">
																						<td>{{$value['subLedger']['title']}}</td>
																						<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																					</tr>
																			@endforeach
																			<tr style="color:#267BF1;">
																				<td>Sub Total</td>
																				<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																				<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																			</tr>
																		@endif

																		@if($assetPlant)
																		<tr>
																		<td colspan="100%">Plant & Mechineries</td>
																		</tr>
																		@php
																		$subTotalOpening = 0;
																		$subTotalDr = 0;
																		$subTotalCr = 0;
																		$subTotalClosing = 0;
																		@endphp
																			@foreach($assetPlant as $value)
																			@php
																			$subTotalOpening += $value['subLedger']['opening'];
																			$subTotalDr += $value['subLedger']['debit'];
																			$subTotalCr += $value['subLedger']['credit'];
																			$subTotalClosing += $value['subLedger']['closing'];
																			$totalCr += $value['subLedger']['credit'];
																			$totalDr += $value['subLedger']['debit'];
																			@endphp
																					<tr style="color: #267BF1;">
																						<td>{{$value['subLedger']['title']}}</td>
																						<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																					</tr>
																			@endforeach
																			<tr style="color:#267BF1;">
																				<td>Sub Total</td>
																				<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																				<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																			</tr>
																		@endif

																		@if($assetMotor)
																		<tr>
																		<td colspan="100%">Motor Vehicle</td>
																		</tr>
																		@php
																		$subTotalOpening = 0;
																		$subTotalDr = 0;
																		$subTotalCr = 0;
																		$subTotalClosing = 0;
																		@endphp
																			@foreach($assetMotor as $value)
																			@php
																			$subTotalOpening += $value['subLedger']['opening'];
																			$subTotalDr += $value['subLedger']['debit'];
																			$subTotalCr += $value['subLedger']['credit'];
																			$subTotalClosing += $value['subLedger']['closing'];
																			$totalCr += $value['subLedger']['credit'];
																			$totalDr += $value['subLedger']['debit'];
																			@endphp
																					<tr style="color: #267BF1;">
																						<td>{{$value['subLedger']['title']}}</td>
																						<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																					</tr>
																			@endforeach
																			<tr style="color:#267BF1;">
																				<td>Sub Total</td>
																				<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																				<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																			</tr>
																		@endif

																		@if($assetElectrical)
																		<tr>
																		<td colspan="100%">Electrical Equipment</td>
																		</tr>
																		@php
																		$subTotalOpening = 0;
																		$subTotalDr = 0;
																		$subTotalCr = 0;
																		$subTotalClosing = 0;
																		@endphp
																			@foreach($assetElectrical as $value)
																			@php
																			$subTotalOpening += $value['subLedger']['opening'];
																			$subTotalDr += $value['subLedger']['debit'];
																			$subTotalCr += $value['subLedger']['credit'];
																			$subTotalClosing += $value['subLedger']['closing'];
																			$totalCr += $value['subLedger']['credit'];
																			$totalDr += $value['subLedger']['debit'];
																			@endphp
																					<tr style="color: #267BF1;">
																						<td>{{$value['subLedger']['title']}}</td>
																						<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																					</tr>
																			@endforeach
																			<tr style="color:#267BF1;">
																				<td>Sub Total</td>
																				<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																				<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																			</tr>
																		@endif
																		@if($assetComputer)
																		<tr>
																		<td colspan="100%">Computer & Software</td>
																		</tr>
																		@php
																		$subTotalOpening = 0;
																		$subTotalDr = 0;
																		$subTotalCr = 0;
																		$subTotalClosing = 0;
																		@endphp
																			@foreach($assetComputer as $value)
																			@php
																			$subTotalOpening += $value['subLedger']['opening'];
																			$subTotalDr += $value['subLedger']['debit'];
																			$subTotalCr += $value['subLedger']['credit'];
																			$subTotalClosing += $value['subLedger']['closing'];
																			$totalCr += $value['subLedger']['credit'];
																			$totalDr += $value['subLedger']['debit'];
																			@endphp
																					<tr style="color: #267BF1;">
																						<td>{{$value['subLedger']['title']}}</td>
																						<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																					</tr>
																			@endforeach
																			<tr style="color:#267BF1;">
																				<td>Sub Total</td>
																				<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																				<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																			</tr>
																		@endif

																		@if($assetFurniture)
																		<tr>
																		<td colspan="100%">Furniture & Fixture</td>
																		</tr>
																		@php
																		$subTotalOpening = 0;
																		$subTotalDr = 0;
																		$subTotalCr = 0;
																		$subTotalClosing = 0;
																		@endphp
																			@foreach($assetFurniture as $value)
																			@php
																			$subTotalOpening += $value['subLedger']['opening'];
																			$subTotalDr += $value['subLedger']['debit'];
																			$subTotalCr += $value['subLedger']['credit'];
																			$subTotalClosing += $value['subLedger']['closing'];
																			$totalCr += $value['subLedger']['credit'];
																			$totalDr += $value['subLedger']['debit'];
																			@endphp
																					<tr style="color: #267BF1;">
																						<td>{{$value['subLedger']['title']}}</td>
																						<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																					</tr>
																			@endforeach
																			<tr style="color:#267BF1;">
																				<td>Sub Total</td>
																				<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																				<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																			</tr>
																		@endif

																		@if($assetOthers)
																		<tr>
																		<td colspan="100%">Others Fixed Assets</td>
																		</tr>
																		@php
																		$subTotalOpening = 0;
																		$subTotalDr = 0;
																		$subTotalCr = 0;
																		$subTotalClosing = 0;
																		@endphp
																			@foreach($assetOthers as $value)
																			@php
																			$subTotalOpening += $value['subLedger']['opening'];
																			$subTotalDr += $value['subLedger']['debit'];
																			$subTotalCr += $value['subLedger']['credit'];
																			$subTotalClosing += $value['subLedger']['closing'];
																			$totalCr += $value['subLedger']['credit'];
																			$totalDr += $value['subLedger']['debit'];
																			@endphp
																					<tr style="color: #267BF1;">
																						<td>{{$value['subLedger']['title']}}</td>
																						<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																						<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																					</tr>
																			@endforeach
																			<tr style="color:#267BF1;">
																				<td>Sub Total</td>
																				<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																				<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																				<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																			</tr>
																		@endif

																		<tr>
																		<td colspan="100%">Bank</td>
																		</tr>
																			@foreach($accountExtendedBankInfo as $val)

																			@php
																			$totalCr += $val['credit'];
																			$totalDr += $val['debit'];
																			@endphp

																			<tr style="color:#054091;">
																			 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																			 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																			 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																			 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																			 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																			</tr>

																			@endforeach

																			<tr>
																			<td colspan="100%">Cash</td>
																			</tr>
																				@foreach($accountExtendedCashInfo as $val)

																				@php
																				$totalCr += $val['credit'];
																				$totalDr += $val['debit'];
																				@endphp

																				<tr style="color:#054091;">
																				 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																				 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																				 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																				 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																				 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																				</tr>

																				@endforeach

																				@if($accountExtendedPurchaseInfo)
																				<tr>
																				<td colspan="100%">Purchase</td>
																				</tr>
																					@foreach($accountExtendedPurchaseInfo as $val)

																					@php
																					$totalCr += $val['credit'];
																					$totalDr += $val['debit'];
																					@endphp

																					<tr style="color:#054091;">
																					 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																					 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																					 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																					 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																					 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																					</tr>
																					@endforeach
																				@endif

																				@if($accountDealerInfo)
																				<tr>
																				<td colspan="100%">Accounts Receivable (Dealer)</td>
																				</tr>
																				@php
																				$subTotalOpening = 0;
																				$subTotalDr = 0;
																				$subTotalCr = 0;
																				$subTotalClosing = 0;
																				@endphp
																					@foreach($accountDealerInfo as $val)
																					@php
																					$subTotalOpening += $val['opening'];
																					$subTotalDr += $val['debit'];
																					$subTotalCr += $val['credit'];
																					$subTotalClosing += $val['closing'];
																					$totalCr += $val['credit'];
																					$totalDr += $val['debit'];
																					@endphp
																					@if($val['closing'] != 0)
																					<tr style="color:#009;">
																					 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																					 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																					 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																					 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																						 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																					</tr>
																					@endif
																					@endforeach
																					<tr style="color:#009;">
																						<td>Sub Total</td>
																						<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																						<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																						<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																						<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																					</tr>
																					@endif

																			@if($accountDealerAdvanceInfo)
																			<tr>
																			<td colspan="100%">Advance Deposit Prepayment(Dealers)</td>
																			</tr>
																			@php
																			$subTotalOpening = 0;
																			$subTotalDr = 0;
																			$subTotalCr = 0;
																			$subTotalClosing = 0;
																			@endphp
																				@foreach($accountDealerAdvanceInfo as $val)
																				@php
																				$subTotalOpening += $val['opening'];
																				$subTotalDr += $val['debit'];
																				$subTotalCr += $val['credit'];
																				$subTotalClosing += $val['closing'];
																				$totalCr += $val['credit'];
																				$totalDr += $val['debit'];
																				@endphp
																				@if($val['closing'] != 0)
																				<tr style="color:#009;">
																				 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																				 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																				 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																				 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																				 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																				</tr>
																				@endif
																				@endforeach
																				<tr style="color:#009;">
																					<td>Sub Total</td>
																					<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																					<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																					<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																					<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																				</tr>

																			@endif
																			@if($accountExtendedFGSalesInfo)
																			<tr>
																			<td colspan="100%">Finished Goods Sales</td>
																			</tr>

																				@foreach($accountExtendedFGSalesInfo as $val)
																				@php
																					$subTotalDr += $totalDr;
																					$subTotalCr += $totalCr;
																				@endphp

																				<tr style="color:#009;">
																				 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																				 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																				 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																				 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																				 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																				</tr>
																				@endforeach


																			@endif
																			@if($accountExtendedSalesReturnInfo)
																			<tr>
																			<td colspan="100%">Sales Return</td>
																			</tr>

																				@foreach($accountExtendedSalesReturnInfo as $val)
																				@php
																				$totalCr += $val['credit'];
																				$totalDr += $val['debit'];
																				@endphp

																				<tr style="color:#009;">
																				 <td style="margin-left:15px;">{{ $val['title'] }}</td>
																				 <td align="right">{{  number_format($val['opening'],2)  }}</td>
																				 <td align="right">{{  number_format($val['debit'],2)  }}</td>
																				 <td align="right">{{  number_format($val['credit'],2)  }}</td>
																				 <td align="right">{{  number_format($val['closing'],2)  }}</td>
																				</tr>
																				@endforeach

																			@endif

																	<tr>
																		<td colspan="100%">Cost of Goods Sold (COGS)</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesCOGSData as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	<tr>
																		<td colspan="100%">Office & Administrative Expense</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesOfficeAdmin as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>

																	<tr>
																		<td colspan="100%">Direct Expenses</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesDirectExp as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@if($expensesFinancialExp)
																	<tr>
																		<td colspan="100%">Financial Expenses</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesFinancialExp as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@endif
																	@if($expensesSellingDistributionExp)
																	<tr>
																		<td colspan="100%">SELLING & DISTRIBUTION EXPENSE-SD</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesSellingDistributionExp as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@endif
																	@if($expensesDepreciationExp)
																	<tr>
																		<td colspan="100%">Depreciation Expense</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesDepreciationExp as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@endif
																	@if($expensesPrinceExp)
																	<tr>
																		<td colspan="100%">Prince Expense</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesPrinceExp as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@endif
																	@if($expensesFactoryOverheadExp)
																	<tr>
																		<td colspan="100%">Factory Overhead Expense</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesFactoryOverheadExp as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@endif
																	@if($expensesReseachExp)
																	<tr>
																		<td colspan="100%">Research and Development-F</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesReseachExp as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@endif
																	@if($expensesFuelExp)
																	<tr>
																		<td colspan="100%">Fuel & Lubricant - HO</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesFuelExp as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@endif
																	@if($expensesRepairExp)
																	<tr>
																		<td colspan="100%">Fuel & Lubricant - HO</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesRepairExp as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@endif
																	@if($expensesRegCarExp)
																	<tr>
																		<td colspan="100%">Registration Exp-Car </td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesRegCarExp as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@endif
																	@if($expensesMetingExp)
																	<tr>
																		<td colspan="100%">Meting Expense</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesMetingExp as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@endif
																	@if($expensesDirectLabourExp)
																	<tr>
																		<td colspan="100%">Direct Labour Expense</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($expensesDirectLabourExp as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@endif
																	@if($othersExpense)
																	<tr>
																		<td colspan="100%">Others Expense</td>
																	</tr>
																	@php
																	$subTotalOpening = 0;
																	$subTotalDr = 0;
																	$subTotalCr = 0;
																	$subTotalClosing = 0;
																	@endphp
																	@foreach($othersExpense as $value)
																	@php
																	$subTotalOpening += 0;
																	$subTotalDr += $value['subLedger']['debit'];
																	$subTotalCr += $value['subLedger']['credit'];
																	$subTotalClosing += $value['subLedger']['closing'];
																	$totalCr += $value['subLedger']['credit'];
																	$totalDr += $value['subLedger']['debit'];
																	@endphp
																			<tr style="color: red;">
																				<td>{{$value['subLedger']['title']}}</td>
																				<td align="right">{{number_format($value['subLedger']['opening'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['debit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['credit'],2)}}</td>
																				<td align="right">{{number_format($value['subLedger']['closing'],2)}}</td>
																			</tr>
																	@endforeach
																	<tr style="color:red;">
																		<td>Sub Total</td>
																		<td align="right">{{  number_format($subTotalOpening,2)  }}</td>
																		<td align="right">{{  number_format($subTotalDr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalCr,2)  }}</td>
																		<td align="right">{{  number_format($subTotalClosing,2)  }}</td>
																	</tr>
																	@endif
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td align="right"></td>
                                   <td align="right">{{number_format($totalDr,2)}}</td>
                                   <td align="right">{{number_format($totalCr,2)}}</td>
                                   <td align="right"></td>
                                </tr>

                            </tfoot>
                        </table>
												<!-- end table  -->
                    </div>

                </div>
            </div>
        </div>
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
                filename: "Extend_Trail_balance.xls"
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
