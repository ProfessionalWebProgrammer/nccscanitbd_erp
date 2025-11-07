<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesProduct extends Model
{
    protected $fillable =['id',
    'product_name',
    'category_id',
    'product_code',
    'product_dimension',
    'product_dimension_unit',
    'product_weight',
    'product_weight_unit',
    'product_unit',
    'product_barcode',
    'product_dp_price',
    'opening_balance',
    'product_dealer_commision',
    'product_mrp',
    'product_color',
    'product_description'];

    public function weightUnit(){
        return $this->belongsTo(ProductUnit::class,'product_weight_unit' , 'id');
    }
    public function unit(){
        return $this->belongsTo(ProductUnit::class,'product_unit' , 'id');
    }
    
    public function sales_category(){
        return $this->belongsTo(SalesCategory::class, 'category_id' , 'id');
    }
}
