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
                      <h5 class="text-uppercase font-weight-bold">Category Sales Order Report</h5>
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
                                <th>Qty (Pcs)</th>
                                <th>Qty (KG)</th>
                                <th>Qty (Ton)</th>
                                <th>Total Value</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $grnd_tqty = 0;
                                $grnd_tqtykg = 0;
                                $grnd_tqtyton = 0;
                                $grnd_tvalue = 0;
                            @endphp
                            @foreach ($category as $data)

                                @php

                                        $product_data = DB::table('sales_order_items as t1')
                                            ->select('t1.product_id', 't2.product_name', 't1.product_weight',  DB::raw('SUM(t1.qty) as total_qty'), DB::raw('SUM(t1.total_price) as grand_total'))
                                            ->leftjoin('sales_products as t2', 't1.product_id', '=', 't2.id')
                                            ->whereBetween('date', [$datefrom, $dateto])
                                            ->where('t2.category_id', $data->id);
                                        

                                        if ($vid) {
                                            $product_data =$product_data->where('t1.dealer_id', $vid);
                                        }
                                            $product_data =$product_data->groupBy('t1.product_id')
                                            ->groupBy('t2.product_name')
                                            ->get();

                                @endphp
                                @php
                                    $sub_tqty = 0;
                                    $sub_tqtykg = 0;
                                    $sub_tvalue = 0;
                                @endphp
                                <tr>
                                    <td colspan="100%" style=" font-weight: 600; color:rgb(119, 119, 255)">{{ $data->category_name }}</td>
                                </tr>
                                @foreach ($product_data as $product)
                                    @php
                          				$orderKg = 0; 
                          				$orderKg = $product->total_qty*$product->product_weight;
                                        $grnd_tqty += $product->total_qty;
                                        $grnd_tqtykg += $orderKg;
                                        $grnd_tvalue += $product->grand_total;

                                        $sub_tqty += $product->total_qty;
                                        $sub_tqtykg += $orderKg;
                                        $sub_tvalue += $product->grand_total;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td align="right">{{ number_format($product->total_qty, 2) }}</td>
                                        <td align="right">{{ number_format($orderKg, 2) }}</td>
                                        <td align="right">{{ number_format($orderKg/1000, 3) }}</td>
                                        <td align="right">{{ number_format($product->grand_total, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr style="background-color: #fdc6964f;">
                                    <th colspan="2" style="text-align:right">Sub Total:</th>
                                    <th style="text-align:right">{{ number_format($sub_tqty, 2) }}</th>
                                    <th style="text-align:right">{{ number_format($sub_tqtykg, 2) }}</th>
                                    <th style="text-align:right">{{ number_format($sub_tqtykg / 1000, 3) }}</th>
                                    <th style="text-align:right">{{ number_format($sub_tvalue, 2) }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background-color: #80a5087c">
                                <th colspan="2" style="text-align:right">Total:</th>
                                <th style="text-align:right">{{ number_format($grnd_tqty, 2) }}</th>
                                <th style="text-align:right">{{ number_format($grnd_tqtykg, 2) }}</th>
                                <th style="text-align:right">{{ number_format($grnd_tqtykg / 1000, 3) }}</th>
                                <th style="text-align:right">{{ number_format($grnd_tvalue, 2) }}</th>
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
