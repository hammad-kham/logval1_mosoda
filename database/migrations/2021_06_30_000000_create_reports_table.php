<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_user_id');
            $table->unsignedBigInteger('user_id');
            $table->string('ref_type')->default(null);
            $table->unsignedBigInteger('ref_id')->default(0);
            $table->text('reason')->default(null);
            $table->integer('report_time')->default(0);
            $table->tinyInteger('status')->default(1); 
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();			
            $table->timestamps();
            $table->softDeletes();
			
            $table->foreign('app_user_id')->references('id')->on('app_users')
            ->onDelete('cascade');
			
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('reports');
    }
}
