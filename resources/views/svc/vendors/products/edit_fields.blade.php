
@if(Auth::user()->vend_id==0)
<!-- Restaurant Field -->

    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('vend_id', 'Vender:') !!} 
        </div>
        <div class="col-sm-9"> 
            <select class="form-control" id="vend_id" name="vend_id" disabled>
                <option value="{{$vendor_data->id}}">{{$vendor_data->name}}</option>
                
            </select> 
        </div>  
    </div>
@else
    <input type="hidden" id="vend_id" name="vend_id" value="<?php echo Auth::user()->vend_id;?>" />
@endif

<div class="form-group row">
    <div class="col-sm-3">
    	{!! Form::label('cat_id', 'Cat:') !!} 
    </div>
    <div class="col-sm-9"> 
        <select class="form-control" id="cat_id" name="cat_id" disabled>
            <option value="{{$category_data->id}}">{{$category_data->title}}</option>
            
        </select> 
    </div>  
</div>


<div class="form-group row">
    <div class="col-sm-3">
    	{!! Form::label('sub_cat_id', 'Sub Cat:') !!} 
    </div>
    <div class="col-sm-9"> 
        <select class="form-control" id="sub_cat_id" name="sub_cat_id" disabled>
            <option value="{{$sub_category_data->id}}">{{$sub_category_data->title}}</option>
            
        </select> 
    </div>  
</div>


<div class="form-group row">
    <div class="col-sm-3">
    	{!! Form::label('ser_id', 'Services:') !!} 
    </div>
    <div class="col-sm-9"> 
        <select class="form-control" id="ser_id" name="ser_id" disabled>
            <option value="{{$service_data->id}}">{{$service_data->title}}</option>
            
        </select> 
    </div>  
</div>

<div class="form-group row">
    <div class="col-sm-3">
    	{!! Form::label('sub_ser_id', 'Sub Services:') !!} 
    </div>
    <div class="col-sm-9"> 
        <select class="form-control" id="sub_ser_id" name="sub_ser_id" disabled>
            <option value="{{$sub_service_data->id}}">{{$sub_service_data->title}}</option>
            
        </select> 
    </div>  
</div>


<div class="form-group row">
    <div class="col-sm-3">
    	{!! Form::label('price', 'Starting Price:') !!} 
    </div>
    <div class="col-sm-9"> 
        <input class="form-control" type="text" id="price" name="price" placeholder="Price" value="{{$Model_Data->price}}" required/> 
    </div>  
</div>

<div class="mt-4 mb-3 row">
    <div class="col-sm-12 text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{route('vendor-services.index')}}" class='btn btn-outline-dark' >
            Cancel
        </a>                        
    </div>
</div>