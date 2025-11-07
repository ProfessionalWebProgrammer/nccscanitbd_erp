<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QualityParameter;

class QualityControl extends Model
{
    use HasFactory;
    protected $fillable = [
      	'item_type',
        'chalan_no',
        'supplier_id',
        'product_id',
        'qty',
      	'status',
        'remarks'
    ];

    public function parameter()
    {
        return $this->belongsTo(QualityParameter::class);
    }
}
