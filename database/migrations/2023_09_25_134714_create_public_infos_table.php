<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_infos', function (Blueprint $table) {
            $table->id();
            $table->string('id_branch');
            $table->text('attachment');
            $table->string('category');
            $table->string('title');
            $table->string('title_slug');
            $table->text('content');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('public_infos');
    }
}
