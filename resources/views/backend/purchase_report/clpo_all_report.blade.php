@extends('layouts.purchase_deshboard')
@push('addcss')
    <style>
        .text_sale {
            color: #1fb715;
        }
        .text_credit{
            color: #f90b0b;
        }
          .tableFixHead          { overflow: auto; height: 600px; }
    	.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

    </style>
@endpush

@section('print_menu')

			<li class="nav-item">

                </li>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                     {{-- <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button> --}}
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                    </div>
                </div>
            <div class="container-fluid" id="contentbody">

              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Closing Stock and Outstanding Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                        <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>


                <div class="py-4 table-responsive tableFixHead">
                    <table  class="table table-bordered table-striped table-fixed"
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top" style="font-size: 16px;text-align: center;font-weight: bold;color: rgb(0, 0, 0);top: -25px;">
                              <th>Product Name</th>
                              <th colspan="2" style="text-align: center;">Consumption </th>
                              <th colspan="2" style="text-align: center;">C. Daily </th>
                              <th colspan="2" style="text-align: center;">Closing Stock</th>
                              <th colspan="2" style="text-align: center;">Covarage</th>
                              <th colspan="4" style="text-align: center;">PO Outstanding</th>
                            </tr>
                          <tr>
                              <th></th>
                            <th>Qty (Kg)</th>
                            <th>Qty (MT)</th>
                            <th>Qty (Kg)</th>
                            <th>Qty (MT)</th>
                            <th>Qty (Kg)</th>
                            <th>Qty (MT)</th>
                              <th>Day</th>
                              <th>Month</th>
                              <th>Qty (Kg)</th>
                              <th>Qty (Ton)</th>
                              <th>Rate</th>
                             <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                $consumptionTotal = 0;
                                $consumptionTotalKg = 0;
                              	$consumptionDayTotal = 0;
                              	$consumptionDayTotalKg = 0;
                                $closingDataTotal = 0;
                                $closingDataTotalKg = 0;
                                $coverageDayTotal = 0; 
                                $coverageMonthTotal = 0;
                              	$poQtyTotal = 0;
                              	$poRateTotal = 0;
                              	$poAmountTotal = 0;
                                @endphp
                                @foreach($products as $data)

                                @php
                                $consumption = 0;
                                $closingDataTemp = 0;
                              	$closingData = 0;
                                $coverageDay = 0; 
                                $coverageMonth = 0;
                              	$poQty = 0;
                              	$poQtyTon = 0;
                              	$poRate = 0;
                              	$poAmount = 0; 
  								$name = \App\Models\RowMaterialsProduct::where('id', $data->id)->value('product_name');
                               $stocko = DB::select('SELECT SUM(purchase_stockouts.stock_out_quantity) as stockout  FROM `purchase_stockouts`
                                WHERE purchase_stockouts.product_id = "'.$data->id.'" and  purchase_stockouts.date between "'.$fdate.'" and "'.$tdate.'" ');
                               
                              
                            $opbcalculet = DB::select('SELECT sum(row_materials_products.opening_balance) as opening_blns FROM `row_materials_products` where row_materials_products.id = "'.$data->id.'"');
                                       
							$stocin = DB::select('SELECT SUM(purchases.inventory_receive) as stock_in FROM `purchases`
                                WHERE  purchases.product_id = "'.$data->id.'"  and  purchases.date between "'.$fdate.'" and "'.$tdate.'" ');
							$pre_stocko = DB::select('SELECT SUM(purchases.receive_quantity) as stockout FROM `purchases`
                                WHERE purchases.product_id = "'.$data->id.'" and  purchases.date between "'.$sdate.'" and "'.$pdate.'" ');
                              
                            $closingDataTemp = ($opbcalculet[0]->opening_blns + $pre_stocko[0]->stockout + $stocin[0]->stock_in) - $stocko[0]->stockout;
                            $closingDataTotalKg += $closingDataTemp;
                            $closingData = $closingDataTemp/1000;
                              
                            $poData = DB::table('purchase_order_creates as p')->select([DB::raw("SUM(pd.quantity) poQty"),DB::raw("AVG(pd.rate) rate"), DB::raw("SUM(pd.amount) amount")])
                    				->leftjoin('purchase_order_create_details as pd', 'p.id', '=', 'pd.purchase_order_id')
                    				->where('pd.product_id',$data->id)
                    				->whereBetween('p.date',[$fdate,$tdate])->get();
                              
                              $closingDataTotal += $closingData; 
                              
                              if(!empty($stocko[0]->stockout)){
                                $consumption = $stocko[0]->stockout/1000;
                                $consumptionTotalKg += $stocko[0]->stockout;
                              	$consumptionTotal += $consumption;
                              	$temp1 = 0;$temp = 0;
                                $temp1 = $stocko[0]->stockout/$day;
                                $temp = $consumption/$day;
                                $coverageDay = $closingData/$temp;
                                $coverageMonth = $closingData/$consumption;
                              	$consumptionDayTotalKg += $temp1;
                                $consumptionDayTotal += $temp;
                                $coverageDayTotal += $coverageDay;
                              	$coverageMonthTotal += $coverageMonth;
                               } else {
                              	$consumption = ''; $coverageDay = 0; $coverageMonth = 0;
                               }
                              
                              $poQty = $poData[0]->poQty;
                              $poQtyTon = $poData[0]->poQty/1000;
                              $poRate = $poData[0]->rate;
                              $poAmount = $poData[0]->amount;
                              $poQtyTotal += $poQty;
                              $poRateTotal += $poRate;
                              $poAmountTotal += $poAmount;
                              	@endphp

                                <tr>
                                    <td>{{$name}}</td>
                                    <td>{{$stocko[0]->stockout}}</td>
                                    <td>@if(!empty($consumption)) {{ number_format(($consumption),3) }} @else 0 @endif  </td>
                                   <td>{{$stocko[0]->stockout/$day}}</td>
                                    <td>@if(!empty($consumption)) {{ number_format(($consumption/$day),3) }} @else 0 @endif  </td>
                                    <td>{{ $closingDataTemp }}</td>
                                    <td>@if(!empty($closingData)) {{ number_format($closingData,3) }} @else 0 @endif </td>

                                   	<td>{{number_format($coverageDay,2)}}</td>
                                    <td>{{number_format($coverageMonth,2)}}</td>
                                  
                                    <td>{{number_format($poQty,2)}} </td>
                                    <td>{{number_format($poQtyTon,3)}} </td>
                                    <td>{{number_format($poRate,2)}} </td>
                                    <td>{{number_format($poAmount,2)}} </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            
                                <tr style="background-color: rgb(52 161 158 / 59%);">
                                    <td><b>Total : </b></td>
                                  	<td><b> {{$consumptionTotalKg}}</b></td>
                                    <td><b>{{number_format($consumptionTotal,3)}} Ton</b></td>
                                    <td><b> {{$consumptionDayTotalKg}}</b></td>
                                    <td><b>{{number_format($consumptionDayTotal,3)}} Ton</b></td>
                                    <td><b> {{ $closingDataTotalKg }} </b></td>
                                    <td><b>{{number_format($closingDataTotal,3)}} Ton</b></td>
                                    <td><b>{{number_format($coverageDayTotal,2)}} </b></td>
                                    <td><b>{{number_format($coverageMonthTotal,2)}} </b></td>
                                    <td><b>{{number_format($poQtyTotal,2)}} Kg</b></td>
                                    <td><b>{{number_format($poQtyTotal/1000,3)}} Ton</b></td>
                                    <td><b>{{number_format($poRateTotal,2)}} Tk</b></td>
                                    <td><b>{{number_format($poAmountTotal,2)}} Tk</b></td>
                                </tr> 
                            </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
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
                filename: "StockReportPurchase.xls"
            });
        });
    });
</script>
@endsection
