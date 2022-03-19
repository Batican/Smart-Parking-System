<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('qrCode_path')->nullable();
            $table->string('qrCode_value')->nullable();
            $table->enum('slotFor',['Public', 'Guest']);
            $table->string('parking_number');
            $table->string('type');
            $table->unsignedInteger('department_id');
            $table->integer('status'); // 1 = AVAILABLE, 2 = OCCUPIED, 3 = RESERVED 
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
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
        Schema::dropIfExists('parking_slots');
    }
}
