<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
        
        "http://localhost:8000/callback/notive",
        "http://localhost:8000/webhook/whatsapp",
        "http://localhost:8000/notif/va",
        "http://localhost:8000/digi/harga",
        "https://m.rajajualan.com/callback/notive",
        "https://m.rajajualan.com/notif/va",
        "https://m.rajajualan.com/notif/vabca",
        "https://m.rajajualan.com/webhook/whatsapp",
        "https://m.rajajualan.com/digi/harga",
        "https://m.rajajualan.com/digiflazz/webhook",
        "http://app.wapays.shop/digiflazz/webhook",
        "http://localhost:8000/digiflazz/webhook",
    ];
}
