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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('profile_pic');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('dob');
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('role')->nullable();
            $table->string('qualification')->nullable();
            $table->string('certificate')->nullable();
            $table->string('date_of_hire')->nullable();
            $table->integer('salary')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->index('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
