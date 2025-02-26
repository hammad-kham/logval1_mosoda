@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Create New Reward</h1>
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
                            <a href="{{ url('service/rewards') }}">Rewards</a>
                          </li>
                          <li class="breadcrumb-item active" aria-current="page">
                            Create New
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ url('service/rewards') }}">
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
                        <h4>Create New Reward</h4>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['route' => 'rewards.store','files' => true, 'onSubmit' => 'validateForm()']) !!}
        
                            @include('svc.rewards.fields_add')
        
                        {!! Form::close() !!}
                    </div>
                </div>
                    
            </div>
        </div>
    </div>
</section>

    <div id="fixed_div_data_silver" class="hide" >
        <div class="col-sm-4">
            {!! Form::label('silver_fixed_value', 'Choose Fixed Value Per Silver House:') !!}
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                {!! Form::number('silver_fixed_value', 0, ['class' => 'form-control', 'id'=>'silver_fixed_value', 'required' => '', 'min'=>1]) !!}
                
            </div>
        </div>
        <div class="col-sm-4"> 
            <small class="nomodal" data-toggle="tooltip" title="Fixed Discount value to be Claimed per Reward">
                <i class="fa fa-2x fa-info-circle"></i>
            </small>
        </div>
    </div>

    <div id="percentage_div_data_silver" class="hide" >
        <div class="col-sm-4">
            {!! Form::label('silver_discount_percentage', 'Choose Discount Percentage Per Silver House:') !!}
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                {!! Form::number('silver_discount_percentage', 00, ['class' => 'form-control','required' => '','min'=>'1','max'=>'80']) !!}
                <span class="input-group-text">%</span>
            </div>          
        </div>
        <div class="col-sm-4"> 
            <small class="nomodal" data-toggle="tooltip" title="Percentage Discount value to be Claimed per Reward">
                <i class="fa fa-2x fa-info-circle"></i>
            </small>
        </div>
    </div>


    <div id="fixed_div_data_golden" class="hide" >
        <div class="col-sm-4">
            {!! Form::label('golden_fixed_value', 'Choose Fixed Value Per Golden House:') !!}
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                {!! Form::number('golden_fixed_value', 0, ['class' => 'form-control', 'id'=>'type_value', 'required' => '', 'min'=>1]) !!}
                
            </div>
        </div>
        <div class="col-sm-4"> 
            <small class="nomodal" data-toggle="tooltip" title="Fixed Discount value to be Claimed per Reward">
                <i class="fa fa-2x fa-info-circle"></i>
            </small>
        </div>
    </div>

    <div id="percentage_div_data_golden" class="hide" >
        <div class="col-sm-4">
            {!! Form::label('golden_discount_percentage', 'Choose Discount Percentage Per Golden House:') !!}
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                {!! Form::number('golden_discount_percentage', 00, ['class' => 'form-control','required' => '','min'=>'1','max'=>'80']) !!}
                <span class="input-group-text">%</span>
            </div>          
        </div>
        <div class="col-sm-4"> 
            <small class="nomodal" data-toggle="tooltip" title="Percentage Discount value to be Claimed per Reward">
                <i class="fa fa-2x fa-info-circle"></i>
            </small>
        </div>
    </div>


    <div id="fixed_div_data_platinum" class="hide" >
        <div class="col-sm-4">
            {!! Form::label('platinum_fixed_value', 'Choose Fixed Value Per Platinum House:') !!}
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                {!! Form::number('platinum_fixed_value', 0, ['class' => 'form-control', 'id'=>'type_value', 'required' => '', 'min'=>1]) !!}
                
            </div>
        </div>
        <div class="col-sm-4"> 
            <small class="nomodal" data-toggle="tooltip" title="Fixed Discount value to be Claimed per Reward">
                <i class="fa fa-2x fa-info-circle"></i>
            </small>
        </div>
    </div>

    <div id="percentage_div_data_platinum" class="hide" >
        <div class="col-sm-4">
            {!! Form::label('platinum_discount_percentage', 'Choose Discount Percentage Per Platinum House:') !!}
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                {!! Form::number('platinum_discount_percentage', 00, ['class' => 'form-control','required' => '','min'=>'1','max'=>'80']) !!}
                <span class="input-group-text">%</span>
            </div>          
        </div>
        <div class="col-sm-4"> 
            <small class="nomodal" data-toggle="tooltip" title="Percentage Discount value to be Claimed per Reward">
                <i class="fa fa-2x fa-info-circle"></i>
            </small>
        </div>
    </div>


    <div id="fixed_div_data" class="hide" >
        <div class="col-sm-4">
            {!! Form::label('type_value', 'Choose Fixed Value Per Item:') !!}
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                {!! Form::number('type_value', 0, ['class' => 'form-control', 'id'=>'type_value', 'required' => '', 'min'=>1]) !!}
                
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
                {!! Form::number('type_value', 00, ['class' => 'form-control','required' => '','min'=>'1','max'=>'80']) !!}
                <span class="input-group-text">%</span>
            </div>          
        </div>
        <div class="col-sm-4"> 
            <small class="nomodal" data-toggle="tooltip" title="Percentage Discount value to be Claimed per Reward">
                <i class="fa fa-2x fa-info-circle"></i>
            </small>
        </div>
    </div>
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
            var min_punches = document.getElementById("min_punches").value;
            var min_punch_value = document.getElementById("min_punch_value").value;
            var res = parseInt(min_punches) * parseInt(min_punch_value);
            // alert(min_punches);
            // return false;
 
            let type_value = document.getElementById("type_value").value;
            if(parseInt(res) < parseInt(type_value)){
                alert("Fixed value cannot be greater than total order value");
                return false;
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

           
            $("#silver_punchess").change(function()
            {
                var type_id = $("#silver_punchess").val();
                console.log("f");
                if(type_id == 0)
                { 
                    $("#add_option_div_silver").html($("#fixed_div_data_silver").html());
                    $("#add_price_div").removeClass('hide');
                    $("#reward").addClass('hide');
                    $("#menu_item").removeClass('hide');

                    $('#myForm').find('input[name=silver_fixed_value]').change(function()
                    {
                        var type_id = $("#type_id").val();
                        var silver_fixed_value = $('#myForm').find('input[name=silver_fixed_value]').val();
                            
                        if(type_id == 1)
                        {
                            silver_fixed_value = parseFloat(silver_fixed_value).toFixed(3);
                            $('#myForm').find('input[name=silver_fixed_value]').val(silver_fixed_value);
                            
                        }

                      
                        
        
                    });
                }
                else if(type_id == 1)
                {
                    $("#add_option_div_silver").html($("#percentage_div_data_silver").html());
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

            $("#golden_punches").change(function()
            {
                var type_id = $("#golden_punches").val();
                console.log("f");
                if(type_id == 0)
                { 
                    $("#add_option_div_golden").html($("#fixed_div_data_golden").html());
                    $("#add_price_div").removeClass('hide');
                    $("#reward").addClass('hide');
                    $("#menu_item").removeClass('hide');

                    $('#myForm').find('input[name=type_valuee]').change(function()
                    {
                        var type_id = $("#type_id").val();
                        var type_valuee = $('#myForm').find('input[name=type_value]').val();
                            
                        if(type_id == 1)
                        {
                            type_valuee = parseFloat(type_valuee).toFixed(3);
                            $('#myForm').find('input[name=type_value]').val(type_valuee);
                            
                        }

                      
                        
        
                    });
                }
                else if(type_id == 1)
                {
                    $("#add_option_div_golden").html($("#percentage_div_data_golden").html());
                    $("#add_price_div").removeClass('hide');
                    $("#menu_item").removeClass('hide');
                    $("#reward").addClass('hide');
                }
              
                else
                {
                    $("#add_option_div").html('');
                    $("#menu_item").addClass('hide');
                    $("#reward").addClass('hide');

                }

                main_events();

            });
            $("#platinum_punches").change(function()
            {
                var type_id = $("#platinum_punches").val();
                console.log("f");
                if(type_id == 0)
                { 
                    $("#add_option_div_platinum").html($("#fixed_div_data_platinum").html());
                    $("#add_price_div").removeClass('hide');
                    $("#reward").addClass('hide');
                    $("#menu_item").removeClass('hide');

                    $('#myForm').find('input[name=type_valuee]').change(function()
                    {
                        var type_id = $("#type_id").val();
                        var type_valuee = $('#myForm').find('input[name=type_value]').val();
                            
                        if(type_id == 1)
                        {
                            type_valuee = parseFloat(type_valuee).toFixed(3);
                            $('#myForm').find('input[name=type_value]').val(type_valuee);
                            
                        }

                      
                        
        
                    });
                }
                else if(type_id == 1)
                {
                    $("#add_option_div_platinum").html($("#percentage_div_data_platinum").html());
                    $("#add_price_div").removeClass('hide');
                    $("#menu_item").removeClass('hide');
                    $("#reward").addClass('hide');
                }
              
                else
                {
                    $("#add_option_div").html('');
                    $("#menu_item").addClass('hide');
                    $("#reward").addClass('hide');

                }

                main_events();

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