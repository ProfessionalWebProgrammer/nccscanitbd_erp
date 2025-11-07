<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeMaternityLeave extends Model
{

    use HasFactory;
    	protected $table = 'employee_maternity_leaves';
      protected $fillable = [
      'id',
      'emp_id',
      'user_id',
      'date',
      'executeDate',
      'endDate',
      'duration',
      'note',
      'status'
    ];

    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id' , 'id');
    }
    public function employeeAccount(){
        return $this->belongsTo(EmployeeAccount::class,'emp_id' , 'emp_id');
    }



    // public function department(){
    //     return $this->belongsTo(Department::class,'department_id' , 'id');
    // }

    public function user(){
        return $this->belongsTo(User::class,'user_id' , 'id');
    }
}
