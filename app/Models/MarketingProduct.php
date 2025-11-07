<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingProduct extends Model
{
    use HasFactory;
    protected $table = 'marketing_products';
    protected $fillable=['name','code','unit','image','specification','status'];

    public function saleCat(){
        return $this->belongsTo(SalesCategory::class,'category_id' , 'id');
    }

    public function subSaleCat(){
        return $this->belongsTo(SalesSubCategory::class,'sub_category_id' , 'id');
    }
    
    
}
