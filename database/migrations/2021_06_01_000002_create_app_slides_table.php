<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('ar_title');                
            $table->tinyInteger('module');
            $table->tinyInteger('type')->default('0');
            $table->text('description');
            $table->text('ar_description');
            $table->string('image', 200);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('app_slides');
    }
}
