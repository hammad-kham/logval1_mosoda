@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Edit Reward</h1>
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
                            <a href="{{ url('rewards') }}">Rewards</a>
                          </li>
                          <li class="breadcrumb-item active" aria-current="page">
                            Edit
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ url('rewards') }}">
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
                
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Reward</h4>
                    </div>
                    <div class="card-body">
                          {!! Form::model($Model_Data, ['route' => ['rewards.update', $Model_Data->id], 'method' => 'patch','name' => 'myForm','id' => 'myForm','onsubmit'=>'return validateForm()','novalidate']) !!}
                        <div class="block-content">
                            @include('svc.rewards.fields_edit')
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
                    
            </div>
        </div>
        <div id="fixed_div_data" class="hide" >
        <div class="col-sm-4">
            {!! Form::label('type_value', 'Choose Fixed Value Per Item:') !!}
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                {!! Form::number('type_value', $Model_Data->fixed_value, ['class' => 'form-control','required' => '', 'step'=>'0.001']) !!}
                <span class="input-group-text">OMR</span>
            </div>
        </div>
        <div class="col-sm-4"> 
            <small class="nomodal" data-toggle="tooltip" title="Fixed Discount value to be Claimed per Reward">
                <i class="fa fa-2x fa-info-circle"></i>
            </small>
        </div>
    </div>

    <div id="percentage_div_data" class="hide" >
        <div class="col-sm-4">
            {!! Form::label('type_value', 'Choose Discount Percentage Per Item:') !!}
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                {!! Form::number('type_value', $Model_Data->discount_percentage, ['class' => 'form-control','required' => '','min'=>'1','max'=>'80']) !!}
                <span class="input-group-text">%</span>
            </div>          
        </div>
        <div class="col-sm-4"> 
            <small class="nomodal" data-toggle="tooltip" title="Percentage Discount value to be Claimed per Reward">
                <i class="fa fa-2x fa-info-circle"></i>
            </small>
        </div>
    </div>
    </div>
</section>
@endsection

