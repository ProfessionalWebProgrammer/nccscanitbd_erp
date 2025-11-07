<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedUser extends Model
{
    use HasFactory;
    protected $table = 'approved_users';
    protected $fillable=['requisition_id','user_id','note','status'];
    public function emp(){
      return $this->belongsTo(Employee::class,'user_id' , 'user_id');
    }
}
