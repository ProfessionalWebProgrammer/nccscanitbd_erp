@extends('layouts.sales_dashboard')

@section('print_menu')

			<li class="nav-item">

                </li>

@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 ">
          	<div class="row pt-2">
                  	<div class="col-md-12 text-right">
                         <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                           Export
                        </button>
                        <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                           Print
                        </button>
                    </div>
                </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">
              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">F.G Stock Report</h5>
                      <p>From {{date('d F, Y',strtotime($fdate))}} to {{date('d F, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                        <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>





                <div class="py-4">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="table-header-fixt-top">
                                <th>SI No</th>
                                <th>Product Name</th>
                                <th colspan="2" style="text-align:right;">Opening Balance</th>
                                <th colspan="2" style="text-align:right;">Stock In</th>
                                <th colspan="2" style="text-align:right;">Stock out</th>
                                <th colspan="2" style="text-align:right;">Return</th>
                                <th colspan="2" style="text-align:right;">Transfer In</th>
                                <th colspan="2" style="text-align:right;">Transfer Out</th>
                                 <th colspan="2" style="text-align:right;">Damage</th>
                                <th colspan="2" style="text-align:right;">Closing Balance</th>
                                <th style="text-align:right;">Amount</th>
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
														$gtotal_value = 0;
                        @endphp



                                @foreach($products as $all_products)
                                @php
                                   $startdate = '2023-10-01';
                          			if($fdate <= '2023-10-01')
                                       {
                                        $fdate2 = '2023-10-01';
                                        } else {
                                    	$fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
                                         }

                                    $todaystock = \App\Models\SalesStockIn::select(DB::raw('SUM(quantity) as quantity'), DB::raw('AVG(production_rate) as rate'))->where('prouct_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->get();
                                    $openingstock = \App\Models\SalesStockIn::where('prouct_id',$all_products->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                                    $sales = \App\Models\SalesLedger::where('product_id',$all_products->id)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');
                                    $opsales = \App\Models\SalesLedger::where('product_id',$all_products->id)->whereBetween('ledger_date',[$startdate,$fdate2])->sum('qty_pcs');


                                    $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('product_id',$all_products->id)->whereBetween('sales_returns.date',[$fdate,$tdate])->sum('qty');
                                     $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('product_id',$all_products->id)->whereBetween('sales_returns.date',[$startdate,$fdate2])->sum('qty');



                                    $transfer_from = \App\Models\Transfer::where('product_id',$all_products->id)->whereNotNull('from_wirehouse')->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                    $optransfer_from = \App\Models\Transfer::where('product_id',$all_products->id)->whereNotNull('from_wirehouse')->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                                    $transfer_to = \App\Models\Transfer::where('product_id',$all_products->id)->where('confirm_status', 1)->whereNotNull('to_wirehouse')->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                    $optransfer_to = \App\Models\Transfer::where('product_id',$all_products->id)->where('confirm_status', 1)->whereNotNull('to_wirehouse')->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                                    $damage = \App\Models\SalesDamage::where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $opdamage = \App\Models\SalesDamage::where('product_id',$all_products->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                                   // $dataItemOP = \App\Models\SalesProduct::select('product_name','opening_balance')->where('id',$all_products->id)->first();
									$product_name = $all_products->product_name;
                                    $itemOpenBalance = $all_products->opening_balance;

                                        $opblnce = ($openingstock+$optransfer_to + $itemOpenBalance)-($opsales+$optransfer_from+$opdamage);
                                        $clb = ($opblnce+$todaystock[0]->quantity+$transfer_to+$returnp)- ($sales+$returnp+$transfer_from+$damage);
																				/*if($todaystock[0]->rate){
																					$value = $clb*$todaystock[0]->rate;
																				} else {
																					$value = $clb*$all_products->rate;
																				} */
										if($all_products->rate){
                                        $value = $clb*$all_products->rate;
                                        } else {
                                       
                                        $value = $clb*$todaystock[0]->rate;
                                        }
                                          // dd($product_name);
                                        $gtotal_op+= $opblnce;
                                        $gtotal_si += $todaystock[0]->quantity;
                                        $gtotal_so += $sales+$returnp;
                                        $greturn += $returnp;
                                        $gtotal_trns_from += $transfer_from;
                                        $gtotal_trns_to += $transfer_to;
                                        $gtotal_dmg += $damage;
                                        $gtotal_clb += $clb;
																				$gtotal_value += $value;

                                @endphp


                               
                                <tr style="font-size: 12x;"><!--  -->

                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$product_name}}</td>
                                    <td>{{$opblnce * $all_products->product_weight}} @if($opblnce) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif </td>
                                    <td>{{$opblnce}} @if($opblnce) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>

                                    <td>{{$todaystock[0]->quantity * $all_products->product_weight}} @if($todaystock[0]->quantity) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{$todaystock[0]->quantity}} @if($todaystock[0]->quantity) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>

                                    <td>{{($sales+$returnp) * $all_products->product_weight}} @if($sales) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{$sales+$returnp}} @if($sales) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>

                                    <td>{{round($returnp * $all_products->product_weight)}} @if($returnp) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{round($returnp)}} @if($returnp) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>

                                     <td>{{$transfer_to * $all_products->product_weight}} @if($transfer_to) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                     <td>{{$transfer_to}} @if($transfer_to) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>

                                    <td>{{$transfer_from * $all_products->product_weight}} @if($transfer_from) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{$transfer_from}} @if($transfer_from) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>


                                    <td>{{number_format(($damage * $all_products->product_weight), 2)}} @if($damage) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{number_format($damage, 2)}} @if($damage) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>

                                    <td>{{number_format(($clb * $all_products->product_weight), 2)}} @if($clb) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{number_format($clb, 2)}} @if($clb) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>
																		<td style="text-align:right;">{{number_format($value,2)}}</td>

                                </tr>
                               
                                @endforeach

                         </tbody>
                           <tfoot>

								<tr style="background-color: rgba(255, 127, 80, 0.233);">
                                    <th colspan="2">Total</th>
                                    {{--<td colspan="2" >{{$gtotal_op}}</td>
                                    <td colspan="2" >{{$gtotal_si}}</td>
                                    <td colspan="2" >{{$gtotal_so}}</td>
                                    <td colspan="2" >{{$greturn}}</td>
                                    <td colspan="2" >{{$gtotal_trns_to}}</td>
                                    <td colspan="2" >{{$gtotal_trns_from}}</td>
                                    <td colspan="2" >{{number_format($gtotal_dmg, 2)}}</td>
                                    <td colspan="2" >{{number_format($gtotal_clb,2)}}</td> --}}
									<td colspan="100%" style="text-align:right;">{{number_format($gtotal_value,2)}}</td>
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
                filename: "Sales Stock Total Report.xls"
            });
        });
    });
</script>
@endsection
