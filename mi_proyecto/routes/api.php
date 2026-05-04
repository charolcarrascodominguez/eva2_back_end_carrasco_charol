<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ClientController;
// Rutas para Ofertas Laborales
use App\Http\Controllers\OfertasController;
use App\Http\Controllers\PostulacionesController;


Route::get('/health', [HealthController::class, 'index']);

Route::apiResource('clients', ClientController::class);

Route::get('/ofertas', [OfertasController::class, 'index']);
Route::post('/ofertas', [OfertasController::class, 'store']);
Route::put('/ofertas/{id_oferta}', [OfertasController::class, 'update']);
Route::patch('/ofertas/{id_oferta}/desactivar', [OfertasController::class, 'desactivar']);
Route::get('/ofertas/{id_oferta}/postulantes', [OfertasController::class, 'postulantes']);

Route::post('/postulaciones', [PostulacionesController::class, 'store']);
Route::get('/postulaciones/{rut_cantidado}', [PostulacionesController::class, 'porCandidato']);
Route::patch('/postulaciones/{id_postulacion}', [PostulacionesController::class, 'update']);
