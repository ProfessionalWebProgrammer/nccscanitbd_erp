@extends('layouts.purchase_deshboard')

@section('print_menu')

			<li class="nav-item">

                </li>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


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
            <div class="container-fluid"  id="contentbody" style="min-width: 100% !important;">


              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h6 class="text-uppercase font-weight-bold">Purchase Bag Stock  Ledger</h6>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                        <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
                <div class="py-4 table-responsive">
                    <table  id="reporttable" class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top">
                                <th>Product</th>
                                <th>Opening Balance</th>
                                <th>Rate</th>
																<th>Amount</th>
                                <th>Stock In</th>
                                <th>Stock Out</th>
                                <th>S.O Amount</th>
                                <th>Return</th>
                                <th>Transfer in</th>
                                <th>transfer out</th>
                                <th>Balance</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $gtotal_return = 0;
                                $gtransfer_to = 0;
                                $gtotal_trns_to = 0;
                                $gtotal_trns_from = 0;
                                $gtotal_op = 0;
                                $gtotal_so = 0;
                                $gtotal_si = 0;
                                $gtotal_cb = 0;
																$gtOpeningAmount = 0;
								$grandTotalAmount = 0;
								$grandTotalStockAmount = 0;
                            @endphp
                            @foreach ($wirehousedata as $key => $wdata)

                                @php

																if($product) {
                                  if($wdata->id == 35){
                                    $products = \App\Models\RowMaterialsProduct::whereIn('id',$product)->where('unit','PCS')->orderBy('product_name', 'ASC')->get();
                                  } else {
                                    $products = \App\Models\Purchase::select('product_id as id','raw_supplier_id','wirehouse_id','p.product_name')
                                                ->leftJoin('row_materials_products as p', 'p.id', '=', 'purchases.product_id')->where('wirehouse_id',$wdata->id)
                                                ->whereIn('purchases.product_id', $product)->where('p.unit','PCS')->whereBetween('purchases.date',[$sdate,$tdate])->orderby('p.product_name', 'asc')->get();
                                  }

                                } else {
                                    if($wdata->id == 35){
                                      $products = \App\Models\RowMaterialsProduct::where('unit','PCS')->orderBy('product_name', 'ASC')->get();
                                    } else {
                                      $products = \App\Models\Purchase::select('product_id as id','raw_supplier_id','wirehouse_id','p.product_name')
                                                  ->leftJoin('row_materials_products as p', 'p.id', '=', 'purchases.product_id')->where('wirehouse_id',$wdata->id)
                                                  ->where('p.unit','PCS')->whereBetween('purchases.date',[$sdate,$tdate])->orderby('p.product_name', 'asc')->get();
                                    }

                                }
                                @endphp
                                <tr style="background-color: rgba(127, 255, 212, 0.384);">
                                    <td colspan="100%">{{ $wdata->factory_name }}</td>

                                </tr>
                                @php
                                    $return = 0;
                                    $total_return = 0;
                                    $transfer_to = 0;
                                    $total_trns_to = 0;
                                    $transfer_from = 0;
                                    $total_trns_from = 0;
                                    $total_op = 0;
                                    $total_so = 0;
                                    $total_si = 0;
                                    $total_cb = 0;
                                @endphp

                                @foreach ($products as $key => $pdata)
                                    @php

              $opening_balance  = DB::select('SELECT SUM(purchase_set_opening_balance.opening_balance) as opbalance FROM `purchase_set_opening_balance`
            					where purchase_set_opening_balance.product_id="'.$pdata->id.'" and purchase_set_opening_balance.wirehouse_id ="'.$wdata->id.'"  and  purchase_set_opening_balance.date between "'.$sdate.'" and "'.$tdate.'" ');


			  $pre_stock_out = 0;
              $stockTotalAll = DB::select('SELECT SUM(purchases.total_payable_amount) as amount, SUM(purchases.bill_quantity) as srcv, AVG(purchases.purchase_rate) as rate FROM `purchases`
                               where purchases.product_id="'.$pdata->id.'" and purchases.wirehouse_id ="'.$wdata->id.'"  and  purchases.date between "'.$sdate.'" and "'.$tdate.'" ');
              $stocktotal = DB::select('SELECT SUM(purchases.bill_quantity) as srcv FROM `purchases`
                               where purchases.product_id="'.$pdata->id.'" and purchases.wirehouse_id ="'.$wdata->id.'"  and  purchases.date between "'.$fdate.'" and "'.$tdate.'" ');
              $pre_stocktotal = DB::select('SELECT SUM(purchases.bill_quantity) as srcv  FROM `purchases`
                                where purchases.product_id="'.$pdata->id.'" and purchases.wirehouse_id ="'.$wdata->id.'"  and  purchases.date between "'.$sdate.'" and "'.$pdate.'"');
              $return = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty  FROM `purchase_returns`
             					WHERE purchase_returns.product_id="'.$pdata->id.'" and purchase_returns.wirehouse_id ="'.$wdata->id.'" and purchase_returns.date between "'.$fdate.'" and "'.$tdate.'"');
              $pre_return = $returns = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty FROM `purchase_returns`
             					WHERE purchase_returns.product_id="'.$pdata->id.'" and purchase_returns.wirehouse_id ="'.$wdata->id.'" and purchase_returns.date between "'.$sdate.'" and "'.$pdate.'"');

            $transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            				WHERE purchase_transfers.to_wirehouse_id ="'.$wdata->id.'" and purchase_transfers.product_id="'.$pdata->id.'"  and purchase_transfers.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
            $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
            				WHERE purchase_transfers.to_wirehouse_id ="'.$wdata->id.'" and purchase_transfers.product_id="'.$pdata->id.'"  and purchase_transfers.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');

            $transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            						WHERE purchase_transfers.from_wirehouse_id ="'.$wdata->id.'" and purchase_transfers.product_id="'.$pdata->id.'"  and purchase_transfers.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
            $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
            						WHERE purchase_transfers.from_wirehouse_id ="'.$wdata->id.'" and purchase_transfers.product_id="'.$pdata->id.'"  and purchase_transfers.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');

       		$stock_out = DB::select('SELECT SUM(packing_consumptions.qty) as stockout, SUM(packing_consumptions.amount) as Amount  FROM `packing_consumptions`
            				WHERE packing_consumptions.bag_id ="'.$pdata->id.'"  and packing_consumptions.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
                          if($sdate < $pdate)   {
            $pre_stock_out = DB::select('SELECT SUM(packing_consumptions.qty) as stockout FROM `packing_consumptions`
            				WHERE packing_consumptions.bag_id ="'.$pdata->id.'" AND packing_consumptions.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');
                           $pre_stock_out = $pre_stock_out[0]->stockout;
                          } else {
                          $pre_stock_out = 0;
                          }

							$stockOutAll = DB::select('SELECT SUM(packing_consumptions.amount) as amount, SUM(packing_consumptions.qty) as stockout, AVG(packing_consumptions.rate) as rate FROM `packing_consumptions`
								            				WHERE packing_consumptions.bag_id ="'.$pdata->id.'"  and packing_consumptions.date BETWEEN "'.$sdate.'" and "'.$tdate.'"');


                                        $openingbalance = $pdata->opening_balance+$opening_balance[0]->opbalance + $pre_stocktotal[0]->srcv - $pre_return[0]->return_qty + $pre_transfer_to[0]->transfers_qty - $pre_transfer_from[0]->transfers_qty - $pre_stock_out;
                                        $clsingbalance = $openingbalance + $stocktotal[0]->srcv - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout;

                                        $total_return += $return[0]->return_qty;
                                        $total_trns_to += $transfer_to[0]->transfers_qty;
                                        $total_trns_from += $transfer_from[0]->transfers_qty;
                                        $total_op += $openingbalance;
                                        $total_so += $stock_out[0]->stockout;
                                        $total_si += $stocktotal[0]->srcv;
                                        $total_cb += $clsingbalance;

                                        $gtotal_return += $return[0]->return_qty;
                                        $gtotal_trns_to += $transfer_to[0]->transfers_qty;
                                        $gtotal_trns_from += $transfer_from[0]->transfers_qty;
                                        $gtotal_op += $openingbalance;
                                        $gtotal_so += $stock_out[0]->stockout;
                                        $gtotal_si += $stocktotal[0]->srcv;
                                        $gtotal_cb += $clsingbalance;

																				$tempTotalAmount = $pdata->opening_balance*$pdata->rate + $stockTotalAll[0]->amount - $stockOutAll[0]->amount ;
																				$grandTotalAmount += $tempTotalAmount;

																				if($stockTotalAll[0]->rate > 0){
																					if($stockOutAll[0]->rate > 0){
																						$rate = ($stockTotalAll[0]->rate + $stockOutAll[0]->rate)/2;
																					} elseif($pdata->rate > 0){
																						$rate = ($stockTotalAll[0]->rate + $pdata->rate)/2;
																					} else {
																						$rate = $stockTotalAll[0]->rate;
																					}
																				}elseif($stockOutAll[0]->rate > 0){
																					if($pdata->rate > 0){
																						$rate = ($stockOutAll[0]->rate + $pdata->rate)/2;
																					} else {
																						$rate = $stockOutAll[0]->rate;
																					}

																				} else {
																					$rate = $pdata->rate;
																				}

																				$stockOutAmount = $stock_out[0]->Amount;
																				$grandTotalStockAmount += $stockOutAmount;
																				$openingAmount = $openingbalance *$rate;
																				$gtOpeningAmount += $openingAmount;
                                    @endphp
                                    @if ($openingbalance != 0 || $return[0]->return_qty != 0 || $transfer_to[0]->transfers_qty != 0 || $stock_out[0]->stockout != 0 || $stocktotal[0]->srcv != 0 || $clsingbalance != 0)

                                        <tr>

                                            <td>{{ $pdata->product_name }}</td>
                                            <td>{{ number_format($openingbalance,2) }}</td>
                                            <td>@if($clsingbalance > 0) {{ number_format(($tempTotalAmount/$clsingbalance),2) }} @else {{ number_format($rate,2) }} @endif</td>
																						<td>{{ number_format($openingAmount,2) }}</td>
                                            <td>{{ number_format($stocktotal[0]->srcv,2) }}</td>
                                            <td>{{ number_format($stock_out[0]->stockout,2) }}</td>
                                            <td>{{number_format($stockOutAmount,2)}}</td>
                                            <td>{{ number_format($return[0]->return_qty,2) }}</td>
                                            <td>{{ number_format($transfer_to[0]->transfers_qty,2) }}</td>
                                            <td>{{ number_format($transfer_from[0]->transfers_qty,2) }}</td>
                                            <td>{{ number_format($clsingbalance,2) }}</td>
                                            <td>{{ number_format($tempTotalAmount,2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach

 							{{--	@if ($total_op != 0 || $total_si != 0 || $total_so != 0 || $total_return != 0 || $total_trns_to != 0 || $total_trns_from != 0 || $total_cb != 0)

                                <tr style="background-color: rgba(255, 228, 196, 0.233);">
                                    <th> Total</th>
                                    <th>{{ number_format($total_op) }}</th>
                                    <th>{{ number_format($total_si) }}</th>
                                    <th>{{ number_format($total_so) }}</th>
                                    <th>{{ number_format($total_return) }}</th>
                                    <th>{{ number_format($total_trns_to) }}</th>
                                    <th>{{ number_format($total_trns_from) }}</th>
                                    <th>{{ number_format($total_cb) }}</th>
                                </tr>
							 @endif --}}

                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background-color: rgba(255, 127, 80, 0.466);">
                                <th>Grand Total</th>
                                <th>{{ number_format($gtotal_op,2) }}</th>
																<th></th>
                                <th>{{ number_format($gtOpeningAmount,2) }}</th>
                                <th>{{ number_format($gtotal_si,2) }}</th>
                                <th>{{ number_format($gtotal_so,2) }}</th>
                               {{-- <th> @if($tdate <= '2023-10-31') {{ number_format(($grandTotalStockAmount + 18693.91) ,2) }} @else {{ number_format($grandTotalStockAmount ,2) }} @endif </th> --}}
                                <th> {{ number_format($grandTotalStockAmount ,2) }} </th>
                                <th>{{ number_format($gtotal_return,2) }}</th>
                                <th>{{ number_format($gtotal_trns_to,2) }}</th>
                                <th>{{ number_format($gtotal_trns_from,2) }}</th>
                                <th>{{ number_format($gtotal_cb,2) }}</th>
                                <th>{{ number_format($grandTotalAmount,2) }}</th>
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
                filename: "BagStockLedger.xls"
            });
        });
    });
</script>
@endsection
