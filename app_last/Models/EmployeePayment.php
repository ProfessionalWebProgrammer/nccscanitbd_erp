<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePayment extends Model
{
    use HasFactory;
    protected $table = 'employee_payments';



    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id' , 'id');
    }
    public function empAccount(){
        return $this->belongsTo(EmployeeAccount::class,'emp_id' , 'emp_id');
    }

    public function empAttendance(){
        return $this->belongsTo(EmployeeAttendance::class,'emp_id' , 'employee_id');
    }

    public function empPayment(){
        return $this->belongsTo(EmployeePayment::class,'emp_id' , 'emp_id');
    }
}
