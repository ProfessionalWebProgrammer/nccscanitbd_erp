<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingOrderSpecification extends Model
{
    use HasFactory;
    protected $table = 'marketing_order_specifications';
    protected $fillable=['invoice','specification_id','value'];
}
