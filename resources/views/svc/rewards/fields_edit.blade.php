<div class="row justify-content-center mt-2 mb-2 form-group">

<?php  
    $s_types = array();
    $s_types[-1]= "";
    $s_types[0] = "Fixed Value Discount"; 
    $s_types[1] = "Percentage Discount"; 

    $g_types = array();
    $g_types[-1]= "";
    $g_types[0] = "Fixed Value Discount"; 
    $g_types[1] = "Percentage Discount"; 

    $p_types = array();
    $p_types[-1]= "";
    $p_types[0] = "Fixed Value Discount"; 
    $p_types[1] = "Percentage Discount"; 
  ?>

    <div class="col-sm-12">

    <div class="form-group row mt-3">
            <div class="col-sm-4">
                {!! Form::label('min_order_value', 'Minimum Punch Value') !!}
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                {!! Form::number('min_order_value', null, ['class' => 'form-control', 'required'=>'', 'step'=>'0.001']) !!}
                
                </div>                
            </div>
            <div class="col-sm-4"> 
                <small class="nomodal" data-toggle="tooltip" title="Minimum order value to Claim one Punch">
                    <i class="fa fa-2x fa-info-circle"></i>
                </small>
            </div>
        </div>

     
        <div class="form-group row mt-3">
            <div class="col-sm-4">
                {!! Form::label('silver_punches', 'Silver Punchess') !!}
            </div>
            <div class="col-sm-4"> 
            <div class="input-group">
                {!! Form::number('silver_punches', null, ['class' => 'form-control', 'required'=>'', 'step'=>'0']) !!}
                
                </div>  
            </div>
            <div class="col-sm-4"> 
                <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim one Reward">
                    <i class="fa fa-2x fa-info-circle"></i>
                </small>
            </div>
        </div>

        <?php if($Model_Data->silver_fixed_value != null){ ?>
            
        <div class="form-group row mt-3">
            <div class="col-sm-4">
                {!! Form::label('silver_fixed_value', 'Choose Fixed value Per Silver House') !!}
            </div>
            <div class="col-sm-4"> 
            <div class="input-group">
                {!! Form::number('silver_fixed_value', null, ['class' => 'form-control', 'required'=>'', 'step'=>'0']) !!}
                
                </div>  
            </div>
            <div class="col-sm-4"> 
                <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim one Reward">
                    <i class="fa fa-2x fa-info-circle"></i>
                </small>
            </div>
        </div> 
        
        <?php } elseif($Model_Data->silver_discount_percentage != null){  ?>

        <div class="form-group row mt-3">
            <div class="col-sm-4">
                {!! Form::label('silver_discount_percentage', 'Choose Discount Percentage Per Silver House') !!}
            </div>
            <div class="col-sm-4"> 
            <div class="input-group">
                {!! Form::number('silver_discount_percentage', null, ['class' => 'form-control', 'required'=>'', 'step'=>'0']) !!}
                
                </div>  
            </div>
            <div class="col-sm-4"> 
                <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim one Reward">
                    <i class="fa fa-2x fa-info-circle"></i>
                </small>
            </div>
        </div>
        
        <?php } ?>


        <div class="form-group row mt-3">
            <div class="col-sm-4">
                {!! Form::label('golden_punches', 'Golden Punches') !!}
            </div>
            <div class="col-sm-4"> 
            <div class="input-group">
                {!! Form::number('golden_punches', null, ['class' => 'form-control', 'required'=>'', 'step'=>'0']) !!}
                
                </div>  
            </div>
            <div class="col-sm-4"> 
                <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim one Reward">
                    <i class="fa fa-2x fa-info-circle"></i>
                </small>
            </div>
        </div>


        <?php if($Model_Data->golden_fixed_value != null){ ?>
            
            <div class="form-group row mt-3">
                <div class="col-sm-4">
                    {!! Form::label('golden_fixed_value', 'Choose Fixed value Per Golden House') !!}
                </div>
                <div class="col-sm-4"> 
                <div class="input-group">
                    {!! Form::number('golden_fixed_value', null, ['class' => 'form-control', 'required'=>'', 'step'=>'0']) !!}
                    
                    </div>  
                </div>
                <div class="col-sm-4"> 
                    <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim one Reward">
                        <i class="fa fa-2x fa-info-circle"></i>
                    </small>
                </div>
            </div> 
            
            <?php } elseif($Model_Data->golden_discount_percentage != null){  ?>
    
            <div class="form-group row mt-3">
                <div class="col-sm-4">
                    {!! Form::label('golden_discount_percentage', 'Choose Discount Percentage Per Golden House') !!}
                </div>
                <div class="col-sm-4"> 
                <div class="input-group">
                    {!! Form::number('golden_discount_percentage', null, ['class' => 'form-control', 'required'=>'', 'step'=>'0']) !!}
                    
                    </div>  
                </div>
                <div class="col-sm-4"> 
                    <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim one Reward">
                        <i class="fa fa-2x fa-info-circle"></i>
                    </small>
                </div>
            </div>
            
            <?php } ?>




        <div class="form-group row mt-3">
            <div class="col-sm-4">
                {!! Form::label('platinum_punches', 'Platinum Punches') !!}
            </div>
            <div class="col-sm-4"> 
            <div class="input-group">
                {!! Form::number('platinum_punches', null, ['class' => 'form-control', 'required'=>'', 'step'=>'0']) !!}
                
                </div>  
            </div>
            <div class="col-sm-4"> 
                <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim one Reward">
                    <i class="fa fa-2x fa-info-circle"></i>
                </small>
            </div>
        </div>
        
        <?php if($Model_Data->platinum_fixed_value != null){ ?>
            
            <div class="form-group row mt-3">
                <div class="col-sm-4">
                    {!! Form::label('platinum_fixed_value', 'Choose Fixed value Per Platinum House') !!}
                </div>
                <div class="col-sm-4"> 
                <div class="input-group">
                    {!! Form::number('platinum_fixed_value', null, ['class' => 'form-control', 'required'=>'', 'step'=>'0']) !!}
                    
                    </div>  
                </div>
                <div class="col-sm-4"> 
                    <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim one Reward">
                        <i class="fa fa-2x fa-info-circle"></i>
                    </small>
                </div>
            </div> 
            
            <?php } elseif($Model_Data->platinum_discount_percentage != null){  ?>
    
            <div class="form-group row mt-3">
                <div class="col-sm-4">
                    {!! Form::label('platinum_discount_percentage', 'Choose Discount Percentage Per Platinum House') !!}
                </div>
                <div class="col-sm-4"> 
                <div class="input-group">
                    {!! Form::number('platinum_discount_percentage', null, ['class' => 'form-control', 'required'=>'', 'step'=>'0']) !!}
                    
                    </div>  
                </div>
                <div class="col-sm-4"> 
                    <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim one Reward">
                        <i class="fa fa-2x fa-info-circle"></i>
                    </small>
                </div>
            </div>
            
            <?php } ?>


 

    





        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('has_limitaiton', 'Has Limitation:') !!}
            </div>
            <div class="col-sm-4">
                <select class="form-control" name="limitation" id="limitation">
                    <option value="0" <?php if($Model_Data->has_limitations == 0){?> selected="selected" <?php } ?> >Select Limitation</option>
                    <option value="1" <?php if($Model_Data->has_limitations == 1){?> selected="selected" <?php } ?> >Interval Based</option>
                    <option value="2" <?php if($Model_Data->has_limitations == 2){?> selected="selected" <?php } ?> >Date Based</option>
                </select>
            </div>
        </div>


        <div class="hide" id="interval">
            <div class="form-group row mt-4">
                <div class="col-sm-4">
                    {!! Form::label('interval', 'Interval:') !!}
                </div>
                <div class="col-sm-4">
                    <select class="form-control" name="interval">

                        <option value="30" <?php if($Model_Data->intervals == 30){?> selected="selected" <?php } ?> >30 Days</option>
                        <option value="60" <?php if($Model_Data->intervals == 60){?> selected="selected" <?php } ?> >60 Days</option>
                        <option value="90" <?php if($Model_Data->intervals == 90){?> selected="selected" <?php } ?> >90 Days</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="hide" id="timings">
            <div class="form-group row mt-4">
                <div class="col-sm-4">
                    {!! Form::label('start_date', 'Start Date:') !!}
                </div>
                <div class="col-sm-4">
                    {{ Form::date('start_date',date('Y-m-d',$Model_Data->start_date),['class' => 'form-control', 'min' => date("Y-m-d")]) }}
                </div>
            </div>

            <div class="form-group row mt-3">
                <div class="col-sm-4">
                    {!! Form::label('end_date', 'End Date:') !!}
                </div>
                <div class="col-sm-4">
                    {{ Form::date('end_date',date('Y-m-d',$Model_Data->end_date),['class' => 'form-control', 'min' => date("Y-m-d")]) }}
                </div>
            </div>
        </div>


        <div class="form-group row mt-3 mb-3">
            <div class="col-sm-12 text-center">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{url('rewards')}}" class='btn btn-outline-dark' >
                    Cancel
                </a>
            </div>
        </div>
    </div>
</div>