<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSortOrderToRhcSpecs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('rhc_specs', function (Blueprint $table) {
        $table->tinyInteger('sort_order')->default(0)->unsigned();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('rhc_specs', function (Blueprint $table) {
        $table->dropColumn('sort_order');
      });
    }
}
