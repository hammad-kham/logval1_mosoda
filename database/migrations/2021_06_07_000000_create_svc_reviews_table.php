<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvcReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svc_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vend_id');
            $table->unsignedBigInteger('user_id');  
            $table->unsignedBigInteger('order_id');
            $table->tinyInteger('rating_option')->default(0);
            $table->tinyInteger('rating')->default(1);
            $table->text('review')->nullable();
            $table->integer('reviewed_at');
            $table->tinyInteger('has_badwords')->default(0);
            $table->tinyInteger('is_reported')->default(0);  
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
			
            $table->foreign('vend_id')->references('id')->on('svc_vendors')
            ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('app_users')
            ->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('svc_orders')
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
        Schema::dropIfExists('svc_reviews');
    }
}
