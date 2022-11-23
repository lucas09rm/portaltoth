<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('denuncias', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("analise")->nullable();
            $table->boolean("ativo");
            $table->unsignedBigInteger("postagem_id");
            $table->foreign("postagem_id")->references("id")->on("postagems");
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('denuncias');
    }
};
