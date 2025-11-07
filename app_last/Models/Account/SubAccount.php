<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAccount extends Model
{
    use HasFactory;
    protected $table = 'ac_sub_account';
    protected $fillable = ['title','code','ac_main_account_id'];
    
    public function acMainAccount(){
        return $this->belongsTo(MainAccount::class,'ac_main_account_id' , 'id');
    }

    public function subSubAccounts(){
        return $this->hasMany(SubSubAccount::class,'ac_sub_account_id','id');
    }
}
