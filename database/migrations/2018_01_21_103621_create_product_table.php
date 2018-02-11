<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rhc_products', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->timestamps();
            $table->mediumInteger('rhc_ref')->unsigned();
            $table->enum('rhc_status', ['to add','added','to skip'])->default('to add');
            $table->string('curlew_ref', 20)->default('');
            $table->enum('curlew_status', ['to add','added','to skip'])->default('to add');
            $table->string('shop_notes', 255)->default('');
            $table->enum('photos_status', ['to take','to edit','done'])->default('to take');
            $table->enum('print_status', ['to print','to attach','done','to skip'])->default('to print');
            $table->string('print_notes', 255)->default('');
            $table->string('invoice', 255)->default('');
            $table->string('product_name', 255)->default('');
            $table->string('description', 4098)->default('');
            $table->smallInteger('quantity')->default(1)->unsigned();
            $table->decimal('price', 7, 2)->default(0)->unsigned();
            $table->decimal('original_price', 7, 2)->default(0)->unsigned();
            $table->boolean('is_job_lot')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->enum('site_flag', ['','soon','reserved','sale','staff picks'])->default('');
            $table->enum('site_icon', [
              'Single Phase',
              'Three Phase',
              'Natural Gas',
              'LPG',
              'Dual Fuel',
              'Fridge',
              'Freezer',
              'Fridge-Freezer',
              'Domestic',
              ''
            ])->default('');
            $table->string('site_seo_text', 255)->default('');
            $table->dateTime('date_live')->nullable();
            $table->dateTime('date_sold')->nullable();

            $table->index('rhc_ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rhc_products');
    }
}
