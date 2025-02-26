
<div class="form-group">

    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('orderno', 'Order No.') !!}
        </div>
        <div class="col-sm-6">
            <p>{{ $Order->order_no }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('orderstatus', 'Order Status') !!}
        </div>
        <div class="col-sm-6">
            <p>
                <?php
                $status = get_svc_order_status($Order->status, $Order->type);
                echo $status;
                ?>
            </p>
        </div>
    </div>

   
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('totalvalue', 'Total Value') !!}
        </div>
        <div class="col-sm-6">
            <p>{{ $Order->total }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('vat_included', 'Vat Included % ') !!}
        </div>
        <div class="col-sm-6">
            <p>{{ $Order->vat_included }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('vat_value', 'Vat Value') !!}
        </div>
        <div class="col-sm-6">
            <p>{{ $Order->vat_value }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('final_value', 'Final Value') !!}
        </div>
        <div class="col-sm-6">
            <p>{{ $Order->final_value }}</p>
        </div>
    </div>

</div>