<?php
 $segment1 =  Request::segment(3);
?>
<div class="row mt-2 mb-2 form-group">
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-12">
                <strong>Title [En]:</strong>
                <br />
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12">
                <strong>Description [En]:</strong>
                <br />
                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-12">
                <strong>Title [Ar]:</strong>
                <br />
                {!! Form::text('ar_title', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12">
                <strong>Description [Ar]:</strong>
                <br />
                {!! Form::textarea('ar_description', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

<!--    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-12">
                <strong>Status:</strong>
                <br />
                {!! Form::text('status', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>-->

    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-12">
                <strong>Image:</strong>
                <br />
                {!! Form::file('image', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>
<div class="row mt-2 mb-2 form-group">
    <div class="col-sm-6">
        <div class="row mt-3">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-8">
            </div>
        </div>
    </div>        
    <div class="col-sm-6">
        <div class="row mt-3">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-8">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('app-pages.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
</div>