@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ route('employee.maternityLeave.report.view') }}" method="POST">
                @csrf
                <div class="container">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase"> Employee Production Report</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4 " >
                      <div class="col-md-3"></div>
                      <div class="col-md-3">
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
                       <div class="col-md-3" >
                            <div class="form-group ">
                                <label class="col-form-label"> Employee :</label>
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                    data-live-search="true" data-actions-box="true" multiple name="emp_id[]">
                                       @foreach($employees as $val)
                                       <option value="{{$val->id}}">{{$val->emp_name}}</option>
                                       @endforeach
                                   </select>

                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                <div class="row pb-5">
                    <div class="col-md-2 m-auto  mt-3">
                            <button type="submit" class="btn custom-btn-sbms-submit w-100 "> View Report </button>
                    </div>
                </div>
                </div>
            </form>
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

        });
    </script>


@endpush
