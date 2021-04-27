<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Apitester extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apitester_project', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('apitester_folder', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->index();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('apitester_item', function (Blueprint $table) {
            $table->id();
            $table->integer('folder_id')->index();
            $table->string('name');
            $table->text('body');
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
        Schema::dropIfExists('apitester_item');
        Schema::dropIfExists('apitester_folder');
        Schema::dropIfExists('apitester_project');
    }
}
