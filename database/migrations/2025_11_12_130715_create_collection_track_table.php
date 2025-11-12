<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('collection_track', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained('collections')->onDelete('cascade');
            $table->foreignId('track_id')->constrained('tracks')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['collection_id', 'track_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_track');
    }
};
