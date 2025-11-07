@extends('layouts.employee_dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper ">


        <!-- Main content -->
        <div class="content px-4">
            <div class="form container  ">
              <div class="row">
                <div class="col-md-8 m-auto">
                  <form class="floating-labels pt-5" action="{{route('hrpayroll.employee.myAttendance.report')}}" method="POST">
                      @csrf
                      <div class="row">
                          <div class="col-md-6 m-auto">
                              <label>Select Date: </label>
                              <div class="form-group m-b-40">
                                  <div class="input-group">
                                      <input type="text" name="date" class="form-control" id="daterangepicker">
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row mt-3 pb-5">
                          <div class="col-md-12 text-center mt-1">

                                  <button type="submit" class="btn custom-btn-sbms-submit"> View List </button>

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
