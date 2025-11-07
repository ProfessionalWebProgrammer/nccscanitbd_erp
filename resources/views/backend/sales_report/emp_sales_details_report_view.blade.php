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
                      <h5 class="text-uppercase font-weight-bold">Employee Wise Sales Details  Report</h5>
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
                                <th>Category Name</th>
                                <th>Item Name</th>
                                <th>Order Quantity</th>
                              	<th>Delivery Quantity</th>
                                <th>Remaining Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                         @php
                             
                          	 $gTotalOQ = 0;
                          	 $gTotalDQ = 0;
                          	 $gTotalRQ = 0;
                          	 $totalRemainAmount = 0;
                        @endphp
								
                                @foreach($areas as $val)
                                @php                                   
                                   /* $datas = DB::table('sales_ledgers as s')
                          			->join('sales_order_items as o', 's.invoice', '=', 'o.invoice_no')
                          			->select('s.category_id','s.product_name','s.unit_price', DB::raw('sum(qty) as orderQty'), DB::raw('sum(qty_pcs) as deliveryQty'))
                          			->where('s.area_id',$val->id)->whereNotNull('s.category_id')->whereBetween('s.ledger_date',[$fdate,$tdate])
                          			->groupBy('s.category_id')->get(); */
                          
                          			$subTotalOQ= 0;
                          			$subTotalDQ= 0;
                          			$subTotalRQ= 0;
                          			$subTotalRemainAmount = 0;
                          			
                          			
                                  /* $datas = DB::table('sales_ledgers as s')->select('s.area_id','s.product_id','s.category_id','s.product_name','s.unit_price','s.invoice', DB::raw('sum(qty_pcs) as deliveryQty'))
                          					->where('s.area_id',$val->id)->whereNotNull('s.product_id')->whereBetween('s.ledger_date',[$fdate,$tdate])
                          					->groupBy('s.product_id')->get(); */
                          			$datas = DB::table('sales_order_items as s')->select('s.area_id','s.product_id','s.category_id','s.product_name','s.unit_price', DB::raw('sum(qty) as orderQty'))
                          					->where('s.area_id',$val->id)->whereNotNull('s.product_id')->whereBetween('s.date',[$fdate,$tdate])
                          					->groupBy('s.product_id')->get();
                                
                          			//$name = \App\Models\DealerArea::where('id',$val->id)->value('area_title');
									
                                @endphp
                          		<tr> 
                          			<td></td>
                                    <td colspan="7">{{$val->name}}</td>
                          		</tr>
								@foreach($datas as $data)
                          			@php
                          			$remainQty = 0; $remainAmount = 0; 
                          			$categoryName = DB::table('sales_categories')->where('id',$data->category_id)->value('category_name');
                          			
                          			$deliveryQty = DB::table('sales_ledgers')->where('area_id',$data->area_id)->whereBetween('ledger_date',[$fdate,$tdate])->where('product_id',$data->product_id)->sum('qty_pcs');
                          			
                          			$remainQty =  $data->orderQty -  $deliveryQty;
                          			$remainAmount = $remainQty*$data->unit_price;
                          			$subTotalOQ += $data->orderQty;
                          			$gTotalOQ += $data->orderQty;
                          			$subTotalDQ += $deliveryQty;
                          			$gTotalDQ += $deliveryQty;
                           			$subTotalRQ += $remainQty;
                          			$gTotalRQ += $remainQty;
                          			$subTotalRemainAmount += $remainAmount;
                          			
                          			$totalRemainAmount += $remainAmount;
                          			@endphp 
                          		
                          
                                <tr style="font-size: 12x;">
                                    <td>{{$loop->iteration}}</td>
                                    <td></td>
                                    <td>{{$categoryName}}</td>
                                  	<td >{{$data->product_name}}</td>
                                    <td>{{$data->orderQty}}</td> 
                                    <td>{{$deliveryQty}}</td>
                                    <td>{{ $remainQty }}</td> 
                                  	<td>{{ number_format($remainAmount,2) }}</td>
                                </tr>
							@endforeach
                          <tr style="background-color: rgba(255, 127, 80, 0.633);">
                                    <th></th>
                                    <th colspan="3">Sub Total </th>
                            		<th>{{$subTotalOQ}}</th>
                            		<th>{{$subTotalDQ}}</th>
                            		<th>{{$subTotalRQ}}</th>
                                    <td>{{number_format($subTotalRemainAmount,2)}}</td>
                            </tr> 
                         @endforeach

                         </tbody>
                           <tfoot>
                            <tr style="background-color: rgb(130 179 178);">
                                    <th></th>
                                    <th colspan="3">Grand Total </th>
                              		<th>{{number_format($gTotalOQ,0)}}</th>
                              		<th>{{number_format($gTotalDQ,0)}}</th>
                              		<th>{{number_format($gTotalRQ,0)}}</th>
                                    <td>{{number_format($totalRemainAmount,2)}}</td>
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
