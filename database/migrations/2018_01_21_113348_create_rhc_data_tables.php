<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhcDataTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('rhc_tags', function (Blueprint $table) {
          $table->mediumIncrements('id');
          $table->string('name', 32)->unique();
      });
      Schema::create('rhc_specs', function (Blueprint $table) {
          $table->increments('id');
          $table->mediumInteger('product_id')->unsigned();
          $table->string('name', 64);
          $table->string('value', 255);
      });
      Schema::create('rhc_related', function (Blueprint $table) {
        $table->mediumInteger('product_id')->unsigned();
        $table->mediumInteger('related_id')->unsigned();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('rhc_tags');
      Schema::dropIfExists('rhc_specs');
      Schema::dropIfExists('rhc_related');
    }
}
