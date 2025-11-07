<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExporterLedger extends Model
{
    use HasFactory;
    protected $table = 'exporter_ledgers';
    protected $fillable=['user_id','name'];
}
