<?php

namespace App\Http\Controllers;

use App\Models\DealerArea;
use App\Models\DealerZone;
use App\Models\CommissionIn;
use App\Models\SalesCategory;
use App\Models\Lmcommisiontarget;
use App\Models\EmployeeReport;
use App\Models\Designation;
use App\Models\Department;
use App\Models\EmployeeAccount;
use App\Models\StaffCategory;
use App\Models\EmployeeAttendance;
use App\Models\LeaveOfAbsent;
use App\Models\EmployeeOvertime;
use App\Models\Employee;
use App\Models\MasterBank;
use App\Models\Payment_number;
use App\Models\ExpanseSubgroup;
use App\Models\EmployeeTeam;
use App\Models\EmployeePayment;
use App\Models\EmployeeIdCard;
use App\Models\Payment;
use App\Models\MasterCash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Models\Payroll\EmployeeLeavePolicySystem;

class EmployeeController extends Controller
{
    public function employeeManagementList(){
      return view('backend.employee.employeeManagementIndex');
    }
    public function extendedPimIndex(){
      $employeeData = Employee::get();
      return view('backend.employee.employeeRxtendedList', compact('employeeData'));
    }
    public function index()
    {
        $employeeData = Employee::orderby('emp_name','asc')->get();
        return view('backend.employee.employeelist', compact('employeeData'));
    }

  	public function deleteEmployee(Request $request)
    {
    	//dd($request->all());
      Employee::where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Employee Deleted Successfull');
    }
    public function createEmployee()
    {
        /* $dealerArea = DealerArea::all();
        $dealerZone = DealerZone::all(); */
        $designation = Designation::all();
        $department = Department::all();
        $staffcategory = StaffCategory::all();

        return view('backend.employee.employeecreate', compact('designation','department','staffcategory'));
    }

    public function storeEmployee(Request $request)
    {
      //dd($request->all());
        $employees = new Employee();
        $employees->emp_name = $request->emp_name;
        $employees->emp_mobile_number = $request->emp_mobile_number;
        $employees->emp_joining_date = $request->emp_joining_date;
        $employees->emp_punch_card_no = $request->emp_punch_card_no;
        $employees->emp_designation_id = $request->emp_designation_id;
        $employees->yearly_holiday = $request->yearly_holiday;
        $employees->emp_department_id = $request->emp_department_id;
        $employees->emp_staff_category_id = $request->emp_staff_category_id;

      	$employees->emp_dob = $request->emp_dob;
      	$employees->emp_age = $request->emp_age;
        $employees->emp_gender = $request->emp_gender;
        $employees->emp_merital_status = $request->emp_merital_status;
        $employees->emp_nid_card = $request->emp_nid_card;
        $employees->emp_spouse_name = $request->emp_spouse_name;
        $employees->emp_mobile_number = $request->emp_mobile_number;
        $employees->emp_nationality = $request->emp_nationality;
        $employees->emp_religion = $request->emp_religion;

        $employees->emp_father_name = $request->emp_father_name;
        $employees->emp_mother_name = $request->emp_mother_name;
        $employees->emp_blood_group = $request->emp_blood_group;


        $employees->emp_mail_id = $request->emp_mail_id;
        // $employees->emp_zone = $request->emp_zone;
        // $employees->emp_area = $request->emp_area;

        $employees->bank_name = $request->bank_name;
        $employees->bank_ac_number = $request->bank_ac_number;


     //	 $employees->emp_salary = $request->emp_salary;
      //  $employees->emp_bonus = $request->emp_bonus;
      //  $employees->emp_work_hour = $request->emp_work_hour;
      //  $employees->emp_overtime = $request->emp_overtime;

      	$employees->emp_present_address = $request->emp_present_address;
        $employees->emp_parmanent_address = $request->emp_parmanent_address;
        $employees->save();

        return redirect()->back()->with('success', 'Employee Create Successfull');
    }

    public function editEmployee($id)
    {
        $employeeData = Employee::where('id', $id)->first();
        // $dealerArea = DealerArea::all();
        // $dealerZone = DealerZone::all();
      	$designation = Designation::all();
        $department = Department::all();

        return view('backend.employee.employeeEdit', compact('employeeData', 'designation','department'));
    }
    public function updateEmployee(Request $request, $id)
    {
        $employees = Employee::where('id', $id)->first();
        $employees->emp_name = $request->emp_name;
        $employees->emp_mobile_number = $request->emp_mobile_number;
        $employees->emp_joining_date = $request->emp_joining_date;
        $employees->emp_punch_card_no = $request->emp_punch_card_no;
        $employees->emp_designation_id = $request->emp_designation_id;
      	$employees->yearly_holiday = $request->yearly_holiday;
        $employees->emp_department_id = $request->emp_department_id;
        $employees->emp_staff_category_id = $request->emp_staff_category_id;

      	$employees->emp_dob = $request->emp_dob;
        $employees->emp_age = $request->emp_age;
        $employees->emp_gender = $request->emp_gender;
        $employees->emp_merital_status = $request->emp_merital_status;
        $employees->emp_nid_card = $request->emp_nid_card;
        $employees->emp_spouse_name = $request->emp_spouse_name;
        $employees->emp_mobile_number = $request->emp_mobile_number;
        $employees->emp_nationality = $request->emp_nationality;
        $employees->emp_religion = $request->emp_religion;

        $employees->emp_father_name = $request->emp_father_name;
        $employees->emp_mother_name = $request->emp_mother_name;
        $employees->emp_blood_group = $request->emp_blood_group;

		    $employees->bank_name = $request->bank_name;
        $employees->bank_ac_number = $request->bank_ac_number;

        $employees->emp_mail_id = $request->emp_mail_id;
        // $employees->emp_zone = $request->emp_zone;
        // $employees->emp_area = $request->emp_area;

       $employees->emp_salary = $request->emp_salary;
      //  $employees->emp_bonus = $request->emp_bonus;
      //  $employees->emp_work_hour = $request->emp_work_hour;
      //  $employees->emp_overtime = $request->emp_overtime;

      $employees->emp_present_address = $request->emp_present_address;
        $employees->emp_parmanent_address = $request->emp_parmanent_address;

        $employees->save();

        return redirect()->Route('employee.list')->with('success', 'Employee Update Successffull');
    }

