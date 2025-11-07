@extends('layouts.backendbase')


@section('print_menu')

			<li class="nav-item">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                </li>
			<li class="nav-item ml-1">
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
                </li>

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="contentbody">



        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="text-center pt-3">
                    <h5 class="text-uppercase font-weight-bold">Product History Stock Report</h5>

                    <h6>From {{ date('d F Y', strtotime($fdate)) }}
                        To
                        {{ date('d F Y', strtotime($tdate)) }}</h6>

                    <hr>
                </div>
                <div class="py-4">
                    <table id="reporttable" class="table table-bordered table-striped table-fixed font-weight-bold" style="font-size: 15px;">
                        <thead>
                             <tr>
                                <th>Product</th>
                                <th>Date</th>
                                <th>Stock In</th>
                                <th>Stock Out</th>
                                <th>Return</th>
                                <th>Transfer in</th>
                                <th>transfer out</th>
                                <th>Balance</th>
                             </tr>
                        </thead>
                        <tbody>
        					@php
                          		$totalstockin = 0;
                          		$totalstockout = 0;
                          		$totalreturn = 0;
                          		$totaltransferin = 0;
                          		$totaltransferout =0;
                          		$totalbalance = 0;
                          	@endphp
							@foreach ($wirehousedata as $w)
                                      <tr style="background: #ffe4b56b;">
                                        	<td colspan="8">{{ $w->factory_name }}</td>
                                      </tr>
                          				@foreach ($products as $p)

                          					 @php
                                                $fdate2 =date('Y-m-d', strtotime('-1 day', strtotime($fdate)));


                          						 $stockin = DB::table('purchases')
                                                          ->where('product_id', $p->id)
                                                          ->where('wirehouse_id', $w->id)
                                                          ->whereBetween('date',[$fdate,$tdate])
                                                          ->sum('receive_quantity');

                         						$stockout = DB::table('purchase_stockouts')
                                                          ->where('product_id', $p->id)
                                                          ->where('wirehouse_id', $w->id)
                                                          ->whereBetween('date',[$fdate,$tdate])
                                                          ->sum('stock_out_quantity');

                          						$stockreturn = DB::table('purchase_returns')
                                                          ->where('product_id', $p->id)
                                                          ->where('wirehouse_id', $w->id)
                                                          ->whereBetween('date',[$fdate,$tdate])
                                                          ->sum('return_quantity');

                          						$ptransferin = DB::table('purchase_transfers')
                                                          ->where('product_id', $p->id)
                                                          ->where('to_wirehouse_id', $w->id)
                                                          ->whereBetween('date',[$fdate,$tdate])
                                                          ->sum('qty');

                          						$ptransferout = DB::table('purchase_transfers')
                                                          ->where('product_id', $p->id)
                                                          ->where('from_wirehouse_id', $w->id)
                                                          ->whereBetween('date',[$fdate,$tdate])
                                                          ->sum('qty');
                          						$balance = ($stockin+$ptransferin)-($stockout+$ptransferout+$stockreturn);
                                            @endphp

                          						@php
                                                  $totalstockin += $stockin;
                                                  $totalstockout += $stockout;
                                                  $totalreturn += $stockreturn;
                                                  $totaltransferin += $ptransferin;
                                                  $totaltransferout +=$ptransferout;
                                                  $totalbalance += $balance ;
                                            	@endphp

                                            <tr>
                                                <td>{{ $p->product_name }}</td>
                                              	<td>{{ date('d-M', strtotime($fdate)) }} <span class="text-danger font-weight-bold">TO</span> {{ date('d-M', strtotime($tdate)) }}</td>
                                              	<td class="text-right">{{$stockin}}</td>
                                              	<td class="text-right">{{$stockout}}</td>
                                                <td class="text-right">{{$stockreturn}}</td>
                                                <td class="text-right">{{$ptransferin}}</td>
                                                <td class="text-right">{{$ptransferout}}</td>
                                                <td class="text-right">{{$balance}}</td>
                                            </tr>
                              			@endforeach
                            @endforeach


                         </tbody>
                           <tfoot>
                            <tr style="background-color: rgba(255, 127, 80, 0.233);">
                                    <th></th>
                                    <th>Total</th>
                                    <th class="text-right">{{$totalstockin}}</th>
                                    <th class="text-right">{{$totalstockout}}</th>
                                    <th class="text-right">{{$totalreturn}}</th>
                                    <th class="text-right">{{$totaltransferin}}</th>
                                    <th class="text-right">{{$totaltransferout}}</th>
                                    <th class="text-right">{{$totalbalance}}</th>

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
                filename: "ProductHistoryStock.xls"
            });
        });
    });
</script>
@endsection
