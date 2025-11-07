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
                        <h4 class="font-weight-bolder text-uppercase">Employee Paternity Leave Policy Create </h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                      <div class="col-md-12">
                          <div class="form-group row">
                              <label class="col-sm-2 col-form-label">Head :</label>
                              <div class="col-sm-9">
                                  <input type="test" name="head" class="form-control" placeholder="Employee Paternity Policy Head">
                              </div>
                          </div>
                      </div>
                     <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Description:</label>
                                <div class="col-sm-10">
                                  <textarea name="description" class="form-control" rows="8" cols="96"></textarea>
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
