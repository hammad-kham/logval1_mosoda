<?php
$segment1 =  Request::segment(3);
?>

<div class="row justify-content-center text-center mt-2 mb-2 form-group">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('title', 'Contact Name:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('value', 'Contact Value:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::text('value', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <?php
        if(isset($Model_Data)){
        ?>
        <div class="row mt-3">
            <div class=" form-group col-12 text-right">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('contact-details.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>

        <?php
        }
        ?>

    </div>
</div>