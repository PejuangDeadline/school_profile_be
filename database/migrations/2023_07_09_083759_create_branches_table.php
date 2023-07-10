<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('id_institution')->nullable;
            $table->string('grade')->nullable;
            $table->string('name')->nullable;
            $table->string('about')->nullable;
            $table->text('vision')->nullable;
            $table->text('mission')->nullable;
            $table->string('lat')->nullable;
            $table->string('long')->nullable;
            $table->string('addr')->nullable;
            $table->string('province')->nullable;
            $table->string('city')->nullable;
            $table->string('district')->nullable;
            $table->string('sub_district')->nullable;
            $table->string('zip_code')->nullable;
            $table->string('phone1')->nullable;
            $table->string('phone2')->nullable;
            $table->string('whatsapp')->nullable;
            $table->string('instagram')->nullable;
            $table->string('facebook')->nullable;
            $table->string('twitter')->nullable;
            $table->string('owner')->nullable;
            $table->string('pic')->nullable;
            $table->string('pic_no')->nullable;
            $table->string('established')->nullable;
            $table->string('is_active')->nullable;
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
        Schema::dropIfExists('branches');
    }
}
