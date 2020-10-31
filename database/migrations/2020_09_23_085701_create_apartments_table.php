<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {

          $table->id();

          $table->unsignedBigInteger('user_id');
          $table->foreign('user_id')
          ->references('id')
          ->on('users');

          $table->string('title', 100);
          $table->text('description')->nullable();
          $table->integer('rooms');
          $table->integer('beds');
          $table->integer('baths');
          $table->integer('square_mt');
          $table->string('address');
          $table->string('city', 100);
          $table->decimal('lng', 10, 7);
          $table->decimal('lat', 10, 7);
          $table->string('img_main_path')->default('/img/imgDefault.jpg');
          $table->boolean('visible')->default(true);
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
        Schema::dropIfExists('apartments');
    }
}
