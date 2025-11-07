@extends('layouts.purchase_deshboard')
<style>
/* ==============new scc start ============= */



table {

  font-size: 12px!important;
  white-space: nowrap;
  margin: 0;
  border: none;
  border-collapse: separate;
  border-spacing: 0;
  table-layout: fixed;
  border: 1px solid black;
  overflow-y: scroll;
}
table td,
table th {
  border: 1px solid black;
  padding: 0.5rem 1rem;

}
  .content-wrapper{
    z-index: 1;
    /*margin-top:-43%!important;*/
  }
table thead th {
  padding: 8px;
  position: sticky;
  top: 0;
  z-index: 1;
  width: 45vw;
  background: #FA621C;
  color:#000;
}

table td {
  padding-bottom: 7px;
  text-align: center;

}

table tbody td:first-child {
  font-weight: 100;
  text-align: left;
  position: relative;
}
table thead th:first-child {
  position: sticky!important;
  left: 0;
  z-index: 1;
}
/*table tbody td:first-child {
  position: sticky;
  left: 0;
  background: #f5f5f5;
  z-index: 1;
} */
caption {
  text-align: left;
  padding: 0.25rem;
  position: sticky;
  left: 0;
}

[role="region"][aria-labelledby][tabindex] {
  width: 100%;
  max-height: 600px;
  overflow: auto;
}
[role="region"][aria-labelledby][tabindex]:focus {
  //box-shadow: 0 0 0.5em rgba(0, 0, 0, 0.5);
  outline: 0;
}
  footer.main-footer{
  display: none!important;
    z-index: -1;
  }
  .hover_manu_content{
	    position: absolute;
    width: 100%;
    float: left;
    top: -390px;
    opacity: 0;
  background: #fff;
   margin-left: -15px;
}
  /* ========new css end====== */
