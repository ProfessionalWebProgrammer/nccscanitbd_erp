@extends('layouts.settings_dashboard')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Vehicle  List</h5>
                </div>
                <div class="py-4">
                    <table id="example1" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Vehicle Number</th>
                                <th>Oil Opening</th>
                                <th>Description</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                            @foreach ($vehicles as $date)
                               @php
                          			$category = DB::table('vehicle_categories')->where('id',$date->category_id)->value('name');
                          		@endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $date->vehicle_title }} </td>
                                    <td>{{ $category}}</td>
                                    <td>{{ $date->vehicle_number }}</td>
                                    <td>{{ $date->oil_opening }}</td>
                                    <td>{{ $date->description }} Liter</td>


                                    <td class="text-center align-middle">
                                   {{--   <a class="btn btn-sm mb-1 salesedit"
                                            style="background-color: mediumaquamarine;                                                                                                                                                                                                                                                                    color: white;"
                                            href="{{ route('sales.return.edit', $all_returnslist->invoice_no) }}"
                                            data-toggle="tooltip" data-placement="top" title="CheckOut Invoice"><i
                                                class="fas fa-spinner"></i></a>
                                           <a class="btn btn-sm btn-primary " href="{{URL::to('/sales/return/view/'.$all_returnslist->invoice_no)}}" data-toggle="tooltip"
                                            data-placement="top" title="View Return Invoice"><i class="far fa-eye"></i> </a>  --}}

                                            <a class="btn btn-sm btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete"
                                            data-myid="{{ $date->id }}"><i class="far fa-trash-alt"></i>
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
                <form action="{{ route('delete.vehicle') }}" method="POST">
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

            modal.find('.modal-body #mid').val(id);
        })
    </script>

@endpush
