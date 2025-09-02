<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EgitmenController;
use App\Http\Controllers\OgrenciController;
use App\Http\Controllers\DersController;
use App\Http\Controllers\NotController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Bu dosyadaki rotalar otomatik olarak `api` middleware grubuyla yüklenecek
| ve `/api` prefix'i altında sunulacaktır.
*/

// Authentication routes
Route::group([
  'middleware' => 'api',
  'prefix' => 'auth'
], function ($router) {
  Route::post('login', [AuthController::class, 'login']);
  Route::post('register', [AuthController::class, 'register']);
  Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
  Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
  Route::get('me', [AuthController::class, 'userProfile'])->middleware('auth:api');
});

Route::group([
  'middleware' => 'auth:api'
], function () {});

Route::apiResource('egitmenler', EgitmenController::class)->parameters([
  'egitmenler' => 'egitmen',
]);

Route::apiResource('ogrenciler', OgrenciController::class)->parameters([
  'ogrenciler' => 'ogrenci',
]);

Route::apiResource('dersler', DersController::class)->parameters([
  'dersler' => 'ders',
]);

// Alias: birimler -> dersler index
Route::get('birimler', [DersController::class, 'index']);

Route::apiResource('notlar', NotController::class)->parameters([
  'notlar' => 'not',
]);
