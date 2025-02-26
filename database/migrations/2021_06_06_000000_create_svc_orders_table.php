<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvcOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svc_orders', function (Blueprint $table) {

            $table->id();
            $table->string('order_no')->default(0);
            $table->unsignedBigInteger('vend_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('loc_id')->default(0);
            $table->unsignedBigInteger('drop_off_loc_id')->default(0);
            $table->unsignedBigInteger('cat_id')->default(0);
            $table->unsignedBigInteger('sub_cat_id')->default(0); 
            $table->unsignedBigInteger('type')->default(0);         
            $table->unsignedBigInteger('cat_price')->default(0);
            $table->unsignedBigInteger('sub_cat_price')->default(0);
            $table->unsignedBigInteger('order_value')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->tinyInteger('coupon_applied')->default(0);
            $table->integer('coupon_discount')->default(0);
            $table->tinyInteger('addons_exists')->default(0);
            $table->tinyInteger('addons_paid')->default(0);
            $table->unsignedBigInteger('transaction_id')->default(0);

	        $table->tinyInteger('vat_included')->default(0);
	        $table->double('vat_value')->default(0);
	        $table->double('final_value')->default(0);
			
            $table->text('notes');
            $table->tinyInteger('has_files')->default(0);
            $table->tinyInteger('is_rated')->default(0);

            $table->tinyInteger('has_attributes')->default(0);
            $table->text('attributes')->nullable();

            $table->tinyInteger('need_material')->default(0);
            $table->string('material_notes')->nullable();
            $table->tinyInteger('need_ironing')->default(0);
            $table->tinyInteger('cleaners')->default(0);
            $table->tinyInteger('covid')->default(0);

            $table->tinyInteger('is_ladder')->default(0);
            $table->tinyInteger('ladder_length')->default(0);

            $table->tinyInteger('need_pickup')->default(0);

            $table->integer('date_time')->nullable();
            $table->integer('date_time_drop_off')->nullable();

            $table->string('current_wall_color')->nullable();
            $table->string('new_wall_color')->nullable();
            $table->tinyInteger('provide_paint')->default(0);
            $table->unsignedBigInteger('brand_id')->default(0);
            $table->string('paint_code')->nullable();
            $table->tinyInteger('add_white_color_cost')->default(0);
            $table->tinyInteger('need_ceilings_painted')->default(0);
            $table->unsignedBigInteger('rooms')->default(0);

            $table->string('sender_name')->nullable();
            $table->string('receiver_name')->nullable();
            $table->text('message')->nullable();

            $table->tinyInteger('additional_cost')->default(0);

            $table->integer('cancelled_time')->default(0);
            $table->integer('confirmed_time')->default(0);
            $table->integer('declined_time')->default(0);
            $table->integer('accepted_time')->default(0);
            $table->integer('team_left_time')->default(0);
            $table->integer('team_reached_time')->default(0);
            $table->integer('service_delivered_time')->default(0);
            $table->integer('completed_time')->default(0);

            $table->string('cancel_reason')->nullable();
            $table->string('decline_reason')->nullable();


            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            //foreign keys
            $table->foreign('vend_id')->references('id')->on('svc_vendors')
            ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('app_users')
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
        Schema::dropIfExists('svc_orders');
    }
}
