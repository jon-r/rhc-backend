<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhcPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rhc_pages', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->text('content');

            $table->unique(["slug"], 'rhc_pages_slug_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rhc_pages');
    }
}
