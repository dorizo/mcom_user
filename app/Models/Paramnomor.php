<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paramnomor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'param',
        'provider',
    ];
    protected $table="paramnomor";
}
