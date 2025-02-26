@extends('layouts.app')

@section('content')
    <section class="section">
        {{-- Header Start --}}
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Create New Vendor Sub Categories</h1>
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
                                <a href="{{ route('vendor-sub-categories.index') }}">Vendor Sub Categories</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create New
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 float-right">
                    <a class="btn btn-icon icon-left btn-primary pull-right"
                        href="{{ route('vendor-sub-categories.index') }}">
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
                            <h4>Create New Vendor Sub Categories</h4>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'vendor-sub-categories.store', 'files' => true]) !!}

                            <div class="card-body">

                                @include('svc.vendors.sub_categories.fields')

                            </div>

                            <div class="attributes_div" id="attributes_div" style="display: none">
                                <div class="card-header">
                                    <h4>Sub Category attributes </h4>
                                </div>
                                <div class="card-body inner_attributes_div" id="inner_attributes_div">

                                </div>
                            </div>

                            <div class="mt-4 mb-3 row">
                                <div class="col-sm-12 text-right">
                                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                    <a href="{{ route('vendor-categories.index') }}" class='btn btn-outline-dark'>
                                        Cancel
                                    </a>
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
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
        jQuery(document).ready(function(e) {

            $('#myselect').select2({
                width: '100%',
                placeholder: "Select a Category",
                allowClear: true
            });

            jQuery('#vend_id').on('change', function(event) {

                jQuery('#cat_id').html('');
                var cat_id = jQuery('#cat_id');
                console.log(this.value);
                jQuery.get('{{ URL::to('/') }}/vendors/' + this.value + '/categoriesss.json',
                    function(categories) {
                    
                        cat_id.find('option').remove().end();
                        cat_id.append('<option value="">Select Sub Categories</option>');

                        if (categories.length > 0) {

                            $('#categories').show();
                            jQuery.each(categories, function(index, categories) {
                                cat_id.append('<option value="' + categories.id + '">' +
                                    categories.title + '</option>');
                            });
                        }
                    });
            });


            jQuery('#cat_id').on('change', function(event) {

                jQuery('#sub_cat_id').html('');
                var sub_cat_id = jQuery('#sub_cat_id');
                console.log(this.value);
          
                jQuery.get('{{ URL::to('/') }}/vendors/' + this.value + '/sub-categoriesss.json',
                    function(sub_categories) {

                        sub_cat_id.find('option').remove().end();
                        sub_cat_id.append('<option value="">Select Sub Categories</option>');

                        if (sub_categories.length > 0) {

                            $('#sub_categories').show();
                            jQuery.each(sub_categories, function(index, sub_categories) {
                                sub_cat_id.append('<option value="' + sub_categories.id + '">' +
                                    sub_categories.title + '</option>');
                            });
                        }
                    });
            });

            jQuery('#sub_cat_id').on('change', function(event) {
                jQuery('#inner_attributes_div').html('');
                var sub_cat_id = jQuery('#sub_cat_id');
                var div = jQuery('#inner_attributes_div');
                console.log(this.value);
                jQuery.get('{{ URL::to('/') }}/vendors/sub_category_attributes/' + this.value +
                    '/sub_category_attributes.json',
                    function(attributes) {
                        if (attributes.length > 0) {
                            $('#attributes_div').show();
                            jQuery.each(attributes, function(index, attributes) {
                                if (attributes.num_field == 1) {
                                    var field = "number";
                                } else if (attributes.text_field == 1) {
                                    var field = "text";
                                }

                                var slug = createSlug(attributes.name);

                                div.append(
                                    '<div class="form-group row" > <div class="col-sm-3"></<label for="">' +
                                    attributes.name +
                                    '</label> </div> <div class="col-sm-9"><input type="' +
                                    field + '" name="' + slug +
                                    '" class="form-control" required="required"></div> </div>'
                                    );

                            });
                        } else {
                            $('#attributes_div').hide();
                        }
                    });
            });
        });

        function createSlug(slug) {
            var $slug = '';
            var trimmed = $.trim(slug);
            slug = trimmed.replace(/[^a-z0-9-]/gi, '_').replace(/-+/g, '_').replace(/^-|-$/g, '');
            slug = slug.toLowerCase();
            return slug;
        }
    </script>
@endpush
