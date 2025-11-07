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
                      <h5 class="text-uppercase font-weight-bold">Stock  Report</h5>
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
                            <tr>
                                <th>SI No</th>
                                <th>Product Name</th>
                              	<th>Dimensions</th>
                                <th>Opening Balance</th>
                                <th>Stock In</th>
                                <th>Stock out</th>
                                <th>Transfer In</th>
                                <th>Transfer Out</th>
                                <th>Closing Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                         @php
                            $greturn = 0;
                            $gtotal_trns_to = 0;
                            $gtotal_trns_from = 0;
                            $gtotal_op= 0;
                            $gtotal_so = 0;
                            $gtotal_si = 0;
                            $gtotal_dmg = 0;
                            $gtotal_clb = 0;
                        @endphp


                           @foreach($wirehousedata as $key=>$wdata)

                           @php
                            $return = 0;
                             $total_trns_to = 0;
                            $total_trns_from = 0;
                            $total_op= 0;
                            $total_so = 0;
                            $total_si = 0;
                            $total_dmg = 0;
                            $clb = 0;
                            $total_clb = 0;
                            @endphp
                            @php



                            @endphp
                            <tr style="background-color: rgba(127, 255, 212, 0.404);">
                                <td colspan="10">{{$wdata->wirehouse_name}}</td>

                            </tr>
                                @foreach($gproducts as $all_products)
                                @php
                                   $startdate = '2021-01-01';
                                    $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));

                          			$todaystock = DB::table('general_purchases')->where('product_id',$all_products->id)->where('warehouse_id',$wdata->wirehouse_id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $openingstock = DB::table('general_purchases')->where('product_id',$all_products->id)->where('warehouse_id',$wdata->wirehouse_id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');



                                    $transfer_from = DB::table('general_transfers')->where('product_id',$all_products->id)->where('from_wirehouse',$wdata->wirehouse_id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $optransfer_from = DB::table('general_transfers')->where('product_id',$all_products->id)->where('from_wirehouse',$wdata->wirehouse_id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                                    $transfer_to = DB::table('general_transfers')->where('product_id',$all_products->id)->where('to_wirehouse',$wdata->wirehouse_id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $optransfer_to = DB::table('general_transfers')->where('product_id',$all_products->id)->where('to_wirehouse',$wdata->wirehouse_id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                                     $stockout = DB::table('general_stock_outs')->where('product_id',$all_products->id)->where('wirehouse_id',$wdata->wirehouse_id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $opstockout = DB::table('general_stock_outs')->where('product_id',$all_products->id)->where('wirehouse_id',$wdata->wirehouse_id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');




                                        $opblnce =($openingstock+$optransfer_to)-($opstockout+$optransfer_from);


                                        $clb = ($opblnce+$transfer_to+$todaystock)- ($stockout+$transfer_from);

                                        $total_op += $opblnce;
                                        $total_si +=$todaystock;
                                        $total_so += $stockout;
                                        $total_trns_to += $transfer_to;
                                        $total_trns_from += $transfer_from;
                                        $total_clb += $clb;

                                        $gtotal_op+= $opblnce;
                                        $gtotal_si += $todaystock;
                                        $gtotal_so += $stockout;
                                        $gtotal_trns_from += $transfer_from;
                                        $gtotal_trns_to += $transfer_to;
                                        $gtotal_clb += $clb;


                                @endphp


                                @if($opblnce != 0 || $todaystock != 0 || $transfer_to != 0 || $transfer_from != 0 || $clb != 0)
                                <tr style="font-size: 12x;">

                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-left">{{$all_products->gproduct_name}}</td>
                                  	<td class="text-left">{{$all_products->dimensions}}</td>
                                    <td class="text-right">{{$opblnce}}</td>
                                    <td class="text-right">{{$todaystock}}</td>
                                    <td class="text-right">{{$stockout}}</td>
                                     <td class="text-right">{{$transfer_to}}</td>
                                    <td class="text-right">{{$transfer_from}}</td>


                                   <td class="text-right">{{$clb}}</td>

                                </tr>
                                @endif
                                @endforeach
                          @if($total_clb != 0 || $total_op != 0)
                                 <tr style="background-color: rgba(255, 228, 196, 0.247);">
                                    <td class="text-right"></td>
                                    <td class="text-right"> Sub Total</td>
                                    <td class="text-right"> </td>
                                    <td class="text-right">{{$total_op}}</td>
                                    <td class="text-right">{{$total_si}}</td>
                                    <td class="text-right">{{$total_so}}</td>

                                    <td class="text-right">{{$total_trns_to}}</td>
                                    <td class="text-right">{{$total_trns_from}}</td>

                                    <td class="text-right">{{$total_clb}}</td>
                                </tr>
                          @endif
                         @endforeach

                         </tbody>
                           <tfoot>
                            <tr style="background-color: rgba(255, 127, 80, 0.233);">
                                    <th class="text-right"></th>
                                    <th class="text-right">Total</th>
                              		<td class="text-right"> </td>
                                    <td class="text-right">{{$gtotal_op}}</td>
                                    <td class="text-right">{{$gtotal_si}}</td>
                                    <td class="text-right">{{$gtotal_so}}</td>
                                    <td class="text-right">{{$gtotal_trns_to}}</td>
                                    <td class="text-right">{{$gtotal_trns_from}}</td>

                                    <td class="text-right">{{$gtotal_clb}}</td>
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
