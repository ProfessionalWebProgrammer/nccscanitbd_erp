<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;
  	protected $table = 'employee_attendances';
    protected $gurd = [];
    
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id' , 'id');
    }
}
