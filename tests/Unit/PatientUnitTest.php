<?php

namespace Tests\Unit;

use App\Models\Patient;
use PHPUnit\Framework\TestCase;

class PatientUnitTest extends TestCase
{
    public function test_patient_model_has_expected_fillable_fields(): void
    {
        $patient = new Patient();

        $expectedFields = [
            'document_number',
            'full_name',
            'birth_date',
            'phone',
            'email',
            'address',
            'blood_type',
            'diagnosis',
            'treatment',
            'medical_notes',
        ];

        $this->assertEquals($expectedFields, $patient->getFillable());
    }

    public function test_patient_model_can_store_basic_patient_information(): void
    {
        $patient = new Patient([
            'document_number' => '1001001001',
            'full_name' => 'María Fernanda López',
            'birth_date' => '1990-05-12',
            'phone' => '3001234567',
            'email' => 'maria@example.com',
            'address' => 'Calle 10 # 20-30',
            'blood_type' => 'O+',
        ]);

        $this->assertEquals('1001001001', $patient->document_number);
        $this->assertEquals('María Fernanda López', $patient->full_name);
        $this->assertEquals('1990-05-12', $patient->birth_date);
        $this->assertEquals('3001234567', $patient->phone);
        $this->assertEquals('maria@example.com', $patient->email);
        $this->assertEquals('Calle 10 # 20-30', $patient->address);
        $this->assertEquals('O+', $patient->blood_type);
    }

    public function test_patient_model_can_store_clinical_information(): void
    {
        $patient = new Patient([
            'diagnosis' => 'Hipertensión arterial',
            'treatment' => 'Control médico y medicamento antihipertensivo',
            'medical_notes' => 'Paciente con antecedentes familiares cardiovasculares',
        ]);

        $this->assertEquals('Hipertensión arterial', $patient->diagnosis);
        $this->assertEquals('Control médico y medicamento antihipertensivo', $patient->treatment);
        $this->assertEquals(
            'Paciente con antecedentes familiares cardiovasculares',
            $patient->medical_notes
        );
    }
}