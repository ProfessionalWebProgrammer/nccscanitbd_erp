<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    //
    protected $table = 'sales_items';

    public function product(){
        return $this->belongsTo(SalesProduct::class,'product_id' , 'id');
    }
}