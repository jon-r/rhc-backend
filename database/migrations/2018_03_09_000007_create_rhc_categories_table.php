<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhcCategoriesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'rhc_categories';

    /**
     * Run the migrations.
     * @table rhc_categories
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('cat_name', 32);
            $table->string('slug', 32);
            $table->unsignedInteger('group_id')->default('0');
            $table->unsignedTinyInteger('sort_order')->default('0');
            $table->string('description', 1024)->default('');
            $table->string('image_link', 255)->default('');

            $table->index(["group_id"], 'rhc_categories_group_id_foreign');

            $table->unique(["slug"], 'rhc_categories_slug_unique');

            $table->unique(["cat_name"], 'rhc_categories_cat_name_unique');


            $table->foreign('group_id', 'rhc_categories_group_id_foreign')
                ->references('id')->on('rhc_groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
