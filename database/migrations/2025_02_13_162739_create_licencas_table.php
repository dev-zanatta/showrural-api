<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licencas', function (Blueprint $table) {
            $table->id();
            $table->string('n_protocolo')->nullable();
            $table->string('cpf_cnpj')->nullable();
            $table->string('nome_razao_social')->nullable();
            $table->text('atividade')->nullable();
            $table->text('atividade_especifica')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('modalidade')->nullable();
            $table->string('n_documento')->nullable();
            $table->date('data_emissao')->nullable();
            $table->date('data_validade')->nullable();
            $table->string('dias_vencimento')->nullable();
            $table->string('meses_vencimento')->nullable();
            $table->string('anos_vencimento')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licencas');
    }
};
