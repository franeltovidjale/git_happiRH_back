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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->unique();
            $table->foreignId('employer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->boolean('active')->default(true);

            $table->foreignId('enterprise_id')
                ->nullable()
                ->constrained('enterprises')
                ->cascadeOnDelete();

            $table->date('birth_date')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('nationality')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();

            // Professional fields
            $table->string('employee_id')->unique();
            $table->string('username')->unique()->nullable();
            $table->string('role');
            $table->string('designation')->nullable();
            $table->date('joining_date')->nullable();
            $table->foreignId('location_id')->nullable()->constrained('locations')->cascadeOnDelete();

            // Banking fields
            $table->string('bank_account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('ifsc_code')->nullable();

            // Salary and Payment fields
            $table->string('salary_basis')->nullable();
            $table->date('effective_date')->nullable();
            $table->decimal('monthly_salary_amount', 10, 2)->nullable();
            $table->string('type_of_payment')->nullable();
            $table->decimal('billing_rate', 10, 2)->nullable();

            // Job Information
            $table->enum('job_type', ['remote', 'hybrid', 'in-office'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};