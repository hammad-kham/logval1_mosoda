
<div class="form-group row">
	<div class="col-sm-6">
        {!! Form::label('title', 'Title [En]:') !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-sm-6">
        {!! Form::label('ar_title', 'Title [Ar]:') !!}
        {!! Form::text('ar_title', null, ['class' => 'form-control']) !!}
	</div>
</div>

<div class="form-group row">
    <div class="col-sm-6">
        {!! Form::label('description', 'Description [En]:') !!}
        {!! Form::textarea('description', null, ['class' => 'form-control'  ,'cols' => 10, 'rows' =>5, 'required' => '', 'maxlength' => "200"]) !!}
    </div>
    <div class="form-group col-sm-6">
        {!! Form::label('ar_description', 'Description [Ar]:') !!}
        {!! Form::textarea('ar_description', null, ['class' => 'form-control'  ,'cols' => 10, 'rows' =>5, 'required' => '', 'maxlength' => "200"]) !!}
    </div>
</div>

<div class="row">
{{--    <?php--}}
{{--	if(isset($Model_Data->icon))--}}
{{--	{--}}
{{--		$image = $Model_Data->icon;--}}
{{--		$image_path = 'svc/categories/';--}}
{{--		if($image == 'category.png')--}}
{{--		{--}}
{{--			$image_path = 'defaults/';--}}
{{--		}--}}
{{--		$image_path.= $image;--}}
{{--		?>--}}
{{--        <div class="col-sm-6">--}}
{{--            <img id="image" src="{{ uploads($image_path) }}" class="img-thumbnail img-responsive cust_img_cls" alt="Image" />--}}
{{--        </div>--}}
{{--        <?php--}}
{{--	}--}}
{{--	?>   --}}

    <div class="row form-group col-12">
        <div class="col-1">
            {!! Form::label('icon', 'Icon:') !!}
        </div>
        <div class="col-11">
            <input type="file" name="icon" accept="image/*" />
        </div>
    </div>
    <div class="row form-group col-12">
        <div class="col-1">
            {!! Form::label('ban_image', 'Banner Image:') !!}
        </div>
        <div class="col-11">
            <input type="file" name="ban_image" accept="image/*" />
        </div>
    </div>
    <div class="row form-group col-12">
        <div class="col-1">
            {!! Form::label('thumb_image', 'Thumbnail:') !!}
        </div>
        <div class="col-11">
            <input type="file" name="thumb_image" accept="image/*" />
        </div>
    </div>
</div>




{{--<?php--}}
{{--if(isset($Model_Data))--}}
{{--{--}}
{{--$style = '';--}}
{{--if(isset($Model_Data->has_options) && $Model_Data->has_options==1)--}}
{{--{--}}
{{--    $style = ' style="display:none;"';--}}
{{--}--}}
{{--//if(!isset($Model_Data->has_options) || $Model_Data->has_options==0)--}}
{{--{--}}
{{--?>--}}
{{--<div class="row" <?php echo $style;?>>--}}
{{--    <div class="form-group col-sm-6">--}}
{{--        <input id="chk_variations" name="variations" type="checkbox"  <?php if(isset($Model_Data->has_options) && $Model_Data->has_options==1){echo 'checked="checked"';}?>>--}}
{{--        {!! Form::label('chk_variations', 'has Attributes') !!}--}}
{{--    </div>--}}
{{--</div>--}}
{{--<?php--}}
{{--}--}}
{{--?>--}}


{{--<div id="variation_div">--}}
{{--    <?php--}}
{{--/*    if(isset($Model_Data->has_options) && $Model_Data->has_options==1)--}}
{{--    {--}}
{{--    $count = 0;--}}
{{--    foreach($variants as $variant)--}}
{{--    {--}}
{{--    $count++;--}}
{{--    if($count == 1)--}}
{{--    {--}}
{{--    */?><!----}}
{{--    <div class="variations"  style="padding: 10px;">--}}

{{--        <div class="row">--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                <strong>Addon <?php /*echo $count;*/?></strong>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row">--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                {!! Form::select('type_id[]', $addon_types, $variant->type_id, ['placeholder' => 'Select Addon type','class' => 'form-control']) !!}--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                {!! Form::text('var_name[]', $variant->name, [ 'placeholder' => 'Name [ English ]' ,'class' => 'form-control']) !!}--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                {!! Form::text('var_ar_name[]', $variant->ar_name, ['placeholder' => 'Name [ Arabic ]' ,'class' => 'form-control']) !!}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row">--}}
{{--            <div class="form-group col-sm-6 col-lg-6">--}}
{{--                {!! Form::textarea('var_description[]', $variant->description, ['placeholder' => 'Description [ English ]' , 'class' => 'form-control' , 'cols' => 10, 'rows' =>1,  'maxlength' => "200"]) !!}--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-6 col-lg-6">--}}
{{--                {!! Form::textarea('var_ar_description[]', $variant->ar_description, ['placeholder' => 'Description [ Arabic ]', 'class' => 'form-control' , 'cols' => 10, 'rows' =>1,  'maxlength' => "200"]) !!}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row">--}}
{{--            <div class="form-group col-sm-6">--}}
{{--                {!! Form::text('var_price[]', get_decimal($variant->price), ['placeholder' => 'Price','class' => 'form-control price_addon']) !!}--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                {!! Form::file('var_image[]', null, ['class' => 'form-control']) !!}--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-2">--}}
{{--                {!! Form::button('+', ['class' => 'btn btn-primary add_variations','id' => 'add_variations']) !!}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--    <?php--}}
{{--/*    }--}}
{{--    else--}}
{{--    {--}}
{{--    */?>--}}
{{--    <div class="variations variationrow"  style=" margin-top: 10px; padding: 10px;">--}}

{{--        <div class="row">--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                <strong>Addon</strong>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row">--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                {!! Form::select('type_id[]', $addon_types, $variant->type_id, ['placeholder' => 'Select Addon type','class' => 'form-control']) !!}--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                {!! Form::text('var_name[]', $variant->name, [ 'placeholder' => 'Name [ English ]' ,'class' => 'form-control']) !!}--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                {!! Form::text('var_ar_name[]', $variant->ar_name, ['placeholder' => 'Name [ Arabic ]' ,'class' => 'form-control']) !!}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row">--}}
{{--            <div class="form-group col-sm-6 col-lg-6">--}}
{{--                {!! Form::textarea('var_description[]', $variant->description, ['placeholder' => 'Description [ English ]' , 'class' => 'form-control' , 'cols' => 10, 'rows' =>1,  'maxlength' => "200"]) !!}--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-6 col-lg-6">--}}
{{--                {!! Form::textarea('var_ar_description[]', $variant->ar_description, ['placeholder' => 'Description [ Arabic ]', 'class' => 'form-control' , 'cols' => 10, 'rows' =>1,  'maxlength' => "200"]) !!}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row">--}}
{{--            <div class="form-group col-sm-6">--}}
{{--                {!! Form::text('var_price[]', get_decimal($variant->price), ['placeholder' => 'Price','class' => 'form-control price_addon']) !!}--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-4">--}}
{{--                {!! Form::file('var_image[]', null, ['class' => 'form-control']) !!}--}}
{{--            </div>--}}
{{--            <div class="form-group col-sm-2">--}}
{{--                {!! Form::button('X', ['class' => 'btn btn-secondary btn-rem-var']) !!}--}}
{{--                {!! Form::button('+', ['class' => 'btn btn-primary add_variations','id' => 'add_variations']) !!}--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--    --><?php--}}
{{--/*    }--}}
{{--    }--}}
{{--    }--}}
{{--    */?>--}}
{{--</div>--}}
<?php
//}
//?>



<div class="row">
    <div class=" form-group col-12 text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>
