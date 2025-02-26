
{{ Form::hidden( 'vend_id', $vend_id ) }}
{{ Form::hidden( 'service_id', $service_id ) }}
{{ Form::hidden( 'sub_service_id', $sub_service_id ) }}

<?php
for($i=0; $i<$attributes_count; $i++){

    $name = createSlug($options_array[$i]['name'],'_');

    if( $options_array[$i]['num_field'] == 1 ){
        $type = 'number';
    }
    elseif( $options_array[$i]['text_field'] == 1 ){
        $type = 'text';
    }
?>

<div class="form-group row" id="categories" >
    <div class="col-sm-3">
        {!! Form::label($name, $options_array[$i]['name']) !!}
    </div>
    <div class="col-sm-9">
        {!! Form::input($type,$name, $prices_array[$i], ['class' => 'form-control']) !!}
    </div>
</div>
<?php
}
?>