@extends('layouts.sales_dashboard')


@section('print_menu')


@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" >


        <!-- Main content -->
        <div class="content px-4 ">
          <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      <button class="btn btn-sm  btn-success mt-1" id="btnExport"> Export  </button>
                      <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  > Print  </button>
                      <button class="btn btn-sm  btn-warning mt-1"  onclick="printland()"  id="printland"  > PrintLands. </button>
                    </div>
          </div>

            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh"  id="contentbody">
              <div class="row pt-2">
                  	<div class="col-md-4 text-left">
                      <h5 class="text-uppercase font-weight-bold">Employee Wise Sales Delivery  Report</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  		<p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>
                <div class="py-4">
                    <table id="reporttable"  class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="table-header-fixt-top">
                                <th>SI No</th>
                                <th>Employee Name</th>
                              	<th>Order Quantity (Bag)</th>
                              	<th>Order Quantity (Ton)</th>
                                <th>Delivery Quantity (Bag)</th>
                               	<th>Delivery Quantity (Ton)</th>
                              	<th>Undelivered Quantity (Bag)</th>
                              	<th>Undelivered Quantity (Ton)</th>
                            </tr>
                        </thead>
                        <tbody>
                         @php
                            $gtotalDeliveryBag = 0;
                          	$gtotalDeliveryTon = 0;
                          	$gTotalOrderBag = 0; 
                          	$gTotalOrderTon = 0;
                        @endphp

                                @foreach($areas as $val) 
                                @php           
                                
                                  //  $qty = \App\Models\SalesLedger::where('area_id',$val->id)->join('sales_orders', 'sales_ledgers.invoice', '=', 'sales_orders.invoice_no')->whereBetween('ledger_date',[$fdate,$tdate])->sum('sales_orders.total_qty');
                                 	
                          			$totalOrder = 0; $totalOrderQtyTon = 0; $totalDeliveryQtyTon = 0; 
                          			 
                          			$deliveryData = \App\Models\SalesLedger::select([DB::raw("SUM(qty_pcs) total_bag"),DB::raw("SUM(qty_kg) total_kg")])->where('area_id',$val->id)->whereBetween('ledger_date',[$fdate,$tdate])->get();
                          		 
                          			$totalDatas = \App\Models\SalesOrderItem::select('product_weight','qty')->where('area_id',$val->id)->whereBetween('date',[$fdate,$tdate])->get();
                          			
                          			//$totalOrder = \App\Models\Sale::where('vendor_area_id',$val->id)->whereBetween('date',[$fdate,$tdate])->sum('total_qty');
                          			//$name = \App\Models\DealerArea::where('id',$val->id)->value('area_title');
                          				
                          				
                          				
                          
                          			foreach($totalDatas as $data){
                          		
                          			$totalOrder += intval($data->qty);
                          			
                          			$totalOrderQtyTon += (intval($data->qty) * floatval($data->product_weight))/1000;
                          			}
                          			$gTotalOrderBag += $totalOrder;
                          			$gTotalOrderTon += $totalOrderQtyTon;
                          			$gtotalDeliveryBag += $deliveryData[0]->total_bag;
                          			$totalDeliveryQtyTon = $deliveryData[0]->total_kg/1000;
                          			$gtotalDeliveryTon += $totalDeliveryQtyTon;

                                @endphp
                              
                                <tr style="font-size: 12x;">
                                    <td>{{$loop->iteration}}</td> 
                                    <td>{{$val->name}}</td>
                                    <td>{{number_format($totalOrder,2)}}</td>
                                  	<td>{{number_format($totalOrderQtyTon,2)}}</td>
                                  	<td>{{number_format($deliveryData[0]->total_bag,2)}}</td>
                                  	<td>{{number_format($totalDeliveryQtyTon,2)}}</td>
                                  	<td>{{number_format($totalOrder - $deliveryData[0]->total_bag,2)}}</td>
                                  	<td>{{number_format($totalOrderQtyTon - $totalDeliveryQtyTon,2)}}</td>
                                </tr>

                         @endforeach

                         </tbody>
                           <tfoot>
                            <tr style="background:#FA621C; font-weight:700; font-size:18px; color:#f5f5f5;">
                                    <th></th>
                                    <th>Total</th>
                                    <td>{{number_format($gTotalOrderBag,2)}} (Bag)</td>
                              		<td>{{number_format($gTotalOrderTon,2)}} (Ton)</td>
                              		<td>{{number_format($gtotalDeliveryBag,2)}} (Bag)</td>
                              		<td>{{number_format($gtotalDeliveryTon,2)}} (Ton)</td>
                              		<td>{{number_format($gTotalOrderBag - $gtotalDeliveryBag,2)}} (Bag)</td>
                              		<td>{{number_format($gTotalOrderTon - $gtotalDeliveryTon,2)}} (Ton)</td>
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
                filename: "Sales Stoct Report.xls"
            });
        });
    });
</script>
@endsection
