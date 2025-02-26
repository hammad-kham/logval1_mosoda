<?php
$segment1 =  Request::segment(3);
?>

<?php
$show_2nd_col = 0;
$cols_span = 'col-sm-6';
if(isset($Model_Data->image))
{
    $cols_span = 'col-sm-4';
    $show_2nd_col = 1;
}
?>
<div class="row mt-2 mb-2 form-group">
    <div class="<?php echo $cols_span;?>">
        <div class="row">
            <div class="col-sm-12">
                <strong>Title [En]:</strong>
                <br />
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12">
                <strong>Description [Eng]:</strong>
                <br />
                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-12">
                <strong>Module:</strong>
                <br />
                {!! Form::select('module', array('0' => 'Services On Demand', '1' => 'Ecommerce', '2' => 'Classified Ads'), null, ['class' => 'form-control','id'=>'type'] ); !!}
            </div>
        </div>

        <div class="row mt-3">
            <div class="row col-sm-12">
                <div class="col-sm-4">
                    {!! Form::label('file_upload', 'Image:') !!}
                </div>
                <div class="col-sm-8">
                    {!! Form::file('image', null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>

    </div>

    <div class="<?php echo $cols_span;?>">
        <div class="row">
            <div class="col-sm-12">
                <strong>Title [Ar]:</strong>
                <br />
                {!! Form::text('ar_title', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12">
                <strong>Description [Ar]:</strong>
                <br />
                {!! Form::textarea('ar_description', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-12">
                <strong>Type:</strong>
                <br />
                {!! Form::select('type', array('0' => 'Get Started', '1' => 'Home'), null, ['class' => 'form-control','id'=>'type'] ); !!}
            </div>
        </div>

    </div>

    <?php
    if($show_2nd_col == 1)
    {
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
    }
    ?>

</div>

<?php
$show_2nd_col = 0;
$cols_span = 'col-sm-8';
?>
<div class="row mt-2 mb-2 form-group">

    <div class="<?php echo $cols_span;?>">

        <?php
        if(isset($Model_Data)){
        ?>
        <div class="row">
            <div class=" form-group col-12 text-right">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('app-slides.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>

        <?php
        }
        ?>

    </div>
</div>