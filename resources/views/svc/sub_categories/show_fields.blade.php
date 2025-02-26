<div class="row form-group">
    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-4 form-group">
                {!! Form::label('cat_id', 'Category:') !!}
            </div>
            <div class="col-sm-8">
                {{ $categories_array[$Model_Data->cat_id] }}
            </div>
            <div class="col-sm-4 form-group">
                {!! Form::label('title', 'Title [En]:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->title }}
            </div>
            <div class="col-sm-4 form-group">
                {!! Form::label('description', 'Description [En]:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->description }}
            </div>
            <div class="col-sm-4 form-group">
                {!! Form::label('created_at', 'Created At:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->created_at }}
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-4 form-group">
                {!! Form::label('type', 'Type:') !!}
            </div>
            <div class="col-sm-8">
                <?php
                if($Model_Data->type == 0){
                    echo "Fixed Price";
                }
                elseif($Model_Data->type == 1){
                    echo "Get a Quote";
                }
                ?>
            </div>
            <div class="col-sm-4 form-group">
                {!! Form::label('title', 'Title [Ar]:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->ar_title }}
            </div>
            <div class="col-sm-4 form-group">
                {!! Form::label('description', 'Description [Ar]:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->ar_description }}
            </div>
            <div class="col-sm-4 form-group">
                {!! Form::label('updated_at', 'Updated At:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->updated_at }}
            </div>
        </div>
    
        @if(Auth::user()->can('sub-categories-edit') || Auth::user()->can('all'))
            <div class="form-group row">
                <div class="col-8 text-right">
                    <a href="{{ route('sub-categories.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('sub-categories.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        @endif
        
    </div>

    <div class="col-sm-4">
        <?php
        if(isset($Model_Data->icon))
        {
        $image = $Model_Data->icon;
        $image_path = 'svc/sub_categories/';
        if($image == 'sub_category.png')
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