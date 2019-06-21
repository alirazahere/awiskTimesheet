<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps(0);
            $table->timestamp('timein', 0)->nullable();
            $table->timestamp('timeout', 0)->nullable();
            $table->string('message')->nullable();
            $table->string('remark')->nullable();;
            $table->integer('author')->unsigned();
            $table->boolean('status');
            $table->integer('attendance_id')->unsigned();
            $table->foreign('author')->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreign('attendance_id')->references('id')
                ->on('attendances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
