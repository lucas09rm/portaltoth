<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('perfil_Profissionals', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("profissao");
            $table->string("area");
            $table->string("escolaridade");
            $table->string("texto", 800);
            $table->boolean("disponivel");
            $table->timestamps();
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("cidadaos");
        });
    }

    public function down()
    {
        Schema::dropIfExists('perfil_Profissionals');
    }
};
