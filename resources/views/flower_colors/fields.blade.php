
<div class="form-group row">
    <div class="col-sm-6">
        {!! Form::label('name', 'Title [En]:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
    <div class="col-sm-6">
        {!! Form::label('ar_name', 'Title [Ar]:') !!}
        {!! Form::text('ar_name', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-6">
        {!! Form::label('name', 'Color Value:') !!}
        <?php
        $color_value = '#000000';
        if(isset($Model_Data->value))
        {
            $color_value = $Model_Data->value;
        }
        ?>
        <input type="text" class="form-control colorpickerinput" id="colorpicker1" name="value" value="{{ $color_value }}">
         
        <?php /*?><div class="js-colorpicker input-group js-colorpicker-enabled colorpicker-element" data-format="hex" data-colorpicker-id="1" id="colorpicker1">
            <input type="text" class="form-control" name="value" value="{{ $color_value }}">
            <div class="input-group-text colorpicker-input-addon" data-bs-original-title="" title="" tabindex="0">
                <i style="background: rgb(92, 128, 209);"></i>
            </div>
        </div><?php */?>
    </div>
</div>

<?php
if(isset($Model_Data)){
?>
<div class="row">
    <div class=" form-group col-12 text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('flower-colors.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<?php
}
?>
