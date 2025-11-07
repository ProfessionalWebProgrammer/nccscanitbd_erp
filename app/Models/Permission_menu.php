<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission_menu extends Model
{
    protected $fillable=[
        'id',
        'user_id',
        'menu_title',
        'isshow'
        ];
}
