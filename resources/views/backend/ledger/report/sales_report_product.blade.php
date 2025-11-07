@extends('layouts.sales_dashboard')

@push('addcss')
<style>
    .text_sale {
        color: #1fb715;
    }

    .text_credit {
        color: #5a6eff;
    }

    .tableFixHead {
        overflow: auto;
        height: 600px;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .table,
    .table td {
        padding: 5px 10px;
    }

    .nav-sidebar .nav-item>.nav-link {
        color: #52CD9F !important;
    }
</style>
@endpush

@section('header_menu')
<li class="nav-item">
    <button class="btn btn-sm  btn-success mt-1" id="btnExport">
        Export
    </button>
</li>
<li class="nav-item ml-1">
    <button class="btn btn-sm  btn-warning mt-1" onclick="printDiv('reporttable')" id="printbtn">
        Print
    </button>
</li>
@endsection


@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="contentbody" {{--style="background:#fff !important;color:#000"--}}>

    <!-- Main content -->
    <div class="content px-4 ">
        <div class="container-fluid" >
            <div class="pb-5">

                <div class="table-responsive tableFixHead pb-5  pr-2 " id="reporttable">
                    <div class="text-center pt-3" style=" margin-bottom:10px; border:2px solid #000;">

                        <div class="row mb-4">
                            <div class="col-md-4 text-left align-middle pl-3">
                              	<h5 style="font-weight: 800;">Sales Report</h5>
                                <h6 style="font-weight: 800;" class="mt-3">From {{ date('d F Y', strtotime($fdate)) }}
                                    To
                                    {{ date('d F Y', strtotime($tdate)) }}
                                </h6>
                            </div>
                            <div class="col-md-4 mt-3 text-center align-middle">
                                <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    			         <p>Head office, Rajshahi, Bangladesh</p>
                            </div>

                        </div>
                        <table class="table table-bordered p-2" style="font-size: 11px;font-weight: 600; border:2px solid; ">
                            <thead>
                              <tr class="text-center ">
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Product</th>
                                <th colspan="2">UMO</th>
                                <th>Rate</th>
                                <th>Target</th>
                                <th>Amount (Achievement)</th>
                                <th>Percentage</th>
                              </tr>
                            </thead>

                            <tbody style="font-size: 11px;">
                                @php
                                  $grand_total = 0;
                                  $totalTarget = 0;
                                  $totalAchive = 0;
                                @endphp

                                @foreach ($zones as $val)
                                @php

                                  $regions = \App\Models\SalesLedger::select('region_id as id','t1.subzone_title as name')
                                                  ->leftjoin('dealer_subzones as t1','sales_ledgers.region_id','=','t1.id')
                                                  ->where('sales_ledgers.zone_id', $val->id)->whereIn('product_id',$product_id)
                                                  ->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('region_id')->get();
                                  $regionSubTotal = 0;
                                  $regionTarget = 0;
                                  $regionAchive = 0;
                                @endphp

                                <tr>
                                    <td colspan="100%"  style="text-align: left; color: #0606b7; font-size: 16px; font-weight:600;">Zone:  {{ $val->zone_title ?? ''}}</td>
                                </tr>
                                @if(count($regions) > 0)
                                  @foreach ($regions as $key => $val)
                                      @php

                                      $areas = \App\Models\SalesLedger::select('sales_ledgers.area_id as id','t1.area_title as name')
                                                      ->leftjoin('dealer_areas as t1','sales_ledgers.area_id','=','t1.id')
                                                      ->where('sales_ledgers.region_id', $val->id)->whereIn('product_id',$product_id)
                                                      ->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('sales_ledgers.area_id')->get();
                                        $areaSubTotal = 0;
                                        $areaTarget = 0;
                                        $areaAchive = 0;
                                      @endphp
                                      <tr>
                                        <td colspan="100%" style="text-align: left; color: #0642af; font-size: 14px; font-weight:600;">Region: {{$val->name ?? ''}}</td>
                                      </tr>
                                        @foreach ($areas as $key => $val)
                                        @php
                                        $dealerDatas = \App\Models\SalesLedger::select('sales_ledgers.vendor_id as id','t1.d_s_name as name','t1.monthly_target')
                                                        ->leftjoin('dealers as t1','sales_ledgers.vendor_id','=','t1.id')
                                                        ->where('sales_ledgers.area_id', $val->id)->whereIn('product_id',$product_id)
                                                        ->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('sales_ledgers.vendor_id')->get();
                                        $DealerSubTotal = 0;
                                        $dealerTarget = 0;
                                        $dealerAchive = 0;
                                        @endphp
                                        <tr>
                                          <td colspan="100%" style="text-align: left; color: #8b1ba9; font-size: 13px; font-weight:600;">Area: {{$val->name ?? ''}}</td>
                                        </tr>
                                        @foreach ($dealerDatas as $key => $val)
                                            @php
                                              $products = \App\Models\SalesLedger::where('sales_ledgers.vendor_id', $val->id)->whereIn('product_id',$product_id)
                                                          ->whereBetween('ledger_date' ,[$fdate,$tdate])->get();
                                              $subTotal = 0;
                                              $target = $val->monthly_target;
                                              $dealerTarget += $val->monthly_target;
                                              $areaTarget += $val->monthly_target;
                                              $regionTarget += $val->monthly_target;
                                              $totalTarget += $val->monthly_target;
                                            @endphp
                                            <tr>
                                              <td colspan="100%" style="text-align: left; color: #d90565; font-size: 13px; font-weight:500;">Dealer: {{$val->name ?? ''}}</td>
                                            </tr>
                                            @foreach ($products as $key => $val)
                                              @php
                                              $temp = $val->total_price + $val->discount_amount;
                                              $regionSubTotal += $temp;
                                              $subTotal += $temp;
                                              $DealerSubTotal += $temp;
                                              $areaSubTotal += $temp;
                                              $grand_total += $temp;
                                              @endphp
                                              @if($val->total_price > 0)
                                              <tr>
                                                <td>{{date('d-m-y', strtotime($val->ledger_date))}}</td>
                                                <td>{{$val->invoice}}</td>
                                                <td>{{ $val->product_name }}</td>
                                                <td>{{ $val->qty_kg }} {{$val->product->weightUnit->unit_name ?? ''}}</td>
                                                <td>{{ $val->qty_pcs }}  {{$val->product->unit->unit_name ?? ''}}</td>
                                                <td>{{ number_format($val->unit_price,2) }}</td>
                                                <td></td>

                                                <td style="text-align: right;">{{ number_format($val->total_price + $val->discount_amount, 2) }}</td>
                                                <td></td>
                                              </tr>
                                              @endif
                                        @endforeach
                                        {{-- foreach Product End --}}
                                        @php
                                         // $achive = (($dealerTarget - $subTotal)/$dealerTarget)*100;
                                          $achive = (($subTotal*100)/$dealerTarget);
                                          $dealerAchive += $achive;
                                          $areaAchive += $achive;
                                          $regionAchive += $achive;
                                          $totalAchive += $achive;
                                        @endphp
                                        <tr style="background-color: #d90565; font-size: 16px;">
                                          <td colspan="6" style="text-align: left;">Sub Total: </td>
                                          <td style="text-align: right;">{{number_format($target,2)}}</td>
                                          <td  style="text-align: right;"> {{number_format($subTotal,2)}} </td>
                                          <td style="text-align: right;"> {{number_format($achive,2)}} %</td>
                                        </tr>
                                        @endforeach
                                        {{-- foreach Dealer End --}}
                                        <tr style="background-color: #d2a565; font-size: 16px;">
                                          <td colspan="6" style="text-align: left;">Dealer Sub Total: </td>
                                          <td style="text-align: right;">{{number_format($dealerTarget,2)}}</td>
                                          <td  style="text-align: right;"> {{number_format($DealerSubTotal,2)}} </td>
                                          <td style="text-align: right;"> {{number_format($dealerAchive,2)}} %</td>
                                        </tr>
                                        @endforeach
                                        {{-- foreach Area End --}}
                                        <tr style="background-color: #56b6eb; font-size: 16px;">
                                          <td colspan="6" style="text-align: left;">Area Sub Total: </td>
                                          <td style="text-align: right;">{{number_format($areaTarget,2)}}</td>
                                          <td  style="text-align: right;"> {{number_format($areaSubTotal,2)}} </td>
                                          <td style="text-align: right;"> {{number_format($areaAchive,2)}} %</td>
                                        </tr>
                                      @endforeach
                                    {{-- foreach Region End --}}


                                @endif
                                {{-- if Region End --}}
                                <tr style="background-color: #16c11a; font-size: 16px;">
                                  <td colspan="6" style="text-align: left;">Region Sub Total: </td>
                                  <td style="text-align: right;">{{number_format($regionTarget,2)}}</td>
                                  <td  style="text-align: right;"> {{number_format($regionSubTotal,2)}} </td>
                                  <td style="text-align: right;"> {{number_format($regionAchive,2)}} %</td>
                                </tr>
                                @endforeach
                                {{-- foreach Zone End --}}
                                <tr style="background-color: #a0d47b; font-size: 16px;">
                                  <td colspan="6" style="text-align: left;">Grand Total: </td>
                                  <td style="text-align: right;">{{number_format($totalTarget,2)}}</td>
                                  <td  style="text-align: right;"> {{number_format($grand_total,2)}} </td>
                                  <td style="text-align: right;"> {{number_format($totalAchive,2)}} %</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection


    @push('end_js')

    <script>
        $(document).ready(function() {

            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
                a.style.display = "none";
            });

        });
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
        $(function() {
            $("#btnExport").click(function() {
                $("#reporttable").table2excel({
                    filename: "Sales-Report.xls"
                });
            });
        });
    </script>

    @endpush
