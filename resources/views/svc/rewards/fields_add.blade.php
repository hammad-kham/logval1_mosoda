<div class="row justify-content-center mt-2 mb-2 form-group">
  <div class="col-sm-12">
    
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


<div class="form-group row mt-3">
        <div class="col-sm-4"> 
        	{!! Form::label('min_order_value', 'Minimum Punch Value') !!} 
        </div>
        <div class="col-sm-4"> 
            <div class="input-group">
            	{!! Form::number('min_order_value', '0', ['class' => 'form-control', 'id'=>'min_punch_value', 'required'=>'', 'min'=>1]) !!}
                
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
        {!! Form::label('silver_punches', 'No of Punches To Claim Silver House') !!} 
      </div>
      <div class="col-sm-4"> 
        <div class="input-group">
          {!! Form::number('silver_punches', 0, ['class' => 'form-control', 'id'=>'silver_punches', 'required'=>'', 'min'=>1, 'step'=>'0']) !!}
          
        </div>
      </div>
      <div class="col-sm-4"> 
        <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim Silver house/reward">
          <i class="fa fa-2x fa-info-circle"></i>
        </small>
      </div>
    </div>
    <div class="form-group row mt-3">
        <div class="col-sm-4">
        	{!! Form::label('silver_discount_type', 'Silver House Discount Type') !!} 
        </div>
        <div class="col-sm-4"> 
        <div class="input-group">
            	{!! Form::select('silver_discount_type', $s_types,'null', ['class' => 'form-control', 'id'=>'silver_punchess', 'required'=>'', 'min'=>1, 'step'=>'0']) !!}
               
            </div>
            
          </div>
          <div class="col-sm-4"> 
            <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim Silver house/reward">
              <i class="fa fa-2x fa-info-circle"></i>
            </small>
          </div>
    </div>
    <div class="form-group row mt-3" id="add_option_div_silver"></div>


    <div class="form-group row mt-3">
      <div class="col-sm-4">
        {!! Form::label('golden_punches', 'No of Punches To Claim Golden House') !!} 
      </div>
      <div class="col-sm-4"> 
        <div class="input-group">
          {!! Form::number('golden_punches', 0, ['class' => 'form-control', 'id'=>'silver_punches', 'required'=>'', 'min'=>1, 'step'=>'0']) !!}
          
        </div>
      </div>
      <div class="col-sm-4"> 
        <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim Silver house/reward">
          <i class="fa fa-2x fa-info-circle"></i>
        </small>
      </div>
    </div>
    <div class="form-group row mt-3">
        <div class="col-sm-4">
        	{!! Form::label('golden_discount_type', 'Golden House Discount Type') !!} 
        </div>
        <div class="col-sm-4"> 
        <div class="input-group">
            	{!! Form::select('golden_discount_type', $g_types,'null', ['class' => 'form-control', 'id'=>'golden_punches', 'required'=>'', 'min'=>1, 'step'=>'0']) !!}
               
            </div>
            
          </div>
          <div class="col-sm-4"> 
            <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim Silver house/reward">
              <i class="fa fa-2x fa-info-circle"></i>
            </small>
          </div>
    </div>
    <div class="form-group row mt-3" id="add_option_div_golden"></div>

    <div class="form-group row mt-3">
      <div class="col-sm-4">
        {!! Form::label('platinum_punches', 'No of Punches To Claim Platinum House') !!} 
      </div>
      <div class="col-sm-4"> 
        <div class="input-group">
          {!! Form::number('platinum_punches', 0, ['class' => 'form-control', 'id'=>'silver_punches', 'required'=>'', 'min'=>1, 'step'=>'0']) !!}
          
        </div>
      </div>
      <div class="col-sm-4"> 
        <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim Silver house/reward">
          <i class="fa fa-2x fa-info-circle"></i>
        </small>
      </div>
    </div>
    <div class="form-group row mt-3">
        <div class="col-sm-4">
        	{!! Form::label('platinum_discount_type', 'Platinum House Discount Type') !!} 
        </div>
        <div class="col-sm-4"> 
        <div class="input-group">
            	{!! Form::select('platinum_discount_type', $p_types,'null', ['class' => 'form-control', 'id'=>'platinum_punches', 'required'=>'', 'min'=>1, 'step'=>'0']) !!}
               
            </div>
            
          </div>
          <div class="col-sm-4"> 
            <small class="nomodal" data-toggle="tooltip" title="Minimum number of Punches to Claim Silver house/reward">
              <i class="fa fa-2x fa-info-circle"></i>
            </small>
          </div>
      </div>
    <div class="form-group row mt-3" id="add_option_div_platinum"></div>
    
    
   
   

   
 

    <!-- <div class="form-group row mt-3">
        <div class="col-sm-4"> 
        	{!! Form::label('type_id', 'Reward Type:') !!}
        </div>
        <div class="col-sm-4"> 
        	{!! Form::select('type_id', $types, null, ['placeholder' => 'select','class' => 'form-control','required' => '']) !!} 
        </div>
    </div>

       <div class="form-group row mt-3" id="add_option_div"></div>
    	<?php
        $type = 1;
        ?> -->



        
   
   


    <div class="row">
      <div class="col-sm-4"> {!! Form::label('has_limitaiton', 'Has Limitation:') !!} </div>
      <div class="col-sm-4">
        <select class="form-control" name="limitation" id="limitation">
          <option value="0">Select Limitation</option>
          <option value="1">Interval Based</option>
          <option value="2">Date Based</option>
        </select>
      </div>
    </div>
    <div class="hide" id="interval">
      <div class="form-group row mt-4">
        <div class="col-sm-4"> {!! Form::label('interval', 'Interval:') !!} </div>
        <div class="col-sm-4">
          <select class="form-control" name="interval">
            <option value="">Select Intervals</option>
            <option value="30">30 Days</option>
            <option value="60">60 Days</option>
            <option value="90">90 Days</option>
          </select>
        </div>
      </div>
    </div>
    <div class="hide" id="timings">
      <div class="form-group row mt-4">
        <div class="col-sm-4"> {!! Form::label('start_date', 'Start Date:') !!} </div>
        <div class="col-sm-4"> {{ Form::date('start_date',\Carbon\Carbon::now(),['class' => 'form-control', 'min' => date("Y-m-d"), 'required' => '']) }} </div>
      </div>
      <div class="form-group row mt-3">
        <div class="col-sm-4"> {!! Form::label('end_date', 'End Date:') !!} </div>
        <div class="col-sm-4"> {{ Form::date('end_date',\Carbon\Carbon::now(),['class' => 'form-control', 'min' => date("Y-m-d"), 'required' => '']) }} </div>
      </div>
    </div>

    <div class="form-group row mt-3 mb-3">
      <div class="col-sm-12 text-center"> {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!} <a href="{{url('service/rewards')}}" class='btn btn-outline-dark'> Cancel </a> </div>
    </div>
  </div>
</div>
