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

            <div class="container" style="background:#ffffff; padding:0px 40px;min-height:85vh" id="contentbody">
              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h6 class="text-uppercase font-weight-bold">F.G Transfer Short Summary Report</h6>
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
                                <th>Unit</th>
                                <th>Rate</th>
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
    													$allStockInAmount = 0;
    													$gOpeningAmount = 0;
    													
    													$gTUnitsNames = [];
    													$gTWeightUnitsNames = [];
													@endphp
													@foreach ($wirehousedata as $key => $wdata)
													<tr style="background-color: rgba(127, 255, 212, 0.384);">
															<td colspan="100%">{{ $wdata->factory_name }}</td>
													</tr>
													@for($i = 0; $i < $count; $i++)
													<tr>
														<td colspan="100%"> {{ \App\Models\SalesCategory::where('id',$category[$i])->value('category_name')}}</td>
													</tr>
                         @php

														$startdate = '2023-10-01';
														$totalPackingConsumption = \App\Models\PackingConsumptions::whereBetween('date',[$startdate,$tdate])->sum('amount');
														$totalPackingCost = \App\Models\Account\ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','Sal-%')->whereBetween('date',[$startdate,$tdate])->sum('debit');
														$totalPackingReturnCost = \App\Models\Account\ChartOfAccounts::where('ac_sub_account_id',8)->where('ac_sub_sub_account_id',163)->where('invoice','like','SR-Inv-%')->whereBetween('date',[$startdate,$tdate])->sum('credit');


														if($product){
															$products = \App\Models\WarehouseProduct::select('product_id as id', 'opening','rate')
																					->where('type','fg')->whereIn('product_id', $product)
																					->where('category_id',$category[$i])
																					->where('warehouse_id',$wdata->id)->groupBy('product_id')->get();
														} else {
															$products = \App\Models\WarehouseProduct::select('product_id as id', 'opening','rate')
																				->where('type','fg')->where('category_id',$category[$i])
																				->where('warehouse_id',$wdata->id)->groupBy('product_id')->get();

														}

														$subStockOutAmount = 0;
														$subTotalAmount = 0;
														$subOpeningAmount = 0;
														
														$sTUnitsNames = [];
    													$sTWeightUnitsNames = [];
                            @endphp

                                @foreach($products as $all_products)
                                @php
                                   $startdate = '2023-09-30';
                          						if($fdate <= '2023-10-01')
                                       {
                                        $fdate2 = '2023-09-30';
                                        } else {
                                    	  $fdate2 = date('Y-m-d', strtotime('-1 day', strtotime($fdate)));
                                         }

																	 $value =0;
																	 $allStock = \App\Models\SalesStockIn::select(DB::raw('SUM(quantity) as quantity'),DB::raw('SUM(total_cost) as amount'), DB::raw('AVG(production_rate) as rate'))->where('prouct_id',$all_products->id)->where('factory_id', $wdata->id)->whereBetween('date',[$startdate,$tdate])->get();
																	 $todaystock = \App\Models\SalesStockIn::select(DB::raw('SUM(quantity) as quantity'),DB::raw('SUM(wastage) as wastageQty'), DB::raw('AVG(production_rate) as rate'))->join('sales_products as s', 'sales_stock_ins.prouct_id','=','s.id')->where('prouct_id',$all_products->id)->where('s.category_id',$category[$i])->where('factory_id', $wdata->id)->whereBetween('date',[$fdate,$tdate])->get();
																	 $openingstock = \App\Models\SalesStockIn::select(DB::raw('SUM(quantity) as quantity'), DB::raw('AVG(production_rate) as rate'))->join('sales_products as s', 'sales_stock_ins.prouct_id','=','s.id')->where('prouct_id',$all_products->id)->where('s.category_id',$category[$i])->where('factory_id', $wdata->id)->whereBetween('date',[$startdate,$fdate2])->get();

																	 $salesStockOut = \App\Models\SalesStockOut::select(DB::raw('SUM(sales_stock_outs.qty) as qty'), DB::raw('AVG(sales_stock_outs.rate) as rate'))->join('sales_products as s', 'sales_stock_outs.product_id','=','s.id')->where('sales_stock_outs.product_id',$all_products->id)->where('s.category_id',$category[$i])->where('wirehouse_id', $wdata->id)->whereBetween('sales_stock_outs.date',[$startdate,$tdate])->get();
																	 $sales = \App\Models\SalesStockOut::select(DB::raw('SUM(sales_stock_outs.qty) as qty'), DB::raw('AVG(sales_stock_outs.rate) as rate'))->join('sales_products as s', 'sales_stock_outs.product_id','=','s.id')->where('sales_stock_outs.product_id',$all_products->id)->where('s.category_id',$category[$i])->where('wirehouse_id', $wdata->id)->whereBetween('sales_stock_outs.date',[$fdate,$tdate])->where('invoice', 'LIKE','Sal-%')->get();
																	 $opsales = \App\Models\SalesStockOut::select(DB::raw('SUM(sales_stock_outs.qty) as qty'), DB::raw('AVG(sales_stock_outs.rate) as rate'))->join('sales_products as s', 'sales_stock_outs.product_id','=','s.id')->where('sales_stock_outs.product_id',$all_products->id)->where('s.category_id',$category[$i])->where('wirehouse_id', $wdata->id)->whereBetween('sales_stock_outs.date',[$startdate,$fdate2])->where('invoice', 'LIKE','Sal-%')->get();

																	// if($wdata->id == 35){

																		$allReturn = DB::table('sales_return_items')->select(DB::raw('SUM(total_price) as amount'),DB::raw('SUM(qty) as qty'), DB::raw('AVG(unit_price) as rate'))->join('sales_returns as sr','sr.id','=', 'sales_return_items.return_id')->join('sales_products as s', 'sales_return_items.product_id','=','s.id')->where('sr.warehouse_id',$wdata->id)->where('sales_return_items.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('sales_return_items.date',[$startdate,$tdate])->get();
																		$returnp = DB::table('sales_return_items')->select(DB::raw('SUM(qty) as qty'), DB::raw('AVG(unit_price) as rate'))->join('sales_returns as sr','sr.id','=', 'sales_return_items.return_id')->join('sales_products as s', 'sales_return_items.product_id','=','s.id')->where('sr.warehouse_id',$wdata->id)->where('sales_return_items.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('sales_return_items.date',[$fdate,$tdate])->get();
																		$opreturnp =DB::table('sales_return_items')->select(DB::raw('SUM(qty) as qty'), DB::raw('AVG(unit_price) as rate'))->join('sales_returns as sr','sr.id','=', 'sales_return_items.return_id')->join('sales_products as s', 'sales_return_items.product_id','=','s.id')->where('sr.warehouse_id',$wdata->id)->where('sales_return_items.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('sales_return_items.date',[$startdate,$fdate2])->get();


																	 $transfer_from = \App\Models\Transfer::select(DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as amount'))->join('sales_products as s', 'transfers.product_id','=','s.id')->where('transfers.product_id',$all_products->id)->whereNotNull('from_wirehouse')->where('s.category_id',$category[$i])->where('from_wirehouse', $wdata->id)->whereBetween('date',[$fdate,$tdate])->first();
																	 $optransfer_from = \App\Models\Transfer::select(DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as amount'))->join('sales_products as s', 'transfers.product_id','=','s.id')->where('transfers.product_id',$all_products->id)->whereNotNull('from_wirehouse')->where('s.category_id',$category[$i])->where('from_wirehouse', $wdata->id)->whereBetween('date',[$startdate,$fdate2])->first();

																	 $transfer_to = \App\Models\Transfer::select(DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as amount'))->join('sales_products as s', 'transfers.product_id','=','s.id')->where('transfers.product_id',$all_products->id)->whereNotNull('to_wirehouse')->where('s.category_id',$category[$i])->where('to_wirehouse', $wdata->id)->whereBetween('date',[$fdate,$tdate])->first();
																	 $optransfer_to = \App\Models\Transfer::select(DB::raw('SUM(qty) as qty'), DB::raw('SUM(price) as amount'))->join('sales_products as s', 'transfers.product_id','=','s.id')->where('transfers.product_id',$all_products->id)->where('to_wirehouse',$wdata->id)->where('s.category_id',$category[$i])->where('to_wirehouse', $wdata->id)->whereBetween('date',[$startdate,$fdate2])->first();


																	 $damage = \App\Models\SalesDamage::select(DB::raw('SUM(amount) as amount'),DB::raw('SUM(quantity) as qty'))->join('sales_products as s', 'sales_damages.product_id','=','s.id')->where('sales_damages.product_id',$all_products->id)->where('s.category_id',$category[$i])->where('warehouse_id', $wdata->id)->whereBetween('date',[$fdate,$tdate])->first();
 																	 $opdamage = \App\Models\SalesDamage::select(DB::raw('SUM(amount) as amount'),DB::raw('SUM(quantity) as qty'))->join('sales_products as s', 'sales_damages.product_id','=','s.id')->where('sales_damages.product_id',$all_products->id)->where('s.category_id',$category[$i])->where('warehouse_id', $wdata->id)->whereBetween('date',[$startdate,$fdate2])->first();
 																	 $packingConsumptionAmount = \App\Models\PackingConsumptions::join('sales_products as s', 'packing_consumptions.product_id','=','s.id')->where('packing_consumptions.product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('date',[$fdate,$tdate])->sum('amount');

																	 $thisMonthStockOutAmount = \App\Models\SalesStockOut::join('sales_products as s', 'sales_stock_outs.product_id','=','s.id')->where('product_id',$all_products->id)->where('s.category_id',$category[$i])->whereBetween('date',[$fdate,$tdate])->where('invoice', 'LIKE','Sal-%')->sum('amount');
																	 $stockOutAmount = \App\Models\SalesStockOut::where('product_id',$all_products->id)->where('wirehouse_id', $wdata->id)->whereBetween('date',[$startdate,$tdate])->sum('amount');

																	 $dataItemOP = \App\Models\SalesProduct::select('product_name','opening_balance')->where('id',$all_products->id)->where('category_id',$category[$i])->first();

																	 $item =  \App\Models\SalesProduct::where('id',$all_products->id)->first();
																		$product_name =   $item->product_name;
																		$unit = $item->unit->unit_name;
																		$weightUnit = $item->weightUnit->unit_name;
																		$weight = $item->product_weight;



																		 if($thisMonthStockOutAmount < 0){
																			 $thisMonthStockOutAmount = ($sales[0]->qty+$returnp[0]->qty) * $salesStockOut[0]->rate;
																		 }


																			 $opblnce = ($openingstock[0]->quantity + $optransfer_to->qty + $all_products->opening  + $opreturnp[0]->qty) - ($opsales[0]->qty + $optransfer_from->qty + $opdamage->qty);
																			 $clb = ($opblnce+$todaystock[0]->quantity + $transfer_to->qty + $returnp[0]->qty  ) - ($sales[0]->qty + $transfer_from->qty + $damage->qty);


																			if($allStock[0]->rate > 0){
																			 $salesStockRate = \App\Models\SalesStockIn::where('prouct_id',$all_products->id)->orderBy('id','DESC')->first();
																			 $rate = $salesStockRate->production_rate;

																		 } else {
																			 $rate = $all_products->rate;
																		 }


																		$sORate = $all_products->rate;

																		$sOrate = $allStock[0]->rate ?? $rate;

																		 $allStockInAmount += $allStock[0]->amount;

																		 $value = ($all_products->opening*$all_products->rate)   + $allStock[0]->amount + $optransfer_to->amount + $transfer_to->amount - ($stockOutAmount + $transfer_from->amount + $optransfer_from->amount + $opdamage->amount + $damage->amount);

																		 $openingAmount = $opblnce * $rate ;
																		 $subOpeningAmount += $openingAmount;
																		 $gOpeningAmount += $openingAmount;

																			 $gtotal_value += $value;
																			 $stockOutASmount = $stockOutAmount;
																			 $grandTotalStockAmount += $stockOutASmount;
																			 $subStockOutAmount +=  $stockOutASmount;
																			 $subTotalAmount += $value;
																			 
    													
																			    if(!empty($unit))
                                                                                {
                                                                                    $gTUnitsNames[] = strtoupper($unit);
                                                                                    $sTUnitsNames[] = strtoupper($unit);
                                                                                }else{
                                                                                    $gTUnitsNames[] = 'No-Unit';
                                                                                    $sTUnitsNames[] = 'No-Unit';
                                                                                }
                                                                                
                                                                                if(!empty($unit))
                                                                                {
                                                                                    $gTUnitsNames[strtoupper($unit)] = ($gTUnitsNames[strtoupper($unit)] ?? 0) + $clb;
                                                                                    $sTUnitsNames[strtoupper($unit)] = ($sTUnitsNames[strtoupper($unit)] ?? 0) + $clb;
                                                                                }else{
                                                                                    $gTUnitsNames['No-Unit'] = ($gTUnitsNames['No-Unit'] ?? 0) + $clb;
                                                                                    $sTUnitsNames['No-Unit'] = ($sTUnitsNames['No-Unit'] ?? 0) + $clb;
                                                                                }
                                                                                
                                                                                if(!empty($weightUnit))
                                                                                {
                                                                                    $gTWeightUnitsNames[] = strtoupper($weightUnit);
                                                                                    $sTWeightUnitsNames[] = strtoupper($weightUnit);
                                                                                }else{
                                                                                    $gTWeightUnitsNames[] = 'No-Unit';
                                                                                    $sTWeightUnitsNames[] = 'No-Unit';
                                                                                }
                                                                                
                                                                                if(!empty($weightUnit))
                                                                                {
                                                                                    $gTWeightUnitsNames[strtoupper($weightUnit)] = ($gTWeightUnitsNames[strtoupper($weightUnit)] ?? 0) + $clb;
                                                                                    $sTWeightUnitsNames[strtoupper($weightUnit)] = ($sTWeightUnitsNames[strtoupper($weightUnit)] ?? 0) + $clb;
                                                                                }else{
                                                                                    $gTWeightUnitsNames['No-Unit'] = ($gTWeightUnitsNames['No-Unit'] ?? 0) + $clb;
                                                                                    $sTWeightUnitsNames['No-Unit'] = ($sTWeightUnitsNames['No-Unit'] ?? 0) + $clb;
                                                                                }
                                @endphp



                                <tr style="font-size: 12x;"><!--  -->
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$product_name}}</td>
                                    <td>{{$unit ?? ''}}</td>
                                    <td>  {{number_format($rate,2)}} </td>
                                    <td>{{number_format(($clb * $weight), 2)}} @if($clb) {{$weightUnit ?? ''}} @else  @endif</td>
                                    <td>{{number_format($clb, 2)}} @if($clb) {{$unit ?? ''}} @else  @endif</td>
									<td style="text-align:right;">{{number_format($value,2)}}</td>
                                </tr>

                                @endforeach

									<tr style="background-color:#87cfef;">
	                                    <th colspan="6">Sub Total</th>
	                                    {{--<td>
	                                        @foreach(array_unique($sTWeightUnitsNames) as $key => $val)
                                                @if(is_string($key) && $val != 0)
                                                     {{number_format($val,2)}} {{$key}}/
                                                @endif
                                            @endforeach
	                                    </td>
	                                    <td>
	                                        @foreach(array_unique($sTUnitsNames) as $key => $val)
                                                @if(is_string($key) && $val != 0)
                                                     {{number_format($val,2)}} {{$key}}/ 
                                                @endif
                                            @endforeach
	                                    </td>--}}
										<td style="text-align:right;">{{number_format($subTotalAmount,2)}}</td>
	                            	</tr>
																@endfor
																@endforeach
																<tr>
																	<td colspan="6">Packing Amount : </td>
																	<td style="text-align:right;"> {{number_format(($totalPackingConsumption + $totalPackingReturnCost - $totalPackingCost),2)}} </td>
																</tr>
                         </tbody>

                           <tfoot>

															<tr style="background-color: rgba(205, 102, 65, 0.5);">

                                    <th colspan="6">Grand Total </th>
                                    
                                    {{--<td colspan="2" >{{$gtotal_op}}</td>
                                    <td colspan="2" >{{$gtotal_si}}</td>
                                    <td colspan="2" >{{$gtotal_so}}</td>
                                    <td colspan="2" >{{$gtotal_wastage}}</td>
                                    <td colspan="2" >{{$greturn}}</td>
                                    <td colspan="2" >{{$gtotal_trns_to}}</td>
                                    <td colspan="2" >{{$gtotal_trns_from}}</td>
                                    <td colspan="2" >{{number_format($gtotal_dmg, 2)}}</td>
                                    <td colspan="2" >{{number_format($gtotal_clb,2)}}</td> 
                                    <td colspan="9" style="text-align:right;">{{number_format($grandTotalStockAmount,2)}}</td> 
                                    <td colspan="4" style="text-align:right;">{{number_format($gOpeningAmount,2)}}</td>--}}
                                    
                                    {{-- <td style="font-size: 12px;">
	                                        @foreach(array_unique($gTWeightUnitsNames) as $key => $val)
                                                @if(is_string($key) && $val != 0)
                                                     {{number_format($val,2)}} {{$key}}/
                                                @endif
                                            @endforeach
	                                    </td>
	                                    <td style="font-size: 12px;">
	                                        @foreach(array_unique($gTUnitsNames) as $key => $val)
                                                @if(is_string($key) && $val != 0)
                                                     {{number_format($val,2)}} {{$key}}/
                                                @endif
                                            @endforeach
	                                    </td> --}}
                                    
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
