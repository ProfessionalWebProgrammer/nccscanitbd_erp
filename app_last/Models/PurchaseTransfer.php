<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseTransfer extends Model
{
  protected $table = 'purchase_transfers';
  protected $fillable=[
    'id',
    'invoice',
    'from_wirehouse_id',
    'to_wirehouse_id',
    'date',
    'product_id',
    'qty',
    'receive_qty',
    'vehicle',
    'transfer_fare',
    'narration'
  ];

  public function product(){
    return $this->belongsTo(RowMaterialsProduct::class,'product_id' , 'id');
  }
  public function fromWarehose(){
    return $this->belongsTo(Factory::class,'from_wirehouse_id' , 'id');
  }

  public function toWarehose(){
    return $this->belongsTo(Factory::class,'to_wirehouse_id' , 'id');
  }

}
