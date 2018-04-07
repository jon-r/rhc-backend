<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users', function(Blueprint $t)
      {
          $t->smallIncrements('id')->unsigned();
          $t->string('username', 255)->nullable()->unique();
          $t->string('password', 127);
          $t->enum('role', ['user', 'admin'])->index();
          $t->timestamps();
      });
      $user = new User;
      $user->username = 'admin';
      $user->password = Hash::make('secret');
      $user->role = 'admin';
      $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
