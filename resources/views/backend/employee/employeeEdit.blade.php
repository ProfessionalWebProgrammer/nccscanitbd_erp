@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ URL::to('update/employee/' . $employeeData->id) }}" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Edit Employee</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Name :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="emp_name" value="{{ $employeeData->emp_name }}"
                                        class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Phone No :</label>
                                <div class="col-sm-9">
                                    <input type="Text" value="{{ $employeeData->emp_mobile_number }}"
                                        name="emp_mobile_number" class="form-control" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Join Date :</label>
                                <div class="col-sm-9">
                                    <input type="date" value="{{ $employeeData->emp_joining_date }}"
                                        name="emp_joining_date" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                              <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Age:</label>
                                  <div class="col-sm-9">
                                      <input type="text" name="emp_age" class="form-control" value="{{$employeeData->emp_age}}">
                                  </div>
                              </div>
                          </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Designation:</label>
                                <div class="col-sm-9">
                                  	<select name="emp_designation_id" class="form-control select2" id="">
                                        <option value="">== Select Designation ==</option>
                                        @foreach ($designation as $deg)
                                            <option value="{{ $deg->id }}" @if ($employeeData->emp_designation_id == $deg->id)
                                                selected
                                        @endif>{{ $deg->designation_title }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                      	<div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Department:</label>
                                <div class="col-sm-9">
                                  	<select name="emp_department_id" class="form-control select2" id="">
                                        <option value="">== Select Department ==</option>
                                        @foreach ($department as $dep)
                                            <option value="{{ $dep->id }}" @if ($employeeData->emp_department_id == $dep->id)
                                                selected
                                        @endif>{{ $dep->department_title }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Yearly Holiday:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="yearly_holiday" value="{{ $employeeData->yearly_holiday }}" class="form-control" >
                                </div>
                            </div>
                       </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email:</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="emp_mail_id" value="{{ $employeeData->emp_mail_id }}"
                                        class="form-control" placeholder="Employee Email">
                                </div>
                            </div>
                        </div>
                      {{--  <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Zone :</label>
                                <div class="col-sm-9">
                                    <select name="emp_zone" class="form-control select2" id="">
                                        <option value="">== Select Zone ==</option>
                                        @foreach ($dealerZone as $item)
                                            <option value="{{ $item->id }}" @if ($employeeData->emp_zone == $item->id)
                                                selected
                                        @endif>{{ $item->zone_title }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Area :</label>
                                <div class="col-sm-9">
                                    <select name="emp_area" class="form-control select2" id="">
                                        <option value="">== Select Area ==</option>
                                        @foreach ($dealerArea as $item)
                                            <option value="{{ $item->id }}" @if ($employeeData->emp_area == $item->id)
                                                selected
                                        @endif>{{ $item->area_title }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Salary: </label>
                                <div class="col-sm-9">
                                    <input type="Text" name="emp_salary" value="{{ $employeeData->emp_salary }}"
                                        class="form-control" >
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Bank Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="bank_name" class="form-control" value="{{ $employeeData->bank_name }}" >
                                </div>
                            </div>
                       </div>


                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Account Number:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="bank_ac_number" class="form-control" value="{{ $employeeData->bank_ac_number }}">
                                </div>
                            </div>
                       </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Address: </label>
                                <div class="col-sm-9">
                                    <textarea name="emp_present_address" class="form-control" id="" cols="30" rows="2"
                                        >{{ $employeeData->emp_present_address }}  </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pb-5">
                    <div class="col-md-6 mt-3">
                        <div class="text-right">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Update </button>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">

                    </div>
                </div>
            </form>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
