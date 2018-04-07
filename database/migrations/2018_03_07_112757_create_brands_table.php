<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'rhc_brands';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->unsignedMediumInteger('image_id')->nullable();
            $table->boolean('include_on_list')->default(true);

            $table->unique(["name"], 'rhc_brands_name_unique');

            $table->foreign('image_id', 'rhc_brands_image_id_foreign')
                ->references('id')->on('site_images')
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
