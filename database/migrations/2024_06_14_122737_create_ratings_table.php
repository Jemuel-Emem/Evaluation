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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('eventname');
            $table->integer('stronglyagree')->default(0);
            $table->integer('agree')->default(0);
            $table->integer('moderatelyagree')->default(0);
            $table->integer('disagree')->default(0);
            $table->integer('strongdisagree')->default(0);
            $table->string('status')->default('Pending');
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
