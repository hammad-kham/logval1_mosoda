
<div class="row">
    @foreach($get_currency_record as $currency)

        <input type="hidden" name="id[]" value="{{$currency->id}}">
        <div class="col-sm-3">
            <div class="row mt-2 mb-2">
                <div class="form-group col-sm-3">
                    {!! Form::label($currency->code, $currency->code.':') !!}
                </div>
                <div class="col-sm-5">
                    {!! Form::number('rate[]', $currency->rate, ['class' => 'form-control', 'step' => 1, 'min' => 1]) !!}
                </div>
                <div class="col-sm-4">
                </div>
            </div>
        </div>

    @endforeach
</div>
<br>      
<div class="row">
    <div class=" form-group col-12 text-right">
        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}                
    </div>
</div>