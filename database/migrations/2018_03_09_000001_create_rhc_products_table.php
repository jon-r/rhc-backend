<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhcProductsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'rhc_products';

    /**
     * Run the migrations.
     * @table rhc_products
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('rhc_ref');
            $table->unsignedTinyInteger('rhc_status')->default(0);
            $table->string('curlew_ref', 20)->default('');
            $table->unsignedTinyInteger('curlew_status')->default(0);
            $table->string('shop_notes', 255)->default('');
            $table->unsignedTinyInteger('photos_status')->default(0);
            $table->unsignedTinyInteger('print_status')->default(0);
            $table->unsignedTinyInteger('ebay_status')->default(0);
            $table->string('print_notes', 255)->default('');
            $table->string('product_name', 255)->default('');
            $table->string('description', 4098)->default('');
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->decimal('price', 7, 2)->default('0');
            $table->decimal('original_price', 7, 2)->default(0);
            $table->boolean('is_job_lot')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->unsignedTinyInteger('site_flag')->default(0);
            $table->unsignedTinyInteger('site_icon')->default(0);
            $table->string('site_seo_text', 255)->default('');
            $table->string('video_link', 255)->default('');

            $table->index(["rhc_ref"], 'rhc_products_rhc_ref_index');

            $table->unique(["rhc_ref"], 'rhc_ref_UNIQUE');
            $table->nullableTimestamps();
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