</style>
@section('print_menu')

			<li class="nav-item"></li>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >

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
            <div class="container-fluid" id="contentbody">


				<div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Purchase Stock  Ledger</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  		<p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
                {{-- New Table Design Start --}}
                <div role="region" aria-labelledby="caption" tabindex="0" style="min-height:600px;">
                    <table id="reporttable">
                      <caption id="caption"></caption>
                      <thead>
                            <tr>
                                <th>Product gg</th>
                                <th>Rate</th>
                                <th>Opening Balance</th>
                                <th>Amount</th>
                                <th >Receiving</th>

                                <th >Consumption</th>
                              	<th>S.O Amount</th>
                                <th>Return</th>
                                <th>Transfer in</th>
                                <th>transfer out</th>
                                <th>Damage</th>
                                <th>Balance </th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                             @php
                                $gtotal_return = 0;
                                $gtransfer_to = 0;
                                $gtotal_trns_to = 0;
                                $gtotal_trns_from = 0;
                                $gtotal_dmg = 0;
                                $gtotal_op = 0;
                                $gtotal_so = 0;
                                $gtotal_si = 0;
                                $gtotal_cb = 0;
                                $productID = 0;
                          	    $productName = '';
                          	    $gtotalAmount = 0;
                          	    $gtotalBagQty = 0;
                          	    $gtotalBagBalance = 0;
                          	    $grandTotalStockOutAmount = 0;
                                $gtOpeningAmount = 0;
                            @endphp
                            @foreach ($wirehousedata as $key => $wdata)

                                @php
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
                                    $total_dmg = 0;
                                    $total_op = 0;
                                    $total_so = 0;
                                    $total_si = 0;
                                    $total_cb = 0;
                          			$totalAmount = 0;
                          			$totalBagQty = 0;
                          	        $totalBagBalance = 0;
                                    $subOpeningAmount = 0;
                                @endphp

                                @for($i = 0; $i < $count; $i++)
                                <tr>
                                  <td colspan="100%" style="color: #1340d5; font-size:16px; font-weight:600;"> {{ \App\Models\SalesCategory::where('id',$category[$i])->value('category_name')}} </td>
                                </tr>
                                @php
                                if($product) {
                                  if($wdata->id == 35){
                                    $products = \App\Models\RowMaterialsProduct::whereIn('id', $product)->where('category_id',$category[$i])->orderby('product_name', 'asc')->get();
                                  } else {
                                    $products = \App\Models\Purchase::select('product_id as id','raw_supplier_id','wirehouse_id','p.product_name')
                                                ->leftJoin('row_materials_products as p', 'p.id', '=', 'purchases.product_id')->where('wirehouse_id',$wdata->id)
                                                ->whereIn('purchases.product_id', $product)->where('p.category_id',$category[$i])->whereBetween('purchases.date',[$sdate,$tdate])->groupBy('purchases.product_id')->orderby('p.product_name', 'asc')->get();
                                  }

                                } else {
                                    if($wdata->id == 35){
                                      $products = \App\Models\RowMaterialsProduct::where('category_id',$category[$i])->orderby('product_name', 'asc')->get();
                                    } else {
                                      $products = \App\Models\Purchase::select('product_id as id','raw_supplier_id','wirehouse_id','p.product_name')
                                                  ->leftJoin('row_materials_products as p', 'p.id', '=', 'purchases.product_id')->where('wirehouse_id',$wdata->id)
                                                  ->where('p.category_id',$category[$i])->whereBetween('purchases.date',[$sdate,$tdate])->groupBy('purchases.product_id')->orderby('p.product_name', 'asc')->get();
                                    }

                                }


                                @endphp
                                @foreach ($products as $key => $pdata)

                                    @php
									             $productID = $pdata->id;
                          			$productName = $pdata->product_name;

                            $stocktotal = DB::select('SELECT SUM(purchases.total_payable_amount) as amount, SUM(purchases.inventory_receive) as srcv, SUM(purchases.bill_quantity) as qty, SUM(purchases.purchase_value) as value FROM `purchases`
                               JOIN `row_materials_products` ON purchases.product_id = row_materials_products.id  where row_materials_products.category_id = "'.$category[$i].'"
                                          and purchases.product_id="'.$pdata->id.'" and purchases.wirehouse_id ="'.$wdata->id.'"  and  purchases.date between "'.$fdate.'" and "'.$tdate.'" ');

                               $pre_stocktotal = DB::select('SELECT SUM(purchases.total_payable_amount) as amount,SUM(purchases.inventory_receive) as srcv, SUM(purchases.bill_quantity) as qty FROM `purchases`
                                    JOIN `row_materials_products` ON purchases.product_id = row_materials_products.id  where row_materials_products.category_id = "'.$category[$i].'"
                                 and purchases.product_id="'.$pdata->id.'" and purchases.wirehouse_id ="'.$wdata->id.'"  and  purchases.date between "'.$sdate.'" and "'.$pdate.'" ');

                              $return = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty, SUM(purchase_returns.total_amount) as amount FROM `purchase_returns`
                                    JOIN `row_materials_products` ON purchase_returns.product_id = row_materials_products.id  where row_materials_products.category_id = "'.$category[$i].'"
                                   and purchase_returns.product_id="'.$pdata->id.'" and purchase_returns.wirehouse_id ="'.$wdata->id.'"
                                   and purchase_returns.date between "'.$fdate.'" and "'.$tdate.'"');
                              $pre_return = DB::select('SELECT SUM(purchase_returns.return_quantity) as return_qty, SUM(purchase_returns.total_amount) as amount FROM `purchase_returns`
                              JOIN `row_materials_products` ON purchase_returns.product_id = row_materials_products.id  where row_materials_products.category_id = "'.$category[$i].'"
                                   and purchase_returns.product_id="'.$pdata->id.'" and purchase_returns.wirehouse_id ="'.$wdata->id.'"
                                   and purchase_returns.date between "'.$sdate.'" and "'.$pdate.'"');

                                $transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
                                WHERE purchase_transfers.to_wirehouse_id ="'.$wdata->id.'" and purchase_transfers.product_id="'.$pdata->id.'"  and purchase_transfers.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
                                 $pre_transfer_to = DB::select('SELECT SUM(purchase_transfers.receive_qty) as transfers_qty FROM `purchase_transfers`
                                 WHERE purchase_transfers.to_wirehouse_id ="'.$wdata->id.'" and purchase_transfers.product_id="'.$pdata->id.'"  and purchase_transfers.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');

                                $transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
                                WHERE purchase_transfers.from_wirehouse_id ="'.$wdata->id.'" and purchase_transfers.product_id="'.$pdata->id.'"  and purchase_transfers.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
                                 $pre_transfer_from = DB::select('SELECT SUM(purchase_transfers.qty) as transfers_qty FROM `purchase_transfers`
                                 WHERE purchase_transfers.from_wirehouse_id ="'.$wdata->id.'" and purchase_transfers.product_id="'.$pdata->id.'"  and purchase_transfers.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');

                               if($category[$i] == 39){
                                   $stock_out = DB::select('SELECT SUM(packing_consumptions.qty) as stockout, SUM(packing_consumptions.amount) as amount  FROM `packing_consumptions`
                               				WHERE packing_consumptions.bag_id ="'.$pdata->id.'"  and packing_consumptions.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');

                               		$pre_stock_out = DB::select('SELECT SUM(packing_consumptions.qty) as stockout, SUM(packing_consumptions.amount) as amount FROM `packing_consumptions`
                               				WHERE packing_consumptions.bag_id ="'.$pdata->id.'" AND packing_consumptions.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');
                                 } else {
                                   $stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout, SUM(purchase_stockouts.total_amount) as amount FROM `purchase_stockouts`
                                   JOIN `row_materials_products` ON purchase_stockouts.product_id = row_materials_products.id  where row_materials_products.category_id = "'.$category[$i].'"
                                   and purchase_stockouts.product_id ="'.$pdata->id.'" AND purchase_stockouts.wirehouse_id ="'.$wdata->id.'" and purchase_stockouts.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
                                  $pre_stock_out = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout, SUM(purchase_stockouts.total_amount) as amount  FROM `purchase_stockouts`
                                   JOIN `row_materials_products` ON purchase_stockouts.product_id = row_materials_products.id  where row_materials_products.category_id = "'.$category[$i].'"
                                   and purchase_stockouts.product_id ="'.$pdata->id.'" AND purchase_stockouts.wirehouse_id ="'.$wdata->id.'" and purchase_stockouts.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');
                                 }

                              $damage = DB::select('SELECT SUM(purchase_damages.quantity) as quantity FROM `purchase_damages`
                              WHERE purchase_damages.warehouse_id ="'.$wdata->id.'" and purchase_damages.warehouse_id="'.$pdata->id.'"  and purchase_damages.date BETWEEN "'.$fdate.'" and "'.$tdate.'"');
                              $pre_damage = DB::select('SELECT SUM(purchase_damages.quantity) as quantity FROM `purchase_damages`
                              WHERE purchase_damages.warehouse_id ="'.$wdata->id.'" and purchase_damages.product_id="'.$pdata->id.'"  and purchase_damages.date BETWEEN "'.$sdate.'" and "'.$pdate.'"');


                          if($pdata->unit == 'PCS'){
                            $stockoutBags = \App\Models\PackingConsumptions::where('bag_id',$pdata->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                          } else {
                             $stockoutBags = 0;
                          }



                          if(!empty($stocktotal[0]->value)){
                    						$valueTemp = $stocktotal[0]->value;
                    						$valueQty = $stocktotal[0]->qty;

                    						if($pdata->opening_balance > 0 && $pdata->rate > 0){
                    						$openQty = $pdata->opening_balance;
                    						$valueTemp += $pdata->opening_balance*$pdata->rate;
                    						$valueQty += $openQty;
                                          }
                                            $rate = $valueTemp/$valueQty;
                                            $rate = round($rate,3);
                    						} else {
                                          $rate = $pdata->rate;
                                          }


                          $totalBagQty += $stockoutBags;
                          $gtotalBagQty += $stockoutBags;
                          $totalBagBalance += $pdata->opening_balance - $stockoutBags;
                          $gtotalBagBalance += $pdata->opening_balance - $stockoutBags;


			                       if($fdate == '2023-10-01'){
                           $openingbalance = $pdata->opening_balance;
                           $openingValue = $pdata->opening_balance*$pdata->rate;
                          } elseif($fdate < '2023-10-01') {
                                          $openingbalance = 0;
                                          $openingValue = 0;
                                             } else {
                          	 $openingbalance = $pdata->opening_balance + $pre_stocktotal[0]->qty + $pre_transfer_to[0]->transfers_qty - $pre_return[0]->return_qty- $pre_damage[0]->quantity  - $pre_transfer_from[0]->transfers_qty - $pre_stock_out[0]->stockout;
                          	 $openingValue = $pdata->opening_balance*$pdata->rate + $pre_stocktotal[0]->amount + ($pre_transfer_to[0]->transfers_qty * $rate) - ($pre_return[0]->return_qty  * $rate) - ( $pre_damage[0]->quantity  * $rate)  - ( $pre_transfer_from[0]->transfers_qty  * $rate) -  $pre_stock_out[0]->amount;
                          }


                          				if(!empty($otherRawStockOut)){
                          				$clsingbalance = $openingbalance + $stocktotal[0]->qty - $return[0]->return_qty + $transfer_to[0]->transfers_qty - $damage[0]->quantity - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout - $stockoutBags- $otherRawStockOut;
                          				} else {
                                        $clsingbalance = $openingbalance + $stocktotal[0]->qty + $return[0]->return_qty + $transfer_to[0]->transfers_qty - $damage[0]->quantity - $transfer_from[0]->transfers_qty - $stock_out[0]->stockout;
                                        //$clsingValue = $openingValue + $stocktotal[0]->amount  + ($return[0]->return_qty * $rate) + ( $transfer_to[0]->transfers_qty * $rate) - ( $damage[0]->quantity  * $rate) - ( $transfer_from[0]->transfers_qty * $rate) - $stock_out[0]->amount;
                                        $clsingValue = $openingValue + $stocktotal[0]->amount  + ($return[0]->return_qty * $rate) - ( $damage[0]->quantity  * $rate) - $stock_out[0]->amount;
                                        
                                       
											                   }

								                        $valueTemp = 0;
                                        $valueQty = 0;
                                        $value = 0;


                                        $total_return += $return[0]->return_qty;
                                        $total_trns_to += $transfer_to[0]->transfers_qty;
                                        $total_trns_from += $transfer_from[0]->transfers_qty;
                                        $total_dmg += $damage[0]->quantity;
                                        $total_op += $openingbalance;

                          				if(!empty($otherRawStockOut)){
                          				$total_so += $otherRawStockOut;
                          				} else {
                                        $total_so += $stock_out[0]->stockout + $stockoutBags;
                          				}

                                        $total_si += $stocktotal[0]->qty;
                                        $total_cb += $clsingbalance;

                                        $gtotal_return += $return[0]->return_qty;
                                        $gtotal_trns_to += $transfer_to[0]->transfers_qty;
                                        $gtotal_trns_from += $transfer_from[0]->transfers_qty;
                                        $gtotal_dmg += $damage[0]->quantity;
                                        $gtotal_op += $openingbalance;

                          				if(!empty($otherRawStockOut)){
                          				$gtotal_so += $otherRawStockOut;
                          				//$stockOutAmount = $otherRawStockOut*$rate;
                          				$stockOutAmount = $stock_out[0]->amount;
                                        $grandTotalStockOutAmount += $stockOutAmount;
                          				} else {
                                        $gtotal_so += $stock_out[0]->stockout + $stockoutBags ;
                                        // $stockOutAmount = ($stock_out[0]->stockout + $stockoutBags)*$rate;
                                        $stockOutAmount = $stock_out[0]->amount;
                                        $grandTotalStockOutAmount += $stockOutAmount;
                          				}

                                        $gtotal_si += $stocktotal[0]->qty;
                                        $gtotal_cb += $clsingbalance;

                                        $totalAmount += $clsingValue;
                                      //  $gtotalAmount += $clsingValue;

                                        $openingAmount = $openingbalance * $rate;
                                      //  $subOpeningAmount += $openingAmount ;
                                        $gtOpeningAmount += $openingAmount ;
                                        
                                       
                                    @endphp


                                        <tr>

                                            <td>{{ $pdata->product_name }}</td>
                                          {{--   <td>@if($clsingbalance > 0) {{ number_format(($clsingValue/$clsingbalance),2) }} @else {{ number_format($rate,2) }} @endif</td> --}}
                                            <td>{{ number_format($rate,2) }}</td>
                                          {{-- <td><a href="" data-toggle="modal" data-target="#modalPurchaseStock" >{{ $pdata->product_name }}</a></td> --}}
                                            <td>{{ number_format($openingbalance, 2) }} @if($openingbalance) {{$pdata->unit}} @else  @endif </td>
                                            <td>{{ number_format($openingAmount, 2) }}  </td>
                                            <td>
                                                
                                                {{ number_format($stocktotal[0]->qty, 2) }} @if($stocktotal[0]->qty) {{$pdata->unit}} @else  @endif
                                            </td>

                                          	@if(!empty($otherRawStockOut))
                          						      <td>{{ number_format($otherRawStockOut, 2) }}  @if($otherRawStockOut) {{$pdata->unit}} @else  @endif </td>

                                  					@elseif($stockoutBags > 0)
                                  					    <td >{{ number_format($stockoutBags, 2) }}   @if($stockoutBags) {{$pdata->unit}} @else  @endif </td>
                                  					@else
                                                <td>{{ number_format($stock_out[0]->stockout, 2) }}  @if($stock_out[0]->stockout) {{$pdata->unit}} @else  @endif </td>
                                            @endif

                                            <td>{{number_format($stockOutAmount,2)}}</td>
                                            <td>{{ number_format($return[0]->return_qty, 2) }}  @if($return[0]->return_qty) {{$pdata->unit}} @else  @endif </td>
                                            <td>{{ number_format($transfer_to[0]->transfers_qty, 2) }}  @if($transfer_to[0]->transfers_qty) {{$pdata->unit}} @else  @endif </td>
                                            <td>{{ number_format($transfer_from[0]->transfers_qty, 2) }}  @if($transfer_from[0]->transfers_qty) {{$pdata->unit}} @else  @endif </td>
                                            <td>{{ number_format($damage[0]->quantity, 2) }}  @if($damage[0]->quantity) {{$pdata->unit}} @else  @endif </td>
                                            @if(!empty($stockoutBags > 0))
                                            <td>{{ number_format($clsingbalance, 2) }}  @if($clsingbalance) {{$pdata->unit}} @else  @endif </td>
                                            @else
                                            <td>{{ number_format($clsingbalance, 2) }}  @if($clsingbalance) {{$pdata->unit}} @else  @endif </td>
                                            @endif
                                            <td>{{ number_format($clsingValue, 2) }}</td>
                                        </tr>
                                @endforeach

                                @endfor
                                 <tr style="background-color: rgba(255, 228, 196, 0.233);">
                                    <th colspan="12"> Total</th>
                                    {{-- <th>{{ number_format($total_op, 2) }}</th>
                                    <th>{{ number_format($total_si, 2) }}</th>
                                    <th>{{ number_format(($total_si/1000), 3) }}</th>
                                    @if($totalBagQty > 0 )<th colspan="2" style="text-align:center;">{{ number_format($total_so,2) }}  </th>
                                     @else
                                     <th>{{ number_format($total_so,2) }}  </th>
                                     <th>{{ number_format(($total_so/1000),3) }}</th>
                                     @endif
                                     <th></th>
                                    <th>{{ number_format($total_return,2) }}</th>
                                    <th>{{ number_format($total_trns_to,2) }}</th>
                                    <th>{{ number_format($total_trns_from,2) }}</th>
                                    <th>{{ number_format($total_dmg,2) }}</th>
                                    <th>{{ number_format($total_cb,2) }}</th> --}}
                                    <th>{{ number_format($totalAmount,2) }}</th>
                                </tr>

                                @php
                                $gtotalAmount += $totalAmount;
                                @endphp
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr style="background-color: rgba(255, 127, 80, 0.466);">
                                <th>Grand Total</th>

                               {{-- <th>{{ number_format($gtotal_op,2) }}</th>
                                <th>{{ number_format($gtotal_si,2) }} (Kg)</th>

                                @if($gtotalBagQty > 0)
                                <th  style="text-align:center;">{{ number_format($gtotal_so,2) }}   (Pcs) </th>
                                @else
                                <th>{{ number_format($gtotal_so,2) }} (Kg)  </th>

                                @endif --}}
                                <th colspan="3" style="text-align:right;">{{ number_format($gtOpeningAmount,2) }}</th>
                                <th colspan="3" style="text-align:right;">{{ number_format($grandTotalStockOutAmount,2) }}</th>
                                {{-- <th>{{ number_format($gtotal_return,2) }}</th>
                                <th>{{ number_format($gtotal_trns_to,2) }}</th>
                                <th>{{ number_format($gtotal_trns_from,2) }}</th>
                                <th>{{ number_format($gtotal_dmg,2) }}</th>
                                <th>{{ number_format($gtotal_cb,2) }} @if($gtotalBagQty > 0) (Pcs) @else (Kg)  @endif </th> --}}
                                <th colspan="6" style="text-align:right;" >{{ number_format($gtotalAmount,2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>


{{-- New Table Design End --}}


            </div>
        </div>
    </div>
  @foreach ($products as $key => $pdata)
        @php
		$productID = $pdata->id;
        $productName = $pdata->product_name;
		@endphp
@include('backend.purchase_ledger.model')
@endforeach
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

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
                filename: "RM-StockLedger.xls"
            });
        });
    });
</script>
@endsection
