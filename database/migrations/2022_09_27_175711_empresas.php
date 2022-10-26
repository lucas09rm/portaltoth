<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->string("resumo", 800);
            $table->date("data_inauguracao");
            $table->date("data_chegada");
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger("id");
            $table->foreign("id")->references("id")->on("users");
            $table->primary('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
};
