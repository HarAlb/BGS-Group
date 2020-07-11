<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // Now I don't use slug , but maybe use in future
            $table->string('slug')->unique();
            $table->text('description');

            $table->unsignedBigInteger('creator_id');
            $table->string('creator_name');
            $table->string('feature')->nullable();
            $table->date('event_start')->nullable();
            $table->date('event_end')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_id')->references('id')->on('users');
            $table->index('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
