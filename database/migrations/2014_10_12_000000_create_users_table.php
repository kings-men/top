<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('username')->unique()->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('user_type', 255)->nullable();
            $table->string('contact_number', 255)->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string('login_type')->nullable();
            $table->unsignedBigInteger('service_address_id')->nullable();
            $table->string('uid')->nullable();
            $table->string('city')->nullable();
            $table->tinyInteger('is_available')->nullable()->default('0')->comment('1- true , 0- false');
            $table->string('designation')->nullable();
            $table->time('last_online_time')->nullable();
            $table->integer('zipcode')->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->text('address')->nullable();
            $table->string('player_id')->nullable();
            $table->tinyInteger('status')->nullable()->default('1');
            $table->string('display_name')->nullable();
            $table->unsignedBigInteger('providertype_id')->nullable();
            $table->tinyInteger('is_featured')->nullable()->default('0');
            $table->string('time_zone')->default('UTC');
            $table->timestamp('last_notification_seen')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
