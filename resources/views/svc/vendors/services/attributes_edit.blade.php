
@extends('layouts.app')

@section('content')

    <section class="section">
        {{-- Header Start --}}
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>
                            <?php
                            if($sub_service_id == 0){
                                echo "Edit Vendor Service's Attributes";
                            }
                            else{
                                echo "Edit Vendor Sub Service's Attributes";
                            }
                            ?>
                        </h1>
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
                                <a href="{{ route('vendor-services.index') }}">Vendor Services</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Attributes
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('vendor-services.index') }}">
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
                            <h4>
                                <?php
                                if($sub_service_id == 0){
                                    echo "Edit Vendor Service's Attributes";
                                }
                                else{
                                    echo "Edit Vendor Sub Service's Attributes";
                                }
                                ?>
                            </h4>
                        </div>
                        <?php
                        if($attributes_count > 0){
                        ?>
                        <div class="card-body">
                            <div class="block-content">
                                {!! Form::model( $values_array,['route' => ['vendor_services_attributes_update'], 'method' => 'post']) !!}

                                @include('svc.vendors/services.attributes_edit_fields')

                                {!! Form::close() !!}


                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
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


