<?php
$segment1 =  Request::segment(3);
?>

<?php
$show_2nd_col = 0;
$cols_span = 'col-sm-8';
if(isset($Model_Data->photo))
{
    $cols_span = 'col-sm-6';
    $show_2nd_col = 1;
}
?>
<div class="row justify-content-center text-center mt-2 mb-2 form-group">
    <div class="<?php echo $cols_span;?>">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('name', 'Name:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('phone', 'Phone:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::text('phone', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('email', 'Email:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('file_upload', 'Image:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::file('image', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <?php
        if(isset($Model_Data)){
        ?>
        <div class="row">
            <div class=" form-group col-12 text-right">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('app-users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>

        <?php
        }
        ?>

    </div>
    <?php
    if($show_2nd_col == 1)
    {
    if(isset($Model_Data->photo))
    {
    $image_path = 'app_users/';
    $image = $Model_Data->photo;
    if($image == 'app_user.png')
    {
        $image_path = 'defaults/';
    }
    $image_path.= $image;

    ?>

    <div class="col-sm-6">
        <img id="image" src="{{ uploads($image_path) }}" class="img-thumbnail img-responsive cust_img_cls" alt="Image" />
    </div>

    <?php
    }
    }
    ?>
</div>
