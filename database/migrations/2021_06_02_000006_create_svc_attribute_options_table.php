<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvcAttributeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svc_attribute_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attributable_id')->nullable();
            $table->string('name')->nullable();
            $table->tinyInteger('num_field')->default(0);
            $table->tinyInteger('text_field')->default(0);
            $table->integer('is_mandatory')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
			
            $table->foreign('attributable_id')->references('id')->on('svc_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('svc_attribute_options');
    }
}
