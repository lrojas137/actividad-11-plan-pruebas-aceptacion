<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class PatientValidationTest extends TestCase
{
    /**
     * Reglas básicas para validar los datos de un paciente.
     * Estas reglas simulan la validación que debería tener el registro de pacientes.
     */
    private function rules(): array
    {
        return [
            'document_number' => ['required', 'string', 'max:20'],
            'full_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'blood_type' => ['nullable', 'in:O+,O-,A+,A-,B+,B-,AB+,AB-'],
            'diagnosis' => ['nullable', 'string', 'max:1000'],
            'treatment' => ['nullable', 'string', 'max:1000'],
            'medical_notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function test_accepts_valid_patient_data(): void
    {
        $data = [
            'document_number' => '1001001001',
            'full_name' => 'María Fernanda López',
            'birth_date' => '1990-05-12',
            'phone' => '3001234567',
            'email' => 'maria@example.com',
            'address' => 'Calle 10 # 20-30',
            'blood_type' => 'O+',
            'diagnosis' => 'Hipertensión arterial',
            'treatment' => 'Control médico periódico',
            'medical_notes' => 'Paciente con antecedentes familiares.',
        ];

        $validator = Validator::make($data, $this->rules());

        $this->assertFalse($validator->fails());
    }

    public function test_rejects_empty_required_fields(): void
    {
        $data = [
            'document_number' => '',
            'full_name' => '',
            'birth_date' => '',
        ];

        $validator = Validator::make($data, $this->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('document_number', $validator->errors()->toArray());
        $this->assertArrayHasKey('full_name', $validator->errors()->toArray());
        $this->assertArrayHasKey('birth_date', $validator->errors()->toArray());
    }

    public function test_rejects_invalid_email_format(): void
    {
        $data = [
            'document_number' => '1001001001',
            'full_name' => 'María Fernanda López',
            'birth_date' => '1990-05-12',
            'email' => 'correo-invalido',
        ];

        $validator = Validator::make($data, $this->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    public function test_rejects_future_birth_date(): void
    {
        $data = [
            'document_number' => '1001001001',
            'full_name' => 'María Fernanda López',
            'birth_date' => now()->addYear()->format('Y-m-d'),
            'email' => 'maria@example.com',
        ];

        $validator = Validator::make($data, $this->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('birth_date', $validator->errors()->toArray());
    }

    public function test_rejects_invalid_blood_type(): void
    {
        $data = [
            'document_number' => '1001001001',
            'full_name' => 'María Fernanda López',
            'birth_date' => '1990-05-12',
            'blood_type' => 'XYZ',
        ];

        $validator = Validator::make($data, $this->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('blood_type', $validator->errors()->toArray());
    }
}