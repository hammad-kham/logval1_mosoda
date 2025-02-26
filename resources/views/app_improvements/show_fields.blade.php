
<div class="row form-group">
    <div class="col-sm-6">
        <div class="row">
            <div class="form-group col-sm-4">
              {!! Form::label('user', 'User:') !!}
            </div>
            <div class="col-sm-8">
               {{ $User_Data->name }}
            </div>
        </div> 
        <div class="row">
            <div class="form-group col-sm-4">
              {!! Form::label('content', 'Content:') !!}
            </div>
            <div class="col-sm-8">
               {{ $Model_Data->content_text }}
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="row">
            <div class="form-group col-sm-4">
                {!! Form::label('created_at', 'Created At:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->created_at }}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4">
                {!! Form::label('updated_at', 'Updated At:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->updated_at }}
            </div>
        </div>
    </div>
</div>