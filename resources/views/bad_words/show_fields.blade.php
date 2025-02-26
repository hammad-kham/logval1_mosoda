
<div class="row mt-2 mb-2 form-group">
    <div class="col-sm-12">
        <div class="row mt-3">
            <div class="col-sm-4 form-group">
                {!! Form::label('name', 'Bad Word:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->badword }}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4 form-group">
                {!! Form::label('created_at', 'Created At:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->created_at }}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4 form-group">
                {!! Form::label('updated_at', 'Updated At:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->updated_at }}
            </div>
        </div>
    
        @if(Auth::user()->can('bad-words-edit') || Auth::user()->can('all'))
            <div class="row mt-3">
                <div class="col-sm-12 text-center">
                    <a href="{{ route('bad-words.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('bad-words.index') }}" class="btn btn-outline-dark">Cancel</a>
                </div>
            </div>
        @endif
    </div>
</div>