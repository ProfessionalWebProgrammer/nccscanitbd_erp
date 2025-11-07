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
                                    <th style="width:3%;">Sl</th>
                                    <th>Dealer Name</th>
                                    <th>Opening Balance</th>
                                    <th>Cash Sales</th>
                                    <th>Credit Sales</th>
                                    <th>Discount</th>
                                    <th>Goods Return</th>
                                    <th>Net Sales</th>
                                    <th>Total Credit</th>
                                    <th>Collection</th>
                                    <th>Com. Others</th>
                                    <th>Total Collection</th>
                                    <th>Closing Balance</th>
                                </tr>
                            </thead>

                            <tbody style="font-size: 11px;">
                                @php
                                  $grandTotalOB = 0;
                                  $grandTotalCsS = 0;
                                  $grandTotalCS = 0;
                                  $grandTotalDis = 0;
                                  $grandTotalRS = 0;
                                  $grandTotalNS = 0;
                                  $grandTotalTC = 0;
                                  $grandTotalC = 0;
                                  $grandTotalCom = 0;
                                  $grandTotalTCl = 0;
                                  $grandTotalClb = 0;
                                @endphp

                                @foreach ($zones as $valZone)
                                @php

                                  $regions = \App\Models\SalesLedger::select('region_id as id','t1.subzone_title as name')
                                                  ->leftjoin('dealer_subzones as t1','sales_ledgers.region_id','=','t1.id')
                                                  ->where('sales_ledgers.zone_id', $valZone->id)->whereIn('area_id',$area_id)
                                                  ->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('region_id')->get();

                                  $regionSubTotalOB = 0;
                                  $regionSubTotalCsS = 0;
                                  $regionSubTotalCS = 0;
                                  $regionSubTotalDis = 0;
                                  $regionSubTotalRS = 0;
                                  $regionSubTotalNS = 0;
                                  $regionSubTotalTC = 0;
                                  $regionSubTotalC = 0;
                                  $regionSubTotalCom = 0;
                                  $regionSubTotalTCl = 0;
                                  $regionSubTotalClb = 0;
                                @endphp

                                <tr>
                                    <td colspan="100%"  style="text-align: left; color: #0606b7; font-size: 16px; font-weight:600;">Zone:  {{ $valZone->zone_title ?? ''}}</td>
                                </tr>
                                @if(count($regions) > 0)
                                  @foreach ($regions as $key => $val)
                                      @php

                                      $areas = \App\Models\SalesLedger::select('sales_ledgers.area_id as areaId','sales_ledgers.region_id','t1.area_title as name')
                                                      ->leftjoin('dealer_areas as t1','sales_ledgers.area_id','=','t1.id')
                                                      ->where('sales_ledgers.zone_id', $valZone->id)->where('sales_ledgers.region_id', $val->id)
                                                      ->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('sales_ledgers.area_id')->get();

                                        $areaSubTotalOB = 0;
                                        $areaSubTotalCsS = 0;
                                        $areaSubTotalCS = 0;
                                        $areaSubTotalRS = 0;
                                        $areaSubTotalDis = 0;
                                        $areaSubTotalNS = 0;
                                        $areaSubTotalTC = 0;
                                        $areaSubTotalC = 0;
                                        $areaSubTotalCom = 0;
                                        $areaSubTotalTCl = 0;
                                        $areaSubTotalClb = 0;
                                      @endphp
                                      <tr>
                                        <td colspan="100%" style="text-align: left; color: #0642af; font-size: 14px; font-weight:600;">Region: {{$val->name ?? ''}}</td>
                                      </tr>
                                        @foreach ($areas as $key => $val)
                                        @php


                                        $dealerDatas = DB::table('sales_ledgers')->select(
                                                      't1.d_s_name as name','t1.id as dealerId','sales_ledgers.region_id as regionId','sales_ledgers.area_id as areaId2',
                                                      DB::raw('sum(CASE WHEN discount_amount > 0 AND ledger_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `discount_amount` ELSE null END) as discountSale'),
                                                      DB::raw('sum(CASE WHEN discount_amount > 0 AND ledger_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `total_price` ELSE null END) as cashSale'),
                                                      DB::raw('sum(CASE WHEN discount_amount > 0 AND ledger_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `discount_amount` ELSE null END) as discountSale'),
                                                      DB::raw('sum(CASE WHEN discount_amount = 0 AND total_price > 0 AND ledger_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `total_price` ELSE null END) as creditSale'),
                                                      DB::raw('sum(CASE WHEN credit > 0 AND invoice LIKE "SR-Inv-%" AND ledger_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as returnSale'),
                                                      DB::raw('sum(CASE WHEN credit > 0 AND invoice LIKE "Rec-%" AND ledger_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as collectionSale'),
                                                      DB::raw('sum(CASE WHEN credit > 0 AND invoice LIKE "Jar-%" AND ledger_date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `credit` ELSE null END) as comissionSale')
                                                      )->leftjoin('dealers as t1','sales_ledgers.vendor_id','=','t1.id')
                                                        ->where('sales_ledgers.zone_id', $valZone->id)->where('sales_ledgers.region_id', $val->region_id)->where('sales_ledgers.area_id', $val->areaId)->groupBy('sales_ledgers.vendor_id')->get();

                                        $subTotalOB = 0;
                                        $subTotalCsS = 0;
                                        $subTotalCS = 0;
                                        $subTotalDis = 0;
                                        $subTotalRS = 0;
                                        $subTotalNS = 0;
                                        $subTotalTC = 0;
                                        $subTotalC = 0;
                                        $subTotalCom = 0;
                                        $subTotalTCl = 0;
                                        $subTotalClb = 0;
                                        @endphp
                                        <tr>
                                          <td colspan="100%" style="text-align: left; color: #8b1ba9; font-size: 13px; font-weight:600;">Area: {{$val->name ?? ''}}</td>
                                        </tr>
                                        @foreach ($dealerDatas as $key => $val)
                                            @php

                                            $openingBalance = \App\Models\SalesLedger::select(DB::raw('SUM(debit) - SUM(credit) as balance'))->where('vendor_id', $val->dealerId)
                                                                     ->where('sales_ledgers.zone_id', $valZone->id)->where('sales_ledgers.region_id', $val->regionId)->where('sales_ledgers.area_id', $val->areaId2)->whereBetween('ledger_date', [$sdate,$pdate])->first();



                                            $opening = $openingBalance->balance ?? 0;
                                            $cashSale = $val->cashSale ?? 0;

                                            $creditSale = $val->creditSale ?? 0;
                                            $returnSale = $val->returnSale ?? 0;
                                            $comSale = $val->comissionSale ?? 0;
                                            $discountSale = $val->discountSale ?? 0;

                                            $natSales = $cashSale + $creditSale - $returnSale;
                                            $totalCredit = $opening + $natSales;
                                            $collectionSales = $val->collectionSale ?? 0;
                                            $totalCollection = $collectionSales + $comSale;
                                            $clb = $totalCredit - $totalCollection;

                                            $subTotalOB += $opening;
                                            $subTotalCsS += $cashSale;
                                            $subTotalCS += $creditSale;
                                            $subTotalDis += $discountSale;
                                            $subTotalRS += $returnSale;
                                            $subTotalNS += $natSales;
                                            $subTotalTC += $totalCredit;
                                            $subTotalC += $collectionSales;
                                            $subTotalCom += $comSale;
                                            $subTotalTCl += $totalCollection;
                                            $subTotalClb += $clb;

                                            $areaSubTotalOB += $opening;
                                            $areaSubTotalCsS += $cashSale;
                                            $areaSubTotalCS += $creditSale;
                                            $areaSubTotalDis += $discountSale;
                                            $areaSubTotalRS += $returnSale;
                                            $areaSubTotalNS += $natSales;
                                            $areaSubTotalTC += $totalCredit;
                                            $areaSubTotalC += $collectionSales;
                                            $areaSubTotalCom += $comSale;
                                            $areaSubTotalTCl += $totalCollection;
                                            $areaSubTotalClb += $clb;

                                            $regionSubTotalOB += $opening;
                                            $regionSubTotalCsS += $cashSale;
                                            $regionSubTotalCS += $creditSale;
                                            $regionSubTotalDis += $discountSale;
                                            $regionSubTotalRS += $returnSale;
                                            $regionSubTotalNS += $natSales;
                                            $regionSubTotalTC += $totalCredit;
                                            $regionSubTotalC += $collectionSales;
                                            $regionSubTotalCom += $comSale;
                                            $regionSubTotalTCl += $totalCollection;
                                            $regionSubTotalClb += $clb;

                                            $grandTotalOB += $opening;
                                            $grandTotalCsS += $cashSale;
                                            $grandTotalCS += $creditSale;
                                            $grandTotalDis += $discountSale;
                                            $grandTotalRS += $returnSale;
                                            $grandTotalNS += $natSales;
                                            $grandTotalTC += $totalCredit;
                                            $grandTotalC += $collectionSales;
                                            $grandTotalCom += $comSale;
                                            $grandTotalTCl += $totalCollection;
                                            $grandTotalClb += $clb;

                                            @endphp

                                           <tr>
                                            <td>{{++$key}}</td>
                                            <td style="text-align: left; color: #8b1ba9; font-size: 13px; font-weight:500;">Dealer: {{$val->name ?? ''}}</td>
                                            <td align="right">{{number_format($opening,2)}}</td>
                                            <td align="right">{{number_format($cashSale,2)}}</td>
                                            <td align="right">{{number_format($creditSale,2)}}</td>
                                            <td align="right">{{number_format($discountSale,2)}}</td>
                                            <td align="right">{{number_format($returnSale,2)}}</td>
                                            <td align="right">{{number_format($natSales,2)}}</td>
                                            <td align="right">{{number_format($totalCredit,2)}}</td>
                                            <td align="right">{{number_format($collectionSales,2)}}</td>
                                            <td align="right">{{number_format($comSale,2)}}</td>
                                            <td align="right">{{number_format($totalCollection,2)}}</td>
                                            <td align="right">{{number_format($clb,2)}}</td>
                                          </tr>
                                        @endforeach
                                        {{-- foreach Dealer End --}}

                                        <tr style="background-color: #d2a565; font-size: 15px;">
                                          <td colspan="2" style="text-align: left;">Dealer Sub Total: </td>
                                          <td align="right">{{number_format($subTotalOB,2)}}</td>
                                          <td align="right">{{number_format($subTotalCsS,2)}}</td>
                                          <td align="right">{{number_format($subTotalCS,2)}}</td>
                                          <td align="right">{{number_format($subTotalDis,2)}}</td>
                                          <td align="right">{{number_format($subTotalRS,2)}}</td>
                                          <td align="right"> {{number_format($subTotalNS,2)}} </td>
                                          <td align="right">{{number_format($subTotalTC,2)}}</td>
                                          <td align="right">{{number_format($subTotalC,2)}}</td>
                                          <td align="right">{{number_format($subTotalCom,2)}}</td>
                                          <td align="right">{{number_format($subTotalTCl,2)}}</td>
                                          <td align="right">{{number_format($subTotalClb,2)}}</td>
                                        </tr>
                                        @endforeach
                                        {{-- foreach Area End --}}
                                      <tr style="background-color: #56b6eb; font-size: 15px;">
                                          <td colspan="2" style="text-align: left;">Area Sub Total: </td>
                                          <td align="right">{{number_format($areaSubTotalOB,2)}}</td>
                                          <td align="right">{{number_format($areaSubTotalCsS,2)}}</td>
                                          <td align="right">{{number_format($areaSubTotalCS,2)}}</td>
                                          <td align="right">{{number_format($areaSubTotalDis,2)}}</td>
                                          <td align="right">{{number_format($areaSubTotalRS,2)}}</td>
                                          <td align="right"> {{number_format($areaSubTotalNS,2)}} </td>
                                          <td align="right">{{number_format($areaSubTotalTC,2)}}</td>
                                          <td align="right">{{number_format($areaSubTotalC,2)}}</td>
                                          <td align="right">{{number_format($areaSubTotalCom,2)}}</td>
                                          <td align="right">{{number_format($areaSubTotalTCl,2)}}</td>
                                          <td align="right">{{number_format($areaSubTotalClb,2)}}</td>
                                        </tr>
                                      @endforeach
                                    {{-- foreach Region End --}}


                                @endif
                                {{-- if Region End --}}
                              <tr style="background-color: #16c11a; font-size: 15px;">
                                <td colspan="2" style="text-align: left;">Region Sub Total: </td>
                                <td align="right">{{number_format($regionSubTotalOB,2)}}</td>
                                <td align="right">{{number_format($regionSubTotalCsS,2)}}</td>
                                <td align="right">{{number_format($regionSubTotalCS,2)}}</td>
                                <td align="right">{{number_format($regionSubTotalDis,2)}}</td>
                                <td align="right">{{number_format($regionSubTotalRS,2)}}</td>
                                <td align="right"> {{number_format($regionSubTotalNS,2)}} </td>
                                <td align="right">{{number_format($regionSubTotalTC,2)}}</td>
                                <td align="right">{{number_format($regionSubTotalC,2)}}</td>
                                <td align="right">{{number_format($regionSubTotalCom,2)}}</td>
                                <td align="right">{{number_format($regionSubTotalTCl,2)}}</td>
                                <td align="right">{{number_format($regionSubTotalClb,2)}}</td>
                                </tr>
                                @endforeach
                                {{-- foreach Zone End --}}
                                 <tr style="background-color: #a0d47b; font-size: 15px;">
                                  <td colspan="2" style="text-align: left;">Zone  Grand Total: </td>
                                  <td align="right">{{number_format($grandTotalOB,2)}}</td>
                                  <td align="right">{{number_format($grandTotalCsS,2)}}</td>
                                  <td align="right">{{number_format($grandTotalCS,2)}}</td>
                                  <td align="right">{{number_format($grandTotalDis,2)}}</td>
                                  <td align="right">{{number_format($grandTotalRS,2)}}</td>
                                  <td align="right">{{number_format($grandTotalNS,2)}} </td>
                                  <td align="right">{{number_format($grandTotalTC,2)}}</td>
                                  <td align="right">{{number_format($grandTotalC,2)}}</td>
                                  <td align="right">{{number_format($grandTotalCom,2)}}</td>
                                  <td align="right">{{number_format($grandTotalTCl,2)}}</td>
                                  <td align="right">{{number_format($grandTotalClb,2)}}</td>
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
