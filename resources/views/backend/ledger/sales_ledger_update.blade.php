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

    .table thead tr th{
        background: #f8f9fa !important;
        color:#000;
    }

   

    .table_head th{
        font-size: 16px;
        font-weight: 900;
    }

    .tabe_dealer_name_and_ob, .table_footer_subtotal{
        font-size: 14px;
        color: #000;
        font-weight: 900;
        border-bottom: 2px solid;
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
                            {{-- <div class="col-md-4 text-right pr-3">
                                @if($count == 1)
                                <h5 style="font-weight: 800;" class="">{{$ledgers[0]->d_s_name}}</h5>
                                <h6 style="font-weight: 800;">{{$ledgers[0]->dlr_address}}</h6>
                                <h6 style="font-weight: 800;">{{$ledgers[0]->dlr_mobile_no}}</h6>
                                @if($ledgers[0]->dlr_mail)<a href="mailto:{{$ledgers[0]->dlr_mail}}">{{$ledgers[0]->dlr_mail}}</a>@endif
                                @endif
                            </div> --}}
                        </div>
                        @if($count != 1)
                        @php
                          $dealers = \App\Models\Account\ChartOfAccounts::with('acIndividualAccount:id,title')
                                      ->select('ac_individual_account_id',DB::raw('SUM(debit) as total_debit'))->where('invoice', 'LIKE','Sal-%')
                                      ->where('ac_sub_sub_account_id',15)->whereBetween('date',[$fdate,$tdate])->groupBy('ac_individual_account_id')->get();
                                      $total_Sales = 0;
                          $discount = \App\Models\SalesLedger::select(DB::raw('SUM(discount_amount) as total_discount'),DB::raw('SUM(debit) as total_debit'))->where('invoice','LIKE','Sal-%')->whereBetween('ledger_date',[$fdate,$tdate])->get();
                          $totalCashCollection = \App\Models\Payment::where('payment_type','RECEIVE')
                                                  ->where('type','CASH')
                                                  ->where('invoice','LIKE','Rec-%')
                                                  ->whereNotNull('vendor_id')
                                                  ->whereBetween('payment_date',[$fdate,$tdate])->where('status',1)
                                                  ->sum('amount');
                          $totalBankCollection = \App\Models\Payment::where('type','BANK')
                                                  ->where('invoice','LIKE','Rec-%')
                                                  ->whereNotNull('vendor_id')
                                                  ->whereBetween('payment_date',[$fdate,$tdate])->whereNotIn('status',[0])
                                                  ->sum('amount');
                            $totalJournalAmount = \App\Models\Account\ChartOfAccounts::whereBetween('date',[$fdate,$tdate])
                                                  ->where('ac_sub_sub_account_id',15)->where('invoice','LIKE','Jar-%')->sum('credit');

                            $totalSalesReturnAmount = \App\Models\SalesReturn::whereBetween('date',[$fdate,$tdate])
                                                      ->where('is_active',1)->sum('grand_total');
                          //dd($discount[0]->total_debit);
                        @endphp
                        <div class="col-md-12">
                          <h5><strong>Short Summary Report</strong></h5>
                          <div class="row">
                            <div class="col-md-4">
                              <table class="table table-bordered p-2" style="font-size: 13px;font-weight: 600; border:2px solid; ">
                                  <thead>
                                    <tr class="table_head">
                                      <th>Head</th>
                                      <th>Amount</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Total Sales </td>
                                      <td>{{number_format(($discount[0]->total_debit + $discount[0]->total_discount), 2)}}</td>
                                    </tr>
                                    <tr>
                                      <td>Total Discount</td>
                                      <td>{{ number_format($discount[0]->total_discount,2) }}</td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                              <table class="table table-bordered p-2" style="font-size: 13px;font-weight: 600; border:2px solid; ">
                                  <thead>
                                    <tr class="table_head">
                                      <th>Head</th>
                                      <th>Amount</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Total Sales Return</td>
                                      <td>{{number_format($totalSalesReturnAmount, 2)}}</td>
                                    </tr>
                                    <tr>
                                      <td>Total Journal Amount</td>
                                      <td>{{ number_format($totalJournalAmount,2) }}</td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                              <table class="table table-bordered p-2" style="font-size: 13px;font-weight: 600; border:2px solid; ">
                                  <thead>
                                    <tr class="table_head">
                                      <th>Head</th>
                                      <th>Amount</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Total Bank Collection</td>
                                      <td>{{number_format($totalBankCollection, 2)}}</td>
                                    </tr>
                                    <tr>
                                      <td>Total Cash Collection</td>
                                      <td>{{ number_format($totalCashCollection,2) }}</td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                          </div>
                        </div>
                        <!-- end -->


                        <div class="col-md-12">
                          <h5><strong>Dealer Short Summary</strong></h5>
                          <div class="row">
                            <div class="col-md-6" style="background: #f8f9fa; border-top: 1px solid #000; border-bottom: 1px solid #000;border-right: 1px solid #000;">
                              <div class="row ">
                                <div class="col-md-9 text-left pl-3">
                                  <h5><strong>Dealer Name</strong></h5>
                                </div>
                                <div class="col-md-3 text-right">
                                  <h5><strong>Amount</strong></h5>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6" style="background: #f8f9fa; border-top: 1px solid #000; border-bottom: 1px solid #000;">
                              <div class="row ">
                                <div class="col-md-9 text-left pl-3">
                                  <h5><strong>Dealer Name</strong></h5>
                                </div>
                                <div class="col-md-3 text-right">
                                  <h5><strong>Amount</strong></h5>
                                </div>
                              </div>
                            </div>

                            @foreach($dealers as $val)
                            @php
                            $total_Sales += $val->total_debit;
                            @endphp
                            <div class="col-md-6">
                              <div class="row" style="border-bottom:1px solid #333;">
                                <div class="col-md-9 text-left pl-3">
                                  <h6>{{$val->acIndividualAccount->title}}</h6>
                                </div>
                                <div class="col-md-3 text-right">
                                  <h6>{{number_format($val->total_debit,2)}}</h6>
                                </div>
                              </div>
                            </div>
                            @endforeach

                        </div>
                        </div>
                        @endif
                        <!-- top-end -->

                        <table class="table table-bordered p-2" style="font-size: 11px;font-weight: 600; border:2px solid; ">
                            <thead>
                                <tr class="text-center table_head" {{--style="background-color:white" --}}>
                                    <th>Date</th>
                                    <th>Store/Transaction</th>
                                    <th>Invoice</th>
                                    <th>Product</th>
                                    <!-- <th>PCS</th> -->
                                    <th>UMO</th>
                                    <th>UMO</th>
                                  	<th>Price </th>
                                    <th>Value</th>
                                    <th>Com.</th>
                                    <th>Goods Rtn</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Closing Balance</th>
                                </tr>
                            </thead>

                            <tbody style="font-size: 13px;">
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
                                $gt_pack = 0;
                                $gtReturn = 0;
                                @endphp


                                @foreach ($dealears as $data)
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
                                $t_pack = 0;
                                $tReturn = 0;
                                $stdate = "2023-09-30";
                                $opdata =  \App\Models\SalesLedger::select(DB::raw('sum(debit) as debit'),DB::raw('sum(credit) as credit'))
                                          ->whereBetween('ledger_date', [$stdate, $preday])->where('vendor_id',$data->id)->first();



                                if(!empty($product_id)){
								                          $datas = \App\Models\SalesLedger::where('vendor_id',$data->id)->whereIn('product_id',$product_id)->whereBetween('ledger_date' ,[$fdate,$tdate])
                                		      ->whereNotNull('vendor_id')->get();
                                } else {
                                $datas = \App\Models\SalesLedger::where('vendor_id',$data->id)->whereBetween('ledger_date' ,[$fdate,$tdate])
                                		      ->whereNotNull('vendor_id')->get();
                                }
                                $openigBalance = $data->dlr_base ?? 0  +$opdata->debit - $opdata->credit;

                                $closing_b = $openigBalance;

                                @endphp

                                <tr class="tabe_dealer_name_and_ob">
                                    <td colspan="6"><a href="{{url('/deler/index')}}?vendor_id={{$data->id}}" target="_blank" > {{ $data->d_s_name ?? ''}}</a>  </td>
                                    <!-- <td></td> -->
                                    <td></td>
                                    <td></td>
                                    <td colspan="4">Opening Balance</td>
                                    <td class="text-right">{{ number_format($openigBalance, 2) }} </td>
                                </tr>
                                @foreach ($datas as $key => $item)

                                @php

                               $unit = DB::table('sales_products')->where('id',$item->product_id)->value('product_weight_unit');


                                 if($unit == 4) {
                                   $t_qty += $item->qty_pcs;
                                   $gt_qty += $item->qty_pcs;
                              } elseif($unit == 2) {
                                $t_qtykg += $item->qty_kg;
                                $gt_qtykg += $item->qty_kg;

                              	/* $t_qtykg += $item->qty_kg;
                                $t_qtyton += $item->qty_kg /1000;
                              	$gt_qtykg += $item->qty_kg;
                                $gt_qtyton += $item->qty_kg /1000; */
                              }elseif($unit == 3){
                                   $t_pack += $item->qty_pcs;
                                   $gt_pack += $item->qty_pcs;
                              }
                                $t_value += $item->total_price + $item->discount_amount;
                                $t_dis += $item->discount_amount;

                                $t_debit += $item->debit;
                                $t_credit += $item->credit;
                                $closing_b += $item->debit-$item->credit;


                                $gt_value += $item->total_price;
                                $gt_dis += $item->discount_amount;

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
                                // $uniteWeight = $item->product->product_weight ?? 1;
                                @endphp
                                @if($item->priority != 9 && $item->priority != 4)

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
                                    <td class="<?= $clss ?>"> {{ $item->product_name }}  </td>
                                  {{--  <td class="text-right <?= $clss ?>">{{ $item->qty_pcs }}</td> --}}

                                    <td class="text-right <?= $clss ?>">{{ $item->qty_kg }} {{$item->product->weightUnit->unit_name ?? ''}}</td>
                                    {{-- @if($uniteWeight > 0)
                                    <td class="text-right <?= $clss ?>">{{ $item->qty_kg / $uniteWeight   }}  {{$item->product->unit->unit_name ?? ''}} </td>
                                    @else
                                    <td></td>
                                    @endif --}}
                                    <td class="text-right <?= $clss ?>">{{ $item->qty_pcs }}  {{$item->product->unit->unit_name ?? ''}}</td>

                                    <td class="text-right <?= $clss ?>">{{ number_format($item->unit_price,2) }}</td>
									                  <td class="text-right <?= $clss ?>">{{ number_format($item->total_price + $item->discount_amount, 2) }}</td>

                                    <td class="text-right <?= $clss ?>"> @if($item->discount){{number_format($item->discount_amount,2) }} ({{ $item->discount }}%) @endif</td>
                                    <td></td>
                                    <td class="text-right <?= $clss ?>">{{ number_format($item->debit, 2) }}</td>
                                    <td class="text-right <?= $clss ?>">{{ number_format($item->credit, 2) }}</td>
                                    <td class="text-right <?= $clss ?>">@if($item->priority != 0 || $item->credit != '' || $item->journal_id != '') {{ number_format($closing_b, 2) }} @else - @endif</td>
                                </tr>

                                @elseif($item->priority == 4)
                                @php
                                  $gtReturn += $item->credit;
                                  $tReturn += $item->credit;
                                @endphp
                                <tr>
                                    <td class="<?= $clss ?>">{{ date('d-m-y', strtotime($item->ledger_date)) }}</td>
                                    <td class="<?= $clss ?>">{{ $item->warehouse_bank_name }} @if(!empty($item->narration))<br>{{$item->narration}} @else  @endif</td>
                                   <td class="<?=$clss?>" style="text-align:center;font-family: sans-serif;    font-weight: bold !important;">
                                 {{$item->invoice}}
                                </td>
                                    <td class="<?= $clss ?>"></td>

                                    <td class="text-right <?= $clss ?>"></td>

                                    <td class="text-right <?= $clss ?>"></td>

                                    <td class="text-right <?= $clss ?>"></td>
									                  <td class="text-right <?= $clss ?>"></td>

                                    <td class="text-right <?= $clss ?>"></td>
                                    <td class="text-right <?= $clss ?>">{{ number_format($item->credit, 2) }}</td>
                                    <td class="text-right <?= $clss ?>">{{ number_format($item->debit, 2) }}</td>
                                    <td class="text-right <?= $clss ?>"></td>
                                    <td class="text-right <?= $clss ?>">@if($item->priority != 0 || $item->credit != '' || $item->journal_id != '') {{ number_format($closing_b, 2) }} @else - @endif</td>
                                </tr>
                                @else

                                {{-- For Year Close Subtotal  --}}
                                @if($key != 0)
                                <tr style="font-size: 16px;color:#17a50d; font-weight:bold;border-bottom:2px solid;">
                                    <td colspan="4">Total (Year End)</td>


                                    {{--   <td class="text-right">{{ $t_qty }}</td>

                                 <td class="text-right">{{ $t_qtykg }}</td>
                                    <td class="text-right">{{ $t_qtyton }}</td> --}}
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>

                                    <td class="text-right"></td>
                                    <td class="text-right">{{ number_format($t_value, 2) }}</td>

                                    <td class="text-right">{{ $t_dis }}</td>
                                    <td></td>
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


                                <tr style="font-size: 11px; font-weight:bold;">
                                    <td class="<?= $clss ?>">{{ date('d-m-y', strtotime($item->ledger_date)) }}</td>
                                    <td colspan="5">Year End ({{ date('d-m-y', strtotime($item->ledger_date)) }})</td>


                                    <td></td>
                                    <td></td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Closing Balance</td>
                                    <td class="text-right">{{ number_format($closing_b, 2) }}</td>
                                </tr>

                                <tr style="font-size: 16px; font-weight:bold;">
                                    <td class="<?= $clss ?>">{{ date('d-m-y', strtotime($item->ledger_date)) }}</td>
                                    <td colspan="5">{{ $item->warehouse_bank_name }} ({{ date('d-m-y', strtotime($item->ledger_date)) }})</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td>Opening Balance</td>
                                    <td class="text-right">{{ number_format($closing_b, 2) }}</td>
                                </tr>


                                @endif


                                @endforeach


                                <tr class="table_footer_subtotal">
                                    <td colspan="4">Subtotal</td>


                                    {{--   <td class="text-right">{{ $t_qty }}</td>
                                 <td class="text-right">{{ $t_qtykg }}</td>
                                    <td class="text-right">{{ $t_qtyton }}</td>  --}}
                                    <td class="text-right" colspan="2"> @if(!empty($t_qty)){{ $t_qty }} Ctn  / @endif  @if(!empty($t_qtykg))  {{$t_qtykg}} Kg  @endif @if(!empty($t_pack)) {{$t_pack}} Pack  @endif </td>
                                    <td class="text-right"></td>
                                    <td class="text-right">{{ number_format($t_value, 2) }}</td>

                                    <td class="text-right">{{ number_format($t_dis,2) }}</td>
                                    <td class="text-right">{{ number_format($tReturn, 2) }}</td>
                                    <td class="text-right">{{ number_format($t_debit, 2) }}</td>
                                    <td class="text-right">{{ number_format(($t_credit - $tReturn), 2) }}</td>
                                    <td class="text-right">{{ number_format($closing_b, 2) }}</td>

                                </tr>

                                @php
                                $gt_cb += $closing_b;
                                @endphp

                                @endforeach


                                <tr>
                                    <td colspan="100%" style="border-left: white;border-right: white;padding: 30px;"></td>
                                </tr>
                                <tr style="font-size: 13px; font-weight:bold; border-top:2px solid;">
                                    <td colspan="4">GrandTotal</td>



                                  {{--  <td class="text-right">{{ $gt_qtykg }}</td>
                                    <td class="text-right">{{ $gt_qtyton }}</td> --}}

                                    <td class="text-right" colspan="2"> @if(!empty($gt_qty)){{ $gt_qty }} Ctn / @endif  @if(!empty($gt_qtykg))  {{$gt_qtykg}} Kg  @endif @if(!empty($gt_pack)) {{$gt_pack}} Pack  @endif</td>
                                    <td class="text-right"></td>
                                    <td class="text-right">{{ number_format(($gt_debit + $gt_dis), 2) }}</td>
                                    <td class="text-right">{{ number_format($gt_dis,2) }}</td>
                                    <td class="text-right">{{ number_format($gtReturn, 2) }}</td>
                                    <td class="text-right">{{ number_format($gt_debit, 2) }} </td>
                                    <td class="text-right">{{ number_format(($gt_credit - $gtReturn), 2) }}</td>
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
