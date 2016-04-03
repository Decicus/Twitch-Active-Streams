<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stream_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('_id')->unique();
            $table->string('bio');
            $table->string('social');
            $table->datetime('last_game');
            $table->datetime('last_stream');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stream_profiles');
    }
}
