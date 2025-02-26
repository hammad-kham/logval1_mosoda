@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Orders Details</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('orders.index') }}">Orders</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                View Details
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('orders.index') }}">
                        <i class="fa fa-chevron-left mr-2"></i> Return to Listing
                    </a>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">


                    @include('flash::message')
                    @include('coreui-templates::common.errors')

                    <div class="row">



                        <div class="content col-sm-12 mb-4">

                            <div class="row mt-4">
                                <div class="col-sm-12 text-right">
                                    @if($Order->status == 1 || $Order->status == 3)
                                        <a href="{{ route('svc_orders_accept', $Order->id ) }}" class="btn btn-success">
                                            Accept
                                        </a>
                                        <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#createModal">
                                            Decline
                                        </a>
                                    @endif
                                    @if($Order->type == 0)
                                        @if($Order->status == 5)
                                            <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('order_status_change',[$Order->id,6]) }}">
                                                Team Left
                                            </a>
                                        @elseif($Order->status == 6)
                                            <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('order_status_change',[$Order->id,7]) }}">
                                                Team Reached
                                            </a>
                                        @elseif($Order->status == 7)
                                            <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('order_status_change',[$Order->id,8]) }}">
                                                Service Delivered
                                            </a>
                                        @endif

                                    @endif


                                </div>
                            </div>

                        </div>


                        <div class="content col-sm-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-uppercase">
                                        <?php
                                        if($Order->type == 0){
                                            echo "Fixed Price";
                                        }
                                        elseif($Order->type == 1){
                                            echo "Get a Quote";
                                        }
                                        ?>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    @include('svc.vendors.orders.show_order_details')
                                </div>
                            </div>
                        </div>
                        <div class="content col-sm-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-uppercase">User Information</h4>
                                </div>
                                <div class="card-body">
                                    @include('svc.vendors.orders.show_user_details')
                                </div>
                            </div>
                        </div>
                        <div class="content col-sm-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-uppercase">Vendor Information</h4>
                                </div>
                                <div class="card-body">
                                    @include('svc.vendors.orders.show_vendor_details')
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="content col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-uppercase">Addons</h4>
                                </div>
                                <div class="card-body">
                                   
                                        @include('svc.vendors.orders.show_addons')
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="content col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-uppercase">Details</h4>
                                </div>
                                <div class="card-body">
                                    @if($Order->type == 0)
                                        @include('svc.vendors.orders.show_details_fixed')
                                    @else
                                        @include('svc.vendors.orders.show_details_quote')
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <?php
                    if($items_count > 0)
                    {
                    ?>
                    <div class="row">
                        <div class="content col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-uppercase">Home Items</h4>
                                </div>
                                <div class="card-body">
                                    @include('svc.vendors.orders.show_home_items')
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>


                    <div class="row">
                        <div class="content col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-uppercase">Additional Details</h4>
                                </div>
                                <div class="card-body">
                                    @include('svc.vendors.orders.show_additional_details')
                                </div>
                            </div>
                        </div>
                    </div>


                    @if($Transaction != null)
                    <div class="row">
                        <div class="content col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-uppercase">Transaction Details</h4>
                                </div>
                                <div class="card-body">
                                    @include('svc.vendors.orders.show_transaction_details')
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if ($Order->has_files == 1)
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-uppercase">Order Images</h4>
                            </div>
                            <div class="card-body">
                                @include('svc.vendors.orders.show_images')
                            </div>
                        </div>
                    @endif


                </div>
            </div>

        </div>
    </section>

    <?php
    if($Order->status == 1 || $Order->status == 3)
    {
    ?>
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog"
         aria-labelledby="createModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content card card-primary">
                <div class="card-header">
                    <h4>Decline</h4>
                    <div class="card-header-action">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    {!! Form::open(['route' => 'svc_orders_reject','files' => true]) !!}

                    <div class="block-content fs-sm">

                        <div class="form-group row">

                            <input type="hidden" name="order_id" value="<?php echo $Order->id;?>" />

                            <div class="col-sm-12">
                                {!! Form::label('reason', 'Reason To Decline:') !!}
                                {!! Form::textarea('reason', null, ['placeholder' => 'Reason', 'class' => 'form-control' , 'cols' => 10, 'rows' =>10, 'required' => '']) !!}

                            </div>
                        </div>

                        <div class="row">
                            <div class=" form-group col-12 text-right">
                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </div>


                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>

@endsection

@push('scripts')

    <script>

        @if($Order->type == 1)
        jQuery(document).ready(function(e)
        {
            if($('.quote_input'))
            {
                $('.quote_input').change(function(e) {
                    var field_id = $(this).data('field_id');
                    var quantity = parseInt($('#sub_cat_quantity_'+field_id).val());
                    var attr_sum = parseInt($('#sub_cat_attr_sum_'+field_id).val());
                    var price = parseInt($(this).val());
                    //alert(price);
                    var total = parseInt(price * quantity);
                    total+=attr_sum;
                    //alert(total);
                    $('#total_sub_cat_quote_'+field_id).val(total);
                    calculate_total();
                });
            }
        });
        function calculate_total()
        {
            var total_quotation_value = 0;
            $('.quote_input').each(function(index, element) {
                var sub_cat_id = $(this).data('field_id');
                var total = parseInt($('#total_sub_cat_quote_'+sub_cat_id).val());
                total_quotation_value+=total;
            });
            $('#total_quotation_value').val(total_quotation_value);
        }
        @endif

    </script>

@endpush