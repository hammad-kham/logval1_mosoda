
<div class="row form-group">

    <div class="col-sm-4">
        <div>
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('name', 'Name :') !!}
                </div>
                <div class="col-sm-6">
                    <p>{{ $Model_Data->name }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('description', 'Description :') !!}
                </div>
                <div class="col-sm-6">
                    <p>{{ $Model_Data->description }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('category', 'Category :') !!}
                </div>
                <div class="col-sm-6">
                    <p>{{ $category_data->title }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('subcategory', 'Sub Category :') !!}
                </div>
                <div class="col-sm-6">
                    <p>{{ $sub_category_data->title }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('vendor', 'Vendor :') !!}
                </div>
                <div class="col-sm-6">
                    <p>{{ $vendor_data->name }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('price', 'Price :') !!}
                </div>
                <div class="col-sm-6">
                    <p>{{ $Model_Data->price }}</p>
                </div>
            </div>


        </div>
    </div>

    <div class="col-sm-4">
        <div>
            <div class="row">

            </div>

            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('status', 'Status') !!}
                </div>
                <div class="col-sm-6">
                    <p> <?php
                        if($Model_Data->status == 1)
                        {
                            echo 'Active';
                        }
                        else
                        {
                            echo 'InActive';
                        }
                        ?>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('occasion_type', 'Occasion Types :') !!}
                </div>
                <div class="col-sm-6">
                    <p>{{ $occasions }}</p>
                </div>
            </div>

            @if($Model_Data->created_by != null)
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('createdby', 'Created By :') !!}
                    </div>
                    <div class="col-sm-6">
                        <p>{{ $created_by->company_name }}</p>
                    </div>
                </div>
            @endif

            @if($Model_Data->updated_by != null)
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('updatedby', 'Updated By :') !!}
                    </div>
                    <div class="col-sm-6">
                        <p>{{ $updated_by->company_name }}</p>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('created_at', 'Created At :') !!}
                </div>
                <div class="col-sm-6">
                    <p>{{ $Model_Data->created_at }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('updated_at', 'Updated At :') !!}
                </div>
                <div class="col-sm-6">
                    <p>{{ $Model_Data->updated_at }}</p>
                </div>
            </div>

        </div>


    </div>

    <?php
    if(isset($Model_Data->image))
    {
    $image = $Model_Data->image;
    $image_path = 'svc/products/';
    if($image == 'product_image.png')
    {
        $image_path = 'defaults/';
    }
    $image_path.= $image;
    ?>
    <div class="col-sm-4 text-center">
        <img id="image" src="{{ uploads($image_path) }}" class="img-thumbnail img-responsive cust_img_cls" alt="Image" />
    </div>
    <?php
    }
    ?>
    
    @if(Auth::user()->can('vendor-products-edit') || Auth::user()->can('all'))
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-7">
                </div>
                <div class="col-sm-5">
                    <a href="{{ route('products.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        Back
                    </a>
                </div>
            </div>
        </div>
    @endif

</div>