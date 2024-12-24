<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
      
    protected $fillable = ['menuName','menuLink','icon','parent','publish','creator'];
    protected $primaryKey = 'menuCode';
    protected $table = 'menus';
  
    public function parentdata() {
        return $this->belongsTo('App\Models\menu' , 'parent' ,'menuCode');
    }
    public function menuContent(){
        return $this->belongsTo('App\Models\menuContent' , 'menuCode' ,'menuCode');
    }
    use HasFactory;
}
