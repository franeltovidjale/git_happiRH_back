<?php

use App\Models\Member;
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
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('enterprise_id')->constrained('enterprises');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('location_id')->nullable()->constrained('locations')->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->cascadeOnDelete();
            $table->foreignId('status_by')->constrained('users')->cascadeOnDelete();

            // Core member information
            $table->string('type')->default(Member::TYPE_EMPLOYEE);
            $table->string('status')->default(Member::STATUS_REQUESTED);
            $table->string('username')->unique()->nullable();
            $table->string('code')->unique();

            // Personal information
            $table->date('birth_date')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('nationality')->nullable();

            // Professional information
            $table->string('role')->nullable();
            $table->date('joining_date')->nullable();

            // Status tracking
            $table->string('status_note')->nullable();
            $table->dateTime('status_date')->nullable();
            $table->json('status_stories')->nullable();

            // Constraints
            $table->unique(['enterprise_id', 'user_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};