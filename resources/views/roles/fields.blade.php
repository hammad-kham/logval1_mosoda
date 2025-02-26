<?php
$cols_span = 'col-sm-8';
?>
<div class="row justify-content-center text-center mt-2 mb-2 form-group">
    <div class="<?php echo $cols_span;?>">
    
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('name', 'Name:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('display_to', 'Display To:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::select('display_to', ['0' => 'For Admin Users Only', '1' => 'For Vendor Users Only', '2' => 'For Seller Users Only'], null, ['class' => 'form-control']) !!}
            </div>
        </div>
        
        <?php
        if(isset($Model_Data))
		{
			?>
			<div class="row mt-3">
				<div class=" form-group col-12 text-right">
					{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
					<a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
				</div>
			</div>
			<?php
        }
        ?>

    </div>
</div>
