<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhcCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rhc_categories', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('cat_name', 32)->unique();
            $table->string('slug', 32)->unique();
            $table->tinyInteger('cat_group')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rhc_categories');
    }
}
