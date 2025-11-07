<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LcLedger extends Model
{
    use HasFactory;
    protected $table = 'lc_ledgers';
    protected $fillable=['user_id','lcGroup_id','name'];
    public function lcGroup(){
        return $this->belongsTo(LcGroup::class,'lcGroup_id' , 'id');
    }
}
