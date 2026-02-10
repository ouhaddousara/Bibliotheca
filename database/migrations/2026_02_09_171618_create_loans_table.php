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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('copy_id')->constrained()->cascadeOnDelete();
            $table->dateTime('borrowed_at');
            $table->date('due_date'); // Calculé : borrowed_at + 14j
            $table->dateTime('returned_at')->nullable();
            $table->enum('return_condition', ['good', 'damaged', 'lost'])->nullable(); // Audit trail
            $table->timestamps();
            
            // Index critiques pour performances
            $table->index(['member_id', 'returned_at']);
            $table->index('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};