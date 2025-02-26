
<div class="row form-group">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('name', 'Name:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->title }}</p>
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
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('type', 'Type:') !!}
            </div>
            <div class="col-sm-8">
                <p>
                    <?php
                    if($Model_Data->type == 1){
                        echo "Service On Demand";
                    }
                    elseif($Model_Data->type == 2){
                        echo "Ecommerce";
                    }
                    elseif($Model_Data->type == 3){
                        echo "Classified Ads";
                    }
                    ?>
                </p>
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
        
        
        @if(Auth::user()->can('faq-topics-edit') || Auth::user()->can('all'))
            <div class="form-group row">
                <div class="col-8 text-right">
                    <a href="{{ route('faq-topics.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('faq-topics.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        @endif
    
    </div>
</div>