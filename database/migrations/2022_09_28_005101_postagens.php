<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('postagems', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("titulo");
            $table->string("texto", 800);
            $table->boolean("ativo");
            $table->string("imagem")->nullable();
            $table->timestamps();
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("cidadaos");
            $table->unsignedBigInteger("tag_id");
            $table->foreign("tag_id")->references("id")->on("tags");            
        });
    }

    public function down()
    {
        Schema::dropIfExists('postagems');
    }
};
