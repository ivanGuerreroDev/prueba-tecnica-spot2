<?php
namespace App\Http\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        '/shorten',  // Si no quieres proteger esta ruta con CSRF, la agregas aquí
    ];
}
