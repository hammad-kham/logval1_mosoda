<div class="row form-group">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('title', 'Setting Name:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->title }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('value', 'Setting Value:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->value }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('created_at', 'Created At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->created_at }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('updated_at', 'Updated At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->updated_at }}</p>
            </div>
        </div>

        @if(Auth::user()->can('general-settings-edit') || Auth::user()->can('all'))
        <div class="row">
            <div class="col-sm-4">
            	&nbsp;
            </div>
            <div class="col-sm-8">
                <a href="{{ route('general-settings.edit', $Model_Data->id) }}" class='btn btn-primary'>
                   Edit
                </a>
                <a href="{{ route('general-settings.index') }}" class="btn btn-outline-dark">Cancel</a>
            </div>
        </div> 
        @endif
    </div>
</div>