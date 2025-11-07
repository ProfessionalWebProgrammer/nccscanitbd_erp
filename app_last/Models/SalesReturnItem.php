<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturnItem extends Model
{
  use HasFactory;
    protected $table = 'sales_return_items';

    protected $fillable =['id',
    'date',
    'return_id',
    'invoice_no',
    'product_id',
    'product_code',
    'product_weight',
    'product_name',
    'qty',
    'return_qty',
    'unit_price',
    'total_price'];

    public function product(){
        return $this->belongsTo(SalesProduct::class,'product_id' , 'id');
    }
}
