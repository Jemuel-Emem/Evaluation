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
        Schema::create('accomodations_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->string('eventname');
            $table->integer('stronglyagree')->default(0);
            $table->integer('agree')->default(0);
            $table->integer('moderatelyagree')->default(0);
            $table->integer('disagree')->default(0);
            $table->integer('stronglydisagree')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accomodations_ratings');
    }
};
