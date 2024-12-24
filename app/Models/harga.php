<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class harga extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_name',
        'category',
        'brand',
        'type',
        'seller_name',
        'price',
        'buyer_sku_code',
        'buyer_product_status',
        'seller_product_status',
        'stock',
        'multi',
        'start_cut_off',
        'end_cut_off',
        'desc',
        'member',
        'warung',
        'konter',
        ];
}
