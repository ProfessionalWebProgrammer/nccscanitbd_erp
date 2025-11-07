@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class=" row pt-3">
                  <div class="col-md-12 text-right">
                      	<a href="{{route('employee.qualification.list')}}" class="btn btn-sm btn-success">Employee Qualification</a>
                      {{-- 	<a href="{{route('employee.document.create')}}" class="btn btn-sm btn-success">Employee Document</a> --}}
                      	<a href="{{route('employee.idCard.create')}}" class="btn btn-sm btn-success">Employee ID Card Create</a>
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee ID Cared List</h5>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Card No</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Designation</th>
                                <th>Blood Group</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($empIdCards as $val)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>ID-{{$val->employee->id}}</td>
                                    <td>{{$val->employee->emp_name}}</td>
                                    <td class="text-center">{{$val->phone}}</td>
                                    <td class="text-center">{{$val->designation->designation_title}}</td>
                                    <td class="text-center">{{$val->bloodGroup}}</td>
                                    <td class="text-center">
                                        <a href="#"
                                            class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a>
                                        <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid="{{$val->id}}"><i class="far fa-trash-alt"></i> </a>
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
                    <form action="{{route('employee.idCard.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this?</p>
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
              //  console.log('hello test');
                var button = $(event.relatedTarget)
                var id = button.data('myid')
                var modal = $(this)
                modal.find('.modal-body #mid').val(id);
            })
        </script>

    @endpush
@endsection
