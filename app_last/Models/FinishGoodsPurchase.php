<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishGoodsPurchase extends Model
{
    use HasFactory;
    protected $table = 'finish_goods_purchases';
    protected $fillable=[
      'id',
      'status',
      'date',
      'invoice',
      'supplier_id',
      'warehouse_id',
      'transport_vehicle',
      'total_purchase_amount',
      'transport_fare',
      'narration'
    ];
    public function supplier(){
      return $this->belongsTo(Supplier::class,'supplier_id' , 'id');
    }
    public function warehose(){
      return $this->belongsTo(Factory::class,'warehouse_id' , 'id');
    }
}
