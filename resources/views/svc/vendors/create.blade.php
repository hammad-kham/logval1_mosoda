@extends('layouts.app')

@section('content')

    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">
                    Create New Vendor
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
                            Create New
                        </li>
                    </ol>
                </nav>
                <a href="{{ route('vendors.index') }}" class="btn btn-primary btn-return pull-right">
                    <i class="fa fa-chevron-left mr-2"></i> Return to Listing
                </a>
            </div>
            @include('flash::message')
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">

                    @include('flash::message')
                    @include('coreui-templates::common.errors')

                    {!! Form::open(['route' => 'vendors.store','files' => true]) !!}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="block-title">Create New Vendor</h3>
                        </div>
                        <div class="card-body">

                            <div class="block-content">
                                @include('svc.vendors.fields')
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="block-title">Location</h3>
                        </div>
                        <div class="card-body">
                            <div class="block-content pb-4">
                                @include('svc.vendors.locations')
                            </div>

                            <div class="mt-4 row">
                                <div class="col-sm-12 text-right pb-4">
                                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                                    <a href="{{ route('vendors.index') }}" class="btn btn-outline-dark">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->

@endsection

@push('scripts')
    <style>
        .hide{
            display:none;
        }

        .radioBtn > .notActive{
            color: #3276b1!important;
            background-color: #fff!important;
        }
    </style>
    <script>

        $(document).ready(function(e) {
            $('.radioBtn a').on('click', function(){
                var sel = $(this).data('title');
                var tog = $(this).data('toggle');
                $('#is_'+tog).prop('value', sel);

                $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
                $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');

                var from_div = tog+'_from_div';
                var to_div = tog+'_to_div';

                if(sel == 1)
                {
                    $('.'+from_div).removeClass('hide');
                    $('.'+to_div).removeClass('hide');
                }
                else
                {
                    $('.'+from_div).addClass('hide');
                    $('.'+to_div).addClass('hide');
                }
            });

            if($(".available_from"))
            {
                $(".available_from").each(function(index, element) {
                    var obj = $(this);
                    obj.change(function(e) {
                        check_time_from(index);
                    });
                });
            }

            if($(".available_to"))
            {
                $(".available_to").each(function(index, element) {
                    var obj = $(this);
                    obj.change(function(e) {
                        check_time_to(index);
                    });
                });
            }
        });


        function check_time_from(ind)
        {
            var obj_from;
            var obj_to;
            var from = 0;
            $(".available_from").each(function(index, element) {
                if(ind == index)
                {
                    obj_from = $(this);
                }
            });
            from = parseInt(obj_from.val());
            var to = 0;
            $(".available_to").each(function(index, element) {
                if(ind == index)
                {
                    obj_to = $(this);
                }
            });
            to = parseInt(obj_to.val());

            //alert('start '+from+' -> end '+to);

            if(from >= to && from < 23)
            {
                to = (from+1);
                obj_to.val(to);
            }
            else if(from >= to && from == 23)
            {
                from = (from-1);
                to = (from+1);
                obj_from.val(from);
                obj_to.val(to);
            }
            else if(from == to)
            {
                to = (from+1);
                obj_to.val(to);
            }
        }

        function check_time_to(ind)
        {
            var obj_from;
            var obj_to;
            var from = 0;
            $(".available_from").each(function(index, element) {
                if(ind == index)
                {
                    obj_from = $(this);
                }
            });
            from = parseInt(obj_from.val());
            var to = 0;
            $(".available_to").each(function(index, element) {
                if(ind == index)
                {
                    obj_to = $(this);
                }
            });
            to = parseInt(obj_to.val());

            //alert('start '+from+' -> end '+to);

            if(from >= to && to==0)
            {
                from = 0;
                to = 1;
                obj_from.val(from);
                obj_to.val(to);
            }
            else if(from >= to && to > 0 && to < 23)
            {
                from = (to-1);
                obj_from.val(from);
            }
            else if(from == to && to == 23)
            {
                from = (to-1);
                obj_from.val(from);
            }
            else if(from == to)
            {
                to = (to+1);
                obj_to.val(to);
            }
        }
    </script>

    @include('common.map_js')

@endpush
