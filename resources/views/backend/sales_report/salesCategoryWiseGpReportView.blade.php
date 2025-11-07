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
            <div class="pb-5 col-md-10 m-auto">

                <div class="table-responsive  pb-5  pr-2 " id="reporttable">
                    <div class="text-center pt-3" style="  ">

                        <div class="row mb-4">
                            <div class="col-md-4 text-left align-middle pl-3">
                              	<h5 style="font-weight: 800;">Sales Brand Wise GP Report Ledger</h5>
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

                        <table class="table table-bordered p-2" style="font-size: 13px;font-weight: 600; ">
                            <thead>
                                <tr >
                                    <th>Category</th>
                                    <th>Brand Code</th>
                                    <th >Brand Name</th>
                                    <th>Net Sales</th>
                                    <th class="text-right">COGS</th>
                                    <th>GP</th>
                                    <th class="text-right">GP%</th>
                                </tr>
                            </thead>

                            <tbody style="font-size: 12px;">
                              @php
                              $totalNetSales =  0;
                              $totalGp = 0;
                              @endphp
                              @foreach($reportsData as $val)
                              @php
                              $totalNetSales += $val['netSales'];
                              $totalGp += $val['gp'];
                              @endphp
                              <tr>
                                <td class="text-left">{{$val['category']}}</td>
                                <td >{{$val['brandCode']}}</td>
                                <td class="text-left">{{$val['brand']}}</td>
                                <td class="text-right">{{number_format($val['netSales'],2)}}</td>
                                <td class="text-right">{{number_format($val['cogs'],2)}}</td>
                                <td class="text-right">{{number_format($val['gp'],2)}}</td>
                                <td class="text-right">{{number_format($val['gpPercent'],2)}} %</td>
                              </tr>
                              @endforeach
                              <tr>
                                <td>Grand Total: </td>
                                <td class="text-right" colspan="3">{{number_format($totalNetSales,2)}}</td>
                                <td class="text-right" colspan="2">{{number_format($totalGp,2)}}</td>
                                <td></td>
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
                    filename: "SalesDiscountReport.xls"
                });
            });
        });
    </script>

    @endpush
