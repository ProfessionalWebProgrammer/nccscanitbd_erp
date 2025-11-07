@extends('layouts.sales_dashboard')

@push('addcss')

@endpush

@section('header_menu')

@endsection


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="">


        <!-- Main content -->
        <div class="content px-4 ">

            <div class="container-fluid" style="background: #f5f5f5; padding: 0px 40px;">
                 
				<div class="container mt-2">
              	<div class="col-md-12">
                  <nav class="mt-1">
                	<li class="nav-item d-none d-sm-inline-block">
                        <a href="{{ url('today/sales-delivery/list') }}" class=" btn btn-success btn-sm mr-2">Delivery Summary Report</a>
                   </li>
                               <!--<li class="nav-item d-none d-sm-inline-block">-->
                               <!--       <a href="{{ route('sales.delivery.summary.list') }}" class=" btn btn-success btn-sm mr-2">Delivery Summary Details Report</a>-->
                               <!--</li>-->
                    			<li class="nav-item d-none d-sm-inline-block">
                                      <a href="{{ route('sales.delivery.confirmed.list') }}" class=" btn btn-success btn-sm mr-2">Delivery Confirmed Report</a>
                               </li>
                    			<li class="nav-item d-none d-sm-inline-block">
                                      <a href="{{ route('salesUnDdeliverySummaryList') }}" class=" btn btn-success btn-sm mr-2">UnDelivery Report</a>
                               </li>
                </nav>
                  </div>
              	</div>
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Sales Delivery Pending List</h5>
                </div>
                <div class="py-4 table-responsive">

                    <form action="{{ route('delivery.status') }}" method="get">
                        <div class="row pb-4">
                            <div class="col-md-12 input-group mb-3 s">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">INV</span>
                                </div>
                                <input type="text" name="invoice" value="{{ $invoice }}"
                                    class="form-control float-right" placeholder="Invoice" style="border-radius: 0px !important;">

                                <div class="input-group-prepend  pr-2"></div>

                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Date</span>
                                </div>
                                <input type="text" name="date" class="form-control float-right" id="daterangepicker"
                                    value="{{ $date }}" style="border-radius: 0px !important;">


                                <div class="input-group-prepend  pr-2"> </div>


                                <select class="form-control select2" name="warehouse_id">
                                    	<option value="">Select Store</option>
                                   		@if($authid != 169)
                                        @foreach ($factoryes as $w)
                                            <option style="color: #FF0000; font-weight:bold" value="{{ $w->id }}"
                                                {{ $warehouse_id == $w->id ? 'selected' : null }}>{{ $w->factory_name }}
                                            </option>
                                        @endforeach
                                   		@else 
                                        <option style="color: #FF0000; font-weight:bold" value="36" >Mymensingh Depo </option>
                                        @endif 
                                </select>

                                <div class="input-group-prepend  pr-2"></div>


                                <select class="form-control select2" name="dealer_id">
                                    <option value="">Select Dealer</option>
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
                                {{-- <div class="input-group-prepend">
                                            <button class="btn btn-sm btn-warning"><i class="fas fa-print"></i>
                                                Print</button>
                                            </div> --}}
                            </div>

                        </div>
                    </form>

                    <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>User</th>
                                <th>Dealer</th>
                                <th>Wirehouse</th>
                                <th width="10%">Sales Date</th>
                                <th>Invoice</th>
                                <th>Total Qntty</th>
                                <th>Grand Total</th>
                                <th>Updated By</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                            @foreach ($saleslist as $all_saleslist)
                                @php
                          			$remainQtys = 0; 
                                    $username = DB::select('SELECT name FROM `users` WHERE id="' . $all_saleslist->user_id . '"');
                          			$deliveryQtys = DB::table('chalans')->where('invoice_no', $all_saleslist->invoice_no)->sum('delivery_qty');
                          			$remainQtys = $all_saleslist->total_qty - $deliveryQtys;
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
                                    <td>{{ $all_saleslist->total_qty }} - <span style="color:red;"> {{number_format($remainQtys,0)}}</span></td>
                                    <td>{{ $all_saleslist->grand_total }}</td>
                                    <td>
                                        @if ($all_saleslist->updated_by_name)
                                            {{ $all_saleslist->updated_at }} ({{ $all_saleslist->updated_by_name }})
                                        @endif
                                    </td>

                                    <td class="text-center align-middle">

                                      <a class="btn btn-xs btn-info salesedit" href="{{route('chalan.status', $all_saleslist->invoice_no) }}" data-toggle="tooltip"
                                            data-placement="top" title="Chalan Edit" target="blank"><i class="fas fa-edit"></i> </a>
                                   
                                      @if($all_saleslist->chalan_status == 1)
                                     <a href="{{route('sales.chalan.index',$all_saleslist->invoice_no)}}"  class="btn btn-xs btn-success " data-toggle="tooltip" data-placement="top" title="View Chalan"><i class="far fa-eye"></i> </a>
                                       <a href="{{route('delivery.status.update',$all_saleslist->id)}}" class="btn btn-warning btn-xs " data-toggle="tooltip" data-placement="top"  title="Delivery Confirm"><i class="fas fa-check-circle"></i> </a>
                                      @endif 
                                      <a href="{{ route('sales.invoice.view', $all_saleslist->invoice_no) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top"  title="Invoice View"> <i class="fal fa-eye"></i> </a>
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
