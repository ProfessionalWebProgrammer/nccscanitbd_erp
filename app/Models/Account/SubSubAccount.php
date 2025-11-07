<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSubAccount extends Model
{
    use HasFactory;
    protected $table = 'ac_sub_sub_account';
    protected $fillable = ['title','code','ac_sub_account_id'];

    public function acSubAccount(){
        return $this->belongsTo(SubAccount::class,'ac_sub_account_id' , 'id')->with('acMainAccount');
    }

    public function individualAccounts(){
        return $this->hasMany(IndividualAccount::class,'ac_sub_sub_account_id','id');
    }

}
