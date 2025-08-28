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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 50)->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('currency', 32)->default('XOF');
            $table->string('billing_cycle')->default('monthly'); // monthly, yearly
            $table->boolean('is_active')->default(true);
            $table->boolean('is_recommended')->default(false);

            $table->string('target_audience')->nullable();
            $table->decimal('price_per_employee', 10, 2)->default(0);
            $table->integer('trial_period_months')->default(0);
            $table->boolean('is_custom_quote')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
