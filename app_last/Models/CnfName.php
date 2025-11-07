<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CnfName extends Model
{
    use HasFactory;
    protected $table = 'cnf_names';
    protected $fillable=['user_id','name'];
}
