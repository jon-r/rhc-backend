<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhcImagesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'rhc_images';

    /**
     * Run the migrations.
     * @table rhc_images
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('image_link', 255);
            $table->string('image_meta', 1024);
            $table->unsignedMediumInteger('product_id');

            $table->index(["product_id"], 'fk_rhc_images_rhc_products1_idx');


            $table->foreign('product_id', 'fk_rhc_images_rhc_products1_idx')
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
