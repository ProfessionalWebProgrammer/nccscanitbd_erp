<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeIncrement extends Model
{
    use HasFactory;
    	protected $table = 'employee_increments';
      protected $fillable = [
      'id',
      'date',
      'employee_id',
      'user_id',
      'month',
      'previousAmount',
      'amount',
      'note',
    ];

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id' , 'id');
    }
    public function employeeAccount(){
        return $this->belongsTo(EmployeeAccount::class,'employee_id' , 'emp_id');
    }

    // public function designation(){
    //     return $this->belongsTo(Designation::class,'designation_id' , 'id');
    // }
    //
    // public function department(){
    //     return $this->belongsTo(Department::class,'department_id' , 'id');
    // }

    public function user(){
        return $this->belongsTo(User::class,'user_id' , 'id');
    }
}
