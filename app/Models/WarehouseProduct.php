<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseProduct extends Model
{
  protected $table = 'warehouse_products';
    protected $fillable =['id',
    'type',
    'product_id',
    'category_id',
    'warehouse_id',
    'opening',
    'rate'];

    /* public function weightUnit(){
        return $this->belongsTo(ProductUnit::class,'product_weight_unit' , 'id');
    }
    public function unit(){
        return $this->belongsTo(ProductUnit::class,'product_unit' , 'id');
    } */

    public function product(){
        return $this->belongsTo(SalesProduct::class,'product_id' , 'id');
    }
}
