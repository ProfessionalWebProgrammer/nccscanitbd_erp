@extends('layouts.hrPayroll_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">


        <!-- Main content -->
        <div class="content px-4">
            <div class="form container  ">
              <div class="row">


                  <div class="col-md-12">
                    <form class="floating-labels pt-5" action="{{route('emp.salary.sheet.report')}}" method="POST">
                        @csrf
                        <div class="row">
                          
                          <div class="col-md-4">
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
                          <div class="col-md-4" >
                             <h6>Select Employee</h6>
                             <select class="form-control selectpicker" data-show-subtext="true"
                             data-live-search="true" data-actions-box="true" multiple name="employee[]">
                                @foreach($employees as $val)
                                <option value="{{$val->id}}">{{$val->emp_name}}</option>
                                @endforeach
                            </select>
                             </div>

                            <div class="col-md-4" >
                                <h6>Select Type</h6>
                                <select class="form-control select2" data-show-subtext="true"
                                data-live-search="true" data-actions-box="true"  name="type" required>
                                   <option value="">Select Type</option>
                                   <option value="1">Complaince</option>
                                   <option value="2">Non Complaince</option>
                               </select>
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
          $("#daterangepicker").change(function() {
              var a = document.getElementById("today");
             a.style.display = "none";
          });

        /*  $('#daterangepicker2').daterangepicker({
           timePicker: false,

           locale: {
               format: 'Y-MM-DD'
           }
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
            */
/*
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
              var b = document.getElementById("thisYear");
              b.style.display = "none";
              });

           $("#yearId").change(function() {
              var a = document.getElementById("thisMonth");
              a.style.display = "none";
              });

*/
        });
    </script>


@endpush
