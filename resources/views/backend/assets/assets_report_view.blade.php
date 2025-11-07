@extends('layouts.account_dashboard')
@section('header_menu')
@endsection

@push('addcss')
    <style>
        .text_sale {
            color: #1fb715;
        }
        .text_credit{
            color: #f90b0b;
        }
          .tableFixHead          { overflow: auto; height: 600px; }
    	.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

    </style>
@endpush

@section('print_menu')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"  >


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
            <div class="container-fluid " id="contentbody">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Asset Report View</h5>
                    <p class=" font-weight-bold">Date : {{ date('d-F-Y', strtotime($fdate)) }} to
                        {{ date('d-F-Y', strtotime($tdate)) }}</p>
                </div>
                <div  class="table-responsive tableFixHead pb-5" >
                   <table  id="reporttable" class="table table-bordered p-2" style="font-size: 16px;font-style: italic;font-weight: 600; border:2px solid;">
                        <thead>
                            <tr class="text-center table-header-fixt-top" style="background-color:white" >
                                <th>Date</th>
                                <th>Inovice</th>
                                <th>Asset Category</th>
                                <th>Asset Type</th>
                                <th>Term</th>
                                <th>Client</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total Value</th>

                                <th>Payment Mode</th>
                                <th>Payment Value</th>
                                <th>Remaining Value</th>
                              <th>Asset Value</th>
                           </tr>
                        </thead>
                        <tbody>
                          @php
                          $totalval = 0;
                          $totalpay = 0;
                          $totalrem = 0;
                          $assetval = 0;
                          $assetqty = 0;

                          @endphp

                            @foreach ($assets as $data)
                          @php
                          		$assetdetails = DB::table('asset_details')->select('asset_details.*','asset_products.product_name')
                                ->leftJoin('asset_products', 'asset_products.id', 'asset_details.product_id')
                                ->where('invoice',$data->invoice)->get();

                           $totalval += $data->asset_value;
                          $totalpay += $data->payment_value;
                          $totalrem += $data->remaining_value;

                          @endphp
                          @if($assetdetails)
                           @foreach ($assetdetails as $item)
                          @php
                          $assetval += $item->asset_qty*$item->asset_unit_price;
                          $assetqty += $item->asset_qty;
                          @endphp
                          <tr>
                                    <td class="text-center">{{ date('d-M-Y', strtotime($data->date)) }}</td>
                                    <td class="text-left">{{ $data->invoice }}</td>
                                    <td class="text-left">{{ $data->category_name }}</td>
                                    <td class="text-left"></td>
                                    <td class="text-lef"></td>
                                    <td class="text-left">{{$item->product_name}}</td>
                                    <td class="text-right">{{$item->asset_qty}}</td>
                                    <td class="text-right">{{$item->asset_unit_price}}</td>
                                    <td class="text-lef">{{$item->asset_qty*$item->asset_unit_price}}</td>
                                    <td class="text-lef"></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                    <td class="text-left"></td>
                                </tr>

                           @endforeach
                          @endif
                                <tr @if($data->investment == 0 && $data->intangible == 0) style="color:red; font-weight:bold" @endif>
                                    <td class="text-center">{{ date('d-M-Y', strtotime($data->date)) }}</td>
                                    <td class="text-left">{{ $data->invoice }}</td>
                                    <td class="text-left">{{ $data->category_name }}</td>
                                    <td class="text-left">
                                        <span class="text-primary">
                                            @if ($data->asset_type == 1)
                                                Fixed Asset
                                            @elseif(($data->asset_type == 2))
                                                Current Asset
                                            @endif
                                          @if ($data->investment == 1)
                                          Investment
                                          @endif
                                           @if ($data->intangible == 1)
                                          Intangible
                                          @endif

                                        </span>
                                    </td>
                                    <td class="text-lef"> {{$data->asset_term}}  </td>
                                    <td class="text-lef"> {{$data->company_name}} {{$data->clint_name}} </td>
                                  <td class="text-left"></td>
                                  <td class="text-left"></td>
                                  <td class="text-left"></td>
                                  <td class="text-left"></td>

                                    <td class="text-lef">
                                        @if ($data->payment_mode == 'Bank')
                                            {{ $data->payment_mode }}
                                            <span
                                                class="text-danger">({{ DB::table('master_banks')->where('bank_id', $data->bank_id)->value('bank_name') }})</span>
                                        @elseif($data->payment_mode == "Cash")
                                            {{ $data->payment_mode }} <span
                                                class="text-danger">({{ DB::table('master_cashes')->where('wirehouse_id', $data->wirehouse_id)->value('wirehouse_name') }})</span>
                                        @endif
                                    </td>
                                   <td class="text-right">{{ number_format($data->payment_value, 2) }} (Cr)</td>
                                   <td class="text-right">{{ number_format($data->remaining_value, 2) }}</td>
                                   <td class="text-right">{{ number_format($data->asset_value, 2) }} (Dr)</td>

                                </tr>
                            @endforeach
                          <tr>
                            <td colspan="6" class="text-right">Total</td>
                            <td  class="text-right">{{$assetqty}}</td>

                            <td  class="text-right"></td>

                            <td  class="text-right">{{$assetval}}</td>


                            <td  class="text-right"></td>
                            <td  class="text-right"></td>
                            <td  class="text-right">{{number_format($totalpay, 2)}}</td>
                            <td  class="text-right">{{number_format($totalrem, 2)}}</td>
                             <td  class="text-right">{{number_format($totalval, 2)}}</td>

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
                filename: "Asset_Report.xls"
            });
        });
    });
</script>

@endsection
