@extends('layouts.purchase_deshboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"  >


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row mt-3">
                  	<div class="col-md-12 text-right">
                      	<button class="btn btn-sm  btn-success mt-1" id="btnExport">Export </button>
                    	<button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >Print </button>
                      
                    </div>
                </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">SBMS V.2 - Scan It</h3>
                    <p>Official Conpany Address <br> Road:1200 , House 005, Dhaka- 1202</p>
                    <h6>01712345678 , 86458415</h6>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">G.P. Total Stock Report</h5>

                    <h6>From {{ date('d F Y', strtotime($fdate)) }}
                        To
                        {{ date('d F Y', strtotime($tdate)) }}</h6>

                    <hr>
                </div>
                <div class="py-4">
                    <table id="reporttable"  class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="table-header-fixt-top">
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
        
                                @foreach($gproducts as $all_products)
                                @php
                                   $startdate = '2021-01-01';
                                    $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
                          
                          			$todaystock = DB::table('general_purchases')->where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $openingstock = DB::table('general_purchases')->where('product_id',$all_products->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');
                                  
                                  
                                 
                                    $transfer_from = DB::table('general_transfers')->where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $optransfer_from = DB::table('general_transfers')->where('product_id',$all_products->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');
                                    
                                    $transfer_to = DB::table('general_transfers')->where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $optransfer_to = DB::table('general_transfers')->where('product_id',$all_products->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');
                                    
                                     $stockout = DB::table('general_stock_outs')->where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $opstockout = DB::table('general_stock_outs')->where('product_id',$all_products->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');
                                    
                                   
        							
                          
                                        $opblnce =($openingstock+$optransfer_to)-($opstockout+$optransfer_from);
                                        
                          
                                        $clb = ($opblnce+$openingstock+$transfer_to+$todaystock)- ($stockout+$transfer_from);
                                        
                                        $total_op += $opblnce;
                                        $total_si += $todaystock;
                                        $total_so += $stockout;
                                        $total_trns_to += $transfer_to;
                                        $total_trns_from += $transfer_from;
                                        $total_clb += $clb;                                        
                                                
                                @endphp

                                
                                
                                @if($opblnce != 0 || $clb != 0)
                                <tr style="font-size: 12x;">
                                    
                                    <td class="text-right">{{$loop->iteration}}</td>
                                    <td class="text-right">{{$all_products->gproduct_name}}</td>
                                  	<td class="text-right">{{$all_products->dimensions}}</td>
                                    <td class="text-right">{{$opblnce}}</td>
                                    <td class="text-right">{{$todaystock}}</td>
                                    <td class="text-right">{{$stockout}}</td>
                                    <td class="text-right">{{$transfer_to}}</td>
                                    <td class="text-right">{{$transfer_from}}</td>
                                    <td class="text-right">{{$clb}}</td>
                                    
                                </tr>
                                @endif
                                @endforeach
                           
                         </tbody>
                           <tfoot>
                            <tr style="background-color: rgba(255, 127, 80, 0.233);">
                                    <th></th>
                                    <th>Total</th>
                              		<td> </td>
                                    <td class="text-right">{{$total_op}}</td>
                                    <td class="text-right">{{$total_si}}</td>
                                    <td class="text-right">{{$total_so}}</td>
                                    <td class="text-right">{{$total_trns_to}}</td>
                                    <td class="text-right">{{$total_trns_from}}</td>                                   
                                    <td class="text-right">{{$total_clb}}</td>
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
                filename: "Purchase Total Stoct Report.xls"
            });
        });
    });
</script>
@endsection
