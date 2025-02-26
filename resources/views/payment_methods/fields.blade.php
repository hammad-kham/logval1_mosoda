<?php
 $segment1 =  Request::segment(3);
?>

<?php
$show_2nd_col = 0;
$cols_span = 'col-sm-8';
if(isset($Model_Data->image))
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
                {!! Form::label('file_upload', 'Image:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::file('file_upload', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <?php
        if(isset($Model_Data)){
        ?>
        <div class="row mt-3">
            <div class=" form-group col-12 text-right">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('payment-methods.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>

        <?php
        }
        ?>

    </div>
	<?php
    if(isset($Model_Data->image))
    {
        $image = $Model_Data->image;
        $image_path = 'payment_methods/';
        if($image == 'method.png')
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
    ?>
</div>