
<div class="row justify-content-center mt-2 mb-2 form-group">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('name', 'Name:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('display_to', 'Display:') !!}
            </div>
            @if($Model_Data->display_to == 0)
                <div class="col-sm-8">
                    <p>For Admin Users Only</p>
                </div>
            @elseif($Model_Data->display_to == 1)
                <div class="col-sm-8">
                    <p>For Vendor Users Only</p>
                </div>
            @elseif($Model_Data->display_to == 2)
                <div class="col-sm-8">
                    <p>For Seller Users Only</p>
                </div>
            @endif
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
    
        @if(Auth::user()->can('roles-edit') || Auth::user()->can('all'))
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                    <a href="{{ route('roles.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        @endif
        
    </div>
</div>