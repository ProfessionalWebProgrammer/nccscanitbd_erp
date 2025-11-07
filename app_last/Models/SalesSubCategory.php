<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesSubCategory extends Model
{
    use HasFactory;
    protected $table = 'sales_sub_categories';
    protected $fillable = ['cat_id','name'];
}
