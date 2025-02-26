
<!-- SvcCategory Field -->
<div class="form-group col-sm-4">
    {!! Form::label('cat_title', 'SvcCategory') !!}
    {!! Form::select('cat_title', $AllCategories->pluck('title','id'), -1, ['placeholder' => 'select','class' => 'form-control cat_title ']) !!}  
</div>

<div class="form-group row">
    <div class="col-sm-6">
        {!! Form::label('slected_catgories', 'Selected Categories') !!}
        {!! Form::textarea('slected_catgories', null, ['class' => 'form-control slected_catgories'  ,'cols' => 10, 'rows' =>5, 'required' => '', 'maxlength' => "200"]) !!}
    </div>

    <div class="col-sm-6 variation_div">
        {!! Form::hidden('rest_id', $Model_Data->id, ['class' => 'form-control rest_id' ]) !!}
        {!! Form::hidden('cat_id[]', null, ['class' => 'form-control cat_id' ]) !!}
    </div>    
</div>

<div class="mt-4 mb-3 row">
    <div class="col-sm-12 text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="#" class='btn btn-outline-dark' id="btnclose" data-dismiss="modal">
            Cancel
        </a>                        
    </div>
</div>