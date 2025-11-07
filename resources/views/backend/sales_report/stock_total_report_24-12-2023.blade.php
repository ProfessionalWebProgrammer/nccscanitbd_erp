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
                                <th colspan="2" style="text-align:center;">Opening Balance</th>
                                <th>Rate</th>
                                <th colspan="2" style="text-align:center;">Stock In</th>
                                <th colspan="2" style="text-align:center;">Stock out</th>
                                <th>S.O Amount</th>
                                
																 <th colspan="2" style="text-align:center;">Wastage</th>
                                <th colspan="2" style="text-align:center;">Return</th>
                                <th colspan="2" style="text-align:center;">Transfer In</th>
                                <th colspan="2" style="text-align:center;">Transfer Out</th>
                                 <th colspan="2" style="text-align:center;">Damage</th>

                                <th colspan="2" style="text-align:center;">Closing Balance</th>
                                <th style="text-align:center;">Amount</th>
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
														$gtotal_wastage = 0;
                            $gtotal_clb = 0;
														$gtotal_value = 0;
														$grandTotalStockAmount = 0; 
                        @endphp



                                @foreach($products as $all_products)
                                @php
                                   $startdate = '2023-09-30';
                          			if($fdate <= '2023-10-01')
                                       {
                                        $fdate2 = '2023-09-30';
                                        } else {
                                    	$fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
                                         }
																				 $value =0;
                                    $allStock = \App\Models\SalesStockIn::select(DB::raw('SUM(quantity) as quantity'),DB::raw('AVG(production_rate) as rate'))->where('prouct_id',$all_products->id)->whereBetween('date',[$startdate,$tdate])->get();
                                    $todaystock = \App\Models\SalesStockIn::select(DB::raw('SUM(quantity) as quantity'),DB::raw('SUM(wastage) as wastageQty'), DB::raw('AVG(production_rate) as rate'))->where('prouct_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->get();
                                    $openingstock = \App\Models\SalesStockIn::select(DB::raw('SUM(quantity) as quantity'), DB::raw('AVG(production_rate) as rate'))->where('prouct_id',$all_products->id)->whereBetween('date',[$startdate,$fdate2])->get();

                                    $salesStockOut = \App\Models\SalesLedger::select(DB::raw('SUM(qty_pcs) as qty'), DB::raw('AVG(unit_price) as rate'))->where('product_id',$all_products->id)->whereBetween('ledger_date',[$startdate,$tdate])->get();
                                    $sales = \App\Models\SalesLedger::select(DB::raw('SUM(qty_pcs) as qty'), DB::raw('AVG(unit_price) as rate'))->where('product_id',$all_products->id)->whereBetween('ledger_date',[$fdate,$tdate])->get();
                                    $opsales = \App\Models\SalesLedger::select(DB::raw('SUM(qty_pcs) as qty'), DB::raw('AVG(unit_price) as rate'))->where('product_id',$all_products->id)->whereBetween('ledger_date',[$startdate,$fdate2])->get();


                                    $allReturn = DB::table('sales_returns')->select(DB::raw('SUM(qty) as qty'), DB::raw('AVG(unit_price) as rate'))->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('product_id',$all_products->id)->whereBetween('sales_returns.date',[$startdate,$tdate])->get();
                                    $returnp = DB::table('sales_returns')->select(DB::raw('SUM(qty) as qty'), DB::raw('AVG(unit_price) as rate'))->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('product_id',$all_products->id)->whereBetween('sales_returns.date',[$fdate,$tdate])->get();
                                    $opreturnp =DB::table('sales_returns')->select(DB::raw('SUM(qty) as qty'), DB::raw('AVG(unit_price) as rate'))->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('product_id',$all_products->id)->whereBetween('sales_returns.date',[$startdate,$fdate2])->get();



                                    $transfer_from = \App\Models\Transfer::where('product_id',$all_products->id)->whereNotNull('from_wirehouse')->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                    $optransfer_from = \App\Models\Transfer::where('product_id',$all_products->id)->whereNotNull('from_wirehouse')->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                                    $transfer_to = \App\Models\Transfer::where('product_id',$all_products->id)->where('confirm_status', 1)->whereNotNull('to_wirehouse')->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                    $optransfer_to = \App\Models\Transfer::where('product_id',$all_products->id)->where('confirm_status', 1)->whereNotNull('to_wirehouse')->whereBetween('date',[$startdate,$fdate2])->sum('qty');


                                    $damage = \App\Models\SalesDamage::where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $opdamage = \App\Models\SalesDamage::where('product_id',$all_products->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');
																		$packingConsumptionAmount = \App\Models\PackingConsumptions::where('product_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('amount');

                                    $dataItemOP = \App\Models\SalesProduct::select('product_name','opening_balance')->where('id',$all_products->id)->first();
									 									$product_name = $dataItemOP->product_name;
                                    $itemOpenBalance = $dataItemOP->opening_balance;

																/*		if($packingConsumptionAmount){
																			$packingrate = $packingConsumptionAmount/$allStock[0]->quantity;
																		} else {
																			$packingrate = 0;
																		} */



																				$opblnce = ($openingstock[0]->quantity+$optransfer_to + $itemOpenBalance + $opreturnp[0]->qty)-($opsales[0]->qty+$optransfer_from+$opdamage);
                                        $clb = ($opblnce+$todaystock[0]->quantity+$transfer_to+$returnp[0]->qty)- ($sales[0]->qty+$transfer_from+$damage);

																			 /* $value = ($itemOpenBalance*$all_products->rate + $openingstock[0]->quantity*$openingstock[0]->rate
																									+ $opreturnp[0]->qty*$opreturnp[0]->rate + $todaystock[0]->quantity*$todaystock[0]->rate+$returnp[0]->qty*$returnp[0]->rate) -
																									($opsales[0]->qty*$opsales[0]->rate + $sales[0]->qty*$opsales[0]->rate);
																				*/

																			 if($allStock[0]->rate > 0){
																				//$rate = $allStock[0]->rate;
																				$salesStockRate = \App\Models\SalesStockIn::where('prouct_id',$all_products->id)->orderBy('id','DESC')->first();
																				$rate = ($salesStockRate->production_rate + $all_products->rate)/2;

																			} else {
																				$rate = $all_products->rate;
																			}

																			// $temp = $packingrate;

																			// dd($temp);

																			$value = $itemOpenBalance*$all_products->rate + $allReturn[0]->qty*$allReturn[0]->rate + $allStock[0]->quantity*$rate -
																									$salesStockOut[0]->qty*$rate;


																		/*	if($allStock[0]->quantity < $salesStockOut[0]->qty){
																				$value = ($itemOpenBalance - ( $salesStockOut[0]->qty - $allStock[0]->quantity) )*$all_products->rate + $allReturn[0]->qty*$allReturn[0]->rate + $allStock[0]->quantity*($rate + $packingrate) -
																										$salesStockOut[0]->qty*($rate + $packingrate);

																			} else {
																				$value = $itemOpenBalance*$all_products->rate + $allReturn[0]->qty*$allReturn[0]->rate + $allStock[0]->quantity*($rate + $packingrate) -
																										$salesStockOut[0]->qty*($rate + $packingrate);
																			} */




																		/*	if($todaystock[0]->rate){
																					$rate = ($todaystock[0]->rate+$all_products->rate)/2;
																					$value = $clb*$rate;
																				} else {
																					$value = $clb*$all_products->rate;
																				}
																				*/

																				/*
																				if($all_products->rate){
																						$value = $clb*$all_products->rate;
																					} else {
																							$value = $clb*$todaystock[0]->rate;
																					}
																					*/
																				//dd($todaystock[0]->rate);

                                        $gtotal_op+= $opblnce;
                                        $gtotal_si += $todaystock[0]->quantity;
                                        $gtotal_wastage += $todaystock[0]->wastageQty;
                                        $gtotal_so += $sales[0]->qty+$returnp[0]->qty;
                                        $greturn += $returnp[0]->qty;
                                        $gtotal_trns_from += $transfer_from;
                                        $gtotal_trns_to += $transfer_to;
                                        $gtotal_dmg += $damage;
                                        $gtotal_clb += $clb;
																				$gtotal_value += $value;
																				$stockOutASmount = ($sales[0]->qty+$returnp[0]->qty)*$rate; 
																				$grandTotalStockAmount += $stockOutASmount;

                                @endphp



                                <tr style="font-size: 12x;"><!--  -->

                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$product_name}}</td>
                                    <td>{{$opblnce * $all_products->product_weight}} @if($opblnce) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif </td>
                                    
                                    <td>{{$opblnce}} @if($opblnce) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{$rate}}</td>
                                    <td>{{$todaystock[0]->quantity * $all_products->product_weight}} @if($todaystock[0]->quantity) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{$todaystock[0]->quantity}} @if($todaystock[0]->quantity) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>
                                    
                                    <td>{{($sales[0]->qty+$returnp[0]->qty) * $all_products->product_weight}} @if($sales[0]->qty) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{$sales[0]->qty+$returnp[0]->qty}} @if($sales[0]->qty) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{number_format($stockOutASmount,2)}}</td>

																		<td>{{$todaystock[0]->wastageQty * $all_products->product_weight}} @if($todaystock[0]->wastageQty) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{$todaystock[0]->wastageQty}} @if($todaystock[0]->wastageQty) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>

                                    <td>{{round($returnp[0]->qty * $all_products->product_weight)}} @if($returnp[0]->qty) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{round($returnp[0]->qty)}} @if($returnp[0]->qty) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>

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
                                    <td colspan="2" >{{$gtotal_wastage}}</td>
                                    <td colspan="2" >{{$greturn}}</td>
                                    <td colspan="2" >{{$gtotal_trns_to}}</td>
                                    <td colspan="2" >{{$gtotal_trns_from}}</td>
                                    <td colspan="2" >{{number_format($gtotal_dmg, 2)}}</td>

                                    <td colspan="2" >{{number_format($gtotal_clb,2)}}</td> --}}
                                    <td colspan="8" style="text-align:right;">{{number_format($grandTotalStockAmount,2)}}</td>
									<td colspan="15" style="text-align:right;">{{number_format($gtotal_value,2)}}</td>
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
                filename: "Sales-Stock-Total-Report.xls"
            });
        });
    });
</script>
@endsection
