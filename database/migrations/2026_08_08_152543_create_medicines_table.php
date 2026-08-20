<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('medicine_categories')->nullOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('dosage_form')->nullable();
            $table->string('unit')->default('pcs');
            $table->string('dosage_strength')->nullable();
            $table->integer('minimum_stock')->default(10);
            $table->integer('current_stock')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
