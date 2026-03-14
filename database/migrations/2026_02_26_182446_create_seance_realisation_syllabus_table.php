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
        Schema::create('seance_realisation_syllabus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seance_realisation_id')->constrained('seance_realisations')->onDelete('cascade');
            $table->foreignId('syllabus_item_id')->constrained('syllabus_items')->onDelete('cascade');
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seance_realisation_syllabus');
    }
};
