<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesStockOut extends Model
{
  protected $table = 'sales_stock_outs';
  protected $fillable = ['date','invoice','product_id','wirehouse_id','qty','rate','amount','note','status'];
}
