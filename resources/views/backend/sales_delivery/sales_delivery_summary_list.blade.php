@extends('layouts.sales_dashboard')

@push('addcss')

@endpush


@section('print_menu')
			{{-- <li class="nav-item">
                    <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                       Export
                    </button>
                </li> --}}
			<li class="nav-item ml-1">
                    <button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                       Print
                    </button>
            </li>
@endsection



@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent" >
				@php 
                  	$totalQty = 0;
                    $totalQtyTon = 0;
                    $totalAmount = 0;
                  @endphp 

        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background: #ffffff; padding: 0px 40px;">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    
                </div>
           <div class="summery-report row">
              	{{-- <div class="col-4">
                <h3>Today Total Invoice: <b>{{$invoice_count[0]->tota_invoice}}</b></h3>
                <h3>Today Delivered Invoice: <b>{{$delivery_count[0]->tota_delivery}}</b></h3>
                <h3>Today undelivery Invoice: <b>{{($invoice_count[0]->tota_invoice)-($delivery_count[0]->tota_delivery)}}</b></h3>
            	</div> 
              <div class="col-4">
                <h3>Today Total Ton: <b></b></h3>
                <h3>Today Delivered Ton: <b>{{$totalQtyTon}}</b></h3>
                <h3>Today undelivery Ton: <b></b></h3>
            	</div> --}}
             <div class="col-4">
                <h5>Today Total Bag: <b>{{$invoice_count[0]->total_qty}}</b></h5>
                <h5>Today Delivered Bag: <b>{{$delivery_count[0]->total_qty}}</b></h5>
                <h5>Today undelivery Bag: <b>{{($invoice_count[0]->total_qty)-($delivery_count[0]->total_qty)}}</b></h5>
            </div>
            <div class="col-4" >
                        <form class="" action="{{Route('sales.delivery.summary.list')}}" method="get">


                    <div class="">
                        <h5  style="color:#000;font-weight:400;">Select Date</h5>
                         <div class="form-group ">
                       <input type="text" name="date" class="form-control float-right" id="daterangepicker"
                                    value="{{ $date }}"></div>
                    </div>
					<div class="">
                        <h5  style="color:#000;font-weight:400;">Select Products</h5>
                        <div class="form-group">
                            <select  class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true"  data-actions-box="true" multiple name="product_id[]">
                                <option value="">Select Products</option>
                                @foreach($products as $val)
                                <option  style="color:#000;font-weight:600;" value="{{$val->id}}" >{{$val->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                     <div class="">
                        <h5  style="color:#000;font-weight:400;">Select Warehouse</h5>
                        <div class="form-group">
                            <select id="serach-vendor" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" name="warehouse_id">
                                <option value="">Select Warehouse</option>
                              @if($authid != 169)
                                @foreach($wirehouses as $w)
                                <option  style="color:#000;font-weight:600;" value="{{$w->id}}" {{($warehouse_id == $w->id)?'selected':null}}>{{$w->factory_name}}</option>
                                @endforeach
                              @else 
                                  <option style="color: #FF0000; font-weight:bold" value="36" >Mymensingh Depo </option>
                              @endif 
                            </select>
                        </div>
                    </div>
                                  <button type="submit" class="btn btn-primary">Search</button>

                      </form>  
                    </div>
              

        </div>

        {{-- <div>
        		<h3>RRP U-3: <b>{{$rrpu3[0]->tota_invoice}}/{{$rrpu3[0]->total_qty}}(Bag)</b></h3>
        		<h3>ISHAWRDI: <b>{{$ishawrdi[0]->tota_invoice}}/{{$ishawrdi[0]->total_qty}}(Bag)</b></h3>

        </div> --}}

                <div class="py-4 table-responsive" id="contentbody">

<h5 class="mt-3 mb-3">Sales Delivery Summary Details List</h5>

                    <table id="datatable" class="table table-bordered table-striped table-fixed" style="font-size: 9px;">
                       <thead>
                    <tr>
                        {{--<th>Si.No</th>
                         <th>User</th> 
                        <th>Dealer Name</th>--}}
                        <th width="110px">Date</th>
                      	<th>Product Name</th>
                       {{--  <th>Status</th> --}}
                        <th>Invoice No</th>
                        <th>Quantity (Bag)</th>
                      	<th>Quantity (Ton)</th>
                        <th>Grand Total</th>
                        {{-- <th>Warehouse</th> --}}
                    </tr>
                </thead>
                <tbody>
                  
                @foreach($saleslist as $val)
                  <tr>
                    
                  	<td colspan="100%" style="font-size:13px; color:red;"><b> {{$val->d_s_name}}</b></td>
                  </tr>
                @php
                 $salesDatas =  DB::table('sales_ledgers as t1')
            			->where('t1.vendor_id',$val->vendor_id)
                  		->whereBetween('t1.ledger_date', [$fdate, $tdate])
                  		->whereNotNull('t1.product_id')->get();                  
                @endphp
                    @foreach($salesDatas as $data)
                    @php 
                    $totalQty += $data->qty_pcs;
                    $totalQtyTon += $data->qty_kg/1000;
                    $totalAmount += $data->total_price;
                    @endphp 
                      <tr>
                          <td>{{$data->ledger_date}}</td>

                          <td >{{$data->product_name}}</td>

                          <td>{{$data->invoice }}</td>

                          <td>{{$data->qty_pcs}}</td>
                          <td>{{$data->qty_kg/1000}}</td>
                          <td>{{$data->total_price}}</td>

                      </tr>
                      @endforeach
                  @endforeach
                </tbody>
                      <tfoot>
                     <tr class="bg-info" style="color:#000;">
                        <td colspan="3">Total: </td>
                        <td>{{$totalQty}} (Bag)</td>
                        <td>{{$totalQtyTon}} (Ton)</td>
                        <td>{{ number_format($totalAmount,2)}} </td>
                      </tr>
                    </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('end_js')

    <script type="text/javascript">
    function printDiv(divName) {
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
        }
</script>
@endpush
