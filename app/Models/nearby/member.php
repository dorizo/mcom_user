<?php

namespace App\Models\nearby;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table="member";
}
