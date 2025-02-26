


<div class="row justify-content-center mt-2 mb-2 form-group">
    <div class="col-sm-8">
      
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('min_order_value', 'Min Punch Value:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{$Model_Data->min_order_value}}</p>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('silver_punches', 'Silver Punches:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{$Model_Data->silver_punches}}</p>
            </div>
        </div>
        <?php if($Model_Data->silver_fixed_value != null) { ?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('silver_fixed_value', 'Silver Fixed Discount') !!}
            </div>
            <div class="col-sm-8">
                <p>{{$Model_Data->silver_fixed_value}}</p>
            </div>
        </div>
        <?php }  else if($Model_Data->silver_discount_percentage != null) {?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('silver_discount_percentage', 'Silver Percentage Discount') !!}
            </div>
            <div class="col-sm-8">
                <p>{{$Model_Data->silver_discount_percentage}}</p>
            </div>
        </div>
        <?php } ?>


        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('golden_punches', 'Golden Punches:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{$Model_Data->golden_punches}}</p>
            </div>
        </div>
        <?php if($Model_Data->golden_fixed_value != null) { ?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('golden_fixed_value', 'Golden Fixed Discount') !!}
            </div>
            <div class="col-sm-8">
                <p>{{$Model_Data->golden_fixed_value}}</p>
            </div>
        </div>
        <?php }  else if($Model_Data->golden_discount_percentage != null) {?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('golden_discount_percentage', 'Golden Percentage Discount') !!}
            </div>
            <div class="col-sm-8">
                <p>{{$Model_Data->golden_discount_percentage}}</p>
            </div>
        </div>
        <?php } ?>


        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('platinum_punches', 'Platinum Punches:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{$Model_Data->platinum_punches}}</p>
            </div>
        </div>
        <?php if($Model_Data->silver_fixed_value != null) { ?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('platinum_fixed_value', 'Platinum Fixed Discount') !!}
            </div>
            <div class="col-sm-8">
                <p>{{$Model_Data->platinum_fixed_value}}</p>
            </div>
        </div>
        <?php }  else if($Model_Data->platinum_discount_percentage != null) {?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('platinum_discount_percentage', 'Platinum Percentage Discount') !!}
            </div>
            <div class="col-sm-8">
                <p>{{$Model_Data->platinum_discount_percentage}}</p>
            </div>
        </div>
        <?php } ?>


       

       

        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('has_limitations', 'Has Limitations:') !!}
            </div>
            <div class="col-sm-8">
                <p>
                    <?php
                    if($Model_Data->has_limitations == 0)
                    {
                        echo "No Limitations";
                    }
                    elseif($Model_Data->has_limitations == 1)
                    {
                        echo "Interval Based";
                    }
                    elseif($Model_Data->has_limitations == 2)
                    {
                        echo "Date Based";
                    }
                    ?>
                </p>

            </div>
        </div>


        <?php
        if($Model_Data->has_limitations == 1){
        ?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('interval', 'Interval:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->intervals }} Days</p>
            </div>
        </div>
        <?php
        }
        ?>



        <?php
        if($Model_Data->has_limitations == 2){
        ?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('start_date', 'Start Date:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ date("Y-m-d",$Model_Data->start_date) }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('end_date', 'End Date:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ date("Y-m-d",$Model_Data->end_date) }}</p>
            </div>
        </div>
        <?php
        }
        ?>


        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('created_at', 'Created At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->created_at }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('updated_at', 'Updated At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->updated_at }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-8 text-right">
                <?php
                if($Model_Data->status == 0){
                ?>
                <a href="{{ route('rewards.edit', $Model_Data->id) }}" class='btn btn-primary'>
                    Edit
                </a>
                <?php
                }
                ?>
                <a href="{{ url('service/rewards') }}" class="btn btn-outline-dark">Cancel</a>
            </div>
        </div>
    </div>
</div>