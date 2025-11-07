<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeHolidayBonus extends Model
{
    use HasFactory;
    	protected $table = 'employee_holiday_bonuses';
      protected $fillable = [
      'id',
      'amount',
      'note',
    ];

  
}
