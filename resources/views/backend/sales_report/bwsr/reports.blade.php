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
                      <h5 class="text-uppercase font-weight-bold">Brand Wise Sales Report</h5>
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
                                <th>Brand Code</th>
                                <th>Brand Name</th>
                                <th colspan="3">Quantity</th>
                                <th>Net Sales</th>
                                <th>LMSD</th>
                                <th>LMSD GR(%)</th>
                                <th>SPLY</th>
                                <th>SPLY GR(%)</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $grnd_tqty = 0;
                                $grnd_tqtykg = 0;
                                $grnd_tqtyton = 0;
                                $grnd_tvalue = 0;
                                
                                $grnd_t_discount_v = 0;
                                $grnd_t_net_sale_v = 0;
                                $grand_t_return_v = 0;
                                $grand_t_collection_v = 0;
                                $grand_t_due_v = 0;
                                
                                $grand_lmsd_value_net_sale_amount = 0;
                                $grand_lmsd_gr = 0;
                                $grand_sply_value_net_sale_amount = 0;
                                $grand_sply_gr = 0;
                            @endphp
                            @foreach ($category as $data)

                                @php

                                        $product_data = DB::table('sales_ledgers')
                                            ->select('product_id', 'product_name', DB::raw('SUM(qty_pcs) as total_qty'), DB::raw('SUM(qty_kg) as total_qty_kg'), DB::raw('SUM(total_price) as grand_total'), DB::raw('SUM(discount_amount) as grand_total_discount_amount'))
                                            ->whereBetween('ledger_date', [$datefrom, $dateto])
                                            ->where('category_id', $data->id);
                                        
                                            $product_data =$product_data->groupBy('product_id')
                                            ->groupBy('product_name')
                                            ->get();
                                            
                                        
                                            
                                @endphp
                                @php
                                    $sub_tqty = 0;
                                    $sub_tqtykg = 0;
                                    $sub_tvalue = 0;
                                    
                                    $sub_t_discount_v = 0;
                                    $sub_t_net_sale_v = 0;
                                    $sub_t_return_v = 0;
                                    $sub_t_collection_v = 0;
                                    $sub_t_due_v = 0;
                                    
                                    $sub_lmsd_value_net_sale_amount = 0;
                                    $sub_lmsd_gr = 0;
                                    $sub_sply_value_net_sale_amount = 0;
                                    $sub_sply_gr = 0;
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
                                        $unit = \App\Models\SalesProduct::where('id', $product->product_id)->first();
                                        $sales_product = DB::table('sales_products')->where('id', $product->product_id)->first();
                                        $salesReturnAmount = DB::table('sales_return_items')
                                            ->whereBetween('date', [$datefrom, $dateto])
                                            ->where('product_id', $product->product_id)->sum('total_price');
                                            
                                        $collectionAmount = DB::table('payments')
                                            ->where('category_id', $data->id)
                                            ->whereBetween('payment_date', [$datefrom, $dateto])
                                            ->where('payment_type', 'RECEIVE')
                                            ->whereNull('deleted_by')
                                            ->sum('amount');
                                        
                                        
                                        $net_Sale_amount = $product->grand_total - $product->grand_total_discount_amount - $salesReturnAmount;
                                        $sub_t_discount_v += $product->grand_total_discount_amount;
                                        $sub_t_net_sale_v += $net_Sale_amount;
                                        $grnd_t_discount_v += $product->grand_total_discount_amount;
                                        $grnd_t_net_sale_v += $net_Sale_amount;
                                        
                                        
                                        $sub_t_return_v += $salesReturnAmount;
                                        $grand_t_return_v += $salesReturnAmount;
                                        
                                        $sub_t_collection_v += $collectionAmount;
                                        $grand_t_collection_v += $collectionAmount;
                                        
                                        
                                        
                                        $lmsd_value = DB::table('sales_ledgers')
                                            ->select('product_id', 'product_name', DB::raw('SUM(total_price) as grand_total'), DB::raw('SUM(discount_amount) as grand_total_discount_amount'))
                                            ->whereBetween('ledger_date', [$previousDateRange['previous_start_date'], $previousDateRange['previous_end_date']])
                                            ->where('product_id', $product->product_id)->first();
                                        $lmsd_salesReturnAmount = DB::table('sales_return_items')
                                            ->whereBetween('date', [$previousDateRange['previous_start_date'], $previousDateRange['previous_end_date']])
                                            ->where('product_id', $product->product_id)->sum('total_price');
                                            
                                        $lmsd_value_net_sale_amount = ($lmsd_value->grand_total - $lmsd_value->grand_total_discount_amount - $lmsd_salesReturnAmount);
                                        
                                        $lmsd_gr = ($lmsd_value_net_sale_amount != 0) ? ((($net_Sale_amount - $lmsd_value_net_sale_amount) / $lmsd_value_net_sale_amount) * 100) : 0;
                                        
                                        
                                        $sply_value = DB::table('sales_ledgers')
                                            ->select('product_id', 'product_name', DB::raw('SUM(total_price) as grand_total'), DB::raw('SUM(discount_amount) as grand_total_discount_amount'))
                                            ->whereBetween('ledger_date', [$previousDateRange['previous_year_start_date'], $previousDateRange['previous_year_end_date']])
                                            ->where('product_id', $product->product_id)->first();
                                        $sply_salesReturnAmount = DB::table('sales_return_items')
                                            ->whereBetween('date', [$previousDateRange['previous_year_start_date'], $previousDateRange['previous_year_end_date']])
                                            ->where('product_id', $product->product_id)->sum('total_price');
                                            
                                        $sply_value_net_sale_amount = ($sply_value->grand_total - $sply_value->grand_total_discount_amount - $sply_salesReturnAmount);
                                        
                                        $sply_gr = ($sply_value_net_sale_amount != 0) ? ((($net_Sale_amount - $sply_value_net_sale_amount) / $sply_value_net_sale_amount) * 100) : 0;
                                        
                                        $sub_lmsd_value_net_sale_amount += $lmsd_value_net_sale_amount;
                                        $sub_lmsd_gr += $lmsd_gr;
                                        $sub_sply_value_net_sale_amount += $sply_value_net_sale_amount;
                                        $sub_sply_gr += $sply_gr;
                                        
                                        $grand_lmsd_value_net_sale_amount += $lmsd_value_net_sale_amount;
                                        $grand_lmsd_gr += $lmsd_gr;
                                        $grand_sply_value_net_sale_amount += $sply_value_net_sale_amount;
                                        $grand_sply_gr += $sply_gr;
                                        
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sales_product->product_code }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td align="right">{{ number_format($product->total_qty, 2) }} @if($product->total_qty) {{$unit->unit->unit_name}} @else  @endif </td>
                                        <td align="right" colspan="2">{{ number_format($product->total_qty_kg, 2) }} @if($product->total_qty_kg) {{$unit->weightUnit->unit_name}} @else  @endif </td>
                                        <td align="right">{{ number_format($net_Sale_amount, 2) }}</td>
                                        <td align="right">{{ number_format($lmsd_value_net_sale_amount, 2) }}</td>
                                        <td align="right">{{ number_format($lmsd_gr, 2) }}%</td>
                                        <td align="right">{{ number_format($sply_value_net_sale_amount, 2) }}</td>
                                        <td align="right">{{ number_format($sply_gr, 2) }}%</td>
                                    </tr>
                                @endforeach
                                <tr style="background-color: #fdc6964f;">
                                    <th colspan="3" style="text-align:right">Sub Total:</th>
                                    <th style="text-align:right">{{ number_format($sub_tqty, 2) }} @if($sub_tqty) {{$unit->unit->unit_name}} @else  @endif </th>
                                    <th style="text-align:right">{{ number_format($sub_tqtykg, 2) }} @if($sub_tqtykg) {{$unit->unit->unit_name}} @else  @endif </th>
                                    <th style="text-align:right">
                                        @if(!empty($unit->weightUnit->unit_name))
                                            @if($unit->weightUnit->unit_name == 'Kg') {{ number_format($sub_tqtykg / 1000, 3) }} Ton @else  @endif
                                        @endif
                                    </th> 
                                    <th  style="text-align:right">{{ number_format($sub_t_net_sale_v, 2) }}</th>
                                    <th align="right" style="text-align:right">{{ number_format($sub_lmsd_value_net_sale_amount, 2) }}</th>
                                    <th align="right" style="text-align:right">{{ number_format($sub_lmsd_gr, 2) }}%</th>
                                    <th align="right" style="text-align:right">{{ number_format($sub_sply_value_net_sale_amount, 2) }}</th>
                                    <th align="right" style="text-align:right">{{ number_format($sub_sply_gr, 2) }}%</th>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background-color: #80a5087c">
                                <th colspan="3" style="text-align:right">Grand Total:</th>
                                <th colspan="3"></th>
                                <th  style="text-align:right">{{ number_format($grnd_t_net_sale_v, 2) }}</th>
                                <th align="right" style="text-align:right">{{ number_format($grand_lmsd_value_net_sale_amount, 2) }}</th>
                                <th align="right" style="text-align:right">{{ number_format($grand_lmsd_gr, 2) }}%</th>
                                <th align="right" style="text-align:right">{{ number_format($grand_sply_value_net_sale_amount, 2) }}</th>
                                <th align="right" style="text-align:right">{{ number_format($grand_sply_gr, 2) }}%</th>
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
