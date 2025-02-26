<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvcBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svc_bank_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vend_id');
            $table->string('company_name')->nullable();
            $table->string('tax_reg_no')->nullable();            
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('address')->nullable();
            $table->string('iban')->nullable();
            $table->string('swift_code')->nullable();
            $table->tinyInteger('vat_percentage')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
			
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
        Schema::dropIfExists('svc_bank_details');
    }
}