    public function targetSetIndex()
    {
        $lmtarget = DB::table('lmcommisiontargets')
        ->leftjoin('sales_categories', 'lmcommisiontargets.category_id', '=', 'sales_categories.id')
        ->leftjoin('dealer_areas', 'lmcommisiontargets.employe_area_id', '=', 'dealer_areas.id')

        ->leftjoin('employees', 'lmcommisiontargets.emp_id', '=', 'employees.id')
         ->get();
//$lmtargets=$lmtarget->unique('emp_id')->all();
$lmtargets =  DB::select('SELECT DISTINCT YEAR(from_date) AS "Year", MONTH(from_date) AS "Month", emp_id,from_date,employees.emp_name,dealer_areas.area_title FROM lmcommisiontargets
                LEFT JOIN dealer_areas on dealer_areas.id = lmcommisiontargets.employe_area_id
                LEFT JOIN employees on employees.id = lmcommisiontargets.emp_id  order by from_date desc');
//dd($lmt);

//dd($lmtargets);
       return view('backend.employee.target_set_index',compact('lmtargets'));
    }

    public function targetSetcreate()
    {
         $emps   =   Employee::latest('id')->get();
        $commission_inc = CommissionIn::latest('id')->get();
        $categorys = SalesCategory::latest('id')->get();
        $zones = DealerZone::latest('id')->get();

        $areas = DealerArea::latest('id')->get();
        return view('backend.employee.target_set_create',compact('areas','zones','emps','commission_inc','categorys'));

    }

    public function targetSetStore(Request $request)
    {
   // dd($request->all());

    $urerid = Auth::id();

    $from_date = $request->month."-01";
    $to_date = date("Y-m-t", strtotime($from_date));
    //dd($to_date);
     foreach($request->target_amount as  $key => $target_amount){

        $lineman = new Lmcommisiontarget;
        $lineman->emp_id = $request->emp_id;
        $lineman->target_amount = $target_amount;
        // $lineman->achieve_commistion = $request->achieve_commistion;
        $lineman->category_id = $request->category_id[$key];
        $lineman->employe_zone_id = $request->employe_zone_id;
        $lineman->employe_area_id = $request->employe_area_id;
        $lineman->from_date = $from_date;
        $lineman->to_date = $to_date;
        // $lineman->description = $request->description;
        $lineman->created_by = $urerid;
        $lineman->save();

     }
      return redirect()->route('employee.target.set.index')
                        ->with('success', 'Target Set successfully .');

    }


    public function targetSetView(Request $request)
    {
  // dd($request->all());
    $lmtats = DB::select('SELECT employees.emp_name,sales_categories.category_name,lmcommisiontargets.emp_id,lmcommisiontargets.id,lmcommisiontargets.target_amount,lmcommisiontargets.achieve_commistion,lmcommisiontargets.from_date,lmcommisiontargets.to_date,lmcommisiontargets.active_status FROM `lmcommisiontargets`
        LEFT JOIN employees on employees.id = lmcommisiontargets.emp_id
        LEFT JOIN sales_categories on sales_categories.id = lmcommisiontargets.category_id ');

        $lmtargets = DB::table('lmcommisiontargets')
        			->select('lmcommisiontargets.*','sales_categories.category_name')
        			->leftjoin('sales_categories', 'lmcommisiontargets.category_id', '=', 'sales_categories.id')
					->where('emp_id',$request->mr_id)
       				->where('from_date',$request->target_month)
                    ->get();

       // dd($lmtargets);
        return view('backend.employee.target_set_view',compact('lmtargets'));

    }


  public function designationIndex()
    {
       $designations = Designation::orderBy('id','desc')->get();

        return view('backend.employee.designation',compact('designations'));
    }

   public function designationStore(Request $request)
    {
       // dd($request);
           $designations = new Designation();
        $designations->designation_title = $request->designation_title;
        // dd($categorys);
        $designations->save();
        return redirect()->route('employee.designation.create')->with('success',' Create Successful');
    }

  public function departmentsIndex()
    {
       $departments = Department::orderBy('id','desc')->get();

        return view('backend.employee.departments',compact('departments'));
    }

   public function departmentsStore(Request $request)
    {
       // dd($request);
           $departments = new Department();
        $departments->department_title = $request->department_title;
        // dd($categorys);
        $departments->save();
        return redirect()->route('employee.departments.create')->with('success',' Create Successful');
    }



   public function stafcategoryIndex()
    {
       $stafcategory = StaffCategory::orderBy('id','desc')->get();

        return view('backend.employee.stafcategory',compact('stafcategory'));
    }

   public function stafcategoryStore(Request $request)
    {
       // dd($request);
           $stafcategory = new StaffCategory();
        $stafcategory->staff_cate_title = $request->staff_cate_title;
        // dd($categorys);
        $stafcategory->save();
        return redirect()->route('employee.stafcategory.create')->with('success',' Create Successful');
    }


   public function accountssetIndex($id)
    {
        $employeeData = Employee::where('id', $id)->first();
        $dealerArea = DealerArea::all();
        $dealerZone = DealerZone::all();

     $employeeac = EmployeeAccount::where('emp_id', $id)->first();

     $emp_id = $id;

        return view('backend.employee.employeeAccountsView', compact('employeeData','employeeac','emp_id'));
    }

   public function accountssetedit($id)
    {
        $employeeData = Employee::where('id', $id)->first();
        $dealerArea = DealerArea::all();
        $dealerZone = DealerZone::all();

     $employeeac = EmployeeAccount::where('emp_id', $id)->first();

     $emp_id = $id;

        return view('backend.employee.employeeAccountsSetting', compact('employeeData', 'dealerArea', 'dealerZone','employeeac','emp_id'));
    }
    public function accountssetStore(Request $request)
    {
     $data = EmployeeAccount::where('emp_id', $request->emp_id)->first();
      if($data != null){

      $employees = EmployeeAccount::where('emp_id', $request->emp_id)->first();
      }else{
      $employees = new EmployeeAccount();
      }
        $employees->emp_id = $request->emp_id;
        $employees->basic_salary = $request->basic_salary;
        $employees->work_houre = $request->work_houre;
        $employees->overtime_per_houre = $request->overtime_per_houre;
        $employees->MA = $request->MA;
        $employees->HRA = $request->HRA;
        $employees->PB = $request->PB;
        $employees->DA = $request->DA;
        $employees->TA = $request->TA;
        $employees->FB = $request->FB;
        $employees->CA = $request->CA;
        $employees->CV = $request->CV;
        $employees->Tax = $request->Tax;
        $employees->net_salary = $request->net_salary;
        $employees->fuel_cost = $request->fuel_cost;
        $employees->out_station = $request->out_station;
        $employees->arrears = $request->arrears;
        $employees->others_deduction = $request->others_deduction;
        $employees->mc_install = $request->mc_install;
        $employees->korje_hasana = $request->korje_hasana;
        $employees->loan_deduction = $request->loan_deduction;
        $employees->house_rent = $request->house_rent;
        $employees->EPF_amount = $request->EPF_amount;
        // $employees->EPF = $request->EPF;
        $employees->net_salary_after_EPF = $request->net_salary_after_EPF;
        $employees->accident_benefit = $request->accident_benefit;
        $employees->total_gross_salary = $request->total_gross_salary;
        $employees->save();

        if($employees->save()){
       return redirect()->Route('employee.list')->with('success', 'Employee Accounts Data Store Successffull');
     }
    }

    public function employeeTimeAttendance(){
      return view('backend.employee.employeeTimeAttendance');
    }

  	public function employeeattendance()
    {
      $employee =  Employee::all();

      return view('backend.employee.employeeattendance',compact('employee'));
    }

    public function employeeattendanceStore(Request $request)
      {

      // $d = date('Y-m-d');
      // if($d == $request->date){
      //   dd($d);
      // }
      // foreach ($request->emp_id as $key => $value) {
      //   dump($value);
      // }
      // dd("okay");
        foreach ($request->emp_id as $key => $value) {
            $ifExit = EmployeeAttendance::where('employee_id',$request->emp_id[$key])->whereDate('date',$request->date)->first();
            if($ifExit){

            }else{
              if ($request->entry_time[$key] != null) {
                $entrytime = \Carbon\Carbon::createFromFormat('H:i', $request->entry_time[$key]);
                $fixtime = \Carbon\Carbon::createFromFormat('H:i', '08:15');

                  if($entrytime > $fixtime){
                          $lateday =1;
                  }else{
                      $lateday =0;
                  }
            } else {

              $lateday =0;
            }


     
        if('17:00' < $request->exit_time[$key]){
          $startTime = Carbon::parse('17:00');
          $endTime = Carbon::parse($request->exit_time[$key]);
          $overTime = date("g.i",strtotime($startTime->diff($endTime)->format('%H:%I:%S'))) ;
        } else {
          $overTime = 0;
        }

        $empatt = new EmployeeAttendance();
        $empatt->employee_id = $request->emp_id[$key];
        $empatt->department_id = Employee::where('id',$request->emp_id[$key])->value('emp_department_id');
        $empatt->entry_time = $request->entry_time[$key];
        $empatt->break_time = $request->break_time[$key];
        $empatt->break_back_time = $request->break_back_time[$key];
        $empatt->exit_time = $request->exit_time[$key];

        $empatt->overTime = $overTime;
        $empatt->date = $request->date;
        $empatt->present = $request->present[$value];
        if($request->present[$value] == 0){
          $empatt->absent = 1;
        }
        $empatt->late = $lateday;
        $empatt->status = 1;
        $empatt->save();

            }
        }
        return redirect()->back()->with('success', 'Employee Attebdance Successffull');
      }

  	public function employeeattendanceList()
    {
      //dd("List Route");
      return view('backend.employee.eattenndancelist');
    }

  	public function viewattendance(Request $request)
    {
    //dd($request->all());
              /*  if(isset($request->year)){
                  $lists = EmployeeAttendance::whereYear('date', $request->year)->get();
                } elseif(isset($request->monthYear)){
                  $mY = explode('-', $request->monthYear);
                  $lists = EmployeeAttendance::whereMonth('date',$mY[1])->whereYear('date', $mY[0])->get();
                } else
                */

                if(isset($request->date)) {
                  $dates = explode(' - ', $request->date);
                  $fdate = date('Y-m-d', strtotime($dates[0]));
                  $tdate = date('Y-m-d', strtotime($dates[1]));
                  $lists = EmployeeAttendance::whereBetween('date',[$fdate,$tdate])->get();
                } else {
                  $lists = EmployeeAttendance::where('date',date('Y-m-d'))->get();
                }

                $date = date('Y-m-d');

      return view('backend.employee.eattendaneceview',compact('lists','date'));
    }

    public function employeeovertime()
    {
      $employee =  Employee::all();
      return view('backend.employee.employeeovertime',compact('employee'));
    }

  	public function employeeovertimestore(Request $request)
    {
      //dd($request->all());
      foreach($request->emp_id as $key => $value){
        if($request->ovt_start[$key] != null){

        	$overtimedata = new EmployeeOvertime();
        	$overtimedata->employee_id = $request->emp_id[$key];
        	$overtimedata->date = $request->date;
        	$overtimedata->ovt_start = $request->ovt_start[$key];
        	$overtimedata->ovt_end = $request->ovt_end[$key];
        	$overtimedata->save();

        }
      }
      return redirect()->back()->with('success', 'Overtime Submited Successffull');
    }
     public function employeeOverTimeList(Request $request){
     $overTimeEmployees = EmployeeOvertime::orderby('date','asc')->get();
    return view('backend.employee.employeeOverTimeList',compact('overTimeEmployees'));
    }


    public function employeeOverTimeView(Request $request){

        if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }
        $overTimeEmployees = EmployeeOvertime::whereBetween('date',[$fdate,$tdate])->get();
        return view('backend.employee.employeeOverTimeView',compact('overTimeEmployees','fdate','tdate'));
    }



  	public function leaveofabsentform()
    {
     $employee =  Employee::all();
     $employeeLeavePolicySystems = EmployeeLeavePolicySystem::all();
     return view('backend.employee.leave_of_absent_form',compact('employee','employeeLeavePolicySystems'));
    }

  public function leaveofabsentstore(Request $request)
  {

    if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));
        }

	$period = CarbonPeriod::create($fdate, $tdate);
    $daycount =0;
    foreach ($period as $date) {
      $daycount++;
            // $empatt = new EmployeeAttendance();
            // $empatt->employee_id = $request->employee_id;
            // $empatt->date = $date->format('Y-m-d');
            // $empatt->leave_of_absent = 1;
            // $empatt->absent = 1;

            // $empatt->save();
    }
    $absentdata = new LeaveOfAbsent();
    $absentdata->employee_id = $request->employee_id;
    $absentdata->absent_from = $fdate;
    $absentdata->absent_to =  $tdate;
    $absentdata->leave_of_absent =  $daycount;
    $absentdata->description = $request->description;
    $absentdata->exceed_fine_amount = $request->fine_amount;
    $absentdata->per_day = $request->per_day;
    $absentdata->employee_leave_policy_id = $request->employee_leave_policy_id;
    $absentdata->save();


  	return redirect()->back()->with('success', 'Leave Of Absent Submited Successffull');
  }
  public function leaveofabsentIndex()
  {
     $lofabsents = LeaveOfAbsent::with(['employeeLeavePolicySystem','employee'])->orderBy('status','asc')->get();
    //  return  $lofabsents;
     return view('backend.employee.leave_of_absent_list',compact('lofabsents'));

  }
  public function monthlysalaryandattendanceReport()
  {
    $employee =  Employee::orderBy('emp_name', 'asc')->get();
  	return view('backend.employee.monthly_salary_and_attendance_report',compact('employee'));
  }

    public function monthlysalaryandattendanceReportVew(Request $request)
  {
      //dd($request->all());
      //if (isset($request->date)) {
          //  $dates = explode(' - ', $request->date);
          //  $fdate = date('Y-m-d', strtotime($dates[0]));
           // $tdate = date('Y-m-d', strtotime($dates[1]));
       // }
    $fdate = $request->month . "-01";
    $tdate = date("Y-m-t", strtotime($request->month));

    $period = CarbonPeriod::create($fdate, $tdate);
    $daycount =0;
    foreach ($period as $date) {
      $daycount++;
    }
    if (isset($request->employee_id)) {
      $fempid = $request->employee_id;
      $emp_acc = EmployeeAccount::where('emp_id',$fempid)->get();
    }else{
      	$emp_acc = EmployeeAccount::get();
    }
      //dd($daycount);
  	return view('backend.employee.monthly_salary_and_attendance_report_view',compact('emp_acc','fdate','tdate','daycount'));
  }



    public function employeesalarygetamount($emp_id,$month)
  {

      		$fdate = $month . "-01";
            //$tdate = $request->month_year."-31";
            $tdate = date("Y-m-t", strtotime($month));


    //  return response($tdate);

     $emp =  DB::table('employee_accounts')->where('emp_id',$emp_id)->first();


      						$employee = DB::table('employees')
                                          ->select('employees.*','designations.designation_title')
                                          ->leftJoin('designations','designations.id','employees.emp_designation_id')
                                          ->where('employees.id',$emp->emp_id)
                                          ->orderBy('emp_name','asc')
                                          ->first();


                          		$totalpresent = DB::table('employee_attendances')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('employee_id',$emp_id)
                          					->where('present',1)
                          					->count('id');
                          		$totalabsent = DB::table('employee_attendances')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('employee_id',$emp_id)
                          					->where('absent',1)
                          					->count('id');
                          		$totallofa = DB::table('employee_attendances')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('employee_id',$emp_id)
                          					->where('leave_of_absent',1)
                          					->count('id');
                          		$totalholyday = DB::table('employee_attendances')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('employee_id',$emp_id)
                          					->where('holyday',1)
                          					->count('id');



                          	$epfb = DB::table('employee_other_amounts')
                          				->where('month',date('Y-m', strtotime($fdate)))
                          				->where('emp_id',$emp_id)
                          				->where('type',"PerformanceB")
                          				->sum('amount');



                          $eholidayamount = DB::table('employee_other_amounts')
                          				->where('month',date('Y-m', strtotime($fdate)))
                          				->where('emp_id',$emp_id)
                          				->where('type',"Holiday")
                          				->sum('amount');
                          $eadvance = DB::table('employee_other_amounts')
                          				->where('month',date('Y-m', strtotime($fdate)))
                          				->where('emp_id',$emp_id)
                          				->where('type',"Advance")
                          				->sum('amount');


                          		$fineday = $totalabsent - $totallofa;
                          		$findfineamount = DB::table('leave_of_absents')
                          			->where('employee_id',$emp_id)
                          			->orderBy('id','desc')
                          			->first();

                          		if($findfineamount){
                          			$fineamount = $findfineamount->exceed_fine_amount;
                          			$totalfineamount =$fineday*$fineamount;
                          		}else{
                          			$totalfineamount =0;
                          		}


                          		$entrytime = \Carbon\Carbon::createFromFormat('H:i', '3:30');
                                $exittime = \Carbon\Carbon::createFromFormat('H:i', '4:32');

                                $diff_in_hours = $exittime->diffInHours($entrytime);
                                $diff_in_minutes = $exittime->diffInMinutes($entrytime);

                          		$period = \Carbon\CarbonPeriod::create($fdate, $tdate);
                          		$totalmunite = 0;

                                foreach ($period as $date) {
                          			$odate = date('Y-m-d',strtotime($date));
                                    $overtime = DB::table('employee_overtimes')
                          					->where('employee_id',$emp_id)
                          					->where('date',$odate)
                          					->first();
                          			if($overtime){
                                      $entrytime = \Carbon\Carbon::createFromFormat('H:i', $overtime->ovt_start);
                                      $exittime = \Carbon\Carbon::createFromFormat('H:i', $overtime->ovt_end);

                                      $diff_in_hours = $exittime->diffInHours($entrytime);
                                      $diff_in_minutes = $exittime->diffInMinutes($entrytime);

                                      $totalmunite += $diff_in_minutes;
                                     }
                                }

      						//late fine code start
                              $entrytime = DB::table('employee_attendances')
                                              ->where('employee_id',$emp->emp_id)
                                              ->whereBetween('date',[$fdate, $tdate])
                                              ->orderby('date','asc')
                                              ->get();
                              //dd($entrytime);
                              $latetotal = 0;
                              $lateday = 0;
                                foreach ($entrytime as $key => $data) {

                          			if($data->late_status == 1){
                                      	$lateday += 1;
                                     } else{
                          				$lateday = 0;
                          			 }

                         		 		if($lateday >= 3){
                                            	$latetotal += 1;
                          			   }
                             	}
                         	$emp_perdaysalary = round($emp->net_salary_after_EPF/30);
                        	$totallatefineamount = $latetotal*$emp_perdaysalary;
                          //late fine code end

                          		$overtimehour = $totalmunite/60;
                          		$overtimeamount = $emp->overtime_per_houre*$overtimehour;
                          		$netsalary = $emp->net_salary_after_EPF;

      							$finalfine= $totallatefineamount+$totalfineamount;
                         	 	//$finalnetsalary = $netsalary+$overtimeamount - $finalfine + $epfb + $eholidayamount - $eadvance;

                          		$finalnetsalary = $netsalary+$overtimeamount - $finalfine + $epfb + $eholidayamount - $eadvance;

      	$payments = DB::table('employee_payments')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('emp_id',$emp->emp_id)
                          					->sum('payment_amount');

                          $balancee= $finalnetsalary-$payments;

  	return response(round($balancee));
  }

   public function employeePayRollList()
  {
  	return view('backend.employee.employeePayRollList');
  }

   public function employeesalarypaylist()
  {
    $datas =  EmployeePayment::orderby('id','desc')->get();
  	return view('backend.employee.employee_salary_pay_list', compact('datas'));
  }

  public function deleteemployeepay(Request $request)
  {
    EmployeePayment::where('invoice',$request->invoice)->delete();
    Payment::where('invoice',$request->invoice)->delete();
    return redirect()->back()->with('success','Employee Payment Delete Successfull !');
  }

  public function vewsalarypaysleep($invoice)
  {
    $payinfo = EmployeePayment::where('invoice',$invoice)->first();
    //dd($payinfo->emp_id);
    $empaccinfo = EmployeeAccount::where('emp_id',$payinfo->emp_id)->first();

    $fdate = $payinfo->month . "-01";
            //$tdate = $request->month_year."-31";
    $tdate = date("Y-m-t", strtotime($payinfo->month));


    //  return response($tdate);


      						$employee = DB::table('employees')
                                          ->select('employees.*','designations.designation_title')
                                          ->leftJoin('designations','designations.id','employees.emp_designation_id')
                                          ->where('employees.id',$payinfo->emp_id)
                                          ->orderBy('emp_name','asc')
                                          ->first();


                          		$totalpresent = DB::table('employee_attendances')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('employee_id',$payinfo->emp_id)
                          					->where('present',1)
                          					->count('id');
                          		$totalabsent = DB::table('employee_attendances')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('employee_id',$payinfo->emp_id)
                          					->where('absent',1)
                          					->count('id');
                          		$totallofa = DB::table('employee_attendances')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('employee_id',$payinfo->emp_id)
                          					->where('leave_of_absent',1)
                          					->count('id');
                          		$totalholyday = DB::table('employee_attendances')
                          					->whereBetween('date', [$fdate, $tdate])
                          					->where('employee_id',$payinfo->emp_id)
                          					->where('holyday',1)
                          					->count('id');



                          	$epfb = DB::table('employee_other_amounts')
                          				->where('month',date('Y-m', strtotime($fdate)))
                          				->where('emp_id',$payinfo->emp_id)
                          				->where('type',"PerformanceB")
                          				->sum('amount');



                          $eholidayamount = DB::table('employee_other_amounts')
                          				->where('month',date('Y-m', strtotime($fdate)))
                          				->where('emp_id',$payinfo->emp_id)
                          				->where('type',"Holiday")
                          				->sum('amount');
                          $eadvance = DB::table('employee_other_amounts')
                          				->where('month',date('Y-m', strtotime($fdate)))
                          				->where('emp_id',$payinfo->emp_id)
                          				->where('type',"Advance")
                          				->sum('amount');


                          		$fineday = $totalabsent - $totallofa;
                          		$findfineamount = DB::table('leave_of_absents')
                          			->where('employee_id',$payinfo->emp_id)
                          			->orderBy('id','desc')
                          			->first();

                          		if($findfineamount){
                          			$fineamount = $findfineamount->exceed_fine_amount;
                          			$totalfineamount =$fineday*$fineamount;
                          		}else{
                          			$totalfineamount =0;
                          		}


                          		$entrytime = \Carbon\Carbon::createFromFormat('H:i', '3:30');
                                $exittime = \Carbon\Carbon::createFromFormat('H:i', '4:32');

                                $diff_in_hours = $exittime->diffInHours($entrytime);
                                $diff_in_minutes = $exittime->diffInMinutes($entrytime);

                          		$period = \Carbon\CarbonPeriod::create($fdate, $tdate);
                          		$totalmunite = 0;

                                foreach ($period as $date) {
                          			$odate = date('Y-m-d',strtotime($date));
                                    $overtime = DB::table('employee_overtimes')
                          					->where('employee_id',$payinfo->emp_id)
                          					->where('date',$odate)
                          					->first();
                          			if($overtime){
                                      $entrytime = \Carbon\Carbon::createFromFormat('H:i', $overtime->ovt_start);
                                      $exittime = \Carbon\Carbon::createFromFormat('H:i', $overtime->ovt_end);

                                      $diff_in_hours = $exittime->diffInHours($entrytime);
                                      $diff_in_minutes = $exittime->diffInMinutes($entrytime);

                                      $totalmunite += $diff_in_minutes;
                                     }
                                }
    						if($overtime){
                          		$overtimehour = $totalmunite/60;
                          		$overtimeamount = $empaccinfo->overtime_per_houre*$overtimehour;

                              }
                            else {
                            $overtimeamount = 0;
                            $netsalary = $empaccinfo->net_salary_after_EPF;
                            }

                          		$finalnetsalary = $netsalary+$overtimeamount - $totalfineamount + $epfb + $eholidayamount - $eadvance;

    							$tax = ($netsalary*$empaccinfo->Tax)/100 ? ($netsalary*$empaccinfo->Tax)/100 : 0;

    //dd($empaccinfo);
  	return view('backend.employee.employee_salary_pay_sleep',compact('empaccinfo','payinfo','eadvance','totalfineamount','tax','netsalary','finalnetsalary'));
  }

  public function employeesalarypaymentcreate()
  {
    $allcashs = MasterCash::orderBy('wirehouse_name', 'asc')->get();
         $allBanks = MasterBank::orderBy('bank_name', 'asc')->get();
    $employee =  Employee::all();

    $subgroups = ExpanseSubgroup::all();

        return view('backend.employee.employee_salary_pay_form', compact('allcashs', 'allBanks','employee','subgroups'));


  }

   public function employeesalarypaymentstore(Request $request)
  {
   //dd($request->all());

     if ($request->bank_id != null) {
            $bankname = MasterBank::where('bank_id', $request->bank_id)->value('bank_name');
            $cashdetails = '';
            $type = 'BANK';
        }
      if ($request->cash_id != null) {
            $cashdetails = MasterCash::where('wirehouse_id', $request->cash_id)->value('wirehouse_name');
            $bankname = '';
            $type = 'CASH';
        }



      foreach($request->emp_id as $key => $value){
         $usid = Auth::id();
          $paymentInvoNumber = new Payment_number();
            $paymentInvoNumber->amount = $request->amount[$key];
            $paymentInvoNumber->user_id = $usid;
            $paymentInvoNumber->save();



           $exppayment = new EmployeePayment();
           $exppayment->emp_id= $request->emp_id[$key];
           $exppayment->month= $request->month;
           $exppayment->invoice= $paymentInvoNumber->id;
           $exppayment->date= $request->date;
           $exppayment->payment_type= $request->payment_type;
           $exppayment->bank_id= $request->bank_id;
           $exppayment->cash_id= $request->cash_id;
           $exppayment->expanse_subgroup_id= $request->cash_id;
           $exppayment->bank_warehouse_name= $bankname.$cashdetails;
           $exppayment->net_salary= $request->net_salary[$key];
           $exppayment->payment_amount= $request->amount[$key];
           $exppayment->save();







            $cash_receieve = new Payment();
            $cash_receieve->bank_id = $request->bank_id;
            $cash_receieve->wirehouse_id = $request->cash_id;
            $cash_receieve->expanse_status = 1;
            $cash_receieve->expanse_head = "Salary";
            $cash_receieve->expanse_subgroup_id = $request->expanse_subgroup_id;

            $cash_receieve->bank_name = $bankname;
            $cash_receieve->wirehouse_name = $cashdetails;
           $cash_receieve->amount = $request->amount[$key];
            $cash_receieve->payment_date = $request->date;
            $cash_receieve->payment_type = 'EXPANSE';
            $cash_receieve->type = $request->payment_type;
            $cash_receieve->invoice = $paymentInvoNumber->id;
            $cash_receieve->created_by =  $usid;
         //   $cash_receieve->payment_description = $request->payment_description;
            $cash_receieve->save();




      }
      return redirect()->route('employee.salary.pay.list')->with('success', 'Entry Successffull');


  }




  public function otheramountlist()
  {
    $employee =  Employee::all();
    $otheramount = DB::table('employee_other_amounts')->orderby('id','desc')->get();
        return view('backend.employee.employee_other_amount_list', compact('employee','otheramount'));

  }


  public function otheramountentry()
  {
      $employee =  Employee::all();
        return view('backend.employee.employee_other_amount_form', compact('employee'));
  }

  	public function otheramountstore(Request $request)
    {
     // dd($request->all());
      foreach($request->emp_id as $key => $value){

        DB::table('employee_other_amounts')->insert([
        	'emp_id' =>$request->emp_id[$key],
        	'type' =>$request->type[$key],
        	'amount' =>$request->amount[$key],
        	'month' =>$request->month,
        	'created_at' =>Carbon::now()->toDateTimeString(),
        ]);
      }
      return redirect()->route('employee.other.amount.pay.list')->with('success', 'Entry Successffull');
    }
  public function empmonthlydeductionfilter()
  {
    $employee =  Employee::orderBy('emp_name', 'asc')->get();
  	return view('backend.employee.employee_deduction_report_filter',compact('employee'));
  }

  public function empmonthlydeductionview(Request $request)
  {
    $fdate = $request->month . "-01";
    $tdate = date("Y-m-t", strtotime($request->month));

    $period = CarbonPeriod::create($fdate, $tdate);

    $daycount =0;
    foreach ($period as $date) {
      $daycount++;
    }
    if (isset($request->employee_id)) {
      $fempid = $request->employee_id;
      $emp_acc = DB::table('employee_accounts')->where('emp_id',$fempid)->get();
    }else{
    	$fempid = $request->employee_id;
      	$emp_acc = DB::table('employee_accounts')->get();
    }
    return view('backend.employee.employee_deduction_report_view',compact('emp_acc','fdate','tdate','daycount'));
  }

  public function employeesalarycertificateform()
  {
  	$employee =  Employee::orderBy('emp_name', 'asc')->get();
  	return view('backend.employee.employee_salary_certificate_form',compact('employee'));
  }

  public function employeesalarycertificateview(Request $request)
  {
    //dd($request->all());
    $empdetailes = DB::table('employees')
      ->leftJoin('employee_accounts','employee_accounts.emp_id','employees.id')
      ->leftJoin('designations','designations.id','employees.emp_designation_id')
      ->where('employees.id',$request->employee_id)
      ->first();
  	return view('backend.employee.employee_salary_certificate_view',compact('empdetailes'));
  }

  public function AppointmentLetterForm()
  {
  	$employee =  Employee::orderBy('emp_name', 'asc')->get();
  	return view('backend.employee.appointmentLetter.index',compact('employee'));
  }

  public function AppointmentLetterView(Request $request)
  {
    //dd($request->all());
    $empdetailes = Employee::where('employees.id',$request->employee_id)->first();

  	return view('backend.employee.appointmentLetter.view',compact('empdetailes'));
  }



  public function indexTeam()
    {
        $employeeData = DB::table('employee_teams')->get();

        return view('backend.employee.employee_team_list', compact('employeeData'));
    }

  	public function deleteEmployeeTeam(Request $request)
    {
    	//dd($request->all());
      EmployeeTeam::where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Employee Deleted Successfull');
    }
    public function createEmployeeTeam()
    {
        $employee = Employee::all();
        $dealerArea = DealerArea::all();
        $dealerZone = DealerZone::all();
        $designation = Designation::all();
        $department = Department::all();
        return view('backend.employee.employee_team_create', compact('dealerArea', 'dealerZone','designation','department','employee'));
    }

    public function storeEmployeeTeam(Request $request)
    {
      //dd($request->all());

     $emp_id  =  implode(",",$request->emp_id);
      //dd($emp_id);
        $employees = new EmployeeTeam();
        $employees->title = $request->title;
        $employees->head = $request->head;
        $employees->description = $request->description;
        $employees->employee_id = $emp_id;

        $employees->save();

        return redirect()->route('employee.team.list')->with('success', 'Employee Create Successfull');
    }

  public function etreportList()
    {



    		$empdata = EmployeeReport::select('employee_reports.*','employee_teams.title','employees.emp_name')
    					->leftJoin('employee_teams','employee_teams.id','employee_reports.emp_team_id')
    					->leftJoin('employees','employees.id','employee_reports.emp_id')
              			->orderby('date','desc')->orderby('id','desc')->get();
    //	dd($empdata);

          return view('backend.employee.employee_team_report_list', compact('empdata'));
    }

   public function etrcreate()
    {
        $employee = Employee::all();
        $employeeteam = EmployeeTeam::all();


        return view('backend.employee.employee_team_report_create', compact('employeeteam','employee'));
    }

    public function etrstore(Request $request)
    {
     // dd($request->all());

    // $emp_id  =  implode(",",$request->emp_id);
      //dd($emp_id);
        $employees = new EmployeeReport();
        $employees->date = $request->date;
        $employees->type = $request->type;
        $employees->subject = $request->subject;
        $employees->note = $request->description;
      if($request->type == 1){
      $employees->emp_team_id = $request->team_id;
      }
      if($request->type == 2){
      $employees->emp_id = $request->emp_id;
      }



        $employees->save();

        return redirect()->back()->with('success', 'Entry Successfull');
    }


  public function etredit($id)
    {
        $employee = Employee::all();
        $employeeteam = EmployeeTeam::all();
     $edata =  EmployeeReport::where('id',$id)->first();

        return view('backend.employee.employee_team_report_edit', compact('employeeteam','employee','edata'));
    }

    public function etrupdate(Request $request)
    {
     // dd($request->all());

    // $emp_id  =  implode(",",$request->emp_id);
      //dd($emp_id);
        $employees = EmployeeReport::where('id',$request->id)->first();
        $employees->date = $request->date;
        $employees->type = $request->type;
        $employees->subject = $request->subject;
        $employees->note = $request->description;
      if($request->type == 1){
      $employees->emp_team_id = $request->team_id;
              $employees->emp_id = null;
      }
      if($request->type == 2){
      $employees->emp_id = $request->emp_id;
      $employees->emp_team_id = null;
      }



        $employees->save();

        return redirect()->route("employee.team.report.list")->with('success', 'Entry Successfull');
    }


  	public function etrdelete(Request $request)
    {
    	//dd($request->all());
      EmployeeReport::where('id',$request->id)->delete();
      return redirect()->back()->with('success', ' Deleted Successfull');
    }


    public function etreportIndex()
    {
        $employee = Employee::all();
        $employeeteam = EmployeeTeam::all();
        $subject = EmployeeReport::groupby('subject')->get();

      //dd($subject);


        return view('backend.employee.employee_team_report_index', compact('employeeteam','employee','subject'));
    }

  public function etreportView(Request $request)
    {
      //dd($request->all());

    	if (isset($request->date)) {
            $dates = explode(' - ', $request->date);
            $fdate = date('Y-m-d', strtotime($dates[0]));
            $tdate = date('Y-m-d', strtotime($dates[1]));

         }


    		$empdata = EmployeeReport::select('employee_reports.*','employee_teams.title','employees.emp_name')
    					->leftJoin('employee_teams','employee_teams.id','employee_reports.emp_team_id')
    					->leftJoin('employees','employees.id','employee_reports.emp_id')
              			->whereBetween('date',[$fdate,$tdate]);
    		if($request->subject){
            	$empdata = $empdata->where('subject',$request->subject);
            }
    		if($request->team_id){
            	$empdata = $empdata->where('emp_team_id',$request->team_id);
            }
    		if($request->emp_id){
            	$empdata = $empdata->where('emp_id',$request->emp_id);
            }
    		$empdata = $empdata->get();
    //	dd($empdata);
        return view('backend.employee.employee_team_report_view', compact('empdata'));
    }

  public function employeePayRoll(){
    return view('backend.employee.employeePayRollReportList');
  }
