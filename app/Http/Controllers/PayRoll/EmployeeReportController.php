<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use App\Models\LeaveOfAbsent;
use Illuminate\Support\Facades\DB;
use App\Models\EmployeeAttendance;
use Illuminate\Database\Eloquent\Builder;
use App\Models\EmployeePayment;

class EmployeeReportController extends Controller
{

    public function employeeFinalSettlementReportInput(){
       $employees = Employee::orderBy('id','desc')->get();
       return view('backend.payRoll.report.final_settlement_report_input',[
          'employees' => $employees
       ]);
    }  

    public function employeeFinalSettlementReport(Request $request){
        //    dd($request->all());
        $employees = Employee::with('empAccountInfo','empOtInfo','empAttendanceInfo')->whereIn('id',$request->employee)->get();
        $employeeInfo = [];

        foreach($employees as $employee){
            $totalHours = 0;
            $totalMinutes = 0;
            $empAttendanceInfo = $employee->empAttendanceInfo;
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
                // $totalSalary = 0;
                // $totalHours = 0;
                // $totalMinutes = 0;
                // if ($employee->empOtInfo) {
                //     foreach ($employee->empOtInfo as $overtime) {
                //         $overtimeMinutes = Carbon::parse($overtime->ovt_start)->diffInMinutes(Carbon::parse($overtime->ovt_end));
                //         $totalMinutes += $overtimeMinutes;
                //     }
                //     $totalHours = floor($totalMinutes / 60);
                //     $remainingMinutes = $totalMinutes % 60;
                // }
            

                // $totalOvertimeCost = ($totalHours + ($remainingMinutes / 60)) * $employee->empAccountInfo?->overtime_per_houre;
                
                $totalAmount = 0;
                if ($employee->empAttendanceInfo) {
                    $earnDay = 0;
                    foreach ($employee->empAttendanceInfo()->where('entry_time','<=','09:00')->get() as $empAttenddence) {
                        $earnDay = $empAttenddence->present/18;
                        $basicSalary = $employee->empAccountInfo?->basic_salary ?? 0;
                        if($basicSalary > 0){
                            $perDay = $basicSalary/30;
                            $totalAmount = $earnDay*$perDay;
                        } else {
                            $totalAmount = '';
                        }
                    }
                }

                $joiningDate = Carbon::createFromDate($employee->emp_joining_date);
                $currentDate = Carbon::now();
                $startYear = $joiningDate->year;
                $startMonth = $joiningDate->month;

                $endYear = $currentDate->year;
                $endMonth = $currentDate->month;

                $months = ($endYear - $startYear) * 12 + ($endMonth - $startMonth) + 1;
            

                // while ($joiningDate->lt($currentDate)) {
                //     $daysInMonth = $joiningDate->daysInMonth;
                //     $numDaysWorked = $currentDate->diffInDays($joiningDate->copy()->endOfMonth());
                //     $totalSalary += ($employee->empAccountInfo?->total_gross_salary / $daysInMonth) * $numDaysWorked;
                //     $joiningDate->addMonthNoOverflow();
                //     $joiningDate->startOfMonth();
                // }

                // $numFullMonths = $joiningDate->diffInMonths($currentDate);
                // $totalSalary += $employee->empAccountInfo?->total_gross_salary * $numFullMonths;

        

                
                $employeeInfo[] = [
                    'emp_name' => $employee->emp_name,
                    'total_gross_salary' => $employee->empAccountInfo?->total_gross_salary * $months,
                    'total_ot' => $totalOvertimeCost,
                    'total_loan' => $employee->empAccountInfo?->korje_hasana,
                    'accident_benefit' => $employee->empAccountInfo?->accident_benefit,
                    'earn_leave' => $totalAmount
                ];
        }
        //    return $employeeInfo;
       return view('backend.payRoll.report.final_settlement_report',[
            'employees' => $employeeInfo 
       ]);
    }

    public function employeeLeaveReportInput(){
        return view('backend.payRoll.report.emp_leave_report_input',[
          
        ]);
    }

    public function employeeLeaveReport(Request $request){
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

        $leaveOfAbsents =  LeaveOfAbsent::select('employee_id', DB::raw('SUM(leave_of_absent) as total_leave_of_absent'))
                                ->whereDate('absent_from','>=',$fdate)
                                ->whereDate('absent_to','<=',$tdate)
                                ->where('status' , 1)
                                ->groupBy('employee_id')
                                ->with(['employee']) 
                                ->get();
        return view('backend.payRoll.report.emp_leave_report',[
            'leaveOfAbsents' => $leaveOfAbsents,
            'fdate' => $fdate,
            'tdate' => $tdate
        ]);                        
    }

    public function employeeAttendenceJobReportInput(){
        $employees = Employee::orderBy('id','desc')->get();
        return view('backend.payRoll.report.emp_attendence_job_report_input',[
            'employees' => $employees
        ]);
    }

    public function employeeAttendenceJobReport(Request $request){
        
        
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
            $employeeAttendanceEmpId = EmployeeAttendance::whereBetween('date' , [ $fdate , $tdate])->pluck('employee_id')->toArray();
        }   

        if($request->employee){
            $employeeAttendanceEmpId = EmployeeAttendance::whereIn('employee_id',$request->employee)->whereBetween('date' , [ $fdate , $tdate])->pluck('employee_id')->toArray();
        }

