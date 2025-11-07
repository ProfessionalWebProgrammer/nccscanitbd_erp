<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ChartOfAccounts extends Model
{
    use HasFactory;
    
    protected $table = 'ac_chart_of_account';
    protected $fillable = ['date','ref_id','ac_main_account_id','ac_sub_account_id','ac_sub_sub_account_id','ac_individual_account_id','invoice','debit','credit','comment','created_by'];
    
    public function acMainAccount(){
        return $this->belongsTo(MainAccount::class,'ac_main_account_id' , 'id');
    }

    public function acSubAccount(){
        return $this->belongsTo(SubAccount::class,'ac_sub_account_id' , 'id');
    }

    public function acSubSubAccount(){
        return $this->belongsTo(SubSubAccount::class,'ac_sub_sub_account_id' , 'id');
    }

    public function acIndividualAccount(){
        return $this->belongsTo(IndividualAccount::class,'ac_individual_account_id' , 'id');
    }

    public function user(){
        return $this->belongsTo(User::class,'created_by' , 'id');
    }


}
