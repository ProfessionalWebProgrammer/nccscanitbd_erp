@extends('layouts.account_dashboard')
@section('print_menu')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      
        <!-- Main content -->
        <div class="content px-4 ">
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
            <div class="container-fluid"  id="contentbody">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Bank Book From {{ date('d F Y', strtotime($fdate)) }} To
                            {{ date('d F Y', strtotime($tdate)) }}</h5>
                        <hr>
                    </div>

                    <table id="" class="table table-bordered table-striped" style="font-size: 15px;">
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
                          $si = 0;
                                
                            @endphp

                          
                          @foreach ($allMainBanks as $mainbank)
                           @php
                                $stopb = 0;
                                $strcv = 0;
                                $stpmt = 0;
                                $stclb = 0;
                           $getbanks = DB::table('master_banks')->where('main_bank_id',$mainbank->id)->orderBy('bank_name', 'asc')->get();
                                
                            @endphp

                           <tr>
                                        
                                          <td colspan="100%" style="font-weight:bold; color:red">{{ $mainbank->name }}</td>
                                      </tr>
                          
                          
                          
                                 @foreach ($getbanks as $bank_list)
                                      @php

                                          $bank_name = $bank_list->bank_name;

                                          $oprcv = \App\Models\Payment::where('bank_id', $bank_list->bank_id)
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

                                          $clb = $opb + $totalrcv - $totalpay;

                                          $topb += $opb;
                                          $trcv += $totalrcv;
                                          $tpmt += $totalpay;
                                          $tclb += $clb;
                          
                           					$stopb += $opb;
                                          $strcv += $totalrcv;
                                          $stpmt += $totalpay;
                                          $stclb += $clb;
                          
                          $si = $si+1;

                                      @endphp
                                      <tr>
                                          <td>{{ $si }}</td>
                                          <td>{{ $bank_name }} @if($totaltrpay || $totaltrrcv) <span style="color:red"> (Transfer) </span> @endif </td>
                                          <td align="right">{{ number_format($opb) }}</td>
                                          <td align="right">{{ number_format($totalrcv) }}</td>
                                          <td align="right">{{ number_format($totalpay) }}</td>
                                          <td align="right">{{ number_format($clb) }}</td>
                                      </tr>
                                  @endforeach
                           <tr>
                                <td></td>
                                <td style="font-weight:bold">SubTotal</td>

                                <td style="font-weight:bold" align="right">{{ number_format($stopb) }}</td>
                                <td style="font-weight:bold" align="right">{{ number_format($strcv) }}</td>
                                <td style="font-weight:bold" align="right">{{ number_format($stpmt) }}</td>
                                <td style="font-weight:bold" align="right">{{ number_format($stclb) }}</td>
                            </tr>
                          
                            @endforeach
                          
                          
                          
                           
                            @foreach ($allBanks as $bank_list)
                                @php
                                    
                                    $bank_name = $bank_list->bank_name;
                                    
                                    $oprcv = \App\Models\Payment::where('bank_id', $bank_list->bank_id)
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
                                    
                                    $clb = $opb + $totalrcv - $totalpay;
                                    
                                    $topb += $opb;
                                    $trcv += $totalrcv;
                                    $tpmt += $totalpay;
                                    $tclb += $clb;
                          
                          $si = $si+1;
                                    
                                @endphp
                                <tr>
                                    <td>{{ $si }}</td>
                                    <td>{{ $bank_name }} @if($totaltrpay || $totaltrrcv) <span style="color:red"> (Transfer) </span> @endif </td>
                                    <td align="right">{{ number_format($opb) }}</td>
                                    <td align="right">{{ number_format($totalrcv) }}</td>
                                    <td align="right">{{ number_format($totalpay) }}</td>
                                    <td align="right">{{ number_format($clb) }}</td>
                                </tr>
                            @endforeach
                            
                            <tr>
                                <td></td>
                                <td style="font-weight:bold">Total</td>

                                <td style="font-weight:bold" align="right">{{ number_format($topb) }}</td>
                                <td style="font-weight:bold" align="right">{{ number_format($trcv) }}</td>
                                <td style="font-weight:bold" align="right">{{ number_format($tpmt) }}</td>
                                <td style="font-weight:bold" align="right">{{ number_format($tclb) }}</td>
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
                filename: "Bankbook.xls"
            });
        });
    });
</script>
@endsection
