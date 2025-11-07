<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OthersIncome extends Model
{
    protected $table = 'others_incomes';

    protected $fillable = [
      'id',
      'product_id',
    'date',
    'invoice',
    'amount',
    'head',
    'description'];

}
