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

                <div class="py-4 col-md-6 m-auto">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="table-header-fixt-top">
                                <th>Category</th>
                                {{--
																	<th colspan="2" style="text-align:center;">Opening Balance</th>
                                <th>Rate</th>
                                <th colspan="2" style="text-align:center;">Stock In</th>
                                <th colspan="2" style="text-align:center;">Stock out</th>
                                <th>Con. Rate</th>
                                <th>Con. Amount</th>
																<th colspan="2" style="text-align:center;">Wastage</th>
                                <th colspan="2" style="text-align:center;">Return</th>
                                <th colspan="2" style="text-align:center;">Transfer In</th>
                                <th colspan="2" style="text-align:center;">Transfer Out</th>
                                 <th colspan="2" style="text-align:center;">Damage</th>
                                <th colspan="2" style="text-align:center;">Closing Balance</th> --}}

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
													$gtotal_wastage = 0;
													$gtotal_clb = 0;
													$gtotal_value = 0;
													$grandTotalStockAmount = 0;
													$allStockInAmount = 0;
													@endphp
													@for($i = 0; $i < $count; $i++)

                         @php

														$startdate = '2023-10-01';
														$totalPackingConsumption = \App\Models\PackingConsumptions::whereBetween('date',[$startdate,$tdate])->sum('amount');
														$totalPackingCost = \App\Models\Account\ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','Sal-%')->whereBetween('date',[$startdate,$tdate])->sum('debit');
														$totalPackingReturnCost = \App\Models\Account\ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','SR-Inv-%')->whereBetween('date',[$startdate,$tdate])->sum('credit');
														$totalReturnValue = \App\Models\Account\ChartOfAccounts::where('ac_sub_account_id',1)->where('ac_sub_sub_account_id',25)->where('invoice','like','SR-Inv-%')->whereBetween('date',[$startdate,$tdate])->sum('debit');
														//$totalPackingCost = \App\Models\Account\ChartOfAccounts::select(DB::raw('SUM(debit) as debit'),DB::raw('SUM(credit) as credit'))->where('ac_sub_account_id',8)->whereIn('ac_sub_sub_account_id',[14,163])->whereBetween('date',[$startdate,$tdate])->get();
                            //$totalPackingCost = $totalPackingCost[0]->debit - $totalPackingCost[0]->credit;

														if($product) {
									            $products = \App\Models\SalesProduct::whereIn('id', $product)->where('category_id',$category[$i])->orderby('product_name', 'asc')->get();
									          } else {
									              $products = \App\Models\SalesProduct::where('category_id',$category[$i])->orderby('product_name', 'asc')->get();
									          }
														$subStockOutAmount = 0;
														$subTotalAmount = 0;
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
                                    $allStock = \App\Models\SalesStockIn::select(DB::raw('SUM(quantity) as quantity'),DB::raw('SUM(total_cost) as amount'), DB::raw('AVG(production_rate) as rate'))->where('prouct_id',$all_products->id)->whereBetween('date',[$startdate,$tdate])->get();
                                    $todaystock = \App\Models\SalesStockIn::select(DB::raw('SUM(quantity) as quantity'),DB::raw('SUM(wastage) as wastageQty'), DB::raw('AVG(production_rate) as rate'))->join('sales_products as s', 'sales_stock_ins.prouct_id','=','s.id')->where('prouct_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('date',[$fdate,$tdate])->get();
                                    $openingstock = \App\Models\SalesStockIn::select(DB::raw('SUM(quantity) as quantity'), DB::raw('AVG(production_rate) as rate'))->join('sales_products as s', 'sales_stock_ins.prouct_id','=','s.id')->where('prouct_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('date',[$startdate,$fdate2])->get();

                                    $salesStockOut = \App\Models\SalesStockOut::select(DB::raw('SUM(sales_stock_outs.qty) as qty'), DB::raw('AVG(sales_stock_outs.rate) as rate'))->join('sales_products as s', 'sales_stock_outs.product_id','=','s.id')->where('sales_stock_outs.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('sales_stock_outs.date',[$startdate,$tdate])->get();
                                    $sales = \App\Models\SalesStockOut::select(DB::raw('SUM(sales_stock_outs.qty) as qty'), DB::raw('AVG(sales_stock_outs.rate) as rate'))->join('sales_products as s', 'sales_stock_outs.product_id','=','s.id')->where('sales_stock_outs.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('sales_stock_outs.date',[$fdate,$tdate])->get();
                                    $opsales = \App\Models\SalesStockOut::select(DB::raw('SUM(sales_stock_outs.qty) as qty'), DB::raw('AVG(sales_stock_outs.rate) as rate'))->join('sales_products as s', 'sales_stock_outs.product_id','=','s.id')->where('sales_stock_outs.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('sales_stock_outs.date',[$startdate,$fdate2])->get();

                                    $allReturn = DB::table('sales_return_items')->select(DB::raw('SUM(total_price) as amount'),DB::raw('SUM(qty) as qty'), DB::raw('AVG(unit_price) as rate'))->join('sales_products as s', 'sales_return_items.product_id','=','s.id')->where('sales_return_items.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('sales_return_items.date',[$startdate,$tdate])->get();
                                    $returnp = DB::table('sales_return_items')->select(DB::raw('SUM(qty) as qty'), DB::raw('AVG(unit_price) as rate'))->join('sales_products as s', 'sales_return_items.product_id','=','s.id')->where('sales_return_items.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('sales_return_items.date',[$fdate,$tdate])->get();
                                    $opreturnp =DB::table('sales_return_items')->select(DB::raw('SUM(qty) as qty'), DB::raw('AVG(unit_price) as rate'))->join('sales_products as s', 'sales_return_items.product_id','=','s.id')->where('sales_return_items.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('sales_return_items.date',[$startdate,$fdate2])->get();



                                    $transfer_from = \App\Models\Transfer::join('sales_products as s', 'transfers.product_id','=','s.id')->where('transfers.product_id',$all_products->id)->whereNotNull('from_wirehouse')->where('s.category_id',$category[$i])->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                    $optransfer_from = \App\Models\Transfer::join('sales_products as s', 'transfers.product_id','=','s.id')->where('transfers.product_id',$all_products->id)->whereNotNull('from_wirehouse')->where('s.category_id',$category[$i])->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                                    $transfer_to = \App\Models\Transfer::join('sales_products as s', 'transfers.product_id','=','s.id')->where('transfers.product_id',$all_products->id)->where('confirm_status', 1)->whereNotNull('to_wirehouse')->where('s.category_id',$category[$i])->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                    $optransfer_to = \App\Models\Transfer::join('sales_products as s', 'transfers.product_id','=','s.id')->where('transfers.product_id',$all_products->id)->where('confirm_status', 1)->whereNotNull('to_wirehouse')->where('s.category_id',$category[$i])->whereBetween('date',[$startdate,$fdate2])->sum('qty');


                                    $damage = \App\Models\SalesDamage::join('sales_products as s', 'sales_damages.product_id','=','s.id')->where('sales_damages.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                    $opdamage = \App\Models\SalesDamage::join('sales_products as s', 'sales_damages.product_id','=','s.id')->where('sales_damages.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('date',[$startdate,$fdate2])->sum('quantity');
																		$packingConsumptionAmount = \App\Models\PackingConsumptions::join('sales_products as s', 'packing_consumptions.product_id','=','s.id')->where('packing_consumptions.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('date',[$fdate,$tdate])->sum('amount');

                                    $thisMonthStockOutAmount = \App\Models\SalesStockOut::join('sales_products as s', 'sales_stock_outs.product_id','=','s.id')->where('product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('date',[$fdate,$tdate])->sum('amount');
                                    $stockOutAmount = \App\Models\SalesStockOut::where('product_id',$all_products->id)->whereBetween('date',[$startdate,$tdate])->sum('amount');

                                    $dataItemOP = \App\Models\SalesProduct::select('product_name','opening_balance')->where('id',$all_products->id)->where('category_id',$category[$i])->first();
									 									$product_name = $dataItemOP->product_name ?? '';



																			if($thisMonthStockOutAmount < 0){
																				$thisMonthStockOutAmount = ($sales[0]->qty+$returnp[0]->qty) * $salesStockOut[0]->rate;
																			}

																			/*
																			if($stockOutAmount  < 0){
																				$stockOutAmount = ($sales[0]->qty+$returnp[0]->qty) * $salesStockOut[0]->rate;
																			}
																			*/
																				$opblnce = ($openingstock[0]->quantity+$optransfer_to + $all_products->opening_balance)-($opsales[0]->qty+$optransfer_from+$opdamage);
                                        $clb = ($opblnce+$todaystock[0]->quantity+$transfer_to ) - ($sales[0]->qty+$transfer_from+$damage);


																			 if($allStock[0]->rate > 0){
																				$salesStockRate = \App\Models\SalesStockIn::where('prouct_id',$all_products->id)->orderBy('id','DESC')->first();
																				$rate = $salesStockRate->production_rate;

																			} else {
																				$rate = $all_products->rate;
																			}


                                      $sORate = $all_products->rate;
																			/*$value = $itemOpenBalance*$all_products->rate + $allReturn[0]->qty*$allReturn[0]->rate + $allStock[0]->quantity*$rate -
																									$salesStockOut[0]->qty*$rate; */

																	        $sOrate = $allStock[0]->rate ?? $rate;

																			$allStockInAmount += $allStock[0]->amount;
                                      $value = ($all_products->opening_balance*$all_products->rate)   + $allStock[0]->amount - $stockOutAmount;





                                        /* $gtotal_op+= $opblnce;
                                        $gtotal_si += $todaystock[0]->quantity;
                                        $gtotal_wastage += $todaystock[0]->wastageQty;
                                        $gtotal_so += $sales[0]->qty;
                                        $greturn += $returnp[0]->qty;
                                        $gtotal_trns_from += $transfer_from;
                                        $gtotal_trns_to += $transfer_to;
                                        $gtotal_dmg += $damage;
                                        $gtotal_clb += $clb; */
																				$gtotal_value += $value;
																				$stockOutASmount = $stockOutAmount;
																				$grandTotalStockAmount += $stockOutASmount;
																				$subStockOutAmount +=  $stockOutASmount;
																				$subTotalAmount += $value;

                                @endphp



                                {{-- <tr style="font-size: 12x;">

                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$product_name}}</td>
                                    <td>{{$opblnce * $all_products->product_weight}} @if($opblnce) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif </td>

                                    <td>{{$opblnce}} @if($opblnce) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>
                                    <td> @if($clb > 0) {{ number_format(($value/$clb),3) }} @else {{$rate}} @endif </td>
                                    <td>{{$todaystock[0]->quantity * $all_products->product_weight}} @if($todaystock[0]->quantity) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{$todaystock[0]->quantity}} @if($todaystock[0]->quantity) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>

                                    <td>{{($sales[0]->qty+$returnp[0]->qty) * $all_products->product_weight}} @if($sales[0]->qty) {{$all_products->weightUnit->unit_name ?? ''}} @else  @endif</td>
                                    <td>{{$sales[0]->qty+$returnp[0]->qty}} @if($sales[0]->qty) {{$all_products->unit->unit_name ?? ''}} @else  @endif</td>
                                    <td>@if(($sales[0]->qty+$returnp[0]->qty) > 0){{number_format(($thisMonthStockOutAmount/($sales[0]->qty+$returnp[0]->qty)),2)}} @else  @endif</td>
                                    <td>{{number_format($thisMonthStockOutAmount,2)}} </td>

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


                                </tr> --}}

                                @endforeach
                            {{--    @if($totalPackingConsumption)
                                <tr>
                                    <td colspan="2">F.G Packing Stock In</td>
                                    <td colspan="8" style="text-align:right;"></td>
									<td colspan="15" style="text-align:right;">{{number_format($totalPackingConsumption,2)}}</td>
                                </tr>
                                @endif
                                @if($totalPackingCost)
                                    <tr style="color: red;">
                                    <td colspan="2">F.G Packing Stock Out</td>
                                    <td colspan="8" style="text-align:right;"></td>
									<td colspan="15" style="text-align:right;">{{number_format(($totalPackingCost - $totalPackingReturnCost),2)}}</td>
                                </tr>
                                @endif --}}
																<tr >
	                                    <th >{{ \App\Models\SalesCategory::where('id',$category[$i])->value('category_name')}}</th>
	                                   {{-- <td colspan="9" style="text-align:right;">{{number_format($subStockOutAmount,2)}}</td>
	                                    <td colspan="9" style="text-align:right;"></td>  --}}
																			<td  style="text-align:right;">{{number_format($subTotalAmount,2)}}</td>
	                            	</tr>
																@endfor
                         </tbody>

                           <tfoot>

															<tr style="background-color: rgba(205, 102, 65, 0.5);">

                                    <th >Grand Total </th>
                                    {{--<td colspan="2" >{{$gtotal_op}}</td>
                                    <td colspan="2" >{{$gtotal_si}}</td>
                                    <td colspan="2" >{{$gtotal_so}}</td>
                                    <td colspan="2" >{{$gtotal_wastage}}</td>
                                    <td colspan="2" >{{$greturn}}</td>
                                    <td colspan="2" >{{$gtotal_trns_to}}</td>
                                    <td colspan="2" >{{$gtotal_trns_from}}</td>
                                    <td colspan="2" >{{number_format($gtotal_dmg, 2)}}</td>

                                    <td colspan="2" >{{number_format($gtotal_clb,2)}}</td> --}}
                                  {{--  <td colspan="9" style="text-align:right;">{{number_format($grandTotalStockAmount,2)}}</td>
                                    <td colspan="9" style="text-align:right;"></td> --}}
																		<td style="text-align:right;">{{number_format((($gtotal_value + $totalPackingConsumption + $totalPackingReturnCost) - $totalPackingCost),2)}}</td>
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
