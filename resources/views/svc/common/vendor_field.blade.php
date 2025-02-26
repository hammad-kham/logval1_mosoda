<?php
$Auth_User=Auth::User();
?>
@if($Auth_User->user_type == 'admin')
    <?php
    if(isset($Model_Data->vend_id))
    {
		?>
		<div class="form-group row">
			<div class="col-sm-3">
				{!! Form::label('vend_id', 'Vendor:') !!}
			</div>
			<div class="col-sm-9">
				{!! Form::select('vend_id', $vendors_array, $Model_Data->vend_id, ['placeholder' => 'select', 'class' => 'form-control', 'disabled'=>'disabled']) !!}
			</div>
		</div>
		<?php
    }
    else
    {
		?>
		<div class="form-group row">
			<div class="col-sm-3">
				{!! Form::label('vend_id', 'Vendor:') !!}
			</div>
			<div class="col-sm-9">
				{!! Form::select('vend_id', $vendors_array, null, ['placeholder' => 'select','class' => 'form-control']) !!}
			</div>
		</div>
		<?php
    }
    ?>
@elseif($Auth_User->user_type == 'vendor')
    <input type="hidden" id="vend_id" name="vend_id" value="<?php echo $Auth_User->vend_id;?>" />
@endif