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
        Schema::table('licencas', function (Blueprint $table) {
            $table->string('pdf')->nullable();
            $table->string('condicionamento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('licencas', function (Blueprint $table) {
            $table->dropColumn('pdf');
            $table->dropColumn('condicionamento');
        });
    }
};
