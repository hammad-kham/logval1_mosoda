<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->id();        
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('new_email')->nullable();
            $table->string('email_otp')->nullable();
            $table->string('new_phone')->nullable();
            $table->string('phone_otp')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();            
            $table->timestamp('date_of_birth')->nullable();
            $table->double('balance')->default(0);
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();         
            $table->tinyInteger('email_verified')->default('0');
            $table->timestamp('email_verified_at')->nullable();    
            $table->tinyInteger('phone_verified')->default('0');
            $table->timestamp('phone_verified_at')->nullable();  
            $table->string('device_name')->nullable();
            $table->string('device_id')->nullable();
            $table->tinyInteger('interested_in')->nullable(); 
            $table->double('rating')->default('0'); 
            $table->integer('no_of_reviews')->default('0');     
            $table->integer('follow_count')->default('0'); 
            $table->tinyInteger('photo_type')->default('0');                              
            $table->string('photo')->default('app_user.png');   
            $table->tinyInteger('is_reported')->default('0');        
            $table->tinyInteger('status')->default('1');
            $table->integer('suspend_time')->default(0);
            $table->string('suspend_reason')->nullable();      
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('type')->default('phone');
            $table->string('sent_to');
            $table->string('code'); 
            $table->tinyInteger('verified')->default('1');
            $table->timestamp('verified_at')->nullable();
            $table->string('token')->nullable();
            $table->tinyInteger('expired')->default('1');
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->string('device_id')->nullable();           
            $table->timestamps();
        });


        Schema::create('app_user_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('type')->nullable(); 
            $table->string('old_value')->nullable(); 
            $table->string('new_value')->nullable(); 
                      
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
        Schema::dropIfExists('verification_codes');
        Schema::dropIfExists('app_users');
        Schema::dropDatabaseIfExists(('app_user_logs'));
    }
}
