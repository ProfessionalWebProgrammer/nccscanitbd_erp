@extends('layouts.purchase_deshboard')
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

			<li class="nav-item">

                </li>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                     {{-- <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button> --}}
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>
                </div>
            <div class="container-fluid" id="contentbody">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Purchase Stock  Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                        <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>


                <div class="py-4 table-responsive tableFixHead">
                    <table id="datatablecustom" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top" style="font-size: 16px;font-weight: bold;color: rgb(0, 0, 0);top: -25px;">
                              <th>Product Name</th>
                              <th>Opening Balance</th>
                              <th>Stock In</th>
                              <th>Stock In Rate</th>
                              <th>Stock Value</th>
                              <th>Stock Out</th>
                              <th>Stock Out Rate</th>
                              <th>Stock Out Value</th>
                              <th>Final Stock Value</th>
                              <th>Current Stock Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                $stocin = 0;
                                $stocinrate = 0;
                                $stocko = 0;
                                $total_opb = 0;
                                $total_stockin = 0;
                                $total_stockout = 0;
                                $total_stockval = 0;
                                $total_stockclval = 0;
                                $total_stockoutval = 0;
                                $total_currentval = 0;
                              	$stockTotalValue = 0;
                              	$gtotlaStock = 0;
                                @endphp
                                @foreach($products as $data)

                                @php

                               /* $opbcalculet = DB::select('SELECT sum(purchase_set_opening_balance.opening_balance) as opening_blns FROM `purchase_set_opening_balance` where purchase_set_opening_balance.product_id = "'.$data->product_id.'" and  purchase_set_opening_balance.date between "'.$sdate.'" and "'.$tdate.'"'); */
								/* $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            						where purchase_set_opening_balance.product_id="'.$data->id.'"  and  purchase_set_opening_balance.date between "'.$sdate.'" and "'.$tdate.'" ');
                              dd($opening_balance); */

                				$opbcalculet = DB::select('SELECT sum(row_materials_products.opening_balance) as opening_blns FROM `row_materials_products` where row_materials_products.id = "'.$data->id.'"');
								
                              
                                $stocin = DB::select('SELECT SUM(purchases.inventory_receive) as stock_in,
                                SUM(purchases.total_payable_amount) as stock_in_val FROM `purchases`
                                WHERE  purchases.product_id = "'.$data->id.'"  and  purchases.date between "'.$fdate.'" and "'.$tdate.'" ');
                              
                              
                              	$dataRate = DB::table('purchases')->select('bill_quantity','purchase_value')->where('product_id', $data->id)->whereBetween('date',[$sdate,$tdate])->get();
                              	//dd($dataRate);
                              	$valueTemp = 0;
                              	$valueQty = 0;
                              	$rate = 0;
                              	foreach($dataRate as $key => $val){
                              		
                              		$valueTemp += $val->purchase_value;	
                              		$valueQty += $val->bill_quantity;
                              	}
                              	if($valueTemp > 0 && $valueQty > 0){
                              		$rate = $valueTemp/$valueQty;
                              		$rate = round($rate,2);
                              	} else {
                              	$rate = 0;
                              }
                              
                              	$stockTotalValue += $stocin[0]->stock_in*$rate;
                              
								/*$preStocIn = DB::select('SELECT SUM(purchases.inventory_receive) as stock_in,AVG(purchases.purchase_rate) as stock_in_rate ,
                                SUM(purchases.total_payable_amount) as stock_in_val FROM `purchases`
                                WHERE  purchases.product_id = "'.$data->id.'"  and  purchases.date between "'.$sdate.'" and "'.$pdate.'" '); */
                              
                              
                                $stocinrate = DB::select('SELECT AVG(purchases.purchase_rate) as stock_in_rate FROM `purchases`
                                WHERE purchases.product_id = "'.$data->id.'" and  purchases.date between "'.$sdate.'" and "'.$tdate.'" ');
								
                              	
                                $stocko = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout,
                                SUM(purchase_stockouts.total_amount) as stockout_value  FROM `purchase_stockouts`
                                WHERE purchase_stockouts.product_id = "'.$data->id.'" and  purchase_stockouts.date between "'.$fdate.'" and "'.$tdate.'" ');
							
                              
                             	$total_stockoutval += round($stocko[0]->stockout,2)*$rate;
                              
                               /* $pre_stocko = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout,AVG(purchase_stockouts.stock_out_rate) as stockout_rate,
                                SUM(purchase_stockouts.stock_opening) as stockout_open  FROM `purchase_stockouts`
                                WHERE purchase_stockouts.product_id = "'.$data->id.'" and  purchase_stockouts.date between "'.$sdate.'" and "'.$pdate.'" ');*/
                              
                              $pre_stocko = DB::select('SELECT SUM(purchases.receive_quantity) as stockout,AVG(purchases.purchase_rate) as stockout_rate FROM `purchases`
                                WHERE purchases.product_id = "'.$data->id.'" and  purchases.date between "'.$sdate.'" and "'.$pdate.'" ');

                              	//$pre_stock =  $pre_stocko[0]->stockout_open - $pre_stocko[0]->stockout;
                              	$pre_stock = 0;
								$pre_stock +=  $pre_stocko[0]->stockout;
                              
                                $total_opb += ($opbcalculet[0]->opening_blns + $pre_stock)/1000;
                                $total_stockin += ($stocin[0]->stock_in)/1000;
                                $total_stockout += ($stocko[0]->stockout)/1000;

								$totalQty = round($opbcalculet[0]->opening_blns + $pre_stock,2) + round($stocin[0]->stock_in,2);
                              	//$total_stockoutval += $totalQty*$rate;
                                $total_stockval += ($totalQty)*$rate;
                                $total_stockclval += (($opbcalculet[0]->opening_blns + $pre_stock +$stocin[0]->stock_in)-$stocko[0]->stockout)/1000;
                                
                                $total_currentval +=($opbcalculet[0]->opening_blns + $pre_stock + $stocin[0]->stock_in)*$rate;
                                @endphp

                                <tr>
                                    <td>{{$data->product_name}}</td>
                                    <td>{{number_format($opbcalculet[0]->opening_blns + $pre_stock,2)}} Kg</td>
                                  {{-- <td>{{number_format(($opbcalculet[0]->opening_blns + $pre_stock)/1000,2)}} Ton</td> --}}
                                    @if(!$stocin[0]->stock_in)
                                    <td>0</td>
                                    @else
                                    <td>{{number_format($stocin[0]->stock_in,2)}} Kg</td>
                                  	{{-- <td>{{number_format(($stocin[0]->stock_in)/1000,2)}} Ton</td> --}}
                                    @endif
                                    <td>{{number_format($rate,2)}} Tk</td>
                                  @php 
                                  if(!$stocin[0]->stock_in){
                                  $qty = round($opbcalculet[0]->opening_blns + $pre_stock,2);
                                  } else {
                                  $qty = round($opbcalculet[0]->opening_blns + $pre_stock,2) + round($stocin[0]->stock_in,2);
                                  }
                                  $gtotlaStock += round($qty*$rate,2);
                                  
                                  @endphp 
                                  	 {{-- <td>{{number_format($qtyKg*$rate,2)}} (Dr)</td> --}}
                                   	<td>{{number_format($qty*$rate,2)}} (Dr)</td>
                                    <td>{{number_format(($stocko[0]->stockout),2)}} Kg</td>
                                  {{-- <td>{{number_format(($stocko[0]->stockout)/1000,2)}} Ton</td> --}}
                                    <td>{{number_format($rate,2)}} </td>
                                    <td>{{number_format(($stocko[0]->stockout*$rate),2)}} (Cr)</td>
                                    <td>{{number_format((($opbcalculet[0]->opening_blns + $pre_stock + $stocin[0]->stock_in)*$rate) - ($stocko[0]->stockout*$rate),2)}} (Dr)</td>
                                    <td>{{number_format((($opbcalculet[0]->opening_blns + $pre_stock + $stocin[0]->stock_in)-$stocko[0]->stockout)/1000,2)}} Ton</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                              @php 
                              /* $fdate = '2023-01-01';
                              $total = DB::table('purchases')->whereNotNull('raw_supplier_id')->whereNotNull('product_id')->whereBetween('date', [$sdate, $tdate])->sum('purchase_value'); */
                              //dd($total);
                              @endphp 
                                <tr style="background-color: rgba(247, 130, 130, 0.288)">
                                    <td><b>Total = </b></td>
                                    <td><b>{{number_format($total_opb,2)}} Ton</b></td>
                                    <td><b>{{number_format($total_stockin,2)}} Ton</b></td>
                                    <td><b></b></td>
                                    <td><b>{{number_format($gtotlaStock,2)}} (Dr)</b></td>
                                    <td><b>{{number_format($total_stockout,2)}} Ton</b></td>
                                    <td><b></b></td>
                                    <td><b>{{number_format($total_stockoutval,2)}} (Cr)</b></td>
                                    <td><b>{{number_format($gtotlaStock - $total_stockoutval,2)}} (Dr)</b></td>
                                    <td><b>{{number_format($total_stockclval,2)}} Ton</b></td>
                                </tr>
                            </tfoot>

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
                filename: "StockReportPurchase.xls"
            });
        });
    });
</script>
@endsection
