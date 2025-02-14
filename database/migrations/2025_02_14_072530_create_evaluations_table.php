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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('program_activities_id')->nullable();
            $table->unsignedBigInteger('venue_id')->nullable();
            $table->unsignedBigInteger('accommodations_id')->nullable();
            $table->unsignedBigInteger('speaker_id')->nullable();
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('program_activities_id')->references('id')->on('program__activity__questions')->onDelete('cascade');
            $table->foreign('venue_id')->references('id')->on('venue_questions')->onDelete('cascade');
            $table->foreign('accommodations_id')->references('id')->on('accomodations_questions')->onDelete('cascade');
            $table->foreign('speaker_id')->references('id')->on('speaker_questions')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
