<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factory extends Model
{
    protected $fillable = ['id','factory_name',
    'factory_company_id',
    'factory_type_id',
    'factory_division_id',
    'factory_contact_number',
    'factory_address'];
}
