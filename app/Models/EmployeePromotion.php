<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePromotion extends Model
{
    use HasFactory;
    	protected $table = 'employee_promotions';
      protected $fillable = [
      'id',
      'date',
      'employee_id',
      'user_id',
      'designation_id',
      'department_id',
      'note',
    ];

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id' , 'id');
    }

    public function designation(){
        return $this->belongsTo(Designation::class,'designation_id' , 'id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'department_id' , 'id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id' , 'id');
    }
}
