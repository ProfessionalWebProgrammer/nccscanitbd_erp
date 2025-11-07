@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 pt-5">
            <div class="form container ">
                    <form class="floating-labels pt-5" action="{{route('employee.overtime.view')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 m-auto">
                              <div class=" form-group row">
                                  <label class="col-sm-4 col-form-label">Select Date Range:</label>
                                  <div class="col-sm-8">
                                      <input type="text" name="date" class="form-control float-right" id="daterangepicker">
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12 text-center mt-3 pb-5">
                                <button class="btn btn-sm btn-primary px-5" type="submit">View List</button>
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
@endsection
