
<div class="form-group">

    @if($Vendor->name != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('name', 'Name [ En ]:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Vendor->name }}</p>
            </div>
        </div>
    @endif
    
    @if($Vendor->arabic_name != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('arabic_name', 'Name [ Ar ]:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Vendor->arabic_name }}</p>
            </div>
        </div>
    @endif
    
    @if($Vendor->email != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('email', 'Email:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Vendor->email }}</p>
            </div>
        </div>
    @endif
    
    @if($Vendor->phone != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('phoneNo', 'Phone No.:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Vendor->phone }}</p>
            </div>
        </div>
    @endif
    
    @if($Vendor->location != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('location', 'Location:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Vendor->location }}</p>
            </div>
        </div>
    @endif
    
    @if($Vendor->website != "")
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('website', 'Website') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Vendor->website }}</p>
            </div>
        </div>
    @endif

</div>