<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('booking_date')->default(date('Y-m-d H:i:s'));
            $table->foreignId('show_id');
            $table->foreignId('user_id');
            $table->timestamps();

            
        });
        Schema::disableForeignKeyConstraints();
        Schema::table('bookings', function (Blueprint $table){
            $table->foreign('show_id')
                ->references('id')->on('shows');
            $table->foreign('user_id')
                ->references('id')->on('users');
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
        Schema::dropIfExists('bookings');
    }
}
