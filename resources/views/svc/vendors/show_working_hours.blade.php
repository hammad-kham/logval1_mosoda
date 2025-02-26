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
				$status = $WorkingHour->$day_status;
				
				$str = $time_to_hours[$WorkingHour->time_value];
				if($start == 1)
				{
					?>
					<th>{!! Form::label('str', $str) !!}</th>
                    <?php
				}
				if($status == 1)
				{
					?>
                    <td><button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button></td>
					<?php
				}
				else
				{
					?>
                    <td><button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button></td>
					<?php
				}	
			}
            ?>
		</tr>
		<?php
	}
    ?>
  	</tr>
</table>