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
                      	 <p>Date: {{$fdate}} To {{ $tdate }} </p>
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
                            <th colspan="6">Attendance</th>
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
                            <th>Designation</th>
                            <th>Grade</th>
                            <th>Gender</th>
                            <th>DOB</th>
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
                            <th>CL</th>
                            <th>SL</th>
                            <th>Advanced</th>
                            <th>A. Cost</th>
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
                               $perDaygrossSalary = 0;
                               $basicSalary = 0;
                               $totalPresence = 0;
                               $totalLateCost = 0;
                               $totalPresence = $emp->empAttendanceInfo()?->whereBetween('date',[$fdate,$tdate])->where('present' , 1)->count();
                               $totalAbsence = $emp->empAttendanceInfo()?->whereBetween('date',[$fdate,$tdate])->where('present' , 0)->count();
                               $totalLate = $emp->empAttendanceInfo()?->whereBetween('date',[$fdate,$tdate])->where('late' , 1)->count();
                               $totalLeaveOfAbsence = $emp->leaveOfAbsences()?->whereDate('absent_from','>=',$fdate)->whereDate('absent_to','<=',$tdate)->where('status',1)->sum('leave_of_absent');
                               $totalWoh = $emp->empAttendanceInfo()?->whereBetween('date',[$fdate,$tdate])->where('woh','>',1)->count('woh');
                               $totalHoliday = $emp->empAttendanceInfo()?->whereBetween('date',[$fdate,$tdate])->where('holyday',1)->sum('holyday');
                               $basicSalary = (float)$emp->empAccountInfo?->basic_salary ?? 0;
                               
                               $grossSalary = (float) $emp->empAccountInfo?->total_gross_salary ?? 0;
                               $perDaygrossSalary =  $grossSalary / 26;
                            //    $totalBasicSalary = $totalPresence * $basicSalaryPerDay;
                            $totalHours = 0;
                            $totalMinutes = 0;
                            $comTotalHours = 0;
                            $comTotalMinutes = 0;
                            $empAttendanceInfo = $emp->empAttendanceInfo;
                            if ($empAttendanceInfo) {
                                foreach ($empAttendanceInfo as $attendence) {
                                    if($attendence->entry_time && $attendence->exit_time){
                                        $entryTime = \Carbon\Carbon::createFromFormat('H:i', $attendence->entry_time);
                                        $exitTime = \Carbon\Carbon::createFromFormat('H:i', $attendence->exit_time);
                                        
                                        $timeDifference = $entryTime->diff($exitTime);
                                        if ($timeDifference->h >= 9) {
                                            if($timeDifference->h < 2){
                                              $comTotalHours += $timeDifference->h;
                                              $comTotalMinutes += $timeDifference->i;
                                            }elseif($timeDifference->h == 2) {
                                              $comTotalHours += $timeDifference->h;
                                              $comTotalMinutes = 0;
                                            }else{
                                              $comTotalHours = 2;
                                              $comTotalMinutes = 0;
                                            }
                                            $totalHours += $timeDifference->h - 9;
                                            $totalMinutes += $timeDifference->i;
                                        }
                                    }
                                }
                                if ($totalMinutes >= 60) {
                                    $additionalHours = intdiv($totalMinutes, 60);
                                    $totalHours += $additionalHours;
                                    $totalMinutes = $totalMinutes % 60;
                                }
                                if ($comTotalMinutes >= 60) {
                                    $comAdditionalHours = intdiv($comTotalMinutes, 60);
                                    $comTotalHours += $comAdditionalHours;
                                    $comTotalMinutes = $comTotalMinutes % 60;
                                }
                            
                            }
                            if($emp->empAccountInfo?->overtime_per_houre > 0){
                                $otRate = $emp->empAccountInfo?->overtime_per_houre;
                            }else{
                                $otRate = (($emp->empAccountInfo?->total_gross_salary / 26) / 8);
                            }
                             
                            if($comType == 1){
                              $totalOvertimeCostHour = $comTotalHours * $otRate;
                              $totalOvertimeCostMinute = ($otRate / 60) * $comTotalMinutes;
                            }
                            if($comType == 2){
                              $totalOvertimeCostHour = $totalHours * $otRate;
                              $totalOvertimeCostMinute = ($otRate / 60) * $totalMinutes;
                            }
                        
                            $totalOvertimeCost = $totalOvertimeCostHour + $totalOvertimeCostMinute;

                            
                            $totalLateCostDay = intVal($totalLate / 3);
                            $totalLateCost =  $totalLateCostDay * $perDaygrossSalary;
                            $deductionAbsence = $totalAbsence - $totalLeaveOfAbsence;
                            if($deductionAbsence > 0){
                                $deductionAmount = $deductionAbsence * $perDaygrossSalary;
                            }else{
                                $deductionAmount = 0;
                            }
                            $deductionCost = $deductionAmount +  $totalLateCost;
                            $netSalary = (($perDaygrossSalary * $totalPresence) + $totalOvertimeCost + $emp->empAccountInfo?->FB) - $deductionCost;
                            $totalNetSalary += $netSalary;
                           @endphp
                           <tr>
                               <td>{{ $loop->iteration }}</td>
                               <td>BDDDL-{{$emp->id}}</td>
                               <td>{{$emp->emp_name}}</td>
                               <td>{{$emp->designation?->designation_title ?? '---'}}</td>
                               <td>{{$emp->emp_grade_info ?? '---'}}</td>
                               <td>{{$emp->emp_gender == 2 ? 'Male' : 'Female'}}</td>
                               <td>{{$emp->emp_dob ? \Carbon\Carbon::parse($emp->emp_dob)->format('j F, Y') : '---'}}</td>
                               <td>{{ number_format($basicSalary,2) }}</td>
                               <td>{{ $emp->empAccountInfo?->HRA ?? 0 }}</td>
                               <td>{{ $emp->empAccountInfo?->MA ?? 0 }}</td>
                               <td>{{ $emp->empAccountInfo?->CV ?? 0 }}</td>
                               <td>{{ $emp->empAccountInfo?->FB ?? 0 }}</td>
                               <td>{{ $emp->empAccountInfo?->total_gross_salary ?? 0 }}</td>
                               <td>{{ $totalPresence }}</td>
                               <td>{{ $totalAbsence }}</td>
                               <td>{{ $totalLate }}</td>
                               <td>{{ $totalLeaveOfAbsence }}</td>
                               <td>{{ $totalWoh }}</td>
                               <td>{{ $totalHoliday }}</td>
                               <td>0</td>
                               <td>0</td>
                               <td>0</td>
                               <td>{{ number_format($deductionCost,2) }}</td>
                               <td>{{number_format($grossSalary - $deductionCost,2)}}</td>
                               <td>0</td>
                               <td>0</td>
                               <td>{{ $comType == 2 ? $totalHours.':'.$totalMinutes : $comTotalHours.':'.$comTotalMinutes }} h</td>
                               <td>{{ number_format($otRate,2) }}</td>
                               <td>{{ number_format($totalOvertimeCost,2) }}</td>
                               <td>0</td>
                               <td>{{ number_format($netSalary,2) }}</td>
                               <td></td>
                           </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="30" style="text-align:right"> Grand Total: </td>
                            <td>{{number_format($totalNetSalary,2)}}</td>
                            <td></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- End new Table  -->
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
