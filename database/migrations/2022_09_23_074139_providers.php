<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Providers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('user_id');
            $table->string('bussiness_name',250);
            $table->string('contact_number',20);
            $table->string('address',250);
            $table->string('city',100);
            $table->integer('zipcode');
            $table->unsignedBigInteger('state_id');
            $table->dateTime('dob');
            $table->string('ssn',100);
            $table->double('experience_years', 10,2);
            $table->string('education',250);
            $table->string('previous_employer',250);
            $table->string('referral',250);
            $table->string('trade_education',250);
            $table->text('bio');
            $table->double('preferred_distance',8,2);
            $table->string('insurance',250);
            $table->string('trade_organization',250);
            $table->double('hourly_rate', 10,2);
            $table->double('weekend_rate', 10,2);
            $table->enum('status',['pending','approved','suspended']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');

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
        Schema::dropIfExists('providers');
    }
}
