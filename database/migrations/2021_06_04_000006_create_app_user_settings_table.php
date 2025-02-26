<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            
            $table->unsignedBigInteger('country')->default('1');
            $table->unsignedBigInteger('currency')->default('1');
            $table->unsignedBigInteger('language')->default('1');
            
            $table->tinyInteger('discount_sales')->default('1');
            $table->tinyInteger('discount_sales_preference')->default('2');
            
            $table->tinyInteger('new_stuff')->default('1');
            $table->tinyInteger('new_stuff_preference')->default('2');
            
            $table->tinyInteger('new_collections')->default('1');
            $table->tinyInteger('new_collections_preference')->default('2');
            
            $table->tinyInteger('stock')->default('1');
            $table->tinyInteger('stock_preference')->default('2');
            
            $table->tinyInteger('updates')->default('1');
            $table->tinyInteger('updates_preference')->default('2');
            
            $table->tinyInteger('dark_mode')->default('0');
    
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
			
            $table->foreign('user_id')->references('id')->on('app_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_user_settings');
    }
}
