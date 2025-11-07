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
        
        .trailBalanceReports .table{
            color: #000 !important;
        }
        

    </style>
@endpush



@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 pt-4">

            <div class="container-fluid trailBalanceReports" id="contentbody">
               <div class="row pt-5">
                  	<div class="col-md-3 text-left">
                      <h5 class="text-uppercase font-weight-bold">Trail Balance</h5>
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
                                <tr style="background: #fff !important;">
                                    <th>Particular </th>
                                    <th style="text-align:right;">Debit</th>
                                    <th style="text-align:right;">Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                               @php
                          		$uid = Auth::id();
                                $totalDebit = 0;
                                $totalCredit = 0;
                               @endphp

                            @foreach ($chartOfAccounts  as $chartOfAccount)
														@if($chartOfAccount['title'] == 'Bank')
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
                                @endphp

																  <td><a href="{{URL('/bank/book/report/list')}}/{{$fdate}}/{{$tdate}}" target="_blank">{{ $chartOfAccount['title'] }}</a></td>
                                <td align="right"> <a href="{{URL('/bank/book/report/list')}}/{{$fdate}}/{{$tdate}}" target="_blank">{{  number_format($chartOfAccount['debit'],2)  }}</a></td>
                                <td align="right">{{  number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @elseif($chartOfAccount['title'] == 'Account Payable (Intercompany)')
														 <tr >
																 @php
																		 $totalDebit += $chartOfAccount['debit'];
																		 $totalCredit += $chartOfAccount['credit'];
																 @endphp

																	<td colspan="3"> Inter Company Loan	</td>
																 {{--<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
																 <td align="right"><a href="{{URL('/sisterConcern/book/report/list')}}/{{$fdate}}/{{$tdate}}" target="_blank">{{   number_format($chartOfAccount['credit'],2) }}</a></td> --}}

															</tr>
															@php
																$totalSubDr = 0;
																$totalSubCr = 0;
															@endphp
															@foreach($accountSisterConcernInfo as $val)
															@php
															$balance = 0;
																	 $balance = $val['credit'];

																	$totalSubCr += $val['credit'];

															 @endphp
															 @if($balance != 0)

																<tr>
																 	<td style="margin-left:15px;">{{ $val['title'] }}</td>
																	 <td align="right"></td>
																	 <td align="right">{{  number_format($balance,2)  }}</td>
																</tr>

															@endif

															@endforeach
															<tr>
															 <td >Total: </td>
															 <td align="right"></td>
															 <td align="right">{{  number_format($totalSubCr,2)  }} </td>
															</tr>
														 @elseif($chartOfAccount['title'] == 'Cash')
														 <tr>
																 @php
																		 $totalDebit += $chartOfAccount['debit'];
																		 $totalCredit += $chartOfAccount['credit'];
																 @endphp

																		<td>
																			 <a href="{{URL('/cash/book/report/list')}}/{{$fdate}}/{{$tdate}}" target="_blank"> {{ $chartOfAccount['title'] }}</a>
																		</td>
																 <td align="right"><a href="{{URL('/cash/book/report/list')}}/{{$fdate}}/{{$tdate}}" target="_blank">{{  number_format($chartOfAccount['debit'],2)  }}</a></td>
																 <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
															</tr>
															@elseif($chartOfAccount['title'] == 'Accounts Payable (Suppliers)')
															<tr>
															@php
																		$totalDebit += $chartOfAccount['debit'];
																		$totalCredit += $chartOfAccount['credit'];
																		$supplierCredit = $chartOfAccount['credit'];
																@endphp
																	<td colspan="3">{{ $chartOfAccount['title'] }}</td>

															 </tr>
															 @php
															 $totalSubDr = 0;
															 $totalSubCr = 0;
															 @endphp
															 @foreach($accountSupplierInfo as $val)
															 @php
															 $balance = 0;
															 			$balance = $val['credit'];

																@endphp
																@if($balance != 0)

																	 <tr>
																	 	<td style="margin-left:15px;">{{ $val['title'] }}</td>
																			<td align="right"></td>
																			<td align="right">{{  number_format($balance,2)  }}</td>
																	 </tr>

															 @endif

															 @endforeach

															 <tr>
															 	<td >Total: </td>
																<td align="right"> </td>
																<td align="right">{{  number_format($supplierCredit,2)  }} </td>
															 </tr>
															 @elseif($chartOfAccount['title'] == 'Accounts Receivable (Dealer)')
 																	<tr>
																		@php
																				$totalDebit += $chartOfAccount['debit'];
																				$totalCredit += $chartOfAccount['credit'];
																		@endphp
		 																	<td colspan="3"> {{ $chartOfAccount['title'] }} </td>

																	</tr>
																	@php
																	 $totalSubDr = 0;
	 																 $totalSubCr = 0;
		 															 @endphp
	 															 @foreach($accountDealerInfo as $val)
	 															 @php
	 															 $balance = 0;
	 															 			$balance = $val['debit'];

																			$totalSubDr += $val['debit'];

	 																@endphp
	 																@if($balance != 0)

		 															 <tr>
		 															 		<td style="margin-left:15px;">{{ $val['title'] }}</td>
		 																	<td align="right">{{  number_format($balance,2)  }}</td>
																			<td align="right"></td>
		 															 </tr>

	 															 @endif

	 															 @endforeach

																 <tr>
																 	<td >Total: </td>
																	<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
																	{{-- <td align="right">{{  number_format($totalSubDr,2)  }}</td> --}}
																	<td align="right"></td>
																 </tr>
															 @elseif($chartOfAccount['title'] == 'Finished Goods Sales')
 															<tr>
 																	@php
 																			$totalDebit += $chartOfAccount['debit'];
 																			$totalCredit += $chartOfAccount['credit'];
 																	@endphp

 																		 <td>
 																				<a href="{{URL('/sales/ledger/fg/report')}}/{{$fdate}}/{{$tdate}}" target="_blank"> {{ $chartOfAccount['title'] }}</a>
 																		 </td>
 																	<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
 																	<td align="right"><a href="{{URL('/sales/ledger/fg/report')}}/{{$fdate}}/{{$tdate}}" target="_blank">{{   number_format($chartOfAccount['credit'],2) }}</a></td>
 															 </tr>
															 @elseif($chartOfAccount['title'] == 'Inventory(FG)')
 														{{--	<tr>
 																	@php
 																			$totalDebit += $chartOfAccount['debit'];
 																			$totalCredit += $chartOfAccount['credit'];
 																	@endphp

 																		 <td>
 																				<a href="{{URL('/sales/stock/total/report/list')}}/{{$fdate}}/{{$tdate}}" target="_blank"> {{ $chartOfAccount['title'] }}</a>
 																		 </td>
 																	<td align="right"><a href="{{URL('/sales/stock/total/report/list')}}/{{$fdate}}/{{$tdate}}" target="_blank">{{  number_format($chartOfAccount['debit'],2)  }}</a></td>
 																	<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
 															 </tr> --}}
															 <tr>
															 	<td colspan="3">Inventory(FG)</td>
															 </tr>
															 @php
															 $totalInventory = 0;
															 @endphp
															 @foreach($fgInventoryInfo as $val)
															 @php
																	 $totalDebit += $val['debit'];
																	 $totalInventory += $val['debit'];
															 @endphp
															 @if($val['debit'] != 0)
															 <tr>
															 	<td>{{$val['title']}}</td>
															 	<td align="right">{{number_format($val['debit'],2)}}</td>
															 	<td></td>
															 </tr>
															 @endif
															 @endforeach
															 <tr>
															 		<td>Total: </td>
															 		<td align="right">{{number_format($totalInventory,2)}}</td>
															 		<td></td>
															 </tr>
															 @elseif($chartOfAccount['title'] == 'Purchase')
 															<tr>
 																	@php
 																			$totalDebit += $chartOfAccount['debit'];
 																			$totalCredit += $chartOfAccount['credit'];
 																	@endphp

 																		 <td>
 																				<a href="{{URL('/purchase/stock/ledger/report')}}/{{$fdate}}/{{$tdate}}" target="_blank"> {{ $chartOfAccount['title'] }}</a>
 																		 </td>
 																	<td align="right"><a href="{{URL('/purchase/stock/ledger/report')}}/{{$fdate}}/{{$tdate}}" target="_blank">{{  number_format($chartOfAccount['debit'],2)  }}</a></td>
 																	<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
 															 </tr>
															 @elseif($chartOfAccount['title'] == 'Sales Returns')
 															<tr>
 																	@php
 																			$totalDebit += $chartOfAccount['debit'];
 																			$totalCredit += $chartOfAccount['credit'];
 																	@endphp

 																		 <td>
 																				<a href="{{URL('/sales/ledger/return/report')}}/{{$fdate}}/{{$tdate}}" target="_blank"> {{ $chartOfAccount['title'] }}</a>
 																		 </td>
 																	<td align="right"><a href="{{URL('/sales/ledger/return/report')}}/{{$fdate}}/{{$tdate}}" target="_blank">{{  number_format($chartOfAccount['debit'],2)  }}</a></td>
 																	<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
 															 </tr>
															 @elseif($chartOfAccount['title'] == 'Equity')
 															<tr>
 																	@php
 																			$totalDebit += $chartOfAccount['debit'];
 																			$totalCredit += $chartOfAccount['credit'];
 																	@endphp

 																		 <td colspan="3">
 																				 {{ $chartOfAccount['title'] }}
 																		 </td>
 																	{{--<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
 																	<td align="right"><a href="{{URL('/accounts/equity/report/view')}}/{{$fdate}}/{{$tdate}}" target="_blank">{{   number_format($chartOfAccount['credit'],2) }}</a></td> --}}

 															 </tr>
															 @php
 															$totalSupAmount = 0;
 															@endphp
 															@foreach($accountEquityInfo as $val)
 															@php
 															$balance = 0;
 																	 $balance = $val['credit'];
 																	 // $totalCredit += $balance;
 																	 $totalSupAmount += $balance;
 															 @endphp
 															 @if($balance != 0)
 															<tr>
 															 <td style="margin-left:15px;">{{ $val['title'] }}</td>
 																 <td align="right"></td>
 																 <td align="right">{{  number_format($balance,2)  }}</td>
 															</tr>
 															@endif

 															@endforeach
 															<tr>
 															 <td >Total: </td>
 															 <td></td>
 															 <td align="right">@if($totalSupAmount != 0){{  number_format($totalSupAmount,2)  }} @else {{number_format($chartOfAccount['credit'],2)}} @endif </td>
 															</tr>
														 @else
														 <tr>
																 @php
																		 $totalDebit += $chartOfAccount['debit'];
																		 $totalCredit += $chartOfAccount['credit'];
																 @endphp
																 <td>  {{ $chartOfAccount['title'] }} </td>
																 <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
																 <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
															</tr>
														 @endif
                            @endforeach

														@if($accrudeExpenses)
														<tr>
															<td colspan="100%">ACCRUED EXPENSES</td>
														</tr>
                            @foreach ($accrudeExpenses  as $accrudeExp)

                            <tr>
                                @php
                                    $totalDebit += $accrudeExp['debit'];
                                    $totalCredit += $accrudeExp['credit'];
                                @endphp
                                <td>{{ $accrudeExp['title'] }}</td>
                                <td align="right">{{  number_format($accrudeExp['debit'],2)  }}</td>
                                <td align="right">{{   number_format($accrudeExp['credit'],2) }}</td>
                             </tr>
                            @endforeach
														@endif
														@if($currentAsset)
														<tr>
															<td colspan="100%">Advance, Deposit and Prepayment</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($currentAsset  as $chartOfAccount)
														@if($chartOfAccount['debit'] != 0)
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
                                    $subTotalDebit += $chartOfAccount['debit'];
                                    $subTotalCredit += $chartOfAccount['credit'];
                                @endphp

                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @endif
                            @endforeach
														<tr>
															<td>Sub Total (Advance, Deposit and Prepayment)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($fixedAsset)
														<tr>
															<td colspan="100%">Fixed Asset</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($fixedAsset  as $chartOfAccount)
														@if($chartOfAccount['debit'] != 0)
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
                                    $subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @endif
                            @endforeach
														<tr>
															<td>Sub Total (Fixed Asset)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif

															<tr>
																<td colspan="100%">Non Current Asset</td>
															</tr>
															@php
															$subTotalDebit = 0;
															$subTotalCredit = 0;
															@endphp

															@if($assetBuilding)
															<tr>
																<td colspan="100%" > <span style="margin-left: 15px;">Building & Civil Construction</span></td>
															</tr>
															@php
															$subTotal = 0;
															@endphp
	                            @foreach ($assetBuilding  as $value)
															@if($value['subLedger']['debit'] != 0)

	                            <tr>
	                                @php
	                                    $totalDebit += $value['subLedger']['debit'];
	                                    $totalCredit += 0;
																			$subTotalDebit += $value['subLedger']['debit'];
	                                    $subTotalCredit += 0;
																			$subTotal += $value['subLedger']['debit'];
	                                @endphp
	                                <td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
	                                <td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
	                                <td align="right">{{   number_format(0,2) }}</td>
	                             </tr>
															 @endif
	                            @endforeach
															<tr>
																<td>Sub Total</td>
																<td align="right">{{  number_format($subTotal,2)  }}</td>
																<td></td>
															</tr>
															@endif

															@if($assetOffEquip)
															<tr>
																<td colspan="100%" > <span style="margin-left: 15px;">Office Equipments</span></td>
															</tr>
															@php
															$subTotal = 0;
															@endphp
	                            @foreach ($assetOffEquip  as $value)
															@if($value['subLedger']['debit'] != 0)

	                            <tr>
	                                @php
	                                    $totalDebit += $value['subLedger']['debit'];
	                                    $totalCredit += 0;
																			$subTotalDebit += $value['subLedger']['debit'];
	                                    $subTotalCredit += 0;
																			$subTotal += $value['subLedger']['debit'];
	                                @endphp
	                                <td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
	                                <td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
	                                <td align="right">{{   number_format(0,2) }}</td>
	                             </tr>
															 @endif
	                            @endforeach
															<tr>
																<td>Sub Total</td>
																<td align="right">{{  number_format($subTotal,2)  }}</td>
																<td></td>
															</tr>
															@endif
															@if($assetPlant)
															<tr>
																<td colspan="100%" > <span style="margin-left: 15px;">Plant & Mechineries</span></td>
															</tr>
															@php
															$subTotal = 0;
															@endphp
	                            @foreach ($assetPlant  as $value)
															@if($value['subLedger']['debit'] != 0)

	                            <tr>
	                                @php
	                                    $totalDebit += $value['subLedger']['debit'];
	                                    $totalCredit += 0;
																			$subTotalDebit += $value['subLedger']['debit'];
	                                    $subTotalCredit += 0;
																			$subTotal += $value['subLedger']['debit'];
	                                @endphp
	                                <td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
	                                <td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
	                                <td align="right">{{   number_format(0,2) }}</td>
	                             </tr>
															 @endif
	                            @endforeach
															<tr>
																<td>Sub Total</td>
																<td align="right">{{  number_format($subTotal,2)  }}</td>
																<td></td>
															</tr>
															@endif

															@if($assetMotor)
															<tr>
																<td colspan="100%" > <span style="margin-left: 15px;">Motor Vehicle</span></td>
															</tr>
															@php
															$subTotal = 0;
															@endphp
	                            @foreach ($assetMotor  as $value)
															@if($value['subLedger']['debit'] != 0)

	                            <tr>
	                                @php
	                                    $totalDebit += $value['subLedger']['debit'];
	                                    $totalCredit += 0;
																			$subTotalDebit += $value['subLedger']['debit'];
	                                    $subTotalCredit += 0;
																			$subTotal += $value['subLedger']['debit'];
	                                @endphp
	                                <td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
	                                <td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
	                                <td align="right">{{   number_format(0,2) }}</td>
	                             </tr>
															 @endif
	                            @endforeach
															<tr>
																<td>Sub Total</td>
																<td align="right">{{  number_format($subTotal,2)  }}</td>
																<td></td>
															</tr>
															@endif
															@if($assetElectrical)
															<tr>
																<td colspan="100%" > <span style="margin-left: 15px;">Electrical Equipment</span></td>
															</tr>
															@php
															$subTotal = 0;
															@endphp
	                            @foreach ($assetElectrical  as $value)
															@if($value['subLedger']['debit'] != 0)

	                            <tr>
	                                @php
	                                    $totalDebit += $value['subLedger']['debit'];
	                                    $totalCredit += 0;
																			$subTotalDebit += $value['subLedger']['debit'];
	                                    $subTotalCredit += 0;
																			$subTotal += $value['subLedger']['debit'];
	                                @endphp
	                                <td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
	                                <td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
	                                <td align="right">{{   number_format(0,2) }}</td>
	                             </tr>
															 @endif
	                            @endforeach
															<tr>
																<td>Sub Total</td>
																<td align="right">{{  number_format($subTotal,2)  }}</td>
																<td></td>
															</tr>
															@endif
															@if($assetComputer)
															<tr>
																<td colspan="100%" > <span style="margin-left: 15px;">Computer & Software</span></td>
															</tr>
															@php
															$subTotal = 0;
															@endphp
	                            @foreach ($assetComputer  as $value)
															@if($value['subLedger']['debit'] != 0)

	                            <tr>
	                                @php
	                                    $totalDebit += $value['subLedger']['debit'];
	                                    $totalCredit += 0;
																			$subTotalDebit += $value['subLedger']['debit'];
	                                    $subTotalCredit += 0;
																			$subTotal += $value['subLedger']['debit'];
	                                @endphp
	                                <td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
	                                <td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
	                                <td align="right">{{   number_format(0,2) }}</td>
	                             </tr>
															 @endif
	                            @endforeach
															<tr>
																<td>Sub Total</td>
																<td align="right">{{  number_format($subTotal,2)  }}</td>
																<td></td>
															</tr>
															@endif
															@if($assetFurniture)
															<tr>
																<td colspan="100%" > <span style="margin-left: 15px;">Furniture & Fixture</span></td>
															</tr>
															@php
															$subTotal = 0;
															@endphp
															@foreach ($assetFurniture  as $value)
															@if($value['subLedger']['debit'] != 0)

															<tr>
																	@php
																			$totalDebit += $value['subLedger']['debit'];
																			$totalCredit += 0;
																			$subTotalDebit += $value['subLedger']['debit'];
																			$subTotalCredit += 0;
																			$subTotal += $value['subLedger']['debit'];
																	@endphp
																	<td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
																	<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
																	<td align="right">{{   number_format(0,2) }}</td>
															 </tr>
															 @endif
															@endforeach
															<tr>
																<td>Sub Total</td>
																<td align="right">{{  number_format($subTotal,2)  }}</td>
																<td></td>
															</tr>
															@endif
															@if($assetOthers)
															<tr>
																<td colspan="100%" > <span style="margin-left: 15px;">Preliminary Expanse</span></td>
															</tr>
															@php
															$subTotal = 0;
															@endphp
															@foreach ($assetOthers  as $value)
															@if($value['subLedger']['debit'] != 0)

															<tr>
																	@php
																			$totalDebit += $value['subLedger']['debit'];
																			$totalCredit += 0;
																			$subTotalDebit += $value['subLedger']['debit'];
																			$subTotalCredit += 0;
																			$subTotal += $value['subLedger']['debit'];
																	@endphp
																	<td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
																	<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
																	<td align="right">{{   number_format(0,2) }}</td>
															 </tr>
															 @endif
															@endforeach
															<tr>
																<td>Sub Total</td>
																<td align="right">{{  number_format($subTotal,2)  }}</td>
																<td></td>
															</tr>
															@endif
															@if($assetLand)
															<tr>
																<td colspan="100%" > <span style="margin-left: 15px;">Land & Land Development</span></td>
															</tr>
															@php
															$subTotal = 0;
															@endphp
															@foreach ($assetLand  as $value)
															@if($value['subLedger']['debit'] != 0)

															<tr>
																	@php
																			$totalDebit += $value['subLedger']['debit'];
																			$totalCredit += 0;
																			$subTotalDebit += $value['subLedger']['debit'];
																			$subTotalCredit += 0;
																			$subTotal += $value['subLedger']['debit'];
																	@endphp
																	<td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
																	<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
																	<td align="right">{{   number_format(0,2) }}</td>
															 </tr>
															 @endif
															@endforeach
															<tr>
																<td>Sub Total</td>
																<td align="right">{{  number_format($subTotal,2)  }}</td>
																<td></td>
															</tr>
															@endif

															<tr>
																<td>Sub Total (Non Current Asset)</td>
																<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
																<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
															</tr> 


														@if($otherFixedAsset)
														<tr>
															<td colspan="100%">Others Fixed Asset</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($otherFixedAsset  as $chartOfAccount)
														@if($chartOfAccount['debit'] != 0)
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
																		$subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @endif
                            @endforeach
														<tr>
															<td>Sub Total (Others Fixed Asset)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif

													{{--	@if($buildingFixedAsset)
														<tr>
															<td colspan="100%">Building and Civil Construction (Fixed Asset)</td>
														</tr>
                            @foreach ($buildingFixedAsset  as $chartOfAccount)

                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
                            @endforeach
														@endif --}}

														@if($officeAdminExp)
														<tr>
															<td colspan="100%">Office & Administrative Expense</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($officeAdminExp  as $chartOfAccount)
														@if($chartOfAccount['debit'] != 0)
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
																		$subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @endif
                            @endforeach
														<tr>
															<td>Sub Total (Office & Administrative Expense)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($cogsExp)
														<tr>
															<!--<td colspan="100%">Cost of Goods Sold (COGS)</td>-->
															<td colspan="100%">Material Consumption</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($cogsExp  as $chartOfAccount)
														@if($chartOfAccount['title'] == 'Cost of Goods Sold of Raw Material (RMCOGS)')
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
																		$subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td><a href="{{URL('/accounts/rmCogs/report/view')}}/{{$fdate}}/{{$tdate}}" target="_blank"> {{ $chartOfAccount['title'] }} </a></td>
                                <td align="right"><a href="{{URL('/accounts/rmCogs/report/view')}}/{{$fdate}}/{{$tdate}}" target="_blank"> {{  number_format($chartOfAccount['debit'],2)  }} </a></td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @elseif($chartOfAccount['title'] == 'Cost of Good Sold of Finished Goods (FGCOGS)')
														 <tr>
                                 @php
                                     $totalDebit += $chartOfAccount['debit'];
                                     $totalCredit += $chartOfAccount['credit'];
 																		$subTotalDebit += $chartOfAccount['debit'];
 																		$subTotalCredit += $chartOfAccount['credit'];
                                 @endphp
                                 <td><a href="{{URL('/accounts/fgCogs/report/view')}}/{{$fdate}}/{{$tdate}}" target="_blank"> {{ $chartOfAccount['title'] }} </a></td>
                                 <td align="right"><a href="{{URL('/accounts/fgCogs/report/view')}}/{{$fdate}}/{{$tdate}}" target="_blank"> {{  number_format($chartOfAccount['debit'],2)  }} </a></td>
                                 <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                              </tr>
														 @else
														 <tr>
                                 @php
                                     $totalDebit += $chartOfAccount['debit'];
                                     $totalCredit += $chartOfAccount['credit'];
 																		$subTotalDebit += $chartOfAccount['debit'];
 																		$subTotalCredit += $chartOfAccount['credit'];
                                 @endphp
                                 <td><a href="{{URL('/accounts/bagCogs/report/view')}}/{{$fdate}}/{{$tdate}}" target="_blank"> {{ $chartOfAccount['title'] }} </a></td>
                                 <td align="right"><a href="{{URL('/accounts/bagCogs/report/view')}}/{{$fdate}}/{{$tdate}}" target="_blank"> {{  number_format($chartOfAccount['debit'],2)  }} </a></td>
                                 <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                              </tr>
														 @endif

                            @endforeach
														<tr>
															<td>Sub Total COGS</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($directExp)
														<tr>
															<td colspan="100%">Direct Expenses</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($directExp  as $chartOfAccount)
														@if($chartOfAccount['debit'] != 0)
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
																		$subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @endif
                            @endforeach
														<tr>
															<td>Sub Total (Direct Expenses)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($financialExp)
														<tr>
															<td colspan="100%">Financial Expenses</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($financialExp  as $chartOfAccount)
														@if($chartOfAccount['debit'] != 0)
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
																		$subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @endif
                            @endforeach
														<tr>
															<td>Sub Total (Financial Expenses)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($sellingDistributionExpSD)

														<tr>
															<td colspan="100%">Selling and Distribution Expense-SD</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($sellingDistributionExpSD  as $chartOfAccount)
														@if($chartOfAccount['debit'] != 0)
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
																		$subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @endif
                            @endforeach
														<tr>
															<td>Sub Total (Selling and Distribution Expense-SD)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($factoryOverHeadExp)

														<tr>
															<td colspan="100%">Factory Over Head Expenses</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($factoryOverHeadExp  as $chartOfAccount)
														@if($chartOfAccount['debit'] != 0)
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
																		$subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @endif
                            @endforeach
														<tr>
															<td>Sub Total (Factory Over Head Expenses)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($rechearceDevelopExp)
														<tr>
															<td colspan="100%">Research and Development-F</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($rechearceDevelopExp  as $chartOfAccount)
														@if($chartOfAccount['debit'] != 0)
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
																		$subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @endif
                            @endforeach
														<tr>
															<td>Sub Total (Research and Development-F)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif

													{{--	@if($sellingDistributionExp)
														<tr>
															<td colspan="100%">Selling and Distribution Expense</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($sellingDistributionExp as $chartOfAccount)

                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
																		$subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
                            @endforeach
														<tr>
															<td>Sub Total (Selling and Distribution Expense)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif --}}
														@if($tdsPayableExp)
														<tr>
															<td colspan="100%">TDS Payble Office</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($tdsPayableExp as $chartOfAccount)
														@if($chartOfAccount['debit'] != 0)
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
																		$subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @endif
                            @endforeach
														<tr>
															<td>Sub Total (TDS Payble Office)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($othersDirectExp)
														<tr>
															<td colspan="100%">Others Direct Expense</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($othersDirectExp  as $chartOfAccount)
														@if($chartOfAccount['debit'] != 0)
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
																		$subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @endif
                            @endforeach
														<tr>
															<td>Sub Total (Others Direct Expense)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($othersExp)
														<tr>
															<td colspan="100%">Others All Expense</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($othersExp  as $chartOfAccount)
														@if($chartOfAccount['debit'] != 0)
                            <tr>
                                @php
                                    $totalDebit += $chartOfAccount['debit'];
                                    $totalCredit += $chartOfAccount['credit'];
																		$subTotalDebit += $chartOfAccount['debit'];
																		$subTotalCredit += $chartOfAccount['credit'];
                                @endphp
                                <td>{{ $chartOfAccount['title'] }}</td>
                                <td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
                                <td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
                             </tr>
														 @endif
                            @endforeach
														<tr>
															<td>Sub Total (Others All Expense)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														
														<tr>
														    @php 
														        $reatinedEarning = $totalDebit - $totalCredit;
														        $totalCredit+= $reatinedEarning;
														    @endphp 
														    <td>Retained Earning</td>
														    <td align="right"></td>
														    <td align="right">{{ number_format($reatinedEarning, 2) }}</td>
														</tr> 
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td align="right">{{ number_format($totalDebit, 2) }}</td>
                                   <td align="right">{{ number_format($totalCredit, 2) }}</td>
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
