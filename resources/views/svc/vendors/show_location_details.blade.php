<div class="row">
    <div class="col-md-4">
        {!! Form::label('address', 'Address:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $Model_Data->location !!} </p>
    </div>
</div>

<?php
if(isset($Model_Data->lat) && isset($Model_Data->lng)){
?>
<div class="row">
    <div class="col-md-4">
        {!! Form::label('lat', 'Latitude:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $Model_Data->lat !!} </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        {!! Form::label('lng', 'Longitude:') !!}
    </div>
    <div class="col-md-8">
        <p> {!! $Model_Data->lng !!} </p>
    </div>
</div>

<div id="mymap" style="width:100%; height:400px; border:1px solid; margin-bottom: 15px"></div>

<?php
}
?>