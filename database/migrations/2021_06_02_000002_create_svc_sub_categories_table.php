<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvcSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svc_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('static_id')->default(0);
            $table->unsignedBigInteger('cat_id');
            $table->string('title', 50);
            $table->string('ar_title', 50);
            $table->string('description')->nullable;
            $table->string('ar_description')->nullable;
            $table->tinyInteger('type')->default(0);
            $table->string('icon', 50)->nullable;
            $table->tinyInteger('has_services')->default('0');
            $table->tinyInteger('has_attributes')->default('0');
            $table->tinyInteger('has_brands')->default('0');
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cat_id')->references('id')->on('svc_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('svc_sub_categories');
    }
}
