@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 pt-5">
          	<h4 class="text-center">Monthly Salary And Attendance Report</h4> <hr>
            <div class="form container pt-3">
                    <form class="floating-labels m-t-40" action="{{route('monthly.salary.and.attendance.report.view')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 m-auto">
                                <div class="row">
                                    <div class="col-md-6">
										<label>Select Employee: </label>
                                        <div class="form-group m-b-40">
                                            <div class="input-group">
                                                <select class="form-control select2" name="employee_id">
                                                  	<option value="">== Select Employee ==</option>
                                                  @foreach($employee as $emp)
                                                  	<option value="{{$emp->id}}">{{$emp->emp_name}}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                  	<div class="col-md-6">
										<label>Select Month: </label>
                                        <div class="form-group m-b-40">
                                            <div class="input-group">
                                                <input type="month" name="month" class="form-control float-right" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="class row mt-3">
                            <div class="class col-md-4"></div>
                            <div class="class col-md-4 px-5">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">View Report</button>
                            </div>
                            <div class="class col-md-4">
                            </div>
                        </div>

                    </form>
                </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@push('end_js')

    <script>
        $(document).ready(function() {
            $("#daterangepicker").change(function() {
                var a = document.getElementById("today");
               a.style.display = "none";
            });
        });
    </script>

@endpush
@endsection
