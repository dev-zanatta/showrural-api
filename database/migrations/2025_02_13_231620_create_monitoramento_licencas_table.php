<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitoramento_licencas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('licenca_id');
            $table->foreign('licenca_id')->references('id')->on('licencas');
            $table->unsignedBigInteger('monitoramento_id');
            $table->foreign('monitoramento_id')->references('id')->on('monitoramentos');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoramento_licencas');
    }
};
