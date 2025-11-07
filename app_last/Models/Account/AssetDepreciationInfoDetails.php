<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDepreciationInfoDetails extends Model
{
    use HasFactory;
    protected $table = 'ac_assets_depreciation_details';
    protected $fillable = ['remaining_value' , 'depreciation_year','depreciation_month' ,'account_value' ,'status'];

}
