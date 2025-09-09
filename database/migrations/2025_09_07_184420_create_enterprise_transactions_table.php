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
        Schema::create('enterprise_transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2);
            $table->string('status');
            $table->string('currency', 3)->default('XOF');
            $table->decimal('salaire_net', 15, 2)->nullable();
            $table->foreignId('enterprise_id')->constrained('enterprises')->cascadeOnDelete();
            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['enterprise_id', 'created_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enterprise_transactions');
    }
};
