<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    protected $fillable = ['beritakatCode','judul','gambar','slug','isi','publish','creator'];
    protected $primaryKey = 'beritaCode';
    protected $table = 'beritas';
}
