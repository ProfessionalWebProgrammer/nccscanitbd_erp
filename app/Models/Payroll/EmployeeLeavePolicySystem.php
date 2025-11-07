<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeavePolicySystem extends Model
{
    use HasFactory;
    protected $table = 'employee_leave_policies';
    protected $fillable = ['leave_category_name' , 'leave_no' , 'description'];
}
