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
        Schema::create('demande_absences', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_date');
            $table->string('status')->default('pending');
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('enterprise_id')->constrained('enterprises')->cascadeOnDelete();
            $table->foreignId('creator_member_id')->constrained('members')->cascadeOnDelete();
            $table->text('reason')->nullable();

            // Add new columns
            $table->dateTime('end_date')->nullable();
            $table->string('type')->default('leave'); // leave, absence, holiday
            $table->string('period'); // 3h, 1day, 1week, 2month, etc.
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_absences');
    }
};
