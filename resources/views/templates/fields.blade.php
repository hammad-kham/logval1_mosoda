
<div class="row mt-2 mb-2 form-group">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <strong>Subject:</strong>
                <br />
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12">
                <strong>Description:</strong>
                <br />

				<?php
                if(isset($Model_Data) && $Model_Data->type == 2)
                {
                    ?>
                	{!! Form::textarea('description', null, ['class' => 'form-control summernote']) !!}
					<?php
                }
				elseif(isset($Model_Data) && $Model_Data->type == 1)
                {
                    ?>
                	{!! Form::textarea('description', null, ['class' => 'form-control']) !!}
					<?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row mt-2 mb-2 form-group">
    <div class="col-sm-6">
    </div>        
    <div class="col-sm-6">
        <div class="row mt-3">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-8">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('templates.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
</div>