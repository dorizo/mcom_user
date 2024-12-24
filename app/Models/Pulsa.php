<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pulsa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomor',
        'trx_id',
        'userID',
        'code',
        'price',
        'response',
        'callback',
        'kategori',
        'hargadasar',
    ];
    public function loger() {
        return $this->belongsTo('App\Models\loger', 'trx_id' , 'trx_id');
    }
}
