<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payroll\EmployeeLeavePolicySystem;

class LeaveOfAbsent extends Model
{
    use HasFactory;
    
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id' , 'id')->with(['designation','department']);
    }

    public function employeeLeavePolicySystem(){
        return $this->belongsTo(EmployeeLeavePolicySystem::class,'employee_leave_policy_id','id');
    }
}
