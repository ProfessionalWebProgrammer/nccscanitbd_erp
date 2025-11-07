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
                                <tr style="background: #FA621C; color: #fff;">
                                    <th>Head </th>
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

														@if($accrudeExpenses)
														<tr style="background-color:#e44949;">
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
														<tr style="background-color:#87cfef;">
															<td colspan="100%">Current Asset</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($currentAsset  as $chartOfAccount)

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
															<td>Sub Total (Current Asset)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($fixedAsset)
														<tr style="background-color:#87cfef;">
															<td colspan="100%">Fixed Asset</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($fixedAsset  as $chartOfAccount)

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
															<td>Sub Total (Fixed Asset)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($nonCurrentAsset)
															<tr style="background-color:#87cfef;">
																<td colspan="100%">Non Current Asset</td>
															</tr>
															@php
															$subTotalDebit = 0;
															$subTotalCredit = 0;
															@endphp
	                            @foreach ($nonCurrentAsset  as $chartOfAccount)

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
																<td>Sub Total (Non Current Asset)</td>
																<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
																<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
															</tr>
														@endif
														@if($otherFixedAsset)
														<tr style="background-color:#87cfef;">
															<td colspan="100%">Others Fixed Asset</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($otherFixedAsset  as $chartOfAccount)

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
															<td>Sub Total (Others Fixed Asset)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif

													{{--	@if($buildingFixedAsset)
														<tr style="background-color:#87cfef;">
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
														<tr style="background-color: #e1936e;">
															<td colspan="100%">Office & Administrative Expense</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($officeAdminExp  as $chartOfAccount)

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
															<td>Sub Total (Office & Administrative Expense)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($cogsExp)
														<tr style="background-color:#e1936e;">
															<td colspan="100%">Cost of Goods Sold (COGS)</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($cogsExp  as $chartOfAccount)

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
															<td>Sub Total COGS</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($directExp)
														<tr style="background-color:#e1936e;">
															<td colspan="100%">Direct Expenses</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($directExp  as $chartOfAccount)

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
															<td>Sub Total (Direct Expenses)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($financialExp)
														<tr style="background-color:#e1936e;">
															<td colspan="100%">Financial Expenses</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($financialExp  as $chartOfAccount)

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
															<td>Sub Total (Financial Expenses)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($sellingDistributionExpSD)

														<tr style="background-color:#e1936e;">
															<td colspan="100%">Selling and Distribution Expense-SD</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($sellingDistributionExpSD  as $chartOfAccount)

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
															<td>Sub Total (Selling and Distribution Expense-SD)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($factoryOverHeadExp)

														<tr style="background-color:#e1936e;">
															<td colspan="100%">Factory Over Head Expenses</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($factoryOverHeadExp  as $chartOfAccount)

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
															<td>Sub Total (Factory Over Head Expenses)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($rechearceDevelopExp)
														<tr style="background-color:#e1936e;">
															<td colspan="100%">Research and Development-F</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($rechearceDevelopExp  as $chartOfAccount)

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
															<td>Sub Total (Research and Development-F)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif

														@if($sellingDistributionExp)
														<tr style="background-color:#e1936e;">
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
														<tr style="background:#32a259;">
															<td>Sub Total (Selling and Distribution Expense)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($tdsPayableExp)
														<tr style="background-color:#e1936e;">
															<td colspan="100%">TDS Payble Office</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($tdsPayableExp as $chartOfAccount)

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
															<td>Sub Total (TDS Payble Office)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($othersDirectExp)
														<tr style="background-color:#e1936e;">
															<td colspan="100%">Others Direct Expense</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($othersDirectExp  as $chartOfAccount)

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
															<td>Sub Total (Others Direct Expense)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
														@if($othersExp)
														<tr style="background-color:#e1936e;">
															<td colspan="100%">Others All Expense</td>
														</tr>
														@php
														$subTotalDebit = 0;
														$subTotalCredit = 0;
														@endphp
                            @foreach ($othersExp  as $chartOfAccount)

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
															<td>Sub Total (Others All Expense)</td>
															<td align="right">{{  number_format($subTotalDebit,2)  }}</td>
															<td align="right">{{  number_format($subTotalCredit,2)  }}</td>
														</tr>
														@endif
                            </tbody>

                            <tfoot>
                                <tr style="background: #C641CF; color: #fff;">
                                    <td>Total</td>
                                    <td align="right">{{ number_format($totalDebit, 2) }}</td>
                                   <td align="right">{{ number_format($totalCredit, 2) }}</td>
                                </tr>

                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


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
</script>

@endsection
