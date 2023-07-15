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
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('computer_id');
            // $table->unsignedBigInteger('question_id');
            // $table->unsignedBigInteger('answer_id');
            $table->json('selected_option');
            // $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            // $table->foreign('answer_id')->references('id')->on('answers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
