@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="section-header-breadcrumb-content">
                    <h1>Create New Product</h1> 
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
                            <a href="{{ route('products.index') }}">Product</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Create New
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
                        <h4>Create New Product</h4>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['route' => 'products.store','files' => true]) !!}

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

        $('#myselect').select2({
            width: '100%',
            placeholder: "Select Ocassion Type",
            allowClear: true
        });

        jQuery('#vendor_id').on('change', function(event)
        {
            
            jQuery('#category_id').html('');
            var category_id = jQuery('#category_id');
            console.log(this.value);
            jQuery.get( '{{URL::to("/")}}/service/vendors/' + this.value + '/product-categories.json', function(categories)
            {
         
                category_id.find('option').remove().end();
                category_id.append('<option value="">Select Sub Categories</option>');
                
                if (categories.length > 0)
                {
                   
                    $('#categories').show();
                    jQuery.each(categories, function(index, categories)
                    {
                        category_id.append('<option value="' + categories.id + '">' + categories.title + '</option>');
                    });
                }
            });
        });



        jQuery('#category_id').on('change', function(event)
        {
            
            jQuery('#sub_category_id').html('');
            var sub_category_id = jQuery('#sub_category_id');
            console.log(this.value);
            jQuery.get( '{{URL::to("/")}}/service/vendors/' + this.value + '/product-sub-categories.json', function(sub_categories)
            {
         
                sub_category_id.find('option').remove().end();
                sub_category_id.append('<option value="">Select Sub Categories</option>');
                
                if (sub_categories.length > 0)
                {
                   
                    $('#sub_categories').show();
                    jQuery.each(sub_categories, function(index, sub_categories)
                    {
                        sub_category_id.append('<option value="' + sub_categories.id + '">' + sub_categories.title + '</option>');
                    });
                }
            });
        });        

    });
</script>
@endpush