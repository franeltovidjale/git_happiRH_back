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
        Schema::create('enterprises', function (Blueprint $table) {
            $table->id();
            $table->string('ifu', 16)->nullable();
            $table->string('name', 100);
            $table->boolean('active')->default(true);
            $table->string('code')->unique();
            $table->foreignId('"owner_id"')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('sector_id')->nullable()->constrained('sectors')->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->string('status_note')->nullable();
            $table->dateTime('status_date')->nullable();
            $table->foreignId('status_by')->constrained('users')->cascadeOnDelete();
            $table->json('status_stories')->nullable();

            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();

            $table->string('country_code');
            $table->foreign('country_code')
                ->references('code')
                ->on('countries')
                ->cascadeOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enterprises');
    }
};
