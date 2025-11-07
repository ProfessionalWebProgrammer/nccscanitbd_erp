@extends('layouts.sales_dashboard')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid" style="background:#ffffff; padding:0px 40px;min-height:85vh">
              <div class="row pt-3">
                  	<div class="col-md-12 text-right">
                      	<a href="{{ route('sales.return.create') }}" class=" btn btn-sm btn-success mr-2">Return Entry</a>

                    </div>
                </div>

                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Return List</h5>
                </div>
                <div class="py-4">
                    <table id="example3" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>User</th>
                                <th>Vendor</th>
                                <th>Wirehouse</th>
                                <th>Return Date</th>
                                <th>Invoice</th>
                                <th>Total Qntty</th>
                                <th>Grand Total</th>
                                <th>Updated By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                            @foreach ($returnslist as $all_returnslist)
                                @php
                                    $username = DB::select('SELECT name FROM `users` WHERE id="' . $all_returnslist->emp_id . '"');
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $all_returnslist->created_at }} {{ $username[0]->name ?? 0 }}</td>
                                    <td>{{ $all_returnslist->d_s_name }}</td>
                                    <td>{{ $all_returnslist->factory_name }}</td>
                                    <td>{{ $all_returnslist->date }}</td>
                                    <td style="color: rgb(17, 158, 17);font-weight: bold">{{ $all_returnslist->invoice_no }}</td>
                                    <td>{{ $all_returnslist->total_qty }}</td>
                                    <td>{{ number_format($all_returnslist->grand_total,2) }}</td>
                                    <td>{{ $all_returnslist->up_at }} {{ $all_returnslist->updated_by_name }} </td>

                                    <td class="text-center align-middle" style="width:110px;">
                                      {{-- <a class="btn btn-xs btn-primary salesedit"                                                                                                                                                                                                                                                                 color: white;"
                                            href="{{ route('fg.sales.return.edit', $all_returnslist->invoice_no) }}"
                                            data-toggle="tooltip" data-placement="top" title="Edit Sales Return"><i
                                                class="fas fa-edit"></i></a> --}}

                                      <a class="btn btn-xs salesedit"
                                            style="background-color: mediumaquamarine;                                                                                                                                                                                                                                                                    color: white;"
                                            href="{{ route('sales.return.edit', $all_returnslist->invoice_no) }}"
                                            data-toggle="tooltip" data-placement="top" title="CheckOut Invoice"><i
                                                class="fas fa-spinner"></i></a> 
                                           <a class="btn btn-xs btn-primary " href="{{URL::to('/sales/return/view/'.$all_returnslist->invoice_no)}}" data-toggle="tooltip"
                                            data-placement="top" title="View Return Invoice"><i class="far fa-eye"></i> </a>

                                            <a class="btn btn-xs btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete"
                                            data-myid="{{ $all_returnslist->invoice_no }}"><i class="far fa-trash-alt"></i>
                                        </a>
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
                <form action="{{ route('sales.return.delete') }}" method="POST">
                    {{ method_field('delete') }}
                    @csrf

                    <div class="modal-body">
                        <p>Are you sure to delete this?</p>

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
