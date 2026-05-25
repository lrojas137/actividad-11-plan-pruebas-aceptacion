<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientApiController extends Controller
{
    /**
     * Lista todos los pacientes registrados.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Listado de pacientes obtenido correctamente.',
            'data' => Patient::all()
        ], 200);
    }

    /**
     * Muestra la información de un paciente específico.
     */
    public function show(Patient $patient)
    {
        return response()->json([
            'message' => 'Paciente encontrado correctamente.',
            'data' => $patient
        ], 200);
    }

    /**
     * Registra un nuevo paciente.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'document_number' => ['required', 'string', 'max:20', 'unique:patients,document_number'],
            'full_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'blood_type' => ['nullable', 'in:O+,O-,A+,A-,B+,B-,AB+,AB-'],
            'diagnosis' => ['nullable', 'string', 'max:1000'],
            'treatment' => ['nullable', 'string', 'max:1000'],
            'medical_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $patient = Patient::create($validated);

        return response()->json([
            'message' => 'Paciente creado correctamente.',
            'data' => $patient
        ], 201);
    }

    /**
     * Actualiza la información de un paciente.
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'document_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('patients', 'document_number')->ignore($patient->id),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'blood_type' => ['nullable', 'in:O+,O-,A+,A-,B+,B-,AB+,AB-'],
            'diagnosis' => ['nullable', 'string', 'max:1000'],
            'treatment' => ['nullable', 'string', 'max:1000'],
            'medical_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $patient->update($validated);

        return response()->json([
            'message' => 'Paciente actualizado correctamente.',
            'data' => $patient
        ], 200);
    }

    /**
     * Lista los usuarios con rol doctor.
     */
    public function doctors()
    {
        $doctors = User::where('role', 'doctor')
            ->select('id', 'name', 'email', 'role')
            ->get();

        return response()->json([
            'message' => 'Listado de doctores obtenido correctamente.',
            'data' => $doctors
        ], 200);
    }

    /**
     * Consulta el historial médico básico del paciente.
     */
    public function medicalHistory(Patient $patient)
    {
        return response()->json([
            'message' => 'Historial médico obtenido correctamente.',
            'data' => [
                'patient_id' => $patient->id,
                'full_name' => $patient->full_name,
                'diagnosis' => $patient->diagnosis,
                'treatment' => $patient->treatment,
                'medical_notes' => $patient->medical_notes,
            ]
        ], 200);
    }

    /**
     * Registra o actualiza información de historial médico.
     */
    public function updateMedicalHistory(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'diagnosis' => ['required', 'string', 'max:1000'],
            'treatment' => ['required', 'string', 'max:1000'],
            'medical_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $patient->update($validated);

        return response()->json([
            'message' => 'Historial médico actualizado correctamente.',
            'data' => [
                'patient_id' => $patient->id,
                'full_name' => $patient->full_name,
                'diagnosis' => $patient->diagnosis,
                'treatment' => $patient->treatment,
                'medical_notes' => $patient->medical_notes,
            ]
        ], 200);
    }
}