
<div class="form-group row">

    @if($Transaction->transaction_id != "")
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('transaction_id', 'Transaction ID:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Transaction->transaction_id }}</p>
            </div>
        </div>
    @endif

    @if($Transaction->card_number != "")
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('card_number', 'Card Number:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Transaction->card_number }}</p>
            </div>
        </div>
    @endif

    @if($Transaction->card_type != "")
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('card_type', 'Card Type:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Transaction->card_type }}</p>
            </div>
        </div>
    @endif

    @if($Transaction->card_brand != "")
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('card_brand', 'Card Brand:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Transaction->card_brand }}</p>
            </div>
        </div>
    @endif

    @if($Transaction->nick_name != "")
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('nick_name', 'Nick Name:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ $Transaction->nick_name }}</p>
            </div>
        </div>
    @endif

    @if($Transaction->transaction_date_time != "")
        <div class="col-sm-6 row">
            <div class="col-sm-6">
                {!! Form::label('transaction_date_time', 'Date Time:') !!}
            </div>
            <div class="col-sm-6">
                <p>{{ date("Y-m-d H:i:s", $Transaction->transaction_date_time) }}</p>
            </div>
        </div>
    @endif

</div>