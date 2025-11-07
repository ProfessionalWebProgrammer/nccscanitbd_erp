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
                      <h5 class="text-uppercase font-weight-bold">Employee Wise Sales Order  Report</h5>
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
                              <th>Order Quantity (Ton)</th>
                                <th>Order Quantity (Bag)</th>
                            </tr>
                        </thead>
                        <tbody>
                         @php
                             $gtotal_qty= 0;
                          $gTotal_ton = 0; 
                        @endphp

                                @foreach($areas as $val)
                                @php                                 
                                   // $qty = \App\Models\SalesOrder::where('vendor_area_id',$val->id)->where('is_active',1)->whereBetween('date',[$fdate,$tdate])->sum('total_qty');
                          			$qtyTon = 0; $qty = 0; 
                         		  // $qty = \App\Models\SalesOrderItem::where('area_id',$val->id)->whereBetween('date',[$fdate,$tdate])->sum('qty');
                          			$datas = \App\Models\SalesOrderItem::select('product_weight','qty')->where('area_id',$val->id)->whereBetween('date',[$fdate,$tdate])->get();
                                   	$name = \App\Models\DealerArea::where('id',$val->id)->value('area_title');
                                   
                          			foreach($datas as $data){
                          			$qty += $data->qty;
                          			$qtyTon += ($data->qty * $data->product_weight)/1000;
                          			}
                          			$gtotal_qty +=$qty;
                          			$gTotal_ton += $qtyTon; 
                                @endphp

                                <tr style="font-size: 12x;">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$name}}</td>
                                    <td>{{$qtyTon}}</td>
                                  <td>{{number_format($qty,2)}}</td>
                                </tr>

                         @endforeach

                         </tbody>
                           <tfoot>
                            <tr style="background-color: rgba(255, 127, 80, 0.233);">
                                    <th></th>
                                    <th>Total</th>
                                    <td>{{number_format($gTotal_ton,2)}} (Ton)</td>
                              		<td>{{number_format($gtotal_qty,2)}} (Bag)</td>
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
