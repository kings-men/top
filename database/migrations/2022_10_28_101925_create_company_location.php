<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_locations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('company_cusine_id')->nullable();
            $table->string('restaurant_name',255)->nullable();
            $table->string('contact_name',250);
            $table->string('email',250);
            $table->string('address',255)->nullable();
            $table->string('city',100)->nullable();
            $table->string('phone_number',20);
            $table->string('restaurant_type',250)->nullable();
            $table->integer('seats')->nullable();
            $table->boolean('bar')->default(True);
            $table->boolean('parking')->default(True);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            // $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            // $table->foreign('company_cusine_id')->references('id')->on('company_cuisines')->onDelete('cascade');
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
        Schema::dropIfExists('company_locations');
    }
}
