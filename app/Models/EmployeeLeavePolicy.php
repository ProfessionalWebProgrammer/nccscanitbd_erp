<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeavePolicy extends Model
{
    use HasFactory;
    	protected $table = 'employee_leave_policies';
      protected $fillable = [
      'id',
      'user_id',
      'head',
      'count',
      'fine',
      'note'
    ];
}
