<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pulsaTrx extends Model
{
    use HasFactory;
    
    protected $table="pulsaTrx";
    protected $fillable = [
        'sn',
        'trx_id',
        'response'
    ];
}
