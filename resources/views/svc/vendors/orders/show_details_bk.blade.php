<?php
if($Order->type == 1){
?>
{!! Form::open(['route' => 'services.store','files' => true]) !!}
<?php
}
?>

<div class="row form-group">
    <div class="col-sm-12 row order_details">
        <div class="col-sm-12 row order_details">
            <div class="col-sm-10 row order_details">
                <div class="col-sm-2">
                    <h6>Category</h6>
                </div>
                <div class="col-sm-2">
                    <h6>Sub Category</h6>
                </div>
                <div class="col-sm-2">
                    <h6>Service</h6>
                </div>
                <div class="col-sm-2">
                    <h6>Sub Service</h6>
                </div>
                <div class="col-sm-2">
                    <h6>Products</h6>
                </div>
                <div class="col-sm-2">
                    <h6>Attributes</h6>
                </div>
            </div>
            
            <div class="col-sm-2 row order_details">
                <div class="col-sm-6">
                    <h6>Quantity</h6>
                </div>
                <div class="col-sm-6">
                    <h6>Price</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-12 row order_details">
            <div class="col-sm-10 row order_details">
                <div class="col-sm-2">
                    <p>{{ $Category->title }}</p>
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
            </div>
            
            <div class="col-sm-2 row order_details">
                <div class="col-sm-6">
                    -
                </div>
                <div class="col-sm-6">
                    -
                </div>
            
            </div>
        
        </div>
        
        <?php
        foreach($Sub_Category as $sub_cat)
		{
        ?>
        <div class="col-sm-12 row order_details">
            <div class="col-sm-10 row order_details">
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    <p>{{ $sub_cat->title }}</p>
                    <?php
                    if($Order->brand_name != null){
                        echo "<small>";
                        echo " (" . $Order->brand_name . ")";
                        echo "</small>";
                    }
                    ?>
                    </p>
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
            </div>
            
            <div class="col-sm-2 row order_details">
                <div class="col-sm-6">
                    -
                </div>
                <?php
                if($Order->type == 0){
                ?>
                <div class="col-sm-6">
                    -
                </div>
                <?php
                }
                else{
                ?>
                <div class="col-sm-6">
                    <?php
                    if(count($Order_Details) == 0)
                    {
                    ?>
                    {!! Form::number('', null, ['class' => 'form-control']) !!}
                    <?php
                    }
                    else{
                        echo "-";
                    }
                    ?>
                </div>
                <?php
                }
                ?>
            </div>
        
        </div>
        <?php
        $service_id = 0;
        foreach($Order_Details as $order_Detail){
        
        if($order_Detail->sub_cat_id == $sub_cat->id){
        
        if($order_Detail->product_id != 0){
        ?>
        <div class="col-sm-12 row order_details">
            <div class="col-sm-10 row order_details">
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    {{$order_Detail->product_name}}
                </div>
                <div class="col-sm-2">
                    -
                </div>
            </div>
            
            <div class="col-sm-2 row order_details">
                <div class="col-sm-6">
                    <?php
                    if($order_Detail->quantity != 0 && $order_Detail->sub_service_id == 0){
                    ?>
                    <p>{{$order_Detail->quantity}}</p>
                    <?php
                    }
                    else{
                        echo "-";
                    }
                    ?>
                </div>
                <?php
                if($Order->type == 0){
                ?>
                <div class="col-sm-6">
                    <?php
                    if($order_Detail->product_price != 0){
                    $price = 0;
                    if($order_Detail->quantity != 0){
                        $price = ($order_Detail->product_price * (int)$order_Detail->quantity);
                    }
                    else{
                        $price = $order_Detail->product_price;
                    }
                    ?>
                    <p>{{$price}}</p>
                    <?php
                    }
                    else{
                        echo "-";
                    }
                    ?>
                </div>
                
                <?php
                }
                ?>
            </div>
        
        </div>
        <?php
        }
        
        if($service_id != $order_Detail->service_id){
        ?>
        <div class="col-sm-12 row order_details">
            <div class="col-sm-10 row order_details">
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    <p>{{ $order_Detail->service_title }}
                        <?php
                        if($order_Detail->brand_name != null){
                            echo "<small>";
                            echo " (" . $order_Detail->brand_name . ")";
                            echo "</small>";
                        }
                        ?>
                    </p>
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
            </div>
            
            <div class="col-sm-2 row order_details">
                <div class="col-sm-6">
                    <?php
                    if($order_Detail->quantity != 0 && $order_Detail->sub_service_id == 0){
                    ?>
                    <p>{{$order_Detail->quantity}}</p>
                    <?php
                    }
                    else{
                        echo "-";
                    }
                    ?>
                </div>
                <?php
                if($Order->type == 0){
                ?>
                <div class="col-sm-6">
                    <?php
                    if($order_Detail->service_price != 0){
                    $price = 0;
                    if($order_Detail->quantity != 0){
                        $price = ($order_Detail->service_price * (int)$order_Detail->quantity);
                    }
                    else{
                        $price = $order_Detail->service_price;
                    }
                    ?>
                    <p>{{$price}}</p>
                    <?php
                    }
                    else{
                        echo "-";
                    }
                    ?>
                </div>
                <?php
                }
                ?>
            </div>
        
        </div>
        <?php
        }
        
        if($service_id == 0){
            $service_id = $order_Detail->service_id;
        }
        if($service_id != 0 && $order_Detail->sub_service_id != 0){
        ?>
        <div class="col-sm-12 row order_details">
            <div class="col-sm-10 row order_details">
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    <p>{{ $order_Detail->sub_service_title }}</p>
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
            </div>
            
            <div class="col-sm-2 row order_details">
                <div class="col-sm-6">
                    <?php
                    if($order_Detail->quantity != 0 && $order_Detail->sub_service_id != 0){
                    ?>
                    <p>{{$order_Detail->quantity}}</p>
                    <?php
                    }
                    else{
                        echo "-";
                    }
                    ?>
                </div>
                <?php
                if($Order->type == 0){
                ?>
                <div class="col-sm-6">
                    <?php
                    if($order_Detail->sub_service_price != 0){
                    $price = 0;
                    if($order_Detail->quantity != 0){
                        $price = ($order_Detail->sub_service_price * (int)$order_Detail->quantity);
                    }
                    else{
                        $price = $order_Detail->sub_service_price;
                    }
                    ?>
                    <p>{{$price}}</p>
                    <?php
                    }
                    else{
                        echo "-";
                    }
                    ?>
                </div>
                <?php
                }
                ?>
            </div>
        
        </div>
        <?php
        }
        }
        }
        ?>
        <?php
        if(isset($order_Detail->attributes) && $order_Detail->attributes != null){
        $attributes = json_decode($order_Detail->attributes);
        foreach ($attributes as $attribute){
        ?>
        <div class="col-sm-12 row order_details">
            <div class="col-sm-10 row order_details">
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    <p>{{$attribute->name}}</p>
                </div>
            </div>
            
            <div class="col-sm-2 row order_details">
                <div class="col-sm-6">
                    <p>{{$attribute->quantity}}</p>
                </div>
                <?php
                if($Order->type == 0){
                ?>
                <div class="col-sm-6">
                    <p>{{$attribute->price}}</p>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <?php
        }
        }
        ?>
        <?php
        }
        
        ?>
        
        <?php
        if($Order->attributes != null){
        $attributes = json_decode($Order->attributes);
        foreach ($attributes as $attribute){
        ?>
        <div class="col-sm-12 row order_details">
            <div class="col-sm-10 row order_details">
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    -
                </div>
                <div class="col-sm-2">
                    <p>{{$attribute->name}}</p>
                </div>
            </div>
            
            <div class="col-sm-2 row order_details">
                <div class="col-sm-6">
                    <p>{{$attribute->quantity}}</p>
                </div>
                <?php
                if($Order->type == 0){
                ?>
                <div class="col-sm-6">
                    <p>{{$attribute->price}}</p>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <?php
        }
        }
        ?>
        <?php
        if($Order->type == 0){
        ?>
        <div class="col-sm-12 row order_details top_line">
            <div class="col-sm-10 row order_details">
                <div class="col-sm-10">
                
                </div>
                <div class="col-sm-2 ">
                    <h6> Total </h6>
                </div>
            </div>
            
            <div class="col-sm-2 row order_details">
                <div class="col-sm-6">
                
                </div>
                <div class="col-sm-6">
                    <p>{{$Order->total}}</p>
                </div>
            </div>
        
        </div>
        <?php
        }
        else
        {
        ?>
        <div class="col-sm-12 row order_details top_line">
            <div class="col-sm-10 row order_details">
                <div class="col-sm-10">
                
                </div>
                <div class="col-sm-2 ">
                    <h6> Total </h6>
                </div>
            </div>
            
            <div class="col-sm-2 row order_details">
                <div class="col-sm-6">
                
                </div>
                <div class="col-sm-6">
                    <p id="total">0</p>
                </div>
            </div>
        
        </div>
        <?php
        }
        ?>
    
    </div>
</div>


<div class="row">
    <div class=" form-group col-12 text-right">
        {!! Form::submit('Submit Quote', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
<?php
if($Order->type == 1){
?>
{!! Form::close() !!}
<?php
}
?>

