<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deletepermission extends Model
{
    protected $fillable=[
        'id',
        'user_id',
        'isdelete',
        ];
}
