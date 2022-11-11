<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('user_id');
            $table->string('business_name',255)->nullable();
            $table->integer('logo_file_id')->nullable();
            $table->enum('status',['pending','approved','rejected']);
            $table->dateTime('visit_datetime')->nullable();
            $table->integer('subscription_plan_id')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->enum('subscription_status',['pending','active','onhold','cancelled','expired']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('companies');
    }
}
