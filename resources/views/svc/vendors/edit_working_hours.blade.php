<?php

$time_to_hours = get_time_to_hours_array();


$days = [
	'monday',
	'tuesday',
	'wednesday',
	'thursday',
	'friday',
	'saturday',
	'sunday'
];
?>
<table class="table table-striped table-hover" width="100%" border="0">
  	<tr>
		<th style="width:12.5%">&nbsp;</th>
		<?php
        foreach ($days as $day)
        {
            $label = ucwords($day);
            ?>	
            <th style="width:12.5%">{!! Form::label('day', $label) !!}</th>
            <?php	
        }
        ?>
  	</tr>
	<?php
	if(isset($WorkingHours))
	{
		foreach ($WorkingHours as $WorkingHour)
		{
			?>
			<tr>
				<?php
				$start = 0;
				foreach ($days as $day)
				{	
					$start++;
					$day_status= $day .'_status';
					$is_day = $status = $WorkingHour->$day_status;
					
					$time_key = $WorkingHour->time_value;
					
					$field= $day.'_'.$time_key;
					
					$str = $time_to_hours[$time_key];
					if($start == 1)
					{
						?>
						<th>
                            <div class="btn-group radioBtn2">
    
                                <a class="btn btn-success btn-sm notActive" data-toggle="<?php echo $time_key;?>" data-title="1">
                                	<i class="fa fa-check fa-lg"></i>
                                </a>
    
                                <a class="btn btn-danger btn-sm notActive" data-toggle="<?php echo $time_key;?>" data-title="0">
                                	<i class="fa fa-times fa-lg"></i>
                                </a>
    
                            </div>
                            
                        	{!! Form::label('str', $str) !!}

                        </th>
						<?php
					}
					?>
                    <td>                    
                        <div class="radioBtn">
                            <?php
                            $class = 'hide';
                            if($is_day == 1)
                            {
                                $class = '';
                            }
                            ?>
                            <a class="btn btn-success btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="0">
                            <i class="fa fa-check"></i>
                            </a>
                            <?php
                            $class = 'hide';
                            if($is_day == 0)
                            {
                                $class = '';
                            }
                            ?>
                            <a class="btn btn-danger btn-sm <?php echo $class;?>" data-toggle="<?php echo $field;?>" data-title="1">
                            <i class="fa fa-times"></i>
                            </a>
                        </div>
                        <input type="hidden" name="<?php echo $field;?>" id="<?php echo $field;?>" value="<?php echo $is_day;?>">
                    </td>
                    <?php
				}
				?>
			</tr>
			<?php
		}
	}
	else
	{
	}
    ?>
  	</tr>
</table>