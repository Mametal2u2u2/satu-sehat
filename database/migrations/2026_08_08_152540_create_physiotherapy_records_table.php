<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('physiotherapy_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('therapist_id')->constrained('users')->cascadeOnDelete();
            $table->text('assessment')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('target_therapy')->nullable();
            $table->text('intervention')->nullable();
            $table->text('evaluation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('physiotherapy_records');
    }
};
