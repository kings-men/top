<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedBigInteger('company_id');
            $table->string('equipment_number');
            $table->unsignedBigInteger('file_id');
            $table->integer('make')->nullable();
            $table->string('name');
            $table->integer('category_id')->nullable();
            $table->integer('model_no')->nullable();
            $table->string('location')->nullable();
            $table->string('sn_no')->nullable();
            $table->string('refrigerant_type')->nullable();
            $table->string('warranty_info')->nullable();
            $table->string('voltage_amps')->nullable();
            $table->dateTime('date_of_purchase')->nullable();
            $table->string('filter_no')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('file_id')->references('id')->on('files');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('equipments');
    }
}
