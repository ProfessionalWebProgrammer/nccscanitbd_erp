<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawMaterialStockOut extends Model
{
      protected $table = 'raw_material_stock_outs';

      protected $fillable=[
        'id',
        'date',
        'invoice',
        'raw_product_id',
        'product_id',
        'wirehouse_id',
        'qty',
        'rate',
        'amount',
        'note',
        'status'
      ];

      public function rawProduct(){
        return $this->belongsTo(RowMaterialsProduct::class,'raw_product_id' , 'id');
      }

      public function product(){
        return $this->belongsTo(SalesProduct::class,'product_id' , 'id');
      }
}
