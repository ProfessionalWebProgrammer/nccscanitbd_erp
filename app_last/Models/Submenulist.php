<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submenulist extends Model
{
    protected $fillable=[
        'id',
        'user_id',
        'submenu_title',
        'isedit',
        'isadd',
        'isdelete'
        ];
}
