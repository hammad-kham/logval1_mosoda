<?php
$additional_details_count = 0;
?>

<div class="row form-group">
    
    @if($Order->created_at != "")
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('', 'Created At :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->created_at }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->notes != "")
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('', 'Notes :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->notes }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->need_material != 0)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('needmaterial', 'Need Material :') !!}
            </div>
            <div class="col-sm-6">
                <p> Yes </p>
            </div>
        </div>
    @endif
    
    @if($Order->material_notes != NULL)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('materialnotes', 'Material Notes :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->material_notes }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->need_ironing != 0)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('need_ironing', 'Need Ironing :') !!}
            </div>
            <div class="col-sm-6">
                <p> Yes </p>
            </div>
        </div>
    @endif
    
    @if($Order->cleaners != 0)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('cleaners', 'No. of Cleaners :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->cleaners }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->covid != 0)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('covid', 'Covid :') !!}
            </div>
            <div class="col-sm-6">
                <p> Yes </p>
            </div>
        </div>
    @endif
    
    @if($Order->is_ladder == 1)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('ladder', 'Ladder :') !!}
            </div>
            <div class="col-sm-6">
                <p> Yes </p>
            </div>
        </div>
        
        <?php
        if($Order->ladder_length != 0)
        {
        ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('ladderlength', 'Ladder Length :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->ladder_length." ft" }}</p>
            </div>
        </div>
        <?php
        }
        ?>
    @endif
    
    @if($Order->need_pickup != 0)
        <?php $additional_details_count++; ?>
        {{-- need pickup yes or no if 1 than show --}}
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('needpickup', 'Need Pickup :') !!}
            </div>
            <div class="col-sm-6">
                <p> Yes </p>
            </div>
        </div>
    @endif
    
    @if($Order->date_time != 0)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('dateandtime', 'Date and Time :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ date('d-m-Y h:i a',$Order->date_time) }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->date_time_drop_off != 0)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('date_time_drop_off', 'Date and Time Drop Off :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ date('d-m-Y h:i a',$Order->date_time_drop_off) }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->current_wall_color != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('current_wall_color', 'Current Wall Color :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->current_wall_color }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->new_wall_color != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('new_wall_color', 'New Wall Color :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->new_wall_color }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->provide_paint >= 1)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('provide_paint', 'Provide Paint :') !!}
            </div>
            <div class="col-sm-6">
                <p> Yes </p>
            </div>
        </div>
    @endif
    
    @if($Order->paint_code != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('paint_code', 'Paint Code :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->paint_code }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->add_white_color_cost >= 1)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('add_white_color_cost', 'Add White Color Cost :') !!}
            </div>
            <div class="col-sm-6">
                <p> Yes </p>
            </div>
        </div>
    @endif
    
    @if($Order->need_ceilings_painted >= 1)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('need_ceilings_painted', 'Need Ceilings Painted :') !!}
            </div>
            <div class="col-sm-6">
                <p> Yes </p>
            </div>
        </div>
    @endif
    
    @if($Order->rooms >= 1)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('rooms', 'Rooms :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->rooms }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->sender_name != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('sender_name', 'Sender Name :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->sender_name }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->receiver_name != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('receiver_name', 'Receiver Name :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->receiver_name }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->message != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('message', 'Message :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->message }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->additional_cost >= 1)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('additional_cost', 'Additional Cost :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->additional_cost }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->cancelled_time != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('cancelled_time', 'Cancelled Time :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ date('d-m-Y h:i a',$Order->cancelled_time) }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->confirmed_time != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('confirmed_time', 'Confirmed Time :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ date('d-m-Y h:i a',$Order->confirmed_time) }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->declined_time != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('declined_time', 'Declined Time :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ date('d-m-Y h:i a',$Order->declined_time) }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->accepted_time != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('accepted_time', 'Accepted Time :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ date('d-m-Y h:i a',$Order->accepted_time) }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->completed_time != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('completed_time', 'Completed Time :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ date('d-m-Y h:i a',$Order->completed_time) }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->cancel_reason != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('cancel_reason', 'Cancel Reason :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->cancel_reason }}</p>
            </div>
        </div>
    @endif
    
    @if($Order->decline_reason != null)
        <?php $additional_details_count++; ?>
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('decline_reason', 'Decline Reason :') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Order->decline_reason }}</p>
            </div>
        </div>
    @endif

</div>


<?php
if($additional_details_count == 0)
{
	?>
<div class="row form-group">
    <div class="col-sm-12 " style="text-align: center">
        <p>No Additional Details</p>
    </div>
</div>
<?php
}
?>