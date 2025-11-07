<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackingStockOut extends Model
{
      protected $table = 'packing_stock_outs';

      protected $fillable=[
        'id',
        'date',
        'invoice',
        'packing_id',
        'product_id',
        'wirehouse_id',
        'qty',
        'rate',
        'amount',
        'note',
        'status'
      ];

      public function packing(){
        return $this->belongsTo(RowMaterialsProduct::class,'packing_id' , 'id');
      }

      public function product(){
        return $this->belongsTo(SalesProduct::class,'product_id' , 'id');
      }
}
