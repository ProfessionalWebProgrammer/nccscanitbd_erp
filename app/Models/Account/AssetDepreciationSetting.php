<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetDepreciationSetting extends Model
{
    use HasFactory;
    protected $table = 'ac_assets_depreciation_setting';
    protected $fillable = ['depreciation_rate','depreciation_year','status'];
}
