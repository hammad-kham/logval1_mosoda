
<?php
$segment1 =  Request::segment(3);

$col_lg = "col-lg-12 col-md-12 col-sm-12";
$hide = "display:none;";
if(isset($Model_Data))
{
    $col_lg = "col-lg-8 col-md-8 col-sm-12";
    $hide = "";
}
?>
<div class="col-sm-12 row">
    <div class="<?php echo $col_lg; ?>">
        
        <?php
        if(isset($Model_Data->vendor_id))
        {
		?>
            <div class="form-group row">
                <div class="col-sm-3">
                    {!! Form::label('vendor_id', 'Vendor:') !!}
                </div>
                <div class="col-sm-9">
                    {!! Form::select('vendor_id', $vendors_array, $Model_Data->vendor_id, ['placeholder' => 'select', 'class' => 'form-control']) !!}
                </div>
            </div>
        <?php }  else { ?>

            <div class="form-group row">
                <div class="col-sm-3">
                    {!! Form::label('vendor_id', 'Vendor:') !!}
                </div>
                <div class="col-sm-9">
                    {!! Form::select('vendor_id', $vendors_array, null, ['placeholder' => 'select', 'class' => 'form-control']) !!}
                </div>
            </div>

        <?php } ?>
        
        <div class="mt-4 row">
            <div class="col-md-3">
                {!! Form::label('coupon_code', 'Coupon Code:') !!}
            </div>
            <div class="col-md-9">
                {!! Form::text('coupon_code', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        
        <div class="mt-4 row">
            <div class="col-md-3">
                {!! Form::label('title', 'Title [En]:') !!}
            </div>
            <div class="col-md-9">
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        
        <div class="mt-4 row">
            <div class="col-md-3">
                {!! Form::label('ar_title', 'Title [Ar]:') !!}
            </div>
            <div class="col-md-9">
                {!! Form::text('ar_title', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        
        <div class="mt-4 row">
            <div class="col-md-3">
                {!! Form::label('description', 'Description [En]:') !!}
            </div>
            <div class="col-md-9">
                {!! Form::text('description', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        
        <div class="mt-4 row">
            <div class="col-md-3">
                {!! Form::label('ar_description', 'Description [Ar]:') !!}
            </div>
            <div class="col-md-9">
                {!! Form::text('ar_description', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        
        <div class="mt-4 row">
            <div class="col-md-3">
                {!! Form::label('min_order_value', 'Min Order Value:') !!}
            </div>
            <div class="col-md-9">
                {!! Form::number('min_order_value', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        
        <div class="mt-4 row">
            <div class="col-md-3">
                {!! Form::label('max_discount_value', 'Max Discount Value:') !!}
            </div>
            <div class="col-md-9">
                {!! Form::number('max_discount_value', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        
        <div class="mt-4 row">
            <div class="col-md-3">
                {!! Form::label('start_time', 'Start Time:') !!}
            </div>
            <div class="col-md-9">
                <?php
                if(isset($Model_Data)){
                ?>
                {!! Form::datetimeLocal('start_time', date('Y-m-d\TH:i',$Model_Data->start_time), ['class' => 'form-control datetimepicker']) !!}
                <?php
                }
                else{
                ?>
                {!! Form::datetimeLocal('start_time', null, ['class' => 'form-control datetimepicker']) !!}
                <?php
                }
                ?>
            </div>
        </div>
        
        <div class="mt-4 row">
            <div class="col-md-3">
                {!! Form::label('end_time', 'End Time:') !!}
            </div>
            <div class="col-md-9">
                <?php
                if(isset($Model_Data)){
                ?>
                {!! Form::datetimeLocal('end_time', date('Y-m-d\TH:i',$Model_Data->end_time), ['class' => 'form-control datetimepicker']) !!}
                <?php
                }
                else{
                ?>
                {!! Form::datetimeLocal('end_time', null, ['class' => 'form-control datetimepicker']) !!}
                <?php
                }
                ?>
            </div>
        </div>
        
        <div class="mt-4 row">
            <div class="col-md-3">
                {!! Form::label('image', 'Image:') !!}
            </div>
            <div class="col-md-9">
                <input type="file" name="image" accept="image/*" />
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-4 col-sm-12" style="<?php echo $hide; ?>">
        <?php
        if(isset($Model_Data->image))
        {
        $image = $Model_Data->image;
        $image_path = 'svc/coupons/';
        if($image == 'coupon_image.png')
        {
            $image_path = 'defaults/';
        }
        $image_path.= $image;
        ?>
        <img id="image" src="{{ uploads($image_path) }}" class="img-thumbnail img-responsive cust_img_cls" alt="Image" />
        <?php
        }
        ?>
    </div>
    
</div>


