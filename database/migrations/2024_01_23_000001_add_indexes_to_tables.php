<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Adicionar índices para otimizar consultas
        Schema::table('modelos', function (Blueprint $table) {
            $table->index('marca_id');
        });

        Schema::table('carros', function (Blueprint $table) {
            $table->index('modelo_id');
            $table->index('disponivel');
        });

        Schema::table('clientes', function (Blueprint $table) {
            $table->index('email');
            $table->index('cpf');
        });

        Schema::table('locacoes', function (Blueprint $table) {
            $table->index('cliente_id');
            $table->index('carro_id');
            $table->index('data_inicio_periodo');
            $table->index('data_final_previsto_periodo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modelos', function (Blueprint $table) {
            $table->dropIndex(['marca_id']);
        });

        Schema::table('carros', function (Blueprint $table) {
            $table->dropIndex(['modelo_id']);
            $table->dropIndex(['disponivel']);
        });

        Schema::table('clientes', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['cpf']);
        });

        Schema::table('locacoes', function (Blueprint $table) {
            $table->dropIndex(['cliente_id']);
            $table->dropIndex(['carro_id']);
            $table->dropIndex(['data_inicio_periodo']);
            $table->dropIndex(['data_final_previsto_periodo']);
        });
    }
}