/*
 employee Branch transfer
 */

public function employeeBrachTransferList(){
  return view('backend.employee.emanagement.branchTransfer');
}

public function employeeBrachTransferCreate(){
  $employees = Employee::orderby('emp_name','asc')->get();
  return view('backend.employee.emanagement.branchTransferCreate', compact('employees'));
}

/*
 employee Department transfer
 */

public function employeeDepartmentTransferList(){
  return view('backend.employee.emanagement.departmentTransfer');
}

public function employeeDepartmentTransferCreate(){
  $employees = Employee::orderby('emp_name','asc')->get();
  $departments = Department::orderby('department_title','asc')->get();
  return view('backend.employee.emanagement.departmentTransferCreate', compact('employees','departments'));
}

public function employeeExtraOverTimeList(Request $request){
  $overTimeEmployees = EmployeeOvertime::get();
return view('backend.employee.employeeExtraOverTimeList',compact('overTimeEmployees'));
}


public function leaveofabsentPolicy(){
  return view('backend.payRoll.timeAttendance.leavePolicy.index');
}

public function leaveofabsentPolicyCreate(){
  return view('backend.payRoll.timeAttendance.leavePolicy.create');
}

public function qualificationIndex(){
  return view('backend.employee.qualification.index');
  }

public function qualificationCreate(){
  $employee = Employee::orderby('emp_name','asc')->get();
  return view('backend.employee.qualification.create',compact('employee'));
}

