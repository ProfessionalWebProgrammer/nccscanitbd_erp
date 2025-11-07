@extends('layouts.hrPayroll_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">


        <!-- Main content -->
        <div class="content px-4">
            <div class="form container  ">
              <div class="row">
                <div id="exTab2" class="container">
                  <ul class="nav nav-tabs mt-4 pt-4">
                  <li class="active">
                  <a  href="#compliance" class="btn btn-sm btn-primary" data-toggle="tab">Compliance </a>
                  </li>
                  <li>
                    <a href="#nonCompliance" class="btn btn-sm btn-success" data-toggle="tab">Non Compliance</a>
                  </li>
              </ul>
              <div class="tab-content ">
        			  <div class="tab-pane active" id="compliance">

                  <div class="col-md-12">
                    <form class="floating-labels pt-5" action="{{route('hrpayroll.employee.attendance.report')}}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="1">
                        <div class="row">
                          <div class="col-md-3" >
                             <h6>Select Employee</h6>

                             <select class="form-control selectpicker" data-show-subtext="true"
                             data-live-search="true" data-actions-box="true" multiple name="employee[]">
                                @foreach($employees as $val)
                                <option value="{{$val->id}}">{{$val->emp_name}}</option>
                                @endforeach
                            </select>
                             </div>
                            <div class="col-md-3"  >
                              <div id="thisDate">
                                <h6>Select Date: <span id="today" style="color: lime; display:inline-block">Today</span> </h6>
                                <div class="form-group m-b-40">
                                <div class="input-group">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text">
                                              <i class="far fa-calendar-alt"></i>
                                          </span>
                                      </div>
                                      <input type="text" name="date" class="form-control float-right" id="daterangepicker" style="border-radius: 0px 12px 12px 0px!important;">

                                  </div>
                                  </div>
                            </div>
                            </div>
                           <div class="col-md-3 ">
                             <div id="thisMonth">

                                <h6>Select Month: </h6>
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
                            </div>
                            <div class="col-md-3" >
                              <div id="thisYear">
                               <h6>Select Year</h6>
                               <div class="form-group m-b-40">
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
                                 </div>
                               </div>
                               </div>
                               <div class="col-md-3" >
                                  <h6>Select Department</h6>

                                  <select class="form-control selectpicker" data-show-subtext="true"
                                  data-live-search="true" data-actions-box="true"  multiple name="department[]">
                                     @foreach($departments as $val)
                                     <option value="{{$val->id}}">{{$val->department_title}}</option>
                                     @endforeach
                                 </select>
                                  </div>
                               <div class="col-md-3">
                                 <h6>Select This One</h6>
                                 <div class="form-check">
                                  <input class="form-check-input" style="width: 25px; height: 25px;" type="radio" name="report" id="pr" value="1">
                                  <label class="form-check-label ml-3 mt-1" for="pr">
                                    Present Report
                                  </label>
                                </div>
                               </div>
                               <div class="col-md-3">
                                 <h6>Select This One</h6>
                                 <div class="form-check">
                                  <input class="form-check-input" style="width: 25px; height: 25px;" type="radio" name="report" id="ar" value="2">
                                  <label class="form-check-label ml-3 mt-1" for="ar">
                                    Absent Report
                                  </label>
                                </div>
                               </div>
                               <div class="col-md-3">
                                 <h6>Select This One</h6>
                                 <div class="form-check">
                                  <input class="form-check-input" style="width: 25px; height: 25px;" type="radio" name="report" id="lr" value="3">
                                  <label class="form-check-label ml-3 mt-1" for="lr">
                                    Late Report
                                  </label>
                                </div>
                               </div>
                        </div>
                        <div class="row mt-3 pb-5">
                            <div class="col-md-2 m-auto mt-1">

                                    <button type="submit" class="btn btn-sm btn-primary w-100 "> View Report </button>

                            </div>

                        </div>
                    </form>
                  </div>

                </div>
                <div class="tab-pane" id="nonCompliance">

                  <div class="col-md-12">
                    <form class="floating-labels pt-5" action="{{route('hrpayroll.employee.attendance.report')}}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="2">
                        <div class="row">
                          <div class="col-md-3" >
                             <h6>Select Employee</h6>

                             <select class="form-control selectpicker" data-show-subtext="true"
                             data-live-search="true" data-actions-box="true" multiple name="employee[]">
                                @foreach($employees as $val)
                                <option value="{{$val->id}}">{{$val->emp_name}}</option>
                                @endforeach
                            </select>
                             </div>
                            <div class="col-md-3"  >
                              <div id="thisDate2">
                                <h6>Select Date: <span id="today2" style="color: lime; display:inline-block">Today</span> </h6>
                                <div class="form-group m-b-40">
                                <div class="input-group">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text">
                                              <i class="far fa-calendar-alt"></i>
                                          </span>
                                      </div>
                                      <input type="text" name="date" class="form-control float-right" id="daterangepicker2" style="border-radius: 0px 12px 12px 0px!important;">

                                  </div>
                                  </div>
                            </div>
                            </div>
                           <div class="col-md-3 ">
                             <div id="thisMonth2">

                                <h6>Select Month: </h6>
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
                            </div>
                            <div class="col-md-3" >
                              <div id="thisYear2">
                               <h6>Select Year</h6>
                               <div class="form-group m-b-40">
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
                                 </div>
                               </div>
                               </div>
                               <div class="col-md-3" >
                                  <h6>Select Department</h6>

                                  <select class="form-control selectpicker" data-show-subtext="true"
                                  data-live-search="true" data-actions-box="true"  multiple name="department[]">
                                     @foreach($departments as $val)
                                     <option value="{{$val->id}}">{{$val->department_title}}</option>
                                     @endforeach
                                 </select>
                                  </div>
                               <div class="col-md-3">
                                 <h6>Select This One</h6>
                                 <div class="form-check">
                                  <input class="form-check-input" style="width: 25px; height: 25px;" type="radio" name="report" id="pr" value="1">
                                  <label class="form-check-label ml-3 mt-1" for="pr">
                                    Present Report
                                  </label>
                                </div>
                               </div>
                               <div class="col-md-3">
                                 <h6>Select This One</h6>
                                 <div class="form-check">
                                  <input class="form-check-input" style="width: 25px; height: 25px;" type="radio" name="report" id="ar" value="2">
                                  <label class="form-check-label ml-3 mt-1" for="ar">
                                    Absent Report
                                  </label>
                                </div>
                               </div>
                               <div class="col-md-3">
                                 <h6>Select This One</h6>
                                 <div class="form-check">
                                  <input class="form-check-input" style="width: 25px; height: 25px;" type="radio" name="report" id="lr" value="3">
                                  <label class="form-check-label ml-3 mt-1" for="lr">
                                    Late Report
                                  </label>
                                </div>
                               </div>
                        </div>
                        <div class="row mt-3 pb-5">
                            <div class="col-md-2 m-auto mt-1">

                                    <button type="submit" class="btn btn-sm btn-success w-100 "> View Report </button>

                            </div>

                        </div>
                    </form>
                  </div>

              </div>
              </div>

                </div>
                <!-- Tab end -->

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

          $('#daterangepicker2').daterangepicker({
           timePicker: false,

           locale: {
               format: 'Y-MM-DD'
           }
       });



           $("#daterangepicker").change(function() {
               var a = document.getElementById("today");
              a.style.display = "none";
           });

           $("#daterangepicker2").change(function() {
               var a = document.getElementById("today2");
              a.style.display = "none";
           });


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

			 $("#daterangepicker2").change(function() {
              var a = document.getElementById("thisMonth2");
              var b = document.getElementById("thisYear2");
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
