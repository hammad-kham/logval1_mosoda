<div class="row">
<?php
$disabled = "";
if(isset($Model_Data->id) && $Model_Data->id != ""){
    $disabled = "readonly";
}
?>
<!-- Page Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('app_page', 'Topic:') !!}
        {!! Form::select('topic_app_page_id', $app_pages, null, ['class' => 'form-control',$disabled] ); !!}
    </div>

    <!-- Location Field -->
    <div class="form-group col-sm-6">

    </div>
</div>
<div class="row">
    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('title', 'Title [ English ]') !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Arabic Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('ar_title', 'Title [ Arabic ]') !!}
        {!! Form::text('ar_title', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-10 ">
        {!! Form::label('image', 'Banner Image:') !!}
        {!! Form::file('image', null, ['placeholder' => '', 'class' => 'form-control' , 'required' => '']) !!}
    </div>
</div>


<div class="row text-right">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('banners.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

