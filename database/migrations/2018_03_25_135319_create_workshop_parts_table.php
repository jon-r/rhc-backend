<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshop_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('workshop_id');
            $table->string('part_name', 255)->default('');
            $table->string('ordered_by', 255)->default('');
            $table->string('notes', 255)->default('');
            $table->decimal('part_cost', 5, 2)->default('0');

            $table->index(["workshop_id"], 'fk_workshop_parts_workshop1_idx');

            $table->foreign('workshop_id', 'fk_workshop_parts_workshop1_idx')
                ->references('id')->on('workshop')
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
        Schema::dropIfExists('workshop_parts');
    }
}
