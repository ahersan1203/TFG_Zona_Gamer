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
         Schema::table('noticias', function (Blueprint $table) {
            if (Schema::hasColumn('noticias', 'fecha')) {
                $table->dropColumn('fecha');
            }
        });
    }
    public function down(): void
    {
        Schema::table('noticias', function (Blueprint $table) {

            // (opcional) si quieres poder revertirlo
            $table->date('fecha')->nullable();
        });
    }
};
