<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesLedger extends Model
{
  use HasFactory;
  protected $table = 'sales_ledgers';
  protected $fillable=[
    'ledger_date',
    'vendor_id',
    'zone_id',
    'region_id',
    'area_id',
    'invoice',
    'invoice_type',
    'sale_id',
    'chalan_no',
    'return_id',
    'payment_id',
    'journal_id',
    'warehouse_bank_name',
    'warehouse_bank_id',
    'is_bank',
    'narration',
    'product_name',
    'product_unit',
    'product_id',
    'category_id',
    'qty_pcs',
    'qty_kg',
    'unit_price',
    'discount',
    'discount_amount',
    'free',
    'total_price',
    'debit',
    'credit',
    'closing_balance',
    'credit_limit',
    'priority',
    'ledger_id',
    'sub_ledger_id'
  ];
  public function dealer(){
      return $this->belongsTo(Dealer::class,'vendor_id' , 'id');
  }
  public function warehouse(){
      return $this->belongsTo(Factory::class,'warehouse_bank_id' , 'id');
  }
  public function product(){
      return $this->belongsTo(SalesProduct::class,'product_id' , 'id');
  }
  public function category(){
      return $this->belongsTo(SalesCategory::class,'category_id' , 'id');
  }

}
