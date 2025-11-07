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
                        <h4 class="font-weight-bolder text-uppercase">Employee Personal & Qualification Document Create </h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                      <div class="col-md-6 m-auto">
                          <div class="form-group row">
                            <label class="col-md-3">Employee Name: </label>
                            <div class="col-md-9 form-group m-b-40">
                                <div class="input-group">
                                    <select class="form-control select2" name="employee_id">
                                      <option>Select Employee</option>
                                      @foreach($employee as $item)
                                        <option value="{{$item->id}}">{{$item->emp_name}}</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Qualification Doc :</label>
                              <div class="col-sm-9">
                                  <input type="file" name="qualification" >
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Personal Doc :</label>
                              <div class="col-sm-9">
                                  <input type="file" name="pesonal" >
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Image:</label>
                              <div class="col-sm-9">
                                  <input type="file" name="image" >
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
