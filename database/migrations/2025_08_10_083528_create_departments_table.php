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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enterprise_id')->constrained('enterprises')->cascadeOnDelete();
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->string('slug');
            $table->boolean('late_penalty')->default(false);
            $table->string('work_model')->default('in-office');
            $table->boolean('meeting_participation_score')->default(false);
            $table->boolean('attendance_score')->default(false);
            $table->string('overtime_recording_score')->nullable();
            $table->string('overtime_clocking_score')->nullable();
            $table->foreignId('supervisor_id')->nullable()->constrained('members')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['enterprise_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
