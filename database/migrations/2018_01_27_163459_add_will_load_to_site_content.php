<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWillLoadToSiteContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('site_content', function (Blueprint $table) {
        $table->boolean('load_on_init')->default(false);
      });
      Schema::table('site_navigation', function (Blueprint $table) {
        $table->boolean('load_on_init')->default(false);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('site_content', function (Blueprint $table) {
        $table->dropColumn('load_on_init');
      });
      Schema::table('site_navigation', function (Blueprint $table) {
        $table->dropColumn('load_on_init');
      });
    }
}
