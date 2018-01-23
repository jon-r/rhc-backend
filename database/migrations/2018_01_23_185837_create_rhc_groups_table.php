<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhcGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rhc_groups', function (Blueprint $table) {
            $table->tinyIncrements('id');

            $table->string('group_name', 64);
            $table->tinyInteger('sort_order')->unsigned()->default(0);
            $table->index('sort_order');
        });

        Schema::table('rhc_categories', function (Blueprint $table) {
          $table->foreign('cat_group')->references('id')->on('rhc_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rhc_groups');
        Schema::table('rhc_categories', function(Blueprint $table) {
          $table->dropForeign('cat_group');
        });
    }
}
