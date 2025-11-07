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
                        <h4 class="font-weight-bolder text-uppercase">Holiday Calendar Create </h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                      <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Issue Date :</label>
                              <div class="col-sm-9">
                                  <input type="date" name="date" class="form-control" placeholder="Transfer Date">
                              </div>
                          </div>
                      </div>
                     <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">HoliDay Name:</label>
                                <div class="col-sm-9">
                                  <input type="text" name="holiday" class="form-control" placeholder="HoliDay Name">
                                </div>
                            </div>
                        </div>
                     <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">HoliDay Count:</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="holidayCount" placeholder="HoliDay Count">
                                </div>
                            </div>
                        </div>
                     <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Description:</label>
                                <div class="col-sm-9">
                                  <textarea name="description" class="form-control" rows="3" cols="50"></textarea>
                                </div>
                            </div>
                        </div>
                       </div>

                <div class="row pb-5">
                    <div class="col-md-12 mt-3">
                        <div class=" col-md-1 m-auto">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
                        </div>
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
