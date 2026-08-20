<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruitment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('employee_type'); // jenis tenaga kesehatan dibutuhkan
            $table->integer('count')->default(1); // jumlah yang dibutuhkan
            $table->date('needed_by')->nullable();
            $table->text('reason');
            $table->text('qualifications')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_requests');
    }
};
