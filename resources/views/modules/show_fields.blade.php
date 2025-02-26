<?php
$mod_list = $Model_Data->mod_list;
$mod_add = $Model_Data->mod_add;
$mod_edit = $Model_Data->mod_edit;
$mod_view = $Model_Data->mod_view;
$mod_status = $Model_Data->mod_status;
$mod_delete = $Model_Data->mod_delete;
?>
<div class="row justify-content-center mt-2 mb-2 form-group">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('module_name', 'Name:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->module_name }}</p>
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
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('created_at', 'Created At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->created_at }}</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('updated_at', 'Updated At:') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->updated_at }}</p>
            </div>
        </div>
    
    
        @if(Auth::user()->can('modules-edit') || Auth::user()->can('all'))
            <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-8">
                    <a href="{{ route('modules.edit', $Model_Data->id) }}" class='btn btn-primary'>
                        Edit
                    </a>
                    <a href="{{ route('modules.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        @endif
        
    </div>
</div>