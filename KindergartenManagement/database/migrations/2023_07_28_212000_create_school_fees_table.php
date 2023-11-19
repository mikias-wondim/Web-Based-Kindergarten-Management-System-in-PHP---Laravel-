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
        Schema::create('school_fees', function (Blueprint $table) {
            $table->id();
            $table->string('classroom');
            $table->integer('year')->nullable();
            $table->string('month')->nullable();
            $table->integer('amount')->nullable();
            $table->string('due_date')->nullable();
            $table->integer('late_payment')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_fees');
    }
};
