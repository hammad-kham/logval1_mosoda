
<div class="row form-group">
    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-4">
              {!! Form::label('title', 'Title [En]:') !!}
            </div>
            <div class="col-sm-8">
               <p>{{ $Model_Data->title }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
              {!! Form::label('description', 'Description [En]:') !!}
            </div>
            <div class="col-sm-8">
                 <p>{{ $Model_Data->description }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('created_at', 'Created At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->created_at }}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-4">
              {!! Form::label('title', 'Title [Ar]:') !!}
            </div>
            <div class="col-sm-8">
               <p>{{ $Model_Data->ar_title }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
              {!! Form::label('description', 'Description [Ar]:') !!}
            </div>
            <div class="col-sm-8">
                 <p>{{ $Model_Data->ar_description }}</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('updated_at', 'Updated At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->updated_at }}</p>
            </div>
        </div>
        @if(Auth::user()->can('categories-edit') || Auth::user()->can('all'))
            <div class="form-group row">
                <div class="col-8 text-right">
                    <a href="{{ route('categories.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        @endif
        
    </div>
    <div class="col-sm-4">
        <?php
        if(isset($Model_Data->icon))
        {
        $image = $Model_Data->icon;
        $image_path = 'svc/categories/';
        if($image == 'category.png')
        {
            $image_path = 'defaults/';
        }
        $image_path.= $image;
        ?>
        <div class="col-sm-12">
            <img id="image" src="{{ uploads($image_path) }}" class="img-thumbnail img-responsive cust_img_cls" alt="Image" />
        </div>
        <?php
        }
        ?>
    </div>
</div>