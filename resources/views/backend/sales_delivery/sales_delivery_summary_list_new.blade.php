@extends('layouts.sales_dashboard')

@push('addcss')

@endpush

@section('header_menu')

@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">
				@php 
                  	$totalQty = 0;
                    $totalQtyTon = 0;
                    $totalAmount = 0;
      				$totalOrder = 0; 
                  @endphp 

        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background: #ffffff; padding: 0px 40px;">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Sales Delivery Summary Details List</h5>
                </div>
           <div class="summery-report row">
              	{{-- <div class="col-4">
                <h3>Today Total Invoice: <b></b></h3>
                <h3>Today Delivered Invoice: <b>{{$delivery_count}}</b></h3>
                <h3>Today undelivery Invoice: <b></b></h3>
            	</div> 
              <div class="col-4">
                <h3>Today Total Ton: <b></b></h3>
                <h3>Today Delivered Ton: <b>{{$totalQtyTon}}</b></h3>
                <h3>Today undelivery Ton: <b></b></h3>
            	</div> --}}
             {{-- @foreach($saleslist as $val)
             @php 
             	$qty = DB::table('sales_items')->where('invoice_no',$val->invoice)->where('product_id',$val->product_id)->sum('remain_qty');
             $totalOrder += $qty;
             @endphp 
             @endforeach --}} 
             <div class="col-4">
                <h3>Today Total Bag: <b></b></h3>
                <h3>Today Delivered Bag: <b>{{$delivery_count}}</b></h3>
                <h3>Today undelivery Bag: <b></b></h3>
            </div>
            <div class="col-4" >
                        <form class="" action="{{Route('sales.delivery.summary.list')}}" method="get">


                    <div class="">
                        <h5  style="color:#000;font-weight:600;">Select Date</h5>
                         <div class="form-group ">
                       <input type="text" name="date" class="form-control float-right" id="daterangepicker"
                                    value="{{ $date }}"></div>
                    </div>
					<div class="">
                        <h5  style="color:#000;font-weight:600;">Select Products</h5>
                        <div class="form-group">
                            <select  class="form-control selectpicker" data-show-subtext="true"
                                        data-live-search="true"  data-actions-box="true" multiple name="product_id[]" required>
                                <option value="">Select Products</option>
                                @foreach($products as $val)
                                <option  style="color:#000;font-weight:600;" value="{{$val->id}}" >{{$val->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                     <div class="">
                        <h5  style="color:#000;font-weight:600;">Select Warehouse</h5>
                        <div class="form-group">
                            <select id="serach-vendor" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" name="warehouse_id">
                                <option value="">Select Warehouse</option>
                                @foreach($wirehouses as $w)
                                <option  style="color:#000;font-weight:600;" value="{{$w->id}}" {{($warehouse_id == $w->id)?'selected':null}}>{{$w->factory_name}}</option>
                                @endforeach
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

                <div class="py-4 table-responsive">



                    <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 9px;">
                       <thead>
                    <tr>
                        <th>Si.No</th>
                        {{-- <th>User</th> 
                        <th>Dealer Name</th>
                        <th width="110px">Date</th> --}}
                      	<th>Product Name</th>
                       {{--  <th>Status</th> 
                        <th>Invoice No</th> --}}
                        <th>Quantity (Bag)</th>
                      	<th>Quantity (Ton)</th>
                        <th>Grand Total</th>
                        {{-- <th>Warehouse</th> --}}
                    </tr>
                </thead>
                <tbody>
                  @foreach($category as $val)
                  <tr>
                  <td colspan="100%">{{$val->category_name}}</td>
                  </tr>
                  @php 
                  $saleslist = DB::table('sales_ledgers as t1')
                      ->select( DB::raw('sum(total_price) as total_price,sum(qty_pcs) as qty_pcs ,sum(qty_kg) as qty_kg'), 't2.product_name','t1.invoice','t1.product_id')
                      ->join('sales_products as t2', 't1.product_id', '=', 't2.id')->where('t1.category_id',$val->id)
                      ->whereIn('t1.product_id',$product)->whereBetween('t1.ledger_date', [$fdate, $tdate])
                      ->orderBy('t1.ledger_date','desc')->groupBy('t1.product_id')->take(200)
                      ->get();
                 
                  	$subTotalQty = 0;
                    $subTotalQtyTon = 0;
                    $subTotalAmount = 0;
      				
                 
                  @endphp 
                @foreach($saleslist as $all_saleslist)
                @php
                //$username = DB::select('SELECT name FROM `users` WHERE id="'.$all_saleslist->emp_id.'"');
                  $totalQty += $all_saleslist->qty_pcs;
                  $subTotalQty += $all_saleslist->qty_pcs;
                  
                  $totalQtyTon += $all_saleslist->qty_kg/1000;
                  $subTotalQtyTon += $all_saleslist->qty_kg/1000;
                  $totalAmount += $all_saleslist->total_price;
                  $subTotalAmount += $all_saleslist->total_price;
                @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        {{-- <td>{{$all_saleslist->created_at}} {{$username[0]->name ?? 0}}</td> 
                        <td>{{$all_saleslist->d_s_name}}</td>
                        <td>{{$all_saleslist->ledger_date}}</td> --}}
                        
                        <td >{{$all_saleslist->product_name}}</td>
                       
                        {{-- <td>{{$all_saleslist->invoice }}</td> --}}
                       
                        <td>{{$all_saleslist->qty_pcs}}</td>
                        <td>{{$all_saleslist->qty_kg/1000}}</td>
                        <td>{{$all_saleslist->total_price}}</td>
                        {{-- <td>{{$all_saleslist->factory_name}}</td> --}}
                    </tr>
                @endforeach
                  <tr>
                        <td colspan="2">Sub Total: </td>
                        <td>{{$subTotalQty}} </td>
                        <td>{{$subTotalQtyTon}}</td>
                        <td>{{ number_format($subTotalAmount,2)}} </td>
                      </tr>
                  @endforeach
                </tbody>
                      <tfoot>
                      <tr>
                        <td colspan="2">Total: </td>
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



    <!-- /.modal -->

   {{--  <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('sales.invoice.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this invoice?</p>

                        <input type="hidden" id="mid" name="id">
                        <input type="hidden" id="minvoice" name="invoice">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-light">Confirm</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div> --}}

    <!-- /.modal -->



@endsection

@push('end_js')

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })


        $('#delete').on('show.bs.modal', function(event) {
            console.log('hello test');
            var button = $(event.relatedTarget)
            var title = button.data('mytitle')
            var id = button.data('myid')

            var modal = $(this)

            modal.find('.modal-body #minvoice').val(id);
        })
    </script>

@endpush
