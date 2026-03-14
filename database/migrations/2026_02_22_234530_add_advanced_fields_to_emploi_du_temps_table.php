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
        Schema::table('emploi_du_temps', function (Blueprint $table) {
            $table->string('statut_approbation')->default('approved')->after('actif'); // pending, approved, rejected
            $table->text('motif_annulation')->nullable()->after('statut_approbation');
            $table->boolean('is_examen')->default(false)->after('motif_annulation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emploi_du_temps', function (Blueprint $table) {
            $table->dropColumn(['statut_approbation', 'motif_annulation', 'is_examen']);
        });
    }
};
