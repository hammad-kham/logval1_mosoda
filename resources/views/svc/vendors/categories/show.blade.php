
@extends('layouts.app')

@section('content')

    <section class="section">
        {{-- Header Start --}}
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Vendor Category</h1>
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
                                <a href="{{ route('vendor-categories.index') }}">Vendor Categories</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                View Details
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('vendor-categories.index') }}">
                        <i class="fa fa-chevron-left mr-2"></i> Return to Listing
                    </a>
                </div>
            </div>
        </div>
        <!-- Header End -->

        <!-- Page Content -->

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">

                    @include('flash::message')
                    @include('coreui-templates::common.errors')

                    <div class="card">
                        <div class="card-header">
                            <h4>Vendor Category</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="row col-sm-6">
                                    <div class="col-sm-4">
                                        {!! Form::label('name', 'Vendor Name:') !!}
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{ $vend_name }}</p>
                                    </div>
                                </div>
                                <div class="row col-sm-6">
                                    <div class="col-sm-4">
                                        {!! Form::label('name', 'Category Name:') !!}
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{ $cat_name }}</p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php
        if($records_exists)
        {
        ?>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">

                    @include('flash::message')
                    @include('coreui-templates::common.errors')

                    <div class="card">
                        <div class="card-header">
                            <h4>Vendor Category's Attributes</h4>
                        </div>
                        <div class="card-body">
                            <div class="block-content">
                                <div class="row">
                                    <?php
                                    for($i=0; $i<$attributes_count; $i++){
                                    ?>
                                    <div class="row col-sm-6">
                                        <div class="col-sm-4">
                                            {!! Form::label('name', $options_array[$i]['name'].':') !!}
                                        </div>
                                        <div class="col-sm-8">
                                            <p>{{ $prices_array[$i] }}</p>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                
                                @if(Auth::user()->can('vendor-categories-edit') || Auth::user()->can('all'))
                                    <div class="form-group row">
                                        <div class="col-12 text-right">
                                            <a href="{{ route('vendor-categories.edit', $Model_Data->id) }}" class='btn btn-primary'>
                                                Edit
                                            </a>
                                            <a href="{{ route('vendor-categories.index') }}" class="btn btn-secondary">Back</a>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <!-- END Page Content -->

    </section>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        jQuery(document).ready(function (e) {

            $('#myselect').select2({
                width: '100%',
                placeholder: "Select a Category",
                allowClear: true
            });

            jQuery('#vend_id').on('change', function(event)
            {

                jQuery('#cat_id').html('');
                var cat_id = jQuery('#cat_id');
                console.log(this.value);
                jQuery.get( '{{URL::to("/")}}/service/vendors/' + this.value + '/categoriesss.json', function(categories)
                {

                    cat_id.find('option').remove().end();
                    cat_id.append('<option value="">Select Sub Categories</option>');

                    if (categories.length > 0)
                    {

                        $('#categories').show();
                        jQuery.each(categories, function(index, categories)
                        {
                            cat_id.append('<option value="' + categories.id + '">' + categories.title + '</option>');
                        });
                    }
                });
            });


            jQuery('#cat_id').on('change', function(event)
            {

                jQuery('#sub_cat_id').html('');
                var sub_cat_id = jQuery('#sub_cat_id');
                console.log(this.value);
                jQuery.get( '{{URL::to("/")}}/service/vendors/' + this.value + '/sub-categoriesss.json', function(sub_categories)
                {

                    sub_cat_id.find('option').remove().end();
                    sub_cat_id.append('<option value="">Select Sub Categories</option>');

                    if (sub_categories.length > 0)
                    {

                        $('#sub_categories').show();
                        jQuery.each(sub_categories, function(index, sub_categories)
                        {
                            sub_cat_id.append('<option value="' + sub_categories.id + '">' + sub_categories.title + '</option>');
                        });
                    }
                });
            });

        });

    </script>
@endpush


