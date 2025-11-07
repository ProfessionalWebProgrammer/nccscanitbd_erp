@extends('layouts.hrPayroll_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">


        <!-- Main content -->
        <div class="content px-4">
            <div class="form container  ">
              <div class="row">


                  <div class="col-md-12">
                    <form class="floating-labels pt-5" action="{{route('emp.final.settlement.report')}}" method="POST">
                        @csrf
                        <div class="row">
                          <div class="offset-md-4 col-md-4" >
                             <h6>Select Employee</h6>
                             <select class="form-control selectpicker" data-show-subtext="true"
                             data-live-search="true" data-actions-box="true" multiple name="employee[]" required>
                                @foreach($employees as $val)
                                <option value="{{$val->id}}">{{$val->emp_name}}</option>
                                @endforeach
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

        /*  $('#daterangepicker2').daterangepicker({
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
*/

            $("#selectyear").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });
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
*/
           $("#slectmonth").change(function() {
              var b = document.getElementById("thisYear");
              b.style.display = "none";
              });

           $("#yearId").change(function() {
              var a = document.getElementById("thisMonth");
              a.style.display = "none";
              });


        });
    </script>


@endpush
