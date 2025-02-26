@include('svc.common.vendor_field')


<div class="form-group row" id="categories" <?php if(Auth::user()->vend_id==0){ ?>style="display: none;" <?php } ?>>
    <div class="col-sm-3">
        {!! Form::label('category', 'Category:') !!}
    </div>
    <div class="col-sm-9">
        <select class="form-control" id="cat_id" name="cat_id">
            <option value="-1">Select Categories</option>
            <?php
            if(Auth::user()->vend_id > 0)
            {
            foreach ($cat as $key=>$value){
            ?>
            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php
            }
            }
            ?>
        
        </select>
    </div>
</div>


<div class="form-group row" id="sub_categories" style="display: none;">
    <div class="col-sm-3">
        {!! Form::label('subcategory', 'Sub Category:') !!}
    </div>
    <div class="col-sm-9">
        <select class="form-control" id="sub_cat_id" name="sub_cat_id">
            <option value="">Select Sub Categories</option>
        
        </select>
    </div>
</div>


<div class="form-group row" id="services" style="display: none;">
    <div class="col-sm-3">
        {!! Form::label('services', 'Services:') !!}
    </div>
    <div class="col-sm-9">
        <select class="form-control" id="ser_id" name="ser_id">
            <option value="">Select Services</option>
        
        </select>
    </div>
</div>

<div class="form-group row" id="sub_services" style="display: none;">
    <div class="col-sm-3">
        {!! Form::label('subservices', 'Sub Services:') !!}
    </div>
    <div class="col-sm-9">
        <select class="form-control" id="sub_ser_id" name="sub_ser_id">
            <option value="">Select Sub Services</option>
        
        </select>
    </div>
</div>

<div class="form-group row">
    <div class="col-sm-3">
        {!! Form::label('price', 'Price:') !!}
    </div>
    <div class="col-sm-9">
        <input class="form-control" type="text" id="price" name="price" placeholder="Price" required/>
    </div>
</div>
