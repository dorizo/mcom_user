<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class topupmanual extends Model
{
    use HasFactory;
    protected $fillable = [
        'userID',
        'Trx_ID',
        'saldo',
        'responseData',
        'status',
    ];
    protected $table="topupmanuals";
    public function user() {
        return $this->belongsTo('App\Models\User', 'userID' , 'id');
    }
}
