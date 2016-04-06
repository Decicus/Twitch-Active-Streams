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
            $table->integer('_id')->unique()->index();
            $table->string('bio')->nullable();
            $table->string('last_game')->nullable();
            $table->datetime('last_stream')->nullable();
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
