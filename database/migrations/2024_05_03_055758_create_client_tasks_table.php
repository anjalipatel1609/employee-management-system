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
        Schema::create('client_tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->unsignedBigInteger('CS_id');
            $table->foreign('CS_id')->references('id')->on('clients_services')->onDelete('cascade');

            $table->unsignedBigInteger('CS_task_id');
            $table->foreign('CS_task_id')->references('id')->on('sub_service_tasks')->onDelete('cascade');

            $table->string('entry_date');

            $table->string('is_allocated')->default('0');
            $table->string('allocated_date')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->string('is_completed')->default('0');
            $table->string('completed_date')->nullable();

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
        Schema::dropIfExists('client_tasks');
    }
};
