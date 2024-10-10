<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UrlShortenerController;


Route::post('/url/shorten', [UrlShortenerController::class, 'shorten']);
Route::get('/url', [UrlShortenerController::class, 'getUrls']);
Route::delete('/url/{shortened}', [UrlShortenerController::class, 'remove']);
Route::get('/url/redirect/{shortened}', [UrlShortenerController::class, 'redirect']);
