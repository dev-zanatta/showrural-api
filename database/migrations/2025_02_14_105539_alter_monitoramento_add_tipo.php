<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('monitoramentos', function (Blueprint $table) {
            //
            $table->string('tipo')->nullable();
            $table->text('emails')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('monitoramentos', function (Blueprint $table) {
            //
            $table->dropColumn('tipo');
            $table->dropColumn('emails');
        });
    }
};
