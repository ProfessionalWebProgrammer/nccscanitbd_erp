<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
    'id',
    'user_id',
    'emp_code',
    'emp_punch_card_no',
    'emp_name',
    'emp_dob',
    'emp_dob',
    'emp_age',
    'emp_designation_id',
    'emp_gender',
    'emp_merital_status',
    'emp_nid_card',
    'emp_mobile_number',
    'emp_nationality',
    'emp_religion',
    'emp_present_address',
    'emp_parmanent_address',
    'emp_father_name',
    'emp_mother_name',
    'emp_spouse_name',
    'emp_blood_group',
    'emp_joining_date',
    'emp_unit_id',
    'emp_division_id',
    'emp_department_id',
    'emp_company_id',
    'emp_secction_id',
    'emp_staff_category_id',
    'emp_grade_info',
    'emp_mail_id'];

    public function designation(){
        return $this->belongsTo(Designation::class,'emp_designation_id' , 'id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'emp_department_id' , 'id');
    }
    public function empAccount(){
        return $this->belongsTo(EmployeeAccount::class,'id' , 'emp_id');
    }

    public function empAccountInfo(){
        return $this->hasOne(EmployeeAccount::class,'emp_id','id');
    }
    public function empOtInfo(){
        return $this->hasMany(EmployeeOvertime::class,'employee_id','id');
    }
    public function empAttendanceInfo(){
        return $this->hasMany(EmployeeAttendance::class,'employee_id','id');
    }

    public function leaveOfAbsences(){
        return $this->hasMany(LeaveOfAbsent::class,'employee_id','id');
    }
    public function ot(){
        return $this->hasMany(EmployeeOvertime::class,'employee_id','id');
    }
     public function empStaffCategory(){
        return $this->belongsTo(StaffCategory::class,'emp_staff_category_id','id');
    }
}
