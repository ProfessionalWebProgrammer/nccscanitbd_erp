@extends('layouts.hrPayroll_dashboard')

@section('content')
<style>
  .menuclass{
  display: none;
  }
  </style>

<div class="content-wrapper">
    <!-- Main content -->
    <div class="content" >
      <div class="container-fluid" style="background:#fff!important; min-height:85vh;">

       <div class="row">
        <div class="col-md-2 mt-5">
             <!-- Main Sidebar Container -->
        <aside >
            @include('_partials_.sidebar')
        </aside>
        </div>
         <div class="col-md-10">

          <div class="mb-3" >
          @php
              $authid = Auth::id();
              $settingsdata = DB::table('permissions')
                  ->where('head', 'Settings')
                  ->where('user_id', $authid)
                  ->pluck('name')
                  ->toArray();
           @endphp

        <div class="row pt-3">
            <div class="col-md-4 m-auto sales_main_button">
                <a href="{{route('employee.time.attendance')}}" class="text-center pt-1 pb-2 py-3 btn btn-block  text-center linkbtn" >Time & Attendance</a>
            </div>
        </div>
          <div class="row pt-5 px-3 text-center">

            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.attendance.list') }}" class="btn btn-block  text-center py-3 linkbtn">E. Attendance List</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.attendance.form') }}" class="btn btn-block  text-center py-3 linkbtn">E. Attendance</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.overtime.create') }}" class="btn btn-block  text-center py-3 linkbtn">Overtime</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.overtime.list') }}" class="btn btn-block  text-center py-3 linkbtn">Overtime List</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('employee.extra.overtime.list')}}" class="btn btn-block  text-center py-3 linkbtn">Extra Overtime Management</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.time.attendance.lateEmployee.list') }}" class="btn btn-block  text-center py-3 linkbtn">Late Management</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('hrpayroll.time.attendance.shiftManage.list')}}" class="btn btn-block  text-center py-3 linkbtn">Shift Management</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.leave.of.absent.list') }}" class="btn btn-block  text-center py-3 linkbtn">Leave Of Absence List</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.time.attendance.employeeHolidayCalender.list') }}" class="btn btn-block  text-center py-3 linkbtn">Holiday Calendar</a>
                </div>
            </div>

            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.time.attendance.employeeWisePolicyAssign.list') }}" class="btn btn-block  text-center py-3 linkbtn">E. Wise Policy Assign</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.time.attendance.employeePartialLeave.list') }}" class="btn btn-block  text-center py-3 linkbtn">Partial & Fractional Leave</a>
                </div>
            </div>

            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.time.attendance.maternityLeavePolicy.list') }}" class="btn btn-block  text-center py-3 linkbtn">Maternity Leave</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.time.attendance.paternityLeavePolicy.list') }}" class="btn btn-block  text-center py-3 linkbtn">Paternity Leave</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('hrpayroll.time.attendance.billingProcessingMP.list')}}" class="btn btn-block  text-center py-3 linkbtn">Bill Processing</a>
                </div>
            </div>

            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{route('hrpayroll.time.attendance.complianceNonCompliance.list')}}" class="btn btn-block  text-center py-3 linkbtn">Set Compliance and Non Compliance</a>
                </div>
            </div>

          </div>
        </div>


                {{--    <div class="col-lg-12" style="height:390px;">
                           <h4 style="    display: flex;align-items: center;justify-content: center;width: 100%;height: 100%;">CRM Deshboard</h4>

                    </div>
                    <div class="col-lg-12 px-5" style="">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search here" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="button" id="button-addon2" style="margin-left: -9px;"><i class="fas fa-search"></i></button>
                        </div>
                      </div>
                    </div>  --}}


        </div>

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
