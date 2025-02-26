@include('svc.common.vendor_field')

<div class="form-group row">
    <div class="col-sm-3">
        {!! Form::label('cat_id', 'Category') !!}
    </div>
    <div class="col-sm-9">

        {!! Form::select('cat_id', $AllCategories, null, ['id' => 'cat_id','class' => 'form-control cat_title js-select2', 'required' => '']) !!}
    </div>
</div>
