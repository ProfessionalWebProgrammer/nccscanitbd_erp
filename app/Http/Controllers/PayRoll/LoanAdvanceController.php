<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeBonus;
use App\Models\EmployeeAdvanceSalary;
use App\Models\EmployeeHolidayBonus;
use App\Models\EmployeeSubsidiary;
use App\Models\EmployeeLoan;
use Illuminate\Support\Facades\Auth;


class LoanAdvanceController extends Controller
{
    public function loanIndex(){
      $results = EmployeeLoan::where('status',1)->get();
        return view('backend.payRoll.loanAdvance.loan.index', compact('results'));
    }
    public function loanCreate(){
      $userId = Auth::id();
      $employees = Employee::orderby('emp_name','asc')->get();
      return view('backend.payRoll.loanAdvance.loan.create', compact('employees','userId'));
    }

    public function loanStore(Request $request){
     //dd($request->all());
      $empLoan = new EmployeeLoan();
      $empLoan->fill($request->all());
      if($empLoan->save()){
          return redirect()->back()->with('success', 'Employee Loan Create Successfull');
      }
    }

  public function loanDelete(Request $request){
  //  dd($request->all());
    EmployeeLoan::where('id',$request->id)->delete();
    return redirect()->back()->with('success', 'Employee Loan Deleted Successfull');
  }

    public function loanConfigurationIndex(){
        return view('backend.payRoll.loanAdvance.loanConfiguration.index');
    }
    public function loanConfigurationCreate(){
      return view('backend.payRoll.loanAdvance.loanConfiguration.create');
    }

    public function salaryAdvanceIndex(){
      $datas = EmployeeAdvanceSalary::get();

      return view('backend.payRoll.salaryAdvance.index',compact('datas'));
    }
    public function salaryAdvanceCreate(){
        $userId = Auth::id();
        $employees = Employee::orderby('emp_name','asc')->get();
      return view('backend.payRoll.salaryAdvance.create', compact('employees','userId'));
    }

    public function salaryAdvanceStore(Request $request){
    //  dd($request->all());
      $advSalary = new EmployeeAdvanceSalary();
      $advSalary->fill($request->all());
      if($advSalary->save()){
          return redirect()->back()->with('success', 'Employee Advance Salary Create Successfull');
      }
    }

    public function salaryAdvanceDelete(Request $request){
      //dd($request->all());
      EmployeeAdvanceSalary::where('id',$request->id)->delete();
      return redirect()->back()->with('success', 'Employee Advance Salary Deleted Successfull');
    }

    public function employeeBonusPayIndex(){
        $datas = EmployeeBonus::where('status',1)->get();
        return view('backend.payRoll.BonusPay.index', compact('datas'));
    }
    public function employeeBonusPayCreate(){
        $userId = Auth::id();
        $employees = Employee::orderby('emp_name','asc')->get();
      return view('backend.payRoll.BonusPay.create', compact('employees','userId'));
    }
    public function employeeBonusPayStore(Request $request){
      $bonus = new EmployeeBonus();
      $bonus->fill($request->all());
      if($bonus->save()){
          return redirect()->back()->with('success', 'Employee Bonus Create Successfull');
      }
    }

  public function employeeBonusPayDelete(Request $request){
    //dd($request->all());
    EmployeeBonus::where('id',$request->id)->delete();
    return redirect()->back()->with('success', 'Employee Bonus Deleted Successfull');
  }

  public function employeeBonusHolidayIndex(){
    $datas = EmployeeHolidayBonus::get();
    return view('backend.payRoll.BonusPay.holidayBonusIndex', compact('datas'));
  }

  public function employeeBonusHolidayStore(Request $request){
    $bonusHoliday = new EmployeeHolidayBonus();
    $bonusHoliday->fill($request->all());
    if($bonusHoliday->save()){
        return redirect()->back()->with('success', 'Employee Holiday Bonus Create Successfull');
    }
  }

  public function employeeBonusHolidayDelete(Request $request){
  //  dd($request->all());
    EmployeeHolidayBonus::where('id',$request->id)->delete();
    return redirect()->back()->with('success', 'Employee Holiday Bonus Deleted Successfull');
  }

  public function employeeSubsidiaryIndex(){
    $datas = EmployeeSubsidiary::get();
    return view('backend.payRoll.subsidary.index', compact('datas'));
  }

  public function employeeSubsidiaryStore(Request $request){
    $bonusHoliday = new EmployeeSubsidiary();
    $bonusHoliday->fill($request->all());
    if($bonusHoliday->save()){
        return redirect()->back()->with('success', 'Employee Holiday Bonus Create Successfull');
    }
  }

  public function employeeSubsidiaryDelete(Request $request){
   //dd($request->all());
    EmployeeSubsidiary::where('id',$request->id)->delete();
    return redirect()->back()->with('success', 'Employee Holiday Bonus Deleted Successfull');
  }

}
