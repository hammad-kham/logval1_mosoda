
<div class="card">
    <div class="card-header">
        <h4>Template Details</h4>
    </div>
    <div class="card-body">

        <div class="row form-group">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-4">
                        {!! Form::label('subject', 'Subject:') !!}
                    </div>
                    <div class="col-sm-8">
                        {{ $Model_Data->title }}</p>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-4">
                        {!! Form::label('description', 'Description:') !!}
                    </div>
                    <div class="col-sm-8">
                        <?php echo $Model_Data->description;?>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-4">
                        {!! Form::label('created_at', 'Created At:') !!}
                    </div>
                    <div class="col-sm-8">
                        {{ $Model_Data->created_at }}
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-4">
                        {!! Form::label('updated_at', 'Updated At:') !!}
                    </div>
                    <div class="col-sm-8">
                        {{ $Model_Data->updated_at }}
                    </div>
                </div>
    
    
                @if(Auth::user()->can('templates-edit') || Auth::user()->can('all'))
                    <div class="row mt-4">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-8">
                            <a href="{{ route('templates.edit', $Model_Data->id) }}" class='btn btn-primary'>
                                Edit
                            </a>
                            <a href="{{ route('templates.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                @endif
                
            </div>

        </div>

    </div>
</div>

<?php
if($Model_Data->type == 2)
{
	?>
    <div class="card">
        <div class="card-header">
            <h4>Template Display</h4>
        </div>
        <div class="card-body">
    
            <?php echo get_email_content_in_template($Model_Data->title, $Model_Data->description);?>
            <?php //echo custom_mail('aasifkhattak45@gmail.com', $Model_Data->title, $Model_Data->description);?>
    
        </div>
    </div>
	<?php
}
?>