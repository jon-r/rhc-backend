<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteNavigationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_navigation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('url', 255);
            $table->string('location', 255);
            $table->tinyInteger('sort_order')->default(0)->unsigned();
            $table->string('image_link', 255)->default('');
        });
        Schema::create('site_content', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('location', 255);
            $table->string('value', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_navigation');
        Schema::dropIfExists('site_content');
    }
}
