<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cidadaos', function (Blueprint $table) {
            $table->string("sexo");
            $table->string("estado_civil");
            $table->date("data_nascimento");
            $table->date("data_moradia");
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger("id");
            $table->foreign("id")->references("id")->on("users");
            $table->primary('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cidadaos');
    }
};
