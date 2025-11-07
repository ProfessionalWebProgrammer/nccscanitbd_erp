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
                                <th>Amount</th>
                              </tr>
                            </thead>

                            <tbody style="font-size: 11px;">
                                @php
                                  $grand_total = 0;
                                @endphp

                                @foreach ($zones as $val)
                                @php
                                if(!empty($dlr_area_id)){
                                  $areas = \App\Models\SalesLedger::select('area_id as id','t1.area_title')
                                                  ->leftjoin('dealer_areas as t1','sales_ledgers.area_id','=','t1.id')
                                                  ->where('zone_id',$val->id)->whereIn('area_id',$dlr_area_id);
                                  if(!empty($dealer_id)){
                                      $areas = $areas->whereIn('vendor_id',$dealer_id);
                                    if(!empty($product_id)){
                                      $areas = $areas->whereIn('product_id',$product_id)->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('area_id')->get();
                                    } else {
                                      $areas = $areas->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('area_id')->get();
                                    }
                                  }elseif(!empty($product_id)){
                                    $areas = $areas->whereIn('product_id',$product_id)->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('area_id')->get();
                                  }else{
                                    $areas = $areas->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('area_id')->get();
                                  }
                                }elseif(!empty($dealer_id)) {
                                  $areas = \App\Models\SalesLedger::select('area_id','t1.area_title')
                                          ->leftjoin('dealer_areas as t1','sales_ledgers.area_id','=','t1.id')
                                          ->where('zone_id',$val->id)->whereIn('vendor_id',$dealer_id);
                                  if(!empty($product_id)){
                                  $areas = $areas->whereIn('product_id',$product_id)->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('area_id')->get();
                                }else{
                                  $areas = $areas->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('area_id')->get();
                                }
                                }elseif(!empty($product_id)){
                                  $areas = \App\Models\SalesLedger::select('area_id','t1.area_title')
                                            ->leftjoin('dealer_areas as t1','sales_ledgers.area_id','=','t1.id')
                                            ->where('zone_id',$val->id)->whereIn('product_id',$product_id)
                                            ->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('area_id')->get();
                                }else{
                                  $areas = \App\Models\SalesLedger::select('area_id','t1.area_title')
                                            ->leftjoin('dealer_areas as t1','sales_ledgers.area_id','=','t1.id')
                                            ->where('zone_id',$val->id)->whereBetween('ledger_date' ,[$fdate,$tdate])->groupBy('area_id')->get();
                                }
                                @endphp

                                <tr>
                                    <td colspan="100%"  style="text-align: left; color: #0606b7; font-size: 16px; font-weight:600;"> {{ $val->zone_title ?? ''}}</td>
                                </tr>
                                @if(count($areas) > 0)
                                  @foreach ($areas as $key => $valArea)
                                      <tr>
                                        <td colspan="100%" style="text-align: left; color: green; font-size: 14px; font-weight:600;"> {{$valArea->area_title ?? 'Area'}}</td>
                                      </tr>
                                      @php
                                          $dealers = \App\Models\SalesLedger::select('t2.id','t2.d_s_name as name')
                                                    ->leftjoin('dealers as t2','vendor_id','=','t2.id')
                                                    ->where('area_id',$valArea->area_id);
                                            if(!empty($product_id)){
                                              $dealers = $dealers->whereIn('product_id',$product_id)
                                              ->whereBetween('ledger_date' ,[$fdate,$tdate])->get();
                                            } else {
                                              $dealers = $dealers->whereBetween('ledger_date' ,[$fdate,$tdate])->get();
                                            }
                                      @endphp
                                        @foreach ($dealers as $key => $valDealer)
                                        @php
                                          $datas = \App\Models\SalesLedger::where('vendor_id',$valDealer->id)->whereBetween('ledger_date' ,[$fdate,$tdate])->get();

                                          $dealerSubTotal = 0;
                                        @endphp
                                          <tr>
                                            <td colspan="100%" style="text-align: left; color: #0642af; font-size: 13px; font-weight:500;">{{$valDealer->name ?? 'Dealer Name'}}</td>
                                          </tr>
                                          @foreach ($datas as $key => $val)
                                            @if($val->total_price > 0)
                                            @php
                                                $dealerSubTotal += $val->total_price + $val->discount_amount;
                                                $grand_total += $val->total_price + $val->discount_amount;
                                            @endphp
                                                <tr>
                                                  <td>{{date('d-m-y', strtotime($val->ledger_date))}}</td>
                                                  <td>{{$val->invoice}}</td>
                                                  <td>{{ $val->product_name }}</td>
                                                  <td>{{ $val->qty_kg }} {{$val->product->weightUnit->unit_name ?? ''}}</td>
                                                  <td>{{ $val->qty_pcs }}  {{$val->product->unit->unit_name ?? ''}}</td>
                                                  <td>{{ number_format($val->unit_price,2) }}</td>
                                                  <td style="text-align: right;">{{ number_format($val->total_price + $val->discount_amount, 2) }}</td>
                                                </tr>
                                              @endif
                                          @endforeach
                                          <tr style="background-color: #56b6eb; font-size: 14px;">
                                            <td style="text-align: left;">Dealer Sub Total: </td>
                                            <td colspan="6" style="text-align: right;"> {{number_format($dealerSubTotal,2)}} </td>
                                          </tr>
                                          {{-- foreach Dealer Product End --}}

                                        @endforeach
                                        {{-- foreach Dealer End --}}
                                  @endforeach
                                {{-- foreach Area End --}}
                                @endif
                                {{-- if Area End --}}

                                @endforeach
                                {{-- foreach Zone End --}}
                                <tr style="background-color: #a0d47b; font-size: 16px;">
                                  <td style="text-align: left;">Grand Total: </td>
                                  <td colspan="6" style="text-align: right;"> {{number_format($grand_total,2)}} </td>
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
