@extends('layouts.hrPayroll_dashboard')
@section('content')
  <style>
   
  </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content px-4 ">
            <div class="container">
                <div class="pt-3">

                  <div class="text-center">
                    <h3 class="text-uppercase font-weight-bold">Naba Crop Care</h3>
                    <p>Head office, Rajshahi, Bangladesh</p>
                  </div>

                </div>
                <div class="py-4 table-responsive">
                    <div class="text-center">
                        <h5 class="text-uppercase font-weight-bold">Worker Payslip Report</h5>
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
                           
                        }
                    
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
                   <div style="display: flex;flex-direction: row;"> 
                      <table border="1" width="100%" style="margin-right:5px;">
                          <tr style="text-align:center">
                            <td>বেতন স্লিপ</td>
                          </tr>
                          <tr>
                            <td width="100%" style="padding:2px;margin:2px">
                                <table width="100%">
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td width="25%">মাস</td>
                                      <td width="25%">: {{ \Carbon\Carbon::parse($fdate)->format('F, Y') }}</td>
                                      <td width="25%">গ্রেড</td>
                                      <td width="25%">: {{ $employee->emp_grade_info }}</td>
                                    </tr>
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td>কার্ড নং</td>
                                      <td>: {{ $employee->emp_punch_card_no }}</td>
                                      <td>পদবি</td>
                                      <td>: {{ $employee->designation?->designation_title }}</td>
                                    </tr>
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td>নাম</td>
                                      <td>: {{ $employee->emp_name }}</td>
                                      <td>শাখা</td>
                                      <td>: </td>
                                    </tr>
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td>যোগদানের তাং</td>
                                      <td>: {{ \Carbon\Carbon::parse($employee->emp_joining_date)->format('j F, Y') }}</td>
                                      <td>পেমেন্ট তারিখ</td>
                                      <td></td>
                                    </tr>
                                  </table>  
                            </td>
                          </tr>
                          <tr>
                            <td width="100%" style="padding:2px;margin:2px">
                                <table width="100%">
                                    <tr>
                                        <td style="text-align:left;font-weight: normal;font-size:14px;">বিস্তারিত</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align:right;padding-right:20px;font-weight: normal;font-size:14px;">টাকা</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align:left;font-weight: normal;font-size:14px;" width="75%">বেতনের গ্রেড অনুযায়ী বেসিক বেতন</td>
                                        <td width="2%">:</td>
                                        <td style="text-align:right;font-weight: normal;font-size:14px;" width="23%">{{ convertEnToBnNumber($employee->empAccountInfo?->basic_salary) }}</td>
                                    </tr>
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                        <td width="25%">বাসা ভাড়া</td>
                                        <td width="2%">:</td>
                                        <td width="23%">{{ convertEnToBnNumber($employee->empAccountInfo?->house_rent) }}</td>
                                        <td width="25%">চিকিৎসা ভাতা</td>
                                        <td width="2%">:</td>
                                        <td width="23%"  style="text-align:right;">{{ convertEnToBnNumber($employee->empAccountInfo?->MA) }}</td>
                                    </tr>
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                        <td width="25%">যাতায়াত ভাড়া</td>
                                        <td width="2%">:</td>
                                        <td width="23%">{{ convertEnToBnNumber($employee->empAccountInfo?->TA) }}</td>
                                        <td width="25%">খাদ্য ভাতা</td>
                                        <td width="2%">:</td>
                                        <td width="23%"  style="text-align:right;"></td>
                                    </tr>
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                        <td width="25%">পে ডে</td>
                                        <td width="2%">:</td>
                                        <td width="23%"></td>
                                        <td width="25%">উপস্থিত</td>
                                        <td width="2%">:</td>
                                        <td width="23%"  style="text-align:right;">{{ convertEnToBnNumber($employee->empAttendanceInfo()?->whereBetween('date',[$fdate , $tdate])->where('present',1)->count()) }}</td>
                                    </tr>
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                        <td width="25%">ছুটি</td>
                                        <td width="2%">:</td>
                                        <td width="23%">{{ convertEnToBnNumber($employee->leaveOfAbsences()?->whereDate('absent_from','>=',$fdate)->whereDate('absent_to','<=',$tdate)->where('status' , 1)->sum('leave_of_absent'))}}</td>
                                        <td width="25%">অনুপস্থিত</td>
                                        <td width="2%">:</td>
                                        <td width="23%"  style="text-align:right;">{{ convertEnToBnNumber($attendenceAbsence + $leaveAbsence) }}</td>
                                    </tr>
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                        <td width="25%"></td>
                                        <td width="2%"></td>
                                        <td width="23%"></td>
                                        <td width="25%">গ্রস</td>
                                        <td width="2%">:</td>
                                        <td width="23%"  style="text-align:right;">{{ convertEnToBnNumber($employee->empAccountInfo?->total_gross_salary) }}</td>
                                    </tr>
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                        <td width="25%"></td>
                                        <td width="2%"></td>
                                        <td width="23%"></td>
                                        <td width="25%">প্রোডাকশন উপার্জন</td>
                                        <td width="2%">:</td>
                                        <td width="23%"  style="text-align:right;"></td>
                                    </tr>
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                        <td width="25%"></td>
                                        <td width="2%"></td>
                                        <td width="23%"></td>
                                        <td width="25%">ভর্তুকি</td>
                                        <td width="2%">:</td>
                                        <td width="23%"  style="text-align:right;"></td>
                                    </tr>
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                        <td width="25%"></td>
                                        <td width="2%"></td>
                                        <td width="23%"></td>
                                        <td width="25%">প্রোডাকশন বোনাস</td>
                                        <td width="2%">:</td>
                                        <td width="23%"  style="text-align:right;"></td>
                                    </tr>
                                    <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                        <td width="25%"></td>
                                        <td width="2%"></td>
                                        <td width="23%"></td>
                                        <td width="25%">হলিডে বোনাস</td>
                                        <td width="2%">:</td>
                                        <td width="23%"  style="text-align:right;"></td>
                                    </tr>
                                    <tr style="font-size:14px;vertical-align: top;" width="100%">
                                        <td width="25%"></td>
                                        <td width="2%"></td>
                                        <td width="23%"></td>
                                        <td width="25%">মোট প্রদেয়</td>
                                        <td width="2%">:</td>
                                        <td width="23%"  style="text-align:right;">{{ convertEnToBnNumber($totalValue) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align:left;font-weight: normal;font-size:14px;" width="75%">কর্তন</td>
                                        <td width="2%">:</td>
                                        <td style="text-align:right;font-weight: normal;font-size:14px;" width="23%">{{ number_format($deductionTotalAmount) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align:left;font-weight: normal;font-size:14px;" width="75%">অগ্রিম</td>
                                        <td width="2%">:</td>
                                        <td style="text-align:right;font-weight: normal;font-size:14px;" width="23%"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align:left;font-weight: normal;font-size:14px;" width="75%">রেভিনিউ স্ট্যাম্প</td>
                                        <td width="2%">:</td>
                                        <td style="text-align:right;font-weight: normal;font-size:14px;" width="23%"></td>
                                    </tr>
                                   
                                    <tr style="font-weight: normal;font-size:14px;">
                                        <td width="25%">ওটি ঘ : {{ convertEnToBnNumber($totalHours.':'.$totalMinutes)  }} ঘন্টা </td>
                                        <td width="2%"></td>
                                        <td width="23%">ওটি রেট : {{ convertEnToBnNumber(number_format($otRate)) }} </td>
                                        <td width="25%">ওটি পরিমাণ</td>
                                        <td width="2%">:</td>
                                        <td width="23%"  style="text-align:right;">{{ convertEnToBnNumber(number_format($totalOvertimeCost , 2)) }}</td>
                                    </tr>
                                </table>
                            </td>
                         </tr>
                         <tr>
                            <td>
                            <table width="100%">
                                <tr>
                                <td colspan="4" style="text-align:right;font-size:14px;" width="75%">নেট পরিশোধযোগ্য</td>
                                <td width="2%">:</td>
                                <td style="text-align:right;font-size:14px;" width="23%">{{ convertEnToBnNumber($netValue) }}</td>
                            </tr>
                            </table>
                            </td>
                         </tr>
                         <tr>
                            <td>
                                <table width="100%">
                                    <tr style="height:80px">
                                        <td  style="text-align:center;font-size:14px;vertical-align: bottom;" width="50%">হিসাব বিভাগ</td>
                                        <td style="text-align:center;font-size:14px;vertical-align: bottom;" width="50%">গ্রাহকের স্বাক্ষর</td>
                                    </tr>
                                </table>
                            </td>
                         </tr>
                      </table>


                      <table border="1" width="100%" style="margin-right:5px;">
                        <tr style="text-align:center">
                          <td>বেতন স্লিপ</td>
                        </tr>
                        <tr>
                          <td width="100%" style="padding:2px;margin:2px">
                              <table width="100%">
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                    <td width="25%">মাস</td>
                                    <td width="25%">: {{ \Carbon\Carbon::parse($fdate)->format('F, Y') }}</td>
                                    <td width="25%">গ্রেড</td>
                                    <td width="25%">: {{ $employee->emp_grade_info }}</td>
                                  </tr>
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                    <td>কার্ড নং</td>
                                    <td>: {{ $employee->emp_punch_card_no }}</td>
                                    <td>পদবি</td>
                                    <td>: {{ $employee->designation?->designation_title }}</td>
                                  </tr>
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                    <td>নাম</td>
                                    <td>: {{ $employee->emp_name }}</td>
                                    <td>শাখা</td>
                                    <td>: </td>
                                  </tr>
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                    <td>যোগদানের তাং</td>
                                    <td>: {{ \Carbon\Carbon::parse($employee->emp_joining_date)->format('j F, Y') }}</td>
                                    <td>পেমেন্ট তারিখ</td>
                                    <td></td>
                                  </tr>
                                </table>  
                          </td>
                        </tr>
                        <tr>
                          <td width="100%" style="padding:2px;margin:2px">
                              <table width="100%">
                                  <tr>
                                      <td style="text-align:left;font-weight: normal;font-size:14px;">বিস্তারিত</td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td style="text-align:right;padding-right:20px;font-weight: normal;font-size:14px;">টাকা</td>
                                  </tr>
                                  <tr>
                                      <td colspan="4" style="text-align:left;font-weight: normal;font-size:14px;" width="75%">বেতনের গ্রেড অনুযায়ী বেসিক বেতন</td>
                                      <td width="2%">:</td>
                                      <td style="text-align:right;font-weight: normal;font-size:14px;" width="23%">{{ convertEnToBnNumber($employee->empAccountInfo?->basic_salary) }}</td>
                                  </tr>
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td width="25%">বাসা ভাড়া</td>
                                      <td width="2%">:</td>
                                      <td width="23%">{{ convertEnToBnNumber($employee->empAccountInfo?->house_rent) }}</td>
                                      <td width="25%">চিকিৎসা ভাতা</td>
                                      <td width="2%">:</td>
                                      <td width="23%"  style="text-align:right;">{{ convertEnToBnNumber($employee->empAccountInfo?->MA) }}</td>
                                  </tr>
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td width="25%">যাতায়াত ভাড়া</td>
                                      <td width="2%">:</td>
                                      <td width="23%">{{ convertEnToBnNumber($employee->empAccountInfo?->TA) }}</td>
                                      <td width="25%">খাদ্য ভাতা</td>
                                      <td width="2%">:</td>
                                      <td width="23%"  style="text-align:right;"></td>
                                  </tr>
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td width="25%">পে ডে</td>
                                      <td width="2%">:</td>
                                      <td width="23%"></td>
                                      <td width="25%">উপস্থিত</td>
                                      <td width="2%">:</td>
                                      <td width="23%"  style="text-align:right;">{{ convertEnToBnNumber($employee->empAttendanceInfo()?->whereBetween('date',[$fdate , $tdate])->where('present',1)->count()) }}</td>
                                  </tr>
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td width="25%">ছুটি</td>
                                      <td width="2%">:</td>
                                      <td width="23%">{{ convertEnToBnNumber($employee->leaveOfAbsences()?->whereDate('absent_from','>=',$fdate)->whereDate('absent_to','<=',$tdate)->where('status' , 1)->sum('leave_of_absent'))}}</td>
                                      <td width="25%">অনুপস্থিত</td>
                                      <td width="2%">:</td>
                                      <td width="23%"  style="text-align:right;">{{ convertEnToBnNumber($attendenceAbsence + $leaveAbsence) }}</td>
                                  </tr>
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td width="25%"></td>
                                      <td width="2%"></td>
                                      <td width="23%"></td>
                                      <td width="25%">গ্রস</td>
                                      <td width="2%">:</td>
                                      <td width="23%"  style="text-align:right;">{{ convertEnToBnNumber($employee->empAccountInfo?->total_gross_salary) }}</td>
                                  </tr>
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td width="25%"></td>
                                      <td width="2%"></td>
                                      <td width="23%"></td>
                                      <td width="25%">প্রোডাকশন উপার্জন</td>
                                      <td width="2%">:</td>
                                      <td width="23%"  style="text-align:right;"></td>
                                  </tr>
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td width="25%"></td>
                                      <td width="2%"></td>
                                      <td width="23%"></td>
                                      <td width="25%">ভর্তুকি</td>
                                      <td width="2%">:</td>
                                      <td width="23%"  style="text-align:right;"></td>
                                  </tr>
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td width="25%"></td>
                                      <td width="2%"></td>
                                      <td width="23%"></td>
                                      <td width="25%">প্রোডাকশন বোনাস</td>
                                      <td width="2%">:</td>
                                      <td width="23%"  style="text-align:right;"></td>
                                  </tr>
                                  <tr style="font-weight: normal;font-size:14px;vertical-align: top;" width="100%">
                                      <td width="25%"></td>
                                      <td width="2%"></td>
                                      <td width="23%"></td>
                                      <td width="25%">হলিডে বোনাস</td>
                                      <td width="2%">:</td>
                                      <td width="23%"  style="text-align:right;"></td>
                                  </tr>
                                  <tr style="font-size:14px;vertical-align: top;" width="100%">
                                      <td width="25%"></td>
                                      <td width="2%"></td>
                                      <td width="23%"></td>
                                      <td width="25%">মোট প্রদেয়</td>
                                      <td width="2%">:</td>
                                      <td width="23%"  style="text-align:right;">{{ convertEnToBnNumber($totalValue) }}</td>
                                  </tr>
                                  <tr>
                                      <td colspan="4" style="text-align:left;font-weight: normal;font-size:14px;" width="75%">কর্তন</td>
                                      <td width="2%">:</td>
                                      <td style="text-align:right;font-weight: normal;font-size:14px;" width="23%">{{ number_format($deductionTotalAmount) }}</td>
                                  </tr>
                                  <tr>
                                      <td colspan="4" style="text-align:left;font-weight: normal;font-size:14px;" width="75%">অগ্রিম</td>
                                      <td width="2%">:</td>
                                      <td style="text-align:right;font-weight: normal;font-size:14px;" width="23%"></td>
                                  </tr>
                                  <tr>
                                      <td colspan="4" style="text-align:left;font-weight: normal;font-size:14px;" width="75%">রেভিনিউ স্ট্যাম্প</td>
                                      <td width="2%">:</td>
                                      <td style="text-align:right;font-weight: normal;font-size:14px;" width="23%"></td>
                                  </tr>
                                 
                                  <tr style="font-weight: normal;font-size:14px;">
                                      <td width="25%">ওটি ঘ : {{ convertEnToBnNumber($totalHours.':'.$totalMinutes)  }} ঘন্টা </td>
                                      <td width="2%"></td>
                                      <td width="23%">ওটি রেট : {{ convertEnToBnNumber(number_format($otRate)) }} </td>
                                      <td width="25%">ওটি পরিমাণ</td>
                                      <td width="2%">:</td>
                                      <td width="23%"  style="text-align:right;">{{ convertEnToBnNumber(number_format($totalOvertimeCost , 2)) }}</td>
                                  </tr>
                              </table>
                          </td>
                       </tr>
                       <tr>
                          <td>
                          <table width="100%">
                              <tr>
                              <td colspan="4" style="text-align:right;font-size:14px;" width="75%">নেট পরিশোধযোগ্য</td>
                              <td width="2%">:</td>
                              <td style="text-align:right;font-size:14px;" width="23%">{{ convertEnToBnNumber($netValue) }}</td>
                          </tr>
                          </table>
                          </td>
                       </tr>
                       <tr>
                          <td>
                              <table width="100%">
                                  <tr style="height:80px">
                                      <td  style="text-align:center;font-size:14px;vertical-align: bottom;" width="50%">হিসাব বিভাগ</td>
                                      <td style="text-align:center;font-size:14px;vertical-align: bottom;" width="50%">গ্রাহকের স্বাক্ষর</td>
                                  </tr>
                              </table>
                          </td>
                       </tr>
                    </table>
                   </div>
                </div>
            </div>
        </div>
    </div>
@endsection
