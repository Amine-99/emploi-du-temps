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
        Schema::table('seance_realisations', function (Blueprint $table) {
            $table->foreignId('module_id')->after('emploi_du_temps_id')->nullable()->constrained('modules')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seance_realisations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('module_id');
        });
    }
};
