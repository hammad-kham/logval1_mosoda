<?php
//$action_name=Route::getCurrentRoute()->getAction();
//return $action_name;
$segment1 =  Request::segment(3);

?>

@include('svc.common.vendor_field')

<div class="mt-4 row">
    <div class="col-md-3">
        {!! Form::label('company_name', 'Company Name:') !!}
    </div>
    <div class="col-md-9">
        {!! Form::text('company_name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="mt-4 row">
    <div class="col-md-3">
        {!! Form::label('tax_reg_no', 'Tax registration Number:') !!}
    </div>
    <div class="col-md-9">
        {!! Form::text('tax_reg_no', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="mt-4 row">
    <div class="col-md-3">
        {!! Form::label('bank_name', 'Bank Name:') !!}
    </div>
    <div class="col-md-9">
        {!! Form::text('bank_name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="mt-4 row">
    <div class="col-md-3">
        {!! Form::label('account_number', 'Account Number:') !!}
    </div>
    <div class="col-md-9">
        {!! Form::text('account_number', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="mt-4 row">
    <div class="col-md-3">
        {!! Form::label('address', 'Address:') !!}
    </div>
    <div class="col-md-9">
        {!! Form::text('address', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="mt-4 row">
    <div class="col-md-3">
        {!! Form::label('iban', 'IBAN:') !!}
    </div>
    <div class="col-md-9">
        {!! Form::text('iban', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="mt-4 row">
    <div class="col-md-3">
        {!! Form::label('swift_code', 'Swift code:') !!}
    </div>
    <div class="col-md-9">
        {!! Form::text('swift_code', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="mt-4 row">
    <div class="col-md-3">
        &nbsp;
    </div>
    <div class="col-md-3">
        <input id="vat_percentage" name="vat_percentage" type="checkbox" <?php if(isset($Model_Data->vat_percentage) && $Model_Data->vat_percentage > 0){?> checked="checked" <?php } ?> >
        {!! Form::label('vat_percentage', 'VAT Inclusion in Prices') !!}
    </div>
    <div class="col-md-6">
        <small class="nomodal" data-toggle="tooltip" title="VAT value is included in Prices of Items or Not. If not selected than VAT value will be included in Orders Value">
            <i class="fa fa-2x fa-info-circle"></i>
        </small>
    </div>
</div>
