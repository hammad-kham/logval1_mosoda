<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvcOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svc_order_details', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('sub_cat_id')->default(0);
            $table->unsignedBigInteger('service_id')->default(0);
            $table->unsignedBigInteger('sub_service_id')->default(0);
            $table->unsignedBigInteger('brand_id')->default(0);
            $table->unsignedBigInteger('product_id')->default(0);
            $table->unsignedBigInteger('quantity')->default(0);
            $table->unsignedBigInteger('service_price')->default(0);
            $table->unsignedBigInteger('sub_service_price')->default(0);
            $table->unsignedBigInteger('product_price')->default(0);


            $table->tinyInteger('bed_rooms')->default(0);
            $table->tinyInteger('living_rooms')->default(0);
            $table->tinyInteger('dining_rooms')->default(0);
            $table->tinyInteger('maid_rooms')->default(0);
            $table->tinyInteger('storage_rooms')->default(0);
            $table->tinyInteger('garage_or_garden')->default(0);

            $table->tinyInteger('has_attributes')->default(0);
            $table->text('attributes')->nullable();


            // extras and will be removed in future when setting old flows orders
            {

                $table->tinyInteger('covid')->default(0);
                $table->tinyInteger('repitition')->default(0);
                $table->tinyInteger('daily_hours')->default(0);
                $table->tinyInteger('cleaners')->default(0);
                $table->tinyInteger('need_material')->default(0);
                $table->string('material_notes')->nullable();
                $table->tinyInteger('need_ironing')->default(0);
                $table->string('ironing_notes')->nullable();
                $table->string('device_name')->nullable();
                $table->tinyInteger('small_items')->default(0);
                $table->tinyInteger('medium_items')->default(0);
                $table->tinyInteger('large_items')->default(0);
                $table->tinyInteger('is_ladder')->default(0);
                $table->tinyInteger('ladder_length')->default(0);
                $table->unsignedBigInteger('home_type_id')->default(0);
                $table->string('current_wall_color')->nullable();
                $table->string('required_wall_color')->nullable();
                $table->tinyInteger('is_ceileing_color')->default(0);
                $table->string('ceileing_color')->nullable();

                $table->tinyInteger('pet_size')->default(1);
                $table->tinyInteger('need_pickup')->default(1);
                $table->double('price')->nullable();
                $table->integer('date_time')->nullable();
                $table->integer('date_time_drop_off')->nullable();

            }



            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')->on('svc_orders')
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
        Schema::dropIfExists('svc_order_details');
    }
}
