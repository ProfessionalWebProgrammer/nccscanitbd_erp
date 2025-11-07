<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortOfEntry extends Model
{
    use HasFactory;
    protected $table = 'port_of_entries';
    protected $fillable=['user_id','name'];
}
