<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionUser extends Model
{
    use HasFactory;

    protected $table = 'requisition_users';
    protected $fillable = [
    'id',
    'requisition_id',
    'to_user_id',
    'invoice',
    'status'
  ];

  public function emp(){
    return $this->belongsTo(Employee::class,'to_user_id' , 'user_id');
  }

}
