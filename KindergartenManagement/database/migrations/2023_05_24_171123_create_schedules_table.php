<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->string('two')->nullable()->default(' none, none, none, none, none');
            $table->string('three')->nullable()->default(' none, none, none, none, none');
            $table->string('four')->nullable()->default(' none, none, none, none, none');
            $table->string('five')->nullable()->default(' none, none, none, none, none');
            $table->string('six')->nullable()->default(' none, none, none, none, none');
            $table->string('seven')->nullable()->default(' none, none, none, none, none');
            $table->string('eight')->nullable()->default(' none, none, none, none, none');
            $table->string('nine')->nullable()->default(' none, none, none, none, none');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->index('classroom_id');

            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
