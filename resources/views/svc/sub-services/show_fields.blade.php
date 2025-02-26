<div class="row col-sm-12">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4">
                        {!! Form::label('cat_id', 'Category:') !!}
                    </div>
                    <div class="col-sm-8">
                        <p>{{ $categories_array[$Model_Data->cat_id] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4">
                        {!! Form::label('sub_cat_id', 'SubCategory:') !!}
                    </div>
                    <div class="col-sm-8">
                        <p>{{ $sub_categories_array[$Model_Data->sub_cat_id] }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4">
                        {!! Form::label('service_id', 'Service:') !!}
                    </div>
                    <div class="col-sm-8">
                        <p>{{ $services_array[$Model_Data->service_id] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4">
                        {{--              {!! Form::label('sub_cat_id', 'SubCategory:') !!}--}}
                    </div>
                    <div class="col-sm-8">
                        {{--               <p>{{ $sub_categories_array[$Model_Data->sub_cat_id] }}</p>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4">
                        {!! Form::label('title', 'Title [En]:') !!}
                    </div>
                    <div class="col-sm-8">
                        <p>{{ $Model_Data->title }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        {!! Form::label('description', 'Description [En]:') !!}
                    </div>
                    <div class="col-sm-8">
                        <p>{{ $Model_Data->description }}</p>
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
            </div>

            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4">
                        {!! Form::label('title', 'Title [Ar]:') !!}
                    </div>
                    <div class="col-sm-8">
                        <p>{{ $Model_Data->ar_title }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        {!! Form::label('description', 'Description [Ar]:') !!}
                    </div>
                    <div class="col-sm-8">
                        <p>{{ $Model_Data->ar_description }}</p>
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
    
                @if(Auth::user()->can('sub-services-edit') || Auth::user()->can('all'))
                    <div class="form-group row">
                        <div class="col-8 text-right">
                            <a href="{{ route('sub-services.edit', $Model_Data->id) }}" class='btn btn-primary'>
                                Edit
                            </a>
                            <a href="{{ route('sub-services.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="row form-group">
            <div class="col-sm-12">
                <div class="row">
                    <?php
                    if(isset($Model_Data->icon))
                    {
                    $image = $Model_Data->icon;
                    $image_path = 'svc/sub-services/';
                    if($image == 'sub_service.png')
                    {
                        $image_path = 'defaults/';
                    }
                    $image_path.= $image;
                    ?>
                    <div class="col-sm-12">
                        <img id="image" src="{{ uploads($image_path) }}" class="img-thumbnail img-responsive cust_img_cls" alt="Image" />
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>
