<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePregnancyChildrensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pregnancy_children', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pregnancy_id');
            $table->enum('gender', ['unknown', 'male', 'female']);
            $table->timestamps();
            $table
                ->foreign('pregnancy_id')
                ->references('id')
                ->on('pregnancies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pregnancy_children');
    }
}
