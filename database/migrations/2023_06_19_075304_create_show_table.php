<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function(Blueprint $table){
            $table->id();
            $table->dateTime('show_time');
            $table->foreignId('movie_id');
            $table->foreignId('theater_id');
            $table->timestamps();

            
        });

        Schema::disableForeignKeyConstraints();
        Schema::table('shows', function(Blueprint $table){
            $table->foreign('movie_id')
                ->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('theater_id')
                ->references('id')->on('theaters')->onDelete('cascade');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shows');
    }


}
