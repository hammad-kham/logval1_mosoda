<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackendNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backend_notifications', function (Blueprint $table) {
            $table->id();
	
	
	        $table->unsignedBigInteger('app_user_id');
	        $table->unsignedBigInteger('user_id');
	        $table->string('module')->nullable();
	        $table->string('type')->nullable();
	        $table->unsignedBigInteger('type_id');
			
            $table->string('message');
            $table->tinyInteger('read_status')->default(0);
            $table->integer('read_time')->default(0);

            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('app_user_id')->references('id')->on('app_users')
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
        Schema::dropIfExists('backend_notifications');
    }
}
