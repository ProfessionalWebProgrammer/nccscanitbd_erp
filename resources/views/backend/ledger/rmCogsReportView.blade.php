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
                              	<h5 style="font-weight: 800;">Production RM COGS Ledger Report</h5>
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
                                    <th width="20%">Date</th>
                                    <th width="20%" class="text-left">Invoice</th>
                                    <th width="20%" class="text-right">Opening Balance</th>
                                    <th width="20%" class="text-right">Current Balance</th>
                                    <th width="20%" class="text-right">Closing Balance</th>
                                </tr>
                            </thead>

                            <tbody >
                                @php

                                  $total = 0;
                                  $total_ob = 0;
                                  $balance = 0;
                                @endphp

                                @foreach ($invoices as $val)
                                  @php

                                    $preData =  App\Models\Account\ChartOfAccounts::select('date','invoice','debit','credit')->where('invoice',$val->invoice)->where('ac_sub_sub_account_id',13)->whereBetween('date', [$sdate, $preday])->first();
                                    $data =  App\Models\Account\ChartOfAccounts::select('date','invoice','debit','credit')->where('invoice',$val->invoice)->where('ac_sub_sub_account_id',13)->whereBetween('date', [$fdate, $tdate])->first();

                                    if($preData){
                                      if($preData->debit > 0){
                                        $total_ob += $preData->debit;
                                        $balance += $preData->debit;
                                      }
                                      if($preData->credit > 0){
                                        $total_ob -= $preData->credit;
                                        $balance -= $preData->credit;
                                      }
                                    }

                                    if($data){
                                      if($data->debit > 0){
                                        $total += $data->debit;
                                        $balance += $data->debit;
                                      }
                                      if($data->credit > 0){
                                        $total -= $data->credit;
                                        $balance -= $data->credit;
                                      }
                                    }

                                  @endphp

                                 @if($balance > 0 )
                                  <tr style="font-size: 14px; font-weight:bold;border-bottom:1px solid;">
                                      <td class="text-left">{{ date('d-m-Y', strtotime($val->date))}}</td>
                                      <td><a href="{{ route('sales.invoice.view', $val->invoice) }}" target="_blank">{{$val->invoice ?? ''}}</a></td>
                                      <td class="text-right">
                                        @if($preData)
                                        @if($preData->debit > 0)
                                        {{ number_format($preData->debit, 2) }}
                                        @endif

                                        @if($preData->credit > 0)
                                        - {{ number_format($preData->credit, 2) }}
                                        @endif

                                        @endif
                                      </td>
                                      <td class="text-right">
                                        @if($data)
                                        @if($data->debit > 0)
                                        {{ number_format($data->debit, 2) }}
                                        @endif

                                        @if($data->credit > 0)
                                        - {{ number_format($data->credit, 2) }}
                                        @endif
                                        @endif
                                      </td>
                                      <td class="text-right">{{ number_format($balance, 2) }}</td>
                                  </tr>
                                @endif
                                @endforeach

                                <tr style="font-size: 16px; font-weight:bold; border-top:2px solid;">
                                    <td colspan="2">GrandTotal</td>
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
