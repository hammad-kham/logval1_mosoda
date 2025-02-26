<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('vendor_id')->nullable();
            $table->Integer('silver_punches')->default(0);
            $table->double('silver_fixed_value')->nullable();
            $table->double('silver_discount_percentage')->nullable();
            $table->Integer('golden_punches')->default(0);
            $table->double('golden_fixed_value')->nullable();
            $table->double('golden_discount_percentage')->nullable();
            $table->Integer('platinum_punches')->default(0);
            $table->double('platinum_fixed_value')->nullable();
            $table->double('platinum_discount_percentage')->nullable();
            $table->Integer('min_order_value')->default(0);
            $table->tinyInteger('type')->default(0);
            $table->tinyInteger('has_limitations')->default(0);
            $table->Integer('intervals')->nullable();
            $table->Integer('start_date')->nullable();
            $table->Integer('end_date')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamp('activated_at')->nullable();
            $table->Integer('created_by')->nullable();
            $table->Integer('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rewards');
    }
}
