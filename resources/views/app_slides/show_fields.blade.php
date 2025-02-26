
<div class="row form-group">
    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-12">
                <strong>Title [ English ]:</strong>
                <br />
                <p>{{ $Model_Data->title }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <strong>Description [ English ]:</strong>
                <br />
                <p>{{ $Model_Data->description }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('module', 'Module') !!}
            </div>
            <div class="col-sm-8">
                <?php
                if($Model_Data->module == 0)
                {
                    echo 'Services On Demand';
                }
                elseif($Model_Data->module == 1)
                {
                    echo 'Ecommerce';
                }
                elseif($Model_Data->module == 2)
                {
                    echo 'Classified Ads';
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('status', 'Status') !!}
            </div>
            <div class="col-sm-8">
                <?php
                if($Model_Data->status == 1)
                {
                    echo 'Active';
                }
                else
                {
                    echo 'Inactive';
                }
                ?>
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

    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-12">
                <strong>Title [ Arabic ]:</strong>
                <br />
                <p>{{ $Model_Data->ar_title }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <strong>Description [ Arabic ]:</strong>
                <br />
                <p>{{ $Model_Data->ar_description }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('type', 'Type:') !!}
            </div>
            <div class="col-sm-8">
                <p>
                    <?php
                    if($Model_Data->type == 0){
                        echo "Get Started";
                    }
                    elseif($Model_Data->type == 1){
                        echo "Home";
                    }
                    ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">

            </div>
            <div class="col-sm-8">
                <p>

                </p>
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
    </div>

    <?php
    if(isset($Model_Data->image))
    {
    $image = $Model_Data->image;
    $image_path = 'app_slides/';
    if($image == 'slide.png')
    {
        $image_path = 'defaults/';
    }
    $image_path.= $image;
    ?>
    <div class="col-sm-4">
        <img id="image" src="{{ uploads($image_path) }}" class="img-thumbnail img-responsive cust_img_cls" alt="Image" />
    </div>
    <?php
    }
    ?>


</div>

@if(Auth::user()->can('app-slides-edit') || Auth::user()->can('all'))
    <div class="row form-group">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                    <a href="{{ route('app-slides.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('app-slides.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
@endif

