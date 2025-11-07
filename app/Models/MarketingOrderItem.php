<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingOrderItem extends Model
{
    use HasFactory;
    protected $table = 'marketing_order_items';
    public function mp(){
        return $this->belongsTo(MarketingProduct::class,'item_id' , 'id');
    }

    public function com(){
        return $this->belongsTo(InterCompany::class,'company_id' , 'id');
    }
    public function user(){
        return $this->belongsTo(User::class,'approved_by' , 'id');
    }
}
