@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">
                  <div class="col-md-12 text-right">
                      	<a href="{{ route('employee.salary.pay') }}" class="btn btn-sm btn-success">E. Salary Pay Form</a>
                      	<a href="{{ route('employee.target.set.index') }}" class="btn btn-sm btn-success">Employee Sales Target</a>
                      	<a href="{{ route('employee.salary.certificate.form') }}" class="btn btn-sm btn-success">E. Salary Certificate</a>
                      	<a href="{{ route('employee.other.amount.pay.list') }}" class="btn btn-sm btn-success">Employee Other Amount</a>
                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>
                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Salary Payment List</h5>
                        <hr>
                    </div>
                    <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Employee Name</th>
                                <th>Month</th>
                                <th>Bank/Warehouse</th>
                                <th>Payment Date</th>
                                <th>Amount</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                          @foreach($datas as $data)

                          @php
                         	$empname = DB::table('employees')->where('id',$data->emp_id)->value('emp_name');
                          @endphp

                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $empname }}</td>

                          <td>{{date('F-Y', strtotime($data->month))}}</td>
                             <td>{{ $data->bank_warehouse_name }}</td>
                            <td>{{ $data->date }}</td>
                            <td>{{ number_format($data->payment_amount,2) }}</td>
                            <td>
                              <a href="{{URL::to('/employee/salary/pay/view/paysleep/'.$data->invoice)}}" class="btn btn-xs btn-success"><i class="far fa-eye"></i></a>
                              <a href="" class="btn btn-xs btn-primary"><i class="far fa-edit"></i></a>
                              <a class="btn btn-xs btn-danger " href="" data-toggle="modal" data-target="#delete" data-myid="{{ $data->invoice }}"><i class="far fa-trash-alt"></i> </a>
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
                    <form action="{{route('employee.salary.pay.delete')}}" method="POST">
                        {{ method_field('delete') }}
                        @csrf

                        <div class="modal-body">
                            <p>Are you sure to delete this Payment?</p>

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

                modal.find('.modal-body #minvoice').val(id);
            })
        </script>

    @endpush
@endsection
