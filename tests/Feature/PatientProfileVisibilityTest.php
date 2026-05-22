<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientProfileVisibilityTest extends TestCase
{
    use RefreshDatabase;

    private function createPatient(): Patient
    {
        return Patient::create([
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
    }

    public function test_admin_can_view_patient_profile_but_not_clinical_information(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $patient = $this->createPatient();

        $response = $this->actingAs($admin)->get('/patients/' . $patient->id);

        $response->assertStatus(200);
        $response->assertSee('María Fernanda López');
        $response->assertSee('1001001001');

        $response->assertDontSee('Hipertensión arterial');
        $response->assertDontSee('Control médico periódico');
        $response->assertDontSee('Paciente con antecedentes familiares.');
    }

    public function test_doctor_can_view_patient_profile_with_clinical_information(): void
    {
        $doctor = User::factory()->create([
            'role' => 'doctor',
        ]);

        $patient = $this->createPatient();

        $response = $this->actingAs($doctor)->get('/patients/' . $patient->id);

        $response->assertStatus(200);
        $response->assertSee('María Fernanda López');
        $response->assertSee('Hipertensión arterial');
        $response->assertSee('Control médico periódico');
        $response->assertSee('Paciente con antecedentes familiares.');
    }
}