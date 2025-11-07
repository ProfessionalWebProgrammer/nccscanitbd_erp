<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editpermission extends Model
{
    protected $fillable=[
        'id',
        'user_id',
        'isedit',
        ];
}
