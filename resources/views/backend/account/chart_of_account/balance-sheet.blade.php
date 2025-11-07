@extends('layouts.account_dashboard')

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
    <div class="content-wrapper" style="padding-bottom: 100px;">

        <!-- Main content -->
        <div class="content px-4 ">

            <div class="container-fluid" id="contentbody">
 				<div class="row pt-5">
                  	<div class="col-md-3 text-left">
                      <h5 class="text-uppercase font-weight-bold">Balance Sheet</h5>
                      <p>{{$tdate}}</p>

                    </div>
                  	<div class="col-md-6 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
              <hr>

                <div class="py-4 container" style="padding-top: 31px !important; padding-bottom: 31px !important;">
				              <div class="row">
                    <div class=" col-md-12 table-responsive">
                      <h3>Assets</h3>
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="table-layout: inherit;">
                            <thead >
                                <tr style="font-size:20px;">
                                    <th>Particulars </th>
                                    <th align="right" style="text-align:right;">Amount</th>
                                </tr>
                          </thead>
                            <tbody>
                                @php
                                    $totalCurrentBalance = 0;
                                    $totalFixedBalance = 0;
                                    $advanceAmount = 0;
                                    $purchaseAmount = 0; 
                                @endphp
                            <!--<tr class="text-black" style="font-size:20px;">-->
                            <!--  <th colspan="2">Current Assets</th>-->
                            <!--</tr>-->
                            @foreach($currentAssets as $key => $asset)
                            @php
                                 $totalCurrentBalance += $asset['debit'];
                            @endphp

                            @if($asset['title'] != 'Accounts Receivable (Dealer)' && $asset['title'] != 'Bank' && $asset['title'] != 'Cash' && $asset['title'] != 'Purchase')
                              @php
                                $advanceAmount += $asset['debit'];
                              @endphp
                            @elseif($asset['title'] == 'Purchase')
                            @php 
                            $purchaseAmount = $asset['debit'];
                            @endphp 
                            @else
                             <tr>
                                <th><span style="margin-left: 15px;"> {{ $asset['title'] }}</span></th>
                                <td align="right">{{ number_format($asset['debit'],2)}}</td>
                             </tr>
                             @endif
                             @endforeach
                             <tr>
                               <th><span style="margin-left: 15px;">Advance, Deposit & Pre-Payment</span></th>
                               <td align="right">{{ number_format($advanceAmount,2)}}</td>
                             </tr>
                             <!-- <tr>
                               <th colspan="100%">Inventory(FG)</th>
                             </tr> -->
                             <tr>
                                 <th><span style="margin-left: 15px;">Inventory(RM & PM)</span></th>
                                 <td align="right">{{ number_format($purchaseAmount,2)}}</td>
                             </tr>
                             @php
                             $totalInventory = 0;
                             @endphp
                             @foreach($fgInventoryInfo as $value)
                             @php
                                  $totalCurrentBalance += $value['debit'];
                                  $totalInventory += $value['debit'];
                             @endphp
                            {{--   @if($value['debit'] != 0)
                               <tr>
                                  <th> <span style="margin-left: 15px;">{{ $value['title'] }}</span></th>
                                  <td align="right">{{ number_format($value['debit'],2)}}</td>
                               </tr>
                               @endif --}}
                             @endforeach
                             <tr>
                               <th><span style="margin-left: 15px;">Inventory (FG): </span></th>
                               <td align="right">{{ number_format($totalInventory,2)}}</td>
                             </tr>
                             <tr style="color:black; font-size:20px;">
                                <th>Total Current Assets</th>
                                <th style="text-align:right;">{{  number_format($totalCurrentBalance,2) }}</th>
                             </tr>
                            <!-- <tr style="font-size:20px;">-->
                            <!--    <th colspan="2">Noncurrent Assets</th>-->
                            <!--</tr>-->


                             @foreach($accountNonCurrentAssetInfo as $asset)
                             @php
                                $totalFixedBalance += $asset['debit'];
                             @endphp
                            {{-- <tr>
                               <th> <span style="margin-left: 15px;">{{ $asset['title'] }}</span></th>
                               <td align="right">{{ number_format($asset['debit'],2) }}</th>

                             </tr> --}}
                             @endforeach
                             {{-- <tr >
                                <th ><span style="margin-left: 15px;">Noncurrent Assets </span></th>
                                <td align="right">{{ number_format($totalFixedBalance,2) }}</th>
                            </tr> 
                             <tr>
                               <th><span style="margin-left: 15px;">Accumulated Depreciation </span></th>
                               <th style="text-align:right;">{{number_format($accumulatedAmount,2)}}</th>
                             </tr> --}}
                             <tr class="text-black" style="color:black; font-size:20px;" >
                                <th>Total Noncurrent Assets</th>
                                <th style="text-align:right;">{{  number_format($totalFixedBalance - $accumulatedAmount,2) }}</th>
                             </tr>
                            </tbody>

                            <tfoot>
                                <tr style=" color:#000; font-size:20px; font-weight:bold;">
                                    <th>Grand Total</th>
                                    <td align="right">{{ number_format(($totalCurrentBalance + ($totalFixedBalance - $accumulatedAmount)),2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @php
                    $totalAsset = $totalCurrentBalance + ($totalFixedBalance - $accumulatedAmount);
                    $totalCurrentBalanceOfLiability = 0;
                    $totalFixedBalanceOfLiability = 0;
                    $totalEquityOfLiability = 0;
                    foreach ($currentLiabilities as $liabilty){
                      $totalCurrentBalanceOfLiability += $liabilty['credit'];
                    }

                    foreach ($fixedLiabilities as $liabilty){
                      $totalFixedBalanceOfLiability += $liabilty['credit'];
                    }

                    foreach ($equities as $equity){
                      $totalEquityOfLiability += $equity['credit'];
                    }
                      $totalLiability = $totalCurrentBalanceOfLiability + $totalFixedBalanceOfLiability + $totalEquityOfLiability;
                      $adjustAccrudeExpense = $totalAsset - $totalLiability;

                    @endphp
                   <div class=" col-md-12 table-responsive">
                      <h3>Liabilities And Equity </h3>
                        <table id="reporttable" class="table table-bordered table-striped table-fixed"
                            style="table-layout: inherit;">
                            <thead style="background:#fff; color: #000;">
                                <tr style="font-size:20px;">
                                    <th>Particulars </th>
                                    <th align="right" style="text-align:right;">Amount</th>

                                </tr>
                          </thead>
                          <tbody>
                            @php
                                $totalCurrentBalanceOfLiability = 0;
                                $totalFixedBalanceOfLiability = 0;
                                $totalEquityOfLiability = 0;
                            @endphp
                            <tr class="text-black" style="font-size:20px;">
                                <th colspan="2">Current Liabilities</th>
                            </tr>
                            @foreach($currentLiabilities as $liabilty)
                            @php
                                $totalCurrentBalanceOfLiability += $liabilty['credit'];
                             @endphp

                              <tr>
                                <th><span style="margin-left: 15px;">{{ $liabilty['title'] }}</span></th>
                                <td align="right">{{ number_format($liabilty['credit'],2)}}</td>
                             </tr>
                          {{--   @endif --}}

                            @endforeach
                            <tr class="text-black" style="color:black;font-size:20px;">
                                <th>Total Current Liabilities</th>
                                <th style="text-align:right;">{{  number_format($totalCurrentBalanceOfLiability,2) }}</th>
                             </tr>
                             @if($fixedLiabilities)
                             <tr class=" text-black" style="font-size:20px;">
                                <th colspan="2">Noncurrent Liabilities</th>
                            </tr>
                            @foreach($fixedLiabilities as $liabilty)
                            @php
                                $totalFixedBalanceOfLiability += $liabilty['credit'];
                             @endphp
                              <tr>
                                <th><span style="margin-left: 15px;">{{ $liabilty['title'] }}</span></th>
                                <td align="right">{{ number_format($liabilty['credit'],2)}}</td>
                             </tr>

                            @endforeach

                            <tr class="text-black" style="color:black; font-size:20px;">
                                <th>Total Noncurrent Liabilities</th>
                                <th style="text-align:right;">{{  number_format($totalFixedBalanceOfLiability,2) }}</th>
                             </tr>
                             @endif
                             <tr class=" text-black" style="font-size:20px;">
                                <th colspan="2">Equity</th>
                            </tr>

                            @foreach($equities as $equity)
                            @php
                                $totalEquityOfLiability += $equity['credit'];
                             @endphp
                             @if($equity['title'] == 'Retained Earning')
                             @php
                                 $totalEquityOfLiability += $adjustAccrudeExpense;
                                 $currentRetainedEarning = ($equity['credit'] +  $adjustAccrudeExpense);
                              @endphp
                              <tr>
                                <th > <span style="margin-left: 15px;">{{ $equity['title'] }}</span></th>
                                <td align="right">{{ number_format(($equity['credit'] +  $adjustAccrudeExpense),2)}}</td>
                             </tr>
                              @else
                              <tr>
                                <th ><span style="margin-left: 15px;">{{ $equity['title'] }}</span></th>
                                <td align="right">{{ number_format($equity['credit'],2)}}</td>
                             </tr>
                             @endif
                            @endforeach
                            <tr class="text-black" style="color:black; font-size:20px;">
                                <th>Total Equity & Retained Earning</th>
                                <th style="text-align:right;">{{  number_format($totalEquityOfLiability,2) }}</th>
                             </tr>


 						               </tbody>
                           <tfoot>
                                <tr style=" color:#000; font-weight:bold;font-size:20px;">
                                    <th> Grand Total: </th>
                                    <td align="right">{{number_format($totalCurrentBalanceOfLiability + $totalFixedBalanceOfLiability + $totalEquityOfLiability,2) }}</td>
                                </tr>
                                @foreach($retainedEarningNote as $retEanVal)
                                <tr>
                                  <td colspan="100%">Note (Retained Earning) </td>
                                </tr>
                                @php
                                $retainedEarning = $currentRetainedEarning - ($retEanVal['opening'] + $retEanVal['openingPl']);
                                @endphp

                                <tr>
                                  <td><span style="margin-left: 15px;">Retained Earning Opening</span></td>
                                  <td style="text-align:right;">{{  number_format(($retEanVal['opening'] + $retainedEarning),2) }} </td>
                                </tr>


                                <tr>

                                  <td><span style="margin-left: 15px;">Current Month Profit or Loss</span></td>
                                  <td style="text-align:right;">{{  number_format($retEanVal['openingPl'],2) }}</td>
                                </tr>

                                @endforeach
                            </tfoot>
                        </table>
                    </div>
                  </div>

                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        $(document).ready(function() {

            $("#products_id").on('change', function() {

                var product_id = $(this).val();

                alert(product_id);

                $.ajax({
                    url: '{{ url('/scale/data/get/') }}/' + id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);



                        $("#data").val(data.date);
                        $("#vehicle").val(data.vehicle);
                        $("#supplier_chalan_qty").val(data.chalan_qty).attr('readonly',
                            'readonly');
                        $("#receive_quantity").val(data.actual_weight).attr('readonly',
                            'readonly');

                        $("#supplier_id").val(data.supplier_id);
                        $("#wirehouse").val(data.warehouse_id);
                        $("#product_id").val(data.rm_product_id);

                        $('.select2').select2({
                            theme: 'bootstrap4'
                        })

                    }
                });


                calculation();


            });
        });
    </script> --}}


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
                filename: "Balance_sheet.xls"
            });
        });
    });
</script>

@endsection
