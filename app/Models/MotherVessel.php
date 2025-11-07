<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotherVessel extends Model
{
    use HasFactory;
    protected $table = 'mother_vessels';
    protected $fillable=['user_id','name'];
}
