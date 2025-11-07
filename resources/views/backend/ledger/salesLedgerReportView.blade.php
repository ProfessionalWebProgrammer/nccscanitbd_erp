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

  /*  .content-wrapper {
        background: rgb(10, 10, 10) !important;
    }

    .main-sidebar {
        background: #161616 !important;
        color: #52CD9F !important;
    }

    .main-header {
        background: #000000 !important;
        color: #52CD9F !important;
    }

    table tr:hover {
        background: #202020 !important;
    }

    .table,
    .table td,
    .table th {
        border-color: rgb(64 64 64);
    }
 */
    .table,
    .table td {
        padding: 5px 10px;
    }


    .nav-sidebar .nav-item>.nav-link {
        color: #52CD9F !important;
    }

  /*  .table-header-fixt-top {
        background: #202020 !important;
    }

    .table.table-bordered {
        background: #202020 !important;
    } */
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
                    <div class="text-center pt-3" style=" margin-bottom:10px;">

                        <div class="row mb-4">
                            <div class="col-md-4 text-left align-middle pl-3">
                              	<h5 style="font-weight: 800;">Sales Ledger</h5>
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



                        <table class="table table-bordered p-2" style="font-size: 11px;font-weight: 600; border:1px solid; width:60%; margin:0 auto; ">
                            <thead>
                                <tr style="font-size: 15px;" >
                                    <th width="70%" class="text-left">Dealer Name</th>
                                    <th width="30%" class="text-right">Balance</th>
                                </tr>
                            </thead>

                            <tbody >
                                @php
                                $openigAmount = 0;
                                $gt_cb = 0;
                                @endphp

                                @foreach ($dealears as $data)
                                @php

                                $t_cb = 0;
                                $stdate = "2023-10-01";
                                $opdata =  \App\Models\SalesLedger::select(DB::raw('sum(debit) as debit'),DB::raw('sum(credit) as credit'))
                                          ->whereBetween('ledger_date', [$stdate, $preday])->where('vendor_id',$data->id)->first();
								               $datas = \App\Models\SalesLedger::where('vendor_id',$data->id)->whereBetween('ledger_date' ,[$fdate,$tdate])
                                		      ->whereNotNull('vendor_id')->get();
                                $totalAmount = \App\Models\SalesLedger::select(DB::raw('SUM(debit) - SUM(credit) as balance'))->whereBetween('ledger_date' ,[$stdate,$tdate])
                                                      ->whereNotNull('vendor_id')->get();
                                if($fdate <= '2023-10-01'){
                                $openigBalance = $data->dlr_base;
                                } else {
                                $openigBalance = $data->dlr_base+$opdata->debit - $opdata->credit;
                                }
                                $closing_b = $openigBalance;
                                $openigAmount += $data->dlr_base;
                                @endphp


                                @foreach ($datas as $key => $item)

                                @php
                                $closing_b += $item->debit-$item->credit;
                                @endphp
                                @if($item->priority != 9 && $item->priority != 4)

                                @else
                                {{-- For Year Close Subtotal  --}}
                                @if($key != 0)
                                @php
                                $t_cb = 0;
                                @endphp
                                @endif
                                @endif
                                @endforeach
                                @if($closing_b > 0)
                                <tr style="font-size: 14px; font-weight:bold;border-bottom:1px solid;">
                                    <td class="text-left">{{ $data->d_s_name }}</td>
                                    <td class="text-right">{{ number_format($closing_b, 2) }}</td>

                                </tr>
                                @endif
                                @php
                                $gt_cb += $closing_b;
                                @endphp

                                @endforeach

                                <tr style="font-size: 16px; font-weight:bold; border-top:2px solid;">
                                    <td >Grand Total</td>
                                    <td class="text-right">{{ number_format(($totalAmount[0]->balance + $openigAmount),2) }}</td>
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
                    filename: "SalesLedger.xls"
                });
            });
        });
    </script>

    @endpush
