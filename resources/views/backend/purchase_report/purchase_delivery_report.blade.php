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
                      <h5 class="text-uppercase font-weight-bold">Outstanding Purchase Order Statement</h5>
                      <p>From {{date('d M, Y',strtotime($fdate))}} to {{date('d M, Y',strtotime($tdate))}}</p>

                    </div>
                  	<div class="col-md-4 pt-3 text-center">
                      	<h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                        <p>Head office, Rajshahi, Bangladesh</p>
                    </div>
                </div>


                <div class="py-4 table-responsive tableFixHead">
                    <table id="datatablecustom" class="table table-bordered table-striped table-fixed "
                        style="font-size: 15px;table-layout: inherit;">
                        <thead>
                            <tr class="table-header-fixt-top" style="font-size: 16px;text-align: center;font-weight: bold;color: rgb(0, 0, 0);top: -25px;">
                              <th width="120px">Date</th>
                              <th width="100px">PO No</th>
                              <th>Supplier Name</th>
                              <th>Product Name</th>
                              <th colspan="3">PO Qnty </th>
                              <th colspan="3">Receive Qnty</th>
                              
                              <th colspan="3">Outstanding Qnty</th>
                              
                            </tr>
                          <tr>
                              <th></th><th></th><th></th><th></th>
                            
                            <th>Qnty</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th>Qnty</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th>Qnty</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                               
                                @endphp
                                @foreach($suppliers as $data)
								
                                @php
                                $name = \App\Models\Supplier::where('id',$data->id)->value('supplier_name');
  							  $products = \App\Models\Purchase::where('raw_supplier_id', $data->id)->whereBetween('date',[$fdate,$tdate])->groupby('product_id')->get();
//dd($products);
                              	@endphp
                                <tr>
                                  <td></td>
                              	  	<td colspan="12"><b>{{$name}}</b></td>
                              	</tr>
                              @foreach($products as $val)
								@php 
                              	$purchaseOrder = DB::table('purchase_order_creates as p')
                              		  ->select([DB::raw("SUM(pd.quantity) poQty"),DB::raw("AVG(pd.rate) rate")])
                                      ->leftjoin('purchase_order_create_details as pd', 'p.id', '=', 'pd.purchase_order_id')
                              		  ->leftjoin('purchases as pp', 'p.order_no', '=', 'pp.po_no')
                                      ->where('pd.product_id',$val->product_id)
                                      ->whereBetween('p.date',[$fdate,$tdate])->get();
                               $name = \App\Models\RowMaterialsProduct::where('id', $val->product_id)->value('product_name');
                                @endphp 
                                <tr>
                                  <td>{{$val->date}}</td>
                                   <td>{{$val->po_no}}</td>
                                    
                                    <td colspan="2">{{$name}}</td>
                                    
                                    <td>@if(!empty($purchaseOrder[0]->poQty)) {{ $purchaseOrder[0]->poQty }} @else 0 @endif  </td>
                                  <td>{{$purchaseOrder[0]->rate}}</td>
                                  <td>{{number_format($purchaseOrder[0]->poQty*$purchaseOrder[0]->rate,2)}} </td>
                                  	
                                    <td>@if(!empty($val->receive_quantity)) {{ $val->receive_quantity }} @else 0 @endif  </td>
                                    <td>{{$val->purchase_rate}}</td>
                                    <td> {{number_format($val->receive_quantity*$val->purchase_rate,2)}}</td> 
                                  
                                    <td> {{ $purchaseOrder[0]->poQty - $val->receive_quantity }}</td>
                                    <td> {{ $purchaseOrder[0]->rate }}</td>
                                   	<td> {{ number_format(($purchaseOrder[0]->poQty - $val->receive_quantity)*$purchaseOrder[0]->rate,2) }}</td>
                                    
                                </tr> 
                                @endforeach
                              @endforeach
                            </tbody>
                            
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