        $employees = Employee::with(['empAttendanceInfo' , 'department' , 'designation'])->whereIn('id' , $employeeAttendanceEmpId)->get();
       
        return view('backend.payRoll.report.emp_attendence_job_report',[
            'employees' => $employees,
            'fdate' => $fdate,
            'tdate' => $tdate
        ]);    


    }

    public function employeePayslipReportInput(){
        $employees = Employee::orderBy('id','desc')->get();
        return view('backend.payRoll.report.emp_payslip_report_input',[
            'employees' => $employees
        ]);
    }

    public function employeePayslipReport(Request $request){
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }   
        $employee = Employee::with(['designation','empAccountInfo','empAttendanceInfo','leaveOfAbsences','ot'])->where('id',$request->employee)->first();
        return view('backend.payRoll.report.emp_payslip_report',[
            'fdate' => $fdate,
            'tdate' => $tdate,
            'employee' => $employee
        ]);    
    }

    public function employeeWorkerPayslipReportInput(){                         
        $employees = Employee::whereHas('empStaffCategory' , function(Builder $query){
                                    $query->where('staff_cate_title','Factory- production worker');
                                })->orderBy('id','desc')->get();                      
        return view('backend.payRoll.report.emp_worker_payslip_report_input',[   
            'employees' => $employees                                                   
        ]);                                                                      
    }   
    
    public function employeeWorkerPayslipReport(Request $request){
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }   
        $employee = Employee::with(['designation','empAccountInfo','empAttendanceInfo','leaveOfAbsences','ot'])->where('id',$request->employee)->first();

        return view('backend.payRoll.report.emp_worker_payslip_report',[
            'fdate' => $fdate,
            'tdate' => $tdate,
            'employee' => $employee
        ]);    
    }
    
    public function employeeWorkingReportInput(){
        $employees = Employee::orderBy('id','desc')->get();
        return view('backend.payRoll.report.emp_working_report_input',[
            'employees' => $employees
        ]);
    }

    public function employeeWorkingReport(Request $request){

        $employee = Employee::with(['designation','empAttendanceInfo'])->whereNotNull('id');
        $employee->whereHas('empAttendanceInfo');
        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
            $employee->whereHas('empAttendanceInfo' , function(Builder $query) use($fdate , $tdate){
                $query->whereBetween('date' , [$fdate , $tdate]);
            });
        }  
        
        if($request->employee){
            $employee->whereIn('id' , $request->employee); 
        }
        $employees = $employee->get();
        $employees->each(function ($employee) use ($fdate, $tdate) {
            $weekStartDate = new \DateTime($fdate);
            $weekEndDate = (new \DateTime($fdate))->modify('+5 days');
            $weekNumber = 1;
            $weeklyWorkingHours = [];
        
            while ($weekStartDate <= new \DateTime( $tdate)) {
                $totalWorkingHours = $employee->empAttendanceInfo
                    ->whereBetween('date', [$weekStartDate->format('Y-m-d'), $weekEndDate->format('Y-m-d')])
                    ->sum(function ($attendanceInfo) {
                        // Calculate the difference between entry_time and exit_time in hours
                        $entryTime = strtotime($attendanceInfo->entry_time);
                        $exitTime = strtotime($attendanceInfo->exit_time);
                        return ($exitTime - $entryTime) / 3600;
                    });
        
                $weeklyWorkingHours[] = [
                    'week_name' => 'week_' . $weekNumber,
                    'week_start' => $weekStartDate->format('Y-m-d'),
                    'week_end' => $weekEndDate->format('Y-m-d'),
                    'total_hours' => intval($totalWorkingHours),
                ];
        
                $weekStartDate->modify('+6 days');
                $weekEndDate->modify('+6 days');
                $weekNumber++;
                
                if ($weekEndDate->format('m') != $weekStartDate->format('m')) {
                    // Adjust the week end date to the last day of the current month
                    $weekEndDate->setDate($weekStartDate->format('Y'), $weekStartDate->format('m'), 1);
                    $weekEndDate->modify('last day of this month');
                }
            }
        
            $employee->weeklyWorkingHours = $weeklyWorkingHours;
        });
        // return  $employees;

        return view('backend.payRoll.report.emp_working_report',[
            'fdate' => $fdate,
            'tdate' => $tdate,
            'employees' => $employees
        ]);    
    }

    public function empSalaryreportInput(){
        $employees = Employee::orderby('emp_name','asc')->get();
        return view('backend.payRoll.report.emp_salary_report_input', compact('employees'));
    }

    public function empSalaryreport(Request $request){
        //dd($request->all());

        $employees = Employee::with(['designation','empAccountInfo','empAttendanceInfo','leaveOfAbsences','ot'])->whereNotNull('id');
        if(isset($request->date)) {
          $dates = explode(' - ', $request->date);
          $fdate = date('Y-m-d', strtotime($dates[0]));
          $tdate = date('Y-m-d', strtotime($dates[1]));
        } else {
          $fdate = date('Y-m-d');
          $tdate = date('Y-m-d');
        }
  
        if(isset($request->employee)){
          $employees = $employees ->whereIn('id',$request->employee);
        }

        $employees = $employees->orderBy('id','asc')->get();
        $comType = $request->type;
  
        return view('backend.payRoll.report.emp_salary_report',compact('fdate','tdate','employees','comType'));
      }
}
