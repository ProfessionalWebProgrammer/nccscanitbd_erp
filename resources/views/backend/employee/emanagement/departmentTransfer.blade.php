@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class=" row pt-3">
                  <div class="col-md-12 text-right">
                      	<a href="{{route('employee.brach.transfer.list')}}" class="btn btn-sm btn-success">Branch Transfer </a>
                      	<a href="{{route('employee.department.transfer.create')}}" class="btn btn-sm btn-success">Department Transfer Create</a>

                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Department Transfer List</h5>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Date</th>
                                <th>Employee Name</th>
                                <th>From Department</th>
                                <th>To Department</th>
                                <th>Status</th>
                                <th width="13%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                                <tr>
                                    <td>1</td>
                                    <td>21-09-2023</td>
                                    <td>Mr Ali Ahmed</td>
                                    <td>HR Department</td>
                                    <td>Account Department</td>

                                    <td align="center"><span class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Active"><i class="fa fa-check-circle" aria-hidden="true"></i></span> {{--<span class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="PR Approved Reject"> <i class="fa fa-times" aria-hidden="true"></i> </span> --}} </td>
                                    <td class="text-center">
                                        <a href="#"
                                            class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a>

                                        <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid=""><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>21-09-2023</td>
                                    <td>Mr Mahbub Alom</td>
                                    <td>Sales Department</td>
                                    <td>Marketing Department</td>

                                    <td align="center"><span class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Active"><i class="fa fa-check-circle" aria-hidden="true"></i></span> {{--<span class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="PR Approved Reject"> <i class="fa fa-times" aria-hidden="true"></i> </span> --}} </td>
                                    <td class="text-center">
                                        <a href="#"
                                            class="btn btn-xs btn-info my-1" data-toggle="tooltip" data-placement="top" title="Employee Edit"><i class="far fa-edit "></i></a>

                                        <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete"
                                                        data-myid=""><i class="far fa-trash-alt"></i> </a>
                                    </td>
                                </tr>
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
                    <form action="{{route('employee.delete')}}" method="POST">
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
