


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
{{--    $image_path = 'svc/sub-services/';--}}
{{--    if($image == 'sub_service.png')--}}
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
        <a href="{{ route('sub-services.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>