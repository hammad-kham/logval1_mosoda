<?php
//$action_name=Route::getCurrentRoute()->getAction();
//return $action_name;
$segment1 =  Request::segment(3);
?>

<div class="row">
    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Arabic Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('arabic_name', 'Name [ Ar ]:') !!}
        {!! Form::text('arabic_name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <!-- Phone Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('phone', 'Phone#:') !!}
        {!! Form::text('phone', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Email Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <!-- Instagram Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('website', 'Website:') !!}
        {!! Form::text('website', null, ['class' => 'form-control']) !!}
    </div>
    <!-- Profile Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('profile', 'Profile:') !!}
        {!! Form::file('profile', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <!-- Description Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('description', 'Description:') !!}
        {!! Form::textarea('description', null, ['placeholder' => 'Your Comment', 'class' => 'form-control' , 'cols' => 10, 'rows' =>5, 'required' => '', 'maxlength' => "200"]) !!}
    </div>

    <!-- Description in arabic Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('description', 'Description [ Ar ]:') !!}
        {!! Form::textarea('arabic_description', null, ['placeholder' => 'Your Comment', 'class' => 'form-control' , 'cols' => 10, 'rows' =>5, 'required' => '', 'maxlength' => "200"]) !!}
    </div>
</div>