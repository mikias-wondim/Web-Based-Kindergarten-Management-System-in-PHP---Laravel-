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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('progress_id')->nullable();
            $table->integer('quarter')->nullable();
            $table->string('subjects')->nullable();
            $table->string('midterm')->nullable();
            $table->string('assignment')->nullable();
            $table->string('final')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->index('progress_id');

            $table->foreign('progress_id')->references('id')->on('progress')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
