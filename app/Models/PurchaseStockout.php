<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseStockout extends Model
{
      protected $table = 'purchase_stockouts';
      
      public function product(){
        return $this->belongsTo(RowMaterialsProduct::class,'product_id' , 'id');
      }
}
