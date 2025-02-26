<?php
$BankDetails = $BankDetail;
foreach($BankDetails as $BankDetail)
{
	?>
<div class="row">
    <div class="col-md-4">
        {!! Form::label('company_name', 'Company Name:') !!}
    </div>
    <div class="col-md-8">       
         <p> {!! $BankDetail->company_name !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('tax_reg_no', 'Tax registration Number:') !!}
    </div>
    <div class="col-md-8">       
         <p> {!! $BankDetail->tax_reg_no !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('bank_name', 'Bank Name:') !!}
    </div>
    <div class="col-md-8">
         <p> {!! $BankDetail->bank_name !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('account_number', 'Account Number:') !!}
    </div>
    <div class="col-md-8">
         <p> {!! $BankDetail->account_number !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('address', 'Address:') !!}
    </div>
    <div class="col-md-8">
         <p> {!! $BankDetail->address !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('iban', 'IBAN:') !!}
    </div>
    <div class="col-md-8">
         <p> {!! $BankDetail->iban !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('swift_code', 'Swift code:') !!}
    </div>
    <div class="col-md-8">
         <p> {!! $BankDetail->swift_code !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
    <hr />
    </div>
</div>
    <?php
}
?>
