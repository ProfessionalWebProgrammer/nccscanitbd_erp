@extends('layouts.sales_dashboard')
@section('print_menu')



@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"  >


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                           Export
                        </button>
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                           Print
                        </button>
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printland()"  id="printland"  >
                           PrintLands.
                        </button>
                    </div>
                </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">
              	 <div class="challanlogo" align="center" >
                   <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Category Wise Sales Report</h5>
                      <p>From {{date('d M, Y',strtotime($datefrom))}} to {{date('d M, Y',strtotime($dateto))}}</p>

                        </div>
                        <div class="col-md-4 pt-3 text-center">
                            <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  			<p>Head office, Rajshahi, Bangladesh</p>
                        </div>
                    </div>
                   </div>
                <div class="py-4">
                    <table  id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr  class="table-header-fixt-top text-center" style="font-size: 18px;  font-weight:600;">
                                <th>SI. No</th>
                                <th>Product Name</th>
                                <th colspan="3">Quantity</th>
                                {{-- <th>Qty (KG)</th>
                                <th>Qty (Ton)</th> --}}
                                <th>Rate</th>
                                <th>Total Value</th>

                                <th>Discount Amount</th>
                                <th>Return Amount</th>
                                <th>Receive Amount</th>
                                <th>Due Amount</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $grnd_tqty = 0;
                                $grnd_tqtykg = 0;
                                $grnd_tqtyton = 0;
                                $grnd_tvalue = 0;
                                $grnd_tvalue_for_c_w_r_a = 0;
                                $gDiscount = 0;
                                $gReturn = 0;
                                $totalSalesReturnAmount = \App\Models\SalesReturn::whereBetween('date',[$datefrom, $dateto])
                                                          ->where('is_active',1)->sum('grand_total');
                            @endphp
                            @foreach ($category as $data)

                                @php

                                        $product_data = DB::table('sales_ledgers')
                                            ->select('product_id', 'product_name',
                                            DB::raw('SUM(qty_pcs) as total_qty'),
                                            DB::raw('SUM(qty_kg) as total_qty_kg'),
                                            DB::raw('SUM(total_price) as grand_total'),
                                            DB::raw('SUM(discount_amount) as discount')
                                            )->where('invoice','LIKE','Sal-%')
                                            ->whereBetween('ledger_date', [$datefrom, $dateto])
                                            ->where('category_id', $data->id);
                                        if ($wid) {
                                            $product_data =$product_data->where('warehouse_bank_id', $wid);
                                        }

                                        if ($vid) {
                                            $product_data =$product_data->where('vendor_id', $vid);
                                        }
                                            $product_data =$product_data->groupBy('product_id')
                                            ->groupBy('product_name')
                                            ->get();

                                        $cat_wise_total_receive_amounts = DB::table('payments')
                                            ->select('id', 'payment_type', 'category_id', 'amount', 'deleted_by')
                                            ->whereBetween('payment_date', [$datefrom, $dateto])
                                            ->whereNull('deleted_by')
                                            ->where('category_id', $data->id)->where('invoice', 'LIKE','Rec-%')->whereIN('payment_type', ['RECEIVE','EXPANSE'])->sum('amount');
                                        $grnd_tvalue_for_c_w_r_a += $cat_wise_total_receive_amounts ?? 0;
                                @endphp
                                @php
                                    $sub_tqty = 0;
                                    $sub_tqtykg = 0;
                                    $sub_tvalue = 0;
                                    $subDiscount = 0;
                                    $subReturn = 0;

                                @endphp
                                <tr>
                                    <td colspan="100%" style=" font-weight: 600; color:rgb(119, 119, 255)">{{ $data->category_name }}</td>
                                </tr>
                                @foreach ($product_data as $product)
                                    @php
                                        $grnd_tqty += $product->total_qty;
                                        $grnd_tqtykg += $product->total_qty_kg;
                                        $grnd_tvalue += $product->grand_total;

                                        $sub_tqty += $product->total_qty;
                                        $sub_tqtykg += $product->total_qty_kg;
                                        $sub_tvalue += $product->grand_total;
                                        $gDiscount += $product->discount;
                                        $subDiscount += $product->discount;
                                        $unit = \App\Models\SalesProduct::where('id', $product->product_id)->first();

                                          $return = abs(\App\Models\SalesReturnItem::where('product_id',$product->product_id)->whereBetween('date', [$datefrom, $dateto])->sum('total_price'));
                                          $gReturn += $return;
                                          $subReturn += $return;
                                        /* } else {
                                          $return = 0;
                                          $gReturn += $return;
                                          $subReturn += $return;
                                        } */

                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td align="right">{{ number_format($product->total_qty, 2) }} @if($product->total_qty) {{$unit->unit->unit_name}} @else  @endif </td>
                                        <td align="right">{{ number_format($product->total_qty_kg, 2) }} @if($product->total_qty_kg) {{$unit->weightUnit->unit_name}} @else  @endif </td>
                                        <td align="right">
                                            @if(!empty($unit->weightUnit->unit_name))
                                                @if($unit->weightUnit->unit_name == 'Kg'){{ number_format($product->total_qty_kg / 1000, 3) }} Ton @else  @endif
                                            @endif
                                        </td>
                                        <td align="right">{{ number_format($product->grand_total/$product->total_qty,2)}}</td>
                                        <td align="right">{{ number_format($product->grand_total, 2) }}</td>
                                        <td align="right">{{ number_format($product->discount, 2) }}</td>
                                        <td align="right">{{ number_format($return, 2) }}</td>
                                        <td align="right" title="Receive Amount" style="border: none;border-right:1px solid #dee2e6;"></td>
                                        <td align="right" title="Due Amount" style="border: none;"></td>
                                    </tr>
                                @endforeach
                                <tr style="background-color: #fdc6964f;">
                                    <th colspan="2" style="text-align:right">Sub Total:</th>
                                    <th style="text-align:right">{{ number_format($sub_tqty, 2) }} @if($sub_tqty) {{$unit->unit->unit_name}} @else  @endif </th>
                                    <th style="text-align:right">{{ number_format($sub_tqtykg, 2) }} @if($sub_tqtykg) {{$unit->unit->unit_name}} @else  @endif </th>
                                    <th style="text-align:right">
                                        @if(!empty($unit->weightUnit->unit_name))
                                            @if($unit->weightUnit->unit_name == 'Kg') {{ number_format($sub_tqtykg / 1000, 3) }} Ton @else  @endif
                                        @endif
                                    </th>
                                    <th></th>
                                    <th  style="text-align:right">{{ number_format(($sub_tvalue + $subDiscount) , 2) }}</th>
                                    <th  style="text-align:right">{{ number_format($subDiscount, 2) }}</th>
                                    <th  style="text-align:right">{{ number_format($subReturn, 2) }}</th>
                                    <th style="text-align:right" title="Receive Amount">{{number_format($cat_wise_total_receive_amounts, 2)}}</th>
                                    <th style="text-align:right" title="Due Amount">{{number_format(($sub_tvalue - ($subReturn + $cat_wise_total_receive_amounts)), 2)}}</th>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background-color: #80a5087c">
                                <th colspan="2" style="text-align:right">Grand Total:</th>
                                {{-- <th style="text-align:right">{{ number_format($grnd_tqty, 2) }}</th>
                                <th style="text-align:right">{{ number_format($grnd_tqtykg, 2) }}</th>
                                <th style="text-align:right">{{ number_format($grnd_tqtykg / 1000, 3) }}</th> --}}
                                <th colspan="5" style="text-align:right">{{ number_format(($gDiscount + $grnd_tvalue), 2) }}</th>
                                <th  style="text-align:right">{{ number_format($gDiscount, 2) }}</th>
                                <th  style="text-align:right">{{ number_format($totalSalesReturnAmount, 2) }}</th>
                                <th style="text-align:right" title="Receive Amount">{{ number_format($grnd_tvalue_for_c_w_r_a, 2) }}</th>
                                <th style="text-align:right" title="Due Amount">{{ number_format(($grnd_tvalue - ($totalSalesReturnAmount + $grnd_tvalue_for_c_w_r_a)), 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
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
                filename: "ShortSummaryReport.xls"
            });
        });
    });
  function printland() {

            	printJS({
                printable: 'contentbody',
                type: 'html',
                 font_size: '16px;',
                style: ' @page { size: A4 landscape; max-height:100%; max-width:100%} table, th, td {border: 1px solid black; border-collapse: collapse; padding: 0px 3px}  h5{margin-top: 0; margin-bottom: .5rem;} .challanlogo{margin-left:150px}'
              })

        }


</script>
@endsection
