<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vagas', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("titulo");
            $table->string("profissao");
            $table->string("texto", 800);
            $table->string("imagem")->nullable();
            $table->string("area");
            $table->timestamps();
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("empresas");
            $table->unsignedBigInteger("tag_id");
            $table->foreign("tag_id")->references("id")->on("tags");
            //imagem
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vagas');
    }
};
