<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EgitmenController;
use App\Http\Controllers\OgrenciController;
use App\Http\Controllers\DersController;
use App\Http\Controllers\NotController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Bu dosyadaki rotalar otomatik olarak `api` middleware grubuyla yüklenecek
| ve `/api` prefix'i altında sunulacaktır.
*/

Route::apiResource('egitmenler', EgitmenController::class)->parameters([
    'egitmenler' => 'egitmen',
]);

Route::apiResource('ogrenciler', OgrenciController::class)->parameters([
    'ogrenciler' => 'ogrenci',
]);

Route::apiResource('dersler', DersController::class)->parameters([
    'dersler' => 'ders',
]);

Route::apiResource('notlar', NotController::class)->parameters([
    'notlar' => 'not',
]);
