<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvcVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('svc_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('arabic_name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('website', 250)->nullable();
            $table->string('location', 250);
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('image')->default('vendor.png');
            $table->text('description')->nullable();
            $table->text('arabic_description')->nullable();
            $table->integer('avg_time')->default('20');
            $table->string('qrcode', 250)->nullable();
            $table->double('rating')->default('0');
            $table->integer('reviews')->default('0');
            $table->integer('likes')->default('0');
            $table->tinyInteger('is_open')->default('1');
            $table->tinyInteger('is_featured')->default('0');
            $table->tinyInteger('is_exclusive')->default('0');
            $table->double('covid_charges')->default('0');
            $table->double('cleaning_material_charges')->default('0');
            $table->double('ironing_charges')->default('0');
            $table->double('pickup_charges')->default('0');
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('svc_vendors');
    }
}
