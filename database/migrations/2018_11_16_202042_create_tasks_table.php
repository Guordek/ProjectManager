<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->longText('description');
          $table->date('start');
          $table->date('end');
          $table->string('slug');
          $table->integer('project_id')->unsigned();
          $table->integer('user_id')->unsigned();
          $table->integer('level_id')->unsigned();
          $table->integer('status_id')->unsigned();
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
        Schema::dropIfExists('tasks');
    }
}
