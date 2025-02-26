<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvcVendorTimings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svc_vendor_timings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vend_id')->nullable();
            $table->integer('time_value')->default(0);			
            $table->tinyInteger('monday_status')->default(1);			
            $table->tinyInteger('tuesday_status')->default(1);			
            $table->tinyInteger('wednesday_status')->default(1);			
            $table->tinyInteger('thursday_status')->default(1);			
            $table->tinyInteger('friday_status')->default(1);			
            $table->tinyInteger('saturday_status')->default(1);			
            $table->tinyInteger('sunday_status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
			
            $table->foreign('vend_id')->references('id')->on('svc_vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('svc_vendor_timings');
    }
}
