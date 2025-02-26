<?php
//$action_name=Route::getCurrentRoute()->getAction();
//return $action_name;
$segment1 =  Request::segment(3);
?>
@if(Auth::user()->vend_id==0 && isset($vendors_array[$Model_Data->vend_id]))
    <div class="row">
        <div class="col-md-4">
            {!! Form::label('vendor', 'Vendor:') !!}
        </div>
        <div class="col-md-8">
            <p>{{ $vendors_array[$Model_Data->vend_id] }}</p>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-4">
        {!! Form::label('company_name', 'Company Name:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $Model_Data->company_name !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('tax_reg_no', 'Tax registration Number:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $Model_Data->tax_reg_no !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('bank_name', 'Bank Name:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $Model_Data->bank_name !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('account_number', 'Account Number:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $Model_Data->account_number !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('address', 'Address:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $Model_Data->address !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('iban', 'IBAN:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $Model_Data->iban !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('swift_code', 'Swift code:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $Model_Data->swift_code !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('vat', 'VAT Inclusion in Prices:') !!}
    </div>
    <div class="col-md-8">
        <p>
            <?php
            if($Model_Data->vat_percentage == 0)
            {
                echo 'No, VAT value is not Included in prices.';
            }
            else
            {
                echo 'Yes, VAT value is Included in prices.';
            }
            ?>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        {!! Form::label('created_at', 'Created At:') !!}
    </div>
    <div class="col-sm-8">
        <p>{{ $Model_Data->created_at }}</p>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        {!! Form::label('updated_at', 'Updated At:') !!}
    </div>
    <div class="col-sm-8">
        <p>{{ $Model_Data->updated_at }}</p>
    </div>
</div>

@if(Auth::user()->can('vendor-bank-details-edit') || Auth::user()->can('all'))
    <div class="row">
        <div class="col-sm-12 text-center">
            <a href="{{ route('vendor-bank-details.edit', $Model_Data->id) }}" class='btn btn-primary'>
                Edit
            </a>
            <a href="{{ route('vendor-bank-details.index') }}" class="btn btn-outline-dark">Cancel</a>
        </div>
    </div>
@endif
