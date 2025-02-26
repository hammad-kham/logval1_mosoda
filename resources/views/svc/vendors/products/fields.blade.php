@if(isset($Model_Data))
    
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('name', 'Name:') !!}
        </div>
        <div class="col-sm-9">
            <input class="form-control" type="text" id="name" name="name" placeholder="Name" value="{{$Model_Data->name}}" required/>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('description', 'Description:') !!}
        </div>
        <div class="col-sm-9">
            <textarea name="description" id="description" cols="30" rows="15" class="form-control" required>{{$Model_Data->description}}</textarea>
        </div>
    </div>
    
    <?php
    if(Auth::user()->vend_id == 0)
    {
    ?>
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('vendor', 'Vendor:') !!}
        </div>
        <div class="col-sm-9">
            <select class="form-control" id="vendor_id" name="vend_id" disabled>
                <option value="{{$vendor_data->id}}">{{$vendor_data->name}}</option>
            </select>
        </div>
    </div>
    <?php
    }
    else
    {
    ?>
    <input type="hidden" id="vendor_id" name="vend_id" value="<?php echo Auth::user()->vend_id;?>"/>
    <?php
    }
    ?>
    
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('Category', 'Category:') !!}
        </div>
        <div class="col-sm-9">
            <select class="form-control" id="category_id" name="cat_id" readonly>
                <option value="{{$category_data->id}}">{{$category_data->title}}</option>
            </select>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('subcategory', 'Sub Category:') !!}
        </div>
        <div class="col-sm-9">
            <select class="form-control" id="sub_category_id" name="sub_cat_id" readonly>
                <option value="{{$sub_category_data->id}}">{{$sub_category_data->title}}</option>
            </select>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('occasion_types', 'Occasion Types:') !!}
        </div>
        <div class="col-sm-9">
            {!! Form::select('occasion_types[]', $occasion_types, $occassions, ['id' => 'myselect','multiple' => 'multiple','class' => 'form-control js-select2', 'required' => '']) !!}
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('price', 'Price:') !!}
        </div>
        <div class="col-sm-9">
            <input type="number" name="price" id="price" class="form-control" placeholder="Price" value="{{$Model_Data->price}}">
        </div>
    </div>

@else
    
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('name', 'Name:') !!}
        </div>
        <div class="col-sm-9">
            <input class="form-control" type="text" id="name" name="name" placeholder="Name" value="{{ old('name') }}" required/>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('description', 'Description:') !!}
        </div>
        <div class="col-sm-9">
            <textarea name="description" id="description" cols="30" rows="15" class="form-control" placeholder="Description" required>{{ old('description') }}</textarea>
        </div>
    </div>
    
    <?php
    if(Auth::user()->vend_id == 0)
    {
    ?>
    
    <div class="form-group row" id="vendor">
        <div class="col-sm-3">
            {!! Form::label('vendor', 'Vendor:') !!}
        </div>
        <div class="col-sm-9">
            
            <select class="form-control" id="vendor_id" name="vend_id">
                <option value="">Select Vendor</option>
                @foreach($vendor as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        
        </div>
    </div>
    
    <?php
    }
    else
    {
    ?>
    
    <input type="hidden" id="vendor_id" name="vend_id" value="<?php echo Auth::user()->vend_id;?>"/>
    
    <?php
    }
    ?>
    
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('Category', 'Category:') !!}
        </div>
        <div class="col-sm-9">
            {!! Form::select('cat_id', $categories, null, ['id' => 'cat_id','class' => 'form-control']) !!}
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('subcategory', 'Sub Category:') !!}
        </div>
        <div class="col-sm-9">
            {!! Form::select('sub_cat_id', $sub_categories, null, ['id' => 'sub_cat_id','placeholder' => 'Select','class' => 'form-control']) !!}
        </div>
    </div>
    
    
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('occasion_types', 'Occasion Types:') !!}
        </div>
        <div class="col-sm-9">
            {!! Form::select('occasion_types[]', $occasion_types, null, ['id' => 'myselect','multiple' => 'multiple','class' => 'form-control js-select2', 'required' => '']) !!}
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-3">
            {!! Form::label('price', 'Price:') !!}
        </div>
        <div class="col-sm-9">
            <input type="number" name="price" id="price" class="form-control" placeholder="Price">
        </div>
    </div>

@endif


<div class="row">
    <div class="form-group col-sm-10 ">
        {!! Form::label('image', 'Product Image:') !!}
        {!! Form::file('image', null, ['placeholder' => '', 'class' => 'form-control' , 'required' => '']) !!}
    </div>
</div>

<div class="mt-4 mb-3 row">
    <div class="col-sm-12 text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{route('products.index')}}" class='btn btn-outline-dark' >
            Cancel
        </a>
    </div>
</div>