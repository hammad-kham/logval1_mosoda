<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvcProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svc_products', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->unsignedBigInteger('cat_id');
            $table->unsignedBigInteger('sub_cat_id');
            $table->unsignedBigInteger('vend_id');
            $table->string('image');
            $table->double('price');
            $table->string('occasion_type');
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cat_id')->references('id')->on('svc_categories')
            ->onDelete('cascade');
            $table->foreign('sub_cat_id')->references('id')->on('svc_sub_categories')
            ->onDelete('cascade');
            $table->foreign('vend_id')->references('id')->on('svc_vendors')
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
        Schema::dropIfExists('svc_products');
    }
}
