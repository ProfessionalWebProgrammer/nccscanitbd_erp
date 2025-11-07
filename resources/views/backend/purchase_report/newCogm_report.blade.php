@extends('layouts.purchase_deshboard')


@section('print_menu')
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
                      <h5 class="text-uppercase font-weight-bold">C.O.G.M. Report</h5>
                      <p>{{ $month_name }} {{ $year }}</p>
                      
                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
              
                <div class="py-4 table-responsive">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Product Name</th>
                                <th>Opening Balacne</th>
                                <th>Purchase Value</th>
                                <th>Closing Balance</th>
                                <th>Used BDT</th> 
                              	<th>Standard D. Labour</th>
                                <th>Actual D. Labour</th>
                              	<th>Standard M. Cost</th>
                              	<th>Actual M. Cost</th>
                                <th>Total Cost</th>

                            </tr>
                        </thead>

                        <tbody>
                          @php
                          $totalKg = 0;
                          $gTotalopening = 0;
                          $gTotalpurchase = 0; 
                          $gTotalcb = 0;
                          $gTotalused = 0; 
                          $gTotalPreDlc = 0; 
                          $gTotaldlc = 0;
                          $gTotalPreMfcost = 0; 
                          $gTotalmenufcost = 0;
                          @endphp 

                          @foreach($fgproducts as $fgi)
                            @php 
                          		$qty = $fgi->fg_qty;
                              	$totalKg += $qty*$fgi->product_weight;
                            @endphp
                          
                          @endforeach
                          @if($totalKg > 0)
                            @foreach ($fgproducts as $fgi)
                          	
                                <tr style="background-color:rgba(101, 128, 179, 0.616); ">

                                @php
                                    $rmproduct = DB::table('purchase_stockouts')->leftjoin('row_materials_products', 'purchase_stockouts.product_id', '=', 'row_materials_products.id')
                                        ->where('finish_goods_id', $fgi->finish_goods_id)
                                        ->whereBetween('date', [$fdate, $tdate])->groupBy('product_id')->get();

                               // dd($rmproduct);
            $directlebourcost = DB::select('SELECT SUM(direct_labour_costs.total_cost) as dlcost, SUM(direct_labour_costs.previour_total_cost) as preDlcost FROM `direct_labour_costs`
            					WHERE  direct_labour_costs.status = 1 AND  direct_labour_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
                                  
             /*$directlebourcost = DB::table('direct_labour_costs')->select([DB::raw("SUM(total_cost) dlcost"),DB::raw("SUM(previour_total_cost) preDlcost")])->whereBetween('date', [$fdate, $tdate])->where('status',1)->first(); */
                                  
            $manufacturingcost = DB::select('SELECT SUM(manufacturing_costs.total_cost) as mfcost, SUM(manufacturing_costs.previour_total_cost) as preMfcost FROM `manufacturing_costs`
            					WHERE  manufacturing_costs.status ="1" AND  manufacturing_costs.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
                                  
           $fgproductqty = DB::table('purchase_stockouts')->where('finish_goods_id',$fgi->finish_goods_id)
                    		->whereBetween('date',[$fdate,$tdate])->groupBy('sout_number')->get();
                                  
                                $count = count($fgproductqty);
                                $totalfgqty = 0; 
                                  if($tdate <= '2023-01-31'){
                                      foreach($fgproductqty as $item){
                                      $totalfgqty += $item->fg_qty; 
                                      }
                                       } else {
                                      	foreach($fgproductqty as $item){
                                   		$totalfgqty += $item->fg_out_qty; 
                                  		}
                                  }     
                                 // ekhanay FG product qty & weight multiply koray then
                                  //total manufactuaring cost ber koray seta k vag koray per kg costing pabo 
                                  
                                  $standardDirectLebourCost = 0;
                                  $directLebourCost = 0;
                                  if($directlebourcost[0]->preDlcost > 0){
                                  	$tempSDLC = $directlebourcost[0]->preDlcost/$totalKg;
                                  } else {
                                  	$tempSDLC = 0;
                                  }
                                  if($directlebourcost[0]->dlcost > 0){
                                  	$tempDLC = $directlebourcost[0]->dlcost/$totalKg;
                                  } else {
                                  	$tempDLC = 0;
                                  }
                                  
                                  $standardDirectLebourCost = $tempSDLC*$fgi->fg_qty*$fgi->product_weight;
                                  $directLebourCost = $tempDLC*$fgi->fg_qty*$fgi->product_weight;
                                  
                                  $standardManufacturingCost = 0;
                                  $manufacturingCost = 0;
                                  if($manufacturingcost[0]->preMfcost > 0){
                                  	$tempSMC = $manufacturingcost[0]->preMfcost/$totalKg;
                                  } else {
                                  	$tempSMC = 0;
                                  }
                                  
                                  if($manufacturingcost[0]->mfcost > 0){
                                  	$tempMC = $manufacturingcost[0]->mfcost/$totalKg;
                                  } else {
                                  	$tempMC = 0;
                                  } 
                                  $standardManufacturingCost = $tempSMC*$fgi->fg_qty*$fgi->product_weight;
                                  $manufacturingCost = $tempMC*$fgi->fg_qty*$fgi->product_weight;
                                  
                                @endphp
                                  
                                    <td><span style="font-weight: bold">{{ $fgi->product_name }}</span> (Finished Goods)
                                    </td>
                                    <td>Total Batch: {{$count ?? $count}}</td>
                                    <td>Total Qty: {{$totalfgqty}}</td>
                                    <td></td>
                                    <td></td>
                                  	<td align="right">{{number_format($standardDirectLebourCost,2)}}/-</td>
                                    <td align="right">{{number_format($directLebourCost,2)}}/-</td>
                                  	<td align="right">{{number_format($standardManufacturingCost,2)}}/-</td>
                                    <td align="right">{{number_format($manufacturingCost,2)}}/-</td>
                                    <td></td>

                                </tr>

                                @php
                                $totalopening = 0;
                                $totalpurchase = 0;
                                $totalcb = 0;
                                $totalused = 0;
                                $totaldlc = $directLebourCost;
                          		$totalPreDlc = $standardDirectLebourCost;
                                $totalmenufcost = $manufacturingCost;
                                $totalPreMfcost = $standardManufacturingCost;
                                @endphp

                                
                                @foreach ($rmproduct as $pdata)

                                @php

                        $opening_balanceppp = DB::table('row_materials_products')->where('id', $pdata->id)->value('opening_balance');
                                      $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            						where purchase_set_opening_balance.product_id="'.$pdata->id.'"  and  purchase_set_opening_balance.date between "'.$sdate.'" and "'.$tdate.'" ');
            
                        $stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            								where purchases.product_id="'.$pdata->id.'"  and  purchases.date between "'.$fdate.'" and "'.$tdate.'" ');
                        $pre_stocktotal = DB::select('SELECT SUM(purchases.inventory_receive) as srcv FROM `purchases`
            								where purchases.product_id="'.$pdata->id.'"  and  purchases.date between "'.$sdate.'" and "'.$pdate.'" ');

                        $return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
                         WHERE purchase_returns.product_id="'.$pdata->id.'"
                         and purchase_returns.date between "'.$fdate.'" and "'.$tdate.'"');
                       $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
                           WHERE purchase_returns.product_id="'.$pdata->id.'"
                           and purchase_returns.date between "'.$sdate.'" and "'.$pdate.'"');
             
                                $transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="'.$pdata->id.'"  and purchase_transfers.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
                                 $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="'.$pdata->id.'"  and purchase_transfers.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');
                               
                                $transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="'.$pdata->id.'"  and purchase_transfers.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
                                 $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            WHERE purchase_transfers.product_id="'.$pdata->id.'"  and purchase_transfers.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');
            
                                $stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="'.$pdata->id.'" AND purchase_stockouts.finish_goods_id ="'.$fgi->finish_goods_id.'" AND  purchase_stockouts.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
                               $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout FROM `purchase_stockouts`
            WHERE purchase_stockouts.product_id ="'.$pdata->id.'"AND purchase_stockouts.finish_goods_id ="'.$fgi->finish_goods_id.'"  AND  purchase_stockouts.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');
                                
                                         $openingbalance =$opening_balanceppp + $opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;
                                        $clsingbalance = $openingbalance + $stocktotal[0]->srcv - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout;
                                     
                        $avgrate = DB::select('SELECT AVG(purchases.purchase_rate) as rate FROM `purchases`
                					WHERE purchases.product_id ="'.$pdata->id.'" and purchases.date between "'.$sdate.'" and "'.$tdate.'"');
                			$rate = $avgrate[0]->rate;	
                         /* $billQty = 0; 
                          $billAmount = 0;
                          $avgrateData = DB::select('SELECT `bill_quantity`,`purchase_value` FROM `purchases`
                          WHERE purchases.product_id ="'.$pdata->id.'" and purchases.date between "'.$sdate.'" and "'.$tdate.'"');
                          //dd($avgrateData);
                          foreach($avgrateData as $val){
                          $billQty += $val->bill_quantity; 
                          $billAmount += $val->purchase_value;
                          }
                          if($billQty > 0){
                              $rate = $billAmount/$billQty;
                          }
                          
        				*/
                 
                               /* $totalopening += $openingbalance*$pdata->stock_out_rate;
                                $totalpurchase += $stocktotal[0]->srcv*$pdata->stock_out_rate;
                                $totalcb += $clsingbalance*$pdata->stock_out_rate;
                                $totalused += ($openingbalance+$stocktotal[0]->srcv-$clsingbalance)*$pdata->stock_out_rate; */
                          
                           		$totalopening += $openingbalance*$rate;
                                $totalpurchase += $stocktotal[0]->srcv*$rate;
                                $totalcb += $clsingbalance*$rate;
                                $totalused += ($openingbalance+$stocktotal[0]->srcv-$clsingbalance)*$rate;
                                
                                @endphp
                                    <tr >
                                        <td>{{ $pdata->product_name }} </td>
                                        <td align="right">{{number_format($openingbalance*$pdata->stock_out_rate,2)}}/-</td>
                                        <td align="right">{{number_format($stocktotal[0]->srcv*$pdata->stock_out_rate,2)}}/-</td>
                                        <td align="right">{{number_format($clsingbalance*$pdata->stock_out_rate,2)}}/-</td>
                                        <td align="right">{{number_format(($openingbalance+$stocktotal[0]->srcv-$clsingbalance)*$pdata->stock_out_rate,2)}}/-</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>


                                @endforeach
								@php 
                          		$gTotalopening += $totalopening;
                          		$gTotalpurchase += $totalpurchase; 
                          		$gTotalcb += $totalcb;
                          		$gTotalused += $totalused; 
                          		$gTotalPreDlc += $totalPreDlc; 
                          		$gTotaldlc += $totaldlc;
                          		$gTotalPreMfcost += $totalPreMfcost; 
                          		$gTotalmenufcost += $totalmenufcost; 
                          		@endphp 

                                <tr style="background-color:rgba(238, 107, 107, 0.473); font-weight: bold;">
                                  
                                    <td>Total</td>
                                    <td align="right">{{number_format($totalopening,2)}}</td>
                                    <td align="right">{{number_format($totalpurchase,2)}}</td>
                                    <td align="right">{{number_format($totalcb,2)}}</td>
                                    <td align="right">{{number_format($totalused,2)}}</td>
                                  	<td align="right">{{number_format($totalPreDlc,2)}}</td>
                                    <td align="right">{{number_format($totaldlc,2)}}</td>
                                  	<td align="right">{{number_format($totalPreMfcost,2)}}</td>
                                  	<td align="right">{{number_format($totalmenufcost,2)}}</td>
									@if($totalfgqty > 0)
                                    	<td>{{number_format($totalused+$totaldlc+$totalmenufcost,2)}} <br> (Per Bag Cost:{{number_format(($totalused+$totaldlc+$totalmenufcost)/$totalfgqty,2)}} )</td>
                                  	@endif
                                </tr>
                          
                            @endforeach
                          @endif
                          <tr style="background-color:#FA621C; color:#fff; font-weight: 800;">
                                  
                                    <td>Grand Total :</td>
                                    <td align="right">{{number_format($gTotalopening,2)}}</td>
                                    <td align="right">{{number_format($gTotalpurchase,2)}}</td>
                                    <td align="right">{{number_format($gTotalcb,2)}}</td>
                                    <td align="right">{{number_format($gTotalused,2)}}</td>
                                  	<td align="right">{{number_format($gTotalPreDlc,2)}}</td>
                                    <td align="right">{{number_format($gTotaldlc,2)}}</td>
                                  	<td align="right">{{number_format($gTotalPreMfcost,2)}}</td>
                                  	<td align="right">{{number_format($gTotalmenufcost,2)}}</td>

                                  <td> </td>
                                </tr>
                        </tbody>
                        <tfoot>                           
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
                filename: "COGMReport.xls"
            });
        });
    });
</script>
@endsection
