<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResepsTable extends Migration
{
    public function up()
    {
        Schema::create('reseps', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('bahan');
            $table->text('langkah');
            $table->string('gambar')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reseps');
    }
}
