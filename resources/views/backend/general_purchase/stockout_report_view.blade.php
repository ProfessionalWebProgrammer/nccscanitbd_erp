@extends('layouts.purchase_deshboard')


@section('print_menu')

			<li class="nav-item">

                </li>

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

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Stock Out Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>


                <div class="py-4">
                    <table id="reporttable"  class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SI No</th>
                                <th>Date</th>
                                <th>Invoice</th>
                              	<th>Product</th>
                              	<th>Quantity</th>
                              	<th>Dimensions</th>
                              	<th>Rate</th>
                              	<th>Value</th>
                              	<th>Reference</th>
                              	<th>Remaining Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php
                          	$gtotalqntty = 0;
                          	$gtotalprice = 0;
                          	$gtremaning = 0;
                          @endphp
                           @foreach($wirehouses as $wdata)
                                @php
                                  $wirehousename = DB::table('general_wirehouses')->where('wirehouse_id',$wdata->wirehouse_id)->value('wirehouse_name');
                                  $invoices = DB::table('general_stock_outs')
                                              ->whereBetween('date', [$fdate, $tdate])
                                              ->where('wirehouse_id', $wdata->wirehouse_id)
                                              ->get();
                          			$totalqntty = 0;
                          			$totalvalue =  0;
                          			$totalremaing = 0;
                                @endphp
                                <tr style="background-color: rgba(127, 255, 212, 0.404);">
                                    <td colspan="10">{{$wirehousename}}</td>
                                </tr>
                                @foreach($invoices as $data)
                          			@php

                          			$startdate = '2021-01-01';
                                    $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

                          			$todaystock = DB::table('general_purchases')->where('product_id',$data->product_id)->where('warehouse_id',$wdata->wirehouse_id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $transfer_from = DB::table('general_transfers')->where('product_id',$data->product_id)->where('from_wirehouse',$wdata->wirehouse_id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $transfer_to = DB::table('general_transfers')->where('product_id',$data->product_id)->where('to_wirehouse',$wdata->wirehouse_id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $stockout = DB::table('general_stock_outs')->where('product_id',$data->product_id)->where('wirehouse_id',$wdata->wirehouse_id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');

                          			$remaningbalance = ($todaystock+$transfer_to)-($transfer_from+$stockout);
                                    $productname = DB::table('general_products')->where('id',$data->product_id)->value('gproduct_name');
                          			$totalqntty += $data->quantity;
                          			$totalvalue +=  $data->quantity*$data->price;
                          			$totalremaing += $remaningbalance;
                                    @endphp
                          			<tr>
                                      	<td>{{$loop->iteration}}</td>
                                      	<td>{{$data->date}}</td>
                                      	<td>{{$data->id}}</td>
                                      	<td>{{$productname}}</td>
                                      	<td class="text-right">{{$data->quantity}}</td>
                                      	<td>{{$data->dimensions}}</td>
                                      	<td class="text-right">{{$data->price}}</td>
                                      	<td class="text-right">{{$data->quantity*$data->price}}</td>
                                      	<td class="text-right"> {{$data->Referance}}</td>
                                      	<td class="text-right"> {{$remaningbalance}}</td>

                                    </tr>
                                @endforeach
                          			<tr style="background: #ffa768;">
                                      	<td>Total</td>
                                      	<td></td>
                                      	<td></td>
                                      	<td></td>
                                      	<td class="text-right">{{$totalqntty}}</td>
                                      	<td></td>
                                      	<td class="text-right"></td>
                                      	<td class="text-right">{{$totalvalue}}</td>
                                      	<td></td>
                                      	<td class="text-right">{{$totalremaing}}</td>

                                    </tr>
                          		@php
                                  $gtotalqntty += $totalqntty;
                                  $gtotalprice += $totalvalue;
                                  $gtremaning += $totalremaing;
                                @endphp
                         @endforeach

                         </tbody>
                      	 <tfoot >
                           <tr style="background: orangered;">
                              <th colspan="4">Grand Total</th>
                              <th class="text-right">{{$gtotalqntty}}</th>
                              <th></th>
                              <th></th>
                              <th class="text-right">{{$gtotalprice}}</th>
                              <th></th>
                              <th class="text-right">{{$gtremaning}}</th>
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
                filename: "Sales Stoct Report.xls"
            });
        });
    });
</script>
@endsection
