<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Muestra el perfil de un paciente.
     *
     * El contenido visible cambia según el rol del usuario autenticado:
     * - doctor: puede ver información clínica protegida.
     * - admin: solo puede ver información limitada.
     */
    public function show(Patient $patient)
    {
        return view('patients.show', [
            'patient' => $patient,
        ]);
    }
}