<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LcGroup extends Model
{
    use HasFactory;
    protected $table = 'lc_groups';
    protected $fillable=['user_id','name'];

    public function lcLedger(){
       return $this->hasMany(LcLedger::class,'lcGroup_id','id');
   }
}
