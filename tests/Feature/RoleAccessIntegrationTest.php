<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_can_access_admin_panel(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
    }

    public function test_doctor_user_can_access_doctor_panel(): void
    {
        $doctor = User::factory()->create([
            'role' => 'doctor',
        ]);

        $response = $this->actingAs($doctor)->get('/doctor');

        $response->assertStatus(200);
    }

    public function test_admin_user_cannot_access_doctor_panel(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/doctor');

        $response->assertStatus(403);
    }

    public function test_doctor_user_cannot_access_admin_panel(): void
    {
        $doctor = User::factory()->create([
            'role' => 'doctor',
        ]);

        $response = $this->actingAs($doctor)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_guest_user_is_redirected_to_login_when_accessing_patient_profile(): void
    {
        $patient = Patient::create([
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

        $response = $this->get('/patients/' . $patient->id);

        $response->assertRedirect('/login');
    }

    public function test_admin_and_doctor_can_access_patient_profile_route(): void
    {
        $patient = Patient::create([
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

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $doctor = User::factory()->create([
            'role' => 'doctor',
        ]);

        $adminResponse = $this->actingAs($admin)->get('/patients/' . $patient->id);
        $doctorResponse = $this->actingAs($doctor)->get('/patients/' . $patient->id);

        $adminResponse->assertStatus(200);
        $doctorResponse->assertStatus(200);
    }
}