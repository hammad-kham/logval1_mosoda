
<div class="row form-group">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('name', 'Name:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->name }}</p>
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
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('updated_at', 'Updated At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->updated_at }}</p>
            </div>
        </div>
    
        @if(Auth::user()->can('payment-methods-edit') || Auth::user()->can('all'))
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                    <a href="{{ route('payment-methods.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('payment-methods.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        @endif
        
    </div>
	<?php
    if(isset($Model_Data->image))
    {
        $image = $Model_Data->image;
        $image_path = 'payment_methods/';
        if($image == 'method.png')
        {
            $image_path = 'defaults/';
        }
        $image_path.= $image;
        ?>
        <div class="col-sm-6">
            <img id="image" src="{{ uploads($image_path) }}" class="img-thumbnail img-responsive cust_img_cls" alt="Image" />
        </div>
        <?php
    }
    ?>
</div>