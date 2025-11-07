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
                    <div class="text-center pt-3" style="  ">

                        <div class="row mb-4">
                            <div class="col-md-4 text-left align-middle pl-3">
                              	<h5 style="font-weight: 800;">Sales Return Ledger</h5>
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
                                <tr class="text-center " {{--style="background-color:white" --}}>
                                    <th>Date</th>
                                    <th>Warehouse</th>
                                    <th>Inv No</th>
                                    <th>Category</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                  	<th class="text-right">U Price </th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>

                            <tbody style="font-size: 12px;">
                                @php
                                $gTotalAmount = 0;
                                @endphp


                                @foreach ($dealers as $data)
                                @php
                                $details = \App\Models\SalesReturnItem::where('invoice_no', $data->invoice_no)->get();
                                $subTotalAmount = 0;
                                @endphp

                                <tr style="font-size: 15px; font-weight:500; ">
                                    <td colspan="100%" class="text-left"><a href="{{url('/deler/index')}}?vendor_id={{$data->dealer_id}}" target="_blank"  style="color:#082d91 !important;"> {{ $data->dealer->d_s_name ?? ''}}</a>  </td>
                                </tr>
                                @foreach ($details as $key => $item)

                                @php
                                $subTotalAmount += $item->total_price;
                                $gTotalAmount  += $item->total_price;
                                @endphp

                                <tr style="font-size: 13px;">
                                    <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                    <td>{{ $data->warehouse->factory_name }}</td>
                                    <td>  <a href="{{URL::to('/sales/return/view/'.$item->invoice_no)}}" target="_blank" > {{$item->invoice_no}} </a></td>
                                    <td class="text-left">{{optional($item->product->sales_category)->category_name}}</td>
                                    <td class="text-left">{{$item->product->product_name}}</td>
                                    <td>{{$item->qty}} {{$item->product->unit->unit_name}}</td>
                                    <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-right">{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                                @endforeach

                                <tr style="font-size: 14px; font-weight:600;background-color:#7cb7ee;">
                                  <td colspan="7" class="text-left">Sub Total: </td>
                                  <td class="text-right">{{ number_format($subTotalAmount, 2) }}</td>
                                </tr>
                                @endforeach

                                <tr style="font-size: 15px;color:#fff; font-weight:600;background-color:#b88c15; ">
                                    <td colspan="7" class="text-left"  style="padding: 12px;"> Grand Total </td>
                                    <td class="text-right" style="padding: 12px;">{{ number_format($gTotalAmount, 2) }}</td>

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
                    filename: "SalesReturnReport.xls"
                });
            });
        });
    </script>

    @endpush
