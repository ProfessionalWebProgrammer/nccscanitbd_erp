@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container">
            <form action="{{route('hrpayroll.time.attendance.maternityLeavePolicy.store')}}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{$userId}}">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Employee Maternity Leave Policy Create </h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                      <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Date :</label>
                              <div class="col-sm-9">
                                  <input type="date" name="date" class="form-control" placeholder="Issue Date">
                              </div>
                          </div>
                      </div>
                     <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Employee Name:</label>
                                <div class="col-sm-9">
                                   <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="emp_id">
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
                                <label class="col-sm-3 col-form-label">Execute Date :</label>
                                <div class="col-sm-9">
                                    <input type="date" name="executeDate" class="form-control" placeholder="Issue Date">
                                </div>
                            </div>
                        </div>
                     <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Duration:</label>
                                <div class="col-sm-9">
                                   <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="duration">
                                      <option>Select One</option>
                                      <option value="1">One Month</option>
                                      <option value="2">Two Month</option>
                                      <option value="3">Three Month</option>
                                      <option value="4">Four Month</option>
                                      <option value="5">Five Month</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                     <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Salary:</label>
                                <div class="col-sm-9">
                                   <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="duration">
                                      <option>Select One</option>
                                      <option value="1">Full Salary</option>
                                      <option value="2">Half Salary</option>
                                      <option value="3">40% Salary</option>
                                  </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"> Remarks :</label>
                            <div class="col-sm-9">
                              <textarea name="note" class="form-control ml-2 " rows="3" ></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="status" value="1">
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
