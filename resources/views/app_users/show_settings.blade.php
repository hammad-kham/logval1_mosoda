
<div class="row">
    <div class="col-md-4">
        {!! Form::label('country', 'Country:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $country->name !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('currency', 'Currency:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $currency->name !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('language', 'Language:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $language->name !!} </p>
    </div>
</div>

