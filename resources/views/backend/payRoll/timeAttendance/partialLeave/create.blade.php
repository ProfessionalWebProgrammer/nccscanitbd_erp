@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
          <div class="container">
            <form action="{{route('hrpayroll.time.attendance.employeePartialLeave.store')}}" method="POST">
                @csrf
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">CL Leave Create </h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                      <input type="hidden" name="user_id" value="{{$userId}}">
                      <div class="col-md-4">
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Date :</label>
                              <div class="col-sm-9">
                                  <input type="date" name="date" class="form-control" placeholder="Date">
                              </div>
                          </div>
                      </div>
                     <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Employee :</label>
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


                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Leave Day:</label>
                                <div class="col-sm-9">
                                  <input type="text" name="cl_day" class="form-control">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="sl_day" value="">
                        {{-- <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Amount :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="amount" placeholder="Loan Amount">
                                </div>
                            </div>
                        </div> --}}


                  <div class="col-md-12">
                         <div class="form-group row">
                             <label class="col-sm-2 col-form-label">Description:</label>
                             <div class="col-sm-10">
                               <textarea name="note" class="form-control" rows="3" cols="100"></textarea>
                             </div>
                         </div>
                     </div>
                     <input type="hidden" name="status" value="1">
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
