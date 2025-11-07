<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';
    protected $fillable=[
      'product_id',
      'po_no',
      'invoice',
      'raw_supplier_id',
      'supplier_group_id',
      'reference',
      'month',
      'year',
      'order_quantity',
      'supplier_chalan_qty',
      'receive_quantity',
      'inventory_receive',
      'bill_quantity',
      'wirehouse_id',
      'date',
      'purchas_unit',
      'rate',
      'purchase_rate',
      'purchase_value',
      'transport_vehicle',
      'transport_fare',
      'total_payable_amount',
      'user_id'
    ];

    public function supplier(){
      return $this->belongsTo(Supplier::class,'raw_supplier_id' , 'id');
    }
    public function product(){
      return $this->belongsTo(RowMaterialsProduct::class,'product_id' , 'id');
    }
    public function warehose(){
      return $this->belongsTo(Factory::class,'wirehouse_id' , 'id');
    }
}
