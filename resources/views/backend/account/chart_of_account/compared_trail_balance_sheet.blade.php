@extends('layouts.account_dashboard')
@section('print_menu')

			{{-- <li class="nav-item mt-2">
				<a href="{{ URL('/accounts/trial/balance/head/change') }}" class=" btn btn-success btn-xs mr-2">Head Change</a>
			</li> --}}
			<div class="text-right">
                       <button class="btn btn-xs  btn-success mr-1 mt-2" id="btnExport"  >
                       Export
                    </button>
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
				table{
					font-size: 14px!important;
					font-weight: 500 !important;
				}
				#reporttable .table th,   #reporttable .table td{
          color: #000;
          font-size: 14px!important;
        }
    </style>
@endpush


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >
        <!-- Main content -->
        <div class="content px-4 pt-4">

            <div class="container-fluid" id="contentbody">
                <div class="">
               <div class="row pt-5">
                  	<div class="col-md-3 text-left">
                      <h6 class="text-uppercase font-weight-bold">Compared Trail Balance</h6>
                      {{-- <p class="text-uppercase font-weight-bold">From {{date('d m, Y',strtotime($date))}} to {{date('d m, Y',strtotime($tdate))}}</p> --}}

                    </div>
                  	<div class="col-md-6 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    	<p>Head office, Rajshahi, Bangladesh</p>
                        {{--  <p><strong>{{ $fdate }} - {{ $tdate }}</strong></p>  --}}
                    </div>
                </div>
								@php  $i = 0; @endphp
                <div class="row " id="reporttable">
					@foreach($information as $index => $val)

					<div class="@if($i == 0) col-md-5 id="tabel1" @else col-md-2 id="tabel2" @endif "   @if($i == 0) id="tabel1" @else id="tabel2" @endif  style="@if($i == 0) width: 66.666667%; @else width: 33.333333%; @endif">
						<table class="table table-bordered table-striped table-fixed">
							<thead style="font-size:14px; font-weight:500;">
								<tr>
									@if($i == 0)
									<th>Particular</th>
									<th colspan="2" style="text-align:center;">The Month of {{ $val['month']}}</th>
									@else
									<th colspan="2" style="text-align:center;">The Month of {{ $val['month']}}</th>
									@endif
								</tr>
								<tr>
									@if($i == 0)
									<th width="84%"></th>
									<th width="8%" style="text-align:right;">Debit</th>
									<th width="8%" style="text-align:right;">Credit</th>
									@else
									<th width="50%" style="text-align:right;">Debit</th>
									<th width="50%" style="text-align:right;">Credit</th>
									@endif

								</tr>
							</thead>
							<tbody>
								 @php
									$uid = Auth::id();
									$totalDebit = 0;
									$totalCredit = 0;
								 @endphp

							@foreach ($val['chartOfAccounts']  as $key => $chartOfAccount)
							@if($chartOfAccount['title'] == 'Accounts Payable (Suppliers)')

							@php
										$totalDebit += $chartOfAccount['debit'];
										$totalCredit += $chartOfAccount['credit'];
								@endphp



							@elseif($chartOfAccount['title'] == 'Accounts Receivable (Dealer)')

									@php
											$totalDebit += $chartOfAccount['debit'];
											$dealerSubTotal = $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
									@endphp




								@else

							<tr style="font-size:13px; font-weight:500;">
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'])  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit']) }}</td>
							 </tr>
								 @endif
							@endforeach

							<!-- supplier start -->
							<tr>
								<td colspan="100%" style="font-size:15px; font-weight:500;" >Accounts Payable (Suppliers)</td>
							</tr>
							@php
							$totalSubDr = 0;
							$totalSubCr = 0;
							@endphp
							@foreach($val['accountSupplierInfo'] as $value)
							@php
							$balance = 0;
									 $balance = $value['credit'];
									 $totalSubCr += $value['credit'];

							 @endphp


									<tr style="color: #719617; font-size:8.5px;">
										@if($i == 0)
									 <td style="margin-left:15px;">{{ $value['title'] }}</td>
									 @else

									 @endif
										 <td align="right"></td>
										 <td align="right">{{  number_format($balance,2)  }}</td>
									</tr>


							@endforeach

							<tr style="color: #719617;">
								@if($i == 0)
							 <td >Total: </td>
							 @else

							 @endif
							 <td align="right"> </td>
							 <td align="right">{{  number_format($totalSubCr,2)  }} </td>
							</tr>
							<!-- supplier end -->

							<!-- Dealer start  -->
							<tr>
								<td colspan="100%" style="font-size:15px; font-weight:500;color:skye;" >Accounts Receivable (Dealer)</td>
							</tr>
							@php
							 $totalSubDr = 0;
							 $totalSubCr = 0;
							 @endphp
						 @foreach($val['accountDealerInfo'] as $value)
						 @php
						 $balance = 0;
									$balance = $value['debit'];
									$totalSubDr += $value['debit'];

							@endphp


							 <tr style="color: #009; font-size:8.5px;">
								 @if($i == 0)
									<td style="margin-left:15px;">{{ $value['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($balance,2)  }}</td>
									<td align="right"></td>
							 </tr>



						 @endforeach

						 <tr style="color: #009;">
							 @if($i == 0)
							<td >Total: </td>
							@else

							@endif
							<td align="right">{{  number_format($dealerSubTotal,2)  }}</td>
							{{-- <td align="right">{{  number_format($totalSubDr,2)  }}</td> --}}
							<td align="right"></td>
						 </tr>
							<!-- Dealer end  -->

							@if($val['accrudeExpenses'])
							<tr style="background-color:#e44949; font-size:14px; font-weight:500;">
								<td colspan="100%">ACCRUED EXPENSES</td>
							</tr>
							@foreach ($val['accrudeExpenses']  as $accrudeExp)

							<tr style="font-size:13px; font-weight:500;">
									@php
											$totalDebit += $accrudeExp['debit'];
											$totalCredit += $accrudeExp['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $accrudeExp['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($accrudeExp['debit'],2)  }}</td>
									<td align="right">{{   number_format($accrudeExp['credit'],2) }}</td>
							 </tr>
							@endforeach
							@endif
						{{-- 	<tr style="background-color:#874536; font-size:14px; font-weight:500;">
								<td colspan="100%">Others Income</td>
							</tr> --}}
							@if($val['othersIncomeInfo'])
							@foreach($val['othersIncomeInfo']  as $chartOfAccount)
							<tr style="font-size:13px; font-weight:500;">
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] ?? '' }}</td>
									@else

									@endif

									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>

							 </tr>
							@endforeach
							@else
							<tr>
								@if($i == 0)
								<td> Others Income</td>
								@else

								@endif
								<td></td>
								<td align="right"> 0.00</td>
							</tr>
							@endif


							@if($val['currentAsset'])
							<tr style="background-color:#87cfef; font-size:14px; font-weight:500;">
								<td colspan="100%">Advance, Deposit and Prepayment</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['currentAsset']  as $chartOfAccount)

							<tr style="font-size:13px; font-weight:500;">
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
											$subTotalDebit += $chartOfAccount['debit'];
											$subTotalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
							 </tr>
							@endforeach
							<tr style="background:#32a259; font-size:14px; font-weight:500;">
								@if($i == 0)
								<td>Sub Total (Current Asset)</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif

							<tr style="background-color:#87cfef;">

								<td colspan="100%">Non Current Asset</td>

							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp

							@if($val['assetBuilding'])
							<tr>

								<td colspan="100%" > <span style="margin-left: 15px;">Building & Civil Construction</span></td>

							</tr>
							@php
							$subTotal = 0;
							@endphp
							@foreach ($val['assetBuilding']  as $value)
							@if($value['subLedger']['debit'] != 0)

							<tr>
									@php
											$totalDebit += $value['subLedger']['debit'];
											$totalCredit += 0;
											$subTotalDebit += $value['subLedger']['debit'];
											$subTotalCredit += 0;
											$subTotal += $value['subLedger']['debit'];
									@endphp
									@if($i == 0)
									<td> <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
									<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
									<td align="right">{{   number_format(0,2) }}</td>
									@else
									<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
									<td align="right">{{   number_format(0,2) }}</td>
									@endif

							 </tr>
							 @endif
							@endforeach
							<tr style="background:#4ec7df;">
								@if($i == 0)
								<td>Sub Total</td>
								<td align="right">{{  number_format($subTotal,2)  }}</td>
								<td></td>
								@else
								<td align="right">{{  number_format($subTotal,2)  }}</td>
								<td></td>
								@endif

							</tr>
							@endif

							@if($val['assetOffEquip'])
							<tr>

								<td colspan="100%" > <span style="margin-left: 15px;">Office Equipments</span></td>

							</tr>
							@php
							$subTotal = 0;
							@endphp
							@foreach ($val['assetOffEquip']  as $value)
							@if($value['subLedger']['debit'] != 0)

							<tr>
									@php
											$totalDebit += $value['subLedger']['debit'];
											$totalCredit += 0;
											$subTotalDebit += $value['subLedger']['debit'];
											$subTotalCredit += 0;
											$subTotal += $value['subLedger']['debit'];
									@endphp
									@if($i == 0)
									<td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
									<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
									<td align="right">{{   number_format(0,2) }}</td>
									@else
									<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
									<td align="right">{{   number_format(0,2) }}</td>
									@endif

							 </tr>
							 @endif
							@endforeach
							<tr style="background:#4ec7df;">
								@if($i == 0)
								<td>Sub Total</td>
								<td align="right">{{  number_format($subTotal,2)  }}</td>
								<td></td>
								@else
								<td align="right">{{  number_format($subTotal,2)  }}</td>
								<td></td>
								@endif

							</tr>
							@endif
							@if($val['assetPlant'])
							<tr>

								<td colspan="100%" > <span style="margin-left: 15px;">Plant & Mechineries</span></td>

							</tr>
							@php
							$subTotal = 0;
							@endphp
							@foreach ($val['assetPlant']  as $value)
							@if($value['subLedger']['debit'] != 0)

							<tr>
									@php
											$totalDebit += $value['subLedger']['debit'];
											$totalCredit += 0;
											$subTotalDebit += $value['subLedger']['debit'];
											$subTotalCredit += 0;
											$subTotal += $value['subLedger']['debit'];
									@endphp
									@if($i == 0)
									<td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
									@else

									@endif
									<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
									<td align="right">{{   number_format(0,2) }}</td>
							 </tr>
							 @endif
							@endforeach
							<tr style="background:#4ec7df;">
								@if($i == 0)
								<td>Sub Total</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotal,2)  }}</td>
								<td></td>
							</tr>
							@endif

							@if($val['assetMotor'])
							<tr>

								<td colspan="100%" > <span style="margin-left: 15px;">Motor Vehicle</span></td>

							</tr>
							@php
							$subTotal = 0;
							@endphp
							@foreach ($val['assetMotor']  as $value)
							@if($value['subLedger']['debit'] != 0)

							<tr>
									@php
											$totalDebit += $value['subLedger']['debit'];
											$totalCredit += 0;
											$subTotalDebit += $value['subLedger']['debit'];
											$subTotalCredit += 0;
											$subTotal += $value['subLedger']['debit'];
									@endphp
									@if($i == 0)
									<td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
									@else

									@endif
									<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
									<td align="right">{{   number_format(0,2) }}</td>
							 </tr>
							 @endif
							@endforeach
							<tr style="background:#4ec7df;">
								@if($i == 0)
								<td>Sub Total</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotal,2)  }}</td>
								<td></td>
							</tr>
							@endif
							@if($val['assetElectrical'])
							<tr>

								<td colspan="100%" > <span style="margin-left: 15px;">Electrical Equipment</span></td>

							</tr>
							@php
							$subTotal = 0;
							@endphp
							@foreach ($val['assetElectrical']  as $value)
							@if($value['subLedger']['debit'] != 0)

							<tr>
									@php
											$totalDebit += $value['subLedger']['debit'];
											$totalCredit += 0;
											$subTotalDebit += $value['subLedger']['debit'];
											$subTotalCredit += 0;
											$subTotal += $value['subLedger']['debit'];
									@endphp
									@if($i == 0)
									<td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
									@else

									@endif
									<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
									<td align="right">{{   number_format(0,2) }}</td>
							 </tr>
							 @endif
							@endforeach
							<tr style="background:#4ec7df;">
								@if($i == 0)
								<td>Sub Total</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotal,2)  }}</td>
								<td></td>
							</tr>
							@endif
							@if($val['assetComputer'])
							<tr>

								<td colspan="100%" > <span style="margin-left: 15px;">Computer & Software</span></td>

							</tr>
							@php
							$subTotal = 0;
							@endphp
							@foreach ($val['assetComputer']  as $value)
						

							<tr>
									@php
											$totalDebit += $value['subLedger']['debit'];
											$totalCredit += 0;
											$subTotalDebit += $value['subLedger']['debit'];
											$subTotalCredit += 0;
											$subTotal += $value['subLedger']['debit'];
									@endphp
									@if($i == 0)
									<td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
									@else

									@endif
									<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
									<td align="right">{{   number_format(0,2) }}</td>
							 </tr>

							@endforeach
							<tr style="background:#4ec7df;">
								@if($i == 0)
								<td>Sub Total</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotal,2)  }}</td>
								<td></td>
							</tr>
							@endif
							@if($val['assetFurniture'])
							<tr>

								<td colspan="100%" > <span style="margin-left: 15px;">Furniture & Fixture</span></td>

							</tr>
							@php
							$subTotal = 0;
							@endphp
							@foreach ($val['assetFurniture']  as $value)
							@if($value['subLedger']['debit'] != 0)

							<tr>
									@php
											$totalDebit += $value['subLedger']['debit'];
											$totalCredit += 0;
											$subTotalDebit += $value['subLedger']['debit'];
											$subTotalCredit += 0;
											$subTotal += $value['subLedger']['debit'];
									@endphp
									@if($i == 0)
									<td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
									@else

									@endif
									<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
									<td align="right">{{   number_format(0,2) }}</td>
							 </tr>
							 @endif
							@endforeach
							<tr style="background:#4ec7df;">
								@if($i == 0)
								<td>Sub Total</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotal,2)  }}</td>
								<td></td>
							</tr>
							@endif
							@if($val['assetOthers'])
							<tr>

								<td colspan="100%" > <span style="margin-left: 15px;">Preliminary Expanse</span></td>

							</tr>
							@php
							$subTotal = 0;
							@endphp
							@foreach ($val['assetOthers']  as $value)
							@if($value['subLedger']['debit'] != 0)

							<tr>
									@php
											$totalDebit += $value['subLedger']['debit'];
											$totalCredit += 0;
											$subTotalDebit += $value['subLedger']['debit'];
											$subTotalCredit += 0;
											$subTotal += $value['subLedger']['debit'];
									@endphp
									@if($i == 0)
									<td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
									@else

									@endif
									<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
									<td align="right">{{   number_format(0,2) }}</td>
							 </tr>
							 @endif
							@endforeach
							<tr style="background:#4ec7df;">
								@if($i == 0)
								<td>Sub Total</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotal,2)  }}</td>
								<td></td>
							</tr>
							@endif
							@if($val['assetLand'])
							<tr>

								<td colspan="100%" > <span style="margin-left: 15px;">Land & Land Development</span></td>
							
							</tr>
							@php
							$subTotal = 0;
							@endphp
							@foreach ($val['assetLand']  as $value)
							@if($value['subLedger']['debit'] != 0)

							<tr>
									@php
											$totalDebit += $value['subLedger']['debit'];
											$totalCredit += 0;
											$subTotalDebit += $value['subLedger']['debit'];
											$subTotalCredit += 0;
											$subTotal += $value['subLedger']['debit'];
									@endphp
									@if($i == 0)
									<td > <span style="margin-left: 30px;">{{ $value['subLedger']['title'] }}</span></td>
									@else

									@endif
									<td align="right">{{  number_format($value['subLedger']['debit'],2)  }}</td>
									<td align="right">{{   number_format(0,2) }}</td>
							 </tr>
							 @endif
							@endforeach
							<tr style="background:#4ec7df;">
								@if($i == 0)
								<td>Sub Total</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotal,2)  }}</td>
								<td></td>
							</tr>
							@endif

							<tr style="background:#32a259;">
								@if($i == 0)
								<td>Sub Total (Non Current Asset)</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>

							@if($val['fixedAsset'])
							<tr style="background-color:#87cfef;">
								<td colspan="100%">Fixed Asset</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['fixedAsset']  as $chartOfAccount)

							<tr style="font-size: 8px!important;">
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
											$subTotalDebit += $chartOfAccount['debit'];
											$subTotalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td class="text-nowrap">{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
							 </tr>
							@endforeach
							<tr style="background:#32a259; font-size:14px; font-weight:500;">
								@if($i == 0)
								<td>Sub Total (Fixed Asset)</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif
							@if($val['nonCurrentAsset'])
								<tr style="background-color:#87cfef; font-size:14px; font-weight:500;">
									<td colspan="100%">Non Current Asset</td>
								</tr>
								@php
								$subTotalDebit = 0;
								$subTotalCredit = 0;
								@endphp
								@foreach ($val['nonCurrentAsset']  as $chartOfAccount)

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
								<tr style="background:#32a259; font-size:14px; font-weight:500;">
									@if($i == 0)
									<td>Sub Total (Non Current Asset)</td>
									@else

									@endif
									<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
									<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
								</tr>
							@endif




							@if($val['officeAdminExp'])
							<tr style="background-color: #e1936e; font-size:14px; font-weight:500;">
								<td colspan="100%">Office & Administrative Expense</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['officeAdminExp']  as $chartOfAccount)

							<tr>
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
											$subTotalDebit += $chartOfAccount['debit'];
											$subTotalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
							 </tr>
							@endforeach
							<tr style="background:#32a259; font-size:14px; font-weight:500;">
								@if($i == 0)
								<td>Sub Total (Office & Admin Expense)</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif
							@if($val['cogsExp'])
							<tr style="background-color:#e1936e; font-size:14px; font-weight:500;">
								<!--<td colspan="100%">Cost of Goods Sold (COGS)</td>-->
								<td colspan="100%">Material Consumption</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['cogsExp']  as $chartOfAccount)

							<tr>
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
											$subTotalDebit += $chartOfAccount['debit'];
											$subTotalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
							 </tr>
							@endforeach
							<tr style="background:#32a259; font-size:14px; font-weight:500;">
								@if($i == 0)
								<td>Sub Total COGS</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif
							@if($val['directExp'])
							<tr style="background-color:#e1936e; font-size:14px; font-weight:500;">
								<td colspan="100%">Direct Expenses</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['directExp']  as $chartOfAccount)

							<tr>
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
											$subTotalDebit += $chartOfAccount['debit'];
											$subTotalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
							 </tr>
							@endforeach
							<tr style="background:#32a259; font-size:14px; font-weight:500;">
								@if($i == 0)
								<td>Sub Total (Direct Expenses)</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif
							@if($val['financialExp'])
							<tr style="background-color:#e1936e; font-size:14px; font-weight:500;">
								<td colspan="100%">Financial Expenses</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['financialExp']  as $chartOfAccount)

							<tr>
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
											$subTotalDebit += $chartOfAccount['debit'];
											$subTotalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
							 </tr>
							@endforeach
							<tr style="background:#32a259; font-size:14px; font-weight:500;">
								@if($i == 0)
								<td>Sub Total (Financial Expenses)</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif
							@if($val['sellingDistributionExpSD'])

							<tr style="background-color:#e1936e; font-size:12px; font-weight:500;">
								<td colspan="100%">Selling and Distribution Expense-SD</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['sellingDistributionExpSD']  as $chartOfAccount)

							<tr>
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
											$subTotalDebit += $chartOfAccount['debit'];
											$subTotalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
							 </tr>
							@endforeach
							<tr style="background:#32a259; font-size:11px; font-weight:500;">
								@if($i == 0)
								<td>Sub Total (Selling and Distribution Expense-SD)</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif
							@if($val['factoryOverHeadExp'])

							<tr style="background-color:#e1936e; font-size:14px; font-weight:500;">
								<td colspan="100%">Factory Over Head Expenses</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['factoryOverHeadExp']  as $chartOfAccount)

							<tr>
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
											$subTotalDebit += $chartOfAccount['debit'];
											$subTotalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
							 </tr>
							@endforeach
							<tr style="background:#32a259; font-size:13px; font-weight:500;">
								@if($i == 0)
								<td>Sub Total (Factory Over Head Expenses)</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif
							@if($val['rechearceDevelopExp'])
							<tr style="background-color:#e1936e; font-size:14px; font-weight:500;">
								<td colspan="100%">Research and Development-F</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['rechearceDevelopExp']  as $chartOfAccount)

							<tr>
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
											$subTotalDebit += $chartOfAccount['debit'];
											$subTotalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
							 </tr>
							@endforeach
							<tr style="background:#32a259; font-size:13px; font-weight:500;">
								@if($i == 0)
								<td>Sub Total (Research and Development-F)</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif

						{{--	@if($val['sellingDistributionExp'])
							<tr style="background-color:#e1936e;">
								<td colspan="100%">Selling and Distribution Expense</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['sellingDistributionExp'] as $chartOfAccount)

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
							<tr style="background:#32a259;">
								<td>Sub Total (Selling and Distribution Expense)</td>
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif --}}

							@if($val['tdsPayableExp'])
							<tr style="background-color:#e1936e; font-size:14px; font-weight:500;">
								<td colspan="100%">TDS Payble Office</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['tdsPayableExp'] as $chartOfAccount)

							<tr>
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
											$subTotalDebit += $chartOfAccount['debit'];
											$subTotalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
							 </tr>
							@endforeach
							<tr style="background:#32a259; font-size:14px; font-weight:500;">
								@if($i == 0)
								<td>Sub Total (TDS Payble Office)</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif
							@if($val['othersDirectExp'])
							<tr style="background-color:#e1936e; font-size:14px; font-weight:500;">
								<td colspan="100%">Others Direct Expense</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['othersDirectExp']  as $chartOfAccount)

							<tr>
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
											$subTotalDebit += $chartOfAccount['debit'];
											$subTotalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
							 </tr>
							@endforeach
							<tr style="background:#32a259; font-size:14px; font-weight:500;">
								@if($i == 0)
								<td>Sub Total (Others Direct Expense)</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif
							@if($val['othersExp'])
							<tr style="background-color:#e1936e; font-size:14px; font-weight:500;">
								<td colspan="100%">Others All Expense</td>
							</tr>
							@php
							$subTotalDebit = 0;
							$subTotalCredit = 0;
							@endphp
							@foreach ($val['othersExp']  as $chartOfAccount)

							<tr>
									@php
											$totalDebit += $chartOfAccount['debit'];
											$totalCredit += $chartOfAccount['credit'];
											$subTotalDebit += $chartOfAccount['debit'];
											$subTotalCredit += $chartOfAccount['credit'];
									@endphp
									@if($i == 0)
									<td>{{ $chartOfAccount['title'] }}</td>
									@else

									@endif
									<td align="right">{{  number_format($chartOfAccount['debit'],2)  }}</td>
									<td align="right">{{   number_format($chartOfAccount['credit'],2) }}</td>
							 </tr>
							@endforeach
							<tr style="background:#32a259; font-size:14px; font-weight:500;">
								@if($i == 0)
								<td>Sub Total (Others All Expense)</td>
								@else

								@endif
								<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
								<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
							</tr>
							@endif
							<tr>
								@php
										$reatinedEarning = $totalDebit - $totalCredit;
										$totalCredit+= $reatinedEarning;
								@endphp
								@if($i == 0)
								<td>Retained Earning</td>
								@else

								@endif
								<td align="right"></td>
								<td align="right">{{ number_format($reatinedEarning, 2) }}</td>
						</tr>
							</tbody>

							<tfoot>
									<tr style="background: #C641CF; font-size:14px; font-weight:500;">
										@if($i == 0)
											<td>Total</td>
											@else

											@endif
											<td align="right">{{ number_format($totalDebit, 2) }}</td>
										 <td align="right">{{ number_format($totalCredit, 2) }}</td>
									</tr>

							</tfoot>
					</table>

					</div>
					@php
					$i = 1;
					@endphp
					@endforeach
                </div><!--/.container-->
                </div><!--/.row-->
            </div>
        </div>
    </div>

<script type="text/javascript">
    function printDiv(divName) {
            alert('Please! print only maximum two months');
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
            $("#reporttable #tabel1").table2excel({
                filename: "Particular.xls"
            });
            
            $("#reporttable #tabel2").table2excel({
                filename: "Particular_2.xls"
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
