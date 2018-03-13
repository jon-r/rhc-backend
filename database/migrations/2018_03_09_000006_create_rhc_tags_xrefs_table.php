<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhcTagsXrefsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'rhc_tags_xrefs';

    /**
     * Run the migrations.
     * @table rhc_tags_xrefs
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedMediumInteger('product_id');
            $table->unsignedMediumInteger('tag_id');

            $table->index(["tag_id"], 'rhc_tags_xrefs_tag_id_foreign');

            $table->index(["product_id"], 'rhc_tags_xrefs_product_id_foreign');


            $table->foreign('product_id', 'rhc_tags_xrefs_product_id_foreign')
                ->references('id')->on('rhc_products')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('tag_id', 'rhc_tags_xrefs_tag_id_foreign')
                ->references('id')->on('rhc_tags')
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
