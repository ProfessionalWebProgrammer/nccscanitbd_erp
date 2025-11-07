<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCategory extends Model
{
  use HasFactory;
    protected $table = 'sales_categories';
    protected $fillable=['id','category_name'];


}
