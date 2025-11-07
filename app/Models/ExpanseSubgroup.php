<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpanseSubgroup extends Model
{
  protected $table = 'expanse_subgroups';

  protected $fillable = [
  'id',
  'group_id',
  'group_name',
  'subgroup_name',
  'balance',
  'invoice',
  'description',
  'type'
];

}
