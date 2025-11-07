@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 pt-5">
            <div class="form container ">
                    <form class="floating-labels pt-4" action="{{route('employee.leave.of.absent.store')}}" method="POST">
                        @csrf
                        <div class="row">

                           <div class="col-md-12">
                                <h3 class="text-center mb-4"> Leave Of Absent Form </h3> <hr>
                            </div>
                            <div class="col-md-6 m-auto">
                                <label>Employee Name: </label>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                      	<select class="form-control select2" name="employee_id">
                                          <option>Select Employee</option>
                                          @foreach($employee as $item)
                                          	<option value="{{$item->id}}">{{$item->emp_name}}</option>
                                          @endforeach
                                      	</select>
                                    </div>
                                </div>
                            </div>
                          	<div class="col-md-6 m-auto">
                                <label>Select Date: </label>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                      	<input type="text" name="date"
                                            class="form-control float-right" id="daterangepicker" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 m-auto">
                                <label>Leave Type: </label>
                                <div class="form-group m-b-40">
                                    <div class="input-group">
                                      	<select class="form-control select2" name="employee_leave_policy_id">
                                          <option>Select Leave type</option>
                                          @foreach($employeeLeavePolicySystems as $item)
                                          	<option value="{{$item->id}}">{{$item->leave_category_name}}</option>
                                          @endforeach
                                      	</select>
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-12 m-auto">
                                    <label>Description: </label>
                                    <div class="input-group">
                                      	<textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                          		<div class="col-md-6 mt-3">
                                	<label>If Exceed Fine Amount: </label>
                                    <div class="input-group">
                                      	<input type="text" name="fine_amount" class="form-control float-right">
                                    </div>
                                </div>
                          		<div class="col-md-6 mt-3">
                                	<label>Fine Per: </label>
                                  <div class="input-group">
                                   	<input type="text" name="per_day" value="1" class="form-control float-right">
                                    <div class="input-group-append">
                                      <span class="input-group-text">Day</span>
                                    </div>
                                  </div>
                                    <div class="input-group">

                                    </div>
                                </div>
                           	</div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-3 pb-5">
                                      <button class="btn btn-sm btn-primary px-5" type="submit">Submit</button>
                                </div>
                              </div>
                    </form>
                </div>
        </div>
        <!-- /.container-fluid -->
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
