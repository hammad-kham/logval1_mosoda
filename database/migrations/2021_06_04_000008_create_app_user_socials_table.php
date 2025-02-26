<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUserSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user_socials', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->tinyInteger('google_status')->default(0);
            $table->string('google')->nullable();

            $table->tinyInteger('facebook_status')->default(0);
            $table->string('facebook')->nullable();

            $table->tinyInteger('instagram_status')->default(0);
            $table->string('instagram')->nullable();

            $table->tinyInteger('pinterest_status')->default(0);
            $table->string('pinterest')->nullable();

            $table->tinyInteger('twitter_status')->default(0);
            $table->string('twitter')->nullable();

            $table->tinyInteger('apple_status')->default(0);
            $table->string('apple')->nullable();

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
        Schema::dropIfExists('app_user_socials');
    }
}
