<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groupes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId('filiere_id')->constrained('filieres')->onDelete('cascade');
            $table->integer('annee');
            $table->integer('effectif')->default(0);
            $table->string('annee_scolaire');
            $table->timestamps();

            $table->unique(['nom', 'annee_scolaire']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groupes');
    }
};
