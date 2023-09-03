<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvantagesTable extends Migration
{
    public function up()
    {
        Schema::create('advantages', function (Blueprint $table) {
            $table->id();
            $table->string('id_institutions', 5);
            $table->string('title', 255);
            $table->text('description');
            $table->string('is_active', 5);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('advantages');
    }
}


