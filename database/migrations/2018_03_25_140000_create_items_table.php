<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 255)->default('');
            $table->unsignedTinyInteger('status')->default(0);
            $table->string('serial_number', 255)->default('');

            $table->unsignedInteger('purchases_id')->nullable();
            $table->dateTime('purchased_date')->nullable();

            $table->unsignedInteger('workshop_id')->nullable();
            $table->dateTime('workshop_in')->nullable();
            $table->dateTime('workshop_out')->nullable();

            $table->unsignedInteger('product_id')->nullable();
            $table->dateTime('date_live')->nullable();
            $table->dateTime('date_sold')->nullable();

            $table->unsignedInteger('sales_id')->nullable();
            $table->dateTime('date_scrapped')->nullable();


            $table->index(["product_id"], 'fk_items_rhc_products1_idx');
            $table->index(["workshop_id"], 'fk_items_workshop1_idx');
            $table->index(["sales_id"], 'fk_items_sales1_idx');
            $table->index(["purchases_id"], 'fk_items_purchases1_idx');

            $table->foreign('product_id', 'fk_items_rhc_products1_idx')
                ->references('id')->on('rhc_products')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('workshop_id', 'fk_items_workshop1_idx')
                ->references('id')->on('workshop')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('sales_id', 'fk_items_sales1_idx')
                ->references('id')->on('sales')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('purchases_id', 'fk_items_purchases1_idx')
                ->references('id')->on('purchases')
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
        Schema::dropIfExists('items');
    }
}
