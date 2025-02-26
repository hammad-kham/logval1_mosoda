
<div class="row justify-content-center mt-2 mb-2 form-group">
    <div class="col-sm-6">
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('name', 'Name [En]:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->name }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('name_ar', 'Name [Ar]:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->name_ar }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('created_at', 'Created At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->created_at }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('updated_at', 'Updated Ait:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->updated_at }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12 text-center">
                <a href="{{ url('/service/reward_discount_type/edit', $Model_Data->id) }}" class='btn btn-primary'>
                   Edit
                </a>
                <a href="{{ url('service/reward_discount_types') }}" class="btn btn-outline-dark">Cancel</a>
            </div>
        </div>
    </div>

</div>