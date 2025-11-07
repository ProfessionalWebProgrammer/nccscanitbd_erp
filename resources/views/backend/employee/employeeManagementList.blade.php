@extends('layouts.hrPayroll_dashboard')

@section('header_menu')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ URL('/employee/team/create') }}" class=" btn btn-success mr-2">Team Create</a>
    @endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="text-center pt-3">
                  <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                  <p>Head office, Rajshahi, Bangladesh</p>
                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Team  List</h5>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Team Title</th>
                                <th>Team Head</th>
                                <th>Team Member</th>
                                <th>Description</th>

                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 0;
                            @endphp

                            @foreach ($employeeData as $item)
                                @php
                                    $sl++;
                          			$emp_id = explode(',',$item->employee_id);
                          				$numItems = count($emp_id);

                          //dd($emp_id);
                                @endphp
                                <tr>
                                    <td>{{ $sl }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->head }}</td>
                                    <td> @foreach ($emp_id as $key=> $data)
                                      	 @php
                                      		$emp_name = DB::table('employees')->where('id',$data)->value('emp_name');
                                      	@endphp

                                      {{$emp_name}} @if($key != ($numItems-1) ), @endif

                                      	@endforeach
                                  	</td>
                                    <td>{{ $item->description }}</td>

                                    <td class="text-center">

                                        <a class="btn btn-sm btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{ $item->id }}"><i class="far fa-trash-alt"></i> </a>
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
                    <form action="{{route('employee.team.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Employee?</p>

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
@endsection
