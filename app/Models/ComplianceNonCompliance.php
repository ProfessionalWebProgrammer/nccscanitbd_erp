<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplianceNonCompliance extends Model
{
    use HasFactory;
    	protected $table = 'compliance_non_compliances';
      protected $fillable = [
      'id',
      'complianceStartTime',
      'complianceEndTime',
      'nonComplianceStartTime',
      'nonComplianceEndTime',
      'note',
      'status',
    ];


}
