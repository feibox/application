<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->unsignedInteger('ais_id')->nullable()->default(null);
            $table->unsignedTinyInteger('rank')->nullable()->default(null);
            $table->unsignedTinyInteger('study_level')->nullable()->default(null);
            $table->string('email')->unique();
            $table->string('user_name')->nullable()->default(null);
            $table->string('first_name')->nullable()->default(null);
            $table->string('middle_name')->nullable()->default(null);
            $table->string('last_name')->nullable()->default(null);
            $table->string('title_prefix')->nullable()->default(null);
            $table->string('title_suffix')->nullable()->default(null);
            $table->string('study_information')->nullable()->default(null);
            $table->string('password');
            $table->rememberToken();
            $table->string('registration_token', '60')->nullable()->default(null);
            $table->boolean('verified')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_valid')->default(false);
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
        Schema::drop('users');
    }
}
