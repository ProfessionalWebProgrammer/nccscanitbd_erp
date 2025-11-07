<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProduct extends Model
{
    use HasFactory;
    	protected $table = 'employee_products';
      protected $fillable = [
      'id',
      'name',
      'category',
      'style',
      'process',
      'rate',
      'note'
    ];

    /*public function employee(){
        return $this->belongsTo(Employee::class,'emp_id' , 'id');
    }
    */

}
