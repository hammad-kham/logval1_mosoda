<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUserPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');   
            $table->unsignedBigInteger('method_id');               
            $table->string('paypal_email')->nullable(); 
            $table->string('card_number')->nullable(); 
            $table->string('card_expiry_month')->nullable(); 
            $table->string('card_expiry_year')->nullable(); 
            $table->string('card_civ')->nullable();                  
            $table->tinyInteger('is_default')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
			
            $table->foreign('user_id')->references('id')->on('app_users')
            ->onDelete('cascade');
            $table->foreign('method_id')->references('id')->on('payment_methods')
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
        Schema::dropIfExists('app_user_payment_methods');
    }
}
