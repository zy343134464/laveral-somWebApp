<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * 这些 URI 将免受 CSRF 验证
     *
     * @var array
     */
    protected $except = [
        
    ];
}
