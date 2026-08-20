<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satu_sehat_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->nullable()->constrained()->nullOnDelete();
            $table->string('endpoint');
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->integer('status_code')->nullable();
            $table->boolean('is_success')->default(false);
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satu_sehat_logs');
    }
};
