<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class VolumePatientsSeeder extends Seeder
{
    public function run(): void
    {
        $bloodTypes = ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];

        for ($i = 1; $i <= 200; $i++) {
            Patient::updateOrCreate(
                ['document_number' => '900000' . str_pad($i, 4, '0', STR_PAD_LEFT)],
                [
                    'full_name' => 'Paciente Volumen ' . $i,
                    'birth_date' => '1990-01-01',
                    'phone' => '300000' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'email' => 'paciente.volumen' . $i . '@test.com',
                    'address' => 'Dirección de prueba ' . $i,
                    'blood_type' => $bloodTypes[array_rand($bloodTypes)],
                    'diagnosis' => 'Diagnóstico de prueba ' . $i,
                    'treatment' => 'Tratamiento de prueba ' . $i,
                    'medical_notes' => 'Notas médicas de prueba para volumen ' . $i,
                ]
            );
        }
    }
}