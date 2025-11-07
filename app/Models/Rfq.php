<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    use HasFactory;
    protected $table = 'rfqs';
    protected $fillable=['id','pr_no','invoice','supplier_id','issue_date','response_date','total_amount','description','status'];

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

}
