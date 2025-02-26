<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUserLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');    
            $table->string('nick_name');           
            $table->string('flat');               
            $table->string('building');               
            $table->string('address');    
            $table->string('lat');          
            $table->string('lng');                                  
            $table->tinyInteger('is_default')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
			
            $table->foreign('user_id')->references('id')->on('app_users')
            ->onDelete('cascade');
             
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_user_locations');
    }
}
