
<div class="form-group">
    
    <div class="row">
        <div class="col-sm-12">
            <h6>Category: {{ $Category->title }}</h6>
        </div>
    </div>
    
    <?php
    $total_sum = 0;
    $discount = 0;
    $headers = 0;
    ?>
    
    <?php
    if($Order->attributes != null)
    {
        $headers = 1;
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
                                $var_price += $attribute->price;
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
                    <h6>
                        @if($Order->cat_id == 2)
                            {{"Products"}}
                        @else
                            {{"Services"}}
                        @endif
                    </h6>
                </div>
                <div class="col-sm-2 text-right">
                    <h6>
                        <?php
                        if($headers == 0){
                            echo "Quantity";
                        }
                        ?>
                    </h6>
                </div>
                <div class="col-sm-2 text-right">
                    <h6>
                        <?php
                        if($headers == 0){
                            echo "Price";
                        }
                        ?>
                    </h6>
                </div>
                <div class="col-sm-2 text-right">
                    <h6>
                        <?php
                        if($headers == 0){
                            echo "Total";
                        }
                        ?>
                    </h6>
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
                $service_id = 0;
                foreach($Order_Details as $order_Detail)
                {
                if($order_Detail->sub_cat_id == $sub_cat->id)
                {
                    $var_quantity = 0;
                    $var_price = 0;
                    ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <p>
                                <?php
                                    if($order_Detail->product_id != 0)
                                    {
                                        ?>
                                        
                                        {{$order_Detail->product_name}}
                                        
                                        <?php
                                        if($order_Detail->quantity != 0 && $order_Detail->sub_service_id == 0)
                                        {
                                            $var_quantity+= $order_Detail->quantity;
                                            
                                        }
                                        if($order_Detail->product_price != 0)
                                        {
                                            $var_price+= $order_Detail->product_price;
                                        }
                                    }
                                    
                                    elseif($order_Detail->service_id != 0)
                                    {
                                        $service_id = $order_Detail->service_id;
                                        
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
                                            if($order_Detail->service_price != 0)
                                            {
                                                $var_price+= $order_Detail->service_price;
                                            }
                                            
                                        }
                                        else
                                        {
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
//                                            if($order_Detail->service_price != 0)
//                                            {
//                                                $var_price+= $order_Detail->service_price;
//                                            }
                                            if($order_Detail->sub_service_price != 0)
                                            {
                                                $var_price+= $order_Detail->sub_service_price;
                                            }
                                            
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
                                        
                                        
                                    }
                                    
                                    if(isset($order_Detail->attributes) && $order_Detail->attributes != null)
                                    {
                                    ?>
                                    <br >
                                <div class="row" style="border-bottom:1px solid #000;">
                                    <div class="col-sm-3"><strong>Attribute</strong></div>
                                    <div class="col-sm-3 text-right"><strong>Quantity</strong></div>
                                    <div class="col-sm-3 text-right"><strong>Price</strong></div>
                                    <div class="col-sm-3 text-right"><strong>Total</strong></div>
                                </div>
                                <?php
                                $at_total_sum = 0;
                                $attributes = json_decode($order_Detail->attributes);
                                foreach ($attributes as $attribute)
                                {
                                    $at_quantity = $attribute->quantity;
                                    $at_price = $attribute->price;
                                    $at_total = ($at_quantity * $at_price);
                                    $at_total_sum+= ($at_total);
                                    ?>
                                    <div class="row" style="border-bottom:1px solid #000;">
                                        <div class="col-sm-3">{{$attribute->name}}</div>
                                        <div class="col-sm-3 text-right">{{$at_quantity}}</div>
                                        <div class="col-sm-3 text-right">{{$at_price}}</div>
                                        <div class="col-sm-3 text-right">{{$at_total}}</div>
                                    </div>
                                    <?php
                                }
                                $attr_price+= ($at_total_sum);
                                ?>
                                <div class="row" style="border-bottom:1px solid #000;">
                                    <div class="col-sm-3">&nbsp;</div>
                                    <div class="col-sm-3">&nbsp;</div>
                                    <div class="col-sm-3">&nbsp;</div>
                                    <div class="col-sm-3 text-right">{{$at_total_sum}}</div>
                                </div>
                                <?php
                                }
                            
                            if($var_quantity == 0)
                            {
                                $var_quantity = 1;
                            }
                            if(isset($order_Detail->attributes) && $order_Detail->attributes != null){
                                $var_total = ($attr_price);
                            }
                            else{
                                $var_total = (($var_quantity * $var_price) );
                            }
                            ?>
                            </p>
                        </div>
                        <div class="col-sm-2 text-right">
                            <h6>
                                <?php
                                if(isset($order_Detail->attributes) && $order_Detail->attributes != null){
                                    echo "-";
                                }
                                else{
                                    echo $var_quantity;
                                }
                                ?>
                                {{--                        {{$var_quantity}}--}}
                            </h6>
                        </div>
                        <div class="col-sm-2 text-right">
                            <h6>
                                <?php
                                if(isset($order_Detail->attributes) && $order_Detail->attributes != null){
                                    echo "-";
                                }
                                else{
                                    echo $var_price;
                                }
                                ?>
                                {{--                       {{$var_price}}--}}
                            </h6>
                        </div>
                        <div class="col-sm-2 text-right">
                            <h6>
                                <?php
                                if(isset($order_Detail->attributes) && $order_Detail->attributes != null){
                                    echo "0";
                                }
                                else{
                                    echo $var_total;
                                }
                                ?>
                                {{--{{$var_total}}--}}
                            </h6>
                        </div>
                    </div>
                    <?php
                    $total_sum+=$var_total;
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
                <div class="col-sm-2 text-right">
                    <h6> {{ $total_sum }} </h6>
                </div>
            </div>
        </div>
    </div>

    @if($Order->discount != 0)
    <div class="row mt-4">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-7">
                </div>
                <div class="col-sm-3 text-right">
                    <h6> Discount 
                    <p>(Reward-Claimed)</p>
                    </h6>
                </div>
                <div class="col-sm-2 text-right">
                    <h6> {{ $Order->discount }} </h6>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($Order->coupon_discount != 0)
    <div class="row mt-4">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-7">
                </div>
                <div class="col-sm-3 text-right">
                    <h6>Coupon Discount 
                    </h6>
                </div>
                <div class="col-sm-2 text-right">
                    <h6> {{ $Order->coupon_discount }} </h6>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    
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
                    <div class="col-sm-7">
                    </div>
                    <div class="col-sm-3 text-right">
                        <h5> Total Value</h5>
                    </div>
                    <div class="col-sm-2 text-right">
                        <h5> {{ $Order->final_value  }} </h5>
                    </div>
                </div>
            </div>
        </div>
 
</div>