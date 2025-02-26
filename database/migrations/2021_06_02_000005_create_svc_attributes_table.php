<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvcAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svc_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attributable_id')->nullable();
            $table->string('attributable_type')->nullable();
            $table->string('name')->nullable();
            $table->string('input_name')->nullable();
            $table->integer('price_status')->default(1);
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
        Schema::dropIfExists('svc_attributes');
    }
}
