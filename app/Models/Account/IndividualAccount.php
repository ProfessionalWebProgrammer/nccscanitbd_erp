<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class IndividualAccount extends Model
{
    use HasFactory;
    protected $table = 'ac_individual_account';
    protected $fillable = ['title','code','ac_sub_sub_account_id'];

    public function acSubSubAccount(){
        return $this->belongsTo(SubSubAccount::class,'ac_sub_sub_account_id' , 'id')->with('acSubAccount');
    }
    
    protected static function boot()
    {
        parent::boot();
            self::creating(function($model) {
                $model->created_by = Auth::id();
            });
            self::created(function($model) {
                $model->code = str_pad($model?->acSubSubAccount->code.$model->id,8,0,STR_PAD_LEFT);
                $model->save();
            });
    }

}
