<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUpLink extends Model
{
  protected $table = 'user_up_links';
  protected $fillable = [
  'id',
  'user_id',
  'parent_id',
  'status'
];
}
