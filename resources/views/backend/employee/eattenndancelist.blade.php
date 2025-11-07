@extends('layouts.hrPayroll_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">


        <!-- Main content -->
        <div class="content px-4">
            <div class="form container  ">
              <div class="row">
                <div class="col-md-10">
                  <form class="floating-labels pt-5" action="{{route('employee.attendance.view')}}" method="POST">
                      @csrf
                      <div class="row">
                          <div class="col-md-4 m-auto" id="thisDate" >
                              <label>Select Date: </label>

                              <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="date" class="form-control float-right" id="daterangepicker" style="border-radius: 0px 12px 12px 0px!important;">

                                </div>
                          </div>
                        {{--  <div class="col-md-4 " id="thisMonth">
                              <h5>Select Month: </h5>
                              <div class="form-group m-b-40">
                                  <div class="input-group">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text">
                                              <i class="far fa-calendar-alt"></i>
                                          </span>
                                      </div>
                                      <input type="month" name="monthYear" class="form-control float-right" id="slectmonth"  placeholder="Select Month" style="border-radius: 0px 12px 12px 0px!important;">
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-4" id="thisYear">
                             <h4>Select Year</h4>
                             <div class="input-group">
                             <div class="input-group-prepend">
                                 <span class="input-group-text">
                                     <i class="far fa-calendar-alt"></i>
                                 </span>
                             </div>
                             <select class="form-control" name="year" id="yearId">
                                   <option value="">Select Year </option>
                                   @for($i = 2023; $i <= 2050 ; $i++)
                                   <option value="{{$i}}">{{$i}}</option>
                                   @endfor
                                 </select>
                               </div>
                             </div> --}}
                      </div>
                      <div class="row mt-3 pb-5">
                          <div class="col-md-12 text-center mt-1">

                                  <button type="submit" class="btn custom-btn-sbms-submit"> View List </button>

                          </div>

                      </div>
                  </form>
                </div>
                <div class="col-md-2 text-right mt-2">
                  <a href="{{ route('employee.attendance.form') }}" class="btn btn-sm btn-success">Employee Attendance</a>
                </div>
              </div>

                </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('end_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {

            $("#selectyear").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });

			 $("#daterangepicker").change(function() {
              var a = document.getElementById("thisMonth");
              var b = document.getElementById("thisYear");
              a.style.display = "none";
              b.style.display = "none";
              });

           $("#slectmonth").change(function() {
              var a = document.getElementById("thisDate");
              var b = document.getElementById("thisYear");
              a.style.display = "none";
              b.style.display = "none";
              });

           $("#yearId").change(function() {
              var a = document.getElementById("thisMonth");
              var b = document.getElementById("thisDate");
              a.style.display = "none";
              b.style.display = "none";
              });


        });
    </script>


@endpush
