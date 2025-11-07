@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container">
            <form action="#" method="POST">
                @csrf
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Employee Shift Time Schedule Create </h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                      <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Head :</label>
                              <div class="col-sm-9">
                                  <input type="test" name="head" class="form-control" placeholder="Employee Shift Time Schedule Head">
                              </div>
                          </div>
                      </div>
                     <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Time Schedule:</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="schedule" placeholder="6.00 am to 12.00 am">
                                </div>
                            </div>
                        </div>
                  </div>

                <div class="row pb-5">
                    <div class="col-md-12 text-center mt-3">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                    </div>

                </div>
            </form>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- /. -->
@endsection
