<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateRestaurantJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_jobs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('service_id');
            $table->text('description');
            $table->enum('schedule_type',['ASAP','Schedule']);
            $table->enum('status',['Pending','Completed','Cancelled','InProgress']);
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('restaurant_name',255);
            $table->string('restaurant_location',255);
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->enum('is_active',[1,0])->default(1);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('service_id')->references('id')->on('services');
            $table->softDeletes();
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
        Schema::dropIfExists('restaurant_jobs');
    }
}
