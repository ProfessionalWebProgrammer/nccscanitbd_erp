<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityParameter extends Model
{
    use HasFactory;
    protected $fillable = ['item_type','name','standard'];

    public function qcparameter()
    {
        return $this->hasMany(QualityControl::class);
    }

}
