<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackingConsumptions extends Model
{
    protected $table = 'packing_consumptions';
    protected $fillable = ['date','pro_invoice','invoice','product_id','bag_id','qty','rate','amount','note','status'];
}