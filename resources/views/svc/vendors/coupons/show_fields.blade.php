<?php
//$action_name=Route::getCurrentRoute()->getAction();
//return $action_name;
$segment1 =  Request::segment(3);
?>

<div class="col-sm-12 row">
    <div class="col-sm-8">
        @if(Auth::user()->user_type=='admin' && isset($sellers_array[$Model_Data->seller_id]))
            <div class="row">
                <div class="col-md-4">
                    {!! Form::label('seller', 'Seller:') !!}
                </div>
                <div class="col-md-8">
                    <p>{{ $sellers_array[$Model_Data->seller_id] }}</p>
                </div>
            </div>
        @endif
    
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('coupon_code', 'Coupon Code:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $Model_Data->coupon_code !!} </p>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('title', 'Title [En]:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $Model_Data->title !!} </p>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('ar_title', 'Title [Ar]:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $Model_Data->ar_title !!} </p>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('description', 'Description [En]:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $Model_Data->description !!} </p>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('ar_description', 'Description [Ar]:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $Model_Data->ar_description !!} </p>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('min_order_value', 'Minimum Order Value:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $Model_Data->min_order_value !!} </p>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('max_discount_value', 'Maximum Discount Value:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! $Model_Data->max_discount_value !!} </p>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('start_time', 'Start Time:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! date("Y-m-d H:i:s",$Model_Data->start_time) !!} </p>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-4">
                {!! Form::label('end_time', 'End Time:') !!}
            </div>
            <div class="col-md-8">
                <p> {!! date("Y-m-d H:i:s",$Model_Data->end_time) !!} </p>
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
    
        @if(Auth::user()->can('seller-coupons-edit') || Auth::user()->can('all'))
            <div class="row">
                <div class="col-sm-12 text-right">
                    <a href="{{ url('service/coupon/edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('svc_coupons.index') }}" class="btn btn-outline-dark">Cancel</a>
                </div>
            </div>
        @endif

    </div>
    <div class="col-sm-4">
        <?php
        if(isset($Model_Data->image))
        {
        $image = $Model_Data->image;
        $image_path = 'svc/coupons/';
        if($image == 'coupon_image.png')
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
