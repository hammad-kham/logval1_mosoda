
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
        @if(isset($Model_Data->phone))
            <div class="row">
                <div class="col-sm-4">
                    {!! Form::label('phone', 'Phone:') !!}
                </div>
                <div class="col-sm-8">
                    <p>{{ $Model_Data->phone }}</p>
                </div>
            </div>
        @endif
        @if(isset($Model_Data->email))
            <div class="row">
                <div class="col-sm-4">
                    {!! Form::label('email', 'Email:') !!}
                </div>
                <div class="col-sm-8">
                    <p>{{ $Model_Data->email }}</p>
                </div>
            </div>
        @endif
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

        @if(Auth::user()->can('app-users-edit') || Auth::user()->can('all'))
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                    <a href="{{ route('app-users.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('app-users.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        @endif

    </div>
    <div class="col-sm-6">
        <?php

        if(isset($Model_Data->photo))
        {
        $image_path = 'app_users/';
        $image = $Model_Data->photo;
        if($image == 'app_user.png')
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