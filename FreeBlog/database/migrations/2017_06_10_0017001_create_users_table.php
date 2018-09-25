<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('image_thumbnail')->nullable();
            $table->longText('description')->nullable();
            $table->date('birthdate')->nullable();

            $table->integer('user_type_id')->unsigned();    
            $table->foreign('user_type_id')->references('id')->on('user_types');

            $table->string('confirmation_code')->nullable();
            $table->timestamp('logged_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
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
