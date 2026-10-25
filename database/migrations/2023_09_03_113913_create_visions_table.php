<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisionsTable extends Migration
{
    public function up()
    {
        Schema::create('visions', function (Blueprint $table) {
            $table->id();
            $table->string('id_institution', 45);
            $table->text('description');
            $table->text('img');
            $table->string('is_active', 5);
            // Add any additional columns or constraints here
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visions');
    }
}
