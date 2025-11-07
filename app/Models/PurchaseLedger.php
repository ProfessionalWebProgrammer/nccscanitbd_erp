<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseLedger extends Model
{
    use HasFactory;
    protected $table = 'purchase_ledgers';
    protected $fillable=['supplier_id','supplier_group_id','date','type','invoice_no',
                          'credit','debit','balance','warehouse_bank_id','warehouse_bank_name',
                        'purcahse_id','supplier_bill_id','payment_id','return_id','journal_id',
                        'ledger_id','sub_ledger_id','opbadjust_id'];
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id' , 'id');
    }
}
