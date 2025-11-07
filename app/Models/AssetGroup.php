<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetGroup extends Model
{
    use HasFactory;
    protected $table = 'asset_groups';
    protected $fillable=[
      'id',
      'category_id',
      'name',
      'description'];
      public function category(){
        return $this->belongsTo(AssetCategory::class,'category_id' , 'id');
      }
}
