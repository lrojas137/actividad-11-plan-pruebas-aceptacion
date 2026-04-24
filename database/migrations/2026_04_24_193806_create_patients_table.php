<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // Datos básicos del paciente.
            $table->string('document_number')->unique();
            $table->string('full_name');
            $table->date('birth_date');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();

            // Datos clínicos sensibles.
            // Estos datos serán visibles completamente solo para usuarios con rol doctor.
            $table->string('blood_type')->nullable();
            $table->string('diagnosis');
            $table->text('treatment')->nullable();
            $table->text('medical_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
