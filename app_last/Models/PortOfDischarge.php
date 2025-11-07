<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortOfDischarge extends Model
{
    use HasFactory;
    protected $table = 'port_of_discharges';
    protected $fillable=['user_id','name'];
}
