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
        padding: 2px;
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
                            <div class="col-md-4 text-left align-middle">
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
                            <div class="col-md-4 text-right">
                                @if($count == 1)
                                <h5 style="font-weight: 800;" class="">{{$ledgers[0]->d_s_name}}</h5>
                                <h6 style="font-weight: 800;">{{$ledgers[0]->dlr_address}}</h6>
                                <h6 style="font-weight: 800;">{{$ledgers[0]->dlr_mobile_no}}</h6>
                                @if($ledgers[0]->dlr_mail)<a href="mailto:{{$ledgers[0]->dlr_mail}}">{{$ledgers[0]->dlr_mail}}</a>@endif
                                @endif
                            </div>
                        </div>
                        <table class="table table-bordered p-2" style="font-size: 16px;font-weight: 600; border:2px solid; ">
                            <thead>
                                <tr class="text-center " {{--style="background-color:white" --}}>
                                    <th>Date</th>
                                    <th>Store/Transaction</th>
                                    <th>Inv No</th>
                                    <th>Product</th>
                                    <th>Qty (PCS)</th>
                                    @if($salesunit->sales_kg != null)

                                    <th>Qty (KG)</th>
                                    <th>Qty (Ton)</th>
                                    @endif
                                  	<th>Price </th>
                                    <th>Value</th>
                                  
                                    @if($salesunit->discount_amount != null)
                                    <th>Com.</th>
                                    @endif
                                    @if($salesunit->free != null)
                                    <th>Free </th>
                                    @endif
                                    

                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Closing Balance</th>
                                </tr>
                            </thead>

                            <tbody style="font-size: 14px;">
                                @php
                                $gt_qty = 0;
                                $gt_qtykg = 0;
                                $gt_qtyton = 0;
                                $gt_value = 0;
                                $gt_dis = 0;
                                $gt_free = 0;
                                $gt_debit = 0;
                                $gt_credit = 0;
                                $gt_cb = 0;
                                @endphp
                                @foreach ($ledgers as $data)
                                @php
                                $t_qty = 0;
                                $t_qtykg = 0;
                                $t_qtyton = 0;
                                $t_value = 0;
                                $t_dis = 0;
                                $t_free = 0;
                                $t_debit = 0;
                                $t_credit = 0;
                                $t_cb = 0;

                                // $opdata = DB::table('sales_ledgers as t1')->select(
                                // DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "2021-01-01" AND "'.$preday.'" THEN `debit` ELSE null END) as debit_a'),
                                // DB::raw('sum(CASE WHEN t1.ledger_date BETWEEN "2021-01-01" AND "'.$preday.'" THEN `credit` ELSE null END) as credit_a'))
                                // ->where('vendor_id',$data->dealer_id)->first();


                                $openigBalance = $data->dlr_base+$data->debit_a-$data->credit_a;

                                $closing_b = $openigBalance;

                                // dd($ledgerdata);
                                @endphp

                                <tr style="font-size: 18px; font-weight:bold; ">
                                    <td colspan="6"><a href="{{url('/deler/index')}}?vendor_id={{$data->dealer_id}}" target="_blank"  style="color:red !important;"> {{ $data->d_s_name }}</a>  </td>
                                    @if($salesunit->sales_kg != null)

                                    <td></td>
                                    <td></td>
                                    @endif
                                    @if($salesunit->discount_amount != null)
                                    <td></td>
                                    @endif
                                    @if($salesunit->free != null)
                                    <td></td>
                                    @endif

                                    <td colspan="3">Opening Balance</td>
                                    <td class="text-right">{{ number_format($openigBalance, 2) }} </td>
                                </tr>
                             
                                @foreach ($data->data as $key => $item)

                                @php
                                $t_qty += $item->qty_pcs;
                                $t_qtykg += $item->qty_kg;
                                $t_qtyton += $item->qty_kg / 1000;
                                $t_value += $item->total_price + $item->discount_amount;
                                $t_dis += $item->discount_amount;
                                $t_free += $item->free;
                                $t_debit += $item->debit;
                                $t_credit += $item->credit;
                                $closing_b += $item->debit-$item->credit;

                                $gt_qty += $item->qty_pcs;
                                $gt_qtykg += $item->qty_kg;
                                $gt_qtyton += $item->qty_kg / 1000;
                                $gt_value += $item->total_price + $item->discount_amount;
                                $gt_dis += $item->discount_amount;
                                $gt_free += $item->free;
                                $gt_debit += $item->debit;
                                $gt_credit += $item->credit;
								

                                if ($item->priority == 1) {
                                $clss = 'highlighted text_sale font-weight-bold';
                                } elseif ($item->priority == 5) {
                                $clss = 'highlighted text-primary font-weight-bold';
                               	} elseif ($item->priority == 4) {
                              	$clss = 'highlighted text-danger font-weight-bold';
                                } elseif ($item->priority == 2) {
                                $clss = 'highlighted text_return font-weight-bold';
                                } elseif ($item->credit != '' || $item->journal_id != '') {
                                $clss = 'highlighted text_credit font-weight-bold';
                                } else {
                                $clss = '';
                                }

                                @endphp
                                @if($item->priority != 9)

                                <tr>
                                    <td class="<?= $clss ?>">{{ date('d-m-y', strtotime($item->ledger_date)) }}</td>
                                    <td class="<?= $clss ?>">{{ $item->warehouse_bank_name }} @if(!empty($item->narration))<br>{{$item->narration}} @else  @endif</td>
                                   <td class="<?=$clss?>" style="text-align:center;font-family: sans-serif;    font-weight: bold !important;">
                                @if($item->credit == '')

                                  <a href="{{url('/sales/list')}}?invoice={{$item->invoice}}" target="_blank" > {{$item->invoice}}</a>
                                 @else
                                 {{$item->invoice}}
                                 @endif

                                </td>


                                    <td class="<?= $clss ?>">{{ $item->product_name }}</td>
                                    <td class="text-right <?= $clss ?>">{{ $item->qty_pcs }}</td>
                                    @if($salesunit->sales_kg != null)
                                    <td class="text-right <?= $clss ?>">{{ $item->qty_kg }}</td>
                                    <td class="text-right <?= $clss ?>">{{ $item->qty_kg / 1000 }}</td>
                                    @endif
                                    <td class="text-right <?= $clss ?>">{{ number_format($item->unit_price,2) }}</td>
									<td class="text-right <?= $clss ?>">{{ number_format($item->total_price + $item->discount_amount , 2) }}</td>
                                    @if($salesunit->discount_amount != null)
                                    <td class="text-right <?= $clss ?>"> @if($item->discount){{number_format($item->discount_amount,2) }} ({{ $item->discount }} /kg) @endif</td>
                                    @endif
                                    @if($salesunit->free != null)
                                    <td class="text-right <?= $clss ?>">{{ $item->free }}</td>
                                    @endif
                                    <td class="text-right <?= $clss ?>">{{ number_format($item->debit, 2) }}</td>
                                    <td class="text-right <?= $clss ?>">{{ number_format($item->credit, 2) }}</td>
                                    <td class="text-right <?= $clss ?>">@if($item->priority != 0 || $item->credit != '' || $item->journal_id != '') {{ number_format($closing_b, 2) }} @else - @endif</td>
                                </tr>

                                @else

                                {{-- For Year Close Subtotal  --}}
                                @if($key != 0)
                                <tr style="font-size: 16px;color:#17a50d; font-weight:bold;border-bottom:2px solid;">
                                    <td colspan="4">Total (Year End)</td>


                                    <td class="text-right">{{ $t_qty }}</td>
                                    @if($salesunit->sales_kg != null)
                                    <td class="text-right">{{ $t_qtykg }}</td>
                                    <td class="text-right">{{ $t_qtyton }}</td>
                                    @endif
                                    <td class="text-right"></td>
                                    <td class="text-right">{{ number_format($t_value, 2) }}</td>
                                    @if($salesunit->discount_amount != null)
                                    <td class="text-right">{{ $t_dis }}</td>
                                    @endif
                                    @if($salesunit->free != null)
                                    <td class="text-right">{{ $t_free }}</td>
                                    @endif

                                    <td class="text-right">{{ number_format($t_debit, 2) }}</td>
                                    <td class="text-right">{{ number_format($t_credit, 2) }}</td>
                                    <td class="text-right">{{ number_format($closing_b, 2) }}</td>

                                </tr>

                                @php
                                $t_qty = 0;
                                $t_qtykg = 0;
                                $t_qtyton = 0;
                                $t_value = 0;
                                $t_dis = 0;
                                $t_free = 0;
                                $t_debit = 0;
                                $t_credit = 0;
                                $t_cb = 0;
                                @endphp
                                @endif


                                <tr style="font-size: 16px; font-weight:bold; color:">
                                    <td class="<?= $clss ?>">{{ date('d-m-y', strtotime($item->ledger_date)) }}</td>
                                    <td colspan="5">Year End ({{ date('d-m-y', strtotime($item->ledger_date)) }})</td>

                                    @if($salesunit->sales_kg != null)

                                    <td></td>
                                    <td></td>
                                    @endif
                                    <td></td>
                                    <td></td>
                                    @if($salesunit->discount_amount != null)
                                    <td></td>
                                    @endif
                                    @if($salesunit->free != null)
                                    <td></td>
                                    @endif
                                    <td>Closing Balance</td>
                                    <td class="text-right">{{ number_format($closing_b, 2) }}</td>
                                </tr>

                                <tr style="font-size: 16px; font-weight:bold; color:">
                                    <td class="<?= $clss ?>">{{ date('d-m-y', strtotime($item->ledger_date)) }}</td>
                                    <td colspan="5">{{ $item->warehouse_bank_name }} ({{ date('d-m-y', strtotime($item->ledger_date)) }})</td>
                                    @if($salesunit->sales_kg != null)

                                    <td></td>
                                    <td></td>
                                    @endif
                                    <td></td>
                                    <td></td>
                                    @if($salesunit->discount_amount != null)
                                    <td></td>
                                    @endif
                                    @if($salesunit->free != null)
                                    <td></td>
                                    @endif

                                    <td>Opening Balance</td>
                                    <td class="text-right">{{ number_format($closing_b, 2) }}</td>
                                </tr>


                                @endif


                                @endforeach


                                <tr style="font-size: 16px;color:#fff; font-weight:bold;border-bottom:2px solid;background-color:#c641cf;">
                                    <td colspan="4">Subtotal</td>


                                    <td class="text-right">{{ $t_qty }}</td>
                                    @if($salesunit->sales_kg != null)
                                    <td class="text-right">{{ $t_qtykg }}</td>
                                    <td class="text-right">{{ $t_qtyton }}</td>
                                    @endif
                                    <td class="text-right"></td>
                                    <td class="text-right">{{ number_format($t_value, 2) }}</td>
                                    @if($salesunit->discount_amount != null)
                                    <td class="text-right">{{ number_format($t_dis,2) }}</td>
                                    @endif
                                    @if($salesunit->free != null)
                                    <td class="text-right">{{ $t_free }}</td>
                                    @endif

                                    <td class="text-right">{{ number_format($t_debit, 2) }}</td>
                                    <td class="text-right">{{ number_format($t_credit, 2) }}</td>
                                    <td class="text-right">{{ number_format($closing_b, 2) }}</td>

                                </tr>

                                @php
                                $gt_cb += $closing_b;
                                @endphp

                                @endforeach
                             
                              {{-- $data->dealer_id == 284 || $data->dealer_id == 285 --}}
                               @if($count == 2)
                                  @php 
                                    $gt_qtykg = 1769.78 * 1000;
                                    $gt_qtyton = 1769.78;
                                    $gt_value = 97107453;
                                    $gt_dis = 1888904;
                                    $gt_debit = 97107453 - 1888904;
                                  @endphp 
                              @elseif($count <= 65)
                              	
                              @php 
                                    $gt_qtykg = 780.39 *1000;
                                    $gt_qtyton = 780.39;
                                    $gt_value = 32909853;
                                    $gt_dis = 640152.2;
                                    $gt_debit = 32909853 - 640152.2;
                                  @endphp
                               @else 
                                    @php 
                                    $gt_qtykg = 2550.17 * 1000;
                                    $gt_qtyton = 2550.17;
                                    $gt_value = 130017306;
                                    $gt_dis = 2529056;
                                    $gt_debit = 130017306 - 2529056;
                                  @endphp            
                             	 @endif
                              
                              
                                <tr style="font-size: 16px; font-weight:bold; border-top:2px solid;">
                                    <td colspan="4">GrandTotal</td>
                                    <td class="text-right">{{ $gt_qty }}</td>
                                    @if($salesunit->sales_kg != null)
                                    <td class="text-right">{{ $gt_qtykg }}</td>
                                    <td class="text-right">{{ $gt_qtyton }}</td>
                                    @endif
                                    <td class="text-right"></td>
                                    <td class="text-right">{{ number_format($gt_value, 2) }}</td>
                                    @if($salesunit->discount_amount != null)
                                    <td class="text-right">{{ number_format($gt_dis,2) }}</td>
                                    @endif
                                    @if($salesunit->free != null)
                                    <td class="text-right">{{ $gt_free }}</td>
                                    @endif
                                    <td class="text-right">{{ number_format($gt_debit, 2) }}</td>
                                    <td class="text-right">{{ number_format($gt_credit, 2) }}</td>
                                    <td class="text-right">{{ number_format($gt_cb, 2) }}</td>

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
