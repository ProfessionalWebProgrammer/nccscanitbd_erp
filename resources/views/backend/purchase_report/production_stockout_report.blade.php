@extends('layouts.purchase_deshboard')


@section('print_menu')

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >



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
                    </div>
                </div>
            <div class="container-fluid" id="contentbody">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Production J.V Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>




                <div class="py-4 table-responsive">
                    <table id="datatablecustom" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top">
                                   <th>No</th>
                                   <th>Item</th>
                                    <th>Opening</th>
                                    <th>Qty</th>
                                    <th>Closing</th>
                                   <th>Rate</th>
                                   <th>Total Amount</th>
                                 </tr>
                                 </thead>
                                 <tbody>

                                 @php
                                 $gtotalq = 0;

                                 $gtotala = 0;
                                 @endphp
                                  @foreach($wirehouses as $wdata)
                                    <tr>
                                     <td colspan="100%" style="background-color: #59c3a0;">{{$wdata->wirehouse_name}}</td>
                                    </tr>
                                   @php
                                 $totalq = 0;

                                 $totala = 0;
                                 @endphp

                                   @php



                 if($pid){

                   $stock_out_invoice = DB::select('SELECT purchase_stockouts.date,purchase_stockouts.finish_goods_id,purchase_stockouts.sout_number, sales_products.product_name as fgname,purchase_stockouts.batch,purchase_stockouts.fg_out_qty as fg_qty FROM `purchase_stockouts`
                 LEFT JOIN sales_products ON sales_products.id = purchase_stockouts.finish_goods_id
                 WHERE purchase_stockouts.wirehouse_id = "'.$wdata->wirehouse_id.'" and purchase_stockouts.finish_goods_id ="'.$pid.'" and purchase_stockouts.date between "'.$fdate.'" and "'.$tdate.'"
                 GROUP BY purchase_stockouts.sout_number');
                 }else{
                  $stock_out_invoice = DB::select('SELECT purchase_stockouts.date,purchase_stockouts.finish_goods_id,purchase_stockouts.sout_number, sales_products.product_name as fgname,purchase_stockouts.batch,purchase_stockouts.fg_out_qty as fg_qty FROM `purchase_stockouts`
                  LEFT JOIN sales_products ON sales_products.id = purchase_stockouts.finish_goods_id
                 WHERE purchase_stockouts.wirehouse_id = "'.$wdata->wirehouse_id.'" and purchase_stockouts.date between "'.$fdate.'" and "'.$tdate.'"
                 GROUP BY purchase_stockouts.sout_number');
                 }
                                  // dd($stock_out);
              //  dd($stock_out_invoice);

                                  @endphp
                  @foreach($stock_out_invoice as $stockdata)

                                   @php
                                     $stotalq = 0;

                                 $stotala = 0;

                                      if($pid){

                                       $stock_out = DB::select('SELECT purchase_stockouts.date,purchase_stockouts.finish_goods_id,purchase_stockouts.product_id,row_materials_products.product_name,SUM(purchase_stockouts.stock_out_quantity) as stock_out_quantity,SUM(purchase_stockouts.stock_opening) as stock_opening,AVG(purchase_stockouts.stock_out_rate) as stock_out_rate,
                                                     SUM(purchase_stockouts.total_amount) as total_amount, sales_products.product_name as fgname,purchase_stockouts.batch,purchase_stockouts.fg_qty FROM `purchase_stockouts`
                                     LEFT JOIN row_materials_products ON row_materials_products.id = purchase_stockouts.product_id
                                     LEFT JOIN sales_products ON sales_products.id = purchase_stockouts.finish_goods_id
                                     WHERE purchase_stockouts.sout_number = "'.$stockdata->sout_number.'" AND purchase_stockouts.wirehouse_id = "'.$wdata->wirehouse_id.'" and purchase_stockouts.finish_goods_id ="'.$pid.'" and purchase_stockouts.date between "'.$fdate.'" and "'.$tdate.'"
                                     GROUP BY purchase_stockouts.date,row_materials_products.product_name');
                                     }else{
                                      $stock_out = DB::select('SELECT purchase_stockouts.product_id,purchase_stockouts.finish_goods_id,row_materials_products.product_name,SUM(purchase_stockouts.stock_out_quantity) as stock_out_quantity,SUM(purchase_stockouts.stock_opening) as stock_opening,AVG(purchase_stockouts.stock_out_rate) as stock_out_rate,
                                                     SUM(purchase_stockouts.total_amount) as total_amount, sales_products.product_name as fgname,purchase_stockouts.batch,purchase_stockouts.fg_qty  FROM `purchase_stockouts`
                                     LEFT JOIN row_materials_products ON row_materials_products.id = purchase_stockouts.product_id
                                      LEFT JOIN sales_products ON sales_products.id = purchase_stockouts.finish_goods_id
                                     WHERE purchase_stockouts.sout_number = "'.$stockdata->sout_number.'" AND purchase_stockouts.wirehouse_id = "'.$wdata->wirehouse_id.'" and purchase_stockouts.date between "'.$fdate.'" and "'.$tdate.'"
                                     GROUP BY purchase_stockouts.date,row_materials_products.product_name');
                                     }
							
                                   
                                   
                                   @endphp
                                    <tr style="background-color:#ffbf6f">

                                      <td colspan="2">{{$stockdata->fgname}} (Finished Goods) </td>
                                       <td> Batch: ({{ $stockdata->batch}}) </td>
                                     <td>{{$stockdata->fg_qty}} (BAG) - (Dr)</td>
                                     <td></td>
                                     <td></td>
                                     <td></td>

                              	 	</tr>


                             @foreach($stock_out as $key=>$data)
                                  @php
                                 	$stotalq += $data->stock_out_quantity;
                                   	$gtotalq += $data->stock_out_quantity;                              		
									$stotala += $data->total_amount;                                
									$gtotala += $data->total_amount;

                                 @endphp
                                   <tr>
                                     <td>{{++$key}}</td>
                                      <td>{{$data->product_name}}</td>
                                       <td>{{$data->stock_opening}}</td>
                                       <td>{{$data->stock_out_quantity}}</td>
                                       <td>{{$data->stock_opening-$data->stock_out_quantity}}</td>
                                     <td>{{$data->stock_out_rate}}</td>
                                     <td>{{number_format($data->total_amount, 2)}}</td>

                               </tr>
                                 @endforeach

                                    <tr>

                                   <th colspan="2" style="text-align:center">SubTotal</th>
                                   <th></th>

                                      <th>{{$stotalq}} - (Cr)</th>
                                   <th></th>
                                   <th></th>
                                   <th>{{number_format($stotala, 2)}}</th>
                                 </tr>
                             @endforeach

                                   {{-- <tr  style="background: #e7b4b4;">

                                   <th colspan="2" style="text-align:center">Total</th>
                                     <th></th>
                                     <th>{{$totalq}}</th>

                                   <th></th>
                                   <th></th>
                                   <th>{{number_format($totala, 2)}}</th>
                                 </tr> --}}


                                  @endforeach


                                 <tr style="background: #a3a3a3;">
                                   <th colspan="2" style="text-align:center">Grand Total</th>
                                     <th></th>
                                   <th>{{$gtotalq}}</th>
                                   <th></th>
                                   <th></th>
                                   <th>{{number_format($gtotala, 2)}}</th>
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
                filename: "ProductionStockOut.xls"
            });
        });
    });
</script>
@endsection
