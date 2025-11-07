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
                <a href="{{route('employee.pay.rollReport')}}" class="text-center pt-1 pb-2 py-3 btn btn-block  text-center linkbtn" >HR & PayRoll Report</a>
            </div>
        </div>


          <div class="row pt-5 px-3 text-center">
              <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.history.report.index') }}" class="btn btn-block  text-center py-3 linkbtn">All Employee History Report</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.payment.report.index') }}" class="btn btn-block  text-center py-3 linkbtn">Salary Payment History Report</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('newEmployee.recruitment.report.index') }}" class="btn btn-block  text-center py-3 linkbtn">New Recruitment Report</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.production.report.index') }}" class="btn btn-block  text-center py-3 linkbtn">Production Report</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.maternityLeave.report.index') }}" class="btn btn-block  text-center py-3 linkbtn">Maternity Leave Report</a>
                </div>
            </div>

            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.team.report.index') }}" class="btn btn-block  text-center py-3 linkbtn">Employee Team Report</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('monthly.salary.and.attendance.report') }}" class="btn btn-block  text-center py-3 linkbtn">Monthly Salary And Attendance Report</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.monthly.deduction.filter') }}" class="btn btn-block  text-center py-3 linkbtn">E. Monthly Deduction Report</a>
                </div>
            </div>

            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.employee.attendance.index') }}" class="btn btn-block  text-center py-3 linkbtn">All Attendance Report</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.employee.attendance.ledger.index') }}" class="btn btn-block  text-center py-3 linkbtn">All Attendance Ledger</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.employee.lefty.industry.index') }}" class="btn btn-block  text-center py-3 linkbtn">Lefty Report</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.employee.earnLeave.index') }}" class="btn btn-block  text-center py-3 linkbtn">Earn Leave Report</a>
                </div>
            </div>
             <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
              <div class="mx-1">
                <a href="{{ route('emp.final.settlement.report.input') }}" class="btn btn-block  text-center py-3 linkbtn">Final Settelment Report</a>
              </div>
          </div>
           <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
            <div class="mx-1">
              <a href="{{ route('emp.leave.report.input') }}" class="btn btn-block  text-center py-3 linkbtn">Leave Report</a>
            </div>
        </div>
        <!--<div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">-->
        <!--        <div class="mx-1">-->
        <!--          <a href="{{ route('hrpayroll.employee.salarySheet.index') }}" class="btn btn-block  text-center py-3 linkbtn">Salary Sheet Report</a>-->
        <!--        </div>-->
        <!--    </div>-->
        <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
              <div class="mx-1">
                <a href="{{ route('emp.salary.sheet.input') }}" class="btn btn-block  text-center py-3 linkbtn">Salary Sheet Report</a>
              </div>
          </div>
             <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
          <div class="mx-1">
            <a href="{{ route('emp.attendence.job.report.input') }}" class="btn btn-block  text-center py-3 linkbtn">Attendence Job Card Report</a>
          </div>
      </div>
      <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.employee.productSalarySheet.index') }}" class="btn btn-block  text-center py-3 linkbtn">Production Salary Sheet Report</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.employee.promotion.report') }}" class="btn btn-block  text-center py-3 linkbtn">Promotion Report</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('hrpayroll.employee.increment.report') }}" class="btn btn-block  text-center py-3 linkbtn">Increment Report</a>
                </div>
            </div>
             <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
        <div class="mx-1">
          <a href="{{ route('emp.payslip.report.input') }}" class="btn btn-block  text-center py-3 linkbtn">Payslip Report</a>
        </div>
    </div>
     <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
      <div class="mx-1">
        <a href="{{ route('emp.worker.payslip.report.input') }}" class="btn btn-block  text-center py-3 linkbtn">Worker Payslip Report</a>
      </div>
  </div>
  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
    <div class="mx-1">
      <a href="{{ route('emp.working.report.input') }}" class="btn btn-block  text-center py-3 linkbtn">Working Report</a>
    </div>
</div>

          {{--  <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.overtime.list') }}" class="btn btn-block  text-center py-3 linkbtn">E. Overtime List</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.leave.of.absent.form') }}" class="btn btn-block  text-center py-3 linkbtn">E. Leave Of Absence</a>
                </div>
            </div>
            <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                <div class="mx-1">
                  <a href="{{ route('employee.leave.of.absent.list') }}" class="btn btn-block  text-center py-3 linkbtn">Leave Of Absence List</a>
                </div>
            </div>

              <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                  <div class="mx-1">
                    <a href="{{route('client.index')}}" class="btn btn-block  text-center py-3 linkbtn"></a>
                  </div>
              </div>

              <div class="col-md-2 p-1 sales_button" style="border-radius: 8px;">
                  <div class="mx-1">
                    <a href="{{route('progress.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Progress</a>
                  </div>
              </div>

             <div class="col-md-4 p-1 sales_button" style="border-radius: 8px;">
                  <div class="mx-1">
                    <a href="{{route('progress.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Progress Report</a>
                  </div>
              </div>

             <div class="col-md-4 p-1 sales_button" style="border-radius: 8px;">
                  <div class="mx-1">
                    <a href="{{route('client.requirement.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Client Requirement</a>
                  </div>
              </div>

             <div class="col-md-4 p-1 sales_button" style="border-radius: 8px;">
                  <div class="mx-1">
                    <a href="{{route('requirement.report.index')}}" class="btn btn-block  text-center py-3 linkbtn" >Client Requirement Report</a>
                  </div>
              </div> --}}



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
