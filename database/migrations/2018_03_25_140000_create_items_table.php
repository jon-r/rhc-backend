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
            $table->mediumIncrements('id');
            $table->timestamps();

            $table->string('name', 255)->default('');
            $table->string('serial_number', 255)->default('');
            $table->unsignedTinyInteger('status')->default(0);

            $table->unsignedMediumInteger('purchases_id')->nullable();
            $table->dateTime('date_purchased')->nullable();

            $table->unsignedMediumInteger('workshop_id')->nullable();
            $table->dateTime('date_workshop_done')->nullable();
            $table->dateTime('date_scrapped')->nullable();

            $table->unsignedMediumInteger('product_id')->nullable();
            $table->dateTime('date_on_site')->nullable();

            $table->unsignedMediumInteger('sales_id')->nullable();
            $table->dateTime('date_sold')->nullable();


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
