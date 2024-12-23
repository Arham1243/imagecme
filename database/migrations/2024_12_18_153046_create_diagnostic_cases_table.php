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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_type')->nullable();
            $table->text('content')->nullable();
            $table->string('image_quality')->nullable();
            $table->string('diagnosis_title')->nullable();
            $table->string('slug')->nullable();
            $table->string('diagnosed_disease')->nullable();
            $table->string('ease_of_diagnosis')->nullable();
            $table->string('certainty')->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('segment')->nullable();
            $table->text('clinical_examination')->nullable();
            $table->string('patient_age')->nullable();
            $table->string('patient_gender')->nullable();
            $table->string('patient_socio_economic')->nullable();
            $table->string('patient_concomitant')->nullable();
            $table->string('patient_others')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('authors')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
