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
                {!! Form::label('status', 'Status') !!}

                <p> <?php
                    if($Model_Data->status == 1)
                    {
                        echo "Active";
                    }
                    else
                    {
                        echo "InActive";
                    }
                    ?></p>
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
                {!! Form::label('topic', 'Topic:') !!}
                <br/>
                <p>{{ $app_page_array[$Model_Data->topic_app_page_id] }}</p>
            </div>
        </div>

    </div>
    <?php
    if(isset($Model_Data->image))
    {
    $image = $Model_Data->image;
    $image_path = 'banners/';
    if($image == 'banner.png')
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

<?php
/*
?>
<div class="row">
    <div class="col-sm-12">
        {!! Form::label('created_at', 'Created At:') !!}
        <br/>
        <p>{{ $Model_Data->created_at }}</p>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        {!! Form::label('updated_at', 'Updated At:') !!}
        <br>
        <p>{{ $Model_Data->updated_at }}</p>
    </div>
</div>
<?php
*/
?>


<div class="row form-group">

    <div class="col-sm-4">

    </div>
    <div class="col-sm-4">

    </div>
</div>

@if(Auth::user()->can('banners-edit') || Auth::user()->can('all'))
    <div class="row form-group">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                    <a href="{{ route('banners.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('banners.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
@endif
