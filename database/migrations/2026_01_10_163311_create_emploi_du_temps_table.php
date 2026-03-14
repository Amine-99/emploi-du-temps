<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emploi_du_temps', function (Blueprint $table) {
            $table->id();
            $table->enum('jour', ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']);
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->foreignId('professeur_id')->constrained('professeurs')->onDelete('cascade');
            $table->foreignId('groupe_id')->constrained('groupes')->onDelete('cascade');
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            $table->foreignId('salle_id')->constrained('salles')->onDelete('cascade');
            $table->enum('semaine_type', ['Toutes', 'Paire', 'Impaire'])->default('Toutes');
            $table->date('date_debut_validite')->nullable();
            $table->date('date_fin_validite')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();

            $table->index(['jour', 'heure_debut', 'heure_fin']);
            $table->index(['professeur_id', 'jour']);
            $table->index(['salle_id', 'jour']);
            $table->index(['groupe_id', 'jour']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emploi_du_temps');
    }
};
