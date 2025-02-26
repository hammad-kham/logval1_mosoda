
<div class="row form-group">
    <div class="col-sm-6">
        <div class="row">


            <div class="col-sm-4">
                {!! Form::label('vendor', 'Vendor :') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $vendor_dataa->name }}</p>
            </div>


            @if($Model_Data->service_id != null)
                <div class="col-sm-4">
                    {!! Form::label('service', 'Service :') !!}
                </div>
                <div class="col-sm-8">
                    <p>{{ $service_data->title }}</p>
                </div>
            @else
                <div class="col-sm-4">
                    {!! Form::label('service', 'Service :') !!}
                </div>
                <div class="col-sm-8">
                    <p>Null</p>
                </div>
            @endif


            <div class="col-sm-4">
                {!! Form::label('created_at', 'Created At :') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->created_at }}</p>
            </div>


        </div>
    </div>

    <div class="col-sm-6">
        <div class="row">


            <div class="col-sm-4">
                {!! Form::label('price', 'Price :') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->price }}</p>
            </div>


            @if($Model_Data->sub_service_id != null)
                <div class="col-sm-4">
                    {!! Form::label('sub_service', 'Sub Service :') !!}
                </div>
                <div class="col-sm-8">
                    <p>{{ $sub_service_data->title }}</p>
                </div>
            @else
                <div class="col-sm-4">
                    {!! Form::label('sub_service', 'Sub Service :') !!}
                </div>
                <div class="col-sm-8">
                    <p>No Sub Service</p>
                </div>
            @endif


            <div class="col-sm-4">
                {!! Form::label('updated_at', 'Updated At :') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->updated_at }}</p>
            </div>


        </div>
    
        @if(Auth::user()->can('vendor-services-edit') || Auth::user()->can('all'))
            <div class="form-group row">
                <div class="col-8 text-right">
                    <a href="{{ route('vendor-services.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('vendor-services.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        @endif

    </div>
</div>