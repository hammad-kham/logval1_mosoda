@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Create New Sub Service</h1>
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
                                <a href="{{ route('sub-services.index') }}">Sub Services</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create New
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right" href="{{ route('sub-services.index') }}">
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
                            <h4>Create New Sub Service</h4>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'sub-services.store','files' => true]) !!}

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    {!! Form::label('cat_id', 'Category:') !!}
                                    {!! Form::select('cat_id', $categories_array, null, ['id' => 'cat_id','placeholder' => 'select','class' => 'form-control']) !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::label('sub_cat_id', 'SubCategory:') !!}
                                    {!! Form::select('sub_cat_id', $sub_categories_array, null, ['id' => 'sub_cat_id','placeholder' => 'select','class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    {!! Form::label('service_id', 'Service:') !!}
                                    {!! Form::select('service_id', $services_array, null, ['id' => 'service_id','placeholder' => 'select','class' => 'form-control']) !!}
                                </div>
                                <div class="col-sm-6">
                                    {{--        {!! Form::label('sub_cat_id', 'SubCategory:') !!}--}}
                                    {{--        {!! Form::select('sub_cat_id', $sub_categories_array, null, ['placeholder' => 'select','class' => 'form-control']) !!}--}}
                                </div>
                            </div>

                            @include('svc.sub-services.fields')

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
                placeholder: "Select a Category",
                allowClear: true
            });


            jQuery('#cat_id').on('change', function(event)
            {
                jQuery('#sub_cat_id').html('');
                var sub_cat_id = jQuery('#sub_cat_id');
                console.log(this.value);
                jQuery.get( '{{URL::to("/")}}/service/sub-services/' + this.value + '/sub-categories.json', function(sub_categories)
                {
                    sub_cat_id.find('option').remove().end();
                    sub_cat_id.append('<option value="">Select Sub Categories</option>');

                    if (sub_categories.length > 0)
                    {
                        // $('#sub_categories').show();
                        jQuery.each(sub_categories, function(index, sub_category)
                        {
                            sub_cat_id.append('<option value="' + sub_category.id + '">' + sub_category.title + '</option>');
                        });
                    }
                });
            });

            jQuery('#sub_cat_id').on('change', function(event)
            {
                jQuery('#service_id').html('');
                var service_id = jQuery('#service_id');
                console.log(this.value);
                jQuery.get( '{{URL::to("/")}}/service/sub-services/' + this.value + '/services.json', function(services)
                {
                    service_id.find('option').remove().end();
                    service_id.append('<option value="">Select Services</option>');

                    if (services.length > 0)
                    {
                        jQuery.each(services, function(index, services)
                        {
                            service_id.append('<option value="' + services.id + '">' + services.title + '</option>');
                        });
                    }
                });
            });


        });
    </script>
@endpush
