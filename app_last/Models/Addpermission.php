<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addpermission extends Model
{
    protected $fillable=[
        'id',
        'user_id',
        'isadd',
        ];
}
