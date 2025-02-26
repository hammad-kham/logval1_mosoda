<div class="row form-group">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('field_1', 'Phone Number:') !!}
            </div>
            <div class="col-sm-4">
                {!! Form::text('field_1', $Model_Data_1->value, ['class' => 'form-control','required'=>'']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('field_2', 'Email:') !!}
            </div>
            <div class="col-sm-4">
                {!! Form::text('field_2', $Model_Data_2->value, ['class' => 'form-control','required'=>'']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('field_3', 'Website:') !!}
            </div>
            <div class="col-sm-4">
                {!! Form::text('field_3', $Model_Data_3->value, ['class' => 'form-control','required'=>'']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('field_4', 'VAT:') !!}
            </div>
            <div class="col-sm-4">
                <div class="input-group">	
                	{!! Form::text('field_4', $Model_Data_4->value, ['class' => 'form-control','required'=>'']) !!}
                    <span class="input-group-text">%</span>
                </div>                
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('field_5', 'Order Declining Time:') !!}
            </div>
            <div class="col-sm-4">
                <div class="input-group">	
                	{!! Form::text('field_5', $Model_Data_5->value, ['class' => 'form-control','required'=>'']) !!}
                    <span class="input-group-text">Minutes</span>
                </div>                
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('field_6', 'Order Declining Reason:') !!}
            </div>
            <div class="col-sm-4">
                <div class="input-group">	
                	{!! Form::text('field_6', $Model_Data_6->value, ['class' => 'form-control','required'=>'']) !!}
                </div>                
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('field_7', 'Order Collection Time:') !!}
            </div>
            <div class="col-sm-4">
                <div class="input-group">	
                	{!! Form::text('field_7', $Model_Data_7->value, ['class' => 'form-control','required'=>'']) !!}
                    <span class="input-group-text">Minutes</span>
                </div>                
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('field_9', 'Maximum Fixed Discount Value:') !!}
            </div>
            <div class="col-sm-4">
                <div class="input-group">	
                	{!! Form::text('field_9', $Model_Data_9->value, ['class' => 'form-control','required'=>'']) !!}
                    <span class="input-group-text">%</span>
                </div>                
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('field_10', 'Maximum Percentage Discount Value:') !!}
            </div>
            <div class="col-sm-4">
                <div class="input-group">	
                	{!! Form::text('field_10', $Model_Data_10->value, ['class' => 'form-control','required'=>'']) !!}
                    <span class="input-group-text">%</span>
                </div>                
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('field_13', 'Good Maps API Key:') !!}
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                	{!! Form::text('field_13', $Model_Data_13->value, ['class' => 'form-control','required'=>'']) !!}
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('field_11', 'New Order Notification Audio:') !!}
            </div>
            <div class="col-sm-4">
                <div class="input-group">
       				 {!! Form::file('field_11', null, ['class' => 'form-control']) !!}
                </div>                
            </div>
            <div class="col-sm-4">
				<?php
                $file_path = 'audios/';
				$file = $Model_Data_11->value;
				if($file == 'new_order.mp3')
				{
					$image_path = 'defaults/';
				}
                $file_path.= $file;
                ?>
                <button type="button" onclick="playSound('{{ uploads($file_path) }}');">Play</button>              
            </div>    
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('field_12', 'User Arrived Notification Audio:') !!}
            </div>
            <div class="col-sm-4">
                <div class="input-group">
       				 {!! Form::file('field_12', null, ['class' => 'form-control']) !!}
                </div>                
            </div>
            <div class="col-sm-4">
				<?php
                $file_path = 'audios/';
				$file = $Model_Data_12->value;
				if($file == 'user_arrived.mp3')
				{
					$image_path = 'defaults/';
				}
                $file_path.= $file;
                ?>
                <button type="button" onclick="playSound2('{{ uploads($file_path) }}');">Play</button>              
            </div>    
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-8">
    			{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('general-settings.index') }}" class="btn btn-outline-dark">Cancel</a>
            </div>
        </div>
    </div>
</div>

<script>
function playSound(url)
{
	const audio = new Audio(url);
	audio.play();
}
function playSound2(url)
{
	const audio2 = new Audio(url);
	audio2.play();
}
</script>