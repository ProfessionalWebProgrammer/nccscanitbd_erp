@extends('layouts.hrPayroll_dashboard')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <form action="{{ Route('employee.store') }}" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="pt-3 text-center">
                        <h4 class="font-weight-bolder text-uppercase">Employee Create</h4>
                        <hr width="33%">
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Name :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="emp_name" class="form-control" placeholder="Employee Name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Phone No :</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="emp_mobile_number" class="form-control"
                                        placeholder="Employee Phone No">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Join Date :</label>
                                <div class="col-sm-9">
                                    <input type="date" name="emp_joining_date" class="form-control" placeholder="Join Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Punch Card No:</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="emp_punch_card_no" class="form-control"
                                        placeholder="Employee Punch Card No">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email:</label>
                                <div class="col-sm-9">
                                    <input type="Text" name="emp_mail_id" class="form-control" placeholder="Employee Email">
                                </div>
                            </div>
                        </div>



                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Date of Birth:</label>
                                <div class="col-sm-9">
                                    <input type="date" name="emp_dob" class="form-control" placeholder="Employee Email">
                                </div>
                            </div>
                        </div>

                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Age:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="emp_age" class="form-control" placeholder="Employee Age">
                                </div>
                            </div>
                        </div>

                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Select Gender:</label>
                                <div class="col-sm-9">
                                   <div class="form-check">
                                        <input class="form-check-input" type="radio" name="emp_gender" id="flexRadioDefault1" value="1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                          Female
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="emp_gender" id="flexRadioDefault2"  value="2" checked>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                          Male
                                        </label>
                                      </div>
                                </div>
                            </div>
                        </div>
                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Maritial Status:</label>
                                <div class="col-sm-9">
                                   <div class="form-check">
                                        <input class="form-check-input" type="radio" name="emp_merital_status" id="flexRadioDefault3" value="1">
                                        <label class="form-check-label" for="flexRadioDefault3">
                                          Married
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="emp_merital_status" id="flexRadioDefault4" value="0" checked>
                                        <label class="form-check-label" for="flexRadioDefault4">
                                          Unmarried
                                        </label>
                                      </div>
                                </div>
                            </div>
                        </div>


                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Spouse Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="emp_spouse_name" class="form-control" placeholder="Employee Spouse Name">
                                </div>
                            </div>
                        </div>
                     <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nationality:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="emp_nationality" class="form-control" placeholder="Employee Nationality">
                                </div>
                            </div>
                        </div>

                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Religion:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="emp_religion" class="form-control" placeholder="Employee Religion">
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Father Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="emp_father_name" class="form-control" placeholder="Employee Father Name">
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Monther Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="emp_mother_name" class="form-control" placeholder="Employee Monther Name">
                                </div>
                            </div>
                        </div>
                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Blood Group:</label>
                                <div class="col-sm-9">
                                   <select class="form-control select2" style="padding: 0px 10px 10px 10;" name="emp_blood_group">
                                      <option>Select Blood Group</option>
                                      <option value="A+">A+</option>
                                      <option value="A-">A-</option>
                                      <option value="B+">B+</option>
                                      <option value="B-">B-</option>
                                      <option value="AB+">AB+</option>
                                      <option value="AB-">AB-</option>
                                      <option value="O+">O+</option>
                                      <option value="O-">O-</option>
                                  </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nid Number:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="emp_nid_card" class="form-control" placeholder="Employee Nid Number">
                                </div>
                            </div>
                        </div>


                    {{--    <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Zone :</label>
                                <div class="col-sm-9">
                                    <select name="emp_zone" class="form-control select2" id="">
                                        <option value="">== Select Zone ==</option>
                                        @foreach ($dealerZone as $item)
                                            <option value="{{ $item->id }}">{{ $item->zone_title }}</option>

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
                                            <option value="{{ $item->id }}">{{ $item->area_title }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> --}}


                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Depertment :</label>
                                <div class="col-sm-9">
                                    <select name="emp_department_id" class="form-control select2" id="">
                                        <option value="">== Select Depertment ==</option>
                                        @foreach ($department as $item)
                                            <option value="{{ $item->id }}">{{ $item->department_title }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Designation :</label>
                                <div class="col-sm-9">
                                    <select name="emp_designation_id" class="form-control select2" id="">
                                        <option value="">== Select Designation ==</option>
                                        @foreach ($designation as $item)
                                            <option value="{{ $item->id }}">{{ $item->designation_title }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Yearly Holiday:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="yearly_holiday" class="form-control" placeholder="Total Yearly Holiday">
                                </div>
                            </div>
                       </div>

                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Bank Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="bank_name" class="form-control" placeholder="Bank Name">
                                </div>
                            </div>
                       </div>


                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Account Number:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="bank_ac_number" class="form-control" placeholder="Bank A/C Number">
                                </div>
                            </div>
                       </div>
                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> StaffCategory :</label>
                                <div class="col-sm-9">
                                    <select name="emp_staff_category_id" class="form-control select2" id="">
                                        <option value="">== Select StaffCategory ==</option>
                                        @foreach ($staffcategory as $item)
                                            <option value="{{ $item->id }}">{{ $item->staff_cate_title }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    {{--    <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Basic Salary: </label>
                                <div class="col-sm-9">
                                    <input type="Text" name="emp_salary" class="form-control" placeholder="Employee Salary">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"> Bonus: </label>
                                <div class="col-sm-9">
                                    <input type="Text" name="emp_bonus" class="form-control" placeholder="Employee Bonus">
                                </div>
                            </div>
                        </div>

                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Work Houre : </label>
                                <div class="col-sm-9">
                                    <input type="Text" name="emp_work_hour" class="form-control" placeholder="Employee Work Houre">
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Overtime Per Houre : </label>
                                <div class="col-sm-9">
                                    <input type="Text" name="emp_overtime" class="form-control" placeholder="Overtime Per Houre">
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Present Address: </label>
                                <div class="col-sm-9">
                                    <textarea name="emp_present_address" class="form-control" id="" cols="30" rows="2"
                                        placeholder="Employee Present Address"></textarea>
                                </div>
                            </div>
                        </div>
                       <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Permanent Address: </label>
                                <div class="col-sm-9">
                                    <textarea name="emp_parmanent_address" class="form-control" id="" cols="30" rows="2"
                                        placeholder="Employee Permanent Address"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pb-5">
                    <div class="col-md-6 mt-3">
                        <div class="text-right">
                            <button type="submit" class="btn custom-btn-sbms-submit"> Submit </button>
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
