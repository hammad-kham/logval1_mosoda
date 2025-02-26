
<div class="row justify-content-center mt-2 mb-2 form-group">
    <div class="col-sm-6">
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('name', 'Name [En]:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('name_ar', 'Name [Ar]:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::text('name_ar', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('file_upload', 'Icon:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::file('file_upload', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-sm-12 text-center">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ url('/service/reward_discount_types') }}" class="btn btn-outline-dark">Cancel</a>
            </div>
        </div>
    </div>

</div>
