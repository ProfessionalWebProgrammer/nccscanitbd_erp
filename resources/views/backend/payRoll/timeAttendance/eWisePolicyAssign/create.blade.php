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
                        <h4 class="font-weight-bolder text-uppercase">Maternity & Paternity Emploayee Bill Create </h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                      <!-- <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Issue Date :</label>
                              <div class="col-sm-9">
                                  <input type="date" name="date" class="form-control" placeholder="Transfer Date">
                              </div>
                          </div>
                      </div> -->
                     <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Employee Name:</label>
                                <div class="col-sm-9">
                                   <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="emp_name">
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
                                <label class="col-sm-3 col-form-label"> Leave Policy :</label>
                                <div class="col-sm-9">
                                  <select class="form-control selectpicker border border-secondary" data-show-subtext="true"
                                  data-live-search="true" data-actions-box="true" multiple
                                      name="leavePolicy[]">

                                      <option value="">Select Leave Policy</option>
                                      @for ($i=1; $i<= 7; $i++)
                                          <option style="color: #FF0000; font-weight:bold" value="{{ $i }}">
                                              Policy - {{$i}}
                                          </option>
                                      @endfor
                                  </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Amount :</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="amount" placeholder="Loan Amount">
                                </div>
                            </div>
                        </div>


                  <div class="col-md-12">
                         <div class="form-group row">
                             <label class="col-sm-2 col-form-label">Remarks:</label>
                             <div class="col-sm-10">
                               <textarea name="description" class="form-control" rows="3" cols="100"></textarea>
                             </div>
                         </div>
                     </div> --}}
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
