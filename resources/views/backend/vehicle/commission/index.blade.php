@extends('layouts.settings_dashboard')

@section('header_menu')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('commission.create') }}" class=" btn btn-success mr-2">Commission Entry</a>
    </li>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper salescontent">


        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
		                  <p>Head office, Rajshahi, Bangladesh</p>
                    <h5>Commission  List</h5>
                </div>
                <div class="py-4">
                    <table id="example1" class="table table-bordered table-striped table-fixed" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center table-header-fixt-top">
                                <th>Sl</th>
                                <th>Commission Rate</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 18px;">

                           @foreach ($datas as $data)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->commission }} </td>
                                  @if($data->status = 1)
                                  <td>
                                    <span class="btn btn-success p-2">Activated</span>

                                  </td>
                                  @else
                                  <td>
                                    <span class="btn btn-danger p-2">Inactive</span>
                                  </td>
                                  @endif



                                    <td class="text-center align-middle">
                                    <a class="btn btn-sm mb-1 salesedit"
                                            style="background-color: mediumaquamarine;                                                                                                                                                                                                                                                                    color: white;"
                                            href="{{ route('commission.edit', $data->id) }}"
                                            data-toggle="tooltip" data-placement="top" title="Edit Commission"><i
                                                class="fas fa-spinner"></i></a>

                                            <a class="btn btn-sm btn-danger salesdelete" href="" data-toggle="modal" data-target="#delete"
                                            data-myid="{{ $data->id }}"><i class="far fa-trash-alt"></i>
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
                <form action="{{ route('delete.driver') }}" method="POST">
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
