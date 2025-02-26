@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="section-header-breadcrumb-content">
                        <h1>Create New Categories</h1>
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
                                Create New
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

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">

                    @include('flash::message')
                    @include('coreui-templates::common.errors')

                    <div class="card">
                        <div class="card-header">
                            <h4>Create New Vendor Categories </h4>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'vendor-categories.store','files' => true]) !!}
                            <div class="card-body">

                                @include('svc.vendors.categories.fields')

                            </div>

                            <div class="attributes_div" id="attributes_div" style="display: none">
                                <div class="card-header">
                                    <h4>Category attributes </h4>
                                </div>
                                <div class="card-body inner_attributes_div" id="inner_attributes_div">

                                </div>
                            </div>

                            <div class="mt-4 mb-3 row">
                                <div class="col-sm-12 text-right">
                                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                    <a href="{{route('vendor-categories.index')}}" class='btn btn-outline-dark' >
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

    </section>
    <!-- END Page Content -->
@endsection
@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        jQuery(document).ready(function (e) {

            jQuery('#cat_id').on('change', function(event)
            {
                jQuery('#inner_attributes_div').html('');
                var cat_id = jQuery('#cat_id');
                var div = jQuery('#inner_attributes_div');
                console.log(this.value);
                jQuery.get( '{{URL::to("/")}}/service/vendors/category_attributes/' + this.value + '/category_attributes.json', function(attributes)
                {
                    if (attributes.length > 0)
                    {
                        $('#attributes_div').show();
                        jQuery.each(attributes, function(index, attributes)
                        {
                            if(attributes.num_field == 1){
                                var field = "number";
                            }
                            else if(attributes.text_field == 1){
                                var field = "text";
                            }

                            var slug = createSlug(attributes.name);

                            div.append('<div class="form-group row" > <div class="col-sm-3"></<label for="">' + attributes.name + '</label> </div> <div class="col-sm-9"><input type="' + field + '" name="' + slug + '" class="form-control" required="required"></div> </div>');

                        });
                    }
                    else{
                        $('#attributes_div').hide();
                    }
                });
            });
        });

        function createSlug(slug){
            var $slug = '';
            var trimmed = $.trim(slug);
            slug = trimmed.replace(/[^a-z0-9-]/gi, '_').replace(/-+/g, '_').replace(/^-|-$/g, '');
            slug = slug.toLowerCase();
            return slug;
        }

    </script>
@endpush