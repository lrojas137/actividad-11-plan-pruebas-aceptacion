<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientApiController;

Route::middleware('check.api.key')->group(function () {
    // Endpoints de pacientes
    Route::get('/patients', [PatientApiController::class, 'index']);
    Route::get('/patients/{patient}', [PatientApiController::class, 'show']);
    Route::post('/patients', [PatientApiController::class, 'store']);
    Route::put('/patients/{patient}', [PatientApiController::class, 'update']);

    // Endpoint de doctores
    Route::get('/doctors', [PatientApiController::class, 'doctors']);

    // Endpoints de historial médico
    Route::get('/patients/{patient}/medical-history', [PatientApiController::class, 'medicalHistory']);
    Route::post('/patients/{patient}/medical-history', [PatientApiController::class, 'updateMedicalHistory']);
});

// Manejo de rutas API no existentes
Route::fallback(function () {
    return response()->json([
        'message' => 'Endpoint no encontrado.'
    ], 404);
});