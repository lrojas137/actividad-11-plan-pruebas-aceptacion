<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
     * Campos que pueden asignarse de forma masiva.
     * Esto permite crear registros de pacientes de manera controlada.
     */
    protected $fillable = [
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
}