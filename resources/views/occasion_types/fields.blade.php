
<div class="form-group row">
	<div class="col-sm-6">
        {!! Form::label('title', 'Title [En]:') !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-sm-6">
        {!! Form::label('ar_title', 'Title [Ar]:') !!}
        {!! Form::text('ar_title', null, ['class' => 'form-control']) !!}
	</div>
</div>

<?php
if(isset($Model_Data)){
?>
<div class="row mt-3">
    <div class=" form-group col-12 text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('occasion-types.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<?php
}
?>
