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
            $table->foreignId('enterprise_id')->constrained('enterprises');
            $table->foreignId('user_id')->constrained('users');
            $table->string('type')->default(Member::TYPE_EMPLOYEE);
            $table->string('status')->default(value: Member::STATUS_REQUESTED);
            $table->string('username')->unique()->nullable();
            $table->string('code')->unique();

            $table->date('birth_date')->nullable();
            $table->string('marital_status')->default(Member::MARITAL_STATUS_SINGLE);

            $table->string('nationality')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();

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
            $table->string('job_type')->nullable();

            $table->string('status_note')->nullable();
            $table->dateTime('status_date')->nullable();
            $table->foreignId('status_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->json('status_stories')->nullable();

            $table->unique(['enterprise_id', 'user_id']);
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
