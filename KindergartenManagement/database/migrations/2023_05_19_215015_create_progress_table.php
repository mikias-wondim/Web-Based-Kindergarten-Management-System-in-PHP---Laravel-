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
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->string('behavior')->nullable();
            $table->string('teamwork')->nullable();
            $table->string('participation')->nullable();
            $table->string('strength')->nullable();
            $table->string('weakness')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->index('profile_id');

            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress');
    }
};
