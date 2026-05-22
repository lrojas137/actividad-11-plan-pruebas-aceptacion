<?php

namespace Tests\Feature;

use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientPersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_be_created_in_database(): void
    {
        Patient::create([
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
        ]);

        $this->assertDatabaseHas('patients', [
            'document_number' => '1001001001',
            'full_name' => 'María Fernanda López',
            'email' => 'maria@example.com',
        ]);
    }

    public function test_patient_can_be_retrieved_from_database(): void
    {
        Patient::create([
            'document_number' => '2002002002',
            'full_name' => 'Carlos Andrés Martínez',
            'birth_date' => '1985-09-25',
            'phone' => '3109876543',
            'email' => 'carlos@example.com',
            'address' => 'Carrera 15 # 45-80',
            'blood_type' => 'A+',
            'diagnosis' => 'Diabetes tipo 2',
            'treatment' => 'Control de glucosa y seguimiento endocrinológico',
            'medical_notes' => 'Paciente requiere monitoreo periódico.',
        ]);

        $patient = Patient::where('document_number', '2002002002')->first();

        $this->assertNotNull($patient);
        $this->assertEquals('Carlos Andrés Martínez', $patient->full_name);
        $this->assertEquals('Diabetes tipo 2', $patient->diagnosis);
    }

    public function test_patient_information_can_be_updated_in_database(): void
    {
        $patient = Patient::create([
            'document_number' => '3003003003',
            'full_name' => 'Ana Gómez',
            'birth_date' => '1995-03-10',
            'phone' => '3201112233',
            'email' => 'ana@example.com',
            'address' => 'Calle 5 # 10-15',
            'blood_type' => 'B+',
            'diagnosis' => 'Consulta general',
            'treatment' => 'Revisión médica',
            'medical_notes' => 'Sin observaciones adicionales.',
        ]);

        $patient->update([
            'phone' => '3209998877',
            'treatment' => 'Tratamiento actualizado',
        ]);

        $this->assertDatabaseHas('patients', [
            'document_number' => '3003003003',
            'phone' => '3209998877',
            'treatment' => 'Tratamiento actualizado',
        ]);
    }
}