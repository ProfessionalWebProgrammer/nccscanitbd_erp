<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProduction extends Model
{
    use HasFactory;
    	protected $table = 'employee_productions';
      protected $fillable = [
      'id',
      'date',
      'emp_id',
      'user_id',
      'item_id',
      'qty',
      'rate',
      'amount',
      'note'
    ];

    public function product(){
        return $this->belongsTo(EmployeeProduct::class,'item_id' , 'id');
    }
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id' , 'id');
    }

}
