
<div class="form-group row">
	<div class="form-group col-sm-6">
        {!! Form::label('code', 'Code:') !!}
        {!! Form::text('code', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
	</div>
</div>

<?php 
if(isset($Model_Data))
{
    $rate = $Model_Data->rate;
}
else {
    
    $rate = 1;
}
?>

<div class="form-group row">
	<div class="form-group col-sm-6">
        {!! Form::label('rate', 'Rate:') !!}
        {!! Form::number('rate', $rate, ['class' => 'form-control', 'step' => 1, 'min' => 1]) !!}
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('symbol', 'Symbol:') !!}
        {!! Form::text('symbol', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div> 
</div>

<div class="form-group row">
    <div class="form-group col-sm-6">
        {!! Form::label('is_default', 'Is Default') !!}
        <br>
        <br>
        @if(isset($Model_Data))                
            <input name="is_default" value="Yes" type="radio" {{ $Model_Data->is_default == 1 ? 'checked' : ''}}>
            {!! Form::label('yes', 'Yes') !!}
            &nbsp;
            <input name="is_default" value="No" type="radio" {{ $Model_Data->is_default == 0 ? 'checked' : ''}}>
            {!! Form::label('no', 'No') !!}
        @else
            <input name="is_default" value="Yes" type="radio">
            {!! Form::label('yes', 'Yes') !!}
            &nbsp;
            <input name="is_default" value="No" type="radio">
            {!! Form::label('no', 'No') !!}     
        @endif
    </div>    
</div>


<?php
if(isset($Model_Data)){
?>
<div class="row mt-3">
    <div class=" form-group col-12 text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<?php
}
?>

