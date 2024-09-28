<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('system_users')->onDelete('cascade');

            $table->string('employee_name');
            $table->string('employee_phone')->unique();
            $table->string('employee_email')->unique();
            $table->string('employee_address');
            $table->string('user_type');
            $table->string('employee_password');
            $table->string('employee_confirm_password');

            $table->string('date_time');
            $table->string('is_active')->default('1');

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
};
