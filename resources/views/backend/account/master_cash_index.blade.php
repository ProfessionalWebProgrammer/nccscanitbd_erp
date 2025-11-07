@extends('layouts.account_dashboard')



@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  accountscontent">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
              <div class="text-right">
              <li class="nav-item d-none pt-2 d-sm-inline-block">
                <a href="{{ URL('/master/cash/create') }}" class=" btn btn-success mr-2">Create Master Cash</a>
            </li>
                </div>

                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Cash List</h5>
                        <hr>
                    </div>

                    <table id="example3" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SI. No</th>
                                 <th>Cash Name</th>
                                <th>Opening Balance</th>
                                <th>Address</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                            @endphp
                            @foreach($cashs as $data)
                                @php
                                    $sl++;
                                @endphp
                                <tr>
                                    <td class="align-middle">{{ $sl }}</td>
                                    <td>{{$data->wirehouse_name}}</td>
                                    <td>{{$data->wirehouse_opb}}</td>
                                    <td>{{$data->wirehouse_address}}</td>

                                    <td class="text-center align-middle">
                                        <a class="btn btn-xs text-light accountsedit" style="background-color: #66BB6A" href="{{route('master.cash.edit',$data->wirehouse_id)}}"
                                            data-toggle="tooltip" data-placement="top" title="Edit Master Cash"><i
                                                class="fas fa-edit"></i> </a>
                                      	<a class="btn btn-xs btn-danger accountsdelete" href="" data-toggle="modal" data-target="#delete" data-myid="{{ $data->wirehouse_id }}"><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
      <!-- modal -->
    <div class="modal fade" id="delete">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('master.cash.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Master Cash?</p>

                            <input type="hidden" id="mid" name="id">
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
    @push('end_js')

        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })


            $('#delete').on('show.bs.modal', function(event) {
                console.log('hello test');
                var button = $(event.relatedTarget)
                var id = button.data('myid')
                var modal = $(this)
                modal.find('.modal-body #mid').val(id);
            })
        </script>

    @endpush
@endsection
