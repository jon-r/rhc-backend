<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contacts_id')->nullable()->default(null);
            $table->decimal('purchase_price', 7, 2)->default('0');
            $table->string('notes', 255)->default('');
            $table->string('purchase_ref', 255)->default('');

            $table->index(["contacts_id"], 'fk_purchases_contacts1_idx');

            $table->foreign('contacts_id', 'fk_purchases_contacts1_idx')
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
        Schema::dropIfExists('purchases');
    }
}
