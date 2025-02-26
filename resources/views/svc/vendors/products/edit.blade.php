@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Edit Product</h1> 
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
                            <a href="{{ route('products.index') }}">Products</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Details
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('products.index') }}">
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
                        <h4>Edit Products </h4>
                    </div>
                    <div class="card-body">
                        {!! Form::model($Model_Data, ['route' => ['products.update', $Model_Data->id], 'method' => 'patch','files' => true]) !!}
                        
                        @include('svc.vendors.products.fields')

                        {!! Form::close() !!}
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</section>
<!-- END Page Content -->
@endsection
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    jQuery(document).ready(function (e) {

        $('#myselect').val([{{$select_occasions}}]);

        $('#myselect').select2({
            width: '100%',
            placeholder: "Select Ocassion Type",
            allowClear: true
        });


        
        jQuery('#vend_id').on('change', function(event)
        {
            jQuery('#cat_id').html('');
            var cat_id = jQuery('#cat_id');
            console.log(this.value);
            jQuery.get( '{{URL::to("/")}}/vendors/' + this.value + '/categories.json', function(categories)
            {	
                cat_id.find('option').remove().end();
                cat_id.append('<option value="">Select Categories</option>');
                
                if (vend_id.length > 0)
                {
                    jQuery.each(categories, function(index, category)
                    {
                        cat_id.append('<option value="' + category.id + '">' + category.title + '</option>');
                    });
                }
            });
        });


        jQuery('#cat_id').on('change', function(event)
        {
            jQuery('#sub_cat_id').html('');
            var sub_cat_id = jQuery('#sub_cat_id');
            console.log(this.value);
            jQuery.get( '{{URL::to("/")}}/vendors/' + this.value + '/sub-categories.json', function(sub_categories)
            {	
                sub_cat_id.find('option').remove().end();
                sub_cat_id.append('<option value="">Select Sub Categories</option>');
                
                if (sub_categories.length > 0)
                {
                    jQuery.each(sub_categories, function(index, sub_category)
                    {
                        sub_cat_id.append('<option value="' + sub_category.id + '">' + sub_category.title + '</option>');
                    });
                }
            });
        });

        jQuery('#sub_cat_id').on('change', function(event)
        {
            jQuery('#ser_id').html('');
            var ser_id = jQuery('#ser_id');
            console.log(this.value);
            jQuery.get( '{{URL::to("/")}}/vendors/' + this.value + '/services.json', function(services)
            {	
                ser_id.find('option').remove().end();
                ser_id.append('<option value="">Select Services</option>');
                
                if (services.length > 0)
                {
                    jQuery.each(services, function(index, services)
                    {
                        ser_id.append('<option value="' + services.id + '">' + services.title + '</option>');
                    });
                }
            });
        });


        jQuery('#ser_id').on('change', function(event)
        {
            jQuery('#sub_ser_id').html('');
            var sub_ser_id = jQuery('#sub_ser_id');
            console.log(this.value);
            jQuery.get( '{{URL::to("/")}}/vendors/' + this.value + '/sub-services.json', function(sub_services)
            {	
                sub_ser_id.find('option').remove().end();
                sub_ser_id.append('<option value="">Select Sub Services</option>');
                
                if (sub_services.length > 0)
                {
                    jQuery.each(sub_services, function(index, sub_services)
                    {
                        sub_ser_id.append('<option value="' + sub_services.id + '">' + sub_services.title + '</option>');
                    });
                }
            });
        });


    });
</script>
@endpush