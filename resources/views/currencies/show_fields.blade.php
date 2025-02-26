
<div class="row form-group">
    <div class="col-sm-12">
        <div class="row">
            <div class="form-group col-sm-2">
                {!! Form::label('name', 'Name:') !!}
            </div>
            <div class="col-sm-10">
                {{ $Model_Data->name }}
            </div>
        </div>
    </div>
    
    <div class="col-sm-6">
        <div class="row">
            <div class="form-group col-sm-4">
                {!! Form::label('code', 'Code:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->code }}
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-sm-4">
                {!! Form::label('rate', 'Rate:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->rate }}
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-sm-4">
                {!! Form::label('created_at', 'Created At:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->created_at }}
            </div>
        </div>
    </div>
    
    <div class="col-sm-6">
        <div class="row">
            <div class="form-group col-sm-4">
                {!! Form::label('symbol', 'Symbol:') !!}
            </div>
            <div class="col-sm-8">
                {{ $Model_Data->symbol }}
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-sm-4">
                {!! Form::label('default', 'Default:') !!}
            </div>
            <div class="col-sm-8">
                <?php
                $is_default = $Model_Data->is_default;
                $is_active = $Model_Data->status;
                ?>
                @if($is_default == 1 && $is_active == 0)
                    
                    <a href="javascript:void(0)" class="btn btn-success btn-sm">
                        <span class="fa fa-power-off "> No</span>
                    </a>
                
                @elseif($is_default == 0 && $is_active == 0)
                    
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm">
                        <span class="fa fa-power-off "> No</span>
                    </a>
                
                @elseif($is_default == 0 && $is_active == 1)
                    
                    <a href="{{ route('currencies_default',$Model_Data->id)}}" class="btn btn-danger btn-sm" title="Make Currency Default">
                        <span class="fa fa-power-off"> Yes</span>
                    </a>
                
                @elseif($is_default == 1 && $is_active == 1)
                    
                    <a href="javascript:void(0)" class="btn btn-success btn-sm">
                        <span class="fa fa-power-off "> No</span>
                    </a>
                
                @endif
            
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