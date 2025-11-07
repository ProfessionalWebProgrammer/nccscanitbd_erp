<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSubsidiary extends Model
{
    use HasFactory;
    	protected $table = 'employee_subsidiaries';
      protected $fillable = [
      'id',
      'amount',
      'note',
    ];


}
