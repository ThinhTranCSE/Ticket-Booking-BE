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
            $table->timestamp('booking_date');
            $table->foreignId('show_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->timestamps();

            
        });
        Schema::disableForeignKeyConstraints();
        Schema::table('bookings', function (Blueprint $table){
            $table->foreign('show_id')
                ->references('id')->on('shows')->onDelete('set null');
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('set null');
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
