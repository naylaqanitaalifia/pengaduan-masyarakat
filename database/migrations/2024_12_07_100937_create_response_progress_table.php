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
        Schema::create('response_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('response_id');
            $table->json('histories');
            $table->timestamps();

            $table->foreign('response_id')->references('id')->on('responses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_progress');
    }
};
