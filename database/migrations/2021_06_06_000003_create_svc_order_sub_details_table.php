<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvcOrderSubDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svc_order_sub_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_id'); 
            $table->unsignedBigInteger('item_id');                          
            $table->double('quantity')->nullable();                         
            $table->double('price')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
			
            $table->foreign('detail_id')->references('id')->on('svc_order_details')
            ->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('home_items')
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
        Schema::dropIfExists('svc_order_sub_details');
    }
}
