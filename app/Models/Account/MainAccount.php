<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainAccount extends Model
{
    use HasFactory;
    protected $table = 'ac_main_account';

    public function subAccounts(){
        return $this->hasMany(SubAccount::class,'ac_main_account_id','id')->with('subSubAccounts');
    }

}
