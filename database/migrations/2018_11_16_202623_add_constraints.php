<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('projects', function (Blueprint $table)
      {
          $table->foreign('category_id')->references('id')->on('categories');
          $table->foreign('status_id')->references('id')->on('statuses');
          $table->foreign('created_by')->references('id')->on('users');
      });

      Schema::table('tasks', function (Blueprint $table)
      {
          $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
          $table->foreign('level_id')->references('id')->on('levels');
          $table->foreign('status_id')->references('id')->on('statuses');
          $table->foreign('user_id')->references('id')->on('users');
      });

      Schema::table('project_user', function (Blueprint $table)
      {
          $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
          $table->foreign('user_id')->references('id')->on('users');
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
