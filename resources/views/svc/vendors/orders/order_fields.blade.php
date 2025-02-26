<div class="row form-group">
    <div class="col-sm-12">
        @if($Model_Data->status == 1)
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('status', 'Order Status') !!}
            </div>
            <div class="col-sm-8">
                <p>Waiting</p>
            </div>
        </div>
        @elseif($Model_Data->status == 2)
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('status', 'Order Status') !!}
            </div>
            <div class="col-sm-8">
                <p>Canceled</p>
            </div>
        </div>
        @elseif($Model_Data->status == 3)
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('status', 'Order Status') !!}
            </div>
            <div class="col-sm-8">
                <p>Confirmed</p>
            </div>
        </div>
        @elseif($Model_Data->status == 4)
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('status', 'Order Status') !!}
            </div>
            <div class="col-sm-8">
                <p>Declined</p>
            </div>
        </div>
        @elseif($Model_Data->status == 5)
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('status', 'Order Status') !!}
            </div>
            <div class="col-sm-8">
                <p>Accepted</p>
            </div>
        </div>
        @elseif($Model_Data->status == 6)
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('status', 'Order Status') !!}
            </div>
            <div class="col-sm-8">
                <p>Preparing</p>
            </div>
        </div>
        @elseif($Model_Data->status == 7)
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('status', 'Order Status') !!}
            </div>
            <div class="col-sm-8">
                <p>Ready</p>
            </div>
        </div>
        @elseif($Model_Data->status == 8)
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('status', 'Order Status') !!}
            </div>
            <div class="col-sm-8">
                <p>Collected</p>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('order_value', 'Order Value') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->order_value }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('vat_value', 'Vat Value') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->vat_value }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('total_value', 'Total Value') !!}
            </div>
            <div class="col-sm-8">
                <p>{{ $Model_Data->final_value }}</p>
            </div>
        </div>

    </div>

</div>

    