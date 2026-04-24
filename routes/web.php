<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Models\Patient;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'session.timeout'])->name('dashboard');

// Ruta protegida para usuarios con rol administrador.
// Solo los usuarios con role = admin pueden acceder.
Route::get('/admin', function () {
    $patients = Patient::select('id', 'document_number', 'full_name', 'birth_date')->get();

    return view('admin.dashboard', [
        'patients' => $patients,
    ]);
})->middleware(['auth', 'role:admin', 'session.timeout'])->name('admin.dashboard');

// Ruta protegida para usuarios con rol doctor.
// Solo los usuarios con role = doctor pueden acceder.
Route::get('/doctor', function () {
    $patients = Patient::select('id', 'document_number', 'full_name', 'birth_date', 'diagnosis')->get();

    return view('doctor.dashboard', [
        'patients' => $patients,
    ]);
})->middleware(['auth', 'role:doctor', 'session.timeout'])->name('doctor.dashboard');

// Perfil de paciente.
// Requiere usuario autenticado.
// La vista mostrará datos diferentes según el rol del usuario.
Route::get('/patients/{patient}', [PatientController::class, 'show'])
    ->middleware(['auth', 'role:admin,doctor', 'session.timeout'])
    ->name('patients.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
