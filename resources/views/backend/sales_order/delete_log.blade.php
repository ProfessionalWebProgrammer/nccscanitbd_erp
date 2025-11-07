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

                    </div>
                </div>
                <div class="text-center pt-3" >
                   <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Order Delete Log</h5>
                </div>
                <div class="py-4 table-responsive">

                    {{-- <form action="{{ route('sales.index') }}" method="get">
                        <div class="row pb-4">
                            <div class="col-md-12 input-group rounded">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">INV</span>
                                </div>
                                <input type="text" name="invoice" value="{{ $invoice }}"
                                    class="form-control float-right" placeholder="Invoice">

                                <div class="input-group-prepend  pr-2"></div>

                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Date</span>
                                </div>
                                <input type="text" name="date" class="form-control float-right" id="daterangepicker"
                                    value="{{ $date }}">








                                <div class="input-group-prepend  pr-2"> </div>


                                <select class="form-control select2" name="warehouse_id">
                                    <option value="">Select Store</option>
                                    @foreach ($factoryes as $w)
                                        <option style="color: #FF0000; font-weight:bold" value="{{ $w->id }}"
                                            {{ $warehouse_id == $w->id ? 'selected' : null }}>{{ $w->factory_name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="input-group-prepend  pr-2"></div>


                                <select class="form-control select2" name="dealer_id">
                                    <option value="">Select Vendor</option>
                                    @foreach ($dealers as $d)
                                        <option style="color: #FF0000; font-weight:bold" value="{{ $d->id }}"
                                            {{ $dealer_id == $d->id ? 'selected' : null }}>
                                            {{ $d->d_s_name }}</option>
                                    @endforeach
                                </select>

                                <div class="input-group-prepend  pr-2"></div>


                                <div class="input-group-prepend pr-2">
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-search"></i>
                                        Search</button>
                                </div>

                                <div class="input-group-prepend pr-2">
                                    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-danger"><i
                                            class="far fa-times-circle"></i>
                                        Clear</a>
                                </div>

                            </div>

                        </div>
                    </form> --}}

                    <table id="example1" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>User</th>
                                <th>Vendor</th>
                                <th>Wirehouse</th>
                                <th>Order Date</th>
                                <th>Invoice</th>
                                <th>Total Qntty</th>
                                <th>Grand Total</th>
                                <th>Order Status</th>
                              </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                            @foreach ($orderlist as $all_saleslist)
                                @php
                                    $username = DB::select('SELECT name FROM `users` WHERE id="' . $all_saleslist->user_id . '"');
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $all_saleslist->created_at }} ({{ $username[0]->name ?? '' }})</td>
                                    <td>{{ $all_saleslist->d_s_name }}</td>
                                    <td>{{ $all_saleslist->factory_name }}</td>
                                    <td>{{ $all_saleslist->date }}</td>
                                    @if ($all_saleslist->delivery == 0)
                                        <td style="color: red;font-weight: bold">{{ $all_saleslist->invoice_no }}</td>
                                    @else
                                        <td style="color: green;font-weight: bold">{{ $all_saleslist->invoice_no }}</td>
                                    @endif
                                    <td>{{ $all_saleslist->total_qty }}</td>
                                    <td>{{ $all_saleslist->grand_total }}</td>
                                    <td>
                                        @if ($all_saleslist->order_status == 1)
                                         <span style="font-weight: bold; color:blue">Confirmed</span>
                                        @else
                                          <span style="font-weight: bold; color:red">Pending</span>
                                        @endif
                                    </td>




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
