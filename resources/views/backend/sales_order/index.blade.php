@extends('layouts.sales_dashboard')

@push('addcss')

@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background: #ffffff; padding: 0px 40px; min-height:85vh">
              	<div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<a href="{{route('sales.order.create')}}" class="btn btn-sm btn-success">Order Create</a>
         				<a href="{{ URL('/order/delete/log') }}" class=" btn btn-success btn-sm mr-2">Delete Log</a>
                  </div>
                </div>
                <div class="text-center pt-3" >
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Order List</h5>
                </div>
                <div class="py-4 table-responsive">


                     <form action="{{ route('sales.order.index') }}" method="get">
                        <div class="row pb-4">
                            <div class="col-md-5 input-group rounded">
                                {{-- <div class="input-group-prepend">
                                    <span class="input-group-text" id="">INV</span>
                                </div>
                                <input type="text" name="invoice" value=""
                                    class="form-control float-right" placeholder="Invoice"> --}}

                                <div class="input-group-prepend  pr-2"></div>

                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Date</span>
                                </div>
                                <input type="text" name="date" class="form-control float-right" id="daterangepicker"
                                    value="">

                                <div class="input-group-prepend  pr-2"> </div>


                                {{-- <select class="form-control select2" name="warehouse_id">
                                    <option value="">Select Store</option>
                                    @foreach ($factoryes as $w)
                                        <option style="color: #FF0000; font-weight:bold" value="{{ $w->id }}"
                                            {{ $warehouse_id == $w->id ? 'selected' : null }}>{{ $w->factory_name }}
                                        </option>
                                    @endforeach
                                </select> --}}

                                <div class="input-group-prepend  pr-2"></div>


                               {{-- <select class="form-control select2" name="dealer_id">
                                    <option value="">Select Vendor</option>
                                    @foreach ($dealers as $d)
                                        <option style="color: #FF0000; font-weight:bold" value="{{ $d->id }}"
                                            {{ $dealer_id == $d->id ? 'selected' : null }}>
                                            {{ $d->d_s_name }}</option>
                                    @endforeach
                                </select> --}}

                                <div class="input-group-prepend  pr-2"></div>


                                <div class="input-group-prepend pr-2">
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-search"></i>
                                        Search</button>
                                </div>

                                <div class="input-group-prepend pr-2">
                                    <a href="{{ route('sales.order.index') }}" class="btn btn-sm btn-danger"><i
                                            class="far fa-times-circle"></i>
                                        Clear</a>
                                </div>

                            </div>

                        </div>
                    </form>

                    <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 10px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>User</th>
                                <th>Vendor</th>
                                <th>Wirehouse</th>
                                <th style="width:78px;">Order Date</th>
                                <th>Invoice</th>
                                <th>Total Qntty</th>
                                <th>Grand Total</th>
                                <th>Order Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody >
							@php
                          	$totalAmount = 0;
                          	$totalGarndAmount = 0;
                          	$totalQty = 0;
                          @endphp
                          @php
                            /* $startSerial = ($orderlist->currentPage() - 1) * $orderlist->perPage() + 1; */
                          @endphp
                            @foreach ($orderlist as $key => $all_saleslist)
                                @php
                                if(!empty($all_saleslist->emp_id)){
                                  $id = $all_saleslist->emp_id;
                                  } else {
                                  $id = $all_saleslist->user_id;
                                  }
                          			$totalQty += $all_saleslist->total_qty;
									$totalAmount += $all_saleslist->grand_total;
                          			$totalGarndAmount += $all_saleslist->price;
                                   // $username = DB::select('SELECT name FROM `users` WHERE id="' .  . '"');
                          			 $username = DB::table('users')->where('id', $id)->value('name');
                                @endphp
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    {{--  <td>{{ $startSerial++ }}</td> --}}
                                    <td>{{  date("d-m-Y h:i a", strtotime($all_saleslist->created_at)) }} ({{ $username ?? '' }})</td>
                                    <td>{{ $all_saleslist->d_s_name }}</td>
                                    <td>{{ $all_saleslist->factory_name }}</td>
                                    <td>{{ date("d-m-Y", strtotime($all_saleslist->date)) }}</td>
                                    @if ($all_saleslist->delivery == 0)
                                        <td style="color: red;font-weight: bold">{{ $all_saleslist->invoice_no }}</td>
                                    @else
                                        <td style="color: green;font-weight: bold">{{ $all_saleslist->invoice_no }}</td>
                                    @endif
                                    <td>{{ $all_saleslist->total_qty }}</td>
                                    <td>{{ number_format($all_saleslist->grand_total,2) }}</td>
                                    <td>

                                        @if ($all_saleslist->order_status == 1)
                                         <span style="font-weight: bold; color:blue">Confirmed</span>
                                        @else
                                          <span style="font-weight: bold; color:red">Pending</span>
                                        @endif
                                    </td>

                                    <td class="text-center align-middle">

                                        @if($all_saleslist->order_status == 0)
                                        <a class="btn btn-xs salesedit"
                                            style="background-color: mediumaquamarine;                                                                                                                                                                                                                                                                    color: white;"
                                            href="{{ route('sales.order.confirm.edit', $all_saleslist->invoice_no) }}"
                                            data-toggle="tooltip" data-placement="top" title="CheckOut Order"><i
                                                class="fas fa-spinner"></i></a>
                                        @endif

                                        <a  @if ($all_saleslist->order_status == 0) style="display:none;" @endif class="btn btn-xs btn-primary "
                                            href="{{ route('sales.invoice.view', $all_saleslist->invoice_no) }}"
                                            data-toggle="tooltip" data-placement="top" title="View Order Invoice"><i
                                                class="far fa-eye"></i> </a>
                                      <a  @if ($all_saleslist->order_status == 0) style="display:none;" @endif class="btn btn-xs btn-success salesedit"
                                            href="{{ route('sales.order.edit', $all_saleslist->invoice_no) }}"
                                            data-toggle="tooltip" data-placement="top" title="Edit Order" target="_blank"><i
                                                class="far fa-edit"></i> </a>

                                        <a class="btn btn-xs btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete"
                                            data-myid="{{ $all_saleslist->invoice_no }}"><i class="far fa-trash-alt"></i>
                                        </a>

                                        {{-- @if (Auth::id() == 101 && $all_saleslist->order_status == 0)
                                        <a  class="btn btn-xs btn-warning mt-1 " href="" data-toggle="modal" data-target="#confimrorder"
                                        data-myid="{{ $all_saleslist->invoice_no }}">Confirm Order
                                        </a>
                                        @endif --}}
                                    </td>


                                </tr>
                            @endforeach

                        </tbody>
                      <tfoot>
                      	<tr style="background:#589ca7; ">

                          	<td colspan="6">Total: </td>
                            <td>{{number_format($totalQty,2)}}</td>
                            <td>{{number_format($totalAmount,2)}}</td>
                            <td colspan="2" align="center">{{number_format($totalGarndAmount,2)}}</td>
                          </tr>
                        </tfoot>
                    </table>
                    {{-- <div>
                           {{$orderlist->links()}}
                       </div> --}}
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
                <form action="{{ route('sales.order.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this Order?</p>

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


    <!-- /.modal -->

    <div class="modal fade" id="confimrorder">
        <div class="modal-dialog">
            <div class="modal-content bg-warning">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('sales.order.confirm') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to Confimr this Order?</p>

                        <input type="hidden" id="mid" name="id">
                        <input type="hidden" id="minvoice" name="invoice">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-dark">Confirm</button>
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
        $('#confimrorder').on('show.bs.modal', function(event) {
           // console.log('hello test');
            var button = $(event.relatedTarget)
            var title = button.data('mytitle')
            var id = button.data('myid')

            var modal = $(this)

            modal.find('.modal-body #minvoice').val(id);
        })
    </script>

@endpush
