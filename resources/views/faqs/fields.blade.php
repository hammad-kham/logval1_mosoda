
<div class="form-group row">
	<div class="col-sm-6">
        {!! Form::label('topic_id', 'Topic:') !!}
		
		<?php
		if(isset($Model_Data)){
			?>
		{!! Form::select('topic_id', $topics, $Model_Data->topic_id, ['class' => 'form-control','id'=>'type'] ); !!}
		<?php
		}
		else{
			?>
		{!! Form::select('topic_id', $topics, null, ['class' => 'form-control','id'=>'type'] ); !!}
		<?php
		}
		?>
		
    </div>
</div>
<div class="form-group row">
	<div class="col-sm-6">
        {!! Form::label('question', 'Question:') !!}
        {!! Form::textArea('question', null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-sm-6">
        {!! Form::label('answer', 'Answer:') !!}
        {!! Form::textArea('answer', null, ['class' => 'form-control']) !!}
    </div>
</div>


<?php
if(isset($Model_Data)){
?>
<div class="row mt-3">
    <div class=" form-group col-12 text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('faqs.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<?php
}
?>


