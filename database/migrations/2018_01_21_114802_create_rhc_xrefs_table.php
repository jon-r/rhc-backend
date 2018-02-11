<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhcXrefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rhc_categories_xrefs', function (Blueprint $table) {
            $table->mediumInteger('product_id')->unsigned();
            $table->tinyInteger('category_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('rhc_products');
            $table->foreign('category_id')->references('id')->on('rhc_categories')->onDelete('cascade');
        });
        Schema::create('rhc_tags_xrefs', function (Blueprint $table) {
            $table->mediumInteger('product_id')->unsigned();
            $table->mediumInteger('tag_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('rhc_products');
            $table->foreign('tag_id')->references('id')->on('rhc_tags')->onDelete('cascade');
        });

        Schema::table('rhc_related', function (Blueprint $table) {
          $table->foreign('product_id')->references('id')->on('rhc_products');
          $table->foreign('related_id')->references('id')->on('rhc_products');
        });

        Schema::table('rhc_specs', function (Blueprint $table) {
          $table->foreign('product_id')->references('id')->on('rhc_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rhc_categories_xrefs');
        Schema::dropIfExists('rhc_tags_xrefs');
        Schema::table('rhc_related', function(Blueprint $table) {
          $table->dropForeign(['product_id, related_id']);
        });
        Schema::table('rhc_specs', function(Blueprint $table) {
          $table->dropForeign(['product_id']);
        });
    }
}
