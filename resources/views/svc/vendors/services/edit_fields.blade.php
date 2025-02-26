@if(Auth::user()->vend_id==0)
<!-- Vendor Field -->
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('vendor', 'Vendor:') !!} 
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

@if(isset($category_data))
<div class="form-group row">
    <div class="col-sm-3">
    	{!! Form::label('Category', 'Category:') !!} 
    </div>
    <div class="col-sm-9"> 
        <select class="form-control" id="cat_id" name="cat_id" disabled>
            <option value="{{$category_data->id}}">{{$category_data->title}}</option>
            
        </select> 
    </div>  
</div>
@endif

@if(isset($sub_category_data))
<div class="form-group row">
    <div class="col-sm-3">
    	{!! Form::label('subcategory', 'Sub Category:') !!} 
    </div>
    <div class="col-sm-9"> 
        <select class="form-control" id="sub_cat_id" name="sub_cat_id" disabled>
            <option value="{{$sub_category_data->id}}">{{$sub_category_data->title}}</option>
            
        </select> 
    </div>  
</div>
@endif


@if(isset($service_data))
<div class="form-group row">
    <div class="col-sm-3">
    	{!! Form::label('services', 'Services:') !!} 
    </div>
    <div class="col-sm-9"> 
        <select class="form-control" id="ser_id" name="ser_id" disabled>
            <option value="{{$service_data->id}}">{{$service_data->title}}</option>
            
        </select> 
    </div>  
</div>
@endif

@if(isset($sub_service_data))
<div class="form-group row">
    <div class="col-sm-3">
    	{!! Form::label('subservices', 'Sub Services:') !!} 
    </div>
    <div class="col-sm-9"> 
        <select class="form-control" id="sub_ser_id" name="sub_ser_id" disabled>
            <option value="{{$sub_service_data->id}}">{{$sub_service_data->title}}</option>
            
        </select> 
    </div>  
</div>
@endif

<div class="form-group row">
    <div class="col-sm-3">
    	{!! Form::label('startingprice', 'Starting Price:') !!} 
    </div>
    <div class="col-sm-9"> 
        <input class="form-control" type="text" id="price" name="price" placeholder="Price" value="{{$Model_Data->price}}" required/> 
    </div>  
</div>

