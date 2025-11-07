@extends('layouts.sales_dashboard')

@push('addcss')

@endpush

@section('header_menu')

@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container" style="background: #ffffff; padding: 0px 40px;">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Sales Delivery Summary List</h5>
                </div>
           <div class="summery-report row">
              <div class="col-4">
                <h5>Today Total Invoice: <b>{{$invoice_count[0]->tota_invoice}}</b></h5>
                <h5>Today Delivered Invoice: <b>{{$delivery_count[0]->tota_delivery}}</b></h5>
                <h5>Today undelivery Invoice: <b>{{($invoice_count[0]->tota_invoice)-($delivery_count[0]->tota_delivery)}}</b></h5>
            </div>
             <div class="col-4">
                <h5>Today Total Bag: <b>{{$invoice_count[0]->total_qty}}</b></h5>
                <h5>Today Delivered Bag: <b>{{$delivery_count[0]->total_qty}}</b></h5>
                <h5>Today undelivery Bag: <b>{{($invoice_count[0]->total_qty)-($delivery_count[0]->total_qty)}}</b></h5>
            </div>
            <div class="col-4" >
                        <form class="" action="{{Route('sales.delivery.list')}}" method="get">


                    <div class="">
                        <h5  style="color:#000;font-weight:400;">Select Date</h5>
                         <div class="form-group ">
                       <input type="text" name="date" class="form-control float-right" id="daterangepicker"
                                    value="{{ $date }}"></div>
                    </div>

                     <div class="">
                        <h5  style="color:#000;font-weight:400;">Select Warehouse</h5>
                        <div class="form-group">
                            <select id="serach-vendor" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" name="warehouse_id">
                                <option value="">Select Warehouse</option>
                              @if($id != 169)  
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

                <div class="py-4 table-responsive">



                    <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 9px;">
                       <thead>
                    <tr>
                        <th>Si.No</th>
                        <th>User</th>
                        <th>Vendor Name</th>
                        <th>Sales Date</th>
                        <th>Status</th>
                        <th>Sales No</th>
                        <th>Total Qty</th>
                        <th>Grand Total</th>
                        <th>Warehouse</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($saleslist as $all_saleslist)
                @php
                $username = DB::select('SELECT name FROM `users` WHERE id="'.$all_saleslist->emp_id.'"');
                @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$all_saleslist->created_at}} {{$username[0]->name ?? 0}}</td>
                        <td>{{$all_saleslist->d_s_name}}</td>
                        <td>{{$all_saleslist->date}}</td>
                        @if($all_saleslist->delivery==0)
                        <td style="color: red;font-weight: bold">Undelivered</td>
                        @else
                        <td style="color: green;font-weight: bold">Delivered</td>
                        @endif
                        @if($all_saleslist->delivery==0)
                        <td style="color: red;font-weight: bold">{{$all_saleslist->invoice_no}}</td>
                        @else
                        <td style="color: green;font-weight: bold">{{$all_saleslist->invoice_no}}</td>
                        @endif
                        <td>{{$all_saleslist->total_qty}}</td>
                        <td>{{$all_saleslist->grand_total}}</td>
                        <td>{{$all_saleslist->factory_name}}</td>
                    </tr>
                @endforeach
                </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- /.modal -->

    <div class="modal fade" id="delete">
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
    </div>

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
