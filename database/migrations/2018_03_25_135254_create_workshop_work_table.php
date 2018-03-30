<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshop_work', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger('workshop_id')->default(0);
            $table->string('staff_name', 255)->default('');
            $table->string('notes', 255)->default('');
            $table->string('time_taken', 255)->default('');
            $table->unsignedTinyInteger('work_type')->default(0);

            $table->index(["workshop_id"], 'fk_workshop_work_workshop1_idx');

            $table->foreign('workshop_id', 'fk_workshop_work_workshop1_idx')
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
        Schema::dropIfExists('workshop_work');
    }
}
