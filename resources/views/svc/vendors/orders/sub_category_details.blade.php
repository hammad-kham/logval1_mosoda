
<div class="row form-group">
    
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-3">
                {!! Form::label('title', 'title') !!}
            </div>
            <div class="col-sm-9">
                <p>{{ $SubCat->title }}</p>
            </div>
            <div class="col-sm-3">
                {!! Form::label('description', 'Description') !!}
            </div>
            <div class="col-sm-9">
                <p>{{ $SubCat->description }}</p>
            </div>
        </div>
    </div>

</div>