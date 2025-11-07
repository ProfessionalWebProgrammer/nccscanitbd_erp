<?php

namespace App\Http\Controllers\PayRoll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;


class PayRollController extends Controller
{
    public function reimbursementIndex(){
      return view('backend.payRoll.reimbursement.index');
    }

    public function reimbursementCreate(){
      $employees = Employee::orderby('emp_name','asc')->get();
      return view('backend.payRoll.reimbursement.create', compact('employees'));
    }

    public function arrearPayIndex(){
      return view('backend.payRoll.arrearPay.index');
    }

    public function arrearPayCreate(){
      $employees = Employee::orderby('emp_name','asc')->get();
      return view('backend.payRoll.arrearPay.create', compact('employees'));
    }

    public function miscellaneousPayIndex(){
      return view('backend.payRoll.miscellaneousPay.index');
    }

    public function miscellaneousPayCreate(){
      $employees = Employee::orderby('emp_name','asc')->get();
      return view('backend.payRoll.miscellaneousPay.create', compact('employees'));
    }
}
