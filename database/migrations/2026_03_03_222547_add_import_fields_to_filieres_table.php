<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('filieres', function (Blueprint $table) {
            $table->integer('annee')->nullable()->after('niveau');
            $table->string('secteur')->nullable()->after('annee');
            $table->string('type_formation')->nullable()->after('secteur');
        });
    }

    public function down(): void
    {
        Schema::table('filieres', function (Blueprint $table) {
            $table->dropColumn(['annee', 'secteur', 'type_formation']);
        });
    }
};
