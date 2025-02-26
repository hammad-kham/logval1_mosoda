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
            $table->string('user_type')->default('admin');
            $table->unsignedBigInteger('vend_id')->default('0');
            $table->string('company_name')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('password')->nullable();
			
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('application_status')->default('0');
            $table->tinyInteger('approval_status')->default('0');
			
            $table->string('license_no')->nullable();
            $table->string('license_expiry')->nullable();
			
            $table->string('principal_place')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->string('categories')->nullable();
            $table->text('activities')->nullable();
            $table->text('comments')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('device_name')->nullable();
            $table->string('device_id')->nullable();
			
            $table->string('mode')->default('light')->nullable();
            $table->string('sidebar')->default('allports')->nullable();
            $table->string('theme')->default('allports')->nullable();
            $table->string('menu')->default('off')->nullable();
			
            $table->string('photo')->default('user.png');
			
            $table->rememberToken();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('users');
    }
}
