<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderPaymentMethodsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->bigInteger('provider_id')->unsigned();
            $table->string('payment_method');
            $table->string('account_holder_name');
            $table->text('account_number');
            $table->enum('account_holder_type',['company','individual']);
            $table->bigInteger('routing_number');
            $table->string('bank_name');
            $table->integer('last4');
            $table->integer('country_id')->unsigned();
            $table->enum('currency',['USD','AUD','ATS','IND']);
            $table->enum('status',['new','validated','verified','verification_failed','errored']);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('provider_payment_methods');
    }
}
