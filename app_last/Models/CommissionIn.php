<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionIn extends Model
{
    protected $fillable = ['category_id','target_amount','achive_commision','description'];
}
