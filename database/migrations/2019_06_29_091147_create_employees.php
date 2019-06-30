<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('employees');
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('phone', 255);
            $table->string('email', 255);
            $table->float('salary');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('head_id')->nullable();
            $table->unsignedBigInteger('admin_updated_id');
            $table->unsignedBigInteger('admin_created_id');
            $table->foreign('position_id')->references('id')->on('position');
            $table->foreign('head_id')->references('id')->on('employees');
            $table->foreign('admin_updated_id')->references('id')->on('users');
            $table->foreign('admin_created_id')->references('id')->on('users');
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
        Schema::dropIfExists('employees');
    }
}
