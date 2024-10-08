<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UrlShortenerController;


Route::post('/api/url/shorten', [UrlShortenerController::class, 'shorten']);
Route::get('/api/{shortened}', [UrlShortenerController::class, 'redirect']);
Route::get('/api/url', [UrlShortenerController::class, 'getUrls']);
Route::delete('/api/url/{shortened}', [UrlShortenerController::class, 'remove']);
