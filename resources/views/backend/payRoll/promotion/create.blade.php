@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container">
            <form action="{{route('hrpayroll.employee.promotion.store')}}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{$urerid}}">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Emploayee Promotion Create </h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                      <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Date :</label>
                              <div class="col-sm-9">
                                  <input type="date" name="date" class="form-control" placeholder="Transfer Date">
                              </div>
                          </div>
                      </div>
                     <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Employee Name:</label>
                                <div class="col-sm-9">
                                   <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="employee_id">
                                      <option>Select Employee Name</option>
                                      @foreach($employees as $val)
                                      <option value="{{$val->id}}">{{$val->emp_name}}</option>
                                      @endforeach
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Department :</label>
                                <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="department_id">
                                     <option>Select Department</option>
                                     @foreach($departments as $val)
                                     <option value="{{$val->id}}">{{$val->department_title}}</option>
                                     @endforeach
                                 </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Designation :</label>
                                <div class="col-sm-9">
                                  <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="designation_id">
                                     <option>Select Designation</option>
                                     @foreach($designations as $val)
                                     <option value="{{$val->id}}">{{$val->designation_title}}</option>
                                     @endforeach
                                 </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Remarks :</label>
                            <div class="col-sm-10">
                              <textarea name="note" class="form-control" rows="3" cols="106"></textarea>
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
