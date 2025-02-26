<?php
$segment3 =  Request::segment(3);

$mod_list = 1;
$mod_add = 1;
$mod_edit = 1;
$mod_view = 1;
$mod_status = 1;
$mod_delete = 1;
if($segment3 == "edit")
{
    $mod_list = $Model_Data->mod_list;
    $mod_add = $Model_Data->mod_add;
    $mod_edit = $Model_Data->mod_edit;
    $mod_view = $Model_Data->mod_view;
    $mod_status = $Model_Data->mod_status;
    $mod_delete = $Model_Data->mod_delete;
}
?>

<div class="row justify-content-center mt-2 mb-2 form-group">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('module_name', 'Name:') !!}
            </div>
            <div class="col-sm-8">
                {!! Form::text('module_name', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <?php
        $is_mod = $mod_list;
        $field = 'mod_list';
        ?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('value', 'Allow: View Listing') !!}
            </div>
            <div class="col-sm-8">
                <div class="btn-group radioBtn">
                    <?php
                    $class = 'notActive';
                    if($is_mod == 1)
                    {
                        $class = 'active';
                    }
                    ?>
                    <a class="btn btn-primary btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1">Yes</a>
                    <?php
                    $class = 'notActive';
                    if($is_mod == 0)
                    {
                        $class = 'active';
                    }
                    ?>
                    <a class="btn btn-primary btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0">No</a>
                </div>
                <input type="hidden" name="<?php echo $field;?>" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            </div>
        </div>

        <?php
        $is_mod = $mod_add;
        $field = 'mod_add';
        ?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('value', 'Allow: Add New Record') !!}
            </div>
            <div class="col-sm-8">
                <div class="btn-group radioBtn">
                    <?php
                    $class = 'notActive';
                    if($is_mod == 1)
                    {
                        $class = 'active';
                    }
                    ?>
                    <a class="btn btn-primary btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1">Yes</a>
                    <?php
                    $class = 'notActive';
                    if($is_mod == 0)
                    {
                        $class = 'active';
                    }
                    ?>
                    <a class="btn btn-primary btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0">No</a>
                </div>
                <input type="hidden" name="<?php echo $field;?>" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            </div>
        </div>

        <?php
        $is_mod = $mod_edit;
        $field = 'mod_edit';
        ?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('value', 'Allow: Update Record') !!}
            </div>
            <div class="col-sm-8">
                <div class="btn-group radioBtn">
                    <?php
                    $class = 'notActive';
                    if($is_mod == 1)
                    {
                        $class = 'active';
                    }
                    ?>
                    <a class="btn btn-primary btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1">Yes</a>
                    <?php
                    $class = 'notActive';
                    if($is_mod == 0)
                    {
                        $class = 'active';
                    }
                    ?>
                    <a class="btn btn-primary btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0">No</a>
                </div>
                <input type="hidden" name="<?php echo $field;?>" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            </div>
        </div>

        <?php
        $is_mod = $mod_view;
        $field = 'mod_view';
        ?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('value', 'Allow: View Record Details') !!}
            </div>
            <div class="col-sm-8">
                <div class="btn-group radioBtn">
                    <?php
                    $class = 'notActive';
                    if($is_mod == 1)
                    {
                        $class = 'active';
                    }
                    ?>
                    <a class="btn btn-primary btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1">Yes</a>
                    <?php
                    $class = 'notActive';
                    if($is_mod == 0)
                    {
                        $class = 'active';
                    }
                    ?>
                    <a class="btn btn-primary btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0">No</a>
                </div>
                <input type="hidden" name="<?php echo $field;?>" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            </div>
        </div>

        <?php
        $is_mod = $mod_status;
        $field = 'mod_status';
        ?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('value', 'Allow: Change Record Status') !!}
            </div>
            <div class="col-sm-8">
                <div class="btn-group radioBtn">
                    <?php
                    $class = 'notActive';
                    if($is_mod == 1)
                    {
                        $class = 'active';
                    }
                    ?>
                    <a class="btn btn-primary btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1">Yes</a>
                    <?php
                    $class = 'notActive';
                    if($is_mod == 0)
                    {
                        $class = 'active';
                    }
                    ?>
                    <a class="btn btn-primary btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0">No</a>
                </div>
                <input type="hidden" name="<?php echo $field;?>" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            </div>
        </div>

        <?php
        $is_mod = $mod_delete;
        $field = 'mod_delete';
        ?>
        <div class="row mt-3">
            <div class="col-sm-4">
                {!! Form::label('value', 'Allow: Delete Record') !!}
            </div>
            <div class="col-sm-8">
                <div class="btn-group radioBtn">
                    <?php
                    $class = 'notActive';
                    if($is_mod == 1)
                    {
                        $class = 'active';
                    }
                    ?>
                    <a class="btn btn-primary btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1">Yes</a>
                    <?php
                    $class = 'notActive';
                    if($is_mod == 0)
                    {
                        $class = 'active';
                    }
                    ?>
                    <a class="btn btn-primary btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0">No</a>
                </div>
                <input type="hidden" name="<?php echo $field;?>" id="<?php echo $field;?>" value="<?php echo $is_mod;?>">
            </div>
        </div>

        <?php
        if(isset($Model_Data)){
        ?>
        <div class="row">
            <div class=" form-group col-12 text-right">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('modules.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>

        <?php
        }
        ?>


    </div>
</div>
