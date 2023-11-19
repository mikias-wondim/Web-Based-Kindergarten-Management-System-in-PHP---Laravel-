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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('dob');
            $table->string('gender');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('applying_program')->nullable();
            $table->string('previous_school')->nullable();
            $table->string('medical_condition')->nullable();
            $table->string('additional_info')->nullable();
            $table->boolean('new')->nullable()->default(true);
            $table->boolean('checked')->nullable()->default(false);
            $table->unsignedBigInteger('forwarded_by')->nullable();
            $table->boolean('forward')->nullable()->default(false);
            $table->boolean('approved')->nullable()->default(false);
            $table->string('approved_date')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->boolean('registered')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
