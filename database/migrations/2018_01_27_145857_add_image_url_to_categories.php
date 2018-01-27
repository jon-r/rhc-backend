<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageUrlToCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('rhc_categories', function (Blueprint $table) {
        $table->string('description', 1024)->default('');
        $table->string('image_link', 255)->default('');
      });
      Schema::table('rhc_groups', function (Blueprint $table) {
        $table->string('description', 1024)->default('');
        $table->string('image_link', 255)->default('');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('rhc_categories', function (Blueprint $table) {
        $table->dropColumn('description');
        $table->dropColumn('image_link');
      });
      Schema::table('rhc_groups', function (Blueprint $table) {
        $table->dropColumn('description');
        $table->dropColumn('image_link');
      });
    }
}
