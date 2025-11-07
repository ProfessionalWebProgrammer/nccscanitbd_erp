@extends('layouts.hrPayroll_dashboard')
<style media="screen">
table {

  font-size: 11px!important;
  white-space: nowrap;
  margin: 0;
  border: none;
  border-collapse: separate;
  border-spacing: 0;
  table-layout: fixed;
  border: 1px solid black;
  overflow-y: scroll;
}
table td,
table th {
  border: 1px solid black;
  padding: 0.5rem 1rem;

}
  .content-wrapper{
    z-index: 1;
  /* margin-top:-43%!important; */
  }
table thead th {
  padding: 8px;
  position: sticky;
  top: 0;
  z-index: 1;
  width: 45vw;
  background: #FA621C;
  color:#000;
}

table td {
  padding-bottom: 7px;
  text-align: center;

}

table tbody td:nth-child(3) {
  font-weight: 100;
  text-align: left;
  position: relative;
}
table thead th:nth-child(1) {
  position: sticky!important;
  left: 0;
  z-index: 1;
}
table thead th{
  text-align: center;
}
table tbody td:nth-child(3){
  position: sticky;
  left: 0;
  background: #f5f5f5;
  z-index: 1;
}
caption {
  text-align: left;
  padding: 0.25rem;
  position: sticky;
  left: 0;
}

