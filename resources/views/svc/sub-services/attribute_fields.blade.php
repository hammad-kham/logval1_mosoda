
<input type="hidden" value="{{$Model_Data->id}}" name="sub_service_id">

<div class="form-group row">
    <div class="col-sm-12">
        {!! Form::label('attribute_name', 'Attribute Name:') !!}
        {!! Form::text('attribute_name', null, ['class' => 'form-control','required' => 'required']) !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <h6>Options</h6>
    </div>
</div>

<?php
$types = array();
$types['0'] = 'Number';
$types['1'] = 'Text';
?>

<div id="variation_div">
    <div class="variations"  style="padding: 10px;">
        <div class="row">
            <div class="form-group col-sm-4">
                <h6>Option </h6>
            </div>
            <div class="form-group col-sm-8">
                    {!! Form::button('+', ['class' => 'btn btn-primary add_variations','id' => 'add_variations', 'style'=>'float:right']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name[]', null, ['placeholder' => 'Name','class' => 'form-control','required' => 'required']) !!}
            </div>
            <div class="col-sm-12">
                {!! Form::label('type', 'Type:') !!}
                {!! Form::select('type[]', $types, null, ['class' => 'form-control','required' => 'required']) !!}
            </div>
            <div class="col-sm-12" style="margin-top: 10px">
                <input id="is_mandatory" name="is_mandatory" type="checkbox" checked>
                {!! Form::label('is_mandatory', 'Mandatory') !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class=" form-group col-12 text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('sub-services.edit', $Model_Data->id) }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>