public function employeeIdCardList(){
  $empIdCards = EmployeeIdCard::get();
  return view('backend.employee.idCard.index',compact('empIdCards'));
}
public function employeeIdCardCreate(){
  $employee = Employee::orderby('emp_name','asc')->get();
  $designation = Designation::orderby('designation_title','asc')->get();
  $userId = Auth::id();
  return view('backend.employee.idCard.create',compact('employee','designation','userId'));
}

public function employeeIdCardStore(Request $request){
  $empIdCard = new EmployeeIdCard();
  $empIdCard->fill($request->all());
  if($empIdCard->save()){
      return redirect()->back()->with('success', 'Employee ID Card Create Successfull');
  }
}

public function employeeIdCardDelete(Request $request){
  dd($request->all());
  EmployeeIdCard::where('id',$request->id)->delete();
  return redirect()->back()->with('success', 'Employee ID Card Deleted Successfull');
}

public function ehreportIndex()
{
    $employee = Employee::orderby('emp_name','asc')->get();
    return view('backend.payRoll.employeeHistory.index', compact('employee'));
}

public function ehreportView(Request $request){
  if(isset($request->emp_id)){
  $employees =  Employee::whereIn('id',$request->emp_id)->whereMonth('created_at','01')->orderby('emp_name','asc')->get();
  } else {
  $employees = Employee::orderby('emp_name','asc')->get();
  }
  return view('backend.payRoll.employeeHistory.report', compact('employees'));
}


