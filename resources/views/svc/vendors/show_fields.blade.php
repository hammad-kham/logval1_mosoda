<div class="row col-sm-12">
    <div class="row col-sm-8">
        <div class="row col-sm-6">
            <!-- Name Field -->
            <div class="form-group">
                {!! Form::label('name', 'Name [ En ]:') !!}
                <p>{{ $Model_Data->name }}</p>
            </div>
        </div>
        <div class="col-sm-6">
            <!-- Arabic Name Field -->
            <div class="form-group">
                {!! Form::label('arabic_name', 'Name [ Ar ]:') !!}
                <p>{{ $Model_Data->arabic_name }}</p>
            </div>
        </div>
        
        <div class="row col-sm-6">
            <!-- Name Field -->
            <div class="form-group">
                {!! Form::label('description', 'Description [ En ]:') !!}
                <p>{{ $Model_Data->description }}</p>
            </div>
        </div>
        <div class="col-sm-6">
            <!-- Arabic Name Field -->
            <div class="form-group">
                {!! Form::label('arabic_description', 'Description [ Ar ]:') !!}
                <p>{{ $Model_Data->arabic_description }}</p>
            </div>
        </div>
        
        <div class="row col-sm-6">
            <!-- Created At Field -->
            <div class="form-group">
                {!! Form::label('created_at', 'Created At:') !!}
                <p>{{ $Model_Data->created_at }}</p>
            </div>
        </div>
        <div class="col-sm-6">
            <!-- Updated At Field -->
            <div class="form-group">
                {!! Form::label('updated_at', 'Updated At:') !!}
                <p>{{ $Model_Data->updated_at }}</p>
            </div>
        </div>
    
    </div>
    
    
    <div class="row col-sm-4">
        <div class="form-group">
            <?php
            if(isset($Model_Data->image))
            {
            $image = $Model_Data->image;
            $image_path = 'svc/vendors/';
            if($image == 'vendor.png')
            {
                $image_path = 'defaults/';
            }
            $image_path.= $image;
            ?>
            <img id="profileImage" src="{{ uploads($image_path) }}" class="img-thumbnail img-responsive cust_img_cls" alt="Image" />
            <?php
            }
            ?>
        </div>
    </div>
</div>

