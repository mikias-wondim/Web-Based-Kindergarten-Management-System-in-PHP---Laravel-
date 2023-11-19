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
        Schema::create('bill_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_id')->nullable();
            $table->integer('year')->nullable();
            $table->string('month')->nullable();
            $table->integer('amount')->nullable();
            $table->string('paid_at')->nullable();
            $table->string('date')->nullable();
            $table->string('tranx_no')->nullable();
            $table->integer('late_payment')->nullable();
            $table->string('remainder')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->index('child_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_records');
    }
};