public function esreportIndex()
{
    $employee = Employee::orderby('emp_name','asc')->get();
    return view('backend.payRoll.employeeSalaryReport.index', compact('employee'));
}

public function esreportView(Request $request){

  if(isset($request->date)) {
    $dates = explode(' - ', $request->date);
    $fdate = date('Y-m-d', strtotime($dates[0]));
    $tdate = date('Y-m-d', strtotime($dates[1]));
  } else {
    $fdate = date('Y-m-d');
    $tdate = date('Y-m-d');
  }

  if(isset($request->emp_id)){
  $employees =  EmployeePayment::whereIn('emp_id',$request->emp_id)->whereBetween('date',[$fdate, $tdate])->orderby('date','asc')->groupBy('emp_id')->get();
  } else {
  $employees = EmployeePayment::whereBetween('date',[$fdate, $tdate])->orderby('date','asc')->groupBy('emp_id')->get();
  }
  //dd($employees);
  return view('backend.payRoll.employeeSalaryReport.report', compact('employees','fdate','tdate'));
}

  public function newRReportIndex(){
  return view('backend.payRoll.employeeRecruitment.index');
  }

   public function newRReportView(Request $request){
   // dd($request->all());
  if(isset($request->monthYear)) {
    $dates = explode('-', $request->monthYear);
  }
    /* $month = date('m', strtotime($dates[1]));
    } else {
      $month = date('m');
    } */
    
    $getMonth = $request->monthYear.'-01';
    $employees =  Employee::whereMonth('emp_joining_date',$dates[1])->orderby('emp_name','asc')->get();
   
    return view('backend.payRoll.employeeRecruitment.report', compact('employees','getMonth'));
    }
}
