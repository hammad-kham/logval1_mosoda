@extends('layouts.app')

@section('content')
    
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">
                    Edit Vendor Details:  {{ $Model_Data->name }}
                </h1>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <nav class="flex-sm-00-auto" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('vendors.index') }}">Vendors</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Details
                        </li>
                    </ol>
                </nav>
                <a  href="{{ route('vendors.index') }}" class="btn btn-primary btn-return pull-right">
                    <i class="fa fa-chevron-left mr-2"></i> Return to Listing
                </a>
            </div>
            @include('flash::message')
        </div>
    </div>
    <!-- END Hero -->
    
    <!-- Page Content -->
    <div class="content">
        
        @include('flash::message')
        @include('coreui-templates::common.errors')
        
        {!! Form::model($Model_Data, ['route' => ['vendors.update', $Model_Data->id], 'method' => 'patch','files'=>true]) !!}
        <div class="block block-rounded block-themed">
            <div class="card">
                <div class="card-header">
                    <h4 class="block-title">Basic Details</h4>
                </div>
                <div class="card-body">
                    <div class="block-content">
                        
                        @include('svc.vendors.fields')
                        
                        <div class="mt-4 row pb-4">
                            <div class="col-sm-12 text-right">
                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                <a href="{{ route('vendors.index') }}" class="btn btn-outline-dark">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="block block-rounded block-themed">
            <div class="card">
                <div class="card-header">
                    <h4 class="block-title">Location Details</h4>
                </div>
                <div class="card-body">
                    <div class="block-content">
                        
                        @include('svc.vendors.locations')
                        
                        <div class="col-sm-12 text-right">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <a href="{{ route('vendors.index') }}" class="btn btn-outline-dark">Cancel</a>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        
        <div class="block block-rounded block-themed">
            <div class="card">
                <div class="card-header">
                    <h4 class="block-title">Availabilities</h4>
                </div>
                <div class="card-body">
                    <div class="block-content">
                        <?php
                        if(isset($WorkingHours) && !empty($WorkingHours))
                        {
                        ?>
                        {!! Form::open(['route' => ['vendors.timings.update'], 'method' => 'post']) !!}
                        
                        @include('svc.vendors.edit_working_hours')
                        
                        <div class="mt-4 row pb-4">
                            <div class="col-sm-12 text-right">
                                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                <input type="hidden" name="vendor_id" value="<?php echo $Model_Data->id;?>" />
                                <a href="{{ route('vendors.index') }}" class="btn btn-outline-dark">Cancel</a>
                            </div>
                        </div>
                        
                        {!! Form::close() !!}
                        <?php
                        }
                        else
                        {
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <p> No Record Found! </p>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    
    
    <!-- all modals starts here -->
    
    <div class="col-sm-6 clone" style="display: none;">
        {!! Form::hidden('cat_id[]', null, ['class' => 'form-control cat_id' ]) !!}
    </div>
    <div class="col-sm-6 menu-clone" style="display: none;">
        {!! Form::hidden('menu_id[]', null, ['class' => 'form-control menu_id' ]) !!}
    </div>
    
    <!-- END All Modals -->
    
    <!-- END Page Content -->
@endsection


@push('scripts')
    <style>
        .hide{
            display:none;
        }
        
        .radioBtn > .active{
            color: #3276b1!important;
            background-color: #69e7b8!important;
        }
        .radioBtn > .notActive{
            color: #3276b1!important;
            background-color: #febddd!important;
        }
        
        .radioBtn2 > .active{
            color: #3276b1!important;
            background-color: #69e7b8!important;
        }
        .radioBtn2 > .notActive{
            color: #3276b1!important;
            background-color: #febddd!important;
            opacity:0.3;
        }
    </style>
    <script>
        
        $(document).ready(function(e) {
            $('.radioBtn a').on('click', function(){
                var sel = $(this).data('title');
                var tog = $(this).data('toggle');
                if(sel == 1)
                {
                    $('a[data-toggle="'+tog+'"][data-title="1"]').removeClass('hide').addClass('hide');
                    $('a[data-toggle="'+tog+'"][data-title="0"]').removeClass('hide');
                }
                else
                {
                    $('a[data-toggle="'+tog+'"][data-title="0"]').removeClass('hide').addClass('hide');
                    $('a[data-toggle="'+tog+'"][data-title="1"]').removeClass('hide');
                }
                $('#'+tog).prop('value', sel);
            });
            
            
            $('.radioBtn2 a').on('click', function(){
                var sel = $(this).data('title');
                var tog = $(this).data('toggle');
                
                $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
                
                $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
                
                var field;
                field = 'monday_'+tog;
                update_time_slots(field, sel);
                
                field = 'tuesday_'+tog;
                update_time_slots(field, sel);
                
                field = 'wednesday_'+tog;
                update_time_slots(field, sel);
                
                field = 'thursday_'+tog;
                update_time_slots(field, sel);
                
                field = 'friday_'+tog;
                update_time_slots(field, sel);
                
                field = 'saturday_'+tog;
                update_time_slots(field, sel);
                
                field = 'sunday_'+tog;
                update_time_slots(field, sel);
            });
            
            if(jQuery('.btn_close_modal'))
            {
                jQuery('.btn_close_modal').click(function(e) {
                    
                    $('#socialMediaModal').modal('hide');
                });
                
                jQuery('.btn_close_modal').click(function(e) {
                    
                    $('#workingHoursModal').modal('hide');
                });
                jQuery('.btn_close_modal').click(function(e) {
                    
                    $('#bankDetailsModal').modal('hide');
                });
            }
            
            
            $(".cat_title").change(function()
            {
                
                var selected_val = $(this).find(":selected").val();
                
                var cat_id=  '';
                //$('.cat_id').html();
                var slected_catgories=  $('.slected_catgories').html();
                
                
                if(selected_val!=''){
                    if(slected_catgories!=''){
                        slected_catgories=slected_catgories+' , '+$(this).find(":selected").html();
                        cat_id=selected_val;
                        var text_val = $('.clone').children('.cat_id').val(cat_id);
                        var html = $(".clone").html();
                        
                        $(".variation_div").append(html);
                        
                    }else{
                        cat_id=selected_val;
                        $('.cat_id').val(cat_id);
                        slected_catgories=$(this).find(":selected").html();
                    }
                    
                    // $('.cat_id').html(cat_id);
                    $('.slected_catgories').html(slected_catgories);
                    
                    
                }
                
            });
            
            
            $(".menu_title").change(function()
            {
                
                var selected_val = $(this).find(":selected").val();
                
                
                //$('.cat_id').html();
                var slected_menus=  $('.slected_menus').html();
                
                if(selected_val!=''){
                    
                    if(slected_menus!=''){
                        slected_menus=slected_menus+' , '+$(this).find(":selected").html();
                        var text_val = $('.menu-clone').children('.menu_id').val(selected_val);
                        var html = $(".menu-clone").html();
                        
                        $(".menu_variation_div").append(html);
                        
                    }else{
                        menu_id=selected_val;
                        $('.menu_id').val(menu_id);
                        slected_menus=$(this).find(":selected").html();
                    }
                    
                    // $('.cat_id').html(cat_id);
                    $('.slected_menus').html(slected_menus);
                    
                    
                }
                
            });
        });
        
        function update_time_slots(tog, sel)
        {
            if(sel == 1)
            {
                $('a[data-toggle="'+tog+'"][data-title="1"]').removeClass('hide').addClass('hide');
                $('a[data-toggle="'+tog+'"][data-title="0"]').removeClass('hide');
                $('#'+tog).prop('value', sel);
            }
            else
            {
                $('a[data-toggle="'+tog+'"][data-title="0"]').removeClass('hide').addClass('hide');
                $('a[data-toggle="'+tog+'"][data-title="1"]').removeClass('hide');
                $('#'+tog).prop('value', sel);
            }
        }
    </script>

    @include('common.map_js')

@endpush