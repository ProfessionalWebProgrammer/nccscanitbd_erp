@extends('layouts.account_dashboard')

@push('addcss')
    <style>
    
        .text_sale {
            color: #f7ee79;
        }

        .text_credit {
            color: lime;
        }
        #reporttable .table th,   #reporttable .table td{
          color: #000;
        }
        .comBalanceSheetReports .table tr, .comBalanceSheetReports .table tr td, .comBalanceSheetReports .table tr th{
            color: #000 !important;
        }
        
    </style>
@endpush

@section('print_menu')

			<li class="nav-item">
				<div class="text-right">
                      <button class="btn btn-xs  btn-success mr-1 mt-2" id="btnExport"  >
                       Export
                    </button>
                    <button class="btn btn-xs  btn-warning mt-2"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>
            </li>
@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >

        <!-- Main content -->
        <div class="content px-4 ">

            <div class="container-fluid comBalanceSheetReports" id="contentbody">
                <div class="">
 				<div class="row pt-5">
                  	<div class="col-md-12 text-left">
                      <h5 class="text-uppercase font-weight-bold">Compared Balance Sheet</h5>
                      {{-- <p>{{date('d F, Y',strtotime($tdate))}}</p> --}}

                    </div>
                  	<div class="col-md-12 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
              <hr>

                <div id="reporttable">
				              <div class="row" >
                        @php  $i = 0; @endphp
                        @foreach($information as $key => $val)
                    <div class=" @if($i == 0) col-md-5 @else col-md-2 @endif table-responsive" style="@if($i == 0) width: 66.666667%; @else width: 33.333333%; @endif">

                        <table class="table table-bordered table-striped table-fixed"
                            style="font-size:15px;table-layout: inherit;">
                            <thead>
                              <tr style="background:#fff !important; color: #000;">
                                @if($i == 0)
    														<th colspan="2" style="text-align:center;"> Assets - The Month of {{ $val['month']}}</th>
                                @else
                                <th colspan="1" style="text-align:center;"> The Month of {{ $val['month']}}</th>
                                @endif


    													</tr>

                                <tr style="background:#dee2e6 !important; color: #000;" style="font-size:14px;">
                                  @if($i == 0)
                                    <th width="60%" >Particular </th>
                                    @else

                                    @endif
                                    <th  width="40%" style="text-align:right;">Amount</th>

                                </tr>
                          </thead>
                            <tbody>
                                @php
                                    $totalCurrentBalance = 0;
                                    $totalFixedBalance = 0;
                                @endphp
                            <tr style="background:#fff !important; color: #000;">
                              <th colspan="100%">Current Assets</th>
                            </tr>
                            @foreach($val['currentAssets'] as $key => $asset)
                            @php
                                 $totalCurrentBalance += $asset['debit'];
                            @endphp

                             <tr>
                               @if($i == 0)
                                <th>@if($asset['title'] == 'Purchase') Inventory(RM & PM) @else {{ $asset['title'] }} @endif</th>
                                @else

                                @endif
                                <td align="right">{{ number_format($asset['debit'],2)}}</td>

                             </tr>
                             @endforeach
                             @foreach($val['currentAssets2'] as $currentAsset)
                                    @php
                                        $totalCurrentBalance += $currentAsset['debit'];
                                    @endphp
    
                                 <tr style="font-size:12px; font-weight:bold;">
                                   @if($i == 0)
                                    <th> {{ $currentAsset['title'] }} </th>
                                    @else
    
                                    @endif
                                    <td align="right">{{ number_format($currentAsset['debit'],2)}}</td>
    
                                 </tr>
                             @endforeach
                             <tr style="color:black">
                               @if($i == 0)
                                <th>Total Current Assets</th>
                                @else

                                @endif
                                <th style="text-align:right;">{{  number_format($totalCurrentBalance,2) }}</th>

                             </tr>
                             <tr>
                                <th colspan="100%">Non Current Assets</th>
                            </tr>


                             @foreach($val['fixedAssets'] as $keyTwo => $asset)
                             @php
                                $totalFixedBalance += $asset['debit'];
                             @endphp
                              {{--  <tr>
                                    <th>{{ $asset['title'] }}</th>
                                   <td align="right">{{ $asset['title'] == 'Assets' ? number_format($asset['debit'] - $val['accumulatedAmount'],2) : $asset['debit']}}</td>
                                </tr> --}}
                             @endforeach
                             <tr>
                               @if($i == 0)
                               <th>Non Current Assets</th>
                               @else

                               @endif
                               <th style="text-align:right;">{{number_format($totalFixedBalance,2)}}</th>
                             </tr>
                             <tr>
                               @if($i == 0)
                               <th>Accumulated Depreciation</th>
                               @else

                               @endif
                               <th style="text-align:right;">{{number_format($val['accumulatedAmount'],2)}}</th>
                             </tr>
                             <tr style="color:black">
                               @if($i == 0)
                                <th>Total Noncurrent Assets</th>
                                @else

                                @endif
                                <th style="text-align:right;">{{  number_format($totalFixedBalance - $val['accumulatedAmount'],2) }}</th>
                             </tr>
                            </tbody>

                            <tfoot>
                                <tr style="font-weight:bold;">
                                  @if($i == 0)
                                    <th>Grand Total</th>
                                    @else

                                    @endif
                                    <td align="right">{{ number_format(($totalCurrentBalance + ($totalFixedBalance - $val['accumulatedAmount'])),2) }}</td>
                                </tr>
                            </tfoot>
                        </table>

                    @php
                    $totalAsset = $totalCurrentBalance + ($totalFixedBalance - $val['accumulatedAmount']);
                    $totalCurrentBalanceOfLiability = 0;
                    $totalFixedBalanceOfLiability = 0;
                    $totalEquityOfLiability = 0;
                    foreach ($val['currentLiabilities'] as $liabilty){
                      $totalCurrentBalanceOfLiability += $liabilty['credit'];
                    }

                    foreach ($val['fixedLiabilities'] as $liabilty){
                      $totalFixedBalanceOfLiability += $liabilty['credit'];
                    }

                    foreach ($val['equities'] as $equity){
                      $totalEquityOfLiability += $equity['credit'];
                    }
                      $totalLiability = $totalCurrentBalanceOfLiability + $totalFixedBalanceOfLiability + $totalEquityOfLiability;
                      $adjustAccrudeExpense = $totalAsset - $totalLiability;

                    @endphp

                      <h5>Liabilities And Equity </h5>
                        <table  class="table table-bordered table-striped table-fixed"
                            style="font-size: 15px;table-layout: inherit;">
                            <thead>
                                <tr style="background:#fff !important; color: #000;font-size:14px;">
                                  @if($i == 0)
                                    <th>Head </th>
                                    @else

                                    @endif
                                    <th style="text-align:right">Amount</th>
                                </tr>
                          </thead>
                          <tbody>
                            @php
                                $totalCurrentBalanceOfLiability = 0;
                                $totalFixedBalanceOfLiability = 0;
                                $totalEquityOfLiability = 0;
                            @endphp
                            <tr>
                                <th colspan="100%">Current Liabilities</th>
                            </tr>
                            @foreach($val['currentLiabilities'] as $liabilty)
                            @php
                                $totalCurrentBalanceOfLiability += $liabilty['credit'];
                             @endphp

                              <tr>
                                @if($i == 0)
                                <th>{{ $liabilty['title'] }}</th>
                                @else

                                @endif
                                <td align="right">{{ number_format($liabilty['credit'],2)}}</td>
                             </tr>
                          {{--   @endif --}}

                            @endforeach
                            <tr style="color:black">
                              @if($i == 0)
                                <th>Total Current Liabilities</th>
                                @else

                                @endif
                                <th style="text-align:right;">{{  number_format($totalCurrentBalanceOfLiability,2) }}</th>
                             </tr>
                             <tr>
                                <th colspan="100%">Noncurrent Liabilities</th>
                            </tr>
                            @foreach($val['fixedLiabilities'] as $liabilty)
                            @php
                                $totalFixedBalanceOfLiability += $liabilty['credit'];
                             @endphp
                              <tr>
                                @if($i == 0)
                                <th>{{ $liabilty['title'] }}</th>
                                @else

                                @endif
                                <td align="right">{{ number_format($liabilty['credit'],2)}}</td>
                             </tr>

                            @endforeach

                            <tr style="color:black">
                              @if($i == 0)
                                <th>Total Noncurrent Liabilities</th>
                                @else

                                @endif
                                <th style="text-align:right;">{{  number_format($totalFixedBalanceOfLiability,2) }}</th>
                             </tr>
                             <tr>
                                <th colspan="100%">Equity</th>
                            </tr>
                            @foreach($val['equities'] as $equity)
                            @php
                                $totalEquityOfLiability += $equity['credit'];
                             @endphp
                             @if($equity['title'] == 'Retained Earning')
                             @php
                                 $totalEquityOfLiability += $adjustAccrudeExpense;
                              @endphp
                              <tr>
                                @if($i == 0)
                                <th >{{ $equity['title'] }}</th>
                                @else

                                @endif
                                <td align="right">{{ number_format(($equity['credit'] +  $adjustAccrudeExpense),2)}}</td>
                             </tr>
                              @else
                              <tr>
                                @if($i == 0)
                                <th >{{ $equity['title'] }}</th>
                                @else

                                @endif
                                <td align="right">{{ number_format($equity['credit'],2)}}</td>
                             </tr>
                             @endif
                            @endforeach
                            <tr style="color:black">
                              @if($i == 0)
                                <th>Total Equity & Retained Earning</th>
                                @else

                                @endif
                                <th style="text-align:right;">{{  number_format($totalEquityOfLiability,2) }}</th>
                             </tr>
 						                    </tbody>
                           <tfoot>
                                <tr style="font-weight:bold;">
                                  @if($i == 0)
                                    <th> Grand Total: </th>
                                    @else

                                    @endif
                                    <td align="right">{{number_format($totalCurrentBalanceOfLiability + $totalFixedBalanceOfLiability + $totalEquityOfLiability,2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @php
                    $i = 1;
                    @endphp
                    @endforeach
                  </div>

                </div>
            </div><!--/.container-->
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
            $("#reporttable").table2excel({
                filename: "Balance_sheet.xls"
            });
        });
    });
</script>

@endsection
