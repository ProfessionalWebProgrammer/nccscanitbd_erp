@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container">
            <form action="{{route('employee.leave.of.absent.policy.store')}}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{$userid}}">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Employee Leave Policy Create </h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                      <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-2 col-form-label">Head :</label>
                              <div class="col-sm-9">
                                  <input type="test" name="head" class="form-control" placeholder="Employee Late Policy Head">
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-2 col-form-label">Day Count :</label>
                              <div class="col-sm-9">
                                  <input type="test" name="count" class="form-control" placeholder="Day Count">
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-2 col-form-label">Fine :</label>
                              <div class="col-sm-9">
                                  <input type="test" name="fine" class="form-control" placeholder="Fine">
                              </div>
                          </div>
                      </div>
                     <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Description:</label>
                                <div class="col-sm-9">
                                  <textarea name="note" class="form-control" rows="3" cols="46"></textarea>
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
