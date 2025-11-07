<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeOvertime extends Model
{
    use HasFactory;
    	protected $table = 'employee_overtimes';
    
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id' , 'id');
    }
}
