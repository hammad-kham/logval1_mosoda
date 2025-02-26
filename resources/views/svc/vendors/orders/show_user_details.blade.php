
<div class="form-group">

    @if($App_User->name != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('name', 'Name') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $App_User->name }}</p>
            </div>
        </div>
    @endif
    
    @if($App_User->phone != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('phone', 'Phone') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $App_User->phone }}</p>
            </div>
        </div>
    @endif
    
    @if($App_User->email != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('email', 'Email') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $App_User->email }}</p>
            </div>
        </div>
    @endif
    
    @if($App_User_Location->address != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('address', 'Address:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $App_User_Location->address }}</p>
            </div>
        </div>
    @endif
    
    @if($App_User_Location->building != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('buildingname', 'Building Name:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $App_User_Location->building }}</p>
            </div>
        </div>
    @endif
    
    @if($App_User_Location->flat != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('flatno', 'Flat No:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $App_User_Location->flat }}</p>
            </div>
        </div>
    @endif
    
    {{--@if($App_User_Location->nick_name != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('nickname', 'Location Nick Name:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $App_User_Location->nick_name }}</p>
            </div>
        </div>
    @endif--}}
    
    @if($user_order_count != 0)
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('totalorder', 'Total Orders Placed') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $user_order_count }}</p>
            </div>
        </div>
    @endif
    
</div>