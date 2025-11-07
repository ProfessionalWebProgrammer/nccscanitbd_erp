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
                                    <th width="55%">Dealer Name</th>
                                    <th width="15%" class="text-right">Opening Balance</th>
                                    <th width="15%" class="text-right">Current Balance</th>
                                    <th width="15%" class="text-right">Closing Balance</th>
                                </tr>
                            </thead>

                            <tbody >
                                @php
                                  $openData = 27949233;
                                  $total = 0;
                                  $total_ob = 0;
                                  $balance = 27949233;
                                @endphp
                                <tr style="font-size: 14px;">
                                  <td class="text-left">Sales Opening Balance</td>
                                  <td class="text-right">{{number_format($openData,2)}}</td>
                                  <td></td>
                                  <td class="text-right">{{number_format($balance,2)}}</td>
                                </tr>
                                @foreach ($dealears as $data)
                                  @php
                                    $stdate = "2023-10-01";
                                    $preDebit =  \App\Models\SalesLedger::where('vendor_id',$data->id)->whereBetween('ledger_date', [$stdate, $preday])->sum('debit');
                                    $debit =  \App\Models\SalesLedger::where('vendor_id',$data->id)->whereBetween('ledger_date', [$fdate, $tdate])->sum('debit');
                                    $total += $debit;
                                    $total_ob += $preDebit;
                                    $balance += $debit + $preDebit;
                                  @endphp

                                  @if($debit > 0 || $preDebit > 0)
                                  <tr style="font-size: 14px; font-weight:bold;border-bottom:1px solid;">
                                      <td class="text-left">{{ $data->d_s_name }}</td>
                                      <td class="text-right">{{ number_format($preDebit, 2) }}</td>
                                      <td class="text-right">{{ number_format($debit, 2) }}</td>
                                      <td class="text-right">{{ number_format($balance, 2) }}</td>
                                  </tr>
                                  @endif
                                @endforeach

                                <tr style="font-size: 16px; font-weight:bold; border-top:2px solid;">
                                    <td >GrandTotal</td>
                                    <td class="text-right">{{ number_format($total_ob, 2) }}</td>
                                    <td class="text-right">{{ number_format($total, 2) }}</td>
                                    <td class="text-right">{{ number_format($balance, 2) }}</td>
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
