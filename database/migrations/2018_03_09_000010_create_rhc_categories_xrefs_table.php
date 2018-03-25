<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhcCategoriesXrefsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'rhc_categories_xrefs';

    /**
     * Run the migrations.
     * @table rhc_categories_xrefs
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('category_id');

            $table->index(["category_id"], 'rhc_categories_xrefs_category_id_foreign');

            $table->index(["product_id"], 'rhc_categories_xrefs_product_id_foreign');


            $table->foreign('category_id', 'rhc_categories_xrefs_category_id_foreign')
                ->references('id')->on('rhc_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('product_id', 'rhc_categories_xrefs_product_id_foreign')
                ->references('id')->on('rhc_products')
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
