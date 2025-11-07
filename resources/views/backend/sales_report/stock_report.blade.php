@extends('layouts.sales_dashboard')
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
    margin-top:-43%!important;
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
table tbody td:first-child {
  position: sticky;
  left: 0;
  background: #f5f5f5;
  z-index: 1;
}
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
                            <tr class="table-header-fixt-top">
                                {{-- <th>SI No</th> --}}
                                <th>Product Name</th>
                                
                                @if($unit == 'Kg')
                                  <th>Opening Balance (Kg)</th>
                                  @elseif($unit == 'Ton')
                                  <th>Opening Balance (Ton)</th>
                                  @elseif($unit == 'Bag')
                                  <th>Opening Balance (Bag)</th>
                                  @else 
                                  <th>Opening Balance (Kg)</th>
                                  <th>Opening Balance (Ton)</th>
                                  <th>Opening Balance (Bag)</th>
                                  @endif 
                              @if($unit == 'Kg')
                                <th>Receiving (Kg)</th>
                              @elseif($unit == 'Ton')
                              <th>Receiving (Ton)</th>
                              @elseif($unit == 'Bag')
                              <th>Receiving (Bag)</th>
                              @else 
                              <th>Receiving (Kg)</th>
                              <th>Receiving (Ton)</th>
                              <th>Receiving (Bag)</th>
                              @endif 
                               @if($unit == 'Kg')
                              <th>Sales (Kg)</th>
                              @elseif($unit == 'Ton')
                              <th>Sales (Ton)</th>
                              @elseif($unit == 'Bag')
                              <th>Sales (Bag)</th>
                              @else 
                              <th>Sales (Kg)</th>
                              <th>Sales (Ton)</th>
                              <th>Sales (Bag)</th>
                              @endif 
                              @if($unit == 'Kg')
                              <th>Con R Process (Kg)</th>
                              @elseif($unit == 'Ton')
                              <th>Con R Process (Ton)</th>
                               @elseif($unit == 'Bag')
                              <th>Con R Process (Bag)</th>
                              
                              @else 
                              <th>Con R Process (Kg)</th>
                              <th>Con R Process (Ton)</th>
                              <th>Con R Process (Bag)</th>
                              @endif 
                              
                                <th>Return</th>
                                <th>Transfer In</th>
                                <th>Transfer Out</th>
                                 {{--  <th>Damage</th> --}}
                              	
                              	 @if($unit == 'Kg')
                              	<th>Re-Process (Kg)</th>
                                <th>Closing Balance (Kg)</th>
                                <th>Final Balance (Kg)</th>
                              	@elseif($unit == 'Ton')
                              	<th>Re-Process (Ton)</th>
                              	<th>Closing Balance (Ton)</th>
                                <th>Final Balance (Ton)</th>
                              	@elseif($unit == 'Bag')
                                <th>Re-Process (Bag)</th>
                              	<th>Closing Balance (Bag)</th>
                                <th>Final Balance (Bag)</th>
                               @else
                                <th>Re-Process (Kg)</th>
                              	<th>Closing Balance (Kg)</th>
                                <th>Final Balance (Kg)</th>
                                <th>Re-Process (Ton)</th>
                              	<th>Closing Balance (Ton)</th>
                                <th>Final Balance (Ton)</th>
                                <th>Re-Process (Bag)</th>
                              	<th>Closing Balance (Bag)</th>
                                <th>Final Balance (Bag)</th>
                               @endif
                            </tr>
                        </thead>
                        <tbody>
                         @php
                            $greturn = 0;
                            $gtotal_trns_to = 0;
                            $gtotal_trns_from = 0;
                            $gtotal_op= 0;
                            $gtotal_opKg = 0;
                            $gtotal_so = 0;
                            $gtotal_si = 0;
                            $gtotal_dmg = 0;
                            $gtotal_clbKg = 0;
                          	$gtotal_clbBag = 0;
                          	$gtotalBag_so = 0;
                          	$gtotalBag_si = 0;
                            $gTotalReProcessBag = 0;
                            $gTotalReProcessKg = 0; 
                            $gTotalReQty = 0;
                            $gTotalReBag = 0; 
                        @endphp


                           @foreach($wirehousedata as $key=>$wdata)

                           @php
                            $return = 0;
                            $total_trns_to = 0;
                            $total_trns_from = 0;
                            $total_op= 0;
                            $total_opKg = 0;
                            $total_so = 0;
                            $total_si = 0;
                            $total_bag_so = 0;
                            $total_bag_si = 0;
                            $total_dmg = 0;
                            $clb = 0;
                            $total_clbKg = 0;
                          	$total_clbBag = 0;
                            $totalReProcessBag = 0; 
                            $totalReProcessKg = 0;
                            $totalReQty = 0;
                            $totalReBag = 0; 
                            @endphp

                            @php
                          if(!empty($cat)){
								$catName = \App\Models\SalesCategory::where('id',$cat)->value('category_name');
                          } else {
                          	$catName = '';
                          }
                            @endphp
                            <tr style="background-color: rgba(127, 255, 212, 0.404);">
                                <td colspan="100%">{{$wdata->factory_name}} - {{$catName}}</td>

                            </tr>
                                @foreach($products as $all_products)
                                @php
                                   $startdate = '2023-07-01';
                                    $reprocessBag = 0; 
                                    $fdate2 ='2023-07-01';
                          			$todaystock = \App\Models\SalesStockIn::select([DB::raw("SUM(quantity) quantity"), DB::raw("SUM(reprocess_qty) reprocess_qty")])->where('prouct_id',$all_products->id)->where('factory_id',$wdata->id)->whereBetween('date',[$fdate,$tdate])->get();
                                    
                          			$openingstock = \App\Models\SalesStockIn::where('prouct_id',$all_products->id)->where('factory_id',$wdata->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');

                                    $sales = \App\Models\SalesLedger::where('product_id',$all_products->id)->where('warehouse_bank_id',$wdata->id)->whereBetween('ledger_date',[$fdate,$tdate])->sum('qty_pcs');
                                    $opsales = \App\Models\SalesLedger::where('product_id',$all_products->id)->where('warehouse_bank_id',$wdata->id)->whereBetween('ledger_date',[$startdate,$fdate2])->sum('qty_pcs');


                                    $returnp = DB::table('sales_returns')->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('sales_returns.warehouse_id',$wdata->id)->where('sales_return_items.product_id',$all_products->id)->whereBetween('sales_returns.date',[$fdate,$tdate])->sum('sales_return_items.qty');
                                     $opreturnp =DB::table('sales_returns')->join('sales_return_items', 'sales_returns.id', '=', 'sales_return_items.return_id')->where('sales_returns.warehouse_id',$wdata->id)->where('sales_return_items.product_id',$all_products->id)->whereBetween('sales_returns.date',[$startdate,$fdate2])->sum('sales_return_items.qty');


                                    $transfer_from = \App\Models\Transfer::where('product_id',$all_products->id)->where('from_wirehouse',$wdata->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                    $optransfer_from = \App\Models\Transfer::where('product_id',$all_products->id)->where('from_wirehouse',$wdata->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                                    $transfer_to = \App\Models\Transfer::where('product_id',$all_products->id)->where('confirm_status', 1)->where('to_wirehouse',$wdata->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                                    $optransfer_to = \App\Models\Transfer::where('product_id',$all_products->id)->where('confirm_status', 1)->where('to_wirehouse',$wdata->id)->whereBetween('date',[$startdate,$fdate2])->sum('qty');

                                     $damage = \App\Models\SalesDamage::where('product_id',$all_products->id)->where('warehouse_id',$wdata->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                     $opdamage = \App\Models\SalesDamage::where('product_id',$all_products->id)->where('warehouse_id',$wdata->id)->whereBetween('date',[$startdate,$fdate2])->sum('quantity');
                                     
                                     $reprocessQty = DB::table('reprocess')->where('fg_id',$all_products->id)->whereBetween('date',[$fdate,$tdate])->sum('quantity');
                                      
                                    // $dataItemOP = \App\Models\SalesProduct::select('product_name','product_weight','opening_balance')->where('id',$all_products->id)->first();
									 $product_name = $all_products->product_name; 
                          			 $productWeight = $all_products->product_weight;
                          			 if($reprocessQty > 0){
                          			 $reprocessBag = $reprocessQty/$productWeight;
                          			 } else {
                          			 $reprocessBag = 0; 
                          			 }
                          				if($wdata->id == 35) {
                                     		$itemOpenBalance = $all_products->opening_balance;
										} else {
                          					$itemOpenBalance = 0; 
                          					}
                                        $opblnce = ($openingstock+$optransfer_to + $itemOpenBalance)-($opsales+$optransfer_from+$opdamage);
                                        $clb = ($opblnce+$todaystock[0]->quantity+$transfer_to+$returnp)- ($sales+$returnp+$transfer_from+$damage+$reprocessBag);
                                        
                                        
                                        $total_op += $opblnce;
                                        $openingBalanceKg = $opblnce*$productWeight;
                                        $total_opKg += $openingBalanceKg;
                                        $gtotal_opKg += $openingBalanceKg;
                                        $total_si += $todaystock[0]->quantity*$productWeight;
                          				$total_bag_si += $todaystock[0]->quantity;
                                        $total_so += ($sales+$returnp)*$productWeight;
                          				$total_bag_so += $sales+$returnp;
                                        $return += $returnp;
                                         $total_trns_to += $transfer_to;
                                        $total_trns_from += $transfer_from;
                                        
                                       /* $total_dmg += $damage; */
                                        $total_clbBag += $clb;
                          				$total_clbKg += $clb*$productWeight;
                          				$totalReProcessKg += $todaystock[0]->reprocess_qty*$productWeight;
                          				$totalReProcessBag += $todaystock[0]->reprocess_qty;
                                        $totalReQty += $reprocessQty;                        				
                                        $gTotalReQty += $reprocessQty;
                                        $totalReBag += $reprocessBag;
                                        $gTotalReBag += $reprocessBag;
                                        $gtotal_op+= $opblnce;
                                        $gtotal_si += $todaystock[0]->quantity*$productWeight;
                                        $gtotal_so += ($sales+$returnp)*$productWeight;
                                        $greturn += $returnp;
                          
                                        $gtotal_trns_from += $transfer_from;
                                        $gtotal_trns_to += $transfer_to;
                                        /* $gtotal_dmg += $damage; */
                          
                                        $gtotal_clbBag += $clb;
                           				$gtotal_clbKg += $clb*$productWeight;
										$gtotalBag_so += ($sales+$returnp);
										$gtotalBag_si += $todaystock[0]->quantity; 
                          				$gTotalReProcessKg += $todaystock[0]->reprocess_qty*$productWeight;
                          				$gTotalReProcessBag += $todaystock[0]->reprocess_qty;
                                @endphp


                                @if($opblnce != 0 || $clb != 0)
                                <tr style="font-size: 12x;"><!--  -->

                                    {{-- <td>{{$loop->iteration}}</td> --}}
                                    <td>{{$product_name}}</td>
                                   
                                     @if($unit == 'Kg')
                                     <td> {{number_format($openingBalanceKg,2)}}  </td>
                                      @elseif($unit == 'Ton')
                                      <td> {{number_format($openingBalanceKg/1000,3)}} </td>
                                       @elseif($unit == 'Bag')
                                  	<td> {{number_format($opblnce,2)}}  </td>
                                      @else 
                                      	<td>{{number_format($openingBalanceKg,2)}} </td>
                                  		<td>{{number_format($openingBalanceKg/1000,3)}} </td>
                                  		<td>{{number_format($opblnce,2)}} </td>
                                      @endif
                                      @if($unit == 'Kg')
                                     <td> {{number_format($todaystock[0]->quantity*$productWeight,2)}}  </td>
                                      @elseif($unit == 'Ton')
                                      <td> {{number_format(($todaystock[0]->quantity*$productWeight)/1000,3)}} </td>
                                       @elseif($unit == 'Bag')
                                  	<td> {{number_format($todaystock[0]->quantity,2)}}  </td>
                                      @else 
                                      	<td>{{number_format($todaystock[0]->quantity*$productWeight,2)}} </td>
                                  		<td>{{number_format(($todaystock[0]->quantity*$productWeight)/1000,3)}} </td>
                                  		<td>{{number_format($todaystock[0]->quantity,2)}} </td>
                                      @endif
                                   
                                    
                                      @if($unit == 'Kg')
                                      <td> {{number_format(($sales+$returnp)*$productWeight,2)}} </td>
                                      @elseif($unit == 'Ton')
                                      <td> {{number_format(($sales+$returnp)*$productWeight/1000,3)}} </td>
                                      @elseif($unit == 'Bag')
                                  	<td> {{ number_format($sales+$returnp,2) }} </td>
                                      @else 
                                      	<td> {{number_format(($sales+$returnp)*$productWeight,2)}} </td>
                                  		<td> {{number_format(($sales+$returnp)*$productWeight/1000,3)}}</td>
                                  		<td> {{ number_format(($sales+$returnp),2)}} </td>
                                      @endif
                                   @if($unit == 'Kg')
                                     <td> {{number_format($reprocessQty,2)}}  </td>
                                      @elseif($unit == 'Ton')
                                      <td> {{number_format(($reprocessQty)/1000,3)}} </td>
                                       @elseif($unit == 'Bag')
                                  	    <td> {{ number_format($reprocessBag,2) }} </td>
                                      @else 
                                      	<td>{{number_format($reprocessQty,2)}} </td>
                                  		<td>{{number_format(($reprocessQty)/1000,3)}} </td>
                                  		<td> {{ number_format($reprocessBag,2) }} </td>
                                      @endif
                                    <td>{{number_format($returnp,2)}}</td>
                                     <td>{{$transfer_to}}</td>
                                    <td>{{$transfer_from}}</td>
                                   {{-- <td>{{number_format($damage, 2)}}</td> --}}
                                  
                                   @if($unit == 'Kg')
                                  	<td>{{number_format((($todaystock[0]->reprocess_qty)*$productWeight),2)}}</td>
                                    <td>{{number_format(($clb*$productWeight),2)}}</td>
                                    <td>{{number_format((($clb - $todaystock[0]->reprocess_qty)*$productWeight),2)}}</td>
                                  @elseif($unit == 'Ton')
                                  	<td>{{number_format((($todaystock[0]->reprocess_qty)*$productWeight)/1000,3)}}</td>
                                    <td>{{number_format(($clb*$productWeight)/1000,2)}}</td>
                                    <td>{{number_format((($clb - $todaystock[0]->reprocess_qty)*$productWeight)/1000,3)}}</td>
                                  @elseif($unit == 'Bag')
									<td>{{number_format($todaystock[0]->reprocess_qty,2)}}</td>
                                    <td>{{number_format($clb,2)}}</td>
                                    <td>{{number_format($clb - $todaystock[0]->reprocess_qty,2)}}</td>
                                  @else 
                                  	<td>{{number_format((($todaystock[0]->reprocess_qty)*$productWeight),2)}}</td>
                                    <td>{{number_format(($clb*$productWeight),2)}}</td>
                                    <td>{{number_format((($clb - $todaystock[0]->reprocess_qty)*$productWeight),2)}}</td>
                                  	<td>{{number_format((($todaystock[0]->reprocess_qty)*$productWeight)/1000,3)}}</td>
                                    <td>{{number_format(($clb*$productWeight)/1000,2)}}</td>
                                    <td>{{number_format((($clb - $todaystock[0]->reprocess_qty)*$productWeight)/1000,3)}}</td>
                                  	<td>{{number_format($todaystock[0]->reprocess_qty,2)}}</td>
                                    <td>{{number_format($clb,2)}}</td>
                                    <td>{{number_format($clb - $todaystock[0]->reprocess_qty,2)}}</td>
                                  @endif 
                                </tr>
                                @endif
                                @endforeach
                                 <tr style="background-color: rgba(255, 228, 196, 0.247);">
                                    
                                    <td> Sub Total</td>
                                    @if($unit == 'Kg')
                                    <td>{{number_format($total_opKg,2)}} </td>
                                   @elseif($unit == 'Ton')
                                   <td>{{number_format($total_opKg/1000,3)}} </td>
                                   @elseif($unit == 'Bag')
                                    <td>{{number_format($total_op,2)}} </td>
                                   @else 
                                   <td>{{number_format($total_opKg,2)}} </td>
                                   <td>{{number_format($total_opKg/1000,3)}} </td>
                                    <td>{{number_format($total_op,2)}} </td>
                                   @endif
                                   
                                   @if($unit == 'Kg')
                                    <td>{{number_format($total_si,2)}} </td>
                                   @elseif($unit == 'Ton')
                                   <td>{{number_format($total_si/1000,3)}} </td>
                                   @elseif($unit == 'Bag')
                                    <td>{{number_format($total_bag_si,2)}} </td>
                                   @else 
                                   <td>{{number_format($total_si,2)}} </td>
                                   <td>{{number_format($total_si/1000,3)}} </td>
                                    <td>{{number_format($total_bag_si,2)}} </td>
                                   @endif
                                   
                                   @if($unit == 'Kg')
                                    <td>{{number_format($total_so,2)}} </td>
                                   @elseif($unit == 'Ton')
                                   <td>{{number_format($total_so/1000,3)}} </td>
                                   @elseif($unit == 'Bag')
                                    <td> {{ number_format($total_bag_so,2)}} </td>
                                   @else 
                                    <td>{{number_format($total_so,2)}} </td>
                                   <td>{{number_format($total_so/1000,3)}} </td>
                                    <td> {{number_format($total_bag_so,2)}} </td>
                                   @endif 
                                   @if($unit == 'Kg')
                                    <td>{{number_format($totalReQty,2)}} </td>
                                   @elseif($unit == 'Ton')
                                   <td>{{number_format($totalReQty/1000,3)}} </td>
                                   @elseif($unit == 'Bag')
                                    <td> {{ number_format($totalReBag,2)}} </td>
                                   @else 
                                    <td>{{number_format($totalReQty,2)}} </td>
                                   <td>{{number_format($totalReQty/1000,3)}} </td>
                                    <td> {{ number_format($totalReBag,2)}} </td>
                                   @endif 
                                    <td>{{$return}}</td>

                                     <td>{{$total_trns_to}}</td>
                                    <td>{{$total_trns_from}}</td>
                                   {{-- <td>{{number_format($total_dmg,2)}}</td> --}}
                                   	@if($unit == 'Kg')
									<td>{{number_format($totalReProcessKg, 2)}} (Kg)</td>
                                    <td>{{number_format($total_clbKg,2)}} (Kg)</td>
                                   <td>{{number_format($total_clbKg - $totalReProcessKg, 2)}} (Kg)</td>
                                    @elseif($unit == 'Ton')
                                   	<td>{{number_format($totalReProcessKg/1000, 3)}} (Ton)</td>
                                    <td>{{number_format($total_clbKg/1000,3)}} (Ton)</td>
                                   <td>{{number_format(($total_clbKg - $totalReProcessKg)/1000, 3)}} (Ton)</td>
                                    @elseif($unit == 'Bag')
                                   <td>{{number_format($totalReProcessBag, 2)}} (Bag)</td>
                                    <td>{{number_format($total_clbBag,2)}} (Bag)</td>
                                   <td>{{number_format($total_clbBag - $totalReProcessBag, 2)}} (Bag)</td>
                                   @else 
                                   <td>{{number_format($totalReProcessKg, 2)}} (Kg)</td>
                                    <td>{{number_format($total_clbKg,2)}} (Kg)</td>
                                   <td>{{number_format($total_clbKg - $totalReProcessKg, 2)}} (Kg)</td>
                                   <td>{{number_format($totalReProcessKg/1000, 3)}} (Ton)</td>
                                    <td>{{number_format($total_clbKg/1000,3)}} (Ton)</td>
                                   <td>{{number_format(($total_clbKg - $totalReProcessKg)/1000, 3)}} (Ton)</td>
                                   <td>{{number_format($totalReProcessBag, 2)}} (Bag)</td>
                                    <td>{{number_format($total_clbBag,2)}} (Bag)</td>
                                   <td>{{number_format($total_clbBag - $totalReProcessBag, 2)}} (Bag)</td>
                                   @endif 
                                </tr>
                         @endforeach

                        </tbody>
                        <tfoot>
                            <tr style="background-color: rgba(255, 127, 80, 0.233);">
                                    
                                    <th>Total</th>
                                     @if($unit == 'Kg')
                                    <td>{{number_format($gtotal_opKg,2)}} (Kg)</td>
                                       @elseif($unit == 'Ton')
                                       <td>{{number_format($gtotal_opKg/1000,3)}} (Ton)</td>
                                       @elseif($unit == 'Bag')
                                        <td>{{number_format($gtotal_op,2)}} (Bag)</td>
                                       @else 
                                       <td>{{number_format($gtotal_opKg,2)}} (Kg) </td>
                                       <td>{{number_format($gtotal_opKg/1000,3)}} (Ton)</td>
                                        <td>{{number_format($gtotal_op,2)}} (Bag)</td>
                                       @endif
                                  	  @if($unit == 'Kg')
                                            <td>{{number_format($gtotal_si,2)}} (Kg)</td>
                                      @elseif($unit == 'Ton')
                                      		<td>{{number_format($gtotal_si/1000,3)}} (Ton)</td>
                                      @elseif($unit == 'Bag')
                                      		<td>{{number_format($gtotalBag_si,2)}} (Bag)</td>
                                      @else 
                                      		<td>{{number_format($gtotal_si,2)}} (Kg)</td>
                                      		<td>{{number_format($gtotal_si/1000,3)}} (Ton)</td>
                                      		<td>{{number_format($gtotalBag_si,2)}} (Bag)</td>
                                      @endif 
                                      		@if($unit == 'Kg')
                                            <td>{{number_format($gtotal_so,2)}} (Kg)</td>
                                      @elseif($unit == 'Ton')
                                      		<td>{{number_format($gtotal_so/1000,3)}} (Ton)</td>
                                      @elseif($unit == 'Bag')
                                      		<td>{{number_format($gtotalBag_so,2)}} (Bag)</td>
                                      @else 
                                      		<td>{{number_format($gtotal_so,2)}} (Kg)</td>
                                      		<td>{{number_format($gtotal_so/1000,3)}} (Ton)</td>
                                      		<td>{{number_format($gtotalBag_so,2)}} (Bag)</td>
                                      @endif 
                                      @if($unit == 'Kg')
                                    <td>{{number_format($gTotalReQty,2)}} </td>
                                   @elseif($unit == 'Ton')
                                   <td>{{number_format($gTotalReQty/1000,3)}} </td>
                                   @elseif($unit == 'Bag')
                                    <td> {{ number_format($gTotalReBag,2)}} </td>
                                   @else 
                                    <td>{{number_format($gTotalReQty,2)}} </td>
                                   <td>{{number_format($gTotalReQty/1000,3)}} </td>
                                    <td> {{ number_format($gTotalReBag,2)}} </td>
                                   @endif 
                                    <td>{{$greturn}}</td>
                                     <td>{{$gtotal_trns_to}}</td>
                                    <td>{{$gtotal_trns_from}}</td>
                                    {{-- <td>{{number_format($gtotal_dmg,2)}}</td> --}}
                              		@if($unit == 'Kg')
									<td>{{number_format($gTotalReProcessKg, 2)}} (Kg)</td>
                                    <td>{{number_format($gtotal_clbKg,2)}} (Kg)</td>
                              		<td>{{number_format($gtotal_clbKg - $gTotalReProcessKg, 2)}} (Kg)</td>
                              		@elseif($unit == 'Ton')
                              		<td>{{number_format($gTotalReProcessKg/1000, 3)}} (Ton)</td>
                                    <td>{{number_format($gtotal_clbKg/1000,3)}} (Ton)</td>
                              		<td>{{number_format(($gtotal_clbKg - $gTotalReProcessKg)/1000, 3)}} (Ton)</td>
                              		@elseif($unit == 'Bag')
                              		<td>{{number_format($gTotalReProcessBag, 2)}} (Bag)</td>
                                    <td>{{number_format($gtotal_clbBag,2)}} (Bag)</td>
                              		<td>{{number_format($gtotal_clbBag - $gTotalReProcessBag, 2)}} (Bag)</td>
                              		@else
                              		<td>{{number_format($gTotalReProcessKg, 2)}} (Kg)</td>
                                    <td>{{number_format($gtotal_clbKg,2)}} (Kg)</td>
                              		<td>{{number_format($gtotal_clbKg - $gTotalReProcessKg, 2)}} (Kg)</td>
                              		<td>{{number_format($gTotalReProcessKg/1000, 3)}} (Ton)</td>
                                    <td>{{number_format($gtotal_clbKg/1000,3)}} (Ton)</td>
                              		<td>{{number_format(($gtotal_clbKg - $gTotalReProcessKg)/1000, 3)}} (Ton)</td>
                              		<td>{{number_format($gTotalReProcessBag, 2)}} (Bag)</td>
                                    <td>{{number_format($gtotal_clbBag,2)}} (Bag)</td>
                              		<td>{{number_format($gtotal_clbBag - $gTotalReProcessBag, 2)}} (Bag)</td>
                              
                              		@endif
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
                filename: "StockReport.xls"
            });
        });
    });
</script>
@endsection
