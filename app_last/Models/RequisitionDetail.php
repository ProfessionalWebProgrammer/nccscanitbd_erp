<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionDetail extends Model
{
    use HasFactory;
    protected $table = 'requisition_details';
    protected $fillable = [
    'id',
    'req_id',
    'delivery_date',
    'item',
    'specification',
    'unit',
    'stock',
    'qty',
    'lup'
  ];
    public function product(){
      return $this->belongsTo(RowMaterialsProduct::class,'item' , 'id');
    }
}
