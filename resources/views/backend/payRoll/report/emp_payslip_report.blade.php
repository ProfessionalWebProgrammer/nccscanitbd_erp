@extends('layouts.hrPayroll_dashboard')
@section('content')
  <style>
   
  </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container-fluid">
                <div class="pt-3">

                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Employee Payslip Report</h5>
                      	 <p>Date: {{ $fdate }} To {{ $tdate }}</p>
                        <hr>
                    </div>
                    @php
                        $totalHours = 0;
                        $totalMinutes = 0;
                        $empAttendanceInfo = $employee->empAttendanceInfo()->whereBetween('date',[$fdate ,$tdate])->get();
                        if ($empAttendanceInfo) {
                            foreach ($empAttendanceInfo as $attendence) {
                                if($attendence->entry_time && $attendence->exit_time){
                                    $entryTime = \Carbon\Carbon::createFromFormat('H:i', $attendence->entry_time);
                                    $exitTime = \Carbon\Carbon::createFromFormat('H:i', $attendence->exit_time);
                                    
                                    $timeDifference = $entryTime->diff($exitTime);
                                    if ($timeDifference->h >= 9) {
                                        // $timeDifference->subHours(8);
                                        $totalHours += $timeDifference->h - 9;
                                        $totalMinutes += $timeDifference->i;
                                    }
                                }
                                // $overtimeMinutes = \Carbon\Carbon::parse($overtime->entry_time)->diffInMinutes(\Carbon\Carbon::parse($overtime->exit_time));
                                // $totalMinutes += $overtimeMinutes;
                            }
                            if ($totalMinutes >= 60) {
                                $additionalHours = intdiv($totalMinutes, 60);
                                $totalHours += $additionalHours;
                                $totalMinutes = $totalMinutes % 60;
                            }
                            // $totalHours = floor($totalMinutes / 60);
                            // $remainingMinutes = $totalMinutes % 60;
                        }
                    
                        // $otPerchantage = ($totalHours + ($remainingMinutes / 60)) / 100;
                        if($employee->empAccountInfo?->overtime_per_houre > 0){
                            $otRate = $employee->empAccountInfo?->overtime_per_houre;
                        }else{
                            $otRate = (($employee->empAccountInfo?->total_gross_salary / 26) / 8);
                        }
                        $totalOvertimeCostHour = $totalHours * $otRate;
                        $totalOvertimeCostMinute = ($otRate / 60) * $totalMinutes;
                      
                        $totalOvertimeCost = $totalOvertimeCostHour + $totalOvertimeCostMinute;

                        $totalLateCount = $employee->empAttendanceInfo()?->whereBetween('date',[$fdate , $tdate])->where('late',1)->count();
                        $grossSalary = $employee->empAccountInfo?->total_gross_salary ?? 0;
                        $perDaySaly = $grossSalary  / 26;
                        
                        $deductionLate = ($totalLateCount / 3);
                        $deductionLateAmount = intVal($deductionLate) * $perDaySaly;
                        
                        $attendenceAbsence = $employee->empAttendanceInfo()?->whereBetween('date',[$fdate , $tdate])->where('present',0)->count();
                        $leaveAbsence = $employee->leaveOfAbsences()?->whereDate('absent_from','>=',$fdate)
                                                                        ->whereDate('absent_to','<=',$tdate)
                                                                        ->sum('leave_of_absent');

                        $deductionAbsence = $attendenceAbsence - $leaveAbsence;
                        if($deductionAbsence > 0){
                            $deductionAmount = $deductionAbsence * $perDaySaly;
                        }else{
                            $deductionAmount = 0;
                        }
                    
                        $deductionTotalAmount = $deductionLateAmount + $deductionAmount;
                        $totalValue = number_format($grossSalary,2);
                        $netValue = number_format(($grossSalary + $totalOvertimeCost) - $deductionTotalAmount , 2);
                    @endphp
                    <table id="table" style="border-style: dashed;border-collapse: collapse;" width="100%">
                        <tr>
                            <td style="border-left: dotted 2px;border-right: dotted 2px;padding:0px; vertical-align: top;" width="20%">
                                <table width="100%" style="margin-top:13px">
                                    <tr>
                                        <td width="100%" style="text-align:center" colspan="3">Date Leaf</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Name</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px">{{ $employee->emp_name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Card</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px">{{ $employee->emp_punch_card_no }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Designation</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px">{{ $employee->designation?->designation_title }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Bank</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px">{{ $employee->bank_ac_number }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Total Salary</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px">{{ $employee->empAccountInfo?->total_gross_salary }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Total Deduction</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ number_format($deductionAmount,2) }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Addition</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{  number_format($employee->empAccountInfo?->FB + $totalOvertimeCost,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">OT</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ number_format($totalOvertimeCost , 2) }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="border-left: dotted 2px; border-right: dotted 2px;padding:0px; vertical-align: top;" width="20%">
                                <table width="100%" style="margin-top:13px">
                                    <tr>
                                        <td colspan="3" style="text-align:center"><u>Personal Information</u></td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Name</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $employee->emp_name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Card</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $employee->emp_punch_card_no }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Designation</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $employee->designation?->designation_title }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Joining</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ \Carbon\Carbon::parse($employee->emp_joining_date)->format('j F, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Line No.</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">0</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Grade</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $employee->emp_grade_info }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="border-left: dashed 2px; border-right: dashed 2px;vertical-align: top;" width="15%">
                                <table width="100%" style="margin-top:13px">
                                    <tr>
                                        <td colspan="3" style="text-align:center"><u>Wages</u></td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Basic Salary</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $employee->empAccountInfo?->basic_salary }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">House Rent</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $employee->empAccountInfo?->house_rent }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Medical Fees</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $employee->empAccountInfo?->MA }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Transportation Fare</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $employee->empAccountInfo?->TA }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Food Allowance</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">empty</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">PF</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">empty</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Total Salary</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $employee->empAccountInfo?->total_gross_salary }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="border-left: dashed 2px; border-right: dashed 2px;vertical-align: top;" width="15%">
                                <table width="100%" style="margin-top:13px">
                                    <tr>
                                        <td colspan="3" style="text-align:center"><u>Attendance</u></td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Total Attendance</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $employee->empAttendanceInfo()?->whereBetween('date',[$fdate , $tdate])->where('present',1)->count() }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Total Leave</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $employee->leaveOfAbsences()?->whereDate('absent_from','>=',$fdate)->whereDate('absent_to','<=',$tdate)->where('status' , 1)->sum('leave_of_absent')}}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Total Absence</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $attendenceAbsence + $leaveAbsence }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Late Absence</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $totalLateCount }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Late In Month</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $totalLateCount }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">OT Hour</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                       
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ @$totalHours.':'.@$totalMinutes }} h</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">OT Rate</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ number_format( $otRate , 2) }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="border-left: dashed 2px; border-right: dashed 2px;vertical-align: top;" width="15%">
                                <table width="100%" style="margin-top:13px">
                                    <tr>
                                    <td colspan="3" style="text-align:center"><u>Deduction</u></td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Total Deduction</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ number_format($deductionAmount,2)  }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Stump Charge</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">0</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="border-left: dashed 2px; border-right: dashed 2px;vertical-align: top;" width="15%">
                                <table width="100%" style="margin-top:13px">
                                    <tr>
                                        <td colspan="3" style="text-align:center"><u>Total Payment</u></td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">OT</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{  number_format($totalOvertimeCost , 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Addition</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ number_format($employee->empAccountInfo?->FB + $totalOvertimeCost,2) }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Festival Allowance</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">{{ $employee->empAccountInfo?->FB }}</td>
                                    </tr>
                                    <tr>
                                        <td width="49%" style="padding-left:10px;font-weight: normal;font-size:14px;vertical-align: top;">Attendance Bonus</td>
                                        <td width="2%" style="vertical-align: top;">:</td>
                                        <td width="49%" style="text-align:right;padding-right:10px;font-weight: normal;font-size:14px;vertical-align: top;">0</td>
                                    </tr>
                                    <tr>
                                        <td width="100%" colspan="3"><hr style="height: 6px !important;"></td>
                                    </tr>
                                    
                                    <tr style="margin-top: 0px">
                                        <td width="90%" style="padding-left:10px;vertical-align: top;">Net Payment</td>
                                        <td width="1%" style="vertical-align: top;">:</td>
                                        <td width="9%" style="text-align:right;padding-right:10px;vertical-align: top;">{{ number_format(($employee->empAccountInfo?->total_gross_salary +  $totalOvertimeCost +  $employee->empAccountInfo?->FB) - $deductionAmount,2)}}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                       
                    </table>
                    <table width="100%" style="border-style: dashed;border-collapse: collapse;">
                        <tr>
                            <td width="20%"  style="padding:0px border-left: dotted 2px; border-right: dotted 2px;vertical-align: top;">
                                <table width="100%">
                                    <tr>
                                        <td width="50%" style="padding-left:10px">Net Payment</td>
                                        <td width="50%" style="text-align:right;padding-right:10px;">{{ number_format(($employee->empAccountInfo?->total_gross_salary +  $totalOvertimeCost +  $employee->empAccountInfo?->FB) - $deductionAmount,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td width="100%"></td>
                                    </tr>
                                    <tr>
                                        <td width="100%"></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" style="padding-left:10px">Recipient</td>
                                        <td width="50%" style="text-align:right;padding-right:10px;">Account</td>
                                    </tr>
                                </table>
                            </td>
                            <td width="80%" style="padding:0px">
                                <table width="100%">
                                    <tr>
                                        <td width="100%" style="padding-left:10px">Net Payment : {{ number_format(($employee->empAccountInfo?->total_gross_salary +  $totalOvertimeCost +  $employee->empAccountInfo?->FB) - $deductionAmount,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td width="100%"></td>
                                    </tr>
                                    <tr>
                                        <td width="100%"></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" style="padding-left:10px"></td>
                                        <td width="50%" style="text-align:right;padding-right:10px;">Account</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
