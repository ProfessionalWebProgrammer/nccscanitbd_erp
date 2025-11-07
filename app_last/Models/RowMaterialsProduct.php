<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RowMaterialsProduct extends Model
{
    use HasFactory;
  protected $fillable = ['category_id','product_name','unit','rate','department_id','opening_balance','days','min_stock'];

  public function department(){
    return $this->belongsTo(Department::class,'department_id' , 'id');
  }
  public function cat(){
    return $this->belongsTo(SalesCategory::class,'category_id' , 'id');
  }
}
