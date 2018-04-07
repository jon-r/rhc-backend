<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteNavigationTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'site_navigation';

    /**
     * Run the migrations.
     * @table site_navigation
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id');
            $table->string('name', 255);
            $table->string('url', 255);
            $table->unsignedTinyInteger('location_id')->default(0);
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->unsignedMediumInteger('image_id')->nullable();
            $table->boolean('load_on_init')->default(0);
            $table->string('text_content', 255)->default('');

            $table->foreign('image_id', 'site_navigation_image_id_foreign')
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
