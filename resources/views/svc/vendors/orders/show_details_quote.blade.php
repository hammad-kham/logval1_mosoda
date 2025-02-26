<?php
if($Order->status == 1 || $Order->status == 3 || $Order->status == 5 || $Order->status == 6)
{
?>
{!! Form::open(['route' => 'svc_orders_submit_quote','files' => true]) !!}
<?php
}
?>

<input type="hidden" name="order_id" value="{{$Order->id}}">

<div class="form-group">

    <div class="row">
        <div class="col-sm-12">
            <h6>Category: {{ $Category->title }}</h6>
        </div>
    </div>

    <?php
    $total_sum = 0;
    ?>

    <?php
    if($Order->attributes != null)
    {
    ?>
    <div class="row mt-4">
        <div class="col-sm-2">
            <h6>Attributes</h6>
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-6">
                    <h6>Name</h6>
                </div>
                <div class="col-sm-2 text-right">
                    <h6>Quantity</h6>
                </div>
                <div class="col-sm-2 text-right">
                    <h6>Price</h6>
                </div>
                <div class="col-sm-2 text-right">
                    <h6>Total</h6>
                </div>
            </div>
        </div>
    </div>

    <?php
    $attributes = json_decode($Order->attributes);
    foreach ($attributes as $attribute)
    {
    $var_quantity = 0;
    $var_price = 0;
    $var_total = 0;
    ?>
    <div class="row mt-4">
        <div class="col-sm-2">
            &nbsp;
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-6">
                    <p>

                        {{$attribute->name}}

                        <?php
                        $var_quantity = $attribute->quantity;
                        $var_price+= $attribute->price;
                        $var_total = ($var_quantity * $var_price);
                        ?>
                    </p>
                </div>
                <div class="col-sm-2 text-right">
                    <h6>{{$var_quantity}}</h6>
                </div>
                <div class="col-sm-2 text-right">
                    <h6>{{$var_price}}</h6>
                </div>
                <div class="col-sm-2 text-right">
                    <h6>{{$var_total}}</h6>
                </div>
            </div>
        </div>
    </div>
    <?php
    $total_sum+=$var_total;
    }
    ?>

    <div class="row">
        <div class="col-sm-12">
            <hr />
        </div>
    </div>
    <?php
    }
    ?>

    <div class="row mt-4">
        <div class="col-sm-2">
            <h6>Sub Category</h6>
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-6">
                    <h6>Services</h6>
                </div>
                <div class="col-sm-2">
                    <h6>Quantity</h6>
                </div>
                <div class="col-sm-2">
                    <h6>Price</h6>
                </div>
                <div class="col-sm-2">
                    <h6>Total</h6>
                </div>
            </div>
        </div>
    </div>

    <?php
    foreach($Sub_Category as $sub_cat)
    {
    $var_quantity = 0;
    $var_price = 0;
    $attr_price = 0;
    $var_total = 0;
    ?>
    <div class="row mt-4">
        <div class="col-sm-2">
            <p>
                {{ $sub_cat->title }}
                <?php
                if($Order->brand_name != null)
                {
                ?>
                <br >
                <small>
                    ( {{ $Order->brand_name }} )
                </small>
                <?php
                }
                ?>
            </p>
        </div>
        <div class="col-sm-10">
            <?php
            $field_id = $sub_cat->id;
            if(!isset($Order_Details) || empty($Order_Details) ||  count($Order_Details)==0)
            {
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <p>
                        <?php
                        if($var_quantity == 0)
                        {
                            $var_quantity = 1;
                        }

                        $var_price += $Order->sub_cat_price;
                        $var_total = (($var_quantity * $var_price) + $attr_price);
                        ?>
                    </p>
                    <input type="hidden" id="sub_cat_attr_sum_{{ $field_id }}" value="{{ $attr_price }}" />
                </div>
                <div class="col-sm-2">

                    <input type="number" value="{{ $var_quantity }}" class="form-control" name="sub_cat_quantity_{{ $field_id }}" id="sub_cat_quantity_{{ $field_id }}" readonly="readonly" />

                </div>
                <div class="col-sm-2">

                    <input type="number" value="{{ $var_price }}" class="form-control quote_input" name="quote_price_{{ $field_id }}" data-field_id="{{ $field_id }}"  <?php if($Order->status == 7 || $Order->status == 2 || $Order->status == 8 || $Order->status == 9){ ?>readonly="readonly" <?php } ?> required/>

                </div>
                <div class="col-sm-2">

                    <input type="number" value="{{ $var_total }}" class="form-control" id="total_sub_cat_quote_{{ $field_id }}" readonly="readonly" />

                </div>
            </div>
            <?php
            $total_sum+=$var_total;
            }
            else
            {
            foreach($Order_Details as $order_Detail)
            {
            if($order_Detail->sub_cat_id == $sub_cat->id)
            {
            $service_id = 0;
            $var_price = 0;
            $var_total = 0;
            if($order_Detail->service_id != 0)
            {
            $service_id = $order_Detail->service_id;
            $field_id = $service_id;
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <p>
                        <?php

                        if($order_Detail->sub_service_id == 0)
                        {
                        ?>
                        <a title="Service: {{ $order_Detail->service_title }}">
                            {{ $order_Detail->service_title }}
                        </a>

                        <?php
                        if($order_Detail->quantity != 0)
                        {
                            $var_quantity+= $order_Detail->quantity;
                        }
                        $var_price += $order_Detail->service_price;
                        }
                        else
                        {
                        $field_id = $order_Detail->sub_service_id;
                        ?>
                        <a title="Service: {{ $order_Detail->service_title }}">
                            {{ $order_Detail->service_title }}
                        </a>
                        &nbsp; > &nbsp;
                        <a title="Sub Service: {{ $order_Detail->sub_service_title }}">
                            {{ $order_Detail->sub_service_title }}
                        </a>
                        <?php
                        if($order_Detail->quantity != 0)
                        {
                            $var_quantity+= $order_Detail->quantity;
                        }
                        $var_price += $order_Detail->sub_service_price;
                        }

                        if($order_Detail->brand_name != null)
                        {
                        ?>
                        <br >
                        <small>
                            ( <a title="Brand: {{ $order_Detail->brand_name }}">
                                {{ $order_Detail->brand_name }}
                            </a> )
                        </small>
                        <?php
                        }

                        if($var_quantity == 0)
                        {
                            $var_quantity = 1;
                        }
                        $var_total = (($var_quantity * $var_price) + $attr_price);
                        ?>
                    </p>
                    <input type="hidden" id="sub_cat_attr_sum_{{ $field_id }}" value="{{ $attr_price }}" />
                </div>
                <div class="col-sm-2">

                    <input type="number" value="{{ $var_quantity }}" class="form-control" name="sub_cat_quantity_{{ $field_id }}" id="sub_cat_quantity_{{ $field_id }}" readonly="readonly" />

                </div>
                <div class="col-sm-2">

                    <input type="number" value="{{ $var_price }}" class="form-control quote_input" name="quote_price_{{ $field_id }}" data-field_id="{{ $field_id }}" <?php if($Order->status == 7 || $Order->status == 2 || $Order->status == 4 || $Order->status == 8 || $Order->status == 9){ ?>readonly="readonly" <?php } ?>/>

                </div>
                <div class="col-sm-2">

                    <input type="number" value="{{ $var_total }}" class="form-control" id="total_sub_cat_quote_{{ $field_id }}" readonly="readonly" />

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <hr />
                </div>
            </div>
            <?php
            $total_sum+=$var_total;
            }
            }
            }
            }
            ?>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <hr />
        </div>
    </div>
    <?php

    }
    ?>


    <div class="row mt-4">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-8">
                </div>
                <div class="col-sm-2 text-right">
                    <h6> Total </h6>
                </div>
                <div class="col-sm-2">
                    <input type="number" value="{{$total_sum}}" class="form-control" id="total_quotation_value" readonly="readonly" />
                </div>
            </div>
        </div>
    </div>


    <?php
    if($Order->type == 0)
    {
    $final_value = ($total_sum + $Order->vat_value);
    ?>
    <div class="row mt-4">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-8">
                </div>
                <div class="col-sm-2 text-right">
                    <h6> VAT Value </h6>
                </div>
                <div class="col-sm-2 text-right">
                    <h6> {{ $Order->vat_value }} </h6>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-8">
                </div>
                <div class="col-sm-2 text-right">
                    <h5> Total Value</h5>
                </div>
                <div class="col-sm-2 text-right">
                    <h5> {{ $final_value }} </h5>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    else
    {
    if($Order->status == 7 || $Order->status == 2 || $Order->status == 4 || $Order->status == 8 || $Order->status == 9)
    {
    ?>

    <div class="row mt-4">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-8">
                </div>
                <div class="col-sm-2 text-right">
                    <h6> VAT Value </h6>
                </div>
                <div class="col-sm-2 text-right">
                    <h6> {{ $Order->vat_value }} </h6>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-8">
                </div>
                <div class="col-sm-2 text-right">
                    <h5> Total Value</h5>
                </div>
                <div class="col-sm-2 text-right">
                    <h5> {{ $Order->final_value }} </h5>
                </div>
            </div>
        </div>
    </div>


    <?php
    }
    }
    ?>
    <?php
    if($Order->status == 1 || $Order->status == 3 || $Order->status == 5 || $Order->status == 6)
    {
    ?>
    <div class="row mt-4">
        <div class="col-sm-12 text-right">
            {!! Form::submit('Submit Quote', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}

    <?php
    }
    ?>



</div>