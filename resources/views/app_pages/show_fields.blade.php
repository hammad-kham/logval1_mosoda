
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
    </div>
    
    <?php
    if(isset($Model_Data->image) && ($Model_Data->image != "" || $Model_Data->image != null))
    {
    $image = $Model_Data->image;
    $image_path = 'app_pages/';
    if($image == 'page.png')
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


<div class="row form-group">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('status', 'Status:') !!}
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
    </div>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('created_at', 'Created At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->created_at }}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('updated_at', 'Updated At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->updated_at }}</p>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->can('app-pages-edit') || Auth::user()->can('all'))
    <div class="row form-group">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                    <a href="{{ route('app-pages.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('app-pages.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
@endif

