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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('password');
            $table->boolean('is_admin');
            $table->string('login_id')->unique();
            $table->string('status')->default('active');
            $table->date('purchase_date')->nullable();
            $table->date('renewal_date')->nullable();
            $table->string('image_link')->nullable();
            $table->rememberToken();
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
};