[role="region"][aria-labelledby][tabindex] {
  width: 100%;
  max-height: 200px;
  overflow: auto;
}
[role="region"][aria-labelledby][tabindex]:focus {
  //box-shadow: 0 0 0.5em rgba(0, 0, 0, 0.5);
  outline: 0;
}
  footer.main-footer{
  display: none!important;
    z-index: -1;
  }
  .hover_manu_content{
      position: absolute;
    width: 100%;
    float: left;
    /* top: -390px; */
    opacity: 0;
  background: #fff;
   margin-left: -15px;
}
</style>
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">
                  <div class="col-md-12 text-right">
                         <button class="btn btn-sm  btn-success mt-1" id="btnExport"  >
                          Export
                       </button>
                    	<button class="btn btn-sm  btn-warning mt-1"  onclick="printDiv('contentbody')"  id="printbtn"  >
                          Print
                       </button>

                  </div>
                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive" id="contentbody">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Salary Sheet Report List</h5>
                      	 {{-- <p>Date: {{$year}} </p> --}}
                        <hr>
                    </div>
                    <!-- Start new Table  -->
                    <div role="region" aria-labelledby="caption" tabindex="0" style="min-height:400px;">
                      <table id="reporttable">
                        <caption id="caption"></caption>
                        <thead>
                          <tr>
                            <th colspan="7">Information</th>
                            <th colspan="6">Salary</th>
                            <th colspan="7">Attendance</th>
                            <th colspan="2">Leave</th>
                            <th colspan="2">Deduction</th>
                            <th rowspan="2">Total Wages</th>
                            <th colspan="2">Bonus</th>
                            <th colspan="3">Over Time</th>
                            <th rowspan="2">Stamp</th>
                            <th rowspan="2">Net Salary</th>
                            <th rowspan="2">Signature</th>
                          </tr>
                          <tr>
                            <th>Sl</th>
                            <th>Emp ID</th>
                            <th>Name</th>
                            <th>Desination</th>
                            <th>Grade</th>
                            <th>Gender</th>
                            <th>DOJ</th>
                            <th>Basic</th>
                            <th>HR</th>
                            <th>MA</th>
                            <th>CV</th>
                            <th>FA</th>
                            <th>Gross</th>
                            <th>P-Day</th>
                            <th>A-Day</th>
                            <th>T.L</th>
                            <th>L Abs</th>
                            <th>WOH</th>
                            <th>H-Day</th>
                            <th>Pay-Day</th>
                            <th>CL</th>
                            <th>SL</th>
                            <th>Advanced</th>
                            <th>Absent</th>
                            <th>All Bonus</th>
                            <th>Total</th>
                            <th>OT H</th>
                            <th>OT R</th>
                            <th>Amount</th>

                          </tr>
                        </thead>
                        <tbody>
                          @php
                          $totalNetSalary = 0;
                          @endphp
                          @foreach ($employees as $emp)
                          @php
                          $data = DB::table('employee_attendances')->select(
                          'employee_id',
                          DB::raw('SUM(CASE WHEN present = 1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `present` ELSE null END) as total_present'),
                          DB::raw('SUM(CASE WHEN late = 1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `late` ELSE null END) as total_late'),
                          DB::raw('SUM(CASE WHEN absent = 1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `absent` ELSE null END) as total_absent'),
                          DB::raw('SUM(CASE WHEN leave_of_absent = 1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `absent` ELSE null END) as total_leave_of_absent'),
                          DB::raw('SUM(CASE WHEN overTime > .1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `overTime` ELSE null END) as total_overTime'),
                          DB::raw('SUM(CASE WHEN holyday = 1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `holyday` ELSE null END) as total_holiday'),
                          DB::raw('SUM(CASE WHEN woh > 1 AND date BETWEEN  "'.$fdate.'" AND "'.$tdate.'" THEN `woh` ELSE null END) as total_woh')
                          )->where('employee_id',$emp->emp_id)->first();

                          $empLeave = \App\Models\EmployeePartialLeave::select(DB::raw('sum(cl_day) as clDay'),DB::raw('sum(sl_day) as slDay'))->where('emp_id',$emp->emp_id)->whereBetween('date',[$fdate,$tdate])->where('status',1)->first();
                          $empAdvance = \App\Models\EmployeeAdvanceSalary::select(DB::raw('sum(amount) as Amount'))->where('emp_id',$emp->emp_id)->whereBetween('date',[$fdate,$tdate])->first();
                          $empBonus = \App\Models\EmployeeBonus::select(DB::raw('sum(amount) as Amount'))->where('emp_id',$emp->emp_id)->whereBetween('date',[$fdate,$tdate])->first();

                          if(!empty($emp->empAccount->basic_salary)){
                            $rate  = ($emp->empAccount->total_gross_salary/30)/8;
                            $amount = $rate*$data->total_overTime;
                            $perDay = $emp->empAccount->total_gross_salary/30;
                            $deductionAmount = $perDay*$data->total_absent;
                          } else {
                            $rate = 0;
                            $amount = 0;
                            $deductionAmount = 0;
                          }

                          if($data->total_late >= 3){
                            $reault = $data->total_late/3;
                            $lateAmount = $reault*$emp->empAccount->total_gross_salary/30;
                          } else {
                            $lateAmount = 0;
                          }

                          $grossSalary = $emp->empAccount->basic_salary +
                                        $emp->empAccount->HRA +
                                        $emp->empAccount->MA +
                                        $emp->empAccount->CV +
                                        $emp->empAccount->FA - $lateAmount;
                          $netSalary = $grossSalary + $amount + $empBonus->Amount;
                          $totalNetSalary += $netSalary;
                          @endphp
                          <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>BDDDL-{{$emp->employee->id}}</td>
                            <td>{{$emp->employee->emp_name}}</td>
                            <td>{{$emp->employee->designation->designation_title ?? ''}}</td>
                            <td>{{$emp->employee->staffCat->staff_cate_title ?? ''}}</td>
                            <td>@if($emp->employee->emp_gender == 2) Male  @else Female @endif </td>
                            <td>{{date('d M ,Y',strtotime($emp->employee->emp_joining_date))}}</td>
                            <td>{{number_format($emp->empAccount->basic_salary,2)}}</td>
                            <td>{{number_format($emp->empAccount->HRA,2)}}</td>
                            <td>{{number_format($emp->empAccount->MA,2)}}</td>
                            <td>{{number_format($emp->empAccount->CV,2)}}</td>
                            <td>{{number_format($emp->empAccount->FA,2)}}</td>
                            <td>{{number_format($grossSalary,2)}}</td>
                            <td>{{$data->total_present}}</td>
                            <td>{{$data->total_absent}}</td>
                            <td>{{$data->total_late}}</td>
                            <td>{{$data->total_leave_of_absent}}</td>
                            <td>{{$data->total_woh ?? 0}}</td>
                            <td>{{$data->total_holiday ?? 0}}</td>
                            <td>{{$data->total_present+$data->total_holiday}}</td>
                            <td>{{$empLeave->clDay ?? 0}}</td>
                            <td>{{$empLeave->slDay ?? 0}}</td>
                            <td>{{number_format($empAdvance->Amount,2)}}</td>
                            <td>{{number_format($deductionAmount,2)}}</td>
                            <td>{{number_format($grossSalary - $deductionAmount,2)}}</td>
                            <td>{{number_format($empBonus->Amount,2)}}</td>
                            <td>{{number_format($empBonus->Amount,2)}}</td>
                            <td>{{$data->total_overTime}}</td>
                            <td>{{number_format($rate,2)}}</td>
                            <td>{{number_format($amount,2)}}</td>
                            <td></td>
                            <td>{{number_format($netSalary,2)}}</td>
                            <td></td>
                          </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="31"> Grand Total: </td>
                            <td>{{number_format($totalNetSalary,2)}}</td>
                            <td></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- End new Table  -->
                  {{--  <table id="example1" class="table table-bordered table-striped" style="font-size: 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>SL.</th>
                                <th>Employee Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Joining Date</th>
                                <th>Basic Salary</th>
                                <th>Earned Leave Day</th>
                                <th>Paymnet Amount</th>
                            </tr>
                        </thead>
                        <tbody>


                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                  	<td class="text-center">{{$emp->employee->emp_name ?? ''}}</td>
                                  	<td class="text-center">{{$emp->employee->designation->designation_title ?? ''}}</td>
                                  	<td class="text-center">{{$emp->employee->department->department_title ?? ''}}</td>
                                    <td class="text-center">{{date('d-M-Y',strtotime($emp->employee->emp_joining_date))}}</td>

                                    <td class="text-right">
                                      @if($basicSalary > 1)
                                      {{number_format($basicSalary,2)}}
                                      @else  @endif
                                    </td>
                                  	<td class="text-center">{{$earnDay}}</td>
                                    <td class="text-right">
                                      @if($totalAmount > 1)
                                      {{number_format($totalAmount,2)}}
                                      @else  @endif
                                    </td>

                                </tr>


                        </tbody>
                        <tfoot>
                          <tr>

                          </tr>
                        </tfoot>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function printDiv(divName) {
                 var printContents = document.getElementById(divName).innerHTML;
                 var originalContents = document.body.innerHTML;

                 document.body.innerHTML = printContents;

                 window.print();

                 document.body.innerHTML = originalContents;
            }
    </script>

    <script type="text/javascript">
        $(function () {
            $("#btnExport").click(function () {
                $("#reporttable").table2excel({
                    filename: "Monthly-Employee-Target-Report.xls"
                });
            });
        });
    </script>
@endsection
