<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesReturn extends Model
{
  protected $table = 'sales_returns';
  protected $fillable =['id',
  'date',
  'customer_id',
  'emp_id',
  'user_id',
  'created_by',
  'updated_by',
  'up_at',
  'deleted_by',
  'is_active',
  'user_name',
  'warehouse_id',
  'dealer_id',
  'vendor_area_id',
  'vendor_area',
  'total_qty',
  'total_return_qty',
  'price',
  'discount',
  'grand_total',
  'tax',
  'p_dsc',
  'invoice_no',
  'bank_id',
  'narration',
  'vehicle',
  'transport_cost',
  'demand_month',
  'demand_year',
  'ledger_status',
  'bonus'
];

// wrong code  checked by awal (24-Jun-2024)
  public function salesReturn(){
      return $this->belongsTo(SalesReturnItem::class,'return_id' , 'id');
  }
  
//   Added By Awal (24-Jun-2024)
  public function salesReturnItems(){
      return $this->hasMany(SalesReturnItem::class,'return_id', 'id');
  }
  
  
  public function dealer(){
      return $this->belongsTo(Dealer::class,'dealer_id' , 'id');
  }
  public function warehouse(){
      return $this->belongsTo(Factory::class,'warehouse_id' , 'id');
  }
}
