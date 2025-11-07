@extends('layouts.sales_dashboard')

@push('addcss')

@endpush

@section('header_menu')
 <div class="mt-2">
<li class="nav-item d-none d-sm-inline-block">
        <a href="{{ URL('/sales/delete/log') }}" class=" btn btn-xs btn-success mr-2">Delete Log</a>
	</li>
    
</div>
@endsection


@section('content')
<style>
  input.form-control{
    border-radius: 0px!important;
  }
</style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background: #f5f5f5; padding: 0px 40px;">
                   
                <div class="text-center pt-3">

                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Sales List</h5>
                </div>
                <div class="py-4 table-responsive">

                    <form action="{{ route('sales.index') }}" method="get">
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
                                    <option value="">Select Warehouse</option>
                                    @foreach ($factoryes as $w)
                                        <option style="color: #FF0000; font-weight:bold" value="{{ $w->id }}"
                                            {{ $warehouse_id == $w->id ? 'selected' : null }}>{{ $w->factory_name }}
                                        </option>
                                    @endforeach
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

                    <table id="exampleWithoutPag" class="table table-bordered table-striped table-fixed" style="font-size: 10px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>User</th>
                                <th>Vendor</th>
                                <th>Wirehouse</th>
                                <th width="8%">Sales Date</th>
                                <th>Invoice</th>
                                <th>Total Qntty</th>
                                <th>Grand Total</th>
                                <th>Updated By</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody >
                        @php
                            $startSerial = ($saleslist->currentPage() - 1) * $saleslist->perPage() + 1;
                        @endphp
                            @foreach ($saleslist as $all_saleslist)
                                @php
                                    $username = DB::select('SELECT name FROM `users` WHERE id="' . $all_saleslist->user_id . '"');
                                @endphp
                                <tr>
                                    <td>{{ $startSerial++ }}</td>
                                    <td>{{ date("d-m-Y h:i a", strtotime($all_saleslist->created_at)) }} ({{ $username[0]->name ?? '' }})</td>
                                    <td>{{ $all_saleslist->d_s_name }}</td>
                                    <td>{{ $all_saleslist->factory_name }}</td>
                                    <td>{{ $all_saleslist->date }}</td>
                                    @if ($all_saleslist->delivery == 0)
                                        <td style="color: red;font-weight: bold;">{{ $all_saleslist->invoice_no }}</td>
                                    @else
                                        <td style="color: green;font-weight: bold;">{{ $all_saleslist->invoice_no }} - ({{$all_saleslist->counter}})</td>
                                    @endif
                                    <td>{{ $all_saleslist->total_qty }}</td>

                                    @if ($all_saleslist->payment_status == 0)
                                        <td style="color: red;font-weight: bold">{{ number_format($all_saleslist->grand_total,2) }}</td>
                                    @else
                                        <td style="color: green;font-weight: bold">{{number_format($all_saleslist->grand_total,2) }}</td>
                                    @endif


                                    <td>
                                        @if ($all_saleslist->updated_by_name)
                                            {{ $all_saleslist->updated_at }} ({{ $all_saleslist->updated_by_name }})
                                        @endif
                                    </td>

                                    <td class="text-center align-middle">
                                        <a class="btn btn-xs salesedit"
                                            style="background-color: mediumaquamarine;                                                                                                                                                                                                                                                                    color: white;"
                                            href="{{ route('sales.checkout.index', $all_saleslist->invoice_no) }}"
                                            data-toggle="tooltip" data-placement="top" title="CheckOut Invoice"><i
                                                class="fas fa-spinner"></i></a>
                                        <a class="btn btn-xs btn-secondary salesedit" href="{{ route('sales.partial.return', $all_saleslist->invoice_no)}}" data-toggle="tooltip"
                                            data-placement="top" title="Return"><i class="fas fa-undo-alt"></i> </a>
                                        <a class="btn btn-xs btn-primary "
                                            href="{{ route('sales.invoice.view', $all_saleslist->invoice_no) }}"
                                            data-toggle="tooltip" data-placement="top" title="View Invoice"><i
                                                class="far fa-eye"></i> </a>

                                        <a class="btn btn-xs btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete"
                                            data-myid="{{ $all_saleslist->invoice_no }}"><i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                      <div>
                           {{$saleslist->links()}}
                       </div>
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
            //console.log('hello test');
            var button = $(event.relatedTarget)
            var id = button.data('myid')
			var WaireHouse = button.data('WaireHouse')
            var modal = $(this)

            modal.find('.modal-body #minvoice').val(id);
        })
    </script>

@endpush
