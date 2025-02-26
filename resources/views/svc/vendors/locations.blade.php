<?php
$location = null;
$lat = null;
$lng = null;
if(isset($Model_Data))
{
    $location = $Model_Data->location;
    $lat = $Model_Data->lat;
    $lng = $Model_Data->lng;
}
?>
<div class="row form-group">
    <div class="col-sm-6">
        {!! Form::label('location', 'Location:') !!}
        <input type="text" class="form-control" name="location" id="searchmap" value="<?php echo $location;?>">
    </div>

    <div class="col-sm-3">
        {!! Form::label('lat', 'Latitude:') !!}
        {!! Form::text('lat', $lat, ['class' => 'form-control']) !!}
    </div>

    <div class="col-sm-3">
        {!! Form::label('lng', 'Longitude:') !!}
        {!! Form::text('lng', $lng, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-12">
        <div id="mymap" style="width:100%; height:400px; border:1px solid"></div>
    </div>
</div>