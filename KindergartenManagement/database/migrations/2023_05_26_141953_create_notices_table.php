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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classroom_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->string('image')->nullable();
            $table->string('pdf')->nullable();
            $table->string('recipient')->nullable();
            $table->string('status')->nullable();
            $table->date('expired_date')->nullable();

            $table->timestamps();

            $table->index('classroom_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
