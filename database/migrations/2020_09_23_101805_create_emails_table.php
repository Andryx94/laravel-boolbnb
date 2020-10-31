<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {

          $table->id();

          $table->unsignedBigInteger('apartment_id');
          $table->foreign('apartment_id')
          ->references('id')
          ->on('apartments')
          ->onUpdate('cascade')
          ->onDelete('cascade');

          $table->string('sender_email');
          $table->string('object');
          $table->text('content');
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
        Schema::dropIfExists('emails');
    }
}
