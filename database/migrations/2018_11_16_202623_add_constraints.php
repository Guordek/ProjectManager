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
          $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
          $table->foreign('id_status')->references('id')->on('statuses')->onDelete('cascade');
      });

      Schema::table('tasks', function (Blueprint $table)
      {
          $table->foreign('id_project')->references('id')->on('projects')->onDelete('cascade');
          $table->foreign('id_level')->references('id')->on('levels')->onDelete('cascade');
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
