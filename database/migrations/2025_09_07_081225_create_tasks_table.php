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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->date('due_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('priority')->default('medium');
            $table->foreignId('assigned_to')->nullable()->constrained('members')->cascadeOnDelete();
            $table->foreignId('creator_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('enterprise_id')->constrained('enterprises')->cascadeOnDelete();
            $table->json('attachments')->nullable();
            $table->boolean('notifications')->default(false);
            $table->string('status')->default('todo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
