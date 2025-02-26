
<div class="row mt-2 mb-2 form-group">
    <div class="col-sm-12">
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('badword', 'BadWord:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::text('badword', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class=" form-group col-12 text-right">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('bad-words.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
    
</div>
