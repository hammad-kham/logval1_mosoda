
<div class="row justify-content-center text-center mt-2 mb-2 form-group">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('title', 'Contact Name:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->title }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('value', 'Contact Value:') !!}
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
    
        @if(Auth::user()->can('contact-details-edit') || Auth::user()->can('all'))
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                    <a href="{{ route('contact-details.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('contact-details.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        @endif
        
    </div>
</div>