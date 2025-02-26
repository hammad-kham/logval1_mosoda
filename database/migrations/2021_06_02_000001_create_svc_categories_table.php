<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvcCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svc_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->string('ar_title', 50);
            $table->text('description')->nullable();
            $table->text('ar_description')->nullable();
            $table->string('icon')->nullable();
            $table->string('ban_image')->nullable();
            $table->string('thumb_image')->nullable();
            $table->tinyInteger('has_subcategories')->default('0');
            $table->tinyInteger('is_featured')->default('0');
            $table->tinyInteger('has_attributes')->default('0');
            $table->tinyInteger('has_brands')->default('0');
            $table->tinyInteger('is_order')->default('0');
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
        Schema::dropIfExists('svc_categories');
    }
}
