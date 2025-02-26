
<div class="form-group row">
    <div class="col-sm-6">
        <?php
        $disabled = "";
        if(isset($Model_Data->id) && $Model_Data->id != ""){
            $disabled = "readonly";
        }
        ?>
        {!! Form::label('cat_id', 'Category:') !!}
        {!! Form::select('cat_id', $categories_array, null, ['placeholder' => 'select','class' => 'form-control',$disabled]) !!}
    </div>
    <div class="col-sm-6">
        {!! Form::label('type', 'Type:') !!}
        {!! Form::select('type', $types_array, null, ['placeholder' => 'select','class' => 'form-control']) !!}
    </div>
</div>
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
{{--    if(isset($Model_Data->icon))--}}
{{--    {--}}
{{--    $image = $Model_Data->icon;--}}
{{--    $image_path = 'svc/sub_categories/';--}}
{{--    if($image == 'sub_category.png')--}}
{{--    {--}}
{{--        $image_path = 'defaults/';--}}
{{--    }--}}
{{--    $image_path.= $image;--}}
{{--    ?>--}}
{{--    <div class="col-sm-6">--}}
{{--        <img id="image" src="{{ uploads($image_path) }}" class="img-thumbnail img-responsive cust_img_cls" alt="Image" />--}}
{{--    </div>--}}
{{--    <?php--}}
{{--    }--}}
{{--    ?>--}}
    <div class=" form-group col-6">
        {!! Form::label('icon', 'Icon:') !!}
        <input type="file" name="icon" accept="image/*" />
    </div>
</div>

<div class="row">
    <div class=" form-group col-12 text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('sub-categories.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>