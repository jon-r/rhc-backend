<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('invoice', 255)->default('');
            $table->unsignedMediumInteger('contacts_id')->nullable()->default(null);
            $table->decimal('invoice_price', 7, 2)->default('0');
            $table->decimal('extras_cost', 7, 2)->default('0');

            $table->string('notes', 512)->default('');

            $table->index(["contacts_id"], 'fk_sales_contacts1_idx');

            $table->foreign('contacts_id', 'fk_sales_contacts1_idx')
                ->references('id')->on('contacts')
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
        Schema::dropIfExists('sales');
    }
}
