<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSelectItem extends Model
{
  protected $table = 'user_select_items';
  protected $fillable = [
  'id',
  'user_id',
  'requisition_id',
  'item_id'
];

public function selectItem(){
    return $this->belongsTo(ApproveCheckBoxItem::class,'item_id' , 'id');
}

}
