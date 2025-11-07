<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApproveCheckBoxItem extends Model
{
  protected $table = 'approve_check_box_items';
  protected $fillable = [
  'id',
  'name',
  'description'
];

}