@push('scripts')
    <style>
        .hide{
            display:none;
        }

        .radioBtnc > .notActive{
            color: #3276b1!important;
            background-color: #fff!important;
            opacity:0.2;
        }
    </style>
    <script>

        function validateForm() {
            var order_value = document.forms["myForm"]["min_order_value"].value;
            var num_of_orders = document.forms["myForm"]["min_orders"].value;
            var type_id = document.forms["myForm"]["type_id"].value;

            <?php /*?>if (parseInt(num_of_orders) > parseInt(order_value)) {
                alert("Order value cannot be smaller than no. of order");
                return false;
            }
            else <?php */?>
            if(parseInt(type_id) == 1){
                let type_value = document.forms["myForm"]["type_value"].value;
                if(parseInt(order_value) < parseInt(type_value)){
                    alert("Fixed value cannot be greater than total order value");
                    return false;
                }
            }

            if(parseInt(type_id) == 1 || parseInt(type_id) == 2){
                if($( ".selected_menus" ).hasClass('active')){
                    if($('.menus_checked:checked').length < 1){
                        alert("Kindly select atleast 1 menu");
                        return false;
                    }
                }
                else if($( ".selected_items" ).hasClass('active')){
                    if($('.items_checked:checked').length < 1){
                        alert("Kindly select atleast 1 item");
                        return false;
                    }
                }
            }
            if(parseInt(type_id) == 3 ){

                if($('.item_checked:checked').length < 1){
                    alert("Kindly select an item");
                    return false;
                }
            }
        }

        $(document).ready(function(e) {

            $('#myForm').find('input[name=min_order_value]').change(function()
            {
                var min_order_value = $('#myForm').find('input[name=min_order_value]').val();
                console.log(min_order_value);
                {
                    min_order_value = parseFloat(min_order_value).toFixed(3);
                    $('#myForm').find('input[name=min_order_value]').val(min_order_value);
                }

            });

            $('#chk_limitations').click(function (){
                if($('#chk_limitations').is(':checked')){
                    $('#timings').removeClass('hide');
                }
                else{
                    $('#timings').addClass('hide');
                }
            });

            $("#type_id").change(function()
            {
                var type_id = $("#type_id").val();
                if(type_id == 1)
                {
                    $("#add_option_div").html($("#fixed_div_data").html());
                    $("#add_price_div").removeClass('hide');
                    $("#reward").addClass('hide');
                    $("#menu_item").removeClass('hide');

                    $('#myForm').find('input[name=type_value]').change(function()
                    {
                        var type_id = $("#type_id").val();
                        var type_value = $('#myForm').find('input[name=type_value]').val();
                        console.log(type_value);    
                        if(type_id == 1)
                        {
                            type_value = parseFloat(type_value).toFixed(3);
                            $('#myForm').find('input[name=type_value]').val(type_value);
                        }
        
                    });
                }
                else if(type_id == 2)
                {
                    $("#add_option_div").html($("#percentage_div_data").html());
                    $("#add_price_div").removeClass('hide');
                    $("#menu_item").removeClass('hide');
                    $("#reward").addClass('hide');
                }
                else if(type_id == 3)
                {
                    $("#add_option_div").html('');
                    // $("#add_price_div").removeClass('hide');
                    $("#reward").removeClass('hide');
                    $("#menu_item").addClass('hide');
                }
                else
                {
                    $("#add_option_div").html('');
                    $("#menu_item").addClass('hide');
                    $("#reward").addClass('hide');

                }

                main_events();

            });


            $("#limitation").change(function()
            {
                var limitation = $("#limitation").val();
                if(limitation == 0)
                {
                    $("#timings").addClass('hide');
                    $("#interval").addClass('hide');
                }
                else if(limitation == 1)
                {
                    $("#timings").addClass('hide');
                    $("#interval").removeClass('hide');

                }
                else if(limitation == 2)
                {
                    $("#interval").addClass('hide');
                    $("#timings").removeClass('hide');
                }


            });

            $('.radioBtnc2 a').on('click', function(){
                var sel = $(this).data('titlec');
                var tog = $(this).data('togglec');
                $('#'+tog).prop('value', sel);

                $('a[data-togglec="'+tog+'"]').not('[data-titlec="'+sel+'"]').removeClass('active').addClass('notActive');
                $('a[data-togglec="'+tog+'"][data-titlec="'+sel+'"]').removeClass('notActive').addClass('active');

                var menus_div = tog+'_menus_div';
                var items_div = tog+'_items_div';

                if(sel == 0)
                {
                    $('.'+menus_div).removeClass('hide');
                    $('.'+items_div).addClass('hide');
                }
                else
                {
                    $('.'+items_div).removeClass('hide');
                    $('.'+menus_div).addClass('hide');
                }
            });

            if($("#rest_id"))
            {
                var rest_id = $("#rest_id").val();
                if(rest_id == 0 || rest_id == '' || rest_id == null)
                {
                    $("#rest_id").change(function()
                    {
                        rest_id = $("#rest_id").val();
                        if(rest_id == 0 || rest_id == '' || rest_id == null)
                        {
                            rest_id = 0;
                        }
                        get_item_list(rest_id);
                        get_single_items(rest_id);
                        get_items(rest_id);
                        get_menus(rest_id);
                    });
                }
                else
                {
                    main_events();
                }
            }

            main_events();
        });

        function main_events()
        {
            $('[data-toggle="tooltip"]').tooltip();
            
            if($('.btn_close_single_modal'))
            {
                $('.btn_close_single_modal').off();
                $('.btn_close_single_modal').click(function(e) {
                    $('#singleModal').modal('hide');
                });
            }
            if($('.btn_close_list_modal'))
            {
                $('.btn_close_list_modal').off();
                $('.btn_close_list_modal').click(function(e) {
                    $('#listModal').modal('hide');
                });
            }

            if($('.btn_close_menu_modal'))
            {
                $('.btn_close_menu_modal').off();
                $('.btn_close_menu_modal').click(function(e) {
                    $('#menusModal').modal('hide');
                });
            }

            if($('.btn_close_item_modal'))
            {
                $('.btn_close_item_modal').off();
                $('.btn_close_item_modal').click(function(e) {
                    $('#itemsModal').modal('hide');
                });
            }

            check_all_items();

            check_all_menus();

        }



        function get_single_items(rest_id)
        {
            $('#ajax_single_data').html('');

            var url='{{URL::to("/")}}/rewards/' + rest_id +'/items_single_data';

            $.get(url, function(responseData)
            {
                $("#ajax_single_data").html(responseData);
                main_events();
            });
        }


        function get_items(rest_id)
        {
            $('#ajax_items_data').html('');

            var url='{{URL::to("/")}}/rewards/' + rest_id +'/items_data';

            $.get(url, function(responseData)
            {
                $("#ajax_items_data").html(responseData);
                main_events();
            });
        }
        function get_menus(rest_id)
        {
            $('#ajax_menus_data').html('');

            var url='{{URL::to("/")}}/rewards/' + rest_id +'/menus_data';

            $.get(url, function(responseData)
            {
                $("#ajax_menus_data").html(responseData);
                main_events();
            });
        }


        function check_all_menus()
        {
            if($('.check_all_menus'))
            {
                $('.check_all_menus').off();

                if($('.check_ind_menu'))
                {
                    $('.check_ind_menu').off();
                    $('.check_all_menus').change(function(){
                        if(this.checked) {
                            // Iterate each checkbox
                            $('.check_ind_menu').each(function() {
                                this.checked = true;
                            });
                        } else {
                            $('.check_ind_menu').each(function() {
                                this.checked = false;
                            });
                        }
                    });
                }
            }
        }

        function check_all_items()
        {
            if($('.check_all_items'))
            {
                $('.check_all_items').off();

                if($('.check_ind_item'))
                {
                    $('.check_ind_item').off();
                    $('.check_all_items').change(function(){
                        if(this.checked) {
                            // Iterate each checkbox
                            $('.check_ind_item').each(function() {
                                this.checked = true;
                            });
                        } else {
                            $('.check_ind_item').each(function() {
                                this.checked = false;
                            });
                        }
                    });
                }
            }
        }


        function get_item_list(rest_id)
        {
            $('#ajax_list_data').html('');

            var url='{{URL::to("/")}}/rewards/' + rest_id +'/items_list_data';

            $.get(url, function(responseData)
            {
                $("#ajax_list_data").html(responseData);
                main_events();
            });
        }

        function check_all_items()
        {
            if($('.check_all_items'))
            {
                $('.check_all_items').off();

                if($('.check_list_item'))
                {
                    $('.check_list_item').off();
                    $('.check_all_items').change(function(){
                        if(this.checked) {
                            $('.check_list_item').each(function() {
                                this.checked = true;
                            });
                        } else {
                            $('.check_list_item').each(function() {
                                this.checked = false;
                            });
                        }
                    });
                }
            }
        }


    </script>
@endpush